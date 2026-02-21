<?php
echo Page::title(["title" => "Create Department"]);
echo Page::body_open();
echo Html::link(["class" => "btn btn-success", "route" => "department", "text" => "Manage Department"]);
echo Page::context_open();

echo Form::open(["route" => "department/save"]);

// Name
echo Form::input([
    "label" => "Name",
    "type" => "text",
    "name" => "name",
    "required" => true
]);

// Description
echo Form::input([
    "label" => "Description",
    "type" => "textarea",
    "name" => "description"
]);

// Status dropdown (aligned UI)
echo "<div class='form-group row'>";
echo "<label for='status' class='col-sm-2 col-form-label'>Status</label>";
echo "<div class='col-sm-10'>";
echo "<select name='status' id='status' class='form-select' style='width:100%' required>";
echo "<option value='' selected>Select Status</option>";
echo "<option value='Active'>Active</option>";
echo "<option value='Inactive'>Inactive</option>";
echo "</select>";
echo "</div>";
echo "</div>";

// Submit button
echo Form::input([
    "name" => "create",
    "class" => "btn btn-primary offset-2",
    "value" => "Save",
    "type" => "submit"
]);

echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>
