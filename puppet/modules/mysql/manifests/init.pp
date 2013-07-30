
define mysqldb( $user, $password ) {
	exec { "create-${name}-db":
		unless => "/usr/bin/mysql -u ${user} -p ${password} ${name}",
		command => "/usr/bin/mysql -u root -p $mysql_password -e \"create database ${name}; grant all on ${name}.* to '${user}'@'%' identified by '$password';\"",
		require => [Service["mysql"], Exec["set-mysql-password"]],
	}
}

class mysql {

	package {
		"mysql-client": ensure => installed;
		"mysql-server": ensure => installed;
	}

	service { 'mysql':
		ensure => running,
		enable => true,
		hasstatus => true,
		hasrestart => true,
		require => [Package["mysql-server"],File["/etc/mysql/my.cnf"]],
	}
	
	file { "/etc/mysql/my.cnf":
		owner => 'root',
        group => 'root',
        mode => '0644',
		source => "puppet:///modules/mysql/my.cnf",
		require => Package["mysql-server"],
		notify => Service["mysql"],
	}
	
	exec { "set-mysql-password":
		unless => "mysqladmin -u root -p $mysql_password status",
		path => ["/bin", "/usr/bin"],
		command => "mysqladmin -u root password $mysql_password",
		require => Service["mysql"],
	}

}