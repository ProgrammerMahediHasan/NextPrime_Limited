<?php
echo Page::title(["title"=>"Edit User"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"user", "text"=>"Manage User"]);
echo Page::context_open();
echo Form::open(["route"=>"user/update"]);
	echo Form::input(["label"=>"Id","type"=>"hidden","name"=>"id","value"=>"$user->id"]);
	echo Form::input(["label"=>"name","type"=>"text","name"=>"name","value"=>"$user->name"]);
	echo Form::input(["label"=>"Email","type"=>"text","name"=>"email","value"=>"$user->email"]);
	echo Form::input([
		"label"=>"Role",
		"name"=>"role_id",
		"table"=>"roles",
		"value"=>"$user->role_id",
		"placeholder_option"=>"Select Role",
		"placeholder_value"=>""
	]);
	echo Form::input(["label"=>"Address","type"=>"text","name"=>"address","value"=>"$user->address"]);
	echo "<div class='form-group row'>";
	echo "<label for='status' class='col-sm-2 col-form-label'>Status</label>";
	echo "<div class='col-sm-10'>";
	echo "<select name='status' id='status' class='form-select' style='width:100%'>";
	$selA = (isset($user->status) && $user->status=='Active') ? "selected" : "";
	$selI = (isset($user->status) && $user->status=='Inactive') ? "selected" : "";
	echo "<option value='Active' $selA>Active</option>";
	echo "<option value='Inactive' $selI>Inactive</option>";
	echo "</select>";
	echo "</div>";
	echo "</div>";
	echo Form::input(["label"=>"Photo","type"=>"file","name"=>"photo","value"=>$user->photo]);

echo Form::input(["name"=>"update","class"=>"btn btn-success offset-2" , "value"=>"Save Chanage", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
