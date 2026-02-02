<?php
	echo Menu::item([
		"name"=>"Allowance",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"allowance/create","text"=>"Create Allowance","icon"=>"far fa-circle nav-icon"],
			["route"=>"allowance","text"=>"Manage Allowance","icon"=>"far fa-circle nav-icon"],
		]
	]);
