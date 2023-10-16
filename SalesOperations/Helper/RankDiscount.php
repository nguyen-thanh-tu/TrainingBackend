<?php

namespace TrainingBackend\SalesOperations\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class RankDiscount
{
    protected $scopeConfig;

    protected $customer;

    protected $jsonSerializer;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Customer\Model\CustomerFactory $customer
     * @param SerializerInterface $jsonSerializer
     */
    public function __construct(
        ScopeConfigInterface                              $scopeConfig,
        \Magento\Customer\Model\CustomerFactory           $customer,
        SerializerInterface                               $jsonSerializer
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->customer = $customer;
        $this->jsonSerializer = $jsonSerializer;
    }

    public function getRankDiscount($customerId, $totalAmount)
    {
        $customer = $this->customer->create()->load($customerId);
        $config = $this->jsonSerializer->unserialize($this->scopeConfig->getValue('sales_operations/member_rank/member_rank'));
        $min = $max = '0';
        foreach ($config as $rank) {
            $max = $rank['rank_threshold'];
            if ($min < $customer->getRankPoint() && $customer->getRankPoint() < $max) {
                if($rank['rank_discount_type'] == 'percentage'){
                    $totalAmount = $totalAmount * ($rank['discount_amount'] / 100);
                }else{
                    $totalAmount = $totalAmount - $rank['discount_amount'];
                }
            };
            $min = $rank['rank_threshold'];
        }
        return $totalAmount;
    }
}
