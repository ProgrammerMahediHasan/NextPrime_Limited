<?php
class DesignationController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("designation");
	}
	public function create(){
		view("designation");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}
	if(!preg_match("/^[\s\S]+$/",$data["description"])){
		$errors["description"]="Invalid description";
	}

*/
		if(count($errors)==0){
			$designation=new Designation();
		$designation->name=$data["name"];
		$designation->dept_id=$data["dept_id"];
		$designation->description=$data["description"];

			$designation->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("designation",Designation::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}
	if(!preg_match("/^[\s\S]+$/",$data["description"])){
		$errors["description"]="Invalid description";
	}

*/
		if(count($errors)==0){
			$designation=new Designation();
			$designation->id=$data["id"];
			$designation->dept_id=$data["dept_id"];
			$designation->name=$data["name"];
			$designation->description=$data["description"];

		$designation->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("designation");
	}
	
	public function delete($id){
		Designation::delete($id);
		redirect();
	}
	
	public function show($id){
		view("designation",Designation::find($id));
	}
}
?>