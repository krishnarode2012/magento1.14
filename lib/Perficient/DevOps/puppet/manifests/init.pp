$PROJECT = "magento"
$ENVIRONMENT = "dev"
$COMMON_PASSWORD = "mag3nt0"
$MAGENTO_VERSION = "enterprise-1.14.2.0"
$CODE_PACKAGE = "enterprise-1.14.2.0.tar-2015-04-22-03-42-06.gz"
$SAMPLE_DATA = "magento-sample-data-1.14.1.0-2014-12-03-04-11-15.zip"

package { 'yum-plugin-replace':
    ensure => 'present'
}

service { 'iptables':
    enable => 'false',
    ensure  => 'stopped'
}

include apache
include php
include mysql
include site