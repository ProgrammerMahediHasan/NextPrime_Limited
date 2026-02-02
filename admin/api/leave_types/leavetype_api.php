<?php
class LeaveTypeApi{
	public function __construct(){
	}
	function index(){
		echo json_encode(["leave_types"=>LeaveType::all()]);
	}
	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["leave_types"=>LeaveType::pagination($page,$perpage),"total_records"=>LeaveType::count()]);
	}
	function find($data){
		echo json_encode(["leavetype"=>LeaveType::find($data["id"])]);
	}
	function delete($data){
		LeaveType::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}
	function save($data,$file=[]){
		$leavetype=new LeaveType();
		$leavetype->name=$data["name"];
		$leavetype->leave_code=$data["leave_code"];
		$leavetype->total_days=$data["total_days"];
		$leavetype->deduct_apply=$data["deduct_apply"];
		$leavetype->description=$data["description"];
		$leavetype->status=$data["status"];

		$leavetype->save();
		echo json_encode(["success" => "yes"]);
	}
	
	function update($data,$file=[]){
		$leavetype=new LeaveType();
		$leavetype->id=$data["id"];
		$leavetype->name=$data["name"];
		$leavetype->leave_code=$data["leave_code"];
		$leavetype->total_days=$data["total_days"];
		$leavetype->deduct_apply=$data["deduct_apply"];
		$leavetype->description=$data["description"];
        $leavetype->status=$data["status"];
		$leavetype->update();
		echo json_encode(["success" => "yes"]);
	}
}
?>
