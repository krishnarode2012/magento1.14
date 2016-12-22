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
        command => "sudo yum -y replace php --replace-with php56u",    
        path => ['/usr/bin', '/usr/sbin', '/bin'],
        require => Package['php-fpm']
    }
    
    package { 'php56u-mysqlnd':
        ensure => 'present',
        require => Exec['upgrade-php']
    }
    
    package { 'php56u-pdo':
        ensure => 'present',
        require => Package['php56u-mysqlnd']
    }
    
    package { 'php56u-mbstring':
        ensure => 'present',
        require => Package['php56u-pdo']
    }
    
    package { 'php56u-mcrypt':
        ensure => 'present',
        require => Package['php56u-mbstring']
    }
    
    package { 'php56u-gd':
        ensure => 'present',
        require => Package['php56u-mcrypt']
    }
    
    package { 'php56u-soap':
        ensure => 'present',
        require => Package['php56u-gd']
    }
    
    package { 'php56u-intl':
        ensure => 'present',
        require => Package['php56u-soap']
    }
    
    service { 'php-fpm':
        enable => 'true',
        ensure  => 'running',
        require => Package['php56u-intl']
    }
}
