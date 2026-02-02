<?php
class DailyAttendance extends Model implements JsonSerializable
{
    public $id;
    public $emp_id;
    public $att_date;
    public $day_type;
    public $in_time;
    public $out_time;
    public $total_work_minutes;
    public $status;
    public $late_minutes;
    public $overtime_minutes;
    public $remarks;

    public function __construct() {}

    // ----------------- SAVE -----------------
    public function save()
    {
        global $db, $tx;

        $db->query("INSERT INTO {$tx}daily_attendance(emp_id,att_date,day_type,in_time,out_time,total_work_minutes,status,late_minutes,overtime_minutes,remarks)
        VALUES('" . intval($this->emp_id) . "',
               '" . $db->real_escape_string($this->att_date) . "',
               '" . $db->real_escape_string($this->day_type) . "',
               '" . $db->real_escape_string($this->in_time) . "',
               '" . $db->real_escape_string($this->out_time) . "',
               '" . floatval($this->total_work_minutes) . "',
               '" . $db->real_escape_string($this->status) . "',
               '" . floatval($this->late_minutes) . "',
               '" . floatval($this->overtime_minutes) . "',
               '" . $db->real_escape_string($this->remarks) . "')");
        return $db->insert_id;
    }

    // ----------------- UPDATE -----------------
    public function update()
    {
        global $db, $tx;

        $db->query("UPDATE {$tx}daily_attendance 
        SET emp_id='" . intval($this->emp_id) . "',
            att_date='" . $db->real_escape_string($this->att_date) . "',
            day_type='" . $db->real_escape_string($this->day_type) . "',
            in_time='" . $db->real_escape_string($this->in_time) . "',
            out_time='" . $db->real_escape_string($this->out_time) . "',
            total_work_minutes='" . floatval($this->total_work_minutes) . "',
            status='" . $db->real_escape_string($this->status) . "',
            late_minutes='" . floatval($this->late_minutes) . "',
            overtime_minutes='" . floatval($this->overtime_minutes) . "',
            remarks='" . $db->real_escape_string($this->remarks) . "'
        WHERE id='" . intval($this->id) . "'");
    }

    // ----------------- UPDATE OUT TIME -----------------
    public function update_out_time()
    {
        global $db, $tx;
        $att_date = $this->att_date ?? date("Y-m-d");

        // Fetch IN time
        $res = $db->query("SELECT in_time FROM {$tx}daily_attendance 
                           WHERE emp_id='" . intval($this->emp_id) . "' AND att_date='" . $db->real_escape_string($att_date) . "'");
        $in_time = $res->fetch_object()->in_time ?? null;

        if ($in_time && $this->out_time) {
            // Calculate total work minutes
            $total_minutes = max(0, (strtotime($this->out_time) - strtotime($in_time)) / 60);

            // Update OUT time, total work minutes, overtime
            $db->query("UPDATE {$tx}daily_attendance
                SET out_time='" . $db->real_escape_string($this->out_time) . "',
                    total_work_minutes='" . $total_minutes . "',
                    overtime_minutes='" . floatval($this->overtime_minutes) . "'
                WHERE emp_id='" . intval($this->emp_id) . "' AND att_date='" . $db->real_escape_string($att_date) . "'");
        }
    }

    // ----------------- DELETE -----------------
    public static function delete($id)
    {
        global $db, $tx;
        $db->query("DELETE FROM {$tx}daily_attendance WHERE id='" . intval($id) . "'");
    }

    // ----------------- FIND BY ID -----------------
    public static function find($id)
    {
        global $db, $tx;
        $result = $db->query("SELECT * FROM {$tx}daily_attendance WHERE id='" . intval($id) . "'");
        return $result->fetch_object();
    }

    // ----------------- FIND IN TIME BY EMPLOYEE -----------------
    public static function findInTime($emp_id)
    {
        global $db, $tx;
        $date = date("Y-m-d");
        $result = $db->query("SELECT * FROM {$tx}daily_attendance 
                              WHERE emp_id='" . intval($emp_id) . "' AND att_date='$date'");
        return $result->fetch_object();
    }

    // ----------------- ALL -----------------
    public static function all()
    {
        global $db, $tx;
        $result = $db->query("SELECT * FROM {$tx}daily_attendance ORDER BY att_date asc");
        $data = [];
        while ($row = $result->fetch_object()) $data[] = $row;
        return $data;
    }


    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }



public static function dailyattendance($report_date, $id = null)
{
    global $db, $tx;

    $report_date = $db->real_escape_string($report_date);

    $sql = "
        SELECT e.id AS emp_id, e.name AS emp_name, d.att_date, d.in_time, d.out_time,
               d.total_work_minutes, d.status, d.late_minutes, d.overtime_minutes
        FROM {$tx}employees e
        LEFT JOIN {$tx}daily_attendance d 
            ON e.id = d.emp_id AND d.att_date = '{$report_date}'
    ";

    if ($id) {
        $id = (int)$id; // avoid injection
        $sql .= " WHERE e.id = {$id}";
    }

    $sql .= " ORDER BY e.name ASC";

    $result = $db->query($sql);

    $data = [];
    while ($row = $result->fetch_object()) {
        $data[] = $row;
    }

    return $data;
}




    public static function monthlysummaryreport($report_month, $report_year, $emp_id = null)
    {
        global $db, $tx;

        $month = (int)$report_month;
        $year  = (int)$report_year;

        $sql = "
            SELECT 
                e.id AS emp_id,
                e.name AS emp_name,
                SUM(CASE WHEN LOWER(d.status)='present' THEN 1 ELSE 0 END) AS total_attendance,
                SUM(COALESCE(d.late_minutes,0)) AS total_late,
                SUM(COALESCE(d.overtime_minutes,0)) AS total_overtime,
                SUM(CASE WHEN LOWER(d.status)='absent' THEN 1 ELSE 0 END) AS total_absent,
                SUM(CASE WHEN LOWER(d.status)='leave' THEN 1 ELSE 0 END) AS total_leave
            FROM {$tx}employees e
            LEFT JOIN {$tx}daily_attendance d
                ON e.id = d.emp_id
                AND MONTH(d.att_date) = {$month}
                AND YEAR(d.att_date) = {$year}
        ";

        if ($emp_id) {
            $emp_id = (int)$emp_id;
            $sql .= " WHERE e.id = {$emp_id}";
        }

        $sql .= " GROUP BY e.id, e.name ORDER BY e.name ASC";

        $result = $db->query($sql);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }

        return $data;
    }



    // ----------------- HTML TABLE -----------------

public static function html_table($page = 1, $perpage = 5, $criteria = "", $action = true)
{
    global $db, $tx, $base_url;

    // Ensure integers
    $page = max(1, (int)$page);
    $perpage = max(1, (int)$perpage);

    // Total count
    $count_sql = "SELECT COUNT(*) as total 
                  FROM {$tx}daily_attendance da
                  LEFT JOIN {$tx}employees e ON da.emp_id = e.id
                  $criteria";

    $count_result = $db->query($count_sql);
    $total_records = ($count_result) ? ($count_result->fetch_object()->total ?? 0) : 0;

    // Total pages
    $total_pages = max(1, ceil($total_records / $perpage));
    if ($page > $total_pages) $page = $total_pages;

    // Offset
    $top = ($page - 1) * $perpage;

    // Fetch data with employee name
    $sql = "SELECT da.*, e.name AS employee_name
            FROM {$tx}daily_attendance da
            LEFT JOIN {$tx}employees e ON da.emp_id = e.id
            $criteria
            ORDER BY da.att_date DESC
            LIMIT $top, $perpage";

    $result = $db->query($sql);

    // Styles
    $html = "
    <style>
        .attendance-table { width:100%; border-collapse:collapse; font-family:'Poppins',sans-serif; margin-bottom:10px; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
        .attendance-table th, .attendance-table td { border:1px solid #d0d0d0; padding:10px; text-align:center; }
        .attendance-table th { background: linear-gradient(135deg, #163270e8, #253e85ff); color:#fff; font-weight:600; text-transform:uppercase; }
        .attendance-table tr:nth-child(even){ background:#f9faff; }
        .attendance-table tr:hover td { background:#eef5ff; transition:0.3s; }
        .btn-custom { padding:8px 20px; border-radius:6px; color:#fff; text-decoration:none; display:inline-block; font-weight:600; margin:5px 0; transition:all 0.3s ease; }
        .btn-success { background:linear-gradient(135deg,#198754,#157347); }
        .btn-group { display:flex; justify-content:center; gap:6px; }
        .btn-group button { padding:6px 10px; font-size:14px; border-radius:4px; border:none; cursor:pointer; color:#fff; font-weight:700; }
        .btn-primary { background:#0d6efd; }
        .btn-danger { background:#dc3545; }
        .pagination { display:flex; justify-content:center; gap:8px; margin-top:15px; }
        .pagination a { padding:6px 12px; border:1px solid #ccc; text-decoration:none; color:#333; background:#f9f9f9; border-radius:4px; }
        .pagination .active { background:#007bff; color:#fff; }
        .pagination .disabled { color:#aaa; pointer-events:none; }
    </style>
    ";

    // Table Start

     $html .= "<tr><th colspan='12'>" . 
                Html::link([
                    "class" => "btn btn-success btn-custom", 
                    "route" => "dailyattendance/create", 
                    "text"  => "Add Employee Attendance"
                ]) 
             . "</th></tr>";
    $html .= "<table class='attendance-table'>";
   

    $html .= "<tr>
            <th>Employee Name</th>
            <th>Attend Date</th>
            <th>Day Type</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Work Time</th>
            <th>Status</th>
            <th>Late Time</th>
            <th>OverTime</th>";

    if ($action) $html .= "<th>Action</th>";
    $html .= "</tr>";

    // Data Rows
    while ($row = $result->fetch_object()) {

        $att_date = $row->att_date ? date("d-M-Y", strtotime($row->att_date)) : "-";
       $in_time  = ($row->in_time && $row->in_time != "00:00:00") 
                ? date("h:i A", strtotime($row->in_time)) 
                : "00:00:00";

$out_time = ($row->out_time && $row->out_time != "00:00:00") 
                ? date("h:i A", strtotime($row->out_time)) 
                : "00:00:00";


        $html .= "<tr>
                <td>{$row->employee_name}</td>
                <td>{$att_date}</td>
                <td>{$row->day_type}</td>
                <td>{$in_time}</td>
                <td>{$out_time}</td>
                <td>{$row->total_work_minutes}</td>
                <td>{$row->status}</td>
                <td>{$row->late_minutes}</td>
                <td>{$row->overtime_minutes}</td>";

        if ($action) {
            $html .= "<td>
                        <div class='btn-group'>
                            <button class='btn-primary' onclick=\"location.href='{$base_url}/dailyattendance/edit/{$row->id}'\">
                                <i class='fas fa-edit'></i>
                            </button>
                            <button class='btn-danger' onclick=\"if(confirm('Are you sure?')) location.href='{$base_url}/dailyattendance/confirm/{$row->id}'\">
                                <i class='fas fa-trash-alt'></i>
                            </button>
                        </div>
                      </td>";
        }

        $html .= "</tr>";
    }

    $html .= "</table>";

    // Pagination
    if ($total_pages > 1) {
        $html .= "<div class='pagination'>";

        // Prev
        $html .= ($page > 1) 
            ? "<a href='?page=".($page - 1)."'>« Prev</a>"
            : "<a class='disabled'>« Prev</a>";

        // Number Links
        for ($i = 1; $i <= $total_pages; $i++) {
            $html .= ($i == $page)
                ? "<a class='active'>{$i}</a>"
                : "<a href='?page={$i}'>{$i}</a>";
        }

        // Next
        $html .= ($page < $total_pages)
            ? "<a href='?page=".($page + 1)."'>Next »</a>"
            : "<a class='disabled'>Next »</a>";

        $html .= "</div>";
    }

    return $html;
}






    public static function html_row_details($id)
    {
        global $db, $tx;
        $result = $db->query("SELECT * FROM {$tx}daily_attendance WHERE id='" . intval($id) . "'");
        $row = $result->fetch_object();
        $html = "<table class='table table-bordered'>";
        foreach ($row as $key => $val) {
            $html .= "<tr><th>$key</th><td>$val</td></tr>";
        }
        $html .= "</table>";
        return $html;
    }
}
