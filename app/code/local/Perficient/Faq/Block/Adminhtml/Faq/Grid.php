<?php

class Perficient_Faq_Block_Adminhtml_Faq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function __construct()
	{
		parent::__construct();
		$this->setId("faqGrid");
		$this->setDefaultSort("id");
		$this->setDefaultDir("DESC");
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel("faq/faq")->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$this->addColumn("id", array(
			"header" => Mage::helper("faq")->__("ID"),
			"align" =>"right",
			"width" => "50px",
			"type" => "number",
			"index" => "id",
		));

		$this->addColumn("name", array(
			"header" => Mage::helper("faq")->__("Name"),
			"index" => "name",
		));
		$this->addColumn("email", array(
			"header" => Mage::helper("faq")->__("Email"),
			"index" => "email",
		));
		$this->addColumn("telephone", array(
			"header" => Mage::helper("faq")->__("Telephone"),
			"index" => "telephone",
		));

		$this->addColumn("question", array(
			"header" => Mage::helper("faq")->__("Question"),
			"index" => "question",
		));
		$this->addColumn('status', array(
			'header' => Mage::helper('faq')->__('Status'),
			'index' => 'status',
			'type' => 'options',
			'options'=>Perficient_Contact_Block_Adminhtml_Contact_Grid::getStatusOption(),
		));

		$this->addColumn('create_time', array(
			'header'    => Mage::helper('faq')->__('Create date/time'),
			'index'     => 'create_time',
			'type'      => 'datetime',
		));
		$this->addColumn("update_time", array(
			"header" => Mage::helper("faq")->__("Update date/time"),
			"index" => "update_time",
			'type'      => 'datetime'
		));
	//	$this->addExportType('*/*/exportCsv', Mage::helper('faq')->__('CSV'));
		//$this->addExportType('*/*/exportExcel', Mage::helper('faq')->__('Excel'));

		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		//return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		return '#';
	}


	static public function getStatusOption()
	{
		$data_array=array();
		$data_array[0]='Unread (New) ';
		$data_array[1]='Read (Old)';
		return($data_array);
	}
	static public function getStatusOptionValue()
	{
		$data_array=array();
		foreach(Perficient_Contact_Block_Adminhtml_Contact_Grid::getStatusOption() as $k=>$v){
			$data_array[]=array('value'=>$k,'label'=>$v);
		}
		return($data_array);

	}


}