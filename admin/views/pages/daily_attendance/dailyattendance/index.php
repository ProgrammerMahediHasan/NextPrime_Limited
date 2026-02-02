<?php
// echo Page::title(["title"=>"Employee Daily Attendance"]);
// echo Page::body_open();

// ✅ Page Heading
echo '<h1 class="text-center fw-bold my-4" style="color:#0d6efd;">Employee Daily Attendance</h1>';

// echo Page::context_open();
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
echo DailyAttendance::html_table($page, 10);
echo Page::context_close();
echo Page::body_close();
