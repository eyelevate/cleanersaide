class php {

	file { "/tmp/php5-xdebug_2.1.0-1_i386.deb":
		source => "puppet:///modules/php/php5-xdebug_2.1.0-1_i386.deb"
	}

	package {
		"php5": ensure => installed;
		"libapache2-mod-php5": ensure => installed;
		"php5-mysql": ensure => installed;
		"php5-curl": ensure => installed;
		"php5-sqlite": ensure => installed;
		"php5-gd": ensure => installed;
		"php5-xdebug": 
 			provider => dpkg,
		 	ensure   => latest,
		 	require  => File["/tmp/php5-xdebug_2.1.0-1_i386.deb"],
 			source   => "/tmp/php5-xdebug_2.1.0-1_i386.deb",
	}
	
	file { "/etc/php5/apache2/php.ini":
		source => "puppet:///modules/php/php.ini",
		require => Package["php5", "libapache2-mod-php5", "php5-mysql", "php5-curl", "php5-sqlite", "php5-gd", "php5-xdebug"];
	}
	
}