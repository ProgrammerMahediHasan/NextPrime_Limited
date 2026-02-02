<?php
	echo Menu::item([
		"name"=>"Leavepolicy",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"leavepolicy/create","text"=>"Create Leavepolicy","icon"=>"far fa-circle nav-icon"],
			["route"=>"leavepolicy","text"=>"Manage Leavepolicy","icon"=>"far fa-circle nav-icon"],
		]
	]);
