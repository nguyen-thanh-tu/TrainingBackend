<?php
declare(strict_types=1);

namespace TrainingBackend\CustomizeCheckout\Block\Checkout;

use TrainingBackend\CustomizeCheckout\Helper\Data as Helper;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Customer\Model\Url;
use Magento\Framework\App\Http\Context;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\Url\Helper\Data;
use Magento\Customer\Model\Session;

class LoginStepProcessor implements LayoutProcessorInterface
{
    /**
     * @var ArrayManager
     */
    private ArrayManager $arrayManager;

    /**
     * @var Context
     */
    private Context $httpContext;

    /**
     * @var string
     */
    protected string $childrenStepsPath = 'components/checkout/children/steps';

    /**
     * @var string
     */
    protected string $customerEmailPath = 'components/checkout/children/steps' .
        '/children/shipping-step/children/shippingAddress/children/customer-email';

    /**
     * @var string
     */
    protected string $loginFormPath = 'components/checkout/children/steps/children/' .
        'login-step/children/login/children/login-form';

    /**
     * @var Url
     */
    private Url $customerUrl;

    /**
     * @var Data
     */
    private Data $coreUrl;

    /**
     * @var Helper
     */
    private Helper $helper;

    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @param ArrayManager $arrayManager
     * @param Context $httpContext
     * @param Url $customerUrl
     * @param Data $coreUrl
     * @param Helper $helper
     */
    public function __construct(
        ArrayManager $arrayManager,
        Context $httpContext,
        Url $customerUrl,
        Data $coreUrl,
        Helper $helper,
        Session $customerSession
    ) {
        $this->arrayManager = $arrayManager;
        $this->httpContext = $httpContext;
        $this->customerUrl = $customerUrl;
        $this->coreUrl = $coreUrl;
        $this->helper = $helper;
        $this->customerSession = $customerSession;
    }

    /**
     * @inheritdoc
     */
    public function process($jsLayout): array
    {
        if (!$this->helper->isEnabled()) {
            return $jsLayout;
        }

        if ($this->httpContext->getValue(CustomerContext::CONTEXT_AUTH)) {
            return $jsLayout;
        }

        if (!$this->arrayManager->exists($this->childrenStepsPath, $jsLayout)) {
            return $jsLayout;
        }
        if (!$this->arrayManager->exists($this->customerEmailPath, $jsLayout)) {
            return $jsLayout;
        }

        if (!$this->customerSession->isLoggedIn()) {
            $jsLayout = $this->createLoginStepComponents($jsLayout);
            $jsLayout = $this->createLoginFormComponent($jsLayout);
        }

        return $jsLayout;
    }

    /**
     * Create login form component
     *
     * @param array $jsLayout
     * @return array
     */
    protected function createLoginFormComponent(array $jsLayout): array
    {
         $component = array_merge(
             $this->arrayManager->get($this->customerEmailPath, $jsLayout),
             [
                 'component' => 'TrainingBackend_CustomizeCheckout/js/view/form/login',
                 'template' => 'TrainingBackend_CustomizeCheckout/form/login',
                 'displayArea' => 'login-form'
             ]
         );

        $jsLayout = $this->arrayManager->set($this->loginFormPath, $jsLayout, []);
        $jsLayout = $this->arrayManager->merge(
            $this->loginFormPath,
            $jsLayout,
            $component
        );

        return $jsLayout;
    }

    /**
     * Create login step components
     *
     * @param array $jsLayout
     * @return array
     */
    protected function createLoginStepComponents(array $jsLayout): array
    {
        $createAccountComponent = [
            'component' => 'uiComponent',
            'template' => 'TrainingBackend_CustomizeCheckout/login/create-account',
            'displayArea' => 'create-account',
            'createAccountUrl' => $this->getCreateAccountUrl()
        ];
        $proceedWithoutLoginComponent = [
            'component' => 'uiComponent',
            'template' => 'TrainingBackend_CustomizeCheckout/login/proceed-without-login',
            'displayArea' => 'proceed-without-login'
        ];

        return $this->arrayManager->merge(
            $this->childrenStepsPath . '/children',
            $jsLayout,
            [
                'login-step' => [
                    'component' => 'uiComponent',
                    'sortOrder' => 0,
                    'children' => [
                        'login' => [
                            'component' => 'TrainingBackend_CustomizeCheckout/js/view/login',
                            'template' => 'TrainingBackend_CustomizeCheckout/login',
                            'sortOrder' => 0,
                            'config' => [
                                'deps' => [
                                    'checkout.sidebar.summary'
                                ]
                            ],
                            'children' => [
                                'create-account' => $createAccountComponent,
                                'proceed-without-login' => $proceedWithoutLoginComponent
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    /**
     * Get create account url
     *
     * @return string
     */
    private function getCreateAccountUrl(): string
    {
        $url = $this->customerUrl->getRegisterUrl();
        $url = $this->coreUrl->addRequestParam($url, ['context' => 'checkout']);

        return $url;
    }
}
