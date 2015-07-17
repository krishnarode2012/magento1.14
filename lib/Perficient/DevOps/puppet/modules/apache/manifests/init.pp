class apache {
	package { 'httpd':
        ensure => 'present',
        require => Service['iptables']
    }

    service { 'httpd':
        enable => 'true',
        ensure  => 'running',
        require => Package['httpd']
    }
}
