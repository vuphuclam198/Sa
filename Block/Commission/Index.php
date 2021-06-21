<?php
namespace AHT\Sa\Block\Commission;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $_collectionFactory;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productCollectionFactory;

    /**
     * @param \Magento\Customer\Model\Session
     */
    private $_customerSession;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getProducts () {
        $user = $this->_customerSession->getCustomer()->getId();
        $products = $this->_productCollectionFactory->create()->addAttributeToFilter('sale_agent_id', $user)->addAttributeToSelect('*');
        return $products;
    }
}
