<?php
class RoleController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("roles");
	}
	public function create(){
		view("roles");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}

*/
		if(count($errors)==0){
			$role=new Role();
		$role->name=$data["name"];
		// $role->created_at=$now;
		// $role->updated_at=$now;

			$role->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("roles",Role::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}

*/
		if(count($errors)==0){
			$role=new Role();
			$role->id=$data["id"];
		$role->name=$data["name"];
		// $role->created_at=$now;
		// $role->updated_at=$now;

		$role->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("roles");
	}
	public function delete($id){
		Role::delete($id);
		redirect();
	}
	public function show($id){
		view("roles",Role::find($id));
	}
}
?>
