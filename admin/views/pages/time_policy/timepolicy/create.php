<?php
echo Page::title(["title"=>"Create TimePolicy"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"timepolicy", "text"=>"Manage TimePolicy"]);
echo Page::context_open();
echo Form::open(["route"=>"timepolicy/save"]);
	echo Form::input(["label"=>"Name","type"=>"text","name"=>"name"]);
	echo Form::input(["label"=>"Policy Type","type"=>"text","name"=>"policy_type"]);
	echo Form::input(["label"=>"Details","type"=>"textarea","name"=>"details"]);
	echo Form::input(["label"=>"Policy Highlights","type"=>"text","name"=>"policy_highlights"]);
	echo Form::input(["label"=>"Approval Required","type"=>"textarea","name"=>"approval_required"]);

echo Form::input(["name"=>"create","class"=>"btn btn-primary offset-2", "value"=>"Save", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
