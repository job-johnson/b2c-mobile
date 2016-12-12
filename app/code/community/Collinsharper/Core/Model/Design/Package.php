<?php

class Collinsharper_Core_Model_Design_Package extends Mage_Core_Model_Design_Package
{

    public function getMergedConcat()
    {
        return Mage::getStoreConfig('chcore/merged_cssjs/tail') ? Mage::getStoreConfig('chcore/merged_cssjs/tail') : false;
    }

    public function getMergedJsUrl($files)
    {
        $targetFilename = md5(implode(',', $files)) . '.js';
        $targetDir = $this->_initMergerDir('js');
        if (!$targetDir) {
            return '';
        }
        if ($this->_mergeFiles($files, $targetDir . DS . $targetFilename, false, null, 'js')) {
            $concat = $this->getMergedConcat();
            if($concat) {
                $targetFilename .= '?cdn=' . $concat;
            }
            return Mage::getBaseUrl('media', Mage::app()->getRequest()->isSecure()) . 'js/' . $targetFilename;
        }
        return '';
    }

    public function getMergedCssUrl($files)
    {
        // secure or unsecure
        $isSecure = Mage::app()->getRequest()->isSecure();
        $mergerDir = $isSecure ? 'css_secure' : 'css';
        $targetDir = $this->_initMergerDir($mergerDir);
        if (!$targetDir) {
            return '';
        }

        // base hostname & port
        $baseMediaUrl = Mage::getBaseUrl('media', $isSecure);
        $hostname = parse_url($baseMediaUrl, PHP_URL_HOST);
        $port = parse_url($baseMediaUrl, PHP_URL_PORT);
        if (false === $port) {
            $port = $isSecure ? 443 : 80;
        }

        // merge into target file
        $targetFilename = md5(implode(',', $files) . "|{$hostname}|{$port}") . '.css';
        $mergeFilesResult = $this->_mergeFiles(
            $files, $targetDir . DS . $targetFilename,
            false,
            array($this, 'beforeMergeCss'),
            'css'
        );
        if ($mergeFilesResult) {
            $concat = $this->getMergedConcat();
            if($concat) {
                $targetFilename .= '?cdn=' . $concat;
            }

            return $baseMediaUrl . $mergerDir . '/' . $targetFilename;
        }
        return '';
    }
}
