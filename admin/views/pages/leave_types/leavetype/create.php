<?php
// echo Page::title(["title"=>"Create LeaveType"]);

// echo Page::body_open();
echo Html::link(["class"=>"btn btn-success mb-3", "route"=>"leavetype", "text"=>"Back Page"]);
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
echo Form::input([
    "label" => "Deduct Leave",
    "type" => "number",
    "name" => "deduct_apply",
    "class" => "form-control",
    "min" => 0,
    // "placeholder" => "0 = Paid, 1 = Unpaid"
]);

// Description
echo Form::input([
    "label" => "Description",
    "type" => "text",
    "name" => "description",
    "class" => "form-control"
]);

// Status Dropdown
echo "<div class='mb-3'>";
echo "<label for='status' class='form-label'>Status</label>";
echo LeaveType::html_status_select("status", null, "form-control");
echo "</div>";

// Submit Button
echo Form::input([
    "name" => "create",
    "class" => "btn btn-primary",
    "value" => "Save",
    "type" => "submit"
]);

echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>
