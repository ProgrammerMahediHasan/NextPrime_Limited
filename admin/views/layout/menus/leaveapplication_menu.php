<?php
	echo Menu::item([
		"name"=>"Leaveapplication",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"leaveapplication/create","text"=>"Create Leaveapplication","icon"=>"far fa-circle nav-icon"],
			["route"=>"leaveapplication","text"=>"Manage Leaveapplication","icon"=>"far fa-circle nav-icon"],
		]
	]);
