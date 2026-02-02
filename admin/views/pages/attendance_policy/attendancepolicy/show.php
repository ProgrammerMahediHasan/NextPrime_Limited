<?php
echo Page::title(["title"=>"Show AttendancePolicy"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"attendancepolicy", "text"=>"Manage AttendancePolicy"]);
echo Page::context_open();
echo AttendancePolicy::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
