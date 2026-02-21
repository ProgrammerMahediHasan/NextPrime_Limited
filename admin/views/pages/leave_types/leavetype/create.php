<?php
// echo Page::title(["title"=>"Create LeaveType"]);

// echo Page::body_open();
// Top Back Page button removed as requested
echo Page::context_open();

// Open form
echo Form::open(["route"=>"leavetype/save"]);

// Leave Name
echo Form::input([
    "label" => "Leave Name",
    "type" => "text",
    "name" => "name",
    "class" => "form-control",
    "required" => true
]);

// Leave Code
echo Form::input([
    "label" => "Leave Code",
    "type" => "text",
    "name" => "leave_code",
    "class" => "form-control",
    "required" => true
]);

// Total Days
echo Form::input([
    "label" => "Total Days",
    "type" => "number",
    "name" => "total_days",
    "class" => "form-control",
    "required" => true,
    "min" => 0
]);

// Deduct Leave
echo "<div class='form-group row'>";
echo "<label class='col-sm-2 col-form-label'>Deduct Type</label>";
echo "<div class='col-sm-10'>";
echo "<select name='deduct_apply' id='deduct_apply' class='form-select' style='width:100%'>";
echo "<option value='1'>Salary</option>";
echo "<option value='0' selected>Leave Balance</option>";
echo "<option value='-1'>None</option>";
echo "</select>";
echo "</div>";
echo "</div>";

// Description
echo Form::input([
    "label" => "Description",
    "type" => "text",
    "name" => "description",
    "class" => "form-control"
]);

// Status Dropdown
echo "<div class='form-group row'>";
echo "<label class='col-sm-2 col-form-label'>Status</label>";
echo "<div class='col-sm-10'>";
echo LeaveType::html_status_select("status", "active", "form-select");
echo "</div>";
echo "</div>";

// Submit Button
echo "<div style='display:flex;justify-content:center;gap:10px;margin-top:12px;'>";
echo Html::link([
    "class" => "btn btn-dark",
    "route" => "leavetype",
    "text"  => "Back"
]);
echo Form::input([
    "name" => "create",
    "class" => "btn btn-primary",
    "value" => "Save",
    "type" => "submit"
]);
echo "</div>";

echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>
