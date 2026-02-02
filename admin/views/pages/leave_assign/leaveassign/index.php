<?php
// Center the page title using a class or inline style
echo '<h2 style="text-align:center; color:#0d6efd; font-family:Poppins, sans-serif;">Create Leave Assign</h2>';

// echo Page::body_open();
// echo Page::context_open();

$page = isset($_GET["page"]) ? $_GET["page"] : 1;
echo LeaveAssign::html_table($page, 10);

echo Page::context_close();
echo Page::body_close();
?>
