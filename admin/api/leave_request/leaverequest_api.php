<?php
class LeaveRequestApi {
    public function __construct() {
    }

    // LeaveRequest index - include employee name & leave name
    function index() {
        $leave_requests = LeaveRequest::all();
        $modified = [];

        foreach($leave_requests as $lr) {
            // Employee Name & Leave Name যোগ করা
            $lr->emp_name = Employee::find($lr->emp_id)->name ?? "Unknown";
            $lr->leave_name = LeaveType::find($lr->leave_id)->name ?? "Unknown";
            $modified[] = $lr;
        }

        echo json_encode(["leave_request" => $modified]);
    }

    function pagination($data) {
        $page = $data["page"];
        $perpage = $data["perpage"];
        echo json_encode([
            "leave_request" => LeaveRequest::pagination($page, $perpage),
            "total_records" => LeaveRequest::count()
        ]);
    }

    function find($data) {
        $lr = LeaveRequest::find($data["id"]);
        if($lr) {
            $lr->emp_name = Employee::find($lr->emp_id)->name ?? "Unknown";
            $lr->leave_name = LeaveType::find($lr->leave_id)->name ?? "Unknown";
        }
        echo json_encode(["leaverequest" => $lr]);
    }

    function delete($data) {
        LeaveRequest::delete($data["id"]);
        echo json_encode(["success" => "yes"]);
    }

    function save($data, $file = []) {
        $leaverequest = new LeaveRequest();
        $leaverequest->leave_id = $data["leave_id"];
        $leaverequest->emp_id = $data["emp_id"];
        $leaverequest->start_date = $data["start_date"];
        $leaverequest->end_date = $data["end_date"];
        $leaverequest->total_days = $data["total_days"];
        $leaverequest->reason = $data["reason"];
        $leaverequest->approver_id = $data["approver_id"];
        $leaverequest->applied_on = $data["applied_on"];
        $leaverequest->status = $data["status"] ?? 'Pending';

        $leaverequest->save();

        // Update leave_assign if approved
        if($leaverequest->status == "Approved") {
            $this->updateLeaveAssignUsedDays($leaverequest->emp_id, $leaverequest->leave_id);
        }

        echo json_encode(["success" => "yes"]);
    }

    function update($data, $file = []) {
        $leaverequest = new LeaveRequest();
        $leaverequest->id = $data["id"];
        $leaverequest->leave_id = $data["leave_id"];
        $leaverequest->emp_id = $data["emp_id"];
        $leaverequest->start_date = $data["start_date"];
        $leaverequest->end_date = $data["end_date"];
        $leaverequest->total_days = $data["total_days"];
        $leaverequest->reason = $data["reason"];
        $leaverequest->approver_id = $data["approver_id"];
        $leaverequest->applied_on = $data["applied_on"];
        $leaverequest->status = $data["status"];

        $leaverequest->update();

        if (isset($data["status"]) && $data["status"] === "Approved") {
            $this->updateLeaveAssignUsedDays($data["emp_id"], $data["leave_id"]);
        }

        echo json_encode(["success" => "yes"]);
    }

    private function updateLeaveAssignUsedDays($emp_id, $leave_id) {
        global $db, $tx;

        $sum_result = $db->query("
            SELECT SUM(total_days) as total_used
            FROM {$tx}leave_request
            WHERE emp_id = {$emp_id} 
              AND leave_id = {$leave_id} 
              AND status='Approved'
        ");
        $row = $sum_result->fetch_object();
        $total_used = $row->total_used ?? 0;

        $db->query("
            UPDATE {$tx}leave_assign
            SET used_days = {$total_used}
            WHERE emp_id = {$emp_id} AND leave_type_id = {$leave_id}
        ");
    }
}
?>
