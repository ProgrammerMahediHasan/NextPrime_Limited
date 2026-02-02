<?php
	echo Menu::item([
		"name"=>"Employeesalary",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"employeesalary/create","text"=>"Create Employeesalary","icon"=>"far fa-circle nav-icon"],
			["route"=>"employeesalary","text"=>"Manage Employeesalary","icon"=>"far fa-circle nav-icon"],
		]
	]);
