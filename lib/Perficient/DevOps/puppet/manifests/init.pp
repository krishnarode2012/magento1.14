$PROJECT = "magento"
$ENVIRONMENT = "dev"
$COMMON_PASSWORD = "mag3nt0"

if ($LOCATION != 'NGP') {
    $GIT_SERVER_IP = "115.113.227.137"
    $SCP_HOST = "hub.dcs.perficient.com"
} else {
    $GIT_SERVER_IP = "172.16.0.45"
    $SCP_HOST = "git.zeonsolutions.com"
}
$SCP_USER = "magento"
$SCP_PASS = $COMMON_PASSWORD

$MAGENTO_VERSION = "enterprise-1.14.2.0"
$CODE_PACKAGE = "enterprise-1.14.2.0.tar-2015-04-22-03-42-06.gz"
$SAMPLE_DATA = "magento-sample-data-1.14.1.0-2014-12-03-04-11-15.zip"

exec { 'git-host-entry':
    command => "sudo echo 'git.zeonsolutions.com ${GIT_SERVER_IP}' >> /etc/hosts",    
    path => ['/usr/bin', '/usr/sbin', '/bin']
}

service { 'iptables':
    enable => 'false',
    ensure  => 'stopped',
    require => Exec['git-host-entry']
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

include apache
include php
include mysql
include site