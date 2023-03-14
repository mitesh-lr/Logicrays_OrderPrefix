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

use Magento\Framework\Event\Observer;

/**
 * Execute to apply order prefix on shipment.
 */
class ShipmentObserver extends AbstractObserver
{
    /**
     * @var string
     */
    protected $prefixConfigPath = 'orderprefix/general/shipment_prefix';

    /**
     * Return Order Colelction
     *
     * @param mixed $order
     * @return mixed
     */
    public function getCollection($order)
    {
        return $order->getShipmentsCollection();
    }

    /**
     * Execute
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $this->assignIncrement($observer->getShipment());
    }
}
