<?php 
App::uses('lib', 'Lib');
	class DataController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Size','image','Region','city','userAddress','authoritie','userContacts','productinventory');

		 public $components = array('RequestHandler');

		public function image() {
			if(isset($_POST['page'])){
				$lib = new lib();
				$tmpPage = $_POST['page'];
				$page = $lib->parseint($tmpPage);
				if($page===false) $currentPage = 1;
				else if($page<=0) $currentPage = 1;
				else $currentPage = $page;
				$currentPage--;
				$images = $this->image->query('SELECT * FROM `images` ORDER BY `images`.`CreateDate` DESC LIMIT '.($currentPage*15).',15');
		        $this->set('images', $images);
		        $this->set('_serialize', array('images'));
			}
	    }
	    public function GetRegionByCitys(){
	    	if(isset($_POST['citys'])){
	    		$lib = new lib();
	    		$result = array();
	    		$id = $id = $lib->parseint($_POST['citys']);
	    		if($id!==false && $id>0){
	    			$DataTable = $this->Region->find('all',array('conditions'=>array('id_citys'=>$id)));
	    			for($i=0;$i<count($DataTable);$i++){
	    				array_push($result, array('id'=>$DataTable[$i]['Region']['id'],'name'=>$DataTable[$i]['Region']['name']));
	    			}
	    		}
	    		$this->set('result', $result);
		        $this->set('_serialize', array('result'));
	    	}
	    }
	    public function SetPermission(){
	    	$error = array();
	    	$lib = new lib();
	    	if(!isset($_POST['Permission']) || strlen($_POST['Permission'])===0) array_push($error, 'Bạn cần chọn nhóm phân quyền');
	    	else{
	    		$id = $lib->parseint($_POST['Permission']);
	    		if($id!==false && $id>0){
	    			
	    			$authoritie =$this->authoritie->find('all',array('conditions'=>array('id'=>$_POST['Permission'])));
					if(count($authoritie)<=0) array_push($error, 'Bạn cần chọn nhóm phân quyền');

	    		} else array_push($error, 'Bạn cần chọn nhóm phân quyền');
	    	}
	    	if(!isset($_POST['user']) || strlen($_POST['user'])==0) array_push($error, 'không tìm thấy tài khoản này');
	    	else{
				$id = $lib->parseint($_POST['user']);
				if($id!==false && $id>0){
					$User =$this->User->find('all',array('conditions'=>array('id'=>$id)));
					if(count($User)<=0) array_push($error, 'chúng tôi không tìm thấy tài khoản này');
				}
				else array_push($error, 'chúng tôi không tìm thấy tài khoản này');
	    	}
	    	if(!isset($_POST['byUser']) || strlen($_POST['byUser'])===0) array_push($error, 'Bạn chưa được phân quyền này');
	    	else{
	    		$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$_POST['byUser'].'\' and `roles`.`ActionName`=\'SetPermission\' and `roles`.`ControllerName`=\'Data\'';
				if(count($this->User->query($sql))===0) array_push($error,'Bạn chưa được phân quyền này');
	    	}

	    	if(count($error)===0){
		    	$this->User->read(null,$_POST['user']);
		    	$this->User->set(array(
		    			'Permission'=>$_POST['Permission']
		    		));
		    	if($this->User->save()){
		    		$this->set('success', 'true');
	        		$this->set('_serialize', array('success'));
	        		return;
		    	} else array_push($error,'Lưu trữ thất bại');
		    }
		    $this->set('error', $error);
	        $this->set('_serialize', array('error'));
	    }
	    public function SaveAddress(){
	    	$lib = new lib();
	    	$error = array();
	    	if(!isset($_POST['street']) || strlen($_POST['street'])==0) array_push($error, 'Bạn cần nhập tên đường');
	    	if(!isset($_POST['region']) || strlen($_POST['region'])==0) array_push($error, 'Bạn cần chọn quận/huyện');
	    	else{
				$id = $lib->parseint($_POST['region']);
				if($id!==false && $id>0){
					$region =$this->Region->find('all',array('conditions'=>array('id'=>$_POST['region'])));
					if(count($region)<=0) array_push($error, 'Chọn sai thông tin quận huyện');
				}
				else array_push($error, 'Chọn sai thông tin quận huyện');
	    	}
	    	if(!isset($_POST['citys']) || strlen($_POST['citys'])==0) array_push($error, 'Bạn cần chọn tỉnh/thành phố');
	    	else {
	    		$id = $lib->parseint($_POST['citys']);
				if($id!==false && $id>0){
					$city =$this->city->find('all',array('conditions'=>array('id'=>$_POST['citys'])));
					if(count($city)<=0) array_push($error, 'Chọn sai thông tin tỉnh/thành phố');
				}
				else array_push($error, 'Chọn sai thông tin tỉnh/thành phố');
	    	}
			if(!isset($_POST['user']) || strlen($_POST['user'])==0) array_push($error, 'không tìm thấy tài khoản này');
	    	else{
				$id = $lib->parseint($_POST['user']);
				if($id!==false && $id>0){
					$User =$this->User->find('all',array('conditions'=>array('id'=>$id)));
					if(count($User)<=0) array_push($error, 'chúng tôi không tìm thấy tài khoản này');
				}
				else array_push($error, 'chúng tôi không tìm thấy tài khoản này');
	    	}
	    	if(!isset($_POST['byUser']) || strlen($_POST['byUser'])==0) array_push($error, 'bạn chưa được phân quyền này');
	    	else{
				$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$_POST['byUser'].'\' and `roles`.`ActionName`=\'add\' and `roles`.`ControllerName`=\'Users\'';
				if(count($this->User->query($sql))===0) array_push($error, 'bạn chưa được phân quyền này');
	    	}
	    	if(count($error)===0){
	    		$this->userAddress->create();
				$this->userAddress->set(array(
						'stress'=>$_POST['street'],
						'id_City'=>$_POST['citys'],
						'id_region'=>$_POST['region'],
						'id_User'=>$_POST['user'],
						'note'=>isset($_POST['note'])?$_POST['note']:'',
						'source' => 'Được thêm từ tài khoản '.$_POST['byUser']
					));
				if($this->userAddress->save()){
					$this->set('success', $this->userAddress->id);
	        		$this->set('_serialize', array('success'));
	        		return;
				} else array_push($error, 'Lưu trữ thất bại');
	    	}
	    	$this->set('error', $error);
	        $this->set('_serialize', array('error'));
	    }
	    public function removeAddress(){
	    	$error = '';
	    	if(isset($_POST['id']) && strlen($_POST['id'])>0){
	    		if(!isset($_POST['byUser']) || strlen($_POST['byUser'])==0) $error = 'bạn chưa được phân quyền này';
		    	else{
					$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$_POST['byUser'].'\' and `roles`.`ActionName`=\'add\' and `roles`.`ControllerName`=\'Users\'';
					if(count($this->User->query($sql))===0) $error = 'bạn chưa được phân quyền này';
					else {
						$lib = new lib();
						$id = $lib->parseint($_POST['id']);
						if($id!==false && $id>0){
							if($this->userAddress->delete($id))
							{
								$this->set('success', 'true');
			        			$this->set('_serialize', array('success'));
			        			return;
							}
							else $error='Xóa thất bại';
						} else $error='Xóa thất bại';
					}
		    	}
			} else $error='Xóa thất bại';
			$this->set('error', $error);
	        $this->set('_serialize', array('error'));
	    }
	    public function saveContant(){
	    	$lib = new lib();
	    	$error = array();
	    	if(!isset($_POST['value']) || strlen($_POST['value'])==0) array_push($error, 'Bạn cần nhập giá trị');
	    	if(!isset($_POST['key']) || strlen($_POST['key'])==0) array_push($error, 'Không xác định miền giá trị');
	    	if(!isset($_POST['byUser']) || strlen($_POST['byUser'])==0) array_push($error, 'Bạn chưa được phân quyền chức năng này');
	    	else {
    			$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$_POST['byUser'].'\' and `roles`.`ActionName`=\'add\' and `roles`.`ControllerName`=\'Users\'';
    			if(count($this->User->query($sql))===0) array_push($error, 'Bạn chưa được phân quyền này');
	    	}
	    	if(!isset($_POST['user']) || strlen($_POST['user'])==0) array_push($error, 'không tìm thấy tài khoản này');
	    	else{
				$id = $lib->parseint($_POST['user']);
				if($id!==false && $id>0){
					$User =$this->User->find('all',array('conditions'=>array('id'=>$id)));
					if(count($User)<=0) array_push($error, 'chúng tôi không tìm thấy tài khoản này');
				}
				else array_push($error, 'chúng tôi không tìm thấy tài khoản này');
	    	}
	    	if(count($error)===0){
	    		$this->userContacts->create();
	    		$this->userContacts->set(array(
	    				'name'=>$_POST['key'],
	    				'Values' => $_POST['value'],
	    				'byUser' => $_POST['user'],
	    				'key' => $_POST['key'],
	    				'node' => isset($_POST['node'])?$_POST['node']:''
	    			));
	    		if($this->userContacts->save()){
	    			$this->set('success', $this->userContacts->id);
        			$this->set('_serialize', array('success'));
        			return;
	    		} else array_push($error, 'Lưu trữ thất bại');
	    	}
	    	$this->set('error', $error);
	        $this->set('_serialize', array('error'));
	    }
	    public function removeContant(){

	    	$error = '';
	    	if(isset($_POST['id']) && strlen($_POST['id'])>0){
	    		if(!isset($_POST['byUser']) || strlen($_POST['byUser'])==0) $error = 'bạn chưa được phân quyền này';
		    	else{
					$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$_POST['byUser'].'\' and `roles`.`ActionName`=\'add\' and `roles`.`ControllerName`=\'Users\'';
					if(count($this->User->query($sql))===0) $error = 'bạn chưa được phân quyền này';
					else {
						$lib = new lib();
						$id = $lib->parseint($_POST['id']);
						if($id!==false && $id>0){
							if($this->userContacts->delete($id))
							{
								$this->set('success', 'true');
			        			$this->set('_serialize', array('success'));
			        			return;
							}
							else $error='Xóa thất bại';
						} else $error='Xóa thất bại';
					}
		    	}
			} else $error='Xóa thất bại';
			$this->set('error', $error);
	        $this->set('_serialize', array('error'));
	    }
	    public function lockCategory(){
	    	
	    }
	    public function getInventoriesByIDWarehousing(){
	    	$error = '';
	    	if(isset($_POST['id']) && strlen($_POST['id'])>0){
	    		if(!isset($_POST['byUser']) || strlen($_POST['byUser'])==0) $error = 'bạn chưa được phân quyền này';
		    	else{
					$sql = 'SELECT `users`.* FROM `users`,`authorities`,`permissions` ,`roles` WHERE `users`.`Permission`=`authorities`.`id` and `permissions`.`id_authorities`=`authorities`.`id` and `permissions`.`id_role`=`roles`.`id` and `users`.`username`=\''.$_POST['byUser'].'\' and `roles`.`ActionName`=\'add\' and `roles`.`ControllerName`=\'Users\'';
					if(count($this->User->query($sql))===0) $error = 'bạn chưa được phân quyền này';
					else {
						$lib = new lib();
						$id = $lib->parseint($_POST['id']);
						if($id!==false && $id>0){
							$sql='SELECT (CASE EXISTS(SELECT * FROM `sizes` WHERE `sizes`.`id`=`productinventories`.`id_size`) WHEN 1 THEN (SELECT `sizes`.`name` FROM `sizes` WHERE `sizes`.`id`=`productinventories`.`id_size`) ELSE \'Chưa xác định\' END) as \'Size\',`productinventories`.`number`,(`productinventories`.`number`-`productinventories`.`sold`) as \'inventories\' FROM `productinventories` WHERE `productinventories`.`id_warehousing`='.$id;
							$Tables=$this->productinventory->query($sql);
							$data = array();
							for($i=0;$i<count($Tables);$i++){
								array_push($data, array(
										'name'=>(isset($Tables[$i][0]['Size'])?$Tables[$i][0]['Size']:'Chưa xác định'),
										'number' => $Tables[$i]['productinventories']['number'],
										'inventorie' => $Tables[$i][0]['inventories']
									));
							}
							$this->set('data', $data);
		        			$this->set('_serialize', array('data'));
		        			return;
						}
						else $error='không tìm thấy mã kho này';
					}
				}
	    	} else $error = 'không tìm thấy mã kho này';
	    	$this->set('error', $error);
	        $this->set('_serialize', array('error'));
	    }
	}