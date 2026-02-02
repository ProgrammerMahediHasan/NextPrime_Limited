<?php
class DailyAttendanceApi{
	public function __construct(){
	}

	function index(){
		echo json_encode(["daily_attendance"=>DailyAttendance::all()]);
	}

	function dailyAttReport($data){
    
          $report_date= $data['report_date'] ;
          $id= isset($data['id']) ? $data['id']: null ;
		echo json_encode(["daily_attendance"=>DailyAttendance::dailyattendance($report_date, $id)]);
		// echo json_encode(["dailyattendance"=>$data]);
	}



	function monthlysummaryreport($data){
    $report_month = $data['report_month'] ?? null;
    $report_year  = $data['report_year'] ?? null;
    $id = isset($data['emp_id']) ? $data['emp_id'] : null;

    // month / year না থাকলে empty data দেবে
    if (!$report_month || !$report_year) {
        echo json_encode([
            "monthly_summary" => []
        ]);
        return;
    }

    echo json_encode([
        "monthly_summary" =>
            DailyAttendance::monthlysummaryreport($report_month, $report_year, $id)
    ]);
}










	// function pagination($data){
	// 	$page=$data["page"];
	// 	$perpage=$data["perpage"];
	// 	echo json_encode(["daily_attendance"=>DailyAttendance::pagination($page,$perpage),"total_records"=>DailyAttendance::count()]);
	// }

	function find($data){
		echo json_encode(["dailyattendance"=>DailyAttendance::find($data["id"])]);
	}

	function delete($data){
		DailyAttendance::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}

	function save($data,$file=[]){
		$dailyattendance=new DailyAttendance();
		$dailyattendance->emp_id=$data["emp_id"];
		$dailyattendance->att_date=$data["att_date"];
		$dailyattendance->day_type=$data["day_type"];
		$dailyattendance->in_time=$data["in_time"];
		$dailyattendance->out_time=$data["out_time"];
		$dailyattendance->total_work_minutes=$data["total_work_minutes"];
		$dailyattendance->late_minutes=$data["late_minutes"];
		$dailyattendance->status=$data["status"];
		$dailyattendance->overtime_minutes=$data["overtime_minutes"];
		$dailyattendance->remarks=$data["remarks"];

		$dailyattendance->save();
		echo json_encode(["success" => "yes"]);
	}
	
	function update($data,$file=[]){
		$dailyattendance=new DailyAttendance();
		$dailyattendance->id=$data["id"];
		$dailyattendance->emp_id=$data["emp_id"];
		$dailyattendance->att_date=$data["att_date"];
		$dailyattendance->day_type=$data["day_type"];
		$dailyattendance->in_time=$data["in_time"];
		$dailyattendance->out_time=$data["out_time"];
		$dailyattendance->total_work_minutes=$data["total_work_minutes"];
		$dailyattendance->late_minutes=$data["late_minutes"];
		$dailyattendance->status=$data["status"];
		$dailyattendance->overtime_minutes=$data["overtime_minutes"];
		$dailyattendance->remarks=$data["remarks"];

		$dailyattendance->update();
		echo json_encode(["success" => "yes"]);
	}
}
?>
