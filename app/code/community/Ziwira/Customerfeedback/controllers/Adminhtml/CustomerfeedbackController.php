<?php

class Ziwira_Customerfeedback_Adminhtml_CustomerfeedbackController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("customerfeedback/customerfeedback")->_addBreadcrumb(Mage::helper("adminhtml")->__("Customerfeedback  Manager"),Mage::helper("adminhtml")->__("Customerfeedback Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Customerfeedback"));
			    $this->_title($this->__("Manager Customerfeedback"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Customerfeedback"));
				$this->_title($this->__("Customerfeedback"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("customerfeedback/customerfeedback")->load($id);
				if ($model->getId()) {
					Mage::register("customerfeedback_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("customerfeedback/customerfeedback");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Customerfeedback Manager"), Mage::helper("adminhtml")->__("Customerfeedback Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Customerfeedback Description"), Mage::helper("adminhtml")->__("Customerfeedback Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("customerfeedback/adminhtml_customerfeedback_edit"))->_addLeft($this->getLayout()->createBlock("customerfeedback/adminhtml_customerfeedback_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("customerfeedback")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Customerfeedback"));
		$this->_title($this->__("Customerfeedback"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("customerfeedback/customerfeedback")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("customerfeedback_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("customerfeedback/customerfeedback");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Customerfeedback Manager"), Mage::helper("adminhtml")->__("Customerfeedback Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Customerfeedback Description"), Mage::helper("adminhtml")->__("Customerfeedback Description"));


		$this->_addContent($this->getLayout()->createBlock("customerfeedback/adminhtml_customerfeedback_edit"))->_addLeft($this->getLayout()->createBlock("customerfeedback/adminhtml_customerfeedback_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("customerfeedback/customerfeedback")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Customerfeedback was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setCustomerfeedbackData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setCustomerfeedbackData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("customerfeedback/customerfeedback");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("customerfeedback/customerfeedback");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'customerfeedback.csv';
			$grid       = $this->getLayout()->createBlock('customerfeedback/adminhtml_customerfeedback_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'customerfeedback.xml';
			$grid       = $this->getLayout()->createBlock('customerfeedback/adminhtml_customerfeedback_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
