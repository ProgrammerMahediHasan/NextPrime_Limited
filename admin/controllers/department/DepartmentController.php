<?php
class DepartmentController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("department");
	}
	public function create(){
		view("department");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];

		if(count($errors)==0){
			$department=new Department();
		$department->name=$data["name"];
		$department->description=$data["description"];
		$department->status=$data["status"];

			$department->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("department",Department::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];

		if(count($errors)==0){
			$department=new Department();
			$department->id=$data["id"];
		$department->name=$data["name"];
		$department->description=$data["description"];
		$department->status=$data["status"];

		$department->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("department");
	}
	public function delete($id){
		Department::delete($id);
		redirect();
	}
	public function show($id){
		view("department",Department::find($id));
	}
}
?>
