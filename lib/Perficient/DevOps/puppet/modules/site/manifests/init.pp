class site {
	package { 'sshpass':
        ensure => 'present',
        require => Exec['restart-mysql']
    }
    
    package { 'unzip':
        ensure => 'present',
        require => Package['sshpass']
    }
    
    file { '/var/www':
        ensure => 'directory',
        require => Package['unzip']
    }
    
    file { "/var/www/${PROJECT}-${ENVIRONMENT}.local":
        ensure => 'link',
        target => '/vagrant',
        require => File['/var/www']
    }
    
    file { 'create-virtualhost':
        ensure => 'file',        
        path => "/etc/httpd/conf.d/${PROJECT}-${ENVIRONMENT}.local.conf",
        content => template('site/virtualhost.erb'),
        notify => Service['httpd'],
        require => Package['unzip']
	}
    
    exec { 'reload-apache':
        command => 'sudo service httpd reload',    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => File['create-virtualhost']
    }
    
    file { 'create-database-and-user-sql':
	    ensure => 'file',
        path => '/tmp/create_database_and_user.sql',
	    content => template('site/create_database_and_user.erb'),
        require => Exec['reload-apache']
	}
    
    exec { 'create-database-and-user':
        command => "mysql -uroot -p${COMMON_PASSWORD} < /tmp/create_database_and_user.sql",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => File['create-database-and-user-sql']
    }
	
	exec { 'download-code-package':
        command => "sudo sshpass -p 'mag3nt0' scp -o \"StrictHostKeyChecking no\" magento@172.16.0.45:/home/magento/releases/${MAGENTO_VERSION}/${CODE_PACKAGE} /tmp",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Exec['create-database-and-user']
    }
    
    exec { 'download-sample-data':
        command => "sudo sshpass -p 'mag3nt0' scp -o \"StrictHostKeyChecking no\" magento@172.16.0.45:/home/magento/releases/${MAGENTO_VERSION}/${SAMPLE_DATA} /tmp", 			
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        timeout => 3600,
        require => Exec['download-code-package']
    }
	
	exec { 'copy-setup-script':
        command => "sudo cp /vagrant/lib/Perficient/DevOps/bin/Magento_Instance_Setup.php /tmp/",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Exec['download-sample-data']
    }
	
	exec { 'install-magento':
        command => "php /tmp/Magento_Instance_Setup.php localhost ${PROJECT}_${ENVIRONMENT} ${COMMON_PASSWORD} ${PROJECT}_${ENVIRONMENT} /var/www/${PROJECT}-${ENVIRONMENT}.local http://${PROJECT}-${ENVIRONMENT}.local/ /tmp/${CODE_PACKAGE} /tmp/${SAMPLE_DATA}",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        timeout => 3600,
        require => Exec['copy-setup-script']
    }  
}
