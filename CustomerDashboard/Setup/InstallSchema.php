<?php

namespace Nisl\CustomerDashboard\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0){

		$installer->run('create table custom_customer_comment(id int not null auto_increment, customer_id int(11),customer_comment  text, primary key(id))

            create table custom_customer_reschedule(id int not null auto_increment, customer_id int(11), customer_reschedule_date  date,customer_active int(1),  primary key(id))

            ');


		}

        $installer->endSetup();

    }
}