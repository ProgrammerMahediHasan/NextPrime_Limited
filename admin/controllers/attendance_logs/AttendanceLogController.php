<?php
class AttendanceLogController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("attendance_logs");
	}
	public function create(){
		view("attendance_logs");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];

		if(count($errors)==0){
			$attendancelog=new AttendanceLog();
		// $attendancelog->id=$data["id"];	
		$attendancelog->source=$data["source"];
		$attendancelog->in_time=$data["in_time"];
		$attendancelog->out_time=$data["out_time"];
		$attendancelog->status=$data["status"];
		$attendancelog->grace_time=$data["grace_time"];
		$attendancelog->late_time=$data["late_time"];
		$attendancelog->total_work_minutes=$data["total_work_minutes"];
		$attendancelog->remarks=$data["remarks"];

			$attendancelog->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("attendance_logs",AttendanceLog::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];

		if(count($errors)==0){
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
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("attendance_logs");
	}
	public function delete($id){
		AttendanceLog::delete($id);
		redirect();
	}
	public function show($id){
		view("attendance_logs",AttendanceLog::find($id));
	}
}
?>
