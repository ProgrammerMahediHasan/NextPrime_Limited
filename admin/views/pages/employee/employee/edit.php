<?php
$employee = Employee::find($id);
$depts = Department::getall();
$designations = Designation::getall();
?>

<style>
body{
    font-family: 'Segoe UI', sans-serif;
    background:#f1f5f9;
    padding:40px;
}

/* Card */
.card{
    max-width:1000px;
    margin:auto;
    background:#fff;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    overflow:hidden;
}

/* Header */
.card-header{
    background:#2563eb;
    color:#fff;
    padding:18px;
    font-size:20px;
    font-weight:600;
    text-align:center;
}

/* Table */
.form-table{
    width:100%;
    border-collapse:collapse;
}

.form-table td{
    padding:14px 18px;
    border:1px solid #e5e7eb;
}

.form-table label{
    font-weight:600;
    font-size:14px;
    color:#374151;
}

/* Inputs */
.form-table input,
.form-table select{
    width:100%;
    padding:10px 12px;
    border-radius:6px;
    border:1px solid #d1d5db;
    background:#f9fafb;
    font-size:14px;
}

.form-table input:focus,
.form-table select:focus{
    border-color:#2563eb;
    outline:none;
    background:#fff;
}

/* Buttons */
.btn{
    padding:10px 22px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}

.btn-primary{
    background:#2563eb;
    color:#fff;
}

.btn-secondary{
    background:#6b7280;
    color:#fff;
}

.btn:hover{
    opacity:.9;
}

.btn-wrap{
    text-align:right;
    padding:15px;
}

/* Photo preview */
.photo-preview{
    width:60px;
    height:60px;
    border-radius:50%;
    object-fit:cover;
    border:1px solid #d1d5db;
}

/* Responsive */
@media(max-width:768px){
    .form-table td{
        display:block;
        width:100%;
    }
}
</style>

<div class="card">

    <div class="card-header">
        Edit Employee
    </div>

    <form action="<?=$base_url?>/employee/update" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $employee->id ?>">

        <table class="form-table">

            <tr>
                <td><label>Full Name</label></td>
                <td><input type="text" name="name" value="<?= $employee->name ?>" required></td>

                <td><label>Email</label></td>
                <td><input type="email" name="email" value="<?= $employee->email ?>" required></td>
            </tr>

            <tr>
                <td><label>Phone</label></td>
                <td><input type="text" name="phone" value="<?= $employee->phone ?>" required></td>

                <td><label>Gender</label></td>
                <td>
                    <select name="gender" required>
                        <option value="">Select</option>
                        <?php 
                        $genders = ["Male","Female","Other"];
                        foreach($genders as $g){
                            $selected = ($employee->gender == $g) ? "selected" : "";
                            echo "<option value='$g' $selected>$g</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label>Department</label></td>
                <td>
                    <select name="dept_id" id="dept_id" required>
                        <option value="">Select Department</option>
                        <?php foreach($depts as $dept){
                            $selected = ($dept->id == $employee->dept_id) ? "selected" : "";
                            echo "<option value='{$dept->id}' $selected>{$dept->name}</option>";
                        } ?>
                    </select>
                </td>

                <td><label>Designation</label></td>
                <td>
                    <select name="desig_id" id="desig_id" required>
                        <option value="">Select Designation</option>
                        <?php foreach($designations as $desig){
                            $selected = ($desig->id == $employee->desig_id) ? "selected" : "";
                            echo "<option value='{$desig->id}' $selected>{$desig->name}</option>";
                        } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label>Joining Date</label></td>
                <td><input type="date" name="joining_date" value="<?= $employee->joining_date ?>" required></td>

                <td><label>Status</label></td>
                <td>
                    <select name="status" required>
                        <option value="Active" <?= ($employee->status=='Active')?'selected':'' ?>>Active</option>
                        <option value="Inactive" <?= ($employee->status=='Inactive')?'selected':'' ?>>Inactive</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label>Photo</label></td>
                <td>
                    <input type="file" name="photo" accept="image/*">
                    <?php if($employee->photo && file_exists("uploads/".$employee->photo)){ ?>
                        <img src="<?=$base_url?>/uploads/<?=$employee->photo?>" class="photo-preview" />
                    <?php } ?>
                </td>
                <td colspan="2"></td>
            </tr>

        </table>

        <div class="btn-wrap">
            <button type="submit" name="update" class="btn btn-primary">Update Employee</button>
            <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$("#dept_id").change(function(){
    let dept_id = $(this).val();
    let $desig_id = $("#desig_id");
    $desig_id.html('<option value="">Loading...</option>');
    if(dept_id){
        $.get("<?=$base_url?>/api/designation/find_by_dep_id", {id: dept_id}, function(res){
            let desigs = JSON.parse(res);
            let options = '<option value="">Select Designation</option>';
            desigs.forEach(d => options += `<option value="${d.id}">${d.name}</option>`);
            $desig_id.html(options);
        });
    }
});
</script>
