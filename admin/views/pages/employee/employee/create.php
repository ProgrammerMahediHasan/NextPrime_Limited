<?php
$depts = Department::getall();
$designations = Designation::getall();

// Check if we are editing
$isEdit = isset($data) && !empty($data->id);
$actionUrl = $isEdit ? "{$base_url}/employee/update" : "{$base_url}/employee/save";
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

/* Responsive */
@media(max-width:768px){
    .form-table td{
        display:block;
        width:100%;
    }
}

/* Photo preview */
.photo-preview{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
    margin-top:5px;
}
</style>

<div class="card">

    <div class="card-header">
        <?= $isEdit ? "Edit Employee" : "Employee Registration Form" ?>
    </div>

    <!-- Add enctype for file upload -->
    <form action="<?=$actionUrl?>" method="post" enctype="multipart/form-data">

        <?php if($isEdit): ?>
            <input type="hidden" name="id" value="<?= $data->id ?>">
            <input type="hidden" name="existing_photo" value="<?= $data->photo ?>">
        <?php endif; ?>

        <table class="form-table">

            <tr>
                <td><label>Full Name</label></td>
                <td><input type="text" name="name" required value="<?= $isEdit ? $data->name : '' ?>"></td>

                <td><label>Email</label></td>
                <td><input type="email" name="email" required value="<?= $isEdit ? $data->email : '' ?>"></td>
            </tr>

            <tr>
                <td><label>Phone</label></td>
                <td><input type="text" name="phone" required value="<?= $isEdit ? $data->phone : '' ?>"></td>

                <td><label>Gender</label></td>
                <td>
                    <select name="gender" required>
                        <option value="">Select</option>
                        <option <?= $isEdit && $data->gender=="Male" ? "selected" : "" ?>>Male</option>
                        <option <?= $isEdit && $data->gender=="Female" ? "selected" : "" ?>>Female</option>
                        <option <?= $isEdit && $data->gender=="Other" ? "selected" : "" ?>>Other</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label>Department</label></td>
                <td>
                    <select name="dept_id" id="dept_id" required>
                        <option value="">Select Department</option>
                        <?php foreach($depts as $dept){ ?>
                            <option value="<?=$dept->id?>" <?= $isEdit && $data->dept_id==$dept->id ? "selected" : "" ?>><?=$dept->name?></option>
                        <?php } ?>
                    </select>
                </td>

                <td><label>Designation</label></td>
                <td>
                    <select name="desig_id" id="desig_id" required>
                        <option value="">Select Designation</option>
                        <?php
                        if($isEdit && $data->dept_id){
                            $desigsByDept = Designation::getByDeptId($data->dept_id);
                            foreach($desigsByDept as $desig){
                                $selected = ($data->desig_id == $desig->id) ? "selected" : "";
                                echo "<option value='{$desig->id}' $selected>{$desig->name}</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label>Joining Date</label></td>
                <td><input type="date" name="joining_date" required value="<?= $isEdit ? $data->joining_date : '' ?>"></td>

                <td><label>Status</label></td>
                <td>
                    <select name="status">
                        <option value="Active" <?= $isEdit && $data->status=="Active" ? "selected" : "" ?>>Active</option>
                        <option value="Inactive" <?= $isEdit && $data->status=="Inactive" ? "selected" : "" ?>>Inactive</option>
                    </select>
                </td>
            </tr>

            <!-- Photo Upload -->
            <tr>
                <td><label>Photo</label></td>
                <td colspan="3">
                    <input type="file" name="photo" accept="image/*" onchange="previewPhoto(event)">
                    <?php if($isEdit && $data->photo && file_exists("uploads/".$data->photo)): ?>
                        <br>
                        <img src="<?=$base_url?>/uploads/<?=$data->photo?>" class="photo-preview" id="existingPhoto">
                    <?php endif; ?>
                    <img id="photoPreview" class="photo-preview" style="display:none;">
                </td>
            </tr>

        </table>

        <div class="btn-wrap">
            <button type="submit" name="<?= $isEdit ? 'update' : 'btn_save' ?>" class="btn btn-primary">
                <?= $isEdit ? "Update Employee" : "Save Employee" ?>
            </button>
            <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$("#dept_id").change(function(){
    let dept_id = $(this).val();
    $("#desig_id").html('<option value="">Loading...</option>');

    if(dept_id){
        $.get("<?=$base_url?>/api/designation/find_by_dep_id", {id: dept_id}, function(res){
            let desigs = JSON.parse(res);
            let options = '<option value="">Select Designation</option>';
            desigs.forEach(d => {
                options += `<option value="${d.id}">${d.name}</option>`;
            });
            $("#desig_id").html(options);
        });
    }
});

// Photo Preview
function previewPhoto(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('photoPreview');
        output.src = reader.result;
        output.style.display = 'block';
        // Hide existing photo if any
        var existing = document.getElementById('existingPhoto');
        if(existing) existing.style.display = 'none';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
