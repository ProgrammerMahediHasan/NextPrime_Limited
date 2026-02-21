<?php
echo Page::body_open();
// Top Back Page button removed as requested
echo Page::context_open();

echo Form::open(["route"=>"leaverequest/save"]);

// Leave Type dropdown
echo Form::input([
    "label" => "Leave Type",
    "name" => "leave_id",
    "table" => "leave_types",
    "placeholder" => "Select Leave Type"
]);

// Employee dropdown
echo Form::input([
    "label" => "Employee",
    "name" => "emp_id",
    "table" => "employees",
    "placeholder" => "Select Employee"
]);

// Start Date
echo Form::input([
    "label" => "Start Date",
    "type" => "date",
    "name" => "start_date",
    "id"   => "start_date"
]);

// End Date
echo Form::input([
    "label" => "End Date",
    "type" => "date",
    "name" => "end_date",
    "id"   => "end_date"
]);

// Total Days (readonly, auto-calculated)
echo Form::input([
    "label" => "Total Days",
    "type" => "text",
    "name" => "total_days",
    "id"   => "total_days",
    "readonly" => true
]);

// Reason
echo Form::input([
    "label" => "Reason",
    "type" => "textarea",
    "name" => "reason"
]);

// =======================
// Status Dropdown from Model
// =======================
$selected_status = $_POST['status'] ?? "Pending";
echo "<div class='form-group row'>";
echo "<label for='status' class='col-sm-2 col-form-label'>Status</label>";
echo "<div class='col-sm-10'>";
echo LeaveRequest::html_status_dropdown("status", $selected_status);
echo "</div>";
echo "</div>";

global $db, $tx;
echo "<div class='form-group row'>";
echo "<label for='approver_id' class='col-sm-2 col-form-label'>Approver</label>";
echo "<div class='col-sm-10'>";
$sql = "
    SELECT u.id, CONCAT(u.name,' (', COALESCE(r.name,'-'), ')') AS display
    FROM {$tx}users u
    LEFT JOIN {$tx}roles r ON r.id = u.role_id
    WHERE LOWER(r.name) IN ('manager','hr','admin')
    ORDER BY u.name ASC
";
$res = $db->query($sql);
echo "<select id='approver_id' name='approver_id' class='form-select' style='width:100%'>";
echo "<option value='' selected>Select Approver</option>";
while($row = $res->fetch_assoc()){
    $id = intval($row["id"]);
    $text = $row["display"];
    echo "<option value='{$id}'>{$text}</option>";
}
echo "</select>";
echo "</div>";
echo "</div>";

// Applied On (default today)
echo Form::input([
    "label" => "Applied On",
    "type" => "date",
    "name" => "applied_on",
    "value" => date("Y-m-d")
]);

// Submit
echo "<div style='display:flex;justify-content:center;gap:10px;margin-top:12px;'>";
echo Html::link([
    "class" => "btn btn-dark",
    "route" => "leaverequest",
    "text"  => "Back"
]);
echo "<button type='submit' name='create' class='btn btn-primary px-5'>Send Leave Request</button>";
echo "</div>";

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
