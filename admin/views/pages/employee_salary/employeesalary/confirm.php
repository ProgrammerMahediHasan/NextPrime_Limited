<?php
echo Page::title(["title"=>"Show EmployeeSalary"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"employeesalary", "text"=>"Manage EmployeeSalary"]);
echo Page::context_open();
echo Form::open(["route"=>"employeesalary/delete/$id"]);
echo "Are you sure?";
echo EmployeeSalary::html_row_details($id);
echo Form::input(["name"=>"id", "type"=>"hidden", "value"=>$id]);
echo Form::input(["name"=>"delete", "class"=>"btn btn-danger", "value"=>"Delete", "type"=>"submit"]);
echo Form::close();
echo Page::context_close();
echo Page::body_close();
