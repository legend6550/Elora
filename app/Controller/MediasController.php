<?php
	App::uses('lib', 'Lib');
	class MediasController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','image','authoritie');
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
			$sqlWhere = '';
			$order = 'DESC';
			$paramenterUrl = '';
			$lib = new lib();
			$this->set('title','Quản lý hình ảnh');
			$currentPage = 0;
			$regionPage = 24;
			if(isset($_GET['page'])){
				$tmpPage = $_GET['page'];
				$page = $lib->parseint($tmpPage);
				if($page===false) $currentPage = 1;
				else if($page<=0) $currentPage = 1;
				else $currentPage = $page;
				
				$currentPage--;
			}

			if(isset($_GET['caption']) && strlen($_GET['caption'])>0)
			{
				$sqlWhere .= '`Caption` LIKE "%'.$_GET['caption'].'%" and `Description` LIKE "%'.$_GET['caption'].'%"';
				$paramenterUrl = 'caption='.$_GET['caption'];
			}
			if(isset($_GET['sort_date']) && strlen($_GET['sort_date'])>0)
				if(strcmp(strtolower($_GET['sort_date']),strtolower('ASC'))===0 || strcmp(strtolower($_GET['sort_date']),strtolower('DESC'))==0)
				{
					$order = $_GET['sort_date'];
					if(strlen($paramenterUrl)>0) $paramenterUrl='&sort_date='.$_GET['sort_date'];
					else $paramenterUrl='sort_date='.$_GET['sort_date'];
				}
			if(isset($_GET['sort_format']) && strlen($_GET['sort_format'])>0)
			{
				
				if(strlen($paramenterUrl)>0)
				{
					$paramenterUrl='&sort_format='.$_GET['sort_format'];
					$sqlWhere .= 'and `FileType`="'.$_GET['sort_format'].'"';
				}
				else
				{
					$paramenterUrl='sort_format='.$_GET['sort_format'];
					$sqlWhere .= '`FileType`="'.$_GET['sort_format'].'"';
				}
			}
			$sql = '';
			if(strlen($sqlWhere)==0) $sql = 'SELECT * FROM `images` ORDER BY `images`.`CreateDate` '.$order.' LIMIT '.($currentPage*$regionPage).','.$regionPage;
			else $sql = 'SELECT * FROM `images` WHERE '.$sqlWhere.' ORDER BY `images`.`CreateDate` '.$order.' LIMIT '.($currentPage*$regionPage).','.$regionPage;
			$data = $this->image->query($sql);
			$this->set('Tables',$data);
			$this->set('currentPage',$currentPage+1);
			$this->set('TotalPage',$lib->totalpage($this->image->find('count')/$regionPage));
			if(strlen($paramenterUrl)>0) $this->set('url','?page={page}&'.$paramenterUrl);
			else $this->set('url','?page={page}');
		}
		public function add(){
			$this->set('title','thêm hình ảnh');
			if(isset($_POST['btnsave'])){
				$lib = new lib();
				for($i=0;$i<count($this->data['User']['image']);$i++){
					$tmp = $lib->uploadFileCakePHP('assets/images',$this->data['User']['image'][$i]);
					if(isset($tmp['urls'][0])){
						$data = getimagesize(WWW_ROOT.'/'.$tmp['urls'][0]);
						$this->image->create();
						$this->image->save(array(
								'Caption' => '',
								'CreateDate' => date('Y-m-d H:i:s'),
								'Description' => '',
								'FileHeight' => $data[1],
								'FileName' => basename($this->data['User']['image'][$i]['name'],'.'.pathinfo($this->data['User']['image'][$i]['name'], PATHINFO_EXTENSION)),
								'FileSize' => $this->data['User']['image'][$i]['size'],
								'FileType' => $this->data['User']['image'][$i]['type'],
								'FileURL' => '/'.$tmp['urls'][0],
								'FileWidth' => $data[0],
								'Permalink' => $this->data['User']['image'][$i]['name']
							));
					}
				}
			}
		}
		public function delete(){
			if(isset($_GET['id'])){
				$data = $this->image->find('first',array('conditions'=>array('id'=>$_GET['id'])));
				if(count($data)>0){
					if (!unlink(WWW_ROOT.'/'.$data['image']['FileURL'])){
						$this->Session->setFlash('Không thể xóa file này','flash_Login_bad');
					}else{
						$this->image->deleteAll(array('image.id' => $_GET['id']), false);
						$this->Session->setFlash('Xóa thành công','flash_Login_bad');
					}
				}
				else $this->Session->setFlash('Không tìm thấy hình ảnh vừa chọn','flash_Login_bad');
			}
			else $this->Session->setFlash('Không tìm thấy hình ảnh vừa chọn','flash_Login_bad');
			$this->redirect(array('action' => 'index'));
		}
		public function edit($slug = null){
			$this->set('title','chỉnh sửa thông tin hình ảnh');
			$lib = new lib();
			if(isset($slug) && strlen($slug)>0){
				$id =  $lib->parseint($slug);
				if($id!==null && $id>0){
					$data = $this->image->find('first',array('conditions'=>array('id'=>$slug)));
					if(count($data)>0){
						if(isset($_POST['btnsave'])){
							$this->image->read(null,$data['image']['id']);
							$this->image->save(array(
									'Caption' => $this->data['Medias']['Caption'],
									'Description' => $this->data['Medias']['Description']
								));
							$this->Session->setFlash('Chỉnh sửa thành công','flash_Login_bad');
							$this->redirect(array('action' => 'index'));
						}
						else
						{
							if(strlen($data['image']['FileURL'])>0 && file_exists(WWW_ROOT.$data['image']['FileURL']))
							{
								$this->set('images',$data['image']['FileURL']);
								$this->set('Caption',$data['image']['Caption']);
								$this->set('Description',$data['image']['Description']);
								$this->set('format',$data['image']['FileType']);
								$this->set('size',$data['image']['FileSize']);
								$this->set('dimension',$data['image']['FileWidth'].'x'.$data['image']['FileHeight']);
								return;
							}
						}
					}
				}
			}
			$this->Session->setFlash('Không tìm thấy hình ảnh vừa chọn','flash_Login_bad');
			$this->redirect(array('action' => 'index'));
		}
	}