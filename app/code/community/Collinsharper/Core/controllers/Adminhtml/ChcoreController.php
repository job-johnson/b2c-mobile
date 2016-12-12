<?php

class Collinsharper_Core_Adminhtml_ChcoreController extends Mage_Adminhtml_Controller_Action
{

    const MAXSIZE = 1048576; // 1 meg?
    const REPORTDATE = 3600; // 1 hour
    const DEV_ACTIVE = 'dev/log/active'; // 1 hour
    const SUPPORT_EMAIL = 'debugsupport@collinsharper.com';


    public function _toggleLogging($enable = 0)
    {
        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        $table = $resource->getTablename('core_config_data');
        // we wipe all store scopes
        $clearSql = "delete from $table where path = '{self::DEV_ACTIVE}'";
        $write->query($clearSql);

        if($enable) {
            $enable = 1;
        }

        $config = new Mage_Core_Model_Config();
        $config->saveConfig(self::DEV_ACTIVE, $enable, 'default', 0);
    }

    public function enablelogsAction()
    {
        try {

          $this->_toggleLogging(1);
        } catch (Exception $e) {
            mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to enable logging: %s', $e->getMessage()));
            $this->_redirectReferer();
            return;
        }

        mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Enabled Logging'));

        $this->_clearLogs();
        $this->_redirectReferer();


    }

    public function disablelogsAction()
    {
        try {

          $this->_toggleLogging(0);
        } catch (Exception $e) {
            mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to disabling logging: %s', $e->getMessage()));
            $this->_redirectReferer();
            return;
        }

        mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Disabled Logging'));

        $this->_redirectReferer();

    }


    public function indexAction()
    {
        $this->_redirect('/');
    }

    public function _noticeLoggingEnabled()
    {
        if(!Mage::getStoreConfig('dev/log/active')) {
            mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Logging apears to be disabled. Please enable logging.'));
        }
    }

    public function _getLogDir()
    {
        $dir = BP . DS . 'var' . DS . 'log';
        if(!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    public function _getLogFileList($dir = false)
    {
        $ret = array();
        if(!$dir) {
            $dir = $this->_getLogDir();
        }

        $list = scandir($dir);
        foreach($list as $file) {
            if(is_file( $dir . DS . $file)) {
                $ret[] = $dir . DS . $file;
            }
        }
            return $ret;
    }

    public function _clearLogs()
    {
        $list = $this->_getLogFileList();
        foreach($list as $file) {
            file_put_contents($file, '');
        }
    }

    public function clearlogsAction()
    {
        try {

            $this->_noticeLoggingEnabled();
            $this->_clearLogs();

            mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('All logs cleared.'));
        } catch (Exception $e) {
            mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to clear logs: %s', $e->getMessage()));
        }
        $this->_redirectReferer();
    }

    public function emaillogsAction()
    {
        /*
         * check for log sizes
         * attach each one seperate email to support
         *
         */


        $this->_noticeLoggingEnabled();



        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

        $mailBody   = "<b>Log files from {$url}<br />";

        $list = $this->_getLogFileList();

        $dir = BP . DS . 'var' . DS . 'report';
        $reportList = scandir($dir);
        foreach($reportList as $file) {
            if(is_file($dir .  DS . $file) && (time() - filectime($dir . DS . $file)) < self::REPORTDATE) {
                $list[] = $dir .  DS . $file;
            }
        }

        // get PHP info / system informaiton
        ob_start();
        phpinfo();
        $data = ob_get_contents();
        ob_end_clean();
        $data .= "<hr/> <br /> <br /> Magento Version: " . Mage::getVersion() ." <br />";




        $data .= "<br /> Magento modules: <br />";

        $modules = Mage::getConfig()->getNode('modules')->children();
        $modulesArray = (array)$modules;

        ksort($modulesArray);

        $rows = 0;
        foreach($modulesArray as $k => $d) {
            $moduleState = $d->is('active') ? " Active" : "Disabled";
            $data .= "$k: $moduleState | ";

            $rows++;
            if ($rows % 3 === 0) {
                $data .=  '<br />';
            }
        }
        unset($rows);
        $data = trim(rtrim(trim($data), "|"));

        // store details

        $allStores = Mage::app()->getStores();
        $data .= "<br/>";
        $data .= "<hr/> <br /> Store Details <br />";
        foreach ($allStores as $_eachStoreId => $val)
        {
            $_storeCode = Mage::app()->getStore($_eachStoreId)->getCode();
            $_storeName = Mage::app()->getStore($_eachStoreId)->getName();
        //    $_storeId = Mage::app()->getStore($_eachStoreId)->getId();
            $data .= "$_storeCode: $_storeName <br />";

        }

        // TODO : catalog Details
        $infoFile = sys_get_temp_dir() . DS . "collinsharper-serverinformation.html";
        file_put_contents($infoFile, $data);
        array_unshift($list, $infoFile);

        $archiveFile =  tempnam(sys_get_temp_dir(), 'CHzip');


        $storage = sys_get_temp_dir() . DS . 'chdebug-' . rand ( 999, 99999 );
        @mkdir($storage);


        foreach($list as $file) {
            if(filesize($file) > self::MAXSIZE) {
                mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Log file is too large, Please clear logs and repeat your test: %s', basename($file)));
                $this->_redirectReferer();
                return;
            }

        copy($file, $storage . DS . basename($file));
        }
        
        try {
            // we do zip
            // send downloadd
            $filter = new Zend_Filter_Compress(array(
                'adapter' => 'Zip',
                'options' => array(
                    'archive' => $archiveFile
                )
            ));

            $compress = $filter->filter($storage);
         //   $mail->send();
        } catch (Exception $e) {
            mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to archive logs. %s' . $e->getMessage()));
            Mage::logException($e);
            $this->_redirectReferer();
        }

        mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Your download was processed..'));



        $this->_prepareDownloadResponse(date('Y-m-d'). '-collinsharper_support.zip', file_get_contents($archiveFile));

// do i ned this?
  //      $this->_redirectReferer();
    }
}
