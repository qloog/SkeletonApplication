<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{

	/**
     * Dashboard
     *
     * @return ViewModel
     */
	public function indexAction()
	{
        return new ViewModel();
	}

}
