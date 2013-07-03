<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\SysOptions;
use Admin\Form\OptionsForm;

class SystemController extends AbstractActionController
{
	protected $sysOptionsTable;

	public function getSysOptionsTable()
	{
		if (!$this->sysOptionsTable) {
			$sm = $this->getServiceLocator();
			$this->sysOptionsTable = $sm->get('Admin\Model\SysOptionsTable');
		}
		return $this->sysOptionsTable;
	}

	/**
     * system config 
     *
     * @return ViewModel
     */
	public function indexAction()
	{
		$options = $this->getSysOptionsTable()->fetchAll();
        return new ViewModel();
	}

	public function addAction()
	{
		$form = new OptionsForm();
		$messages = array();

		$request = $this->getRequest();
		if ($request->isPost()) {
			$sysOptions = new SysOptions();
			$form->setInputFilter($sysOptions->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$sysOptions->exchangeArray($form->getData());
				$res = $this->getSysOptionsTable()->saveSysOptions($sysOptions);
				if ($res) {
					$messages[] = array(
						'type' => 'success',
						'icon' => 'icon-ok green',
						'message' => 'save ok'
					);
				}
			}else{
				//var_dump($form->getMessages());//Value is required and can't be empty
			}
		}

		return array(
			'form' => $form,
			'messages' => $messages,
		);
	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin', array(
				'controller' => 'system',
                'action' => 'add'
            ));
        }

        // Get the options with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $sysOptions = $this->getSysOptionsTable()->getSysOption($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }

        $form  = new OptionsForm();
        $form->bind($sysOptions);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($sysOptions->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getSysOptionsTable()->saveSysOptions($form->getData());
				if ($res) {
					$messages[] = array(
						'type' => 'success',
						'icon' => 'icon-ok green',
						'message' => 'save ok'
					);
				}
                // Redirect to list of albums
                //return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
		);
	}

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin');
        }

		$this->getSysOptionsTable()->deleteSysoptions($id);
		// Redirect to list of albums
		return $this->redirect()->toRoute('admin');
	}

}
