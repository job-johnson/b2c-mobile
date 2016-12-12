<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table customerfeedback(id int not null auto_increment, customer_name varchar(100),feedback varchar(250),approved varchar(100),posted_date DATETIME  NOT NULL, primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 