<?php
	echo Menu::item([
		"name"=>"Designation",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"designation/create","text"=>"Create Designation","icon"=>"far fa-circle nav-icon"],
			["route"=>"designation","text"=>"Manage Designation","icon"=>"far fa-circle nav-icon"],
		]
	]);
