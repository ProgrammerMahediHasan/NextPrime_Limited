<?php
class AttendancePolicyController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("attendance_policy");
	}
	public function create(){
		view("attendance_policy");
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
	if(!preg_match("/^[\s\S]+$/",$data["key_highlights"])){
		$errors["key_highlights"]="Invalid key_highlights";
	}
	if(!preg_match("/^[\s\S]+$/",$data["effective_from"])){
		$errors["effective_from"]="Invalid effective_from";
	}
	if(!preg_match("/^[\s\S]+$/",$data["status"])){
		$errors["status"]="Invalid status";
	}
	if(!preg_match("/^[\s\S]+$/",$data["approval_required"])){
		$errors["approval_required"]="Invalid approval_required";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtCreatedBy"])){
		$errors["created_by"]="Invalid created_by";
	}

*/
		if(count($errors)==0){
			$attendancepolicy=new AttendancePolicy();
		$attendancepolicy->name=$data["name"];
		$attendancepolicy->description=$data["description"];
		$attendancepolicy->key_highlights=$data["key_highlights"];
		$attendancepolicy->effective_from=$data["effective_from"];
		$attendancepolicy->status=$data["status"];
		$attendancepolicy->approval_required=$data["approval_required"];
		$attendancepolicy->created_by=$data["created_by"];

			$attendancepolicy->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("attendance_policy",AttendancePolicy::find($id));
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
	if(!preg_match("/^[\s\S]+$/",$data["key_highlights"])){
		$errors["key_highlights"]="Invalid key_highlights";
	}
	if(!preg_match("/^[\s\S]+$/",$data["effective_from"])){
		$errors["effective_from"]="Invalid effective_from";
	}
	if(!preg_match("/^[\s\S]+$/",$data["status"])){
		$errors["status"]="Invalid status";
	}
	if(!preg_match("/^[\s\S]+$/",$data["approval_required"])){
		$errors["approval_required"]="Invalid approval_required";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtCreatedBy"])){
		$errors["created_by"]="Invalid created_by";
	}

*/
		if(count($errors)==0){
			$attendancepolicy=new AttendancePolicy();
			$attendancepolicy->id=$data["id"];
		$attendancepolicy->name=$data["name"];
		$attendancepolicy->description=$data["description"];
		$attendancepolicy->key_highlights=$data["key_highlights"];
		$attendancepolicy->effective_from=$data["effective_from"];
		$attendancepolicy->status=$data["status"];
		$attendancepolicy->approval_required=$data["approval_required"];
		$attendancepolicy->created_by=$data["created_by"];

		$attendancepolicy->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("attendance_policy");
	}
	public function delete($id){
		AttendancePolicy::delete($id);
		redirect();
	}
	public function show($id){
		view("attendance_policy",AttendancePolicy::find($id));
	}
}
?>
