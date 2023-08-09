<?php
namespace TrainingBackend\DevelopingAdminhtml\Block\Adminhtml\Event\Edit;

class EventForm extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'user_id';
        $this->_controller = 'user';
        $this->_blockGroup = 'Magento_User';
        parent::_construct();

        $this->buttonList->remove('delete');
        $this->buttonList->remove('save');

        $this->addButton(
            'delete',
            [
                'label' => __('Delete'),
                'class' => 'delete',
                'onclick' => 'setLocation(\'' . $this->getDeleteUrl() . ')',
            ]
        );

        $this->addButton(
            'save',
            [
                'label' => __('Save'),
                'class' => 'save primary',
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'save', 'target' => '#edit_form']],
                ]
            ],
            1
        );

        $this->addButton(
            'save_and_edit_button',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ]
        );
    }

    /**
     * Returns message that is displayed for admin when he deletes user from the system.
     * To see this message admin must do the following:
     * - open user's account for editing;
     * - type current user's password in the "Current User Identity Verification" field
     * - click "Delete User" at top left part of the page;
     *
     * @return \Magento\Framework\Phrase
     * @since 101.0.0
     */
    public function getDeleteMessage()
    {
        return __('Are you sure you want to do this?');
    }

    /**
     * Returns the URL that is used for user deletion.
     * The following Action is executed if admin navigates to returned url
     * Magento\User\Controller\Adminhtml\User\Delete
     *
     * @return string
     * @since 101.0.0
     */
    public function getDeleteUrl()
    {
        $id = <<<script
        document.querySelector('div[aria-hidden="false"] .event_id').value
        script;
        return $this->getUrl('deveadmin/events/delete/')."id/' +".$id;
    }

    /**
     * Get form save URL
     *
     * @see getFormActionUrl()
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('deveadmin/events/save');
    }

    /**
     * This method is used to get the ID of the user who's account the Admin is editing.
     * It can be used to determine the reason Admin opens the page:
     * to create a new user account OR to edit the previously created user account
     *
     * @return int
     * @since 101.0.0
     */
    public function getObjectId()
    {
        return (int)$this->getRequest()->getParam($this->_objectId);
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('permissions_user')->getId()) {
            $username = $this->escapeHtml($this->_coreRegistry->registry('permissions_user')->getUsername());
            return __("Edit User '%1'", $username);
        } else {
            return __('New User');
        }
    }
}
