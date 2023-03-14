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
 * Execute to apply order prefix on invoice.
 */
class InvoiceObserver extends AbstractObserver
{
    /**
     * @var string
     */
    protected $prefixConfigPath = 'orderprefix/general/invoice_prefix';

    /**
     * Return Order Collection
     *
     * @param mixed $order
     * @return mixed
     */
    public function getCollection($order)
    {
        return $order->getInvoiceCollection();
    }

    /**
     * Execute
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $this->assignIncrement($observer->getInvoice());
    }
}
