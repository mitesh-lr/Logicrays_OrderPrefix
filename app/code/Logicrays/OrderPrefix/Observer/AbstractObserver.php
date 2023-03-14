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

namespace Logicrays\OrderPrefix\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Logicrays\OrderPrefix\Helper\Data;
use Magento\Store\Model\ScopeInterface;

abstract class AbstractObserver implements ObserverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var mixed
     */
    protected $prefixConfigPath;

    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Data $helper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Data $helper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_helper = $helper;
    }

    /**
     * Return Prefix Value
     *
     * @param integer $storeId
     * @return string
     */
    public function getPrefix($storeId = null)
    {
        return $this->scopeConfig->getValue(
            $this->prefixConfigPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Return Collection
     *
     * @param mixed $order
     * @return mixed
     */
    abstract public function getCollection($order);

    /**
     * Assign Increment
     *
     * @param mixed $entity
     * @return void
     */
    public function assignIncrement($entity)
    {
        if (!$entity->getId()) {
            $order = $entity->getOrder();
            $prefix = $this->getPrefix($order->getStoreId());
            $collection = $this->getCollection($order);
            $DefaultorderId = $order->getIncrementId();
            $orderpre = $this->_helper->getOrderPrefix();
            $NeworderId = str_replace("$orderpre", "", $DefaultorderId);
            if ($this->_helper->isEnabled()) {
                $prefixedOrderIncrementId = $prefix . $NeworderId;
            } else {
                $prefixedOrderIncrementID = $NeworderId;
            }

            if ($collection->getSize() == 0) {
                $newprefixedOrderIncrement = $prefixedOrderIncrementId;
            } else {
                $PostFix = 0;
                foreach ($collection as $item) {
                    $currentPostfix = trim(str_replace($prefixedOrderIncrementId, '', $item->getIncrementId()), '-');
                    if (empty($currentPostfix)) {
                        $currentPostfix = 1;
                    } else {
                        $currentPostfix++;
                    }
                    $PostFix = max($PostFix, $currentPostfix);
                }
                $newprefixedOrderIncrement = $prefix . $order->getIncrementId() . '-' . $PostFix;
            }
            $entity->setIncrementId($newprefixedOrderIncrement);
        }
    }
}
