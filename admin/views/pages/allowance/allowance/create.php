<?php
echo Page::title(["title"=>"Create Allowance"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"allowance", "text"=>"Manage Allowance"]);
echo Page::context_open();
echo Form::open(["route"=>"allowance/save"]);
	echo Form::input(["label"=>"Emp","name"=>"emp_id","table"=>"employee_details"]);
	echo Form::input(["label"=>"Allowance Type","type"=>"text","name"=>"allowance_type"]);
	echo Form::input(["label"=>"Amount","type"=>"text","name"=>"amount"]);
	echo Form::input(["label"=>"Pay Month","type"=>"text","name"=>"pay_month"]);

echo Form::input(["name"=>"create","class"=>"btn btn-primary offset-2", "value"=>"Save", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
