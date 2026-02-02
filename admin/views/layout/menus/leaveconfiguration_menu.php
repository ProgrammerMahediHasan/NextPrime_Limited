<?php
	echo Menu::item([
		"name"=>"Leaveconfiguration",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"leaveconfiguration/create","text"=>"Create Leaveconfiguration","icon"=>"far fa-circle nav-icon"],
			["route"=>"leaveconfiguration","text"=>"Manage Leaveconfiguration","icon"=>"far fa-circle nav-icon"],
		]
	]);
