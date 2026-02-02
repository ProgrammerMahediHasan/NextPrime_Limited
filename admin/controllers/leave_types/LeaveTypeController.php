<?php
class LeaveTypeController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("leave_types");
	}
	public function create(){
		view("leave_types");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtLeaveName"])){
		$errors["leave_name"]="Invalid leave_name";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtLeaveCode"])){
		$errors["leave_code"]="Invalid leave_code";
	}
	if(!preg_match("/^[\s\S]+$/",$data["total_days"])){
		$errors["total_days"]="Invalid total_days";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtDescription"])){
		$errors["description"]="Invalid description";
	}
	if(!preg_match("/^[\s\S]+$/",$data["status"])){
		$errors["status"]="Invalid status";
	}

*/
		if(count($errors)==0){
			$leavetype=new LeaveType();
		$leavetype->name=$data["name"];
		$leavetype->leave_code=$data["leave_code"];
		$leavetype->total_days=$data["total_days"];
		$leavetype->deduct_apply=$data["deduct_apply"];
		$leavetype->description=$data["description"];
		$leavetype->status=$data["status"];

			$leavetype->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("leave_types",LeaveType::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtLeaveName"])){
		$errors["leave_name"]="Invalid leave_name";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtLeaveCode"])){
		$errors["leave_code"]="Invalid leave_code";
	}
	if(!preg_match("/^[\s\S]+$/",$data["total_days"])){
		$errors["total_days"]="Invalid total_days";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtDescription"])){
		$errors["description"]="Invalid description";
	}
	if(!preg_match("/^[\s\S]+$/",$data["status"])){
		$errors["status"]="Invalid status";
	}

*/
		if(count($errors)==0){
			$leavetype=new LeaveType();
			$leavetype->id=$data["id"];
		$leavetype->name=$data["name"];
		$leavetype->leave_code=$data["leave_code"];
		$leavetype->total_days=$data["total_days"];
		$leavetype->deduct_apply=$data["deduct_apply"];
		$leavetype->description=$data["description"];
		$leavetype->status=$data["status"];

		$leavetype->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("leave_types");
	}
	public function delete($id){
		LeaveType::delete($id);
		redirect();
	}
	public function show($id){
		view("leave_types",LeaveType::find($id));
	}
}
?>
