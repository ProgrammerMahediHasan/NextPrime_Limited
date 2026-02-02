<?php
	echo Menu::item([
		"name"=>"Salarypolicy",
		"icon"=>"nav-icon fa fa-wrench",
		"route"=>"#",
		"links"=>[
			["route"=>"salarypolicy/create","text"=>"Create Salarypolicy","icon"=>"far fa-circle nav-icon"],
			["route"=>"salarypolicy","text"=>"Manage Salarypolicy","icon"=>"far fa-circle nav-icon"],
		]
	]);
