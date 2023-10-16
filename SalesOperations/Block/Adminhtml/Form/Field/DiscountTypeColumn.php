<?php
declare(strict_types=1);

namespace TrainingBackend\SalesOperations\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;

class DiscountTypeColumn extends Select
{
    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    private function getSourceOptions(): array
    {
        return [
            ['value' => 'percentage', 'label' => __('Percentage (%)')],
            ['value' => 'fixed', 'label' => __('Fixed Amount')],
        ];
    }
}