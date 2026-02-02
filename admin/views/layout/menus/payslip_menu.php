<?php
	echo Menu::item([
		"name"=>"Payslip",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"payslip/create","text"=>"Create Payslip","icon"=>"far fa-circle nav-icon"],
			["route"=>"payslip","text"=>"Manage Payslip","icon"=>"far fa-circle nav-icon"],
		]
	]);
