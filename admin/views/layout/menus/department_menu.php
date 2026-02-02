<?php
	echo Menu::item([
		"name"=>"Department",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"department/create","text"=>"Create Department","icon"=>"far fa-circle nav-icon"],
			["route"=>"department","text"=>"Manage Department","icon"=>"far fa-circle nav-icon"],
		]
	]);
