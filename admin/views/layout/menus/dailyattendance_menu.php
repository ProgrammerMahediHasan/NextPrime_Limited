<?php
	echo Menu::item([
		"name"=>"Dailyattendance",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"dailyattendance/create","text"=>"Create Dailyattendance","icon"=>"far fa-circle nav-icon"],
			["route"=>"dailyattendance","text"=>"Manage Dailyattendance","icon"=>"far fa-circle nav-icon"],
		]
	]);
