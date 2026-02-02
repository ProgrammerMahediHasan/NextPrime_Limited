<?php
echo Page::title(["title"=>"Edit TimePolicy"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"timepolicy", "text"=>"Manage TimePolicy"]);
echo Page::context_open();
echo Form::open(["route"=>"timepolicy/update"]);
	echo Form::input(["label"=>"Id","type"=>"hidden","name"=>"id","value"=>"$timepolicy->id"]);
	echo Form::input(["label"=>"Name","type"=>"text","name"=>"name","value"=>"$timepolicy->name"]);
	echo Form::input(["label"=>"Policy Type","type"=>"text","name"=>"policy_type","value"=>"$timepolicy->policy_type"]);
	echo Form::input(["label"=>"Details","type"=>"textarea","name"=>"details","value"=>"$timepolicy->details"]);
	echo Form::input(["label"=>"Policy Highlights","type"=>"text","name"=>"policy_highlights","value"=>"$timepolicy->policy_highlights"]);
	echo Form::input(["label"=>"Approval Required","type"=>"textarea","name"=>"approval_required","value"=>"$timepolicy->approval_required"]);

echo Form::input(["name"=>"update","class"=>"btn btn-success offset-2" , "value"=>"Save Chanage", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
