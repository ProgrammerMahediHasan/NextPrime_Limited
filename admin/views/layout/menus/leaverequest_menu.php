<?php
	echo Menu::item([
		"name"=>"Leaverequest",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"leaverequest/create","text"=>"Create Leaverequest","icon"=>"far fa-circle nav-icon"],
			["route"=>"leaverequest","text"=>"Manage Leaverequest","icon"=>"far fa-circle nav-icon"],
		]
	]);
