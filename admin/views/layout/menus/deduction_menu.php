<?php
	echo Menu::item([
		"name"=>"Deduction",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"deduction/create","text"=>"Create Deduction","icon"=>"far fa-circle nav-icon"],
			["route"=>"deduction","text"=>"Manage Deduction","icon"=>"far fa-circle nav-icon"],
		]
	]);
