$PROJECT = 'magento'
$ENVIRONMENT = 'dev'
$COMMON_PASSWORD = 'mag3nt0'

if ($LOCATION != '') and ($LOCATION != 'NGP') {
    $GIT_SERVER_IP = '115.113.227.137'
    $REPO_MIRROR_BASE_URL = 'http://hub.dcs.perficient.com/vagrant/mirrors/'
    $SCP_HOST = 'hub.dcs.perficient.com'
} else {
    $GIT_SERVER_IP = '172.16.0.45'
    $REPO_MIRROR_BASE_URL = 'http://172.16.0.22/'
    $SCP_HOST = 'git.zeonsolutions.com'
}
$SCP_USER = 'magento'
$SCP_PASS = $COMMON_PASSWORD

$MAGENTO_VERSION = 'enterprise-1.14.2.0'
$CODE_PACKAGE = 'enterprise-1.14.2.0.tar-2015-04-22-03-42-06.gz'
$SAMPLE_DATA = 'magento-sample-data-1.14.1.0-2014-12-03-04-11-15.zip'

include system
include nginx
include php
include mysql
include site