<?php
class SalaryPolicyController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("salary_policy");
	}
	public function create(){
		view("salary_policy");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}
	if(!preg_match("/^[\s\S]+$/",$data["salary_type"])){
		$errors["salary_type"]="Invalid salary_type";
	}
	if(!preg_match("/^[\s\S]+$/",$data["description"])){
		$errors["description"]="Invalid description";
	}
	if(!preg_match("/^[\s\S]+$/",$data["status"])){
		$errors["status"]="Invalid status";
	}
	if(!preg_match("/^[\s\S]+$/",$data["key_points"])){
		$errors["key_points"]="Invalid key_points";
	}
	if(!preg_match("/^[\s\S]+$/",$data["effective_time"])){
		$errors["effective_time"]="Invalid effective_time";
	}
	if(!preg_match("/^[\s\S]+$/",$data["approval_required"])){
		$errors["approval_required"]="Invalid approval_required";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtCreatedBy"])){
		$errors["created_by"]="Invalid created_by";
	}

*/
		if(count($errors)==0){
			$salarypolicy=new SalaryPolicy();
		$salarypolicy->name=$data["name"];
		$salarypolicy->salary_type=$data["salary_type"];
		$salarypolicy->description=$data["description"];
		$salarypolicy->status=$data["status"];
		$salarypolicy->key_points=$data["key_points"];
		$salarypolicy->effective_time=$data["effective_time"];
		$salarypolicy->approval_required=$data["approval_required"];
		$salarypolicy->created_by=$data["created_by"];

			$salarypolicy->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("salary_policy",SalaryPolicy::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}
	if(!preg_match("/^[\s\S]+$/",$data["salary_type"])){
		$errors["salary_type"]="Invalid salary_type";
	}
	if(!preg_match("/^[\s\S]+$/",$data["description"])){
		$errors["description"]="Invalid description";
	}
	if(!preg_match("/^[\s\S]+$/",$data["status"])){
		$errors["status"]="Invalid status";
	}
	if(!preg_match("/^[\s\S]+$/",$data["key_points"])){
		$errors["key_points"]="Invalid key_points";
	}
	if(!preg_match("/^[\s\S]+$/",$data["effective_time"])){
		$errors["effective_time"]="Invalid effective_time";
	}
	if(!preg_match("/^[\s\S]+$/",$data["approval_required"])){
		$errors["approval_required"]="Invalid approval_required";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtCreatedBy"])){
		$errors["created_by"]="Invalid created_by";
	}

*/
		if(count($errors)==0){
			$salarypolicy=new SalaryPolicy();
			$salarypolicy->id=$data["id"];
		$salarypolicy->name=$data["name"];
		$salarypolicy->salary_type=$data["salary_type"];
		$salarypolicy->description=$data["description"];
		$salarypolicy->status=$data["status"];
		$salarypolicy->key_points=$data["key_points"];
		$salarypolicy->effective_time=$data["effective_time"];
		$salarypolicy->approval_required=$data["approval_required"];
		$salarypolicy->created_by=$data["created_by"];

		$salarypolicy->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("salary_policy");
	}
	public function delete($id){
		SalaryPolicy::delete($id);
		redirect();
	}
	public function show($id){
		view("salary_policy",SalaryPolicy::find($id));
	}
}
?>
