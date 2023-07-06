<?php

namespace TrainingBackend\RequestFlowProcessing\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

class Router
{
    protected $actionFactory;
    protected $response;
    protected $eventManager;
    protected $url;
    protected $urlFinder;
    protected $storeManager;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ManagerInterface $eventManager,
        UrlInterface $url,
        UrlFinderInterface $urlFinder,
        StoreManagerInterface $storeManager
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->eventManager = $eventManager;
        $this->url = $url;
        $this->urlFinder = $urlFinder;
        $this->storeManager = $storeManager;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        if (strpos($identifier, '-price-') && strpos($identifier, '.html')) {
            $identifierParts = explode('-', $identifier);
            $minPrice = $identifierParts[count($identifierParts) - 2];
            $maxPrice = str_replace('.html', '', $identifierParts[count($identifierParts) - 1]);
            $pathOld = str_replace('-price-'.$minPrice.'-'.$maxPrice,'', $request->getPathInfo());
            $rewrite = $this->getRewrite($pathOld);
            if(empty($rewrite)){
                return null;
            }
            $request->setModuleName('catalog')
                ->setControllerName('category')
                ->setActionName('view')
                ->setParam('id', $rewrite->getEntityId())
                ->setParam('price', $minPrice . '-' . $maxPrice);
            return $this->actionFactory->create(\Magento\Framework\App\Action\Forward::class);
        }
        return null;
    }

    /**
     * Find rewrite based on request data
     *
     * @param string $requestPath
     * @param int $storeId
     * @return UrlRewrite|null
     */
    protected function getRewrite($requestPath)
    {
        return $this->urlFinder->findOneByData(
            [
                UrlRewrite::REQUEST_PATH => ltrim($requestPath, '/'),
                UrlRewrite::STORE_ID => $this->storeManager->getStore()->getId(),
            ]
        );
    }
}
