<?php
class LeaveAssignController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("leave_assign");
	}
	public function create(){
		view("leave_assign");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$data["emp_id"])){
		$errors["emp_id"]="Invalid emp_id";
	}
	if(!preg_match("/^[\s\S]+$/",$data["leave_type_id"])){
		$errors["leave_type_id"]="Invalid leave_type_id";
	}
	if(!preg_match("/^[\s\S]+$/",$data["allow_days"])){
		$errors["allow_days"]="Invalid allow_days";
	}
	if(!preg_match("/^[\s\S]+$/",$data["used_days"])){
		$errors["used_days"]="Invalid used_days";
	}
	if(!preg_match("/^[\s\S]+$/",$data["year"])){
		$errors["year"]="Invalid year";
	}

*/
		if(count($errors)==0){
			$leaveassign=new LeaveAssign();
		$leaveassign->emp_id=$data["emp_id"];
		$leaveassign->leave_type_id=$data["leave_type_id"];
		$leaveassign->allow_days=$data["allow_days"];
		// $leaveassign->used_days=$data["used_days"];
		$leaveassign->year=$data["year"];
		// $leaveassign->created_at=$now;
		// $leaveassign->updated_at=$now;

			$leaveassign->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("leave_assign",LeaveAssign::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$data["emp_id"])){
		$errors["emp_id"]="Invalid emp_id";
	}
	if(!preg_match("/^[\s\S]+$/",$data["leave_type_id"])){
		$errors["leave_type_id"]="Invalid leave_type_id";
	}
	if(!preg_match("/^[\s\S]+$/",$data["allow_days"])){
		$errors["allow_days"]="Invalid allow_days";
	}
	if(!preg_match("/^[\s\S]+$/",$data["used_days"])){
		$errors["used_days"]="Invalid used_days";
	}
	if(!preg_match("/^[\s\S]+$/",$data["year"])){
		$errors["year"]="Invalid year";
	}

*/
		if(count($errors)==0){
			$leaveassign=new LeaveAssign();
			$leaveassign->id=$data["id"];
		$leaveassign->emp_id=$data["emp_id"];
		$leaveassign->leave_type_id=$data["leave_type_id"];
		$leaveassign->allow_days=$data["allow_days"];
		// $leaveassign->used_days=$data["used_days"];
		$leaveassign->year=$data["year"];
		// $leaveassign->created_at=$now;
		// $leaveassign->updated_at=$now;

		$leaveassign->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("leave_assign");
	}
	public function delete($id){
		LeaveAssign::delete($id);
		redirect();
	}
	public function show($id){
		view("leave_assign",LeaveAssign::find($id));
	}
}
?>
