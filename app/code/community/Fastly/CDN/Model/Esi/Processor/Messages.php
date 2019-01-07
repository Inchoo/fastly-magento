<?php

class Fastly_CDN_Model_Esi_Processor_Messages extends Fastly_CDN_Model_Esi_Processor_Abstract
{
    /**
     * @return string
     */
    public function getHtml()
    {
        $this->_fetchFromSession();
        return parent::getHtml();
    }

    /**
     * Get messages from session
     * @return mixed
     */
    protected function _fetchFromSession()
    {
        $handle = 'messages';
        $content = Mage::getSingleton('checkout/session')->getData($handle);
        Mage::getSingleton('checkout/session')->unsetData($handle);

        $this->_block->setMessages($content);

        return $content;
    }

    public function getEsiBlockTtl($block)
    {
        return 0;
    }
}
