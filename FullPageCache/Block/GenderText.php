<?php

namespace TrainingBackend\FullPageCache\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;

class GenderText extends Template
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Template\Context $context
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Session          $customerSession,
        array            $data = []
    )
    {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
    }

    /**
     * Check if customer is logged in
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    /**
     * Get customer's gender
     *
     * @return string|null
     */
    public function getGender()
    {
        $Gender = null;
        if ($this->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            switch ($customer->getGender()) {
                case 1:
                    $Gender = 'male';
                    break;
                case 2:
                    $Gender = 'female';
                    break;
            }
        }
        return $Gender;
    }
}
