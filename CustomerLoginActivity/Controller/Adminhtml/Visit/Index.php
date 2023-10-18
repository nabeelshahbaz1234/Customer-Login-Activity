<?php
declare(strict_types=1);

namespace Pixafy\CustomerLoginActivity\Controller\Adminhtml\Visit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * @Class Index
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @const ADMIN_RESOURCE
     */
    const ADMIN_RESOURCE = 'Pixafy_CustomerLoginActivity::key2';

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::ADMIN_RESOURCE);
        $resultPage->addBreadcrumb(__('Customer Data'), __('Customer Data'));
        $resultPage->addBreadcrumb(__('Customer Data'), __('Customer Data'));
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Visitor Log'));
        return $resultPage;
    }
}
