<?php
// echo Page::title(["title"=>"Manage Employee"]);
// echo Page::body_open();
// echo Page::context_open();
$page = isset($_GET["page"]) ?$_GET["page"]:1;
echo Employee::html_table($page,5);
echo Page::context_close();
echo Page::body_close();

// $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
?>
