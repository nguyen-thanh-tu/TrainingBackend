<?php

namespace TrainingBackend\RequestFlowProcessing\Plugin;

use Magento\Catalog\Model\Layer\Filter\Item as FilterItem;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class CustomPriceFilterPlugin
{
    protected $request;
    protected $url;

    public function __construct(
        RequestInterface $request,
        UrlInterface $url
    ) {
        $this->request = $request;
        $this->url = $url;
    }

    public function aroundGetUrl(
        FilterItem $subject,
        callable $proceed
    ) {
        $requestVar = $subject->getFilter()->getRequestVar();
        if ($requestVar === 'price') {
            $url = str_replace('.html', '', $this->url->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]).'-'.$requestVar.'-'.$subject->getValue()).'.html';
        }else{
            $url = $proceed();
        }
        return $url;
    }
}
