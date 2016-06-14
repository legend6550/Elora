<?php
	App::uses('lib', 'Lib');
	class CategorysController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Color','authoritie','category');
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
			$lib = new lib();
			$this->set('title', 'Quản trị loại sản phẩm');
			$DataCategory = array();
			$DataTableCategory = $this->category->find('all',array('conditions' => array('id_parrent' => '0')));
			$name = '';
			$index = 0;
			$nodes = '';
			$parrent = '';
			if(isset($_GET['id'])){
				$id = $lib->parseint($_GET['id']);
				if($id===false || $id<0){
					$this->Session->setFlash('<i class="fa fa-times" aria-hidden="true"></i> Không tìm thấy dữ liệu','flash_Login_bad');
					$this->redirect(array('controller'=>'Categorys','action'=>'index'));
					return;
				} else {
					$currentCategory = $this->category->find('first',array('conditions' => array('id' => $_GET['id'])));
					if(count($currentCategory)>0){
						if(isset($_POST['btnsave'])){
							$err = '';
							if(!isset($this->data['Categorys']['name']) || strlen($this->data['Categorys']['name'])==0) $err .= '<li>Bạn cần nhập tên</li>';
							if(!isset($this->data['Categorys']['index']) || strlen($this->data['Categorys']['index'])==0 || $lib->parseint($this->data['Categorys']['index'])===false ||$lib->parseint($this->data['Categorys']['index'])<=0) $err .= '<li>Bạn cần nhập vị trí</li>';
							if(!isset($_POST['cbomenu']) || strlen($_POST['cbomenu'])==0) $err .= '<li>Bạn cần chọn menu cha</li>';
							else {
								$id = $lib->parseint($_POST['cbomenu']);
								if($id===false || $id<0)  $err .= '<li>Bạn cần chọn menu cha</li>';
								if($id!==0){
									if(count($this->category->find('all',array('conditions' => array('id' => $id))))==0){
										$err .= '<li>Bạn cần chọn menu cha</li>';
									}
								}
							}
							if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
							else {
								$dataCurrent = $this->category->find('all',array(
											'conditions' => array('id_parrent' => $_POST['cbomenu'],'index >='=>$this->data['Categorys']['index']),
											'order' => array('index ASC')
									));
								$index = $this->data['Categorys']['index'];
								for($i=0;$i<count($dataCurrent);$i++){
									$this->category->read(null,$dataCurrent[$i]['category']['id']);
									$this->category->set(array('index'=>++$index));
									$this->category->save();
								}
								$this->category->read(null, $_GET['id']);
								$this->category->set(array(
										'name' => $this->data['Categorys']['name'],
										'index' => $this->data['Categorys']['index'],
										'id_parrent' => $_POST['cbomenu'],
										'node' =>$this->data['Categorys']['nodes']
									));
								if($this->category->save())
								{
									$index = 1;
									$dataCurrent = $this->category->find('all',array(
											'conditions' => array('id_parrent' => $_POST['cbomenu']),
											'order' => array('index ASC')
										));
									for($i=0;$i<count($dataCurrent);$i++){
										$this->category->read(null,$dataCurrent[$i]['category']['id']);
										$this->category->set(array('index'=>$index++));
										$this->category->save();
									}
									if($currentCategory['category']['id_parrent']!==$_POST['cbomenu']){
										$index = 1;
										$dataCurrent = $this->category->find('all',array(
												'conditions' => array('id_parrent' => $currentCategory['category']['id_parrent']),
												'order' => array('index ASC')
											));
										for($i=0;$i<count($dataCurrent);$i++){
											$this->category->read(null,$dataCurrent[$i]['category']['id']);
											$this->category->set(array('index'=>$index++));
											$this->category->save();
										}
									}
									$this->Session->setFlash('<i class="fa fa-check" aria-hidden="true"></i> Lưu trữ thành công','flash_Login_bad');
									$this->redirect(array('controller'=>'Categorys','action'=>'index'));
									return;
								}
								else $this->Session->setFlash('<i class="fa fa-times" aria-hidden="true"></i> Lưu trữ thất bại','flash_Login_bad');
							}
						}
						$name = $currentCategory['category']['name'];
						$index = $currentCategory['category']['index'];
						$nodes = $currentCategory['category']['node'];
						$parrent = $currentCategory['category']['id_parrent'];						
					} else {
						$this->Session->setFlash('<i class="fa fa-times" aria-hidden="true"></i> Không tìm thấy dữ liệu','flash_Login_bad');
						$this->redirect(array('controller'=>'Categorys','action'=>'index'));
						return;
					}
				}
				
			} elseif (isset($_POST['btnsave'])){
				$err = '';
				if(!isset($this->data['Categorys']['name']) || strlen($this->data['Categorys']['name'])==0) $err .= '<li>Bạn cần nhập tên</li>';
				if(!isset($this->data['Categorys']['index']) || strlen($this->data['Categorys']['index'])==0 || $lib->parseint($this->data['Categorys']['index'])===false ||$lib->parseint($this->data['Categorys']['index'])<=0) $err .= '<li>Bạn cần nhập vị trí</li>';
				if(!isset($_POST['cbomenu']) || strlen($_POST['cbomenu'])==0) $err .= '<li>Bạn cần chọn menu cha</li>';
				else {
					$id = $lib->parseint($_POST['cbomenu']);
					if($id===false || $id<0)  $err .= '<li>Bạn cần chọn menu cha</li>';
					if($id!==0){
						if(count($this->category->find('all',array('conditions' => array('id' => $id))))==0){
							$err .= '<li>Bạn cần chọn menu cha</li>';
						}
					}
				}
				if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
				else {
					$current = $this->User->find('first',array('conditions'=>array('username'=>$this->Session->read($this->sessionUsername))));
					$dataCurrent = $this->category->find('all',array(
								'conditions' => array('id_parrent' => $_POST['cbomenu'],'index >='=>$this->data['Categorys']['index']),
								'order' => array('index ASC')
						));
					$index = $this->data['Categorys']['index'];
					for($i=0;$i<count($dataCurrent);$i++){
						$this->category->read(null,$dataCurrent[$i]['category']['id']);
						$this->category->set(array('index'=>++$index));
						$this->category->save();
					}
					if(count($current)>0)
					{
						$this->category->create();
						$this->category->set(array(
								'name' => $this->data['Categorys']['name'],
								'index' => $this->data['Categorys']['index'],
								'id_parrent' => $_POST['cbomenu'],
								'createDate' => date('Y-m-d H:i:s'),
								'byUser' =>  $current['User']['id'],
								'node' =>$this->data['Categorys']['nodes']
							));
						if($this->category->save())
						{
							$index = 1;
							$dataCurrent = $this->category->find('all',array(
									'conditions' => array('id_parrent' => $_POST['cbomenu']),
									'order' => array('index ASC')
								));
							for($i=0;$i<count($dataCurrent);$i++){
								$this->category->read(null,$dataCurrent[$i]['category']['id']);
								$this->category->set(array('index'=>$index++));
								$this->category->save();
							}
							$this->Session->setFlash('<i class="fa fa-check" aria-hidden="true"></i> Lưu trữ thành công','flash_Login_bad');
						}
						else $this->Session->setFlash('<i class="fa fa-times" aria-hidden="true"></i> Lưu trữ thất bại','flash_Login_bad');
					}
				}
			}
			$this->set('optionMenu',$this->category->ExportStringCombobox('0','',$parrent));
			$this->set('DataTables',$this->category->ExportStringTables('0'));
			$this->set('name',$name);
			$this->set('index',$index);
			$this->set('nodes',$nodes);
		}
	}