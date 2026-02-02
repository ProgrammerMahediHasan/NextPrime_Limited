<?php
// echo Page::title(["title" => "Edit Daily Attendance"]);
// echo Page::body_open();



// --- Table Form Styling ---
echo "<style>
.attendance-table-form {
    width: 100%;
    max-width: 900px;
    margin: 25px auto;
    border-collapse: collapse;
    font-family: 'Poppins', sans-serif;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0,0,0,0.08);
}
.attendance-table-form th, .attendance-table-form td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}
.attendance-table-form th {
    background: #173e7ef3;
    color: #f7f2f2ef;
    font-weight: 600;
}
.attendance-table-form input,
.attendance-table-form select,
.attendance-table-form textarea {
    width: 100%;
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    font-size: 14px;
}
.attendance-table-form input[type='time'],
.attendance-table-form input[type='number'] {
    max-width: 180px;
}
.btn-submit {
    margin-top: 15px;
    padding: 10px 25px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    background-color: #16a34a;
    color: #fff;
    border: none;
    cursor: pointer;
}
.btn-submit:hover {
    background-color: #14532d;
    transition: 0.3s;
}
</style>";

// --- Open Form ---
echo Form::open(["route" => "dailyattendance/update"]);

// Back Button
echo Html::link(["class" => "btn btn-success mb-3","route" => "dailyattendance",
    "text"  => " ←  Back Page"
]);

// Hidden ID
echo Form::input([
    "type"=>"hidden",
    "name"=>"id",
    "value"=>$dailyattendance->id,
    "label"=>"ID"
]);

// --- Start Table ---
echo "<table class='attendance-table-form'>";

// Fields Array
$fields = [
    "emp_id" => ["label"=>"Employee ID","type"=>"text","readonly"=>true],
    "att_date" => ["label"=>"Attendance Date","type"=>"date"],
    "in_time" => ["label"=>"In Time","type"=>"time"],
    "out_time" => ["label"=>"Out Time","type"=>"time"],
    "total_work_minutes" => ["label"=>"Total Work Minutes","type"=>"number","readonly"=>true],
    "status" => ["label"=>"Status","type"=>"text","readonly"=>true],
    "late_minutes" => ["label"=>"Late Minutes","type"=>"number","readonly"=>true],
    "overtime_minutes" => ["label"=>"Overtime Minutes","type"=>"number","readonly"=>true],
    "remarks" => ["label"=>"Remarks","type"=>"text"]
];

// Render Fields Dynamically
foreach($fields as $name => $attr){
    echo "<tr><th>{$attr['label']}</th><td>";

    $value = $dailyattendance->$name;

    // --- Fix time fields ---
    if($attr['type'] == 'time' && !empty($value)){
        $value = date("H:i", strtotime($value)); // HH:MM format
    }

    $input = [
        "type" => $attr['type'],
        "name" => $name,
        "value" => $value,
        "label" => $attr['label'] // ✅ label added to fix warning
    ];

    if(isset($attr['readonly'])) $input['readonly'] = true;

    echo Form::input($input);

    echo "</td></tr>";
}

// --- Day Type Manual Select ---
echo "<tr><th>Day Type</th><td>";
$dayOptions = ["Working"=>"Working","Weekend"=>"Weekend","Holiday"=>"Holiday"];
echo "<select name='day_type' class='form-control'>";
foreach($dayOptions as $val => $text){
    $selected = ($dailyattendance->day_type == $val) ? "selected" : "";
    echo "<option value='{$val}' {$selected}>{$text}</option>";
}
echo "</select>";
echo "</td></tr>";

// Submit Button
echo "<tr><td colspan='2' style='text-align:center;'>";
echo Form::input([
    "name"=>"update",
    "type"=>"submit",
    "class"=>"btn btn-submit",
    "value"=>"Update",
    "label"=>""
]);
echo "</td></tr>";

echo "</table>";
echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>

<!-- Auto Calculation Script -->
<script>
const officeStartTime = "09:00";
const graceTime = "09:10";
const absentTime = "10:00";
const officeEndTime = "17:00";

function timeToMinutes(timeStr){
    const [h, m] = timeStr.split(":").map(Number);
    return h*60 + m;
}

function calculateAttendance(){
    const inInput = document.querySelector('input[name="in_time"]');
    const outInput = document.querySelector('input[name="out_time"]');
    const totalInput = document.querySelector('input[name="total_work_minutes"]');
    const lateInput = document.querySelector('input[name="late_minutes"]');
    const overtimeInput = document.querySelector('input[name="overtime_minutes"]');
    const statusInput = document.querySelector('input[name="status"]');

    const inTime = inInput.value;
    const outTime = outInput.value;

    if(inTime && outTime){
        const inMins = timeToMinutes(inTime);
        const outMins = timeToMinutes(outTime);

        // Total Work
        let totalWork = outMins - inMins;
        totalInput.value = totalWork > 0 ? totalWork : 0;

        // Late
        const graceMins = timeToMinutes(graceTime);
        const officeStartMins = timeToMinutes(officeStartTime);
        const absentMins = timeToMinutes(absentTime);

        let late = 0;
        if(inMins > graceMins && inMins <= absentMins){
            late = inMins - officeStartMins;
        }
        lateInput.value = late;

        // Overtime
        const overtime = outMins > timeToMinutes(officeEndTime) ? outMins - timeToMinutes(officeEndTime) : 0;
        overtimeInput.value = overtime;

        // Status
        if(inMins > absentMins){
            statusInput.value = "Absent";
            totalInput.value = 0;
            lateInput.value = 0;
            overtimeInput.value = 0;
        } else {
            statusInput.value = "Present";
        }
    } else {
        totalInput.value = 0;
        lateInput.value = 0;
        overtimeInput.value = 0;
        statusInput.value = "";
    }
}

// Trigger calculation on time change
document.querySelectorAll('input[name="in_time"], input[name="out_time"]').forEach(input => {
    input.addEventListener('change', calculateAttendance);
});

// Initial calculation on page load
window.addEventListener('load', calculateAttendance);
</script>
