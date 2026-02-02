<?php
$depts = Department::getall();

echo Page::title(["title"=>"Add Designation"]);
echo Page::body_open();
echo Page::context_open();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

body{
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#eef2ff,#e0e7ff);
}

/* Card */
.form-card{
    max-width:700px;
    margin:40px auto;
    background:#fff;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    overflow:hidden;
}

/* Header */
.form-header{
    background:linear-gradient(135deg,#142f69,#1d4ed8);
    color:#fff;
    padding:18px;
    text-align:center;
    font-size:20px;
    font-weight:600;
}

/* Body */
.form-body{
    padding:25px 30px;
}

/* spacing fix */
.form-body .form-group{
    margin-bottom:16px;
}

/* input design */
.form-body input,
.form-body textarea,
.form-body select{
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #d1d5db;
    transition:.3s;
}

.form-body input:focus,
.form-body textarea:focus,
.form-body select:focus{
    border-color:#2563eb;
    box-shadow:0 0 6px rgba(37,99,235,.25);
}

/* buttons */
.btn-row{
    margin-top:18px;
    display:flex;
    gap:10px;
}

.btn-save{
    background:#2563eb;
    color:#fff;
    padding:10px 22px;
    border-radius:8px;
    border:none;
    font-weight:600;
}

.btn-back{
    background:#6b7280;
    color:#fff;
    padding:10px 22px;
    border-radius:8px;
    text-decoration:none;
}
</style>


<div class="form-card">

    <div class="form-header">
        Add Designation
    </div>

    <div class="form-body">

        <?php
        echo Form::open(["route"=>"designation/save"]);

        // Department
        echo "<div class='form-group'>";
        echo Form::select([
            "label" => "Department",
            "name" => "dept_id",
            "table" => "department",
            "value_column" => "id",
            "display_column" => "name",
            "value" => isset($data['dept_id']) ? $data['dept_id'] : ""
        ]);
        echo "</div>";

        // Designation
        echo "<div class='form-group'>";
        echo Form::input([
            "label" => "Designation",
            "type" => "text",
            "name" => "name"
        ]);
        echo "</div>";

        // Description
        echo "<div class='form-group'>";
        echo Form::input([
            "label" => "Description",
            "type" => "textarea",
            "name" => "description"
        ]);
        echo "</div>";

        // Save + Back
        echo "<div class='btn-row'>";
        echo Form::input([
            "name" => "create",
            "value" => "Save",
            "type" => "submit",
            "class" => "btn-save"
        ]);

        echo Html::link([
            "route" => "designation",
            "text" => "Back",
            "class" => "btn-back"
        ]);
        echo "</div>";

        echo Form::close();
        ?>

    </div>
</div>


<?php
echo Page::context_close();
echo Page::body_close();
?>
