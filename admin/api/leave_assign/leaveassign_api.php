<?php
class LeaveAssignApi{
	public function __construct(){
	}

	// Leave Assign index - Employee Name এবং Leave Type Name যোগ করে
	function index(){
	    $leave_assign = LeaveAssign::all(); // মূল data
	    $modified = [];

	    foreach($leave_assign as $la){
	        // Employee Name & Leave Type Name যোগ করা
	        $la->emp_name = Employee::find($la->emp_id)->name ?? "Unknown"; 
	        $la->leave_type_name = LeaveType::find($la->leave_type_id)->name ?? "Unknown";
	        $modified[] = $la;
	    }

	    echo json_encode(["leave_assign" => $modified]);
	}

	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["leave_assign"=>LeaveAssign::pagination($page,$perpage),"total_records"=>LeaveAssign::count()]);
	}

	function find($data){
		echo json_encode(["leaveassign"=>LeaveAssign::find($data["id"])]);
	}

	function delete($data){
		LeaveAssign::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}

	function save($data,$file=[]){
		$leaveassign=new LeaveAssign();
		$leaveassign->emp_id=$data["emp_id"];
		$leaveassign->leave_type_id=$data["leave_type_id"];
		$leaveassign->allow_days=$data["allow_days"];
		$leaveassign->used_days=$data["used_days"];
		$leaveassign->year=$data["year"];
		// $leaveassign->created_at=$data["created_at"];
		// $leaveassign->updated_at=$data["updated_at"];

		$leaveassign->save();
		echo json_encode(["success" => "yes"]);
	}

	function update($data,$file=[]){
		$leaveassign=new LeaveAssign();
		$leaveassign->id=$data["id"];
		$leaveassign->emp_id=$data["emp_id"];
		$leaveassign->leave_type_id=$data["leave_type_id"];
		$leaveassign->allow_days=$data["allow_days"];
		$leaveassign->used_days=$data["used_days"];
		$leaveassign->year=$data["year"];
		// $leaveassign->created_at=$data["created_at"];
		// $leaveassign->updated_at=$data["updated_at"];

		$leaveassign->update();
		echo json_encode(["success" => "yes"]);
	}
}
?>
