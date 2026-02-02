<?php
	echo Menu::item([
		"name"=>"Policy",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"policy/create","text"=>"Create Policy","icon"=>"far fa-circle nav-icon"],
			["route"=>"policy","text"=>"Manage Policy","icon"=>"far fa-circle nav-icon"],
		]
	]);
