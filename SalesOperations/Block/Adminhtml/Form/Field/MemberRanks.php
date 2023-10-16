<?php

namespace TrainingBackend\SalesOperations\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use TrainingBackend\SalesOperations\Block\Adminhtml\Form\Field\DiscountTypeColumn;

/**
 * Class Ranges
 */
class MemberRanks extends AbstractFieldArray
{
    /**
     * @var DiscountTypeColumn
     */
    private $taxRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('rank_name', ['label' => __('Rank Name'), 'class' => 'required-entry']);
        $this->addColumn('rank_threshold', ['label' => __('Rank Threshold'), 'class' => 'required-entry']);
        $this->addColumn('discount_amount', ['label' => __('Discount Amount'), 'class' => 'required-entry']);
        $this->addColumn('rank_discount_type', [
            'label' => __('Discount Type'),
            'renderer' => $this->getDiscountTypeRenderer()
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $tax = $row->getTax();
        if ($tax !== null) {
            $options['option_' . $this->getDiscountTypeRenderer()->calcOptionHash($tax)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return DiscountTypeColumn
     * @throws LocalizedException
     */
    private function getDiscountTypeRenderer()
    {
        if (!$this->taxRenderer) {
            $this->taxRenderer = $this->getLayout()->createBlock(
                DiscountTypeColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->taxRenderer;
    }
}
