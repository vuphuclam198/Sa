<?php
namespace AHT\Sa\Model\Product\Attribute\Source;

class CommissionType extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
public function getAllOptions()
  {
          $this->_options = [
              ['label' => __('Select option ...'), 'value' => ''],
              ['label' => __('fixed'), 'value' => 1],
              ['label' => __('percent'), 'value' => 2],
          ];
      return $this->_options;
  }
}