<?php

namespace TrainingBackend\RequestFlowProcessing\Plugin\Catalog\Product;

use Magento\Catalog\Helper\Product\View as ProductViewHelper;
use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject;
use Magento\Framework\View\Result\Page as ResultPage;
use Magento\Framework\View\Result\Page;

class AddCustomLayoutHandleToProductPlugin
{
    const PRODUCT_LAYOUT_HANDLE = 'catalog_product_view_price_';
    const PRICE_RANGES = ['0-50', '50-120', '120-190', '192-250', '250'];
    /**
     * @param  ProductViewHelper $subject
     * @param  Page            $resultPage
     * @param  Product         $product
     * @param  null|DataObject $params
     * @return array
     */
    public function beforeInitProductLayout(
        ProductViewHelper $subject,
                          $resultPage,
                          $product,
                          $params
    ) {
        foreach(self::PRICE_RANGES as $range){
            $rangeArray = explode('-', $range);
            $fromPrice = reset($rangeArray);
            $toPrice = end($rangeArray);
            $finalPrice = $product->getPrice();
            if($finalPrice > $fromPrice && $resultPage instanceof ResultPage){
                if($finalPrice < $toPrice){
                    $resultPage->addHandle([self::PRODUCT_LAYOUT_HANDLE.$fromPrice.'_'.$toPrice]);
                    break;
                }elseif(count($rangeArray) == 1){
                    $resultPage->addHandle([self::PRODUCT_LAYOUT_HANDLE.$fromPrice.'_above']);
                    break;
                }
            }
        }
        return [
            $resultPage,
            $product,
            $params
        ];
    }
}
