<?php
	App::uses('lib', 'Lib');
	class ColorController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Color','authoritie');
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
			$this->set('title','Quản lý màu sắc');
			if(isset($_GET['id'])){
				$lib = new lib();
				$id = $lib->parseint($_GET['id']);
				if($id!==false && $id>0){
					$Data = $this->Color->find('first',array('conditions'=>array('id'=>$_GET['id'])));
					if(count($Data)>0) {
						$name = '';
						$value = '';
						$Description = '';
						$err = '';
						if(isset($_POST['btnsave'])){
							if(!isset($this->data['color']['Caption']) || strlen($this->data['color']['Caption'])==0) $err .= '<li>Bạn cần nhập tên màu sắc</li>';
							else $name = $this->data['color']['Caption'];
							if(!isset($this->data['color']['Description']) || strlen($this->data['color']['Description'])==0) $err .= '<li>Bạn cần nhập mô tả</li>';
							else $Description = $this->data['color']['Description'];
							if(!isset($this->data['color']['value']) || strlen($this->data['color']['value'])==0) $err .= '<li>Bạn cần nhập mã màu</li>';
							else $value = $this->data['color']['value'];
							if(strlen($err)===0){
								$this->Color->read(null,$_GET['id']);
								$this->Color->set(array(
										'name' => $this->data['color']['Caption'],
										'Description' => $this->data['color']['Description'],
										'Values' => $this->data['color']['value']
									));
								if($this->Color->save())	
								{
									$this->Session->setFlash('Cập nhật thành công','flash_Login_bad');
									$this->redirect(array('controller'=>'Color','action'=>'index'));
								}
								else $this->Session->setFlash('Cập nhật thất bại','flash_Login_bad');
							} else $this->Session->setFlash($err,'flash_Login_bad');
						} else {
							$name = $Data['Color']['name'];
							$value = $Data['Color']['Values'];
							$Description = $Data['Color']['Description'];
						}
						$this->set('name', $name);
						$this->set('value', $value);
						$this->set('Description', $Description);
					} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');

			} else {
				if(isset($_POST['btnsave'])){
					$err = '';
					if(!isset($this->data['color']['Caption']) || strlen($this->data['color']['Caption'])==0) $err .= '<li>Bạn cần nhập tên màu sắc</li>';
					if(!isset($this->data['color']['Description']) || strlen($this->data['color']['Description'])==0) $err .= '<li>Bạn cần nhập mô tả</li>';
					if(!isset($this->data['color']['value']) || strlen($this->data['color']['value'])==0) $err .= '<li>Bạn cần nhập mã màu</li>';
					if(strlen($err)===0){
						$current = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read($this->sessionUsername))));
						if(count($current)>0)
						{
							$this->Color->create();
							$this->Color->set(array(
									'name' => $this->data['color']['Caption'],
									'Description' => $this->data['color']['Description'],
									'createDate' => date('Y-m-d H:i:s'),
									'byUser' => $current['User']['id'],
									'Values' => $this->data['color']['value']
								));
							if($this->Color->save())$this->Session->setFlash('Lưu thành công','flash_Login_bad');
							else $this->Session->setFlash('Lưu thất bại','flash_Login_bad');
						}
					} else $this->Session->setFlash($err,'flash_Login_bad');
				}
			}
			$this->set('Table',$this->Color->find('all'));
		}
		function delete($slug = null){
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					if($this->Color->delete($id)) $this->Session->setFlash('Xóa thành công','flash_Login_bad');
					else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'Color','action'=>'index'));
		}
	}