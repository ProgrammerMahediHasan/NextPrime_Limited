<?php
echo Page::title(["title"=>"Show LeaveRequest"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"leaverequest", "text"=>"Manage LeaveRequest"]);
echo Page::context_open();
echo LeaveRequest::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
