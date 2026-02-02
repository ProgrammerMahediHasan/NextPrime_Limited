<?php
	echo Menu::item([
		"name"=>"Leaveassign",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"leaveassign/create","text"=>"Create Leaveassign","icon"=>"far fa-circle nav-icon"],
			["route"=>"leaveassign","text"=>"Manage Leaveassign","icon"=>"far fa-circle nav-icon"],
		]
	]);
