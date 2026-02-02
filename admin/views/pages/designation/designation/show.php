<?php
echo Page::title(["title"=>"Show Designation"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"designation", "text"=>"Manage Designation"]);
echo Page::context_open();
echo Designation::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
