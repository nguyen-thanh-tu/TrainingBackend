<?php

namespace TrainingBackend\EAV\Block\Adminhtml\Merchant;

class SelectStatus extends \Magento\Backend\Block\Widget\Grid\Column\Filter\Select
{
    protected $merchantStatus;

    public function __construct
    (
        \Magento\Backend\Block\Context $context,
        \Magento\Framework\DB\Helper $resourceHelper,
        \TrainingBackend\EAV\Model\Config\Source\MerchantStatus $merchantStatus,
        array $data = []
    )
    {
        $this->merchantStatus = $merchantStatus;
        parent::__construct($context, $resourceHelper, $data);
    }

    /**
     * Get grid options
     *
     * @return array
     */
    protected function _getOptions()
    {
        return $this->merchantStatus->toOptionArray();
    }

    /**
     * Get condition
     *
     * @return int
     */
    public function getCondition()
    {
        if ($this->getValue() == 1) {
            return 1;
        } elseif ($this->getValue() == 2) {
            return 2;
        } elseif ($this->getValue() == 3) {
            return 3;
        } else {
            return 4;
        }
    }
}
