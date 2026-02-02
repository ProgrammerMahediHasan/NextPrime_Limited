<?php
	echo Menu::item([
		"name"=>"Attendancepolicy",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"attendancepolicy/create","text"=>"Create Attendancepolicy","icon"=>"far fa-circle nav-icon"],
			["route"=>"attendancepolicy","text"=>"Manage Attendancepolicy","icon"=>"far fa-circle nav-icon"],
		]
	]);
