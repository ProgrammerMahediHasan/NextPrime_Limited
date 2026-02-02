<?php
// echo Page::title(["title"=>"Create Leave Assign"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"leaveassign", "text"=>"Back Page"]);
echo Page::context_open();
echo Form::open(["route"=>"leaveassign/save"]);
echo Form::input([
  "label" => "Emp",
  "name"  => "emp_id",
  "table" => "employees",
  "placeholder" => "Select Employee"
]);

echo Form::input([
  "label" => "Leave Type",
  "name"  => "leave_type_id",
  "table" => "leave_types",
  "placeholder" => "Select Leave"
]);


	echo Form::input(["label"=>"Allow Days","type"=>"text","name"=>"allow_days"]);
	// echo Form::input(["label"=>"Used Days","type"=>"hidden","name"=>"used_days"]);
	echo Form::input(["label"=>"Year","type"=>"text","name"=>"year"]);

echo Form::input(["name"=>"create","class"=>"btn btn-primary offset-2", "value"=>"Save", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
