<?php

namespace TrainingBackend\EAV\Block\Adminhtml\Merchant;

use Magento\Backend\Block\Context;

class RendererStatus extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $merchantStatus;

    public function __construct
    (
        Context $context,
        \TrainingBackend\EAV\Model\Config\Source\MerchantStatus $merchantStatus,
        array $data = [])
    {
        $this->merchantStatus = $merchantStatus;
        parent::__construct($context, $data);
    }

    /**
     * Render review type
     *
     * @param \Magento\Framework\DataObject $row
     * @return \Magento\Framework\Phrase
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        if ($status = (int)$row->getMerchantStatus()) {
            return $this->merchantStatus->toOptionArray()[$status]['label'];
        }
        return __('');
    }
}
