<?php
// echo Page::title(["title"=>"Edit Designation"]);
// echo Page::body_open();
// echo Html::link(["class"=>"btn btn-success","route"=>"designation","text"=>"Manage Designation"]);
// echo Page::context_open();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

body { font-family: 'Poppins', sans-serif; }

.form-card {
    max-width: 700px;
    margin: 30px auto;
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #142f69ff, #1d4ed8);
    color: #e9e0e0d5;
    padding: 20px 30px;
    text-align: center;
    font-size: 20px;
    font-weight: 600;
    position: relative;
}

.form-header::after {
    content: "";
    position: absolute;
    width: 60px;
    height: 3px;
    background: #60a5fa;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 2px;
}

.form-body { padding: 30px; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; margin-bottom: 6px; font-weight: 500; color: #1f2937; }

.form-group input[type="text"], .form-group textarea, select {
    width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid #d1d5db;
    font-size: 14px; box-sizing: border-box; outline: none; transition: all 0.3s ease;
}

.form-group input[type="text"]:focus, .form-group textarea:focus, select:focus {
    border-color: #2563eb; box-shadow: 0 0 8px rgba(37, 99, 235, 0.25);
}

textarea { resize: vertical; min-height: 80px; }

/* Uniform buttons */
.btn-uniform {
    padding: 12px 28px;      /* same padding */
    min-width: 120px;        /* ensure same width */
    text-align: center;
    font-size: 14px;         /* same font size */
    border-radius: 8px;      /* rounded */
    font-weight: 600;
    cursor: pointer;
    display: inline-block;
    transition: 0.3s ease;
}
.btn-submit { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border: none; }
.btn-submit:hover { background: linear-gradient(135deg, #1e40af, #1d4ed8); }

.btn-back { background: #6b7280; color: #fff; border: none; text-decoration:none; line-height:1.4; }
.btn-back:hover { background: #4b5563; text-decoration:none; }
.btn-group-row { display:flex; gap:10px; margin-top:15px; justify-content:flex-start; }

</style>

<div class="form-card">
    <div class="form-header">Edit Designation</div>
    <div class="form-body">
        <?php
        echo Form::open(["route"=>"designation/update"]);

        // Hidden Id
        echo Form::input(["type"=>"hidden","name"=>"id","value"=>$designation->id]);

        // Department dropdown
        echo Form::select([
            "label" => "Department",
            "name" => "dept_id",
            "table" => "department",
            "value_column" => "id",
            "display_column" => "name",
            "value" => $designation->dept_id  // ✅ preselect current dept
        ]);

        // Designation input
        echo "<div class='form-group'>";
        echo Form::input([
            "label"=>"Designation",
            "type"=>"text",
            "name"=>"name",
            "value"=>$designation->name // ✅ object property
        ]);
        echo "</div>";

        // Description
        echo "<div class='form-group'>";
        echo Form::input([
            "label"=>"Description",
            "type"=>"textarea",
            "name"=>"description",
            "value"=>$designation->description // ✅ object property
        ]);
        echo "</div>";

        // Save + Back buttons (same row & same size)
        echo "<div class='btn-group-row'>";
        echo Form::input([
            "type"=>"submit",
            "name"=>"update",
            "value"=>"Save",
            "class"=>"btn-uniform btn-submit"
        ]);
        echo Html::link([

            "route"=>"designation",
            "text"=>"Back",
            "class"=>"btn-uniform btn-back"
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
