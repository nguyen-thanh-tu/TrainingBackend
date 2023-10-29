<?php

namespace TrainingBackend\SalesOperations\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\LoginAsCustomerAdminUi\Ui\Customer\Component\ConfirmationPopup\Options;
use Magento\LoginAsCustomerApi\Api\ConfigInterface;
use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;

class ConfirmationPopup extends Template
{
    /**
     * @var StoreOptions
     */
    private $storeOptions;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var Json
     */
    private $json;

    /**
     * @var Options
     */
    private $options;

    /**
     * @param Template\Context $context
     * @param StoreOptions $storeOptions
     * @param ConfigInterface $config
     * @param Json $json
     * @param array $data
     * @param Options|null $options
     */
    public function __construct(
        Template\Context $context,
        StoreOptions $storeOptions,
        ConfigInterface $config,
        Json $json,
        array $data = [],
        ?Options $options = null
    ) {
        parent::__construct($context, $data);
        $this->storeOptions = $storeOptions;
        $this->config = $config;
        $this->json = $json;
        $this->options = $options ?? ObjectManager::getInstance()->get(Options::class);
    }

    /**
     * @inheritdoc
     * @since 100.4.0
     */
    public function toHtml()
    {
        if (!$this->config->isEnabled()) {
            return '';
        }
        return parent::toHtml();
    }
}
