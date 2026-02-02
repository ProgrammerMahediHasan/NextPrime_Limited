<?php
class TimePolicyController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("time_policy");
	}
	public function create(){
		view("time_policy");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}
	if(!preg_match("/^[\s\S]+$/",$data["policy_type"])){
		$errors["policy_type"]="Invalid policy_type";
	}
	if(!preg_match("/^[\s\S]+$/",$data["details"])){
		$errors["details"]="Invalid details";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtPolicyHighlights"])){
		$errors["policy_highlights"]="Invalid policy_highlights";
	}
	if(!preg_match("/^[\s\S]+$/",$data["approval_required"])){
		$errors["approval_required"]="Invalid approval_required";
	}

*/
		if(count($errors)==0){
			$timepolicy=new TimePolicy();
		$timepolicy->name=$data["name"];
		$timepolicy->policy_type=$data["policy_type"];
		$timepolicy->details=$data["details"];
		$timepolicy->policy_highlights=$data["policy_highlights"];
		$timepolicy->approval_required=$data["approval_required"];
		$timepolicy->created_time=$now;

			$timepolicy->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("time_policy",TimePolicy::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtName"])){
		$errors["name"]="Invalid name";
	}
	if(!preg_match("/^[\s\S]+$/",$data["policy_type"])){
		$errors["policy_type"]="Invalid policy_type";
	}
	if(!preg_match("/^[\s\S]+$/",$data["details"])){
		$errors["details"]="Invalid details";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtPolicyHighlights"])){
		$errors["policy_highlights"]="Invalid policy_highlights";
	}
	if(!preg_match("/^[\s\S]+$/",$data["approval_required"])){
		$errors["approval_required"]="Invalid approval_required";
	}

*/
		if(count($errors)==0){
			$timepolicy=new TimePolicy();
			$timepolicy->id=$data["id"];
		$timepolicy->name=$data["name"];
		$timepolicy->policy_type=$data["policy_type"];
		$timepolicy->details=$data["details"];
		$timepolicy->policy_highlights=$data["policy_highlights"];
		$timepolicy->approval_required=$data["approval_required"];
		$timepolicy->created_time=$now;

		$timepolicy->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("time_policy");
	}
	public function delete($id){
		TimePolicy::delete($id);
		redirect();
	}
	public function show($id){
		view("time_policy",TimePolicy::find($id));
	}
}
?>
