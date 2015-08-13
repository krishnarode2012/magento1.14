class nginx {
	package { 'nginx':
        ensure => 'present',
        require => Package['unzip']
    }

    service { 'nginx':
        enable => 'true',
        ensure  => 'running',
        require => Package['nginx']
    }
}
