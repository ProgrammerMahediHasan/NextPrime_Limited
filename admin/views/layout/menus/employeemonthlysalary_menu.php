<?php
	echo Menu::item([
		"name"=>"Employeemonthlysalary",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"employeemonthlysalary/create","text"=>"Create Employeemonthlysalary","icon"=>"far fa-circle nav-icon"],
			["route"=>"employeemonthlysalary","text"=>"Manage Employeemonthlysalary","icon"=>"far fa-circle nav-icon"],
		]
	]);
