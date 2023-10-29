<?php

namespace TrainingBackend\SalesOperations\Plugin\Button;

use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Backend\Block\Widget\Button\ToolbarInterface;
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\AbstractBlock;
use TrainingBackend\SalesOperations\Ui\Customer\Component\Button\DataProvider;

class ToolbarPlugin
{
    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var DataProvider
     */
    private $dataProvider;

    /**
     * ToolbarPlugin constructor.
     * @param Escaper $escaper
     * @param DataProvider $dataProvider
     */
    public function __construct(
        Escaper $escaper,
        DataProvider $dataProvider
    ) {
        $this->escaper = $escaper;
        $this->dataProvider = $dataProvider;
    }

    /**
     * Add Login as Customer button.
     *
     * @param ToolbarInterface $subject
     * @param AbstractBlock $context
     * @param ButtonList $buttonList
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforePushButtons(
        ToolbarInterface $subject,
        AbstractBlock $context,
        ButtonList $buttonList
    ): void {
        $nameInLayout = $context->getNameInLayout();

        $order = $this->getOrder($nameInLayout, $context);
        if ($order && $order->getStatus() === 'pending' && !empty($order['customer_id'])) {
            $customerId = (int)$order['customer_id'];
            $buttonList->add(
                'confỉm_order_button',
                $this->dataProvider->getData($customerId),
                -2
            );
        }
    }

    /**
     * Extract order data from context.
     *
     * @param string $nameInLayout
     * @param AbstractBlock $context
     * @return array|null
     */
    private function getOrder(string $nameInLayout, AbstractBlock $context)
    {
        switch ($nameInLayout) {
            case 'sales_order_edit':
                return $context->getOrder();
        }

        return null;
    }
}
