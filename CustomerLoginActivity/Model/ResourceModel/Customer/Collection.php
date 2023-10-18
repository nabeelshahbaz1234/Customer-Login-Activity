<?php
declare(strict_types=1);

namespace Pixafy\CustomerLoginActivity\Model\ResourceModel\Customer;

use Magento\Customer\Model\ResourceModel\Visitor;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Zend_Db_Expr;

/**
 * @class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    const YOUR_TABLE = 'customer_visitor';
    private StoreManagerInterface $storeManager;

    /**
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param StoreManagerInterface $storeManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface        $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface       $eventManager,
        StoreManagerInterface  $storeManager,
        AdapterInterface       $connection = null,
        AbstractDb             $resource = null
    ) {
        $this->_init(\Magento\Customer\Model\Visitor::class, Visitor::class);

        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->storeManager = $storeManager;
    }

    /**
     * @return $this|Collection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            ['customer' => $this->getTable('customer_entity')],
            'main_table.customer_id = customer.entity_id',
            ['customer.email', 'customer.firstname']
        );

        $this->getSelect()->joinLeft(
            ['log' => $this->getTable('customer_log')],
            'main_table.customer_id = log.customer_id',
            ['log.last_login_at']
        );

        $this->getSelect()->columns([
            'customer_fullname' => new Zend_Db_Expr("CONCAT(customer.firstname, ' ', customer.lastname)"),
            'log.last_login_at',
            'main_table.customer_id',
            'customer.email',
        ]);

        return $this;
    }
}
