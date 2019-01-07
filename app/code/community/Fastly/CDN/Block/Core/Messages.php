<?php

class Fastly_CDN_Block_Core_Messages extends Mage_Core_Block_Messages
{

    /**
     * Save original data into session, return ESI tag for the page
     * @return string
     * @throws Exception
     */
    protected function _toHtml()
    {
        if (Mage::helper('fastlycdn')->canUseEsi() == false) {
            return parent::_toHtml();
        }

        $request = $this->getRequest();
        if ($request->getControllerName() == 'esi') {
            return parent::_toHtml();
        }

        $handle = $this->getNameInLayout();
        Mage::getSingleton('checkout/session')->setData('fastly_messages_' . $handle, $this->getMessageCollection());

        $esiTagModel = Mage::getModel(
            'fastlycdn/esi_tag_messages',
            array(Mage::helper('fastlycdn')->getLayoutNameParam() => $handle)
        );

        $esiTag = $esiTagModel->getEsiIncludeTag($this);

        return $esiTag;
    }

    public function _prepareLayout()
    {
        $request = $this->getRequest();
        if ($request->getControllerName() == 'esi' && $request->getParam('layout_name') !== 'messages') {
            return $this;
        }

        return parent::_prepareLayout();
    }
}
