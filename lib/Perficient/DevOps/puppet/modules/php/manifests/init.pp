class php {
    package { 'php':
        ensure => 'present',
        require => Service['nginx']
    }
    
    package { 'php-fpm':
        ensure => 'present',
        require => Package['php']
    }
    
    exec { 'upgrade-php':
        command => "sudo yum -y replace php --replace-with php55u",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Package['php-fpm']
    }
    
    package { 'php55u-mysqlnd':
        ensure => 'present',
        require => Exec['upgrade-php']
    }
    
    package { 'php55u-pdo':
        ensure => 'present',
        require => Package['php55u-mysqlnd']
    }
    
    package { 'php55u-mbstring':
        ensure => 'present',
        require => Package['php55u-pdo']
    }
    
    package { 'php55u-mcrypt':
        ensure => 'present',
        require => Package['php55u-mbstring']
    }
    
    package { 'php55u-gd':
        ensure => 'present',
        require => Package['php55u-mcrypt']
    }
    
    package { 'php55u-soap':
        ensure => 'present',
        require => Package['php55u-gd']
    }
    
    package { 'php55u-intl':
        ensure => 'present',
        require => Package['php55u-soap']
    }
    
    service { 'php-fpm':
        enable => 'true',
        ensure  => 'running',
        require => Package['php55u-intl']
    }
}
