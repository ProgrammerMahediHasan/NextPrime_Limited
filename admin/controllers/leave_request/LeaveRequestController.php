<?php
class LeaveRequestController extends Controller {
    public function __construct(){
    }

    // Leave Request list view
    public function index(){
        view("leave_request");
    }

    // Create Leave Request view
    public function create(){
        view("leave_request");
    }

    // Save new Leave Request
    public function save($data, $file){
        if(isset($data["create"])){
            $errors=[];

            if(count($errors) == 0){
                $leaverequest = new LeaveRequest();
                $leaverequest->leave_id = $data["leave_id"];
                $leaverequest->emp_id = $data["emp_id"];
                $leaverequest->start_date = $data["start_date"];
                $leaverequest->end_date = $data["end_date"];
                $leaverequest->total_days = $data["total_days"];
                $leaverequest->reason = $data["reason"];
                $leaverequest->status = $data["status"];
                $leaverequest->approver_id = $data["approver_id"];
                $leaverequest->applied_on = date("Y-m-d", strtotime($data["applied_on"]));

                $leaverequest->save();

                // ✅ যদি নতুন leave request approved হয়, used_days update কর
                if(strtolower($leaverequest->status) == 'approved'){
                    LeaveRequest::updateLeaveAssignUsedDays($leaverequest->emp_id, $leaverequest->leave_id);
                }

                redirect();
            } else {
                print_r($errors);
            }
        }
    }

    // Edit Leave Request view
    public function edit($id){
        view("leave_request", LeaveRequest::find($id));
    }

    // Update Leave Request
    public function update($data, $file){
        if(isset($data["update"])){
            $errors=[];

            if(count($errors) == 0){
                $leaverequest = new LeaveRequest();
                $leaverequest->id = $data["id"];
                $leaverequest->leave_id = $data["leave_id"];
                $leaverequest->emp_id = $data["emp_id"];
                $leaverequest->start_date = $data["start_date"];
                $leaverequest->end_date = $data["end_date"];
                $leaverequest->total_days = $data["total_days"];
                $leaverequest->reason = $data["reason"];
                $leaverequest->status = $data["status"];
                $leaverequest->applied_on = date("Y-m-d", strtotime($data["applied_on"]));

                $leaverequest->update();

                // ✅ যদি status Approved হয়, used_days update কর
                if(strtolower($leaverequest->status) == 'approved'){
                    LeaveRequest::updateLeaveAssignUsedDays($leaverequest->emp_id, $leaverequest->leave_id);
                }

                redirect();
            } else {
                print_r($errors);
            }
        }
    }

    // Confirm view (optional)
    public function confirm($id){
        view("leave_request");
    }

    // Delete Leave Request
    public function delete($id){
        LeaveRequest::delete($id);
        redirect();
    }

    // Show Leave Request detail
    public function show($id){
        view("leave_request", LeaveRequest::find($id));
    }
}
?>
