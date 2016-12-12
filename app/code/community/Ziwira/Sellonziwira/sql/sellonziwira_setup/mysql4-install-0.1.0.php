<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table sell_on_ziwira(id int not null auto_increment, merchant_name varchar(100), mobile varchar(100), owner_name varchar(100), typeof_product varchar(100), compnany_name varchar(100), typeof_business varchar(250), website_url varchar(250),business_desc varchar(250),email varchar(100),primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 