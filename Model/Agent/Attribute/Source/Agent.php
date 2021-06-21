<?php
namespace AHT\Sa\Model\Agent\Attribute\Source;

class Agent extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $_collectionFactory;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    public function getAllOptions()
    {
        $type = [];
        $type[] = [
                'value' => '',
                'label' => '--Select--'
        ];

        $customers = $this->_collectionFactory->create()->addAttributeToFilter('is_sales_agent', 1);
        
        foreach($customers as $c)
        {
            $text = $c->getFirstname() .' ' .$c->getMiddlename().' ' .$c->getLastname();
            $type[] = [
                'value' => $c->getId(),
                'label' => $text
            ];
        }
       
        return $type;
    }

    public function getOptionText($value) 
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
