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

// ✅ Status dropdown (raw HTML)
echo "<div class='form-group'>";
echo "<label>Status</label>";
echo "<select name='status' class='form-control' required>
        <option value=''>Select Status</option>
        <option value='Active'>Active</option>
        <option value='Inactive'>Inactive</option>
      </select>";
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
