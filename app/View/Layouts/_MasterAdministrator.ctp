<?php
	App::uses('Model', 'User');
	$this->User = new User();
	$currentUserSessionLogin = $this->User->find('first',array('conditions'=>array('username'=>(isset($usernameLogin)?$usernameLogin:''))));
	$image = '/assets/images/no-avatar.jpg';
	$name = 'Không xác định';
	if(count($currentUserSessionLogin)>0){
		if(strlen($currentUserSessionLogin['User']['avatar'])>0 && file_exists(WWW_ROOT.'/assets/images/'.$currentUserSessionLogin['User']['avatar'])) 
		$image = '/assets/images/'.$currentUserSessionLogin['User']['avatar'];
		if(isset($currentUserSessionLogin['User']['first_name']) && isset($currentUserSessionLogin['User']['last_name'])) $name = $currentUserSessionLogin['User']['first_name'].' '.$currentUserSessionLogin['User']['last_name'];
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo isset($title) ? $title : '.::Administrator::.' ?></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/assets/font-awesome/4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="/assets/fonts/fonts.googleapis.com.css" />
		<link rel="stylesheet" href="/assets/css/colorbox.min.css" />
		<link rel="stylesheet" href="/assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/assets/js/ace-extra.min.js"></script>

		<!--[if lte IE 8]>
		<script src="/assets/js/html5shiv.min.js"></script>
		<script src="/assets/js/respond.min.js"></script>
		<![endif]-->
		<!--[if !IE]> -->
		<script src="/assets/js/jquery.2.1.1.min.js"></script>
		<!-- <![endif]-->

		<!--[if IE]>
			<script src="/assets/js/jquery.1.11.1.min.js"></script>
		<![endif]-->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='/assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='/assets/js/jquery1x.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/assets/js/bootstrap.min.js"></script>
		<!--[if lte IE 8]>
		  <script src="/assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="/assets/js/jquery-ui.custom.min.js"></script>
		<script src="/assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="/assets/js/jquery.easypiechart.min.js"></script>
		<script src="/assets/js/jquery.sparkline.min.js"></script>
		<script src="/assets/js/jquery.flot.min.js"></script>
		<script src="/assets/js/jquery.flot.pie.min.js"></script>
		<script src="/assets/js/jquery.flot.resize.min.js"></script>
		<script src="/assets/js/ace-elements.min.js"></script>
		<script src="/assets/js/ace.min.js"></script>
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="/" class="navbar-brand">
						<small>
							<i class="fa fa-tachometer"></i>
							Administrator
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo $image; ?>" alt="<?php echo $name; ?>" />
								<span class="user-info">
									<small>Xin chào,</small>
									<?php echo $name; ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="/administrator/change-password">
										<i class="ace-icon fa fa-key"></i>
										Đổi mật khẩu
									</a>
								</li>

								<li>
									<a href="/administrator/profile">
										<i class="ace-icon fa fa-user"></i>
										Thông tin cá nhân
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="/administrator/logout">
										<i class="ace-icon fa fa-power-off"></i>
										Đăng xuất
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->
				<?php echo $menuHtml;?>

				<!--<ul class="nav nav-list">
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cogs"></i>
							<span class="menu-text"> Quản trị website </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="/dashboard/setting-site">
									<i class="menu-icon fa fa-leaf green"></i>
									Cài đặt website
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="/dashboard/setting-social">
									<i class="menu-icon fa fa-pencil orange"></i>
									Mạng xã hội
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="/dashboard/setting-slide">
									<i class="menu-icon fa fa-sliders orange"></i>
									Quản lý side Hình ảnh
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Quản trị nhóm tài khoản</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>
						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="/dashboard/role">
									<i class="menu-icon fa fa-leaf green"></i>
									Danh sách
								</a>
								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="/dashboard/role/add">
									<i class="menu-icon fa fa-pencil orange"></i>
									Thêm
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-picture-o"></i>
							<span class="menu-text"> Quản trị hình ảnh</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>
						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="/dashboard/image">
									<i class="menu-icon fa fa-leaf green"></i>
									Danh sách
								</a>
								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="/dashboard/image/add">
									<i class="menu-icon fa fa-pencil orange"></i>
									Thêm
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li>
						<a href="/dashboard/size">
							<i class="menu-icon fa fa-arrows-alt"></i>
							<span class="menu-text"> Quản trị kích thước</span>
						</a>
					</li>
					<li>
						<a href="/dashboard/color">
							<i class="menu-icon fa fa-paint-brush"></i>
							<span class="menu-text"> Quản trị màu sắc</span>
						</a>
					</li>
				</ul>-->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Smart</span>
							 Group &copy; 2015-2016
						</span>

						&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>
	</body>
</html>
