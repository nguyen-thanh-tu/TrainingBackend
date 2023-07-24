<?php

namespace TrainingBackend\EAV\Block\Adminhtml\Merchant;

use Magento\Backend\Block\Context;

class RendererCategory extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $merchantCategory;

    public function __construct
    (
        Context $context,
        \TrainingBackend\EAV\Model\Config\Source\Category $merchantCategory,
        array $data = [])
    {
        $this->merchantCategory = $merchantCategory;
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
        $categoryLabels = [];
        if ($categoryIds = explode(',', $row->getCategory())) {
            foreach($categoryIds as $categoryId)
            {
                $categoryLabels[] = $this->merchantCategory->toOptionArray()[$categoryId]['label'];
            }
        }
        return __(implode(', ', $categoryLabels));
    }
}
