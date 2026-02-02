<?php
// echo Page::title(["title"=>"Show User"]);
echo Page::body_open();
// echo Html::link(["class"=>"btn btn-success", "route"=>"user", "text"=>"Manage User"]);
echo Page::context_open();
echo User::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
