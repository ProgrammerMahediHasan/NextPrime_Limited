<?php
echo Page::title(["title"=>"Show LeaveAssign"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"leaveassign", "text"=>"Manage LeaveAssign"]);
echo Page::context_open();
echo LeaveAssign::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
