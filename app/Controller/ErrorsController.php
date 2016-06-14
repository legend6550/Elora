<?php
	App::uses('lib', 'Lib');
	class ErrorsController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Size','authoritie');
		public function NotSetPermission(){
			if(!$this->Session->read($this->sessionUsername)){
				$this->redirect(array('controller'=>'Users','action'=>'login'));
			}
			else
			{
				$lib = new	lib();
				$User = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read($this->sessionUsername))));
				if(count($User)>0){
					$sql = 'SELECT *, EXISTS (SELECT * FROM `authorities`,`permissions` where `authorities`.`id`=`permissions`.`id_authorities` and `roles`.`id`=`permissions`.`id_role` and `authorities`.`id`='.$User['User']['Permission'].') as \'CheckRoles\' FROM `roles` WHERE 1 ORDER BY `type_node` ASC, `index` ASC';
					$this->set('user',$User);
					$this->set('menuHtml',$lib->ExportHtmlMenu($this->authoritie->query($sql),$this->params['action'],$this->params['controller']));
				} else $this->redirect(array('controller'=>'Users','action'=>'login'));
			}
		}
	}