class apache {
	package { 'httpd':
        ensure => 'present',
        require => Package['unzip']
    }

    service { 'httpd':
        enable => 'true',
        ensure  => 'running',
        require => Package['httpd']
    }
}
