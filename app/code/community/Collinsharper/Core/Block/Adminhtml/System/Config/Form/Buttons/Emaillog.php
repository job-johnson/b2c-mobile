<?php


class Collinsharper_Core_Block_Adminhtml_System_Config_Form_Buttons_Emaillog extends Collinsharper_Core_Block_Adminhtml_System_Config_Form_Buttons_Clearlog
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {



        $url    = Mage::helper('adminhtml')->getUrl('adminhtml/chcore/emaillogs/');
        $data = <<<EOD
EOD;

        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'chcoreemaillog',
                'label'     => $this->helper('chcore')->__('Download Logs'),
                'onclick'   => 'setLocation(\'' . $url . '\')'
            ));

        return $data . $button->toHtml();
    }

}