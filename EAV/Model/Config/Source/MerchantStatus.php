<?php

namespace TrainingBackend\EAV\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class MerchantStatus implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            1 => ['value' => '1', 'label' => __('Active')],
            2 => ['value' => '2', 'label' => __('Pending')],
            3 => ['value' => '3', 'label' => __('Blocked')],
            4 => ['value' => '4', 'label' => __('Rejected')],
        ];
    }
}
