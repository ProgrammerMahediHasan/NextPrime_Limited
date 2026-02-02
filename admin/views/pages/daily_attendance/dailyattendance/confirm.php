<?php
// Confirm Delete Page for DailyAttendance
echo Page::body_open();

// Back buttons
echo Html::link(["class"=>"btn btn-success me-2", "route"=>"dailyattendance", "text"=>"Back Previous Page"]);
// echo Html::link(["class"=>"btn btn-success", "route"=>"dailyattendance", "text"=>"Employee Attendance OUT"]);

echo Page::context_open();

// Open form for deletion, method POST
echo Form::open([
    "route" => "dailyattendance/delete/$id",
    "method" => "post"
]);

echo "<h5 class='mb-3'>Are you sure you want to delete this attendance record?</h5>";

// Show record details (from model)
echo DailyAttendance::html_row_details($id);

// Hidden input for ID
echo Form::input([
    "name" => "id",
    "type" => "hidden",
    "value" => $id
]);

// Delete button
echo Form::input([
    "name" => "delete",
    "class" => "btn btn-danger mt-3",
    "value" => "Delete",
    "type" => "submit"
]);

echo Form::close();
echo Page::context_close();
echo Page::body_close();
