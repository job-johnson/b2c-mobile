<?php


class Collinsharper_Core_Block_Adminhtml_System_Config_Form_Buttons_Disablelog extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _prepareLayout()
    {

        parent::_prepareLayout();

        if (!$this->getTemplate()) {

            $this->setTemplate('collinsharper/system/config/buttons/generic.phtml');

        }

        return $this;

    }


    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }



    public function getJsScript()
    {
        return '';
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $url    = Mage::helper('adminhtml')->getUrl('adminhtml/chcore/disablelogs/');
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'chcoredisablelog',
                'label'     => $this->helper('adminhtml')->__('Disable logging'),
                'onclick'   => 'setLocation(\'' . $url . '\')'
            ));

        return $button->toHtml();
    }

}
