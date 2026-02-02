<?php
	echo Menu::item([
		"name"=>"Monthlyattendance",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"monthlyattendance/create","text"=>"Create Monthlyattendance","icon"=>"far fa-circle nav-icon"],
			["route"=>"monthlyattendance","text"=>"Manage Monthlyattendance","icon"=>"far fa-circle nav-icon"],
		]
	]);
