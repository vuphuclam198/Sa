<?php
namespace AHT\Sa\Block\Commission;

class CommissionAccount extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \AHT\Sa\Model\ResourceModel\Commission\CollectionFactory
     */
    private $_commissionCollectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \AHT\Sa\Model\ResourceModel\Commission\CollectionFactory $commissionCollectionFactory,
        array $data = []
    ) {
        $this->_commissionCollectionFactory = $commissionCollectionFactory;
        parent::__construct($context, $data);   
    }

    public function getCommission() {
        $commission = $this->_commissionCollectionFactory->create();
        return $commission;
    }
}
