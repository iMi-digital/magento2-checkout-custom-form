<?php

namespace Bodak\CheckoutCustomForm\Plugin;

use Bodak\CheckoutCustomForm\Api\Data\CustomFieldsInterface;
use Bodak\CheckoutCustomForm\Model\CustomFieldsRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderExtensionFactory;

class OrderGet
{
    protected $orderExtensionFactory;
    protected $_customerRepositoryInterface;
    protected $customFieldsFactory;

    /**
     * OrderGet constructor.
     *
     * @param OrderExtensionFactory $orderExtensionFactory
     * @param CustomFieldsRepository $customFieldsRepository
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     */
    public function __construct(
        OrderExtensionFactory $orderExtensionFactory,
        \Bodak\CheckoutCustomForm\Api\Data\CustomFieldsFactory $customFieldsFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->orderExtensionFactory        = $orderExtensionFactory;
        $this->customFieldsFactory       = $customFieldsFactory;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }


    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface $order
    ) {
//        $this->customFieldsFactory->create();

//        $customFields = $this->customFieldsRepository->getCustomFields($order);
        $customFields = $this->customFieldsFactory->create();
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes->setExtraCheckoutFields($customFields->getCheckoutComment());
        $order->setExtensionAttributes($extensionAttributes);
        return $order;
    }
}