<?php
namespace AHT\Sa\Controller\Adminhtml\Commission;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
    
class Account extends \Magento\Backend\App\Action
{
    protected $_pageFactory;
    
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }
    
    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__(' heading '));

        $block = $resultPage->getLayout()
                ->createBlock('AHT\Sa\Block\Commission\CommissionAccount')
                ->setTemplate('AHT_Sa::account_commission.phtml')
                ->toHtml();
        $this->getResponse()->setBody($block);
    }
}

