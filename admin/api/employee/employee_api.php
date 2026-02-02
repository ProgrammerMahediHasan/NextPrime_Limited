<?php
class EmployeeApi{
	public function __construct(){
	}

	function index(){
		echo json_encode(["employees"=>Employee::all()]);
	}

	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["employees"=>Employee::pagination($page,$perpage),"total_records"=>Employee::count()]);
	}

	function find($data){
		echo json_encode(["employee"=>Employee::find($data["id"])]);
	}

	function delete($data){
		Employee::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}

	function save($data,$file=[]){
		$employee=new Employee();
		$employee->name=$data["name"];
		$employee->dept_id=$data["dept_id"];
		$employee->desig_id=$data["desig_id"];
		$employee->gender=$data["gender"];
		$employee->email=$data["email"];
		$employee->phone=$data["phone"];
		$employee->status=$data["status"];
		$employee->joining_date=$data["joining_date"];

		$employee->save();
		echo json_encode(["success" => "yes"]);
	}

	function update($data,$file=[]){
		$employee=new Employee();
		$employee->id=$data["id"];
		$employee->name=$data["name"];
		$employee->dept_id=$data["dept_id"];
		$employee->desig_id=$data["desig_id"];
		$employee->gender=$data["gender"];
		$employee->email=$data["email"];
		$employee->phone=$data["phone"];
		$employee->status=$data["status"];
		$employee->joining_date=$data["joining_date"];

		$employee->update();
		echo json_encode(["success" => "yes"]);
	}

}
?>
