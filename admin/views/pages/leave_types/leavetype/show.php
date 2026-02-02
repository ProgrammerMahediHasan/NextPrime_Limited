<?php
// echo Page::title(["title"=>"Show LeaveType"]);
echo Page::body_open();
// echo '<p>&nbsp;</p>';
echo Html::link(["class"=>"btn btn-success", "route"=>"leavetype", "text"=>"Back Page"]);
echo Page::context_open();
echo LeaveType::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
