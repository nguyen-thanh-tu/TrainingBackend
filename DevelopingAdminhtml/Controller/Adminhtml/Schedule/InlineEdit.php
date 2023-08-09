<?php

namespace TrainingBackend\DevelopingAdminhtml\Controller\Adminhtml\Schedule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteFactory as UrlRewriteFactoryAlias;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use TrainingBackend\DevelopingAdminhtml\Model\ScheduleFactory;

class InlineEdit extends Action implements HttpPostActionInterface
{
    /**
     * @var ScheduleFactory
     */
    private $scheduleFactory;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @param Context $context
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param UrlRewriteFactoryAlias $urlRewriteResourceFactory
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        ScheduleFactory $scheduleFactory,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->scheduleFactory = $scheduleFactory;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Inline edit save action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam(
            'items',
            []
        );

        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data sent.')],
                    'error' => true,
                ]
            );
        }

        $this->scheduleFactory->create()->setData(reset($postItems))->save();

        $messages[] = __('Success.');

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }
}
