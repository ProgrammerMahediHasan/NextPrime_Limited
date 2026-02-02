<?php
class LeaveRequest extends Model implements JsonSerializable {
    public $id;
    public $emp_id;
    public $leave_id;
    public $start_date;
    public $end_date;
    public $total_days;
    public $reason;
    public $status;
    public $approver_id;
    public $applied_on;

    public function __construct(){}

    // Set values
    public function set($id, $emp_id, $leave_id, $start_date, $end_date, $total_days, $reason, $status, $approver_id, $applied_on){
        $this->id = $id;
        $this->emp_id = $emp_id;
        $this->leave_id = $leave_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->total_days = $total_days;
        $this->reason = $reason;
        $this->status = $status;
        $this->approver_id = $approver_id;
        $this->applied_on = $applied_on;
    }

    // ==================== CRUD ====================

    public function save(){
        global $db,$tx;
        $emp_id = intval($this->emp_id);
        $leave_id = intval($this->leave_id);
        $start_date = $db->real_escape_string($this->start_date);
        $end_date = $db->real_escape_string($this->end_date);
        $total_days = intval($this->total_days);
        $reason = $db->real_escape_string($this->reason);
        $status = $db->real_escape_string($this->status);
        $approver_id = intval($this->approver_id);
        $applied_on = $db->real_escape_string($this->applied_on);

        $db->query("INSERT INTO {$tx}leave_request(emp_id, leave_id, start_date, end_date, total_days, reason, status, approver_id, applied_on)
            VALUES('$emp_id','$leave_id','$start_date','$end_date','$total_days','$reason','$status','$approver_id','$applied_on')");

        $last_id = $db->insert_id;

        if(strtolower($this->status) == 'approved'){
            self::updateLeaveAssignUsedDays($this->emp_id, $this->leave_id);
        }

        return $last_id;
    }

    public function update(){
        global $db,$tx;
        $id = intval($this->id);
        $emp_id = intval($this->emp_id);
        $leave_id = intval($this->leave_id);
        $start_date = $db->real_escape_string($this->start_date);
        $end_date = $db->real_escape_string($this->end_date);
        $total_days = intval($this->total_days);
        $reason = $db->real_escape_string($this->reason);
        $status = $db->real_escape_string($this->status);
        $approver_id = intval($this->approver_id);
        $applied_on = $db->real_escape_string($this->applied_on);

        $db->query("UPDATE {$tx}leave_request SET 
            emp_id='$emp_id',
            leave_id='$leave_id',
            start_date='$start_date',
            end_date='$end_date',
            total_days='$total_days',
            reason='$reason',
            status='$status',
            approver_id='$approver_id',
            applied_on='$applied_on'
            WHERE id='$id'");

        if(strtolower($this->status) == 'approved'){
            self::updateLeaveAssignUsedDays($this->emp_id, $this->leave_id);
        }
    }

    public static function delete($id){
        global $db,$tx;
        $id = intval($id);
        $db->query("DELETE FROM {$tx}leave_request WHERE id=$id");
    }

    // ==================== Find Methods ====================

    // Basic find by ID
    public static function find($id){
        global $db,$tx;
        $id = intval($id);
        $result = $db->query("SELECT * FROM {$tx}leave_request WHERE id='$id' LIMIT 1");
        return $result->fetch_object();
    }

    // Find with employee name & leave type name
    public static function findWithDetails($id){
        global $db,$tx;
        $id = intval($id);
        $result = $db->query("
            SELECT lr.*, e.name AS employee_name, lt.name AS leave_type_name
            FROM {$tx}leave_request lr
            LEFT JOIN {$tx}employees e ON e.id = lr.emp_id
            LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
            WHERE lr.id='$id'
            LIMIT 1
        ");
        return $result->fetch_object();
    }

    // ==================== JSON ====================

    public function json(){
        return json_encode($this);
    }

    public function jsonSerialize(): mixed{
        return get_object_vars($this);
    }

    // ==================== HTML Helpers ====================

    static function html_status_dropdown($name="status", $selected=null){
        $options = ["Pending"=>"Pending", "Approved"=>"Approved", "Rejected"=>"Rejected"];
        $html = "<select id='$name' name='$name' class='form-control'>";
        $html .= "<option value=''>Select Status</option>";
        foreach($options as $value => $label){
            $sel = ($selected == $value) ? "selected" : "";
            $html .= "<option value='$value' $sel>$label</option>";
        }
        $html .= "</select>";
        return $html;
    }

    // LeaveRequest table
    static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true){
        global $db, $tx, $base_url;

        $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}leave_request lr
            LEFT JOIN {$tx}employees e ON e.id = lr.emp_id
            LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
            $criteria");
        list($total_rows) = $count_result->fetch_row();
        $total_pages = ceil($total_rows / $perpage);
        $top = ($page - 1) * $perpage;

        $result = $db->query("SELECT
                lr.id,
                e.name AS employee_name,
                lt.name AS leave_type_name,
                lr.start_date,
                lr.end_date,
                lr.total_days,
                lr.reason,
                lr.status,
                lr.approver_id,
                lr.applied_on
            FROM {$tx}leave_request lr
            LEFT JOIN {$tx}employees e ON e.id = lr.emp_id
            LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
            $criteria
            LIMIT $top,$perpage");

        $html = "<style>
            .table-responsive{overflow-x:auto;}
            .table-responsive table{width:100%;border-collapse:collapse;}
            .table-responsive th{background:#1f3d79;color:#fff;padding:8px;text-align:center;}
            .table-responsive td{padding:6px;text-align:center;border:1px solid #000;}
            .btn-group{display:flex;justify-content:center;gap:6px;}
            .btn-primary{background:#3b82f6;color:#fff;border:none;padding:6px 10px;cursor:pointer;}
            .btn-danger{background:#ef4444;color:#fff;border:none;padding:6px 10px;cursor:pointer;}
        </style>";

        $html .= "<div style='margin-bottom:10px;'><button onclick=\"location.href='{$base_url}/leaverequest/create'\" class='btn btn-success'>+ Add Leave Request</button></div>";
        $html .= "<div class='table-responsive'><table class='table'>";
        $html .= "<tr>
                    <th>Employee</th><th>Leave Type</th><th>Start</th><th>End</th><th>Total Days</th><th>Reason</th><th>Status</th><th>Approver</th>";
        if($action) $html .= "<th>Action</th>";
        $html .= "</tr>";

        while($lr = $result->fetch_object()){
            $actions = "";
            if($action){
                $actions = "<td>
                    <div class='btn-group'>
                        <button class='btn-primary' onclick=\"location.href='{$base_url}/leaverequest/edit/$lr->id'\"><i class='fas fa-edit'></i></button>
                        <button class='btn-danger' onclick=\"if(confirm('Are you sure to delete this Leave Request?')) location.href='{$base_url}/leaverequest/delete/$lr->id'\"><i class='fas fa-trash-alt'></i></button>
                    </div>
                </td>";
            }
            $html .= "<tr>
                <td>$lr->employee_name</td>
                <td>$lr->leave_type_name</td>
                <td>$lr->start_date</td>
                <td>$lr->end_date</td>
                <td>$lr->total_days</td>
                <td>$lr->reason</td>
                <td>$lr->status</td>
                <td>$lr->approver_id</td>
                $actions
            </tr>";
        }

        $html .= "</table></div>";
        return $html;
    }

    // Update used_days in leave_assign
    public static function updateLeaveAssignUsedDays($emp_id, $leave_id){
        global $db,$tx;
        $result = $db->query("SELECT SUM(total_days) as total_used 
            FROM {$tx}leave_request 
            WHERE emp_id='$emp_id' AND leave_id='$leave_id' AND status='Approved'");
        $row = $result->fetch_object();
        $total_used = $row->total_used ?? 0;
        $db->query("UPDATE {$tx}leave_assign SET used_days='$total_used' WHERE emp_id='$emp_id' AND leave_type_id='$leave_id'");
    }
}
?>
