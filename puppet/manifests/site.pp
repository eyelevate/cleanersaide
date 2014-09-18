
node default {

    $mysql_password = 'root'

	include apt
    include mysql
	include php
	include phpunit
	include apache

	mysqldb { "bbfl":
        user => "brevica",
        password => "cat3dog!b",
    }
    
    mysqldb { "cake_test":
        user => "cake_test",
        password => "cake_test",
    }
}
