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

namespace Logicrays\OrderPrefix\Model;

use Magento\Framework\App\ResourceConnection as AppResource;
use Magento\Framework\DB\Sequence\SequenceInterface;
use Magento\SalesSequence\Model\Meta;
use Logicrays\OrderPrefix\Helper\Data;
use Magento\SalesSequence\Model\Sequence as MagentoSequence;

/**
 * Override Sequnce with Magento sales Sequence.
 */
class Sequence extends MagentoSequence
{
    /**
     * @var integer
     */
    private $lastIncrementId;

    /**
     * @var Meta
     */
    private $_meta;

    /**
     * @var AppResource
     */
    private $connection;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @param Meta $meta
     * @param Data $helper
     * @param AppResource $resource
     * @param [type] $pattern
     */
    public function __construct(
        Meta $meta,
        Data $helper,
        AppResource $resource,
        $pattern = self::DEFAULT_PATTERN
    ) {
        $this->_meta = $meta;
        $this->connection = $resource->getConnection('sales');
        $this->pattern = $pattern;
        $this->_helper = $helper;
        parent::__construct($meta, $resource, $pattern);
    }

    /**
     * Return Current Value
     *
     * @return string
     */
    public function getCurrentValue()
    {
        if ($this->_helper->isEnabled()) {
            $prefix = $this->_helper->getOrderPrefix();
        } else {
            $prefix = " ";
        }
        if (!isset($this->lastIncrementId)) {
            return null;
        }
        return sprintf(
            $this->pattern,
            $prefix,
            $this->calculateCurrentValue(),
            $this->_meta->getActiveProfile()->getSuffix()
        );
    }

    /**
     * Return Next Value
     *
     * @return string
     */
    public function getNextValue()
    {
        $this->connection->insert($this->_meta->getSequenceTable(), []);
        $this->lastIncrementId = $this->connection->lastInsertId($this->_meta->getSequenceTable());
        return $this->getCurrentValue();
    }

    /**
     * Get Calculate Current Value
     *
     * @return integer
     */
    private function calculateCurrentValue()
    {
        return ($this->lastIncrementId - $this->_meta->getActiveProfile()->getStartValue())
            * $this->_meta->getActiveProfile()->getStep() + $this->_meta->getActiveProfile()->getStartValue();
    }
}
