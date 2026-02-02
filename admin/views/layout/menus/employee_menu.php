<?php
	echo Menu::item([
		"name"=>"Employee",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"employee/create","text"=>"Create Employee","icon"=>"far fa-circle nav-icon"],
			["route"=>"employee","text"=>"Manage Employee","icon"=>"far fa-circle nav-icon"],
		]
	]);
