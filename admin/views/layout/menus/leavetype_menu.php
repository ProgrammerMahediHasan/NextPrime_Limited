<?php
	echo Menu::item([
		"name"=>"Leavetype",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"leavetype/create","text"=>"Create Leavetype","icon"=>"far fa-circle nav-icon"],
			["route"=>"leavetype","text"=>"Manage Leavetype","icon"=>"far fa-circle nav-icon"],
		]
	]);
