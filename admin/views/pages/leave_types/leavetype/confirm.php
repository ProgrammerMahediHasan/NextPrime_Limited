<?php
// echo Page::title(["title"=>"Show LeaveType"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"leavetype", "text"=>"Back Page"]);
echo Page::context_open();
echo Form::open(["route"=>"leavetype/delete/$id"]);
// echo "Are you sure want to delete this Leave Type?";
echo LeaveType::html_row_details($id);
echo Form::input(["name"=>"id", "type"=>"hidden", "value"=>$id]);

echo Form::input ([
    "name" => "delete",
    "class" => "btn btn-danger",
    "value" => "Delete",
    "type" => "submit"
]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
