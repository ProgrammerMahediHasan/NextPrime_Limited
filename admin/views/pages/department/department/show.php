<?php
echo Page::title(["title"=>"Show Department"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"department", "text"=>"Manage Department"]);
echo Page::context_open();
echo Department::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
