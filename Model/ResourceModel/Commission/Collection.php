<?php
namespace AHT\Sa\Model\ResourceModel\Commission;

use Magento\Catalog\Model\Product;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\Log\LoggerInterface as Logger;
use Magento\Sales\Model\ResourceModel\Order\Item;
use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Sales\Model\Order\Item as ItemOrder;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    private $eavAttribute;

    protected $itemOrder;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;

    public function __construct(
        Attribute $eavAttribute,
        ItemOrder $itemOrder,
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        array $addFilterStrategies = [],
        $mainTable = 'commission',
        $resourceModel = Item::class,
        $identifierName = null,
        $connectionName = null
    )
    {
        $this->addFilterStrategies = $addFilterStrategies;
        $this->itemOrder = $itemOrder;
        $this->eavAttribute = $eavAttribute;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel, $identifierName, $connectionName);
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()
            ->joinLeft(
                ['order' => $this->getTable('sales_order_item')],
                'main_table.order_id = order.order_id'
            )->joinLeft(
                ['product' => $this->getTable('catalog_product_entity_int')],
                "order.product_id = product.entity_id AND product.attribute_id = {$this->getProductNameAttributeId()}"  
            )->joinLeft(
                ['customer' => $this->getTable('customer_entity')],
                "product.value = customer.entity_id",
                ['fullname_agent' =>'CONCAT(customer.lastname, " ", customer.firstname)'] 
            );

        return $this;
    }

    private function getProductNameAttributeId()
    {
        return $this->getProductAttribute('sale_agent_id');
    }

    private function getProductAttribute($code)
    {
        return $this->eavAttribute->getIdByCode(Product::ENTITY, $code);
    }
}
