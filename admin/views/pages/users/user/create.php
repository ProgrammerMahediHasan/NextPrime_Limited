<?php
// echo Page::title(["title"=>"Create User"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"user", "text"=>"Back Page"]);
echo Page::context_open();
echo Form::open(["route"=>"user/save"]);
	echo Form::input(["label"=>"name","type"=>"text","name"=>"name"]);
	echo Form::input(["label"=>"Password","type"=>"password","name"=>"password"]);
	echo Form::input(["label"=>"Email","type"=>"text","name"=>"email"]);
	echo Form::input(["label"=>"Role","name"=>"role_id","table"=>"roles","placeholder_option"=>"Select Role","placeholder_value"=>""]);
	echo Form::input(["label"=>"Address","type"=>"text","name"=>"address"]);
	echo "<div class='form-group row'>";
	echo "<label for='status' class='col-sm-2 col-form-label'>Status</label>";
	echo "<div class='col-sm-10'>";
	echo "<select name='status' id='status' class='form-select' style='width:100%'>";
	echo "<option value='Active' selected>Active</option>";
	echo "<option value='Inactive'>Inactive</option>";
	echo "</select>";
	echo "</div>";
	echo "</div>";
	// echo Form::input(["label"=>"Photo","type"=>"file","name"=>"photo"]);

echo Form::input(["name"=>"create","class"=>"btn btn-primary offset-2", "value"=>"Save", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
