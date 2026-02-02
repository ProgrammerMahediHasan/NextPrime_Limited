<?php
// echo Page::title(["title"=>"Show EmployeeSalary"]);
echo Page::body_open();
// echo Html::link(["class"=>"btn btn-success", "route"=>"employeesalary", "text"=>"Manage EmployeeSalary"]);
echo Page::context_open();
echo EmployeeSalary::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
