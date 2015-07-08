<?php

define('DS', DIRECTORY_SEPARATOR);

class Magento_Instance_Setup
{
    
    private $_dbHostname;
    private $_dbUsername;
    private $_dbPassword;
    private $_dbName;
    private $_docRoot;
    private $_siteUrl;
    private $_codePath;
    private $_sampleDataPath;
    
    private $_workingDirectory;
    private $_magentoCodePath;
    private $_magentoSampleDataPath;
    private $_magentoSampleDataSqlPath;
    private $_lastCommandStatus;
    private $_importSampleData;
    
    public function __construct()
    {
        if (php_sapi_name() != "cli") {
            echo 'Error: Script can only be executed from the shell.';
            exit(1);
        }
        
        $cmd = 'mktemp -d ' . __DIR__ . DS . 'mis.XXXXXXXXXX';
        $this->_workingDirectory = $this->_run($cmd);
        $this->_lastCommandStatus = 0;
    }
    
    public function run()
    {
        if (!$this->_validateArguments()) {
            $this->_usage();
            exit(1);
        }
    
        try {
            $this->_initialize();
            $this->_extractFiles();
            $this->_initializeDatabase();
            $this->_setupSite();
            $this->_installMagento();
        } catch (Exception $e) {
            echo 'Error:', $e->getMessage();
            exit(1);
        }
        
        exit(0);
    }
    
    private function _validateArguments()
    {
        return true;
    }
    
    private function _usage()
    {
    
    }
    
    private function _initialize()
    {
        global $argv;
        
        $this->_dbHostname = $argv[1];
        $this->_dbUsername = $argv[2];
        $this->_dbPassword = $argv[3];
        $this->_dbName = $argv[4];
        $this->_docRoot = $argv[5];
        $this->_siteUrl = $argv[6];
        $this->_codePath = $argv[7];
        if (isset($argv[8])) {
            $this->_importSampleData = true;
            $this->_sampleDataPath = $argv[8];
        } else {
            $this->_importSampleData = false;
            $this->_sampleDataPath = '';
        }
    }
    
    private function _extractFiles()
    {
        $cmd = array();
        $cmd[] = 'tar';
        $cmd[] = '-C';
        $cmd[] = $this->_workingDirectory;
        $cmd[] = '-xzf';
        $cmd[] = $this->_codePath;
        $this->_run(implode(' ', $cmd));
        $this->_magentoCodePath = $this->_workingDirectory . DS . 'magento';
        
        if ($this->_importSampleData) {
            $cmd = array();
            $cmd[] = 'unzip';
            $cmd[] = $this->_sampleDataPath;
            $cmd[] = '-d';
            $cmd[] = $this->_workingDirectory;
            $this->_run(implode(' ', $cmd));

            $directories = glob($this->_workingDirectory . DS . 'magento-sample-data-*', GLOB_ONLYDIR);
            if (count($directories) == 1) {
                $this->_magentoSampleDataPath = $directories[0];
                $files = glob($this->_magentoSampleDataPath . DS . '*.sql');
                if (count($files) == 1) {
                    $this->_magentoSampleDataSqlPath = $files[0];
                }
            }
        }
        
        return true;
    }
    
    private function _initializeDatabase()
    {
        $cmd = array();
        $cmd[] = 'mysql';
        $cmd[] = '-h' . $this->_dbHostname;
        $cmd[] = '-u' . $this->_dbUsername;
        $cmd[] = '-p' . $this->_dbPassword;
        $cmd[] = $this->_dbName;
        
        // drop and create database
        $newCmd = $cmd;
        $newCmd[] = '-e "DROP DATABASE IF EXISTS ' . $this->_dbName . '; CREATE DATABASE ' . $this->_dbName . ';"'; 
        $this->_run(implode(' ', $newCmd));
        
        if ($this->_importSampleData) {
            // import sample data
            $newCmd = $cmd;
            $newCmd[] = '<';
            $newCmd[] = $this->_magentoSampleDataSqlPath;
            $this->_run(implode(' ', $newCmd));
        }
        
        return true;
    }
    
    private function _setupSite()
    {
        $cmd = array();
        $cmd[] = 'rsync';
        $cmd[] = '-r';
        $cmd[] = $this->_magentoCodePath . DS;
        $cmd[] = $this->_docRoot . DS;
        $this->_run(implode(' ', $cmd));
        
        if (!empty($this->_magentoSampleDataPath)) {
            $cmd = array();
            $cmd[] = 'rsync';
            $cmd[] = '-r';
            $cmd[] = $this->_magentoSampleDataPath . DS;
            $cmd[] = $this->_docRoot;
            $this->_run(implode(' ', $cmd));
        }
        
        return true;
    }
    
    private function _installMagento()
    {
        $cmd = array();        
        $cmd[] = 'cd';
        $cmd[] = $this->_docRoot;
        $cmd[] = '&&';
        $cmd[] = 'php';
        $cmd[] = 'install.php';
        $cmd[] = '--license_agreement_accepted "yes"';
        $cmd[] = '--locale "en_US"';
        $cmd[] = '--timezone "America/Los_Angeles"';
        $cmd[] = '--default_currency "USD"';
        $cmd[] = '--db_host "' . $this->_dbHostname . '"';
        $cmd[] = '--db_name "' . $this->_dbName . '"';
        $cmd[] = '--db_user "' . $this->_dbUsername . '"';
        $cmd[] = '--db_pass "' . $this->_dbPassword . '"';
        $cmd[] = '--url "' . $this->_siteUrl . '"';
        $cmd[] = '--skip_url_validation "true"';
        $cmd[] = '--use_rewrites "yes"';
        $cmd[] = '--use_secure "no"';
        $cmd[] = '--secure_base_url ""';
        $cmd[] = '--use_secure_admin "no"';
        $cmd[] = '--admin_firstname "Admin"';
        $cmd[] = '--admin_lastname "User"';
        $cmd[] = '--admin_email "ramesh.tabarna@perficient.com"';
        $cmd[] = '--admin_username "admin"';
        $cmd[] = '--admin_password "mag3nt0"';
        $cmd[] = '--admin_frontname "zpanel"';
        $cmd[] = '--session_save "db"';
        $this->_run(implode(' ', $cmd));
    }
    
    private function _run($command)
    {
        echo $command, "\n";
        
        $output = '';
        $result = '';
        $lastLine = exec($command, $output, $result);
        $this->_lastCommandStatus = $result;
        
        return implode('', $output);
    }
}

$objMis = new Magento_Instance_Setup();
$objMis->run();