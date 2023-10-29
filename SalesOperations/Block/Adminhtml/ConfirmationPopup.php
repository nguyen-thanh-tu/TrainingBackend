<?php

namespace TrainingBackend\SalesOperations\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;
use Magento\User\Model\ResourceModel\User\CollectionFactory as AdminUserCollection;
use Magento\Framework\Registry;

class ConfirmationPopup extends Template
{
    /**
     * @var StoreOptions
     */
    private $storeOptions;

    /**
     * @var Json
     */
    private $json;

    /**
     * @var AdminUserCollection
     */
    private $userCollectionFactory;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @param Template\Context $context
     * @param StoreOptions $storeOptions
     * @param ConfigInterface $config
     * @param Json $json
     * @param AdminUserCollection $userCollectionFactory
     * @param Registry $registry
     * @param array $data
     * @param Options|null $options
     */
    public function __construct(
        Template\Context $context,
        StoreOptions $storeOptions,
        Json $json,
        AdminUserCollection $userCollectionFactory,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->storeOptions = $storeOptions;
        $this->json = $json;
        $this->userCollectionFactory = $userCollectionFactory;
        $this->registry = $registry;
    }

    public function getAdminUsers()
    {
        $adminUsers = [];

        foreach ($this->userCollectionFactory->create() as $user) {
            $adminUsers[] = [
                'value' => $user->getId(),
                'label' => $user->getName()
            ];
        }

        return $adminUsers;
    }

    /**
     * Retrieve order model object
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->registry->registry('sales_order');
    }
}
