<?php

namespace TrainingBackend\FullPageCache\Controller\Cart;

use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\StoreManagerInterface;

class Delete extends \Magento\Checkout\Controller\Cart implements HttpPostActionInterface
{
    protected $json;

    public function __construct
    (
        Context $context,
        ScopeConfigInterface $scopeConfig,
        Session $checkoutSession,
        StoreManagerInterface $storeManager,
        Validator $formKeyValidator,
        CustomerCart $cart,
        SerializerInterface $json
    )
    {
        $this->json = $json;
        parent::__construct($context, $scopeConfig, $checkoutSession, $storeManager, $formKeyValidator, $cart);
    }

    public function execute()
    {
        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $data = false;
        $id = (int)$this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->cart->removeItem($id);
                // We should set Totals to be recollected once more because of Cart model as usually is loading
                // before action executing and in case when triggerRecollect setted as true recollecting will
                // executed and the flag will be true already.
                $this->cart->getQuote()->setTotalsCollectedFlag(false);
                $this->cart->save();
                $data = true;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t remove the item.'));
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
            }
        }
        return $this->jsonResponse($data);
    }

    /**
     * JSON response builder.
     *
     * @param bool $data
     * @return void
     */
    private function jsonResponse(bool $data)
    {
        $this->getResponse()->representJson(
            $this->json->serialize($this->getResponseData($data))
        );
    }

    /**
     * Returns response data.
     *
     * @param bool $data
     * @return array
     */
    private function getResponseData(bool $data): array
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
