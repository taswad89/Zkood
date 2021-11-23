<?php

namespace Zkood\CartInformation\Controller\Export;

class CartInfo extends \Magento\Framework\App\Action\Action
{
	protected $fileFactory;
	protected $csvProcessor;
	protected $directoryList;

	public function __construct(
        \Magento\Framework\App\Action\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectmanager,
    	\Magento\Framework\App\Response\Http\FileFactory $fileFactory,
    	\Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
	)
	{
    	$this->objectManager 	= $objectmanager;
		$this->fileFactory 		= $fileFactory;
    	$this->csvProcessor 	= $csvProcessor;
    	$this->directoryList 	= $directoryList;
    	parent::__construct($context);
	}

	public function execute()
	{
    	$fileName = 'cartinfo.csv';
    	$filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
        	. "/" . $fileName;

		$cart = $this->objectManager->get('\Magento\Checkout\Model\Cart'); 

    	$cartData = $this->getCartData($cart);

    	$this->csvProcessor
    	    ->setDelimiter(';')
        	->setEnclosure('"')
        	->saveData(
            	$filePath,
            	$cartData
        	);
			
    	return $this->fileFactory->create(
        	$fileName,
        	[
            	'type' => "filename",
            	'value' => $fileName,
            	'rm' => true,
        	],
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
        	'application/octet-stream'
    	);
	}

	protected function getCartData(\Magento\Checkout\Model\Cart $cart)
	{
    	$result = [];
		// get quote items collection
		$itemsCollection = $cart->getQuote()->getItemsCollection();
		 
		// get array of all items what can be display directly
		$itemsVisible = $cart->getQuote()->getAllVisibleItems();
		 
		// get quote items array
		$items = $cart->getQuote()->getAllItems();
		
    	$result[] = [
        	'item_name',
        	'sku',
        	'quantity',
        	'price'
    	];

		foreach($items as $item) {
        	$result[] = [
            	$item->getName(),
            	$item->getSku(),
            	$item->getQty(),
            	$item->getPrice()
        	];
    	}
    	return $result;
	}
}