<?php

namespace TrainingBackend\SalesOperations\Plugin;

use Magento\Sales\Api\Data\InvoiceInterface;

class InvoiceServicePlugin
{
    public function afterPrepareInvoice(
        \Magento\Sales\Model\Service\InvoiceService $subject,
        InvoiceInterface                            $result,
                                                    $invoice,
                                                    $qtys
    )
    {
        // Calculate and apply the discount from the order to the invoice
        $order = $result->getOrder();
        $discountAmount = $order->getDiscountAmount(); // Get the discount amount from the order

        if ($discountAmount < 0) {
            $result->setDiscountAmount($discountAmount);
            // Update the totals
            $result->setGrandTotal($result->getGrandTotal() + $discountAmount);
            $result->setBaseGrandTotal($result->getBaseGrandTotal() + $discountAmount);
        }

        return $result;
    }

}
