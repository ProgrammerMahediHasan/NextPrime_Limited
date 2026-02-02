<?php
echo Page::title(["title"=>"Show Allowance"]);
echo Page::body_open();
echo Html::link(["class"=>"btn btn-success", "route"=>"allowance", "text"=>"Back Previous Page"]);
echo Page::context_open();
echo Allowance::html_row_details($id);
echo Page::context_close();
echo Page::body_close();
