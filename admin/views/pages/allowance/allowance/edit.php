<?php
echo Page::title(["title"=>"Edit Allowance"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"allowance", "text"=>"Manage Allowance"]);
echo Page::context_open();
echo Form::open(["route"=>"allowance/update"]);
	echo Form::input(["label"=>"Id","type"=>"hidden","name"=>"id","value"=>"$allowance->id"]);
	echo Form::input(["label"=>"Emp","name"=>"emp_id","table"=>"employee_details","value"=>"$allowance->emp_id"]);
	echo Form::input(["label"=>"Allowance Type","type"=>"text","name"=>"allowance_type","value"=>"$allowance->allowance_type"]);
	echo Form::input(["label"=>"Amount","type"=>"text","name"=>"amount","value"=>"$allowance->amount"]);
	echo Form::input(["label"=>"Pay Month","type"=>"text","name"=>"pay_month","value"=>"$allowance->pay_month"]);

echo Form::input(["name"=>"update","class"=>"btn btn-success offset-2" , "value"=>"Save Chanage", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
