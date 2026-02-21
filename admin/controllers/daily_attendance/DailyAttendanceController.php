<?php
class DailyAttendanceController extends Controller
{
    public function __construct() {}

    private function isHoliday($date){
        $list = [
            "2026-02-21","2026-03-26","2026-04-14","2026-05-01","2026-08-15","2026-12-16","2026-12-25"
        ];
        return in_array($date, $list, true);
    }

    private function computeRule($att_date, $in_time){
        date_default_timezone_set('Asia/Dhaka');
        $scheduled = "09:00:00";
        $grace     = "09:10:00";
        $absentAt  = "10:00:00";
        $isec = strtotime($in_time);
        $ssec = strtotime($scheduled);
        $gsec = strtotime($grace);
        $asec = strtotime($absentAt);
        if($isec <= $gsec){ return ["Present", 0]; }
        if($isec <= $asec){ return ["Present", max(0, intdiv(($isec - $ssec), 60))]; }
        return ["Absent", 0];
    }
    // Show attendance index
    public function index() { view("daily_attendance"); }

    // Show create attendance page (Employee IN)
    public function create() { view("daily_attendance"); }

    // Show out attendance page (Employee OUT)
    public function out() { view("daily_attendance"); }

   // Save Employee IN
public function save() {
    global $db, $tx;

    if (!isset($_POST['attendance'])) {
        echo "<div class='alert alert-warning text-center'>No employee selected!</div>";
        return;
    }

    // Timezone fix (very important)
    date_default_timezone_set('Asia/Dhaka');

    $att_date = $_POST['att_date'];
    $current_time = date('H:i:s');

    // Attendance rules
    $scheduled_time = "09:00:00";  // Office start time
    $grace_time     = "09:10:00";  // Grace ends at 9:10
    $absent_time    = "10:00:00";  // Late allowed up to 10:00; after 10:00 -> Absent

    // Determine day type
    $day_name = date('l', strtotime($att_date)); // Monday, Tuesday, etc.
    
    // Debug check (optional)
    // echo "$att_date => $day_name"; exit;

        if ($this->isHoliday($att_date)) { $day_type = "Holiday"; }
        else if ($day_name == "Friday") { $day_type = "Weekend"; }
        else { $day_type = "Working"; }

    foreach($_POST['attendance'] as $emp_id => $row) {
        if(isset($row['p'])) {
            list($status,$late_minutes) = $this->computeRule($att_date, $current_time);

            // Check if record exists
            $check = $db->query("SELECT id FROM {$tx}daily_attendance 
                                 WHERE emp_id='$emp_id' AND att_date='$att_date'");

            if($check->num_rows == 0){
                $db->query("INSERT INTO {$tx}daily_attendance 
                            (emp_id, att_date, in_time, status, late_minutes, day_type)
                            VALUES ('$emp_id','$att_date','$current_time','$status','$late_minutes','$day_type')");
            } else {
                $db->query("UPDATE {$tx}daily_attendance 
                            SET in_time='$current_time', status='$status', late_minutes='$late_minutes', day_type='$day_type'
                            WHERE emp_id='$emp_id' AND att_date='$att_date'");
            }
        }
    }

    echo "<div class='alert alert-success text-center mt-3'>Attendance saved successfully!</div>";
}


    // Save Employee OUT
   
   
    public function outtimesave() {
    global $db, $tx;

    if (!isset($_POST['attendance'])) {
        echo "<div class='alert alert-warning text-center'>No employee selected!</div>";
        return;
    }

    $att_date = $_POST['att_date'];
    $current_time = date('H:i:s'); // OUT time
    $scheduled_in = "09:00:00";    // Scheduled in time
    $scheduled_out = "17:30:00";   // Scheduled out time

    foreach($_POST['attendance'] as $emp_id => $row) {
        if(isset($row['p'])) {
            // Fetch IN time
            $res = $db->query("SELECT in_time FROM {$tx}daily_attendance WHERE emp_id='$emp_id' AND att_date='$att_date'");
            $data = $res->fetch_object();

            if($data && $data->in_time) {
                $in_time = $data->in_time;

                // Calculate total work minutes
                $total_minutes = max(0,(strtotime($current_time) - strtotime($in_time))/60);

                list($statusNow,$late_minutes) = $this->computeRule($att_date, $in_time);

                // Calculate overtime minutes
                $overtime_minutes = max(0,(strtotime($current_time) - strtotime($scheduled_out))/60);

                // Update attendance (also align status from rule)
                $db->query("UPDATE {$tx}daily_attendance
                            SET out_time='$current_time',
                                total_work_minutes='$total_minutes',
                                status='$statusNow',
                                late_minutes='$late_minutes',
                                overtime_minutes='$overtime_minutes'
                            WHERE emp_id='$emp_id' AND att_date='$att_date'");
            }
        }
    }

    echo "<div class='alert alert-success text-center mt-3'>OUT time, total work, late & overtime saved!</div>";
    global $base_url;
    echo '<a href="' . $base_url . '/DailyAttendance/">back</a>';

}



    // Edit attendance
    public function edit($id) { view("daily_attendance", DailyAttendance::find($id)); }

    // Update attendance
    public function update($data, $file) {
        if (isset($data["update"])) {
            $errors = [];
            if(count($errors) == 0){
                $dailyattendance = new DailyAttendance();
                $dailyattendance->id = $data["id"];
                $dailyattendance->emp_id = $data["emp_id"];
                $dailyattendance->att_date = $data["att_date"];
                $dailyattendance->day_type = $data["day_type"];
                $dailyattendance->in_time = $data["in_time"];
                $dailyattendance->out_time = $data["out_time"];
                $dailyattendance->total_work_minutes = $data["total_work_minutes"];
                $dailyattendance->status = $data["status"];
                $dailyattendance->late_minutes = $data["late_minutes"];
                $dailyattendance->overtime_minutes = $data["overtime_minutes"];
                $dailyattendance->remarks = $data["remarks"];
                $dailyattendance->update();
                redirect();
            } else {
                print_r($errors);
            }
        }
    }

    // Attendance report
    public function report() {
        global $db, $tx;

        $employee_id = $_GET['emp_id'] ?? '';
        $from_date = $_GET['from_date'] ?? '';
        $to_date = $_GET['to_date'] ?? '';

        $criteria = "WHERE 1=1";
        if($employee_id != '') $criteria .= " AND emp_id='$employee_id'";
        if($from_date != '') $criteria .= " AND att_date >= '$from_date'";
        if($to_date != '') $criteria .= " AND att_date <= '$to_date'";

        $page = $_GET['page'] ?? 1;
        view("daily_attendance_report", [
            "page"=>$page,
            "criteria"=>$criteria,
            "emp_id"=>$employee_id,
            "from_date"=>$from_date,
            "to_date"=>$to_date
        ]);
    }



  // ============================================
    // MONTHLY SUMMARY
    // ============================================

  public function monthlysummaryreport($data) {

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $report_month = $data['report_month'] ?? null;
    $report_year  = $data['report_year'] ?? null;
    $emp_id       = !empty($data['emp_id']) ? (int)$data['emp_id'] : null;

    if (!$report_month || !$report_year) {
        echo json_encode([
            "status" => false,
            "message" => "Month and Year are required",
            "monthly_summary" => []
        ]);
        return;
    }

    $summary = DailyAttendance::monthlysummaryreport(
        $report_month,
        $report_year,
        $emp_id
    );

    echo json_encode([
        "status" => true,
        "monthly_summary" => $summary
    ]);
}



    // ============================================
    // CONFIRM
    // ============================================
    public function confirm($id) {
        view("daily_attendance");
    }


    // ============================================
    // DELETE
    // ============================================
    public function delete($id) {
        DailyAttendance::delete($id);
        redirect();
    }


    // ============================================
    // SHOW SINGLE RECORD
    // ============================================
    public function show($id) {
        view("daily_attendance", DailyAttendance::find($id));
    }

} // <-- END OF CLASS (Only ONE closing brace!)
?>
