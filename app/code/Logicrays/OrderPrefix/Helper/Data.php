<?php
/**
 * Logicrays
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Logicrays
 * @package     Logicrays_OrderPrefix
 * @copyright   Copyright (c) Logicrays (https://www.logicrays.com/)
 */
declare(strict_types=1);

namespace Logicrays\OrderPrefix\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * For Decalre all the method for get the Data
 */
class Data extends AbstractHelper
{
    public const MODULE_ENABLE = 'orderprefix/general/enable';
    public const ORDER_PREFIX = 'orderprefix/general/order_prefix';
    public const INVOICE_PREFIX = 'orderprefix/general/invoice_prefix';
    public const SHIPMENT_PREFIX = 'orderprefix/general/shipment_prefix';
    public const CREDITMEMO_PREFIX = 'orderprefix/general/creditmemo_prefix';

    /**
     * @var StoreManagerInterface
     */
    protected $_modelStoreManagerInterface;

    /**
     * @var Registry
     */
    protected $_frameworkRegistry;

    /**
     * @param Context $context
     * @param StoreManagerInterface $modelStoreManagerInterface
     * @param Registry $frameworkRegistry
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $modelStoreManagerInterface,
        Registry $frameworkRegistry
    ) {
        $this->_modelStoreManagerInterface = $modelStoreManagerInterface;
        $this->_frameworkRegistry = $frameworkRegistry;
        parent::__construct($context);
    }

    /**
     * Check Is Extension Enable Or Not
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::MODULE_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Return Order Prefix From Config
     *
     * @return string
     */
    public function getOrderPrefix()
    {
        return $this->scopeConfig->getValue(self::ORDER_PREFIX, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Return Invoice Prefix From Config
     *
     * @return string
     */
    public function getInvoicePrefix()
    {
        return $this->scopeConfig->getValue(self::INVOICE_PREFIX, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Returnt Shipment Prefix From Config
     *
     * @return string
     */
    public function getShipmentPrefix()
    {
        return $this->scopeConfig->getValue(self::SHIPMENT_PREFIX, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Return Creditmemo Prefix From Config
     *
     * @return string
     */
    public function getCreditmemoPrefix()
    {
        return $this->scopeConfig->getValue(self::CREDITMEMO_PREFIX, ScopeInterface::SCOPE_STORE);
    }
}
