<?php
echo Page::title(["title"=>"Show TimePolicy"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"timepolicy", "text"=>"Manage TimePolicy"]);
echo Page::context_open();
echo TimePolicy::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
