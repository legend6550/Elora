<?php
App::uses('AppController', 'Controller');
App::uses('lib', 'Lib');
class UsersController extends AppController {
	public $uses = array('User','authoritie','role','city','userAddress','userContacts','Region','category');
	var $sessionUsername = 'userLogin';
	var $layout = '_MasterLogin';
	public function login(){
		$this->set('titlePage','Đăng nhập');
		if(isset($this->data['btnsave'])){
			$username = '';
			$password = '';
			if(isset($this->data['User']['username'])) $username = $this->data['User']['username'];
			if(isset($this->data['User']['password'])) $password = $this->data['User']['password'];

			$data = $this->User->find('first',array(
						'conditions'=>array(
							'username'=>$username,
							'password'=>md5($password)
						)));

			if(!empty($data))
			{
				$this->Session->write($this->sessionUsername,$username);
				$role = $this->role->query('SELECT `roles`.* FROM `authorities`,`roles` WHERE `roles`.`id`=`authorities`.`Dashboard` and `authorities`.`id`='.$data['User']['Permission']);
				if(count($role)>0){
					$this->redirect(array('controller'=>$role[0]['roles']['ControllerName'],'action'=>$role[0]['roles']['ActionName']));
				} else{
					$dataRole=$this->authoritie->query('SELECT *, EXISTS ( SELECT * FROM `authorities`,`permissions`,`users` where `authorities`.`id`=`permissions`.`id_authorities` and `roles`.`id`=`permissions`.`id_role` and `authorities`.`id`=`users`.`Permission` and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\') as \'CheckRoles\' FROM `roles` WHERE 1 ORDER BY `type_node` ASC, `index` ASC');
					for($i=0;$i<count($dataRole);$i++){
						if($dataRole[$i][0]['CheckRoles']==='1' && $dataRole[$i]['roles']['ControllerName']!=='#' && $dataRole[$i]['roles']['ActionName']!=='#')
						{
							$this->redirect(array('controller'=>$dataRole[$i]['roles']['ControllerName'],'action'=>$dataRole[$i]['roles']['ActionName']));
							return;
						}
					}


				}
				
			}
			else $this->Session->setFlash('sai mật khẩu hoặc password','flash_Login_bad');
		}
	}
	public function logout(){
		$this->Session->delete($this->sessionUsername);
		$this->redirect(array('controller'=>'Users','action'=>'login'));
	}
	public function profile(){
		$this->layout = '_MasterAdministrator';
		$username = '';
		if(!$this->Session->read($this->sessionUsername))$this->redirect(array('controller'=>'Users','action'=>'login'));
		else $username = $this->Session->read($this->sessionUsername);


		if(isset($_GET['id'])) $arrayConditions = array('conditions'=>array('id'=>$_GET['id']));
		else $arrayConditions = array('conditions'=>array('username'=>$username));

		$user = $this->User->find('first',$arrayConditions);
		$this->set('user',$user);
		if(isset($_POST['btnsave']))
		{
			$err = '';
			$sql='';
			$lib = new lib();
			$image = $lib->uploadFiles('txtavatar');
			if(isset($_POST['txtfullname']) && strlen($_POST['txtfullname'])>0) 
			{
				$sql = $sql.'`fullname`="'.$_POST['txtfullname'].'",';
				$user['fullname']=$_POST['txtfullname'];
			}
			else $err=$err.'<li>Bạn cần phải nhập họ và tên</li>';

			if(isset($_POST['txtbirthday']) && strlen($_POST['txtbirthday'])>0 && date_parse($_POST['txtbirthday']))
			{
				$sql=$sql.'`birthday`="'.date_parse($_POST['txtbirthday'])['year'].'-'.date_parse($_POST['txtbirthday'])['month'].'-'.date_parse($_POST['txtbirthday'])['day'].'",';
				$user['birthday']=$_POST['txtbirthday'];
			}
			else $err=$err.'<li>Bạn cần phải nhập ngày tháng năm sinh</li>';
			if(isset($_POST['rdgender']) && strlen($_POST['rdgender'])>0)
			{
				$sql=$sql.'`gender`="'.$_POST['rdgender'].'",';
				$user['gender']=$_POST['rdgender'];
			}
			else $err=$err.'<li>Bạn cần phải nhập giới tính</li>';
			if(isset($_POST['txtStreet']) && strlen($_POST['txtStreet'])>0)
			{
				$sql=$sql.'`Street`="'.$_POST['txtStreet'].'",';
				$user['Street']=$_POST['txtStreet'];
			}
			else $err=$err.'<li>Bạn cần phải nhập tên đường</li>';
			if(isset($_POST['txtregion']) && strlen($_POST['txtregion'])>0)
			{
				$sql=$sql.'`region`="'.$_POST['txtregion'].'",';
				$user['region']=$_POST['txtregion'];
			}
			else $err=$err.'<li>Bạn cần phải nhập tên Quận/huyện/xã</li>';
			if(isset($_POST['txtcity']) && strlen($_POST['txtcity'])>0)
			{
				$sql=$sql.'`city`="'.$_POST['txtcity'].'",';
				$user['city']=$_POST['txtcity'];
			}
			else $err=$err.'<li>Bạn cần phải nhập tên tỉnh/thành phố</li>';
			if(isset($_POST['txtphone']) && strlen($_POST['txtphone'])>0)
			{
				$sql=$sql.'`phone`="'.$_POST['txtphone'].'",';
				$user['phone']=$_POST['txtphone'];
			}
			else $err=$err.'<li>Bạn cần phải nhập số điện thoại</li>';
			if(strlen($image)>0) $sql=$sql.'`avatar`="'.$image.'",';
			if(isset($_POST['cborule']) && strlen($_POST['cborule'])>0)
				$sql= $sql.'`rule`="'.$_POST['cborule'].'",';
			if(strlen($err)==0)
			{
				$this->User->query('update `users` set '.substr($sql,0,strlen($sql)-1).'where `id`='.$user['User']['id']);
				$this->Session->setFlash('<i class="ace-icon fa fa-check green"></i> Cập nhật thành công','flash_Login_bad');
			}
			else $this->Session->setFlash($err,'flash_Login_bad');
		}
	}
	public function changePass(){

		$this->layout = '_MasterAdministrator';
		$this->set('title','Đổi mật khẩu');
		$username = '';
		if(!$this->Session->read($this->sessionUsername))$this->redirect(array('controller'=>'Users','action'=>'login'));
		else $username = $this->Session->read($this->sessionUsername);
		$user = $this->User->find('first',array('conditions'=>array('username'=>$username)));
		$this->set('user',$user);

		if(isset($_POST['btnsave']))
		{
			$err='';
			$passold='';
			$passnew='';
			if(isset($_POST['txtpasswordold']) && strlen($_POST['txtpasswordold'])>0) $passold = $_POST['txtpasswordold'];
			else $err=$err.'<li>Bạn cần phải nhập mật khẩu cũ</li>';
			if(isset($_POST['txtpasswordnew']) && strlen($_POST['txtpasswordnew'])>0) $passnew = $_POST['txtpasswordnew'];
			else $err=$err.'<li>Bạn cần phải nhập mật khẩu mới</li>';
			if(strlen($err)==0)
			{
				$passrelay='';
				if(isset($_POST['txtpasswordrelay']) && strlen($_POST['txtpasswordrelay'])>0) $passrelay = $_POST['txtpasswordrelay'];
				if(strcmp($passrelay, $passnew)==0){
					if(strcmp(md5($passold), $user['User']['password'])==0)
					{
						$sql='`password`="'.md5($passnew).'"';
						$this->User->query('update `users` set '.$sql.' where `id`='.$user['User']['id']);
						$err='<i class="ace-icon fa fa-check green"></i> Cập nhật thành công';
					}
					else $err=$err.'<li>Sai mật khẩu</li>';
				}
				else $err=$err.'<li>Mật khẩu mới không giống nhau</li>';
			}
			if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
		}
	}
	public function index(){
		$this->layout = '_MasterAdministrator';
		$this->set('title','Danh sách tài khoản');
		$username = '';
		/*== Kiểm tra phân quyền và chức năng ===*/
		if(!$this->Session->read($this->sessionUsername))$this->redirect(array('controller'=>'Users','action'=>'login'));
		else $username = $this->Session->read($this->sessionUsername);
		if(isset($_GET['id'])) $arrayConditions = array('conditions'=>array('id'=>$_GET['id']));
		else $arrayConditions = array('conditions'=>array('username'=>$username));
		$user = $this->User->find('first',$arrayConditions);
		$this->set('user',$user);
		$lib = new lib();
		$sql='SELECT *, EXISTS ( SELECT * FROM `authorities`,`permissions`,`users` where `authorities`.`id`=`permissions`.`id_authorities` and `roles`.`id`=`permissions`.`id_role` and `authorities`.`id`=`users`.`Permission` and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\') as \'CheckRoles\' FROM `roles` WHERE 1 ORDER BY `type_node` ASC, `index` ASC';
		$this->set('menuHtml',$lib->ExportHtmlMenu($this->authoritie->query($sql),$this->params['action'],$this->params['controller']));
		/*== Kiểm tra phân quyền và chức năng ===*/

		$stringTables = '';
		$Tables = $this->User->find('all',array('conditions'=>array('username <>'=>$username)));
		$TablesAuthorities = $this->authoritie->find('all');
		for($i=0;$i<count($Tables);$i++){
			$stringTables .= '<tr class="'.($i%2===0?'even pointer':'odd pointer').'">';
			$stringTables .= '<td>'.$Tables[$i]['User']['id'].'</td>';
			$stringTables .= '<td>'.$Tables[$i]['User']['username'].'</td>';
			$stringTables .= '<td>'.$Tables[$i]['User']['first_name'].' '.$Tables[$i]['User']['last_name'].'</td>';
			$stringTables .= '<td>'.($Tables[$i]['User']['gender']==='1'?'Nam':'Nữ').'</td>';
			$stringTables .= '<td>'.$Tables[$i]['User']['gmail'].'</td>';
			$stringTables .= '<td>'.$Tables[$i]['User']['createDate'].'</td>';
			$permission='<option value="">--Chưa xác định--</option>';
			for($j=0;$j<count($TablesAuthorities);$j++){
				$permission .='<option value="'.$TablesAuthorities[$j]['authoritie']['id'].'" '.($TablesAuthorities[$j]['authoritie']['id']===$Tables[$i]['User']['Permission']?'selected':'').'>'.$TablesAuthorities[$j]['authoritie']['name'].'</option>';
			}
			$stringTables .= '<td><select data-option="permission" data-value="'.$Tables[$i]['User']['Permission'].'" class="form-control" data-id="'.$Tables[$i]['User']['id'].'">'.$permission.'</select></td>';

			$html='<div class="hidden-sm hidden-xs action-buttons"><a class="green" href="'.Router::url( array('controller'=>'Users','action'=>'update','slug'=>$Tables[$i]['User']['id']), true ).'"><i class="ace-icon fa fa-pencil bigger-130"></i></a></div>';


			$stringTables .= '<td>'.$html.'</td>';
			$stringTables .= '</tr>';
		}
		$this->set('username',$username);
		$this->set('Tables',$stringTables);
	}
	public function add(){
		$this->layout = '_MasterAdministrator';
		$this->set('title','Thêm tài khoản');
		$username = '';
		/*== Kiểm tra phân quyền và chức năng ===*/
		if(!$this->Session->read($this->sessionUsername))$this->redirect(array('controller'=>'Users','action'=>'login'));
		else $username = $this->Session->read($this->sessionUsername);
		if(isset($_GET['id'])) $arrayConditions = array('conditions'=>array('id'=>$_GET['id']));
		else $arrayConditions = array('conditions'=>array('username'=>$username));
		$user = $this->User->find('first',$arrayConditions);
		$this->set('user',$user);
		$lib = new lib();
		$sql='SELECT *, EXISTS ( SELECT * FROM `authorities`,`permissions`,`users` where `authorities`.`id`=`permissions`.`id_authorities` and `roles`.`id`=`permissions`.`id_role` and `authorities`.`id`=`users`.`Permission` and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\') as \'CheckRoles\' FROM `roles` WHERE 1 ORDER BY `type_node` ASC, `index` ASC';
		$this->set('menuHtml',$lib->ExportHtmlMenu($this->authoritie->query($sql),$this->params['action'],$this->params['controller']));
		/*== Kiểm tra phân quyền và chức năng ===*/
		$DataCitys = array();
		$DataAuthoritie = array();
		$DataTable_Citys = $this->city->find('all');
		$DataTable_authoritie = $this->authoritie->find('all');
		for($i=0;$i<count($DataTable_Citys);$i++){
			$DataCitys[$DataTable_Citys[$i]['city']['id']] = $DataTable_Citys[$i]['city']['name'];
		}
		for($i=0;$i<count($DataTable_authoritie);$i++){
			$DataAuthoritie[$DataTable_authoritie[$i]['authoritie']['id']] = $DataTable_authoritie[$i]['authoritie']['name'];
		}
		$this->set('citys',$DataCitys);
		$this->set('authorities',$DataAuthoritie);
		if(isset($_POST['btnsave'])){
			$err = '';
			/*variable*/
			if(!isset($this->data['Users']['first_name']) || strlen($this->data['Users']['first_name'])==0) $err = '<li>Bạn cần nhập họ</li>';
			if(!isset($this->data['Users']['first_name']) || strlen($this->data['Users']['first_name'])==0) $err .= '<li>Bạn cần nhập Tên</li>';
			if(!isset($this->data['Users']['birthday']) || strlen($this->data['Users']['birthday'])==0) $err .= '<li>Bạn cần nhập ngày sinh</li>';
			if(!isset($this->data['Users']['username']) || strlen($this->data['Users']['username'])==0) $err .= '<li>Bạn cần nhập tài khoản</li>';
			if(!isset($this->data['Users']['mail']) || strlen($this->data['Users']['mail'])==0) $err .= '<li>Bạn cần nhập địa chỉ mail</li>';
			else if (!filter_var($this->data['Users']['mail'], FILTER_VALIDATE_EMAIL)) $err .= '<li>Bạn cần nhập địa chỉ mail</li>';
			if(!isset($this->data['Users']['password']) || strlen($this->data['Users']['password'])==0) $err .= '<li>Bạn cần nhập mật khẩu</li>';
			if(!isset($this->data['Users']['authorities']) || strlen($this->data['Users']['authorities'])==0) $err .= '<li>Bạn cần chọn nhóm tài khoản</li>';
			if(strlen($err)>0){
				$this->Session->setFlash($err,'flash_Login_bad');
				return;
			} else {
				if(count($this->User->find('first',array('conditions'=>array('username'=>$this->data['Users']['username']))))>0){
					$this->Session->setFlash('Tài khoản này đã tồn tại','flash_Login_bad');
					return;
				}
				if(count($this->User->find('first',array('conditions'=>array('gmail'=>$this->data['Users']['mail']))))>0){
					$this->Session->setFlash('Địa chỉ mail này đã tồn tại','flash_Login_bad');
					return;
				}
				if(strcmp($this->data['Users']['password'],$this->data['Users']['repassword'])!==0){
					$this->Session->setFlash('Mật khẩu không trùng khớp','flash_Login_bad');
					return;
				}
				if(isset($this->data['Users']['image'])){
					$tmp = $lib->uploadFileCakePHP('assets/images',$this->data['Users']['image']);
					if(isset($tmp['urls'][0])){
						$image=str_replace('assets/images/','',$tmp['urls'][0]);
					}
				}
				$this->User->create();
				$this->User->set(array(
						'username'=>$this->data['Users']['username'],
						'password'=>md5($this->data['Users']['password']),
						'gmail'=>$this->data['Users']['mail'],
						'createDate'=>date('Y-m-d H:i:s'),
						'gender'=>$this->data['Users']['Gender'],
						'birthday'=>$this->data['Users']['birthday'],
						'first_name'=>$this->data['Users']['first_name'],
						'last_name'=>$this->data['Users']['last_name'],
						'avatar'=>$image
					));
				if($this->User->save()){
					if(isset($this->data['Users']['phone']) && strlen($this->data['Users']['phone'])>0){
						$this->userContacts->create();
						$this->userContacts->set(array(
								'name'=>'PHONE',
								'Values'=>$this->data['Users']['phone'],
								'key'=>'PHONE',
								'byUser'=>$this->User->id
							));
						$this->userContacts->save();
					}
					if(isset($this->data['Users']['facebook']) && strlen($this->data['Users']['facebook'])>0){
						$this->userContacts->create();
						$this->userContacts->set(array(
								'name'=>'PHONE',
								'Values'=>$this->data['Users']['facebook'],
								'key'=>'FACEBOOK',
								'byUser'=>$this->User->id
							));
						$this->userContacts->save();
					}
					if(isset($this->data['Users']['gmail']) && strlen($this->data['Users']['gmail'])>0){
						$this->userContacts->create();
						$this->userContacts->set(array(
								'name'=>'PHONE',
								'Values'=>$this->data['Users']['gmail'],
								'key'=>'GMAIL',
								'byUser'=>$this->User->id
							));
						$this->userContacts->save();
					}
					if(isset($this->data['Users']['zalo']) && strlen($this->data['Users']['zalo'])>0){
						$this->userContacts->create();
						$this->userContacts->set(array(
								'name'=>'PHONE',
								'Values'=>$this->data['Users']['zalo'],
								'key'=>'ZALO',
								'byUser'=>$this->User->id
							));
						$this->userContacts->save();
					}
					if(isset($this->data['Users']['citys']) && strlen($this->data['Users']['citys'])>0 &&
					isset($this->data['Users']['region']) && strlen($this->data['Users']['region'])>0 &&
					isset($this->data['Users']['address']) && strlen($this->data['Users']['address'])>0 ){
						$this->userAddress->create();
						$this->userAddress->set(array(
								'stress'=>$this->data['Users']['address'],
								'id_City'=>$this->data['Users']['citys'],
								'id_region'=>$this->data['Users']['region'],
								'id_User'=>$this->User->id
							));
						$this->userAddress->save();
					}

					$this->Session->setFlash('<i class="fa fa-check" aria-hidden="true"></i>Lưu trữ thành công','flash_Login_bad');
				}
				else $this->Session->setFlash('<i class="fa fa-chain-broken" aria-hidden="true"></i>lỗi lưu trữ','flash_Login_bad');
			}
		}
	}
	public function update($slug = null){
		$err = '';
		if(isset($slug) && strlen($slug)>0){
			$lib = new lib();
			$id = $lib->parseint($slug);
			if($id!==false && $id>0){

				$user= $this->User->find('first',array('conditions'=>array('id'=>$id)));
				if(count($user)>0){
					/*== Kiểm tra phân quyền và chức năng ===*/
					$username = '';
					$this->layout = '_MasterAdministrator';
					$this->set('title','cập nhật tài khoản');
					if(!$this->Session->read($this->sessionUsername))$this->redirect(array('controller'=>'Users','action'=>'login'));
					else {
						$username = $this->Session->read($this->sessionUsername);
						$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$username.'\' and `roles`.`ActionName`=\''.$this->params['action'].'\' and `roles`.`ControllerName`=\''.$this->params['controller'].'\'';
						if(count($this->User->query($sql))===0) {
							$this->redirect(array('controller'=>'Errors','action'=>'NotSetPermission'));
							return;
						}
					}
					$this->set('user',$user);
					$lib = new lib();
					$sql='SELECT *, EXISTS ( SELECT * FROM `authorities`,`permissions`,`users` where `authorities`.`id`=`permissions`.`id_authorities` and `roles`.`id`=`permissions`.`id_role` and `authorities`.`id`=`users`.`Permission` and `users`.`username`=\''.$this->Session->read($this->sessionUsername).'\') as \'CheckRoles\' FROM `roles` WHERE 1 ORDER BY `type_node` ASC, `index` ASC';
					$this->set('menuHtml',$lib->ExportHtmlMenu($this->authoritie->query($sql),$this->params['action'],$this->params['controller']));
					$DataCitys = array();
					$DataTable_Citys = $this->city->find('all');
					for($i=0;$i<count($DataTable_Citys);$i++){
						$DataCitys[$DataTable_Citys[$i]['city']['id']] = $DataTable_Citys[$i]['city']['name'];
					}
					$this->set('citys',$DataCitys);
					/** Lấy tất cả địa chỉ **/
					$DataCitys = '';
					$DataTableCitys=$this->userAddress->find('all',array('conditions'=>array('id_User'=>$user['User']['id'])));
					for($i=0;$i<count($DataTableCitys);$i++){
						$Region = $this->Region->find('first',array('conditions'=>array('id'=>$DataTableCitys[$i]['userAddress']['id_region'])));
						$Citys = $this->city->find('first',array('conditions'=>array('id'=>$DataTableCitys[$i]['userAddress']['id_City'])));  
						$DataCitys .= '<tr class="'.($i%2===0?'even pointer':'odd pointer').'" data-id="'.$DataTableCitys[$i]['userAddress']['id'].'">';
						$DataCitys .= '<td>'.($i+1).'</td>';
						$DataCitys .= '<td>'.$DataTableCitys[$i]['userAddress']['stress'].'</td>';
						$DataCitys .= '<td>'.(count($Region)>0?$Region['Region']['name']:'Chưa xác định').'</td>';
						$DataCitys .= '<td>'.(count($Citys)>0?$Citys['city']['name']:'Chưa xác định').'</td>';
						$DataCitys .= '<td>'.$DataTableCitys[$i]['userAddress']['note'].'</td>';
						$DataCitys .= '<td><div class="hidden-sm hidden-xs action-buttons"><a class="red" href="javascript:void(0);" data-option="removeAddress" data-id="'.$DataTableCitys[$i]['userAddress']['id'].'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li><a href="javascript:void(0);" data-option="removeAddress" data-id="'.$DataTableCitys[$i]['userAddress']['id'].'" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li></ul></div></div></td>';
						$DataCitys .= '</tr>';
					}
					/** Lấy tất cả số điện thoại **/
					$DataPhone = '';
					$DataFacebook = '';
					$DataGmail = '';
					$DataZalo = '';
					$DataTablePhone=$this->userContacts->find('all',array('conditions'=>array('byUser'=>$user['User']['id'])));
					for($i=0;$i<count($DataTablePhone);$i++){

						$sub = '<tr class="'.($i%2===0?'even pointer':'odd pointer').'" data-id="'.$DataTablePhone[$i]['userContacts']['id'].'">';
						$sub .= '<td>'.($i+1).'</td>';
						$sub .= '<td>'.$DataTablePhone[$i]['userContacts']['Values'].'</td>';
						$sub .= '<td>'.$DataTablePhone[$i]['userContacts']['node'].'</td>';
						$sub .= '<td><a class="red" href="javascript:void(0);" data-option="removecontants" data-id="'.$DataTablePhone[$i]['userContacts']['id'].'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td>';
						$sub .='</tr>';
						if($DataTablePhone[$i]['userContacts']['key']==='PHONE') $DataPhone .= $sub;
						else if($DataTablePhone[$i]['userContacts']['key']==='FACEBOOK') $DataFacebook .= $sub;
						else if($DataTablePhone[$i]['userContacts']['key']==='GMAIL') $DataGmail .= $sub;
						else if($DataTablePhone[$i]['userContacts']['key']==='ZALO') $DataZalo .= $sub;
					}
					/* Save data */
					if(isset($_POST['btnsave'])){
						$err = '';
						if(!isset($this->data['Users']['first_name']) || strlen($this->data['Users']['first_name'])==0) $err = '<li>Bạn cần nhập họ</li>';
						if(!isset($this->data['Users']['first_name']) || strlen($this->data['Users']['first_name'])==0) $err .= '<li>Bạn cần nhập Tên</li>';
						if(!isset($this->data['Users']['birthday']) || strlen($this->data['Users']['birthday'])==0) $err .= '<li>Bạn cần nhập ngày sinh</li>';
						if(!isset($this->data['Users']['username']) || strlen($this->data['Users']['username'])==0) $err .= '<li>Bạn cần nhập tài khoản</li>';
						if(!isset($this->data['Users']['mail']) || strlen($this->data['Users']['mail'])==0) $err .= '<li>Bạn cần nhập địa chỉ mail</li>';
						else if (!filter_var($this->data['Users']['mail'], FILTER_VALIDATE_EMAIL)) $err .= '<li>Bạn cần nhập địa chỉ mail</li>';
						if(!isset($this->data['Users']['password']) || strlen($this->data['Users']['password'])==0) $err .= '<li>Bạn cần nhập mật khẩu</li>';
						if(strlen($err)>0){
							$this->Session->setFlash($err,'flash_Login_bad');
							return;
						} else {
							if(count($this->User->find('first',array('conditions'=>array('username'=>$this->data['Users']['username'],'id <>'=>$user['User']['id']))))>0){
								$this->Session->setFlash('Tài khoản này đã tồn tại','flash_Login_bad');
								return;
							}
							if(count($this->User->find('first',array('conditions'=>array('gmail'=>$this->data['Users']['mail'],'id <>'=>$user['User']['id']))))>0){
								$this->Session->setFlash('Địa chỉ mail này đã tồn tại','flash_Login_bad');
								return;
							}
							if(strcmp($this->data['Users']['password'],$user['User']['password'])!==0){
								if(strcmp($this->data['Users']['password'],$this->data['Users']['repassword'])!==0){
									$this->Session->setFlash('Mật khẩu không trùng khớp','flash_Login_bad');
									return;
								}
							}
							$image = '';
							if(isset($this->data['Users']['image'])){
								$tmp = $lib->uploadFileCakePHP('assets/images',$this->data['Users']['image']);
								if(isset($tmp['urls'][0])){
									$image=str_replace('assets/images/','',$tmp['urls'][0]);
								}
							}
							$this->User->read(null,$user['User']['id']);
							$this->User->set(array(
									'username'=>$this->data['Users']['username'],
									'password'=>md5($this->data['Users']['password']),
									'gmail'=>$this->data['Users']['mail'],
									'gender'=>$this->data['Users']['Gender'],
									'birthday'=>$this->data['Users']['birthday'],
									'first_name'=>$this->data['Users']['first_name'],
									'last_name'=>$this->data['Users']['last_name'],
									'avatar'=>$image
								));
							if($this->User->save()){
								$this->Session->setFlash('cập nhật thành công','flash_Login_bad');
								$user= $this->User->find('first',array('conditions'=>array('id'=>$id)));
							} else $this->Session->setFlash('cập nhật thất bại','flash_Login_bad');

						}
					}
					$avatar = '/assets/images/no-avatar.jpg';
					if(strlen($user['User']['avatar'])>0 && file_exists(WWW_ROOT.'/assets/images/'.$user['User']['avatar'])) 
				        $avatar = '/assets/images/'.$user['User']['avatar'];
					$this->set('DataCitys',$DataCitys);
					$this->set('DataPhone',$DataPhone);
					$this->set('DataFacebook',$DataFacebook);
					$this->set('DataGmail',$DataGmail);
					$this->set('DataZalo',$DataZalo);
					$this->set('first_name',$user['User']['first_name']);
					$this->set('last_name',$user['User']['last_name']);
					$this->set('birthday',$user['User']['birthday']);
					$this->set('username',$user['User']['username']);
					$this->set('gmail',$user['User']['gmail']);
					$this->set('password',$user['User']['password']);
					$this->set('user_id',$user['User']['id']);
					$this->set('avatar',$avatar);
					$this->set('current_User',$this->Session->read($this->sessionUsername));
					return;


				} else $err = '<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu';
			} else $err = '<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu';
		} else $err = '<i class="ace-icon fa fa-chain-broken green" style="margin-right: 5px;"></i>Không tìm thấy dữ liệu';

		$this->Session->setFlash($err,'flash_Login_bad');
		$this->redirect(array('controller'=>'Users','action'=>'index'));
		
	}
}
