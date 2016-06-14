<?php
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

	Router::connect('/admin', array('controller' => 'Users', 'action' => 'login'));
	Router::connect('/administrator/login', array('controller' => 'Users', 'action' => 'login'));
	Router::connect('/administrator/logout', array('controller' => 'Users', 'action' => 'logout'));
	Router::connect('/administrator/profile', array('controller' => 'Users', 'action' => 'profile'));
	Router::connect('/administrator/change-password', array('controller' => 'Users', 'action' => 'changePass'));
	

	Router::connect('/dashboard/error/not-set-permission', array('controller' => 'Errors', 'action' => 'NotSetPermission'));

	Router::connect('/dashboard', array('controller' => 'Administrator', 'action' => 'dashboard'));
	Router::connect('/dashboard/setting-site', array('controller' => 'Administrator', 'action' => 'settingSite'));
	Router::connect('/dashboard/setting-social', array('controller' => 'Administrator', 'action' => 'settingSocial'));
	Router::connect('/dashboard/setting-slide', array('controller' => 'Administrator', 'action' => 'settingSlide'));
	Router::connect('/dashboard/setting-mail', array('controller' => 'Administrator', 'action' => 'settingMail'));
	Router::connect('/dashboard/image', array('controller' => 'Medias', 'action' => 'index'));
	Router::connect('/dashboard/image/add', array('controller' => 'Medias', 'action' => 'add'));
	Router::connect('/dashboard/image/delete', array('controller' => 'Medias', 'action' => 'delete'));
	Router::connect('/dashboard/image/:slug', array('controller' => 'Medias', 'action' => 'edit'),array('pass' => array('slug')));
	Router::connect('/dashboard/role', array('controller' => 'Role', 'action' => 'index'));
	Router::connect('/dashboard/role/add', array('controller' => 'Role', 'action' => 'addRole'));
	Router::connect('/dashboard/role/:slug', array('controller' => 'Role', 'action' => 'update'),array('pass' => array('slug'),'slug'=>'[0-9]+'));
	Router::connect('/dashboard/role/delete/:slug', array('controller' => 'Role', 'action' => 'delete'),array('pass' => array('slug'),'slug'=>'[0-9]+'));
	Router::connect('/dashboard/size', array('controller' => 'Size', 'action' => 'index'));
	Router::connect('/dashboard/size/:slug', array('controller' => 'Size', 'action' => 'delete'),array('pass' => array('slug')));
	Router::connect('/dashboard/color', array('controller' => 'Color', 'action' => 'index'));
	Router::connect('/dashboard/color/:slug', array('controller' => 'Color', 'action' => 'delete'),array('pass' => array('slug')));
	Router::connect('/dashboard/citys', array('controller' => 'Citys', 'action' => 'index'));
	Router::connect('/dashboard/citys/:slug', array('controller' => 'Citys', 'action' => 'delete'),array('pass' => array('slug')));
	Router::connect('/dashboard/region/:slug', array('controller' => 'Region', 'action' => 'index'),array('pass' => array('slug')));
	Router::connect('/dashboard/region/:slug/:id', array('controller' => 'Region', 'action' => 'delete'),array('pass' => array('slug','id')));
	Router::connect('/dashboard/category', array('controller' => 'Categorys', 'action' => 'index'));



	Router::connect('/dashboard/users', array('controller' => 'Users', 'action' => 'index'));	
	Router::connect('/dashboard/users/add', array('controller' => 'Users', 'action' => 'add'));
	Router::connect('/dashboard/users/:slug', array('controller' => 'Users', 'action' => 'update'),array('pass' => array('slug'),'slug'=>'[0-9]+'));

	Router::connect('/dashboard/product/add', array('controller' => 'Product', 'action' => 'add'));
	Router::connect('/dashboard/product', array('controller' => 'Product', 'action' => 'index'));
	Router::connect('/dashboard/product/promotion/:slug', array('controller' => 'Product', 'action' => 'promotion'),array('pass' => array('slug'),'slug'=>'[0-9]+'));
	Router::connect('/dashboard/product/infomation/:slug', array('controller' => 'Product', 'action' => 'infomation'),array('pass' => array('slug'),'slug'=>'[0-9]+'));
	Router::connect('/dashboard/product/warehousing/:slug', array('controller' => 'Product', 'action' => 'warehousing'),array('pass' => array('slug'),'slug'=>'[0-9]+'));
	Router::connect('/dashboard/product/warehousing/:slug/:idwarehousing', array('controller' => 'Product', 'action' => 'editwarehousing'),array('pass' => array('slug','idwarehousing'),'slug'=>'[0-9]+','idwarehousing'=>'[0-9]+'));
	Router::connect('/dashboard/news', array('controller' => 'News', 'action' => 'index'));


	Router::connect('/api/v2/data/getallimages', array('controller' => 'Data', 'action' => 'image', 'method' => 'POST'));
	Router::connect('/api/v2/data/select-region', array('controller' => 'Data', 'action' => 'GetRegionByCitys', 'method' => 'POST'));
	Router::connect('/api/v2/data/saveaddress', array('controller' => 'Data', 'action' => 'SaveAddress', 'method' => 'POST'));
	Router::connect('/api/v2/data/remove-address', array('controller' => 'Data', 'action' => 'removeAddress', 'method' => 'POST'));
	Router::connect('/api/v2/data/set-permission', array('controller' => 'Data', 'action' => 'SetPermission', 'method' => 'POST'));
	Router::connect('/api/v2/data/save-contant', array('controller' => 'Data', 'action' => 'saveContant', 'method' => 'POST'));
	Router::connect('/api/v2/data/remove-contant', array('controller' => 'Data', 'action' => 'removeContant', 'method' => 'POST'));
	Router::connect('/api/v2/data/get-inventories-by-id-warehousing', array('controller' => 'Data', 'action' => 'getInventoriesByIDWarehousing', 'method' => 'POST'));

	Router::parseExtensions('json');
	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';

