<?php
	App::uses('lib', 'Lib');
	class RoleController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','authoritie','role','Permission');
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
			$this->set('title','Danh sách phân quyền');
			$this->set('Tables',$this->authoritie->find('all'));
		}
		public function addRole(){
			$this->set('title','Thêm phân quyền');
			$lib = new lib();
			$Tables = $this->role->find('all',array('order' => array('type_node'=>'ASC', 'index'=>'ASC')));
			$this->set('htmlRole',$lib->ExportHtmlTreeView($Tables));
			$this->set('htmlCombobox',$lib->ExportHtmlMenuForCombobox($Tables,'','CboRoles'));
			if(isset($_POST['btnsave'])){
				$err = '';
				if(!isset($this->data['authoritie']['name']) || strlen($this->data['authoritie']['name'])==0){
					$err = '<li>Bạn cần nhập tên phân quyền</li>';
				}
				if(!isset($this->data['authoritie']['roles']) || strlen($this->data['authoritie']['roles'])==0){
					$err .= '<li>Bạn cần chọn chức năng</li>';
				}
				if(!isset($_POST['CboRoles']) || strlen($_POST['CboRoles'])==0){
					$err .= '<li>Bạn cần chọn màng hình quản lý chính</li>';
				} 
				if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
				else {
					$selectRole = $this->role->find('first',array('conditions'=>array('id'=>$_POST['CboRoles'])));
					if(count($selectRole)==0)$err.='<li>Bạn cần chọn màng hình quản lý chính</li>';
					else{
						if($selectRole['role']['ActionName']==='#' || $selectRole['role']['ControllerName']==='#') $err.='Màng hình quản lý chình này không được chọn';
						if(strlen($err)>0){$this->Session->setFlash($err,'flash_Login_bad');return;}
						else{
							$current = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read($this->sessionUsername))));
							if(count($current)>0)
							{
								$this->authoritie->create();
								$this->authoritie->set(array(
										'name' => $this->data['authoritie']['name'],
										'description' => $this->data['authoritie']['Description'],
										'createDate' => date('Y-m-d H:i:s'),
										'byUser' => $current['User']['id'],
										'Dashboard'=>$_POST['CboRoles'],
										'DefaultRegister'=>$this->data['authoritie']['DefaultRegister']
									));
								if($this->authoritie->save()) {
									$dem = 0;
									$check = false;
									$selectItem = explode("|",$this->data['authoritie']['roles']);
									$jump = count($selectItem);
									for($i=0;$i<count($selectItem);$i++){
										if(strcmp($selectItem[$i],$_POST['CboRoles'])===0) $check=true;
										$this->Permission->create();
										$this->Permission->set(array(
												'id_role' => $selectItem[$i],
												'id_authorities' => $this->authoritie->id,
												'createDate' => date('Y-m-d H:i:s'),
												'byUser' => $current['User']['id']
											));
										if($this->Permission->save()) $dem++;
									}
									if($check===false){
										$jump++;
										$this->Permission->create();
										$this->Permission->set(array(
												'id_role' => $_POST['CboRoles'],
												'id_authorities' => $this->authoritie->id,
												'createDate' => date('Y-m-d H:i:s'),
												'byUser' => $current['User']['id']
											));
										if($this->Permission->save()) $dem++;
									}
									if($dem >= $jump) $this->Session->setFlash('<i class="ace-icon fa fa-check green"></i>Lưu thành công','flash_Login_bad');
									else {
										$this->Permission->deleteAll(array('id_authorities' => $this->authoritie->id), false);
										$this->authoritie->delete($this->authoritie->id);
										$this->Session->setFlash('Lưu thất bại','flash_Login_bad');
									}
								}
								else $this->Session->setFlash('Lưu thất bại','flash_Login_bad');
							}
						}
					}
				}
			}
		}
		public function update($slug = null){
			$this->set('title','Cập nhật');
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					$authorities = $this->authoritie->find('first',array('conditions'=>array('id'=>$slug)));
					if(count($authorities)>0){
						if(isset($_POST['btnsave'])){
							$err = '';
							if(!isset($this->data['authoritie']['name']) || strlen($this->data['authoritie']['name'])==0){
								$err = '<li>Bạn cần nhập tên phân quyền</li>';
							}
							if(!isset($this->data['authoritie']['roles']) || strlen($this->data['authoritie']['roles'])==0){
								$err .= '<li>Bạn cần chọn chức năng</li>';
							}
							if(!isset($_POST['CboRoles']) || strlen($_POST['CboRoles'])==0){
								$err .= '<li>Bạn cần chọn màng hình quản lý chính</li>';
							} else {
								$selectRole = $this->role->find('first',array('conditions'=>array('id'=>$_POST['CboRoles'])));
								if(count($selectRole)==0) $err.='<li>Bạn cần chọn màng hình quản lý chính</li>';
							}
							if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
							else {
								$this->authoritie->read(null,$slug);
								$this->authoritie->set(array(
										'name' => $this->data['authoritie']['name'],
										'description' => $this->data['authoritie']['Description'],
										'Dashboard'=>$_POST['CboRoles'],
										'DefaultRegister'=>$this->data['authoritie']['DefaultRegister']
									));
								if($this->authoritie->save()) {
									$this->Permission->deleteAll(array('id_authorities' => $slug), false);
									$dem = 0;
									$check = false;
									$selectItem = explode("|",$this->data['authoritie']['roles']);
									$jump = count($selectItem);
									for($i=0;$i<count($selectItem);$i++){
										if(strcmp($selectItem[$i],$_POST['CboRoles'])===0) $check=true;
										$this->Permission->create();
										$this->Permission->set(array(
												'id_role' => $selectItem[$i],
												'id_authorities' => $slug,
												'createDate' => date('Y-m-d H:i:s'),
												'byUser' => $authorities['authoritie']['byUser']
											));
										if($this->Permission->save()) $dem++;
									}
									if($check===false){
										$jump++;
										$this->Permission->create();
										$this->Permission->set(array(
												'id_role' => $_POST['CboRoles'],
												'id_authorities' => $slug,
												'createDate' => date('Y-m-d H:i:s'),
												'byUser' => $authorities['authoritie']['byUser']
											));
										if($this->Permission->save()) $dem++;
									}
									if($dem >= count($selectItem)) $this->Session->setFlash('<i class="ace-icon fa fa-check green"></i>Lưu thành công','flash_Login_bad');
									else {
										$this->Permission->deleteAll(array('id_authorities' => $slug), false);
										$this->authoritie->delete($slug);
										$this->Session->setFlash('Lưu thất bại','flash_Login_bad');
									}
								}
							}
						}
						$sql='SELECT *, EXISTS (SELECT * FROM `authorities`,`permissions` where `authorities`.`id`=`permissions`.`id_authorities` and `roles`.`id`=`permissions`.`id_role` and `authorities`.`id`='.$slug.') as \'CheckRoles\' FROM `roles` WHERE 1';
						$Tables = $this->role->find('all',array('order' => array('type_node'=>'ASC', 'index'=>'ASC')));
						$this->set('htmlCombobox',$lib->ExportHtmlMenuForCombobox($Tables,$authorities['authoritie']['Dashboard'],'CboRoles'));
						$this->set('htmlRole',$lib->ExportHtmlTreeViewForUpdate($this->authoritie->query($sql)));
						$this->set('name',$authorities['authoritie']['name']);
						$this->set('Check',$authorities['authoritie']['DefaultRegister']);
						$this->set('Description',$authorities['authoritie']['description']);
						return;
					} else $this->Session->setFlash('<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu','flash_Login_bad');
					
				} else $this->Session->setFlash('<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu','flash_Login_bad');
			} else $this->Session->setFlash('<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu','flash_Login_bad');
			$this->redirect(array('controller'=>'Role','action'=>'index'));
		}
		public function delete($slug = null){
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					$authorities = $this->authoritie->find('first',array('conditions'=>array('id'=>$slug)));
					if(count($authorities)>0){
						$this->Permission->deleteAll(array('id_authorities' => $slug), false);
						$this->authoritie->delete($slug);
						$this->Session->setFlash('Xóa thành công','flash_Login_bad');
					} else $this->Session->setFlash('<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu','flash_Login_bad');
					
				} else $this->Session->setFlash('<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu','flash_Login_bad');
			} else $this->Session->setFlash('<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu','flash_Login_bad');
			$this->redirect(array('controller'=>'Role','action'=>'index'));
		}
	}