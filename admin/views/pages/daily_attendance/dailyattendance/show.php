<?php
// echo Page::title(["title"=>"Employee Attendance"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"dailyattendance", "text"=>"Manage DailyAttendance"]);
echo Page::context_open();
echo DailyAttendance::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
