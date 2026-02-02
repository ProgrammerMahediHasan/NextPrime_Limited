<?php
	echo Menu::item([
		"name"=>"Timepolicy",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"timepolicy/create","text"=>"Create Timepolicy","icon"=>"far fa-circle nav-icon"],
			["route"=>"timepolicy","text"=>"Manage Timepolicy","icon"=>"far fa-circle nav-icon"],
		]
	]);
