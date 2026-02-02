<?php
echo Page::title(["title"=>"Show Employee"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"employee", "text"=>"Manage Employee"]);
echo Page::context_open();
echo Employee::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
