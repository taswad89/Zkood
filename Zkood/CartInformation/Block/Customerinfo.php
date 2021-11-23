<?php

namespace Zkood\CartInformation\Block;

class Customerinfo extends \Magento\Framework\View\Element\Template
{
	protected $helper;
	
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
		\Zkood\CartInformation\Helper\Data $helper,
		\Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = []
    ) {
        $this->httpContext = $httpContext;
		$this->_helper = $helper;
		$this->_objectManager = $objectManager;
        parent::__construct($context, $data);
    }
	
    public function getLogin() {
		if($this->_helper->isEnabled()){
			$customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
			return $customerSession->isLoggedIn();
		}
			//return $this->httpContext->isLoggedIn();
    }
}
?>

