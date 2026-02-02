<?php
	echo Menu::item([
		"name"=>"Salarydetail",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"salarydetail/create","text"=>"Create Salarydetail","icon"=>"far fa-circle nav-icon"],
			["route"=>"salarydetail","text"=>"Preview Employee Salary","icon"=>"far fa-circle nav-icon"],
		]
	]);
