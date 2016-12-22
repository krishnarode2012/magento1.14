class mysql {
    package { 'mysql':
        ensure => 'present',
        require => Package['php56u-intl']
    }
    
    package { 'mysql-server':
        ensure => 'present',
        require => Package['mysql']
    }

    exec { 'upgrade-mysql':
        command => "sudo yum -y replace mysql-server --replace-with mysql56u-server",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Package['mysql-server']
    }
    
    exec { 'update-mysql-cnf':
        command => 'sudo sed -i \'s/\[mysqld\]/[mysqld]\n\ninnodb_data_file_path = ibdata1:10M:autoextend\n\n/g\' /etc/my.cnf',    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Exec['upgrade-mysql']
    }
    
    service { 'mysqld':
        enable => 'true',
        ensure  => 'running',
        require => Exec['update-mysql-cnf']
    }
    
    exec { 'upgrade-mysql-tables':
        command => "mysql_upgrade -uroot -p${COMMON_PASSWORD}",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Service['mysqld']
    }
    
    exec { 'restart-mysql':
        command => 'sudo service mysqld restart',    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Exec['upgrade-mysql-tables']
    }
}
