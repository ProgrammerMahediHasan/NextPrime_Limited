<?php
// echo Page::title(["title" => "Edit Attendance Log"]);
echo Page::body_open();
echo Html::link(["class" => "btn btn-success mb-3", "route" => "attendancelog", "text" => "Back"]);

// --- Professional Table Styling ---
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
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
    }
</style>";

// --- Open Form ---
echo Form::open(["route" => "attendancelog/update"]);

// --- Table Start ---
echo "<table class='attendance-table-form'>";

// Source
echo "<tr>
        <th>Attendance Type</th>
        <td>";
echo AttendanceLog::html_select("source", $attendancelog->source);
echo "</td>
      </tr>";

// In Time
echo "<tr>
        <th>In Time</th>
        <td>";
echo Form::input(["type"=>"time","name"=>"in_time","value"=>$attendancelog->in_time,"label"=>"In Time"]);
echo "</td>
      </tr>";

// Out Time
echo "<tr>
        <th>Out Time</th>
        <td>";
echo Form::input(["type"=>"time","name"=>"out_time","value"=>$attendancelog->out_time,"label"=>"Out Time"]);
echo "</td>
      </tr>";

// // Status
echo "<tr>
        <th>Status</th>
        <td>";
echo AttendanceLog::html_status_select("status", $attendancelog->status);
echo "</td>
      </tr>";

// Grace Time
echo "<tr>
        <th>Grace Time</th>
        <td>";
echo Form::input(["type"=>"time","name"=>"grace_time","value"=>$attendancelog->grace_time,"label"=>"Grace Time"]);
echo "</td>
      </tr>";

// Late Time
echo "<tr>
        <th>Late Time</th>
        <td>";
echo Form::input(["type"=>"time","name"=>"late_time","value"=>$attendancelog->late_time,"label"=>"Late Time"]);
echo "</td>
      </tr>";

// Total Work Minutes
echo "<tr>
        <th>Total Work Minutes</th>
        <td>";
echo Form::input(["type"=>"number","name"=>"total_work_minutes","value"=>$attendancelog->total_work_minutes,"label"=>"Total Work Minutes"]);
echo "</td>
      </tr>";

// Remarks
echo "<tr>
        <th>Remarks</th>
        <td>";
echo Form::input(["type"=>"text","name"=>"remarks","value"=>$attendancelog->remarks,"label"=>"Remarks"]);
echo "</td>
      </tr>";

// Hidden ID
echo Form::input(["type"=>"hidden","name"=>"id","value"=>$attendancelog->id,"label"=>""]);

// Submit Button
echo "<tr>
        <td colspan='2' style='text-align:center;'>";
echo Form::input(["name"=>"update","class"=>"btn btn-primary btn-submit","value"=>"Save Changes","type"=>"submit","label"=>""]);
echo "</td>
      </tr>";

echo "</table>";

echo Form::close();
echo Page::body_close();
?>
