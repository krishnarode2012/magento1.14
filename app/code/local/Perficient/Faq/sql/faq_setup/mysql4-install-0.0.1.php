<?php
/*$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('faq/faq'))
    ->addColumn(
        'id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'auto_increment' => true,
        ),
        'Id'
    )
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(), 'Name')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 55, array(), 'Email')
    ->addColumn('telephone', Varien_Db_Ddl_Table::TYPE_VARCHAR, 15, array(), 'Telephone')
    ->addColumn('question', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Question')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(), 'Status')
    ->addColumn('create_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Create date/time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Update date/time');

$installer->getConnection()->createTable($table);
$installer->endSetup();*/

/*$sql=<<<SQLTEXT
create table perficient_faq(id int not null auto_increment, name varchar(100),
email varchar(100),
telephone varchar(15),
question text,
status smallint,
create_time TIMESTAMP,
update_time TIMESTAMP,
primary key(id));


SQLTEXT;

$installer->run($sql);*/
	 