class system {
	exec { 'git-host-entry':
        command => "sudo echo '${GIT_SERVER_IP} git.zeonsolutions.com' >> /etc/hosts",    
        path => ['/usr/bin', '/usr/sbin', '/bin']
    }
    
    file { 'setup-ius-repo-mirror':
        ensure => 'file',        
        path => '/etc/yum.repos.d/ius.repo',
        content => template('system/ius.repo.erb'),
        require => Exec['git-host-entry']
	}
    
    file { 'setup-epel-repo-mirror':
        ensure => 'file',        
        path => '/etc/yum.repos.d/epel.repo',
        content => template('system/epel.repo.erb'),
        require => File['setup-ius-repo-mirror']
	}
    
    service { 'iptables':
        enable => 'false',
        ensure  => 'stopped',
        require => File['setup-epel-repo-mirror']
    } 

    package { 'yum-plugin-replace':
        ensure => 'present',
        require => Service['iptables']
    }

    package { 'sshpass':
        ensure => 'present',
        require => Package['yum-plugin-replace']
    }

    package { 'unzip':
        ensure => 'present',
        require => Package['sshpass']
    }  
}
