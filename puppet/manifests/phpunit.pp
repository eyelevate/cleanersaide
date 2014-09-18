class phpunit {
	include pear
	
	pear::package { "PEAR": }

	exec { "pear autodiscover":
		command => "/usr/bin/pear config-set auto_discover 1",
		require => Package["PEAR"],
	}
	
	pear::package { "PHPUnit":
		repository => "pear.phpunit.de", 
		require => Exec["pear autodiscover"]
	}
}