<?php
namespace AHT\Sa\Observer;

class Observer implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    private $_orderFactory;

    /**
     * @param \Magento\Catalog\Model\ProductFactory
     */
    private $_productFactory;

    /**
     * @param \AHT\Sa\Model\ResourceModel\Commission
     */
    private $_commissionFactory;

    /**
     * @param \AHT\Sa\Model\ResourceModel\Commission
     */
    private $commissionResourceFactory;

    public function __construct(
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \AHT\Sa\Model\CommissionFactory $commissionFactory,
        \AHT\Sa\Model\ResourceModel\Commission $commissionResourceFactory
    
    )
    {
        $this->_orderFactory = $orderFactory;
        $this->_productFactory = $productFactory;
        $this->_commissionFactory = $commissionFactory;
        $this->commissionResourceFactory = $commissionResourceFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $idOrder = $observer->getData('order_ids');
        $oderProduct = $this->_orderFactory->create()->load($idOrder);
        
        foreach ($oderProduct->getAllVisibleItems() as $item) {
            $product = $this->_productFactory->create()->getCollection();
            $product->addAttributeToFilter('entity_id', $item->getProductId())
            ->addAttributeToSelect('*')->load();

            $commission = $this->_commissionFactory->create();

            foreach ($product as $value) {

                if(!($value->getCommissionType() == '')) {
                    $commission->setOrderId($oderProduct->getId());
                    $commission->setOrderItemId($value->getId());
                    $commission->setOrderItemSku($value->getSku());
                    $commission->setOrderItemPrice($value->getPrice() * $oderProduct->getData('total_qty_ordered'));
                    $commission->setCommissionType($value->getCommissionType());
                    $commission->setCommissionValue($value->getCommissionValue());
        
                    $commission->save();
                }
            }  
        }
    }
}