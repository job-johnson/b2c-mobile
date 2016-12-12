<?php


class Collinsharper_Core_Model_Feed extends Mage_AdminNotification_Model_Feed
{
    private $_code = 'chcore';
    const XML_USE_HTTPS_PATH    = 'chcore/feed/use_https';
    const XML_FEED_URL_PATH     = 'chcore/feed/url';
    const XML_FREQUENCY_PATH    = 'chcore/feed/check_frequency';
    const XML_FREQUENCY_ENABLE  = 'chcore/feed/enabled';
    const XML_LAST_UPDATE_PATH  = 'chcore/feed/last_update';


    public static function check()
    {

        // disable old feed module
        $configFile = Mage::getBaseDir('app') .  DS  .  'etc' . DS . 'modules' . DS . 'Collinsharper_Mfeed.xml';
        if(file_exists($configFile)) {
            if(Mage::helper('core/data')->isModuleOutputEnabled('chmfeed')) {
                $nodePath = "modules/chmfeed/active";
                Mage::getConfig()->setNode($nodePath, "false", true);
            }

            @unlink($configFile);
        }


        if(!Mage::getStoreConfig(self::XML_FREQUENCY_ENABLE)) {
            return;
        }

        return Mage::getModel('chcore/feed')->checkUpdate();
    }

    public function getFrequency()
    {
        return Mage::getStoreConfig(self::XML_FREQUENCY_PATH) * 3600;
    }

    public function getLastUpdate()
    {
        return Mage::app()->loadCache('chcore_notifications_lastcheck');
    }

    public function setLastUpdate()
    {
        Mage::app()->saveCache(time(), 'chcore_notifications_lastcheck');
        return $this;
    }
    public function getFeedUrl()
    {

        if (is_null($this->_feedUrl)) {
            $this->_feedUrl = (Mage::getStoreConfigFlag(self::XML_USE_HTTPS_PATH) ? 'https://' : 'http://')
                . Mage::getStoreConfig(self::XML_FEED_URL_PATH);
        }
        return $this->_feedUrl;
    }

    public function checkUpdate()
    {
        if (($this->getFrequency() + $this->getLastUpdate()) > time()) {
            return $this;
        }

        $feedData = array();

        $feedXml = $this->getFeedData();

        if ($feedXml && $feedXml->channel && $feedXml->channel->item) {
            foreach ($feedXml->channel->item as $item) {
                $feedData[] = array(
                    'severity'      => (int)$item->comments ? (int)$item->comments : 3, // we store severity in comments meh..
                    'date_added'    => $this->getDate((string)$item->pubDate),
                    'title'         => (string)$item->title,
                    'description'   => (string)$item->description,
                    'url'           => (string)$item->link,
                );
            }

            if ($feedData) {
                Mage::getModel('adminnotification/inbox')->parse(array_reverse($feedData));
            }
        }
        $this->setLastUpdate();

        return $this;
    }

}
