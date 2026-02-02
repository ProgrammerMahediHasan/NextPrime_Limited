<?php
class AttendanceLogApi{
	public function __construct(){
	}
	function index(){
		echo json_encode(["attendance_logs"=>AttendanceLog::all()]);
	}
	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["attendance_logs"=>AttendanceLog::pagination($page,$perpage),"total_records"=>AttendanceLog::count()]);
	}
	function find($data){
		echo json_encode(["attendancelog"=>AttendanceLog::find($data["id"])]);
	}
	function delete($data){
		AttendanceLog::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}
	function save($data,$file=[]){
		$attendancelog=new AttendanceLog();
		$attendancelog->source=$data["source"];
		$attendancelog->in_time=$data["in_time"];
		$attendancelog->out_time=$data["out_time"];
		$attendancelog->status=$data["status"];
		$attendancelog->grace_time=$data["grace_time"];
		$attendancelog->late_time=$data["late_time"];
		$attendancelog->total_work_minutes=$data["total_work_minutes"];
		$attendancelog->remarks=$data["remarks"];

		$attendancelog->save();
		echo json_encode(["success" => "yes"]);
	}
	function update($data,$file=[]){
		$attendancelog=new AttendanceLog();
		$attendancelog->id=$data["id"];
		$attendancelog->source=$data["source"];
		$attendancelog->in_time=$data["in_time"];
		$attendancelog->out_time=$data["out_time"];
		$attendancelog->status=$data["status"];
		$attendancelog->grace_time=$data["grace_time"];
		$attendancelog->late_time=$data["late_time"];
		$attendancelog->total_work_minutes=$data["total_work_minutes"];
		$attendancelog->remarks=$data["remarks"];

		$attendancelog->update();
		echo json_encode(["success" => "yes"]);
	}
}
?>
