<?php
// echo Page::title(["title"=>"Edit LeaveAssign"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"leaveassign", "text"=>"Back Page"]);
echo Page::context_open();
echo Form::open(["route"=>"leaveassign/update"]);
	echo Form::input(["label"=>"Id","type"=>"hidden","name"=>"id","value"=>"$leaveassign->id"]);
echo Form::input([
  "name" => "emp_id",
  "label" => "Employee",
  "table" => "employees",
  "value_column" => "id",
  "display_column" => "name",
  "value" => $leaveassign->emp_id   // ✅ FIX
]);



	echo Form::input(["label"=>"Leave Type","name"=>"leave_type_id","table"=>"leave_types","value"=>"$leaveassign->leave_type_id"]);
	echo Form::input(["label"=>"Allow Days","type"=>"text","name"=>"allow_days","value"=>"$leaveassign->allow_days"]);
	// echo Form::input(["label"=>"Used Days","type"=>"text","name"=>"used_days","value"=>"$leaveassign->used_days"]);
	echo Form::input(["label"=>"Year","type"=>"text","name"=>"year","value"=>"$leaveassign->year"]);

echo Form::input(["name"=>"update","class"=>"btn btn-success offset-2" , "value"=>"Save Chanage", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
