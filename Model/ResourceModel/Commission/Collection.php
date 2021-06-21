<?php
namespace AHT\Sa\Model\ResourceModel\Commission;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'aht_sa_commission_collection';
    protected $_eventObject = 'commission_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AHT\Sa\Model\Commission', 'AHT\Sa\Model\ResourceModel\Commission');
    }
}
