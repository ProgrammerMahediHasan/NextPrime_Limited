<?php
// echo Page::title(["title"=>"Edit LeaveType"]);

echo Page::body_open();
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

// Deduct Type
$dedVal = intval($leavetype->deduct_apply);
echo "<div class='form-group row'>";
echo "<label class='col-sm-2 col-form-label'>Deduct Type</label>";
echo "<div class='col-sm-10'>";
echo "<select name='deduct_apply' id='deduct_apply' class='form-select' style='width:100%'>";
echo "<option value='1' ".($dedVal===1?'selected':'').">Salary</option>";
echo "<option value='0' ".($dedVal===0?'selected':'').">Leave Balance</option>";
echo "<option value='-1' ".($dedVal===-1?'selected':'').">None</option>";
echo "</select>";
echo "</div>";
echo "</div>";

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

// Buttons: Back + Update (centered, side-by-side)
echo "<div style='display:flex;justify-content:center;gap:10px;margin-top:12px;'>";
echo Html::link([
    "class" => "btn btn-dark",
    "route" => "leavetype",
    "text"  => "Back"
]);
echo "<button type='submit' name='update' class='btn btn-primary'>Update</button>";
echo "</div>";

echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>
