<?php
	echo Menu::item([
		"name"=>"Attendancelog",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"attendancelog/create","text"=>"Create Attendancelog","icon"=>"far fa-circle nav-icon"],
			["route"=>"attendancelog","text"=>"Manage Attendancelog","icon"=>"far fa-circle nav-icon"],
		]
	]);
