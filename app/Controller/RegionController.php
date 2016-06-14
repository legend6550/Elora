<?php
	App::uses('lib', 'Lib');
	class RegionController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Size','authoritie','Region','city');
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
		function index($slug=null){
			$this->set('title','Quản lý quận/huyện');
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					$citys = $this->city->find('first',array('conditions'=>array('id'=>$slug)));
					if(count($citys)>0){
						$link=Router::url(array('controller'=>'Citys','action'=>'index'), true );
						if(isset($_GET['id'])){
							$permissions = $this->User->query('SELECT `roles`.* FROM `permissions`,`roles`,`authorities`,`users` WHERE `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `authorities`.`id`= `users`.`Permission` and `roles`.`key`=\'INSERT_CITYS\' and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\'');
							if(count($permissions)>0){
								$region = $this->Region->find('first',array('conditions'=>array('id'=>$_GET['id'])));
								if(count($region)>0){
									$link=Router::url(array('controller'=>'Region','action'=>'index','slug'=>$slug), true );
									$name = $region['Region']['name'];
									if (isset($_POST['btnsave'])){
										if(strlen($this->data['citys']['name'])==0){
											$this->Session->setFlash('bạn cần nhập tên quận/huyện','flash_Login_bad');
											return;
										}
										else $name = $this->data['citys']['name'];
										$data=array(
											'name' => $this->data['citys']['name']
										);
										$this->Region->read(null,$region['Region']['id']);
										$this->Region->set($data);
										if($this->Region->save()){
											$this->Session->setFlash('<i class="fa fa-thumbs-up" aria-hidden="true"></i> cập nhật thành công','flash_Login_bad');
											$this->redirect(array('controller'=>'Region','action'=>'index','slug'=>$slug));
										}
										else $this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Lưu thất bại','flash_Login_bad'); 
									}
									$this->set('name',$name);
								}else{
									$this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Chúng tôi không tìm thấy dữ liệu trên ','flash_Login_bad');
									$this->redirect(array('controller'=>'Region','action'=>'index','slug'=>$slug));
								}
							} else{
								$this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Bạn chưa được cấp quyền cập nhật quận/huyện ','flash_Login_bad');
							}
						}elseif (isset($_POST['btnsave'])){
							$permissions = $this->User->query('SELECT `roles`.* FROM `permissions`,`roles`,`authorities`,`users` WHERE `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `authorities`.`id`= `users`.`Permission` and `roles`.`key`=\'INSERT_CITYS\' and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\'');
							if(count($permissions)>0){
								if(strlen($this->data['citys']['name'])==0){
									$this->Session->setFlash('bạn cần nhập tên quận/huyện','flash_Login_bad');
									return;
								}
								$User = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read($this->sessionUsername))));
								if(count($User)>0){
									$data=array(
											'name' => $this->data['citys']['name'],
											'id_citys' => $citys['city']['id'],
											'byUser' =>$User['User']['id'],
											'createDate'=>date('Y-m-d H:i:s'),
										);
									$this->Region->create();
									$this->Region->set($data);
									if($this->Region->save()) $this->Session->setFlash('<i class="fa fa-thumbs-up" aria-hidden="true"></i> Lưu thành công','flash_Login_bad');
									else $this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Lưu thất bại','flash_Login_bad'); 
								}
							}
							else $this->Session->setFlash('<i class="fa fa-meh-o" aria-hidden="true"></i> Bạn chưa được cấp quyền thêm quận/huyện ','flash_Login_bad');
						}
						$this->set('href',$link);
						$this->set('nameCitys', $citys['city']['name']);
						$this->set('slug',$slug);
						$this->set('Table',$this->Region->find('all',array('conditions'=>array('id_citys'=>$slug))));
						return;
					}
					else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'citys','action'=>'index'));
		}
		function delete($slug=null,$id=null){
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id_slug = $lib->parseint($slug);
				if($id_slug!==false && $id_slug>0){
					$citys = $this->city->find('first',array('conditions'=>array('id'=>$slug)));
					if(count($citys)>0){
						if(isset($id) && strlen($id)>0){
							$id_region=$lib->parseint($id);
							if($id_region!==false && $id_region>0){
								if($this->Region->delete($id)) $this->Session->setFlash('Xóa thành công','flash_Login_bad');
								else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
							}else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
						}
						else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');

						$this->redirect(array('controller'=>'Region','action'=>'index','slug'=>$slug));
					}
					else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'citys','action'=>'index'));
		}
	}