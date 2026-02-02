<?php
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"leaverequest", "text"=>"Back Page"]);
echo Page::context_open();

echo Form::open(["route"=>"leaverequest/update"]);

// ===================
// Hidden ID
// ===================
echo Form::input([
    "type" => "hidden",
    "name" => "id",
    "value" => "$leaverequest->id"
]);

// ===================
// Leave Type (dropdown)
// ===================
echo Form::input([
    "label" => "Leave Type",
    "name" => "leave_id",
    "table" => "leave_types",
    "value" => "$leaverequest->leave_id"
]);

// ===================
// Employee dropdown
// ===================
echo Form::input([
    "label" => "Employee",
    "name" => "emp_id",
    "table" => "employees",
    "value" => "$leaverequest->emp_id"
]);

// ===================
// Start Date
// ===================
echo Form::input([
    "label" => "Start Date",
    "type" => "date",
    "name" => "start_date",
    "id"   => "start_date",
    "value" => "$leaverequest->start_date"
]);

// ===================
// End Date
// ===================
echo Form::input([
    "label" => "End Date",
    "type" => "date",
    "name" => "end_date",
    "id"   => "end_date",
    "value" => "$leaverequest->end_date"
]);

// ===================
// Total Days (readonly)
// ===================
echo Form::input([
    "label" => "Total Days",
    "type" => "text",
    "name" => "total_days",
    "id"   => "total_days",
    "readonly" => true,
    "value" => "$leaverequest->total_days"
]);

// ===================
// Reason
// ===================
echo Form::input([
    "label" => "Reason",
    "type" => "textarea",
    "name" => "reason",
    "value" => "$leaverequest->reason"
]);

// ===================
// Status Dropdown (fixed)
// ===================
echo "<label>Status</label>";
echo LeaveRequest::html_status_dropdown("status", $leaverequest->status);

// ===================
// Approver ID
// ===================
echo Form::input([
    "label" => "Approver",
    "type" => "text",
    "name" => "approver_id",
    "placeholder" => "Enter Approver Id",
    "value" => "$leaverequest->approver_id"
]);

// ===================
// Applied On (default today if empty)
// ===================
echo Form::input([
    "label" => "Applied On",
    "type"  => "date",
    "name"  => "applied_on",
    "value" => ($leaverequest->applied_on ?? date("Y-m-d"))
]);

// ===================
// Submit Button
// ===================
echo Form::input([
    "name" => "update",
    "class" => "btn btn-primary offset-2",
    "value" => "Update",
    "type" => "submit"
]);

echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const start = document.getElementById('start_date');
    const end = document.getElementById('end_date');
    const total = document.getElementById('total_days');

    function calculateDays() {
        if(start.value && end.value){
            const startDate = new Date(start.value);
            const endDate = new Date(end.value);
            const diffTime = endDate - startDate;
            if(diffTime >= 0){
                const diffDays = diffTime / (1000 * 60 * 60 * 24) + 1; // include start & end
                total.value = diffDays;
            } else {
                total.value = '';
            }
        }
    }

    start.addEventListener('change', calculateDays);
    end.addEventListener('change', calculateDays);
});
</script>
