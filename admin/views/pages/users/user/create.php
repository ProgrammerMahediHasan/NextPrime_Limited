<?php
// echo Page::title(["title"=>"Create User"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"user", "text"=>"Back Page"]);
echo Page::context_open();
echo Form::open(["route"=>"user/save"]);
	echo Form::input(["label"=>"name","type"=>"text","name"=>"name"]);
	echo Form::input(["label"=>"Password","type"=>"text","name"=>"password"]);
	echo Form::input(["label"=>"Email","type"=>"text","name"=>"email"]);
	echo Form::input(["label"=>"Role","name"=>"role_id","table"=>"roles"]);
	echo Form::input(["label"=>"Address","type"=>"text","name"=>"address"]);
	echo Form::input(["label"=>"Status","type"=>"text","name"=>"status"]);
	// echo Form::input(["label"=>"Photo","type"=>"file","name"=>"photo"]);

echo Form::input(["name"=>"create","class"=>"btn btn-primary offset-2", "value"=>"Save", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
