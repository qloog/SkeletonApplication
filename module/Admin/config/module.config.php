<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Admin\Controller\Admin'  => 'Admin\Controller\AdminController',
			'Admin\Controller\System'  => 'Admin\Controller\SystemController',
		),
	),
	'admin' => array(
		'use_admin_layout'		=> true,
		'admin_layout_template' => 'layout/admin'
	),

	'service_manager' => array(
		'factories' => array(
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			//'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
		),
	),

	'navigation' => array(
		'default' => array(
			'dashboard' => array(
				'label' => 'Dashboard',
				'uri'   => '/admin',
				'icon'  => 'icon-dashboard',
				'active' => 1,
			),
			'system' => array(
				'label' => '系统管理',
				//'route' => 'admin',
				'uri' => '/admin/system',
				'icon'  => 'icon-cogs',
				'active' => 1,
			),
			'user' => array(
				'label' => '用户管理',
				'uri' => '/admin/user',
				'icon' => 'icon-user',
				'pages' => array(
					'profile' => array(
						'label' => '用户列表',
						'uri'   => '/admin/user',	//if route is not exist, it will error 
					),
					'user' => array(
						'label' => 'User',
						'route' => 'album',
					),
				),
			),
			'notice' => array(
				'label' => '公告管理',
				'uri'   => '/admin/notice',
				'icon'  => 'icon-volume-up',
				'active' => 1,
			),
			'category' => array(
				'label' => '分类管理',
				'uri'   => '/admin/category',
				'icon'  => 'icon-th',
				'active' => 1,
			),
			'article' => array(
				'label' => 'POST管理',
				'route' => 'admin',
				'icon'  => 'icon-pencil',
				'active' => 1,
			),
			'find' => array(
				'label' => '发现频道管理',
				'route' => 'admin',
				'icon'  => 'icon-search',
				'active' => 1,
				'pages' => array(
					'category' => array(
						'label' => '商家管理',
						'route' => 'album',	//if route is not exist, it will error 
					),
				),
			),
			'mall' => array(
				'label' => '商家导航管理',
				'route' => 'admin',
				'icon'  => 'icon-shopping-cart',
				'active' => 1,
				'pages' => array(
					'category' => array(
						'label' => '分类管理',
						'route' => 'album',	//if route is not exist, it will error 
					),
					'malllist' => array(
						'label' => '商城列表',
						'route' => 'album',
					),
				),
			),
			'contribute' => array(
				'label' => '爆料投稿管理',
				'route' => 'admin',
				'icon'  => 'icon-envelope',
				'active' => 1,
				'pages' => array(
					'contribute' => array(
						'label' => '投稿管理',
						'route' => 'album',	//if route is not exist, it will error 
					),
					'show' => array(
						'label' => '晒单管理',
						'route' => 'album',
					),
					'tip-off' => array(
						'label' => '爆料管理',
						'route' => 'album',
					),
				),
			),
			'coupon' => array(
				'label' => '优惠券管理',
				'route' => 'admin',
				'icon'  => 'icon-ticket',
				'active' => 1,
			),
			'comment' => array(
				'label' => '评论管理',
				'route' => 'admin',
				'icon'  => 'icon-comments',
				'active' => 1,
			),
			'push' => array(
				'label' => '推送管理',
				'route' => 'admin',
				'icon'  => 'icon-tasks',
				'active' => 1,
			),
			'ad' => array(
				'label' => '广告管理',
				'route' => 'admin',
				'icon'  => 'icon-eye-open',
				'active' => 1,
			),
			'about' => array(
				'label' => '站务管理',
				'route' => 'admin',
				'icon'  => 'icon-group',
				'active' => 1,
			),
		),
    ),

	'router' => array(
		'routes' => array(
			'admin' => array(
				'type' => 'Literal',
				'options' => array(
					'route'		=> '/admin',
					'defaults' => array(
						'__NAMESPACE__' => 'Admin\Controller',
						'controller' => 'Admin',
						'action'	 => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/[:controller[/:action[/:id]]]',
							//'route' => '/system',
							'constraints' => array(
								'controller'	=> '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'		=> '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'			=> '[0-9]*',
							),
							'defaults' => array(
								'controller' => 'Admin\Controller\Admin',
								'action' => 'index',
							),
						),
					),
				),// child_routes end
			),//admin end
		),
	),

	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype'	=> 'HTML5',
        'not_found_template'       => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
            'application/index/index' => __DIR__ .  '/../view/admin/admin/index.phtml',
            'layout/layout'           => __DIR__ . '/../view/layout/admin.phtml',
            'layout/header'           => __DIR__ . '/../view/layout/header.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
        ),
		'template_path_stack' => array(
			'admin' => __DIR__ . '/../view',
		),
	),
);
