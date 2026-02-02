<?php
echo Page::title(["title"=>"Create AttendancePolicy"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"attendancepolicy", "text"=>"Manage AttendancePolicy"]);
echo Page::context_open();
echo Form::open(["route"=>"attendancepolicy/save"]);
	echo Form::input(["label"=>"Name","type"=>"text","name"=>"name"]);
	echo Form::input(["label"=>"Description","type"=>"textarea","name"=>"description"]);
	echo Form::input(["label"=>"Key Highlights","type"=>"text","name"=>"key_highlights"]);
	echo Form::input(["label"=>"Effective From","type"=>"text","name"=>"effective_from"]);
	echo Form::input(["label"=>"Status","type"=>"text","name"=>"status"]);
	echo Form::input(["label"=>"Approval Required","type"=>"textarea","name"=>"approval_required"]);
	echo Form::input(["label"=>"Created By","type"=>"text","name"=>"created_by"]);

echo Form::input(["name"=>"create","class"=>"btn btn-primary offset-2", "value"=>"Save", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
