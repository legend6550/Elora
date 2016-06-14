<?php
	App::uses('lib', 'Lib');
	class CitysController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Color','city','authoritie');
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
		public function index(){
			if(isset($_GET['id'])){
				$permissions = $this->User->query('SELECT `roles`.* FROM `permissions`,`roles`,`authorities`,`users` WHERE `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `authorities`.`id`= `users`.`Permission` and `roles`.`key`=\'UPDATE_CITYS\' and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\'');
				if(count($permissions)>0){
					$cityCurrent=$this->city->find('first',array('conditions'=>array('id'=>$_GET['id'])));
					if(count($cityCurrent)>0){
						$this->set('name',$cityCurrent['city']['name']);
						if(isset($_POST['btnsave'])){
							if(strlen($this->data['citys']['name'])==0)
							{
								$this->Session->setFlash('bạn cần nhập tên tỉnh/thành phố','flash_Login_bad');
								return;
							}
							$this->city->read(null,$_GET['id']);
							$this->city->set(array(
									'name'=>$this->data['citys']['name'],
								));
							if($this->city->save()){
								$this->Session->setFlash('<i class="fa fa-thumbs-up" aria-hidden="true"></i> cập nhật thành công','flash_Login_bad');
								$this->redirect(array('controller'=>'Citys','action'=>'index'));
							} else $this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> cập nhật thất bại','flash_Login_bad');



						}
					} else {
						$this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Không tìm thấy dữ liệu cần chỉnh sửa ','flash_Login_bad');
						$this->redirect(array('controller'=>'Citys','action'=>'index'));
					}
				}
				else
				{
					$this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Bạn chưa được cấp quyền cập nhật tỉnh/thành phố ','flash_Login_bad');
					$this->redirect(array('controller'=>'Citys','action'=>'index'));
				}
			}
			if(isset($_POST['btnsave'])){
				$permissions = $this->User->query('SELECT `roles`.* FROM `permissions`,`roles`,`authorities`,`users` WHERE `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `authorities`.`id`= `users`.`Permission` and `roles`.`key`=\'INSERT_CITYS\' and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\'');
				if(count($permissions)>0){
					if(strlen($this->data['citys']['name'])==0)
					{
						$this->Session->setFlash('bạn cần nhập tên tỉnh/thanh phố','flash_Login_bad');
						return;
					}
					$User = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read($this->sessionUsername))));
					if(count($User)>0){

						$DataTable_select = $this->city->find('first',array('conditions'=>array('id'=>$_GET['id'])));


						$this->city->create();
						$this->city->set(array(
								'name'=>$this->data['citys']['name'],
								'byUser' =>$User['User']['id'],
								'createDate'=>date('Y-m-d H:i:s'),
							));
						if($this->city->save()) $this->Session->setFlash('<i class="fa fa-thumbs-up" aria-hidden="true"></i> Lưu thành công','flash_Login_bad');
						else $this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Lưu thất bại','flash_Login_bad'); 
					}
				}
				else {
					$this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Bạn chưa được cấp quyền thêm tỉnh/thành phố ','flash_Login_bad');
				}
			}
			$this->set('title','Quản lý tỉnh thành phố');
			$this->set('Table',$this->city->find('all'));
		}
		function delete($slug = null){
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					if($this->city->delete($id)) $this->Session->setFlash('Xóa thành công','flash_Login_bad');
					else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');

			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'Citys','action'=>'index'));
		}
	}