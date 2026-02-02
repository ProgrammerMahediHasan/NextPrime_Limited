<?php
echo Page::title(["title"=>"Edit Department"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"department", "text"=>"Manage Department"]);
echo Page::context_open();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
}

/* Card Container */
.form-card {
    max-width: 700px;
    margin: 30px auto;
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* Header */
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

/* Form Body */
.form-body {
    padding: 30px;
}

/* Form Groups */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #1f2937;
}

.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 14px;
    box-sizing: border-box;
    outline: none;
    transition: all 0.3s ease;
}

.form-group input[type="text"]:focus,
.form-group textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 8px rgba(37,99,235,0.25);
}

textarea {
    resize: vertical;
    min-height: 80px;
}

/* Submit Button */
.btn-submit {
    padding: 12px 28px;
    background: linear-gradient(135deg,#2563eb,#1d4ed8);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}
.btn-submit:hover {
    background: linear-gradient(135deg,#1e40af,#1d4ed8);
    transform: translateY(-2px);
}
</style>

<div class="form-card">
    <div class="form-header">
        Edit Department
    </div>
    <div class="form-body">
        <?php
        echo Form::open(["route"=>"department/update"]);

            // Hidden Id
            echo Form::input(["type"=>"hidden","name"=>"id","value"=>"$department->id"]);

            // Name
            echo "<div class='form-group'>";
            echo Form::input(["label"=>"Name","type"=>"text","name"=>"name","value"=>"$department->name"]);
            echo "</div>";

            // Description
            echo "<div class='form-group'>";
            echo Form::input(["label"=>"Description","type"=>"textarea","name"=>"description","value"=>"$department->description"]);
            echo "</div>";

            // Status
            echo "<div class='form-group'>";
            echo Form::input(["label"=>"Status","type"=>"text","name"=>"status","value"=>"$department->status"]);
            echo "</div>";

            // Submit Button
            echo "<div class='form-group'>";
            echo Form::input(["type"=>"submit","name"=>"update","value"=>"Save Changes","class"=>"btn-submit"]);
            echo "</div>";

        echo Form::close();
        ?>
    </div>
</div>

<?php
echo Page::context_close();
echo Page::body_close();
?>
