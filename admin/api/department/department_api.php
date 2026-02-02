<?php
class DepartmentApi{
	public function __construct(){
	}
	function index(){
		echo json_encode(["department"=>Department::getall()]);
	}
	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["department"=>Department::pagination($page,$perpage),"total_records"=>Department::count()]);
	}
	function find($data){
		echo json_encode(["department"=>Department::find($data["id"])]);
	}
	function delete($data){
		Department::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}
	function save($data,$file=[]){
		$department=new Department();
		$department->name=$data["name"];
		$department->description=$data["description"];
		$department->status=$data["status"];
		$department->save();
		echo json_encode(["success" => "yes"]);
	}
	function update($data,$file=[]){
		$department=new Department();
		$department->id=$data["id"];
		$department->name=$data["name"];
		$department->description=$data["description"];
		$department->status=$data["status"];
		$department->update();
		echo json_encode(["success" => "yes"]);
	}
}
?>
