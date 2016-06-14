<?php
	App::uses('lib', 'Lib');
	class SizeController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Size','authoritie');
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
			$this->set('title','Quản lý size');
			if(isset($_GET['id'])){
				$lib = new lib();
				$id = $lib->parseint($_GET['id']);
				if($id!==false && $id>0){
					$data = $this->Size->find('first',array('conditions'=>array('id' => $_GET['id'])));
					if(count($data)>0) {
						if(isset($_POST['btnsave'])){
							$err = '';
							$name = '';
							if(isset($this->data['size']['name']) && strlen($this->data['size']['name'])>0) $name = $this->data['size']['name'];
							else $err .= '<li>bạn cần nhập tên size</li>';
							if(strlen($err)==0){
								$this->Size->read(null,$_GET['id']);
								$this->Size->set(array(
										'name' => $name,
										'Description' => $this->data['size']['Description'],
									));
								if($this->Size->save())
								{
									$this->Session->setFlash('cập nhật thành công','flash_Login_bad');
									$this->redirect(array('controller'=>'Size','action'=>'index'));
								}
								else $this->Session->setFlash('cập nhật thất bại','flash_Login_bad');
							} else $this->Session->setFlash($err,'flash_Login_bad');
						} else {
							$this->set('name', $data['Size']['name']);
							$this->set('Description', $data['Size']['Description']);
						}
					}
					else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				}
				else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else {
				if(isset($_POST['btnsave'])){
					$err = '';
					$name = '';
					$Description = '';
					if(isset($this->data['size']['name']) && strlen($this->data['size']['name'])>0) $name = $this->data['size']['name'];
					else $err .= '<li>bạn cần nhập tên size</li>';
					if(strlen($err)==0){
						$current = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read($this->sessionUsername))));
						if(count($current)>0)
						{
							$this->Size->create();
							$this->Size->set(array(
									'name' => $name,
									'Description' => $this->data['size']['Description'],
									'createDate' => date('Y-m-d H:i:s'),
									'byUser' => $current['User']['id']
								));
							if($this->Size->save())$this->Session->setFlash('Lưu thành công','flash_Login_bad');
							else $this->Session->setFlash('Lưu thất bại','flash_Login_bad');
						} else $this->redirect(array('controller'=>'Size','action'=>'index'));
					} else $this->Session->setFlash($err,'flash_Login_bad');
				}
			}
			$this->set('Table',$this->Size->find('all'));
		}
		function delete($slug = null){
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					if($this->Size->delete($id)) $this->Session->setFlash('Xóa thành công','flash_Login_bad');
					else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'Size','action'=>'index'));
		}
	}