<?php
namespace Admin;

use Zend\ModuleManager\Feature;
use Zend\Loader;
use Zend\EventManager\EventInterface;
use	Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\SysOptions;
use Admin\Model\SysOptionsTable;

/**
 * Module class for Admin
 *
 * @package Admin
 */
class Module implements
	Feature\AutoloaderProviderInterface,
	Feature\ConfigProviderInterface,
	Feature\ServiceProviderInterface,
	Feature\BootstrapListenerInterface
{
	/**
	 * 
	 */
	public function getAutoloaderConfig()
	{
		return array(
			Loader\AutoloaderFactory::STANDARD_AUTOLOADER => array(
				Loader\StandardAutoloader::LOAD_NS => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	/**
	 *
	 */
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	/**
	 *
	 */
	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'admin_navigation' => 'Admin\Navigation\Service\AdminNavigationFactory',
				'Admin\Model\SysOptionsTable' => function($sm) {
					$tableGateway = $sm->get('AdminSysOptionsTableGateway');
					$table = new SysOptionsTable($tableGateway);
					return $table;
				},
				'AdminSysOptionsTableGateway' => function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Sysoptions());
					return new TableGateway('sys_options', $dbAdapter, null, $resultSetPrototype);
				},
			),
		);
	}

	/**
	 *
	 */
	public function onBootstrap(EventInterface $e)
	{
		$app = $e->getParam('application');
		$em  = $app->getEventManager();

		$em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'selectLayoutBasedOnRoute'));
	}

	/**
	 * Select the admin layout based on route name
	 *
	 * @param MvcEvent $e
	 * @return void
	 */
	public function selectLayoutBasedOnRoute(MvcEvent $e)
	{
		$app    = $e->getParam('application');
		$sm	    = $app->getServiceManager();	
		$config = $sm->get('config');

		if (false === $config['admin']['use_admin_layout']) {
			return;
		}

		$match		= $e->getRouteMatch();
		$controller = $e->getTarget();
		if (!$match instanceof RouteMatch
			|| 0 !== strpos($match->getMatchedRouteName(), 'admin')
			|| $controller->getEvent()->getResult()->terminate()
		) {
			return;
		}

		$layout		= $config['admin']['admin_layout_template'];
		$controller->layout($layout);
	}

}
