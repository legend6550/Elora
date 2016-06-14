<?php
	App::uses('lib', 'Lib');
	class AdministratorController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Config','Slide','authoritie');
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
		public function dashboard(){
			$this->set('title','Administrator');
		}
		public function settingSite(){
			$this->set('title','Cài đặt website');
			$this->set('titleSite','');
			$this->set('description','');
			$this->set('keywords','');
			$this->set('logo','/assets/images/no-avatar.jpg');
			$this->set('icon','/assets/images/no-avatar.jpg');
			$this->set('namelogo','no-avatar.jpg');
			$this->set('nameicon','no-avatar.jpg');
			if(isset($this->data['btnsave'])){
				$lib = new lib();
				if($this->Config->find('count')>0){
					$edit = false;
					$db = $this->Config->getDataSource();
					$edit = $this->Config->updateAll(array(
													'title' => $db->value($this->data['User']['title'], 'string'),
													'description' => $db->value($this->data['User']['description'], 'string'),
													'keywords' => $db->value($this->data['User']['keywords'], 'string')
												));
					if(isset($this->data['User']['logo'])){
						$tmp = $lib->uploadFileCakePHP('assets/images',$this->data['User']['logo']);
						if(isset($tmp['urls'][0])){
							$edit = $this->Config->updateAll(
													array('logo' => $db->value(str_replace('assets/images/','',$tmp['urls'][0]), 'string'))
												);

						}
					}
					if(isset($this->data['User']['icon'])){
						$tmp = $lib->uploadFileCakePHP('assets/images',$this->data['User']['icon']);
						if(isset($tmp['urls'][0])){
							$edit = $this->Config->updateAll(
													array('icon' => $db->value(str_replace('assets/images/','',$tmp['urls'][0]), 'string'))
												);
						}
					}
					if($edit) $this->Session->setFlash('Lưu thành công','flash_Login_bad');
				} 
				else
				{
					$data = array(
								'title' => $this->data['User']['title'],
								'description' => $this->data['User']['description'],
								'keywords' => $this->data['User']['keywords']
							);
					if(isset($this->data['User']['logo'])){
						$tmp = $lib->uploadFileCakePHP('assets/images',$this->data['User']['logo']);
						if(isset($tmp['urls'][0])){
							$data['logo']=str_replace('assets/images/','',$tmp['urls'][0]);
						}
					}
					if(isset($this->data['User']['icon'])){
						$tmp = $lib->uploadFileCakePHP('assets/images',$this->data['User']['icon']);
						if(isset($tmp['urls'][0])){
							$data['icon']=str_replace('assets/images/','',$tmp['urls'][0]);
						}
					}
					if($this->Config->save($data)) $this->Session->setFlash('Lưu thành công','flash_Login_bad');
				}
				
			}
			if($this->Config->find('count')>0)
			{
				$config=$this->Config->find('first');
				$this->set('titleSite',$config['Config']['title']);
				$this->set('description',$config['Config']['description']);
				$this->set('keywords',$config['Config']['keywords']);
				$this->set('logo',(strlen($config['Config']['logo'])>0 && file_exists(WWW_ROOT.'/assets/images/'.$config['Config']['logo']))?'/assets/images/'.$config['Config']['logo']:'/assets/images/no-avatar.jpg');
				$this->set('icon',(strlen($config['Config']['icon'])>0 && file_exists(WWW_ROOT.'/assets/images/'.$config['Config']['icon']))?'/assets/images/'.$config['Config']['icon']:'/assets/images/no-avatar.jpg');
				$this->set('namelogo',$config['Config']['logo']);
				$this->set('nameicon',$config['Config']['icon']);
			}
		}
		public function settingSocial(){
			$this->set('title','Cài đặt mạng xã hội');
			$this->set('facebook','');
			$this->set('Google','');
			$this->set('Twitter','');
			$this->set('Intagram','');
			$this->set('youtube','');
			if(isset($this->data['btnsave'])){
				$lib = new lib();
				if($this->Config->find('count')>0){
					$edit = false;
					$db = $this->Config->getDataSource();
					$edit = $this->Config->updateAll(array(
													'linkFacebook' => $db->value($this->data['User']['facebook'], 'string'),
													'linkGoogle' => $db->value($this->data['User']['Google'], 'string'),
													'linkTwitter' => $db->value($this->data['User']['Twitter'], 'string'),
													'linkIntagram' => $db->value($this->data['User']['Intagram'], 'string'),
													'linkYoutube' => $db->value($this->data['User']['youtube'], 'string')
												));
					if($edit) $this->Session->setFlash('Lưu thành công','flash_Login_bad');
				} 
				else
				{
					$data = array(
								'linkFacebook' => $this->data['User']['facebook'],
								'linkGoogle' => $this->data['User']['Google'],
								'linkTwitter' => $this->data['User']['Twitter'],
								'linkIntagram' => $this->data['User']['Intagram'],
								'linkYoutube' => $this->data['User']['youtube']
							);
					if($this->Config->save($data)) $this->Session->setFlash('Lưu thành công','flash_Login_bad');
				}
				
			}
			if($this->Config->find('count')>0)
			{
				$config = $this->Config->find('first');
				$this->set('facebook',$config['Config']['linkFacebook']);
				$this->set('Google',$config['Config']['linkGoogle']);
				$this->set('Twitter',$config['Config']['linkTwitter']);
				$this->set('Intagram',$config['Config']['linkIntagram']);
				$this->set('youtube',$config['Config']['linkYoutube']);
			}
		}
		public function settingMail(){
			
		}
		public function settingSlide(){
			$this->set('title','cài đặt slide');
			$this->set('titleSlide','');
			$this->set('descriptionSlide','');
			$this->set('btnlink','');
			$this->set('link','');
			$this->set('picture','');
			if(isset($_GET['id'])){
				$Slide = $this->Slide->find('first',array('conditions'=>array('id'=>$_GET['id'])));
				if(count($Slide)>0){

					if(strlen($Slide['Slide']['images'])>0 && file_exists(WWW_ROOT.'/assets/images/slide/'.$Slide['Slide']['images'])) 
				        $icon='/assets/images/slide/'.$Slide['Slide']['images'];
				    else
				       $icon='/assets/images/no-image.png';
					
					if(isset($_POST['btnsave'])){
						$data = array(
								'content' => $this->data['User']['description'],
								'title' => $this->data['User']['title'],
								'linkButton' => $this->data['User']['link'],
								'textButton' => $this->data['User']['btnlink'],
								'createDate' =>date('Y-m-d H:i:s')
							);
						if(isset($this->data['User']['picture'])){
							$lib = new lib();
							$tmp = $lib->uploadFileCakePHP('assets/images/slide',$this->data['User']['picture']);
							if(isset($tmp['urls'][0])){
								$data['images']= str_replace('assets/images/slide/','',$tmp['urls'][0]);
							}
						}
						$this->Slide->read(null, $_GET['id']);
						$this->Slide->set($data);
						if($this->Slide->save())
						{
							$this->Session->setFlash('<i class="fa fa-check" aria-hidden="true"></i> Cập nhật thành công','flash_Login_bad');
							$this->redirect(array('controller' => 'Administrator', 'action' => 'settingSlide'));
						}
						else $this->Session->setFlash('<i class="fa fa-chain-broken" aria-hidden="true"></i> Cập nhật thất bại','flash_Login_bad');
					}

					$Image = '<label class="ace-file-input ace-file-multiple"><span class="ace-file-container hide-placeholder selected">';
					$Image=$Image.'<span class="ace-file-name" data-title="'.$Slide['Slide']['title'].'">';
					$Image=$Image.'<img class="middle" src="'.$icon.'" style="width: 50px; height: 50px;"><i class=" ace-icon fa fa-picture-o file-image"></i></span></span></label><hr>';
					$this->set('titleSlide',$Slide['Slide']['title']);
					$this->set('descriptionSlide',$Slide['Slide']['content']);
					$this->set('btnlink',$Slide['Slide']['textButton']);
					$this->set('link',$Slide['Slide']['linkButton']);
					$this->set('picture',$Image);
				}
				else 
				{
					$this->Session->setFlash('<i class="fa fa-chain-broken" aria-hidden="true"></i> Chúng tôi không tìm thấy thông tin lưu trữ với mã quản lý này','flash_Login_bad');
					$this->redirect(array('controller' => 'Administrator', 'action' => 'settingSlide'));
				}
			}
			elseif (isset($_GET['delete'])) {
				$Slide = $this->Slide->find('first',array('conditions'=>array('id'=>$_GET['delete'])));
				if(count($Slide)>0){
					if($this->Slide->delete($_GET['delete']))
					{
						$this->Session->setFlash('<i class="fa fa-check" aria-hidden="true"></i> Xóa thành công','flash_Login_bad');
						$this->redirect(array('controller' => 'Administrator', 'action' => 'settingSlide'));
					}
					else $this->Session->setFlash('<i class="fa fa-chain-broken" aria-hidden="true"></i> xóa dữ liệu thất bại','flash_Login_bad');
				}
				else
				{
					$this->Session->setFlash('<i class="fa fa-chain-broken" aria-hidden="true"></i> Chúng tôi không tìm thấy thông tin lưu trữ với mã quản lý này','flash_Login_bad');
					$this->redirect(array('controller' => 'Administrator', 'action' => 'settingSlide'));
				}
			}
			elseif (isset($_POST['btnsave'])){
					if(isset($this->data['User']['picture'])){
						$lib = new lib();
						$tmp = $lib->uploadFileCakePHP('assets/images/slide',$this->data['User']['picture']);
						if(isset($tmp['urls'][0])){
							$data = array(
								'content' => $this->data['User']['description'],
								'title' => $this->data['User']['title'],
								'linkButton' => $this->data['User']['link'],
								'textButton' => $this->data['User']['btnlink'],
								'images' => str_replace('assets/images/slide/','',$tmp['urls'][0]),
								'createDate' =>date('Y-m-d H:i:s')
							);
							if($this->Slide->save($data)) $this->Session->setFlash('<i class="fa fa-check" aria-hidden="true"></i> Lưu thành công','flash_Login_bad');
						}
					}
				}
			$this->set('Table',$this->Slide->find('all'));
		}
	}
?>