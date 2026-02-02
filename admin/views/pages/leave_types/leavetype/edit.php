<?php
// echo Page::title(["title"=>"Edit LeaveType"]);

echo Page::body_open();
echo Html::link(["class"=>"btn btn-success mb-3", "route"=>"leavetype", "text"=>"Back Page"]);
echo Page::context_open();

echo Form::open(["route"=>"leavetype/update"]);

// Hidden ID
echo Form::input([
    "type" => "hidden",
    "name" => "id",
    "value" => $leavetype->id
]);

// Leave Name
echo Form::input([
    "label" => "Leave Name",
    "type" => "text",
    "name" => "name",
    "value" => $leavetype->name,
    "class" => "form-control",
    "required" => true
]);

// Leave Code
echo Form::input([
    "label" => "Leave Code",
    "type" => "text",
    "name" => "leave_code",
    "value" => $leavetype->leave_code,
    "class" => "form-control",
    "required" => true
]);

// Total Days
echo Form::input([
    "label" => "Total Days",
    "type" => "number",
    "name" => "total_days",
    "value" => $leavetype->total_days,
    "class" => "form-control",
    "min" => 0,
    "required" => true
]);

// Deduct Leave
echo Form::input([
    "label" => "Deduct Leave",
    "type" => "number",
    "name" => "deduct_apply",
    "value" => $leavetype->deduct_apply,
    "class" => "form-control",
    "min" => 0,
    "placeholder" => "0 = Paid, 1 = Unpaid"
]);

// Description
echo Form::input([
    "label" => "Description",
    "type" => "text",
    "name" => "description",
    "value" => $leavetype->description,
    "class" => "form-control"
]);

// Status Dropdown
echo "<div class='mb-3'>";
echo "<label for='status' class='form-label'>Status</label>";
echo LeaveType::html_status_select("status", $leavetype->status, "form-control");
echo "</div>";

// Submit Button
echo Form::input([
    "name" => "update",
    "class" => "btn btn-success",
    "value" => "Update Changes",
    "type" => "submit"
]);

echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>
