<?php
	echo Menu::item([
		"name"=>"Leaveresult",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"leaveresult/create","text"=>"Create Leaveresult","icon"=>"far fa-circle nav-icon"],
			["route"=>"leaveresult","text"=>"Manage Leaveresult","icon"=>"far fa-circle nav-icon"],
		]
	]);
