<?php
echo Page::title(["title"=>"Show LeaveAssign"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"leaveassign", "text"=>"Manage LeaveAssign"]);
echo Page::context_open();
echo Form::open(["route"=>"leaveassign/delete/$id"]);
// echo "Are you want to delete this Leave Assign?";
echo LeaveAssign::html_row_details($id);
echo Form::input(["name"=>"id", "type"=>"hidden", "value"=>$id]);
echo Form::input(["name"=>"delete", "class"=>"btn btn-danger", "value"=>"Delete", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
