<?php
echo Page::title(["title"=>"Edit AttendancePolicy"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"attendancepolicy", "text"=>"Manage AttendancePolicy"]);
echo Page::context_open();
echo Form::open(["route"=>"attendancepolicy/update"]);
	echo Form::input(["label"=>"Id","type"=>"hidden","name"=>"id","value"=>"$attendancepolicy->id"]);
	echo Form::input(["label"=>"Name","type"=>"text","name"=>"name","value"=>"$attendancepolicy->name"]);
	echo Form::input(["label"=>"Description","type"=>"textarea","name"=>"description","value"=>"$attendancepolicy->description"]);
	echo Form::input(["label"=>"Key Highlights","type"=>"text","name"=>"key_highlights","value"=>"$attendancepolicy->key_highlights"]);
	echo Form::input(["label"=>"Effective From","type"=>"text","name"=>"effective_from","value"=>"$attendancepolicy->effective_from"]);
	echo Form::input(["label"=>"Status","type"=>"text","name"=>"status","value"=>"$attendancepolicy->status"]);
	echo Form::input(["label"=>"Approval Required","type"=>"textarea","name"=>"approval_required","value"=>"$attendancepolicy->approval_required"]);
	echo Form::input(["label"=>"Created By","type"=>"text","name"=>"created_by","value"=>"$attendancepolicy->created_by"]);

echo Form::input(["name"=>"update","class"=>"btn btn-success offset-2" , "value"=>"Save Chanage", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
