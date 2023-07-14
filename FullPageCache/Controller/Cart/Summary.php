<?php

namespace TrainingBackend\FullPageCache\Controller\Cart;

use Magento\Checkout\Model\Cart\RequestQuantityProcessor;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Serialize\SerializerInterface;

class Summary extends \Magento\Checkout\Controller\Cart\UpdatePost
{
    protected $_pageFactory;
    protected $layoutFactory;
    protected $resultRawFactory;
    protected $json;

    public function __construct
    (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        SerializerInterface $json,
        RequestQuantityProcessor $quantityProcessor = null
    )
    {
        $this->json = $json;
        parent::__construct($context, $scopeConfig, $checkoutSession, $storeManager, $formKeyValidator, $cart, $quantityProcessor);
    }

    public function execute()
    {
        $updateAction = (string)$this->getRequest()->getParam('update_cart_action');
        switch ($updateAction) {
            case 'empty_cart':
                $this->_emptyShoppingCart();
                break;
            case 'update_qty':
                $this->_updateShoppingCart();
                break;
            default:
                $this->_updateShoppingCart();
        }
        /** @var \Magento\Framework\View\Result\Page $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $layout = $response->addHandle('checkout_cart_index')->getLayout();
        $response = $layout->getBlock('checkout.cart.form')->toHtml();
        return $this->jsonResponse($response);
    }

    /**
     * JSON response builder.
     *
     * @param string $data
     * @return void
     */
    private function jsonResponse(string $data)
    {
        $this->getResponse()->representJson(
            $this->json->serialize($this->getResponseData($data))
        );
    }

    /**
     * Returns response data.
     *
     * @param string $data
     * @return array
     */
    private function getResponseData(string $data): array
    {
        $response = ['success' => false];

        if (!empty($data)) {
            $response = [
                'success' => true,
                'data' => $data,
            ];
        }

        return $response;
    }
}
