<?php
class AttendanceLog extends Model implements JsonSerializable {
    public $id;
    public $source;
    public $in_time;
    public $out_time;
    public $status;
    public $grace_time;
    public $late_time;
    public $total_work_minutes;
    public $remarks;

    // Dropdown options
    public static $source_options = ["Manual","Biometric","Web"];
    public static $status_options = ["Working","Weekend","Holiday"];

    public function __construct(){}

    public function set($source,$in_time,$out_time,$status,$grace_time,$late_time,$total_work_minutes,$remarks,$id=null){
        $this->source=$source;
        $this->in_time=$in_time;
        $this->out_time=$out_time;
        $this->status=$status;
        $this->grace_time=$grace_time;
        $this->late_time=$late_time;
        $this->total_work_minutes=$total_work_minutes;
        $this->remarks=$remarks;
        $this->id=$id;
    }

    public function save(){
        global $db,$tx;
        $db->query("INSERT INTO {$tx}attendance_logs(source,in_time,out_time,status,grace_time,late_time,total_work_minutes,remarks)
            VALUES('$this->source','$this->in_time','$this->out_time','$this->status','$this->grace_time','$this->late_time','$this->total_work_minutes','$this->remarks')");
        return $db->insert_id;
    }

    public function update(){
        global $db,$tx;
        $db->query("UPDATE {$tx}attendance_logs SET
            source='$this->source',
            in_time='$this->in_time',
            out_time='$this->out_time',
            status='$this->status',
            grace_time='$this->grace_time',
            late_time='$this->late_time',
            total_work_minutes='$this->total_work_minutes',
            remarks='$this->remarks'
            WHERE id='$this->id'");
    }

    public static function delete($id){
        global $db,$tx;
        $db->query("DELETE FROM {$tx}attendance_logs WHERE id='$id'");
    }

    public function jsonSerialize():mixed{
        return get_object_vars($this);
    }

    public static function all(){
        global $db,$tx;
        $result = $db->query("SELECT * FROM {$tx}attendance_logs");
        $data = [];
        while($row = $result->fetch_object()){
            $data[] = $row;
        }
        return $data;
    }

    public static function find($id){
        global $db,$tx;
        $result = $db->query("SELECT * FROM {$tx}attendance_logs WHERE id='$id'");
        return $result->fetch_object();
    }

    // ==================== HTML Dropdown ====================

    public static function html_select($name="source",$selected=null){
        $html="<select id='$name' name='$name' class='form-control'>";
        foreach(self::$source_options as $option){
            $sel = ($option==$selected) ? "selected" : "";
            $html.="<option value='$option' $sel>$option</option>";
        }
        $html.="</select>";
        return $html;
    }

    public static function html_status_select($name="status",$selected=null){
        $html="<select id='$name' name='$name' class='form-control'>";
        foreach(self::$status_options as $option){
            $sel = ($option==$selected) ? "selected" : "";
            $html.="<option value='$option' $sel>$option</option>";
        }
        $html.="</select>";
        return $html;
    }

    // ==================== HTML Table ====================

   public static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true)
{
    global $db, $tx, $base_url;

    $top = ($page - 1) * $perpage;
    $result = $db->query("SELECT * FROM {$tx}attendance_logs $criteria LIMIT $top, $perpage");

    // === Professional Table Styling ===
    $html = "<style>
    .table-responsive {
        overflow-x: auto;
        margin-top: 20px;
        font-family: 'Poppins', sans-serif;
    }
    .table-responsive table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .table-responsive th, .table-responsive td {
        border: 1px solid #d1d5db;
        padding: 10px 12px;
        text-align: center;
        font-size: 13px;
        word-wrap: break-word;
    }
    .table-responsive th {
        background: linear-gradient(135deg, #163270e8, #253e85ff);
        color: #f5f5f5;
        font-weight: 600;
    }
    .table-responsive tr:hover {
        background-color: #f1f5f9;
        transition: 0.2s;
    }


    .btn-group {
    display: flex !important;
    justify-content: center;
    gap: 6px; /* হালকা gap */
    flex-wrap: nowrap;
}

.btn-group {
    display: flex !important;
    justify-content: center;
    gap: 6px; /* হালকা gap */
    flex-wrap: nowrap;
}

.btn-group button {
    padding: 6px 10px !important; /* একটু বড় padding */
    font-size: 14px !important;   /* icon বড় দেখানোর জন্য */
    border-radius: 4px;
    border: 2px solid #000;       /* গাঢ় black border */
    outline: none;
    cursor: pointer;
    color: #fff;
    font-weight: 700;              /* icon/text bold */
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-group i {
    font-weight: 900; /* icon আরও bold */
}


.btn-group button:focus {
    outline: none;
    border: 1px solid rgba(0,0,0,0.3);
    box-shadow: none;
}


    .btn-primary { background: #3b82f6; }
    .btn-danger { background: #ef4444; }
    @media (max-width: 768px) {
        .table-responsive th, .table-responsive td {
            font-size: 12px;
            padding: 6px 8px;
        }
        .btn-group button {
            font-size: 10px;
            padding: 3px 6px;
        }
    }
    </style>";
  // New Attendance Log Button
    $html .= "<tr><th colspan='" . ($action ? 9 : 8) . "' style='text-align:left;'>" 
           . Html::link(["class" => "btn btn-success", "route" => "attendancelog/create", "text" => "+ Add AttendanceLog"]) 
           . "</th></tr>";
    $html .= "<div class='table-responsive'>";
    $html .= "<table class='table table-bordered table-striped table-hover' style='table-layout: fixed;'>";

  

    // Table Headers
    $html .= "<tr>
                <th>Attendance Type</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Status</th>
                <th>Grace Time</th>
                <th>Late Time</th>
                <th>Total Work Minutes</th>
                <th>Remarks</th>";
    if ($action) $html .= "<th>Action</th>";
    $html .= "</tr>";

    // Table Rows
    while ($row = $result->fetch_object()) {
        $action_buttons = "";
        if ($action) {
            $action_buttons = "<td style='white-space: nowrap;'>
                        <div class='btn-group'>
                            <button class='btn-primary' onclick=\"location.href='{$base_url}/attendancelog/edit/$row->id'\"><i class='fas fa-edit'></i></button>
                            <button class='btn-danger' onclick=\"if(confirm('Are you sure?')) location.href='{$base_url}/attendancelog/confirm/$row->id'\"><i class='fas fa-trash-alt'></i></button>
                        </div>
                      </td>";
        }

        $html .= "<tr>
                    <td>$row->source</td>
                    <td>$row->in_time</td>
                    <td>$row->out_time</td>
                    <td>$row->status</td>
                    <td>$row->grace_time</td>
                    <td>$row->late_time</td>
                    <td>$row->total_work_minutes</td>
                    <td>$row->remarks</td>
                    $action_buttons
                  </tr>";
    }

    $html .= "</table>";
    $html .= "</div>";

    // Optional: Add pagination if needed
    //$html .= "<div style='margin-top:15px; text-align:center;'>" . pagination($page, $total_pages) . "</div>";

    return $html;
}



    public static function html_row_details($id){
        global $db,$tx;
        $row = self::find($id);

        $html="<table class='table table-bordered'>";
        $html.="<tr><th colspan='2'>AttendanceLog Details</th></tr>";
        $html.="<tr><th>Source</th><td>$row->source</td></tr>";
        $html.="<tr><th>In Time</th><td>$row->in_time</td></tr>";
        $html.="<tr><th>Out Time</th><td>$row->out_time</td></tr>";
        $html.="<tr><th>Status</th><td>$row->status</td></tr>";
        $html.="<tr><th>Grace Time</th><td>$row->grace_time</td></tr>";
        $html.="<tr><th>Late Time</th><td>$row->late_time</td></tr>";
        $html.="<tr><th>Total Work Minutes</th><td>$row->total_work_minutes</td></tr>";
        $html.="<tr><th>Remarks</th><td>$row->remarks</td></tr>";
        $html.="</table>";
        return $html;
    }
}
?>
