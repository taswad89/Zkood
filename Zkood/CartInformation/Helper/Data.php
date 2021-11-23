<?php

namespace Zkood\CartInformation\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const MODULE_ENABLE_DISABLE = 'cartinformation_config/general/enable';
	
	const DISABLE_GUEST_USER = 'cartinformation_config/general/disable_guest_user';
	
    public function __construct(
	\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }
	
	public function setStoreScope()
	{
		return ScopeInterface::SCOPE_STORE;
	}
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(static::MODULE_ENABLE_DISABLE, $this->setStoreScope());
    }
	public function disableGuest()
    {
        return $this->scopeConfig->getValue(static::DISABLE_GUEST_USER, $this->setStoreScope());
    }
}