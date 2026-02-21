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

        $year = intval(date("Y", strtotime($this->start_date)));
        self::updateLeaveAssignUsedDays($this->emp_id, $this->leave_id, $year);

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

        $year = intval(date("Y", strtotime($this->start_date)));
        self::updateLeaveAssignUsedDays($this->emp_id, $this->leave_id, $year);
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
        $html = "<select id='$name' name='$name' class='form-select' style='width:100%'>";
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
                u.name AS approver_name,
                lr.applied_on
            FROM {$tx}leave_request lr
            LEFT JOIN {$tx}employees e ON e.id = lr.emp_id
            LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
            LEFT JOIN {$tx}users u ON u.id = lr.approver_id
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

        $html .= "<div style='margin-bottom:10px; display:flex; gap:8px; align-items:center;'>
            <button onclick=\"location.href='{$base_url}/leaverequest/create'\" class='btn btn-success'>+ Add Leave Request</button>
        </div>";
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
                        <button class='btn-primary' title='View' onclick=\"location.href='{$base_url}/leaverequest/show/$lr->id'\"><i class='fas fa-eye'></i></button>
                        <button class='btn-primary' title='Edit' onclick=\"location.href='{$base_url}/leaverequest/edit/$lr->id'\"><i class='fas fa-edit'></i></button>
                        <button class='btn-success' title='Approve' onclick=\"location.href='{$base_url}/leaverequest/approve/$lr->id'\"><i class='fas fa-check'></i></button>
                        <button class='btn-warning' title='Reject' onclick=\"location.href='{$base_url}/leaverequest/reject/$lr->id'\"><i class='fas fa-times'></i></button>
                        <button class='btn-danger' title='Delete' onclick=\"if(confirm('Are you sure to delete this Leave Request?')) location.href='{$base_url}/leaverequest/delete/$lr->id'\"><i class='fas fa-trash-alt'></i></button>
                    </div>
                </td>";
            }
            $statusBadge = "<span style='padding:4px 8px;border-radius:12px;color:#fff;font-size:12px;"
                .(strtolower($lr->status)=='approved'?"background:#16a34a;":(strtolower($lr->status)=='rejected'?"background:#dc2626;":"background:#2563eb;"))
                ."'>".$lr->status."</span>";
            $html .= "<tr>
                <td>$lr->employee_name</td>
                <td>$lr->leave_type_name</td>
                <td>$lr->start_date</td>
                <td>$lr->end_date</td>
                <td>$lr->total_days</td>
                <td>$lr->reason</td>
                <td>$statusBadge</td>
                <td>".($lr->approver_name ?: "-")."</td>
                $actions
            </tr>";
        }

        $html .= "</table></div>";
        return $html;
    }

    // Update used_days in leave_assign for a specific year
    public static function updateLeaveAssignUsedDays($emp_id, $leave_id, $year = null){
        global $db,$tx;
        $emp_id = intval($emp_id);
        $leave_id = intval($leave_id);
        if ($year === null) {
            $yrq = $db->query("SELECT year FROM {$tx}leave_assign WHERE emp_id={$emp_id} AND leave_type_id={$leave_id} ORDER BY id DESC LIMIT 1");
            $yrrow = $yrq ? $yrq->fetch_object() : null;
            $year = intval($yrrow->year ?? date("Y"));
        } else {
            $year = intval($year);
        }
        $result = $db->query("
            SELECT SUM(total_days) as total_used 
            FROM {$tx}leave_request 
            WHERE emp_id={$emp_id} 
              AND leave_id={$leave_id} 
              AND status='Approved'
              AND YEAR(start_date) = {$year}
        ");
        $row = $result->fetch_object();
        $total_used = $row->total_used ?? 0;
        $db->query("
            UPDATE {$tx}leave_assign 
            SET used_days={$total_used} 
            WHERE emp_id={$emp_id} 
              AND leave_type_id={$leave_id}
              AND year={$year}
        ");
    }
    
    public static function html_row_details($id){
        global $db,$tx;
        $id = intval($id);
        $result = $db->query("
            SELECT lr.*, e.name AS employee_name, lt.name AS leave_type_name, u.name AS approver_name
            FROM {$tx}leave_request lr
            LEFT JOIN {$tx}employees e ON e.id = lr.emp_id
            LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
            LEFT JOIN {$tx}users u ON u.id = lr.approver_id
            WHERE lr.id = {$id}
            LIMIT 1
        ");
        if(!$result || $result->num_rows == 0){
            return "<div style='text-align:center;color:red;'>No data found</div>";
        }
        $lr = $result->fetch_object();
        $html = "<style>
            .details-table { max-width: 700px; margin: 15px auto; border-collapse: collapse; font-family: 'Poppins', sans-serif; }
            .details-table th, .details-table td { padding: 10px 12px; border: 1px solid #e2e8f0; text-align: left; }
            .details-table th { background: #1f3d79; color: #fff; font-weight: 600; width: 30%; }
            .details-table tr:nth-child(even) { background: #f9fafb; }
        </style>";
        $html .= "<table class='details-table'>";
        $html .= "<tr><th>Employee</th><td>".htmlspecialchars($lr->employee_name ?: "-")."</td></tr>";
        $html .= "<tr><th>Leave Type</th><td>".htmlspecialchars($lr->leave_type_name ?: "-")."</td></tr>";
        $html .= "<tr><th>Start Date</th><td>".htmlspecialchars($lr->start_date ?: "-")."</td></tr>";
        $html .= "<tr><th>End Date</th><td>".htmlspecialchars($lr->end_date ?: "-")."</td></tr>";
        $html .= "<tr><th>Total Days</th><td>".htmlspecialchars($lr->total_days ?: "-")."</td></tr>";
        $html .= "<tr><th>Reason</th><td>".htmlspecialchars($lr->reason ?: "-")."</td></tr>";
        $html .= "<tr><th>Status</th><td>".htmlspecialchars($lr->status ?: "-")."</td></tr>";
        $html .= "<tr><th>Approver</th><td>".htmlspecialchars($lr->approver_name ?: "-")."</td></tr>";
        $html .= "<tr><th>Applied On</th><td>".htmlspecialchars($lr->applied_on ?: "-")."</td></tr>";
        $html .= "</table>";
        return $html;
    }
}
?>
