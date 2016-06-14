<?php
	App::uses('lib', 'Lib');
	class NewsController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Size','image','authoritie');
		function beforeFilter(){
			if(!$this->Session->read($this->sessionUsername)){
				$this->redirect(array('controller'=>'Users','action'=>'login'));
			}
			else
			{
				$lib = new	lib();
				$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\' and `roles`.`ActionName`=\''.$this->params['action'].'\' and `roles`.`ControllerName`=\''.$this->params['controller'].'\'';
				$User = $this->User->query($sql);
				if(count($User)>0){
					$sql = 'SELECT *, EXISTS (SELECT * FROM `authorities`,`permissions` where `authorities`.`id`=`permissions`.`id_authorities` and `roles`.`id`=`permissions`.`id_role` and `authorities`.`id`='.$User[0]['users']['Permission'].') as \'CheckRoles\' FROM `roles` WHERE 1 ORDER BY `type_node` ASC, `index` ASC';
					$this->set('menuHtml',$lib->ExportHtmlMenu($this->authoritie->query($sql),$this->params['action'],$this->params['controller']));
					$this->set('usernameLogin',$this->Session->read($this->sessionUsername));
				} else $this->redirect(array('controller'=>'Errors','action'=>'NotSetPermission'));
			}
		}
		function index(){
			$this->set('title','Quản lý tin tức');
		}
	}