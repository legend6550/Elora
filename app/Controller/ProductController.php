<?php
	App::uses('lib', 'Lib');
	App::uses('imageLib', 'Lib');
	App::uses('Folder', 'Utility');
	class ProductController extends AppController {
		var $layout = '_MasterAdministrator';
		var $sessionUsername = 'userLogin';
		public $uses = array('User','Color','Size','authoritie','category','product','productpromotion','productthumbnail','productinformation','productcategory','productwarehousing','productinventory','productwarehousingimage');

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
		function add(){
			ini_set('memory_limit','-1');
			$infomationName = array();
			$infomationDetail = array();
			$shortDescription = '';
			$DescriptionDetail = '';
			$this->set('title','Thêm sản phẩm');
			$this->set('categoryTreeView','['.$this->category->ExportStringTreeView('0').']');
			if(isset($_POST['btnsave'])){
				$lib = new lib();
				$err = '';
				if(!isset( $this->data['product']['name']) || strlen($this->data['product']['name'])==0) $err .='<li>Bạn cần nhập tên sản phẩm</li>';
				if(!isset($this->data['product']['code']) || strlen($this->data['product']['code'])==0) $err .='<li>Bạn cần nhập mã sản phẩm</li>';
				if(!isset($this->data['product']['priceCode']) || strlen($this->data['product']['priceCode'])==0 || $lib->parseint($this->data['product']['priceCode'])===false) $err .='<li>Bạn cần nhập giá gốc của sản phẩm này</li>';
				if(!isset($this->data['product']['priceSelling']) || strlen($this->data['product']['priceSelling'])==0 || $lib->parseint($this->data['product']['priceSelling'])===false) $err .='<li>Bạn cần nhập giá bán thực tế của sản phẩm này</li>';
				if(!isset($this->data['product']['numberVirtual']) || strlen($this->data['product']['numberVirtual'])==0 || $lib->parseint($this->data['product']['numberVirtual'])===false) $err .='<li>Bạn cần nhập số lượng nhập kho ảo</li>';
				if(!isset($this->data['product']['numberSellVirtual']) || strlen($this->data['product']['numberSellVirtual'])==0 || $lib->parseint($this->data['product']['numberSellVirtual'])===false) $err .='<li>Bạn cần nhập số lượng người mua ảo</li>';
				if(!isset($this->data['product']['shortDescription']) || strlen($this->data['product']['shortDescription'])==0) $err .='<li>Bạn cần nhập mô tả ngắn gọn</li>';
				else $shortDescription = $this->data['product']['shortDescription'];
				if(!isset($this->data['product']['DescriptionDetail']) || strlen($this->data['product']['DescriptionDetail'])==0) $err .='<li>Bạn cần nhập mô tả chi tiết</li>';
				else $DescriptionDetail = $this->data['product']['DescriptionDetail'];
				if(isset($this->data['product']['infomationName']) && count($this->data['product']['infomationName'])>0)  $infomationName = $this->data['product']['infomationName'];
				if(isset($this->data['product']['infomationDetail']) && count($this->data['product']['infomationDetail'])>0)  $infomationDetail = $this->data['product']['infomationDetail'];

				if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad'); 
				else {
					/* Tạo slug */
					$slug = '';
					$jump = 0;
					while(strlen($slug)==0){
						$subSlug = $lib->to_slug($this->data['product']['name']);
						$subSlug = ($jump>0)?$subSlug.$jump:$subSlug;
						if($this->product->find('count',array('conditions'=>array('slug'=>$subSlug)))>0) $jump++;
						else $slug = $subSlug;
					}
					/* Upload hình ảnh lớn */
					$thumbnailLarge = '';
					if(isset($this->data['product']['slideImage'])){
						$tmp = $lib->uploadFileCakePHP('assets/images/'.$slug,$this->data['product']['slideImage']);
						if(isset($tmp['urls'][0])){
							$thumbnailLarge = str_replace('assets/images/','',$tmp['urls'][0]);
						}
					}
					$thumbnailStandard = '';
					if(isset($this->data['product']['thumbnail'])){
						$tmp = $lib->uploadFileCakePHP('assets/images/'.$slug,$this->data['product']['thumbnail']);
						if(isset($tmp['urls'][0])){
							$thumbnailStandard = str_replace('assets/images/','',$tmp['urls'][0]);
						}
					}
					$format = explode('.',$thumbnailStandard);
					$imageSmall = new imageLib();
					$imageSmall->load(WWW_ROOT.'/assets/images/'.$thumbnailStandard);
					$imageSmall->resize(250,244);
					$imageSmall->save(WWW_ROOT.'/assets/images/'.$slug.'/'.$slug.'250x244'.'.'.(isset($format[1])?$format[1]:'jpg'));
					$imageMiss = new imageLib();
					$imageMiss->load(WWW_ROOT.'/assets/images/'.$thumbnailStandard);
					$imageSmall->resize(98,96);
					$imageSmall->save(WWW_ROOT.'/assets/images/'.$slug.'/'.$slug.'98x96'.'.'.(isset($format[1])?$format[1]:'jpg'));
					$currentUser = $this->User->GetCurrentUser($this->Session->read($this->sessionUsername));
					if(count($currentUser)>0)
					{
						$this->product->create();
						$this->product->set(array(
								'byUser' => $currentUser['User']['id'],
								'createDate' => date('Y-m-d H:i:s'),
								'Description' => $this->data['product']['DescriptionDetail'],
								'idProduct' => $this->data['product']['code'],
								'nameProduct' => $this->data['product']['name'],
								'numberSellVirtual' => $this->data['product']['numberSellVirtual'],
								'numberVirtual' => $this->data['product']['numberVirtual'],
								'priceCode' => $this->data['product']['priceCode'],
								'priceSell' => $this->data['product']['priceSelling'],
								'productHot' => $this->data['product']['productHot'],
								'productSelling' => $this->data['product']['productSelling'],
								'productSlide' => $this->data['product']['Showslide'],
								'seoDescription' => $this->data['product']['seoDescription'],
								'seoKeyword' => $this->data['product']['seoKeyword'],
								'seoTitle' => $this->data['product']['seoTitle'],
								'shortDescription' => $this->data['product']['shortDescription'],
								'slug' => $slug,
								'thumbnailLarge' => $thumbnailLarge,
								'thumbnailMiss' => $slug.'/'.$slug.'98x96'.'.'.(isset($format[1])?$format[1]:'jpg'),
								'thumbnailSmall' => $slug.'/'.$slug.'250x244'.'.'.(isset($format[1])?$format[1]:'jpg'),
								'thumbnailStandard' => $thumbnailStandard,
								'TimerOff' => $lib->ParseDatetime($this->data['product']['dateShow']),
								'TimerOn' => $lib->ParseDatetime($this->data['product']['dateHidden']),
								'views' => 0
							));
						if($this->product->save()){
							if(strlen($this->data['product']['priceSale'])>0 && strlen($this->data['product']['deadlineSale'])>0)
							{
								$this->productpromotion->create();
								$this->productpromotion->set(array(
										'id_product' => $this->product->id,
										'price' => $this->data['product']['priceSale'],
										'formdate' => $lib->ParseDatetime($this->data['product']['deadlineSale']),
										'todate' => date('Y-m-d H:i:s'),
										'byUser' => $currentUser['User']['id'],
										'createDate' => date('Y-m-d H:i:s')
									));
								$this->productpromotion->save();
							}
							for($i=0;$i<count($this->data['product']['thumbnailSlide']);$i++){
								$thumbnailSlide = '';
								if(isset($this->data['product']['thumbnailSlide'][$i])){
									$tmp = $lib->uploadFileCakePHP('assets/images/'.$slug.'/slide/',$this->data['product']['thumbnailSlide'][$i]);
									if(isset($tmp['urls'][0])){
										$thumbnailSlide = str_replace('assets/images/','',$tmp['urls'][0]);
									}
								}
								$format = explode('.',$thumbnailSlide);
								$imageMiss = new imageLib();
								$imageMiss->load(WWW_ROOT.'/assets/images/'.$thumbnailSlide);
								$imageSmall->resize(80,78);
								$imageSmall->save(WWW_ROOT.'/assets/images/'.$slug.'/slide/'.$slug.'80x78'.'.'.(isset($format[1])?$format[1]:'jpg'));
								$this->productthumbnail->create();
								$this->productthumbnail->set(array(
										'imageLarge' => $thumbnailSlide,
										'thumbnailMiss' => $slug.'/slide/'.$slug.'80x78'.'.'.(isset($format[1])?$format[1]:'jpg'),
										'id_Product' => $this->product->id
									));
								$this->productthumbnail->save();
							}
							if(isset($this->data['product']['category']))
							{
								for($i=0;$i<count($this->data['product']['category']);$i++){
									$this->productcategory->create();
									$this->productcategory->set(array(
											'id_category' => $this->data['product']['category'][$i],
											'id_Product' => $this->product->id
										));
									$this->productcategory->save();
								}
							}
							if(isset($this->data['product']['infomationName']))
							{
								for($i=0;$i<count($this->data['product']['infomationName']);$i++){
									if(isset($this->data['product']['infomationDetail'])){
										$this->productinformation->create();
										$this->productinformation->set(array(
												'name' => $this->data['product']['infomationName'][$i],
												'detail' => $this->data['product']['infomationDetail'][$i],
												'createDate' => date('Y-m-d H:i:s'),
												'byUser' => $currentUser['User']['id'],
												'id_product' => $this->product->id
											));
										$this->productinformation->save();
									}
								}
							}
						}
					}
					
				}
			}
			$this->set('shortDescription',$shortDescription);
			$this->set('DescriptionDetail',$DescriptionDetail);
			$this->set('infomationName',$infomationName);
			$this->set('infomationDetail',$infomationDetail);
		}
		function index(){
			$this->set('title','Danh sách sản phẩm');
			$lib = new lib();
			$currentPage = 0;
			$pageRegion = 20;
			if(isset($_GET['page'])){
				$page = $lib->parseint($_GET['page']);
				if($page!==false && $page<1) $currentPage = $page;
			}
			$sql = 'SELECT `products`.`id`,`products`.`thumbnailMiss`,`products`.`idProduct`,`products`.`nameProduct`,`products`.`priceCode`, (CASE EXISTS(SELECT `productpromotions`.`price` FROM `productpromotions` WHERE `productpromotions`.`formdate`>=NOW() and `todate`<=NOW() and `productpromotions`.`id_product`=`products`.`id`) WHEN 1 THEN (SELECT `productpromotions`.`price` FROM `productpromotions` WHERE `productpromotions`.`formdate`>=NOW() and `todate`<=NOW() and `productpromotions`.`id_product`=`products`.`id` ORDER BY `productpromotions`.`id` DESC LIMIT 1) ELSE `products`.`priceSell` END) as \'priceSell\',`numberVirtual`,`numberSellVirtual`,`productHot`,`productSelling`,`productSlide`,`views`,`products`.`createDate`,(CASE EXISTS(SELECT * FROM `users` WHERE `users`.`id`=`products`.`byUser`) WHEN 1 THEN (SELECT CONCAT(`users`.`first_name`,\' \',`users`.`last_name`) FROM `users` WHERE `users`.`id`=`products`.`byUser`) ELSE \'Chưa xác định\' END) as \'fullname\' FROM `products` WHERE 1 limit '.($pageRegion*$currentPage).','.$pageRegion;
			$this->set('tables',$this->product->query($sql));
		}
		function promotion($slug = null){
			$this->set('title','Quản lý khuyến mãi');
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					$product = $this->product->find('first',array('conditions'=>array('id'=>$id )));
					if(count($product)>0)
					{
						$this->set('slugID',$id);
						if(isset($_GET['delete'])){
							if(strlen($_GET['delete'])>0){
								$delete = $lib->parseint($_GET['delete']);
								if($delete!==false && $delete>0){
									if($this->productpromotion->delete($delete)) $this->Session->setFlash('Xóa thành công','flash_Login_bad');
									else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
								} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
							} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
							$this->redirect(array('controller'=>'Product','action' => 'promotion','slug'=>$id));
						} elseif (isset($_GET['id'])) {
							if(strlen($_GET['id'])>0){
								$idSlug = $lib->parseint($_GET['id']);
								if($idSlug!==false && $idSlug>0){
									$promotion = $this->productpromotion->find('first',array('conditions'=>array('id'=>$_GET['id'])));
									if(count($promotion)>0){
										if(isset($_POST['btnsave'])){
											$err = '';
											if(!isset($this->data['Product']['price']) || strlen($this->data['Product']['price'])==0) $err .= '<li>Bạn cần nhập giá tiền</li>';
											if(!isset($this->data['Product']['todate']) || strlen($this->data['Product']['todate'])==0) $err .= '<li>Bạn cần nhập ngày bắt đầu</li>';
											if(!isset($this->data['Product']['fromdate']) || strlen($this->data['Product']['fromdate'])==0) $err .= '<li>Bạn cần nhập ngày kết thúc</li>';
											if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
											else{
												$this->productpromotion->read(null,$idSlug);
												$this->productpromotion->set(array(
														'price' => $this->data['Product']['price'],
														'formdate' => $lib->ParseDatetime($this->data['Product']['fromdate']),
														'todate' => $lib->ParseDatetime($this->data['Product']['todate']),
													));
												if($this->productpromotion->save())
												{
													$this->Session->setFlash('Cập nhật dữ liệu thành công','flash_Login_bad');
													$this->redirect(array('controller'=>'Product','action' => 'promotion', 'slug'=>$id));
												}
												else $this->Session->setFlash('Cập nhật dữ liệu thất bại','flash_Login_bad');
											}
										}
										$this->set('price',$promotion['productpromotion']['price']);
										$this->set('todate',$lib->ParseDatetimePicker($promotion['productpromotion']['todate']));
										$this->set('formdate',$lib->ParseDatetimePicker($promotion['productpromotion']['formdate']));
									} else {
										$this->Session->setFlash('Không tìm thấy dữ liệu vừa chọn','flash_Login_bad');
										$this->redirect(array('controller'=>'Product','action' => 'promotion','slug'=>$id));
									} 
								} else {
										$this->Session->setFlash('Không tìm thấy dữ liệu vừa chọn','flash_Login_bad');
										$this->redirect(array('controller'=>'Product','action' => 'promotion','slug'=>$id));
									} 
							} else {
									$this->Session->setFlash('Không tìm thấy dữ liệu vừa chọn','flash_Login_bad');
									$this->redirect(array('controller'=>'Product','action' => 'promotion','slug'=>$id));
								} 
						} elseif(isset($_POST['btnsave'])){
							$err = '';
							if(!isset($this->data['Product']['price']) || strlen($this->data['Product']['price'])==0) $err .= '<li>Bạn cần nhập giá tiền</li>';
							if(!isset($this->data['Product']['todate']) || strlen($this->data['Product']['todate'])==0) $err .= '<li>Bạn cần nhập ngày bắt đầu</li>';
							if(!isset($this->data['Product']['fromdate']) || strlen($this->data['Product']['fromdate'])==0) $err .= '<li>Bạn cần nhập ngày kết thúc</li>';
							if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
							else{
								$currentUser = $this->User->GetCurrentUser($this->Session->read($this->sessionUsername));
								if(count($currentUser)>0)
								{
									$this->productpromotion->create();
									$this->productpromotion->set(array(
											'id_product' => $id,
											'price' => $this->data['Product']['price'],
											'formdate' => $lib->ParseDatetime($this->data['Product']['fromdate']),
											'todate' => $lib->ParseDatetime($this->data['Product']['todate']),
											'byUser' => $currentUser['User']['id'],
											'createDate' => date('Y-m-d H:i:s')
										));
									if($this->productpromotion->save())
									{
										$this->Session->setFlash('Lưu dữ liệu thành công','flash_Login_bad');
										$this->redirect(array('controller'=>'Product','action' => 'promotion', 'slug'=>$id));
									}
									else $this->Session->setFlash('Lưu dữ liệu thất bại','flash_Login_bad');
								}
							}
						}
						$sql = 'SELECT `productpromotions`.`id`,`productpromotions`.`price`,`productpromotions`.`todate`,`productpromotions`.`formdate`,(CASE EXISTS(SELECT * FROM `users` WHERE `users`.`id`=`productpromotions`.`byUser`) WHEN 1 THEN (SELECT CONCAT(`users`.`first_name`,\' \',`users`.`last_name`) FROM `users` WHERE `users`.`id`=`productpromotions`.`byUser`) ELSE \'Chưa xác định\' END) as \'fullname\',(CASE NOW() BETWEEN `productpromotions`.`todate` AND `productpromotions`.`formdate` WHEN 1 THEN \'Đang Diễn ra\' ELSE IF(`productpromotions`.`todate`>NOW(),\'Chưa diễn ra\',\'Đã diễn ra\') END) as \'status\' FROM `productpromotions` WHERE `productpromotions`.`id_product`='.$id;
						$this->set('Tables',$this->productpromotion->query($sql));
						return;
					} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'Product','action'=>'index'));
		}
		function infomation($slug = null){
			$this->set('title','Quản lý khuyến mãi');
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					$product = $this->product->find('first',array('conditions'=>array('id'=>$id )));
					if(count($product)>0)
					{
						$this->set('slugID',$id);
						if(isset($_GET['delete'])){
							if(strlen($_GET['delete'])>0){
								$delete = $lib->parseint($_GET['delete']);
								if($delete!==false && $delete>0){
									if($this->productinformation->delete($delete)) $this->Session->setFlash('Xóa thành công','flash_Login_bad');
									else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
								} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
							} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
							$this->redirect(array('controller'=>'Product','action' => 'infomation','slug'=>$id));
						} elseif (isset($_GET['id'])) {
							if(strlen($_GET['id'])>0){
								$idSlug = $lib->parseint($_GET['id']);
								if($idSlug!==false && $idSlug>0){
									$promotion = $this->productinformation->find('first',array('conditions'=>array('id'=>$_GET['id'])));
									if(count($promotion)>0){
										if(isset($_POST['btnsave'])){
											$err = '';
											if(!isset($this->data['Product']['name']) || strlen($this->data['Product']['name'])==0) $err .= '<li>Bạn cần nhập tên thông tin</li>';
											if(!isset($this->data['Product']['detail']) || strlen($this->data['Product']['detail'])==0) $err .= '<li>Bạn cần nhập ngày bắt đầu</li>';
											if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
											else{
												$this->productinformation->read(null,$idSlug);
												$this->productinformation->set(array(
													'name' => $this->data['Product']['name'],
													'detail' => $this->data['Product']['detail']
												));
												if($this->productinformation->save())
												{
													$this->Session->setFlash('Cập nhật dữ liệu thành công','flash_Login_bad');
													$this->redirect(array('controller'=>'Product','action' => 'infomation', 'slug'=>$id));
												}
												else $this->Session->setFlash('Cập nhật dữ liệu thất bại','flash_Login_bad');
											}
										}
										$this->set('name',$promotion['productinformation']['name']);
										$this->set('detail',$promotion['productinformation']['detail']);
									} else {
										$this->Session->setFlash('Không tìm thấy dữ liệu vừa chọn','flash_Login_bad');
										$this->redirect(array('controller'=>'Product','action' => 'promotion','slug'=>$id));
									} 
								} else {
										$this->Session->setFlash('Không tìm thấy dữ liệu vừa chọn','flash_Login_bad');
										$this->redirect(array('controller'=>'Product','action' => 'promotion','slug'=>$id));
									} 
							} else {
									$this->Session->setFlash('Không tìm thấy dữ liệu vừa chọn','flash_Login_bad');
									$this->redirect(array('controller'=>'Product','action' => 'promotion','slug'=>$id));
								}




						} elseif(isset($_POST['btnsave'])){
							$err = '';
							if(!isset($this->data['Product']['name']) || strlen($this->data['Product']['name'])==0) $err .= '<li>Bạn cần nhập tên thông tin</li>';
							if(!isset($this->data['Product']['detail']) || strlen($this->data['Product']['detail'])==0) $err .= '<li>Bạn cần nhập ngày bắt đầu</li>';
							if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
							else{
								$currentUser = $this->User->GetCurrentUser($this->Session->read($this->sessionUsername));
								if(count($currentUser)>0)
								{
									$this->productinformation->create();
									$this->productinformation->set(array(
											'name' => $this->data['Product']['name'],
											'detail' => $this->data['Product']['detail'],
											'createDate' => date('Y-m-d H:i:s'),
											'byUser' => $currentUser['User']['id'],
											'id_product' => $slug
										));
									if($this->productinformation->save()){
										$this->Session->setFlash('Lưu dữ liệu thành công','flash_Login_bad');
										$this->redirect(array('controller'=>'Product','action' => 'infomation', 'slug'=>$id));
									}
									else $this->Session->setFlash('Lưu dữ liệu thất bại','flash_Login_bad');
								}
							}
						}
						$sql = 'SELECT *,(CASE EXISTS(SELECT * FROM `users` WHERE `users`.`id`=`productinformations`.`byUser`) WHEN 1 THEN (SELECT CONCAT(`users`.`first_name`,\' \',`users`.`last_name`) FROM `users` WHERE `users`.`id`=`productinformations`.`byUser`) ELSE \'Chưa xác định\' END) as \'fullname\' FROM `productinformations` WHERE 1'.$id;
						$this->set('Tables',$this->productinformation->query($sql));
						return;
					} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'Product','action'=>'index'));
		}
		function warehousing($slug = null){
			$this->set('title','Quản lý kho hàng');
			if(isset($slug) && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					$product = $this->product->find('first',array('conditions'=>array('id'=>$id )));
					if(count($product)>0)
					{
						$DataTable_Color = $this->Color->find('all');
						$DataColor = array();
						for($i=0;$i<count($DataTable_Color);$i++){
							$DataColor[$DataTable_Color[$i]['Color']['id']] = $DataTable_Color[$i]['Color']['name'];
						}
						$this->set('DataColor', $DataColor);
						$DataTable_Size = $this->Size->find('all');
						$DataSize = array();
						for($i=0;$i<count($DataTable_Size);$i++){
							$DataSize[$DataTable_Size[$i]['Size']['id']] = $DataTable_Size[$i]['Size']['name'];
						}
						$this->set('DataSize', $DataSize);
						$this->set('nameProduct',$product['product']['nameProduct']);
						if(isset($_GET['delete'])){
							if(isset($_GET['delete'])){
								if(strlen($_GET['delete'])>0){
									$delete = $lib->parseint($_GET['delete']);
									if($delete!==false && $delete>0){
										if($this->productwarehousing->delete($delete))
										{
											$folder = new Folder(WWW_ROOT.'/assets/images/'.$product['product']['slug'].'/color_'.$delete);
											$folder->delete();
											$this->productwarehousingimage->deleteAll(array('id_warehousing' => $delete), false);
											$this->productinventory->deleteAll(array('id_warehousing' => $delete), false);
											$this->Session->setFlash('Xóa thành công','flash_Login_bad');
										} 
										else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
									} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
								} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
							}
							$this->redirect(array('controller'=>'Product','action' => 'warehousing','slug'=>$slug));
						}
						if(isset($_POST['btnsave'])){
							$err='';
							if(!isset($this->data['Product']['color']) || strlen($this->data['Product']['color'])==0)$err .= '<li>Bạn cần chọn màu sắc</li>';
							else{
								$Color = $this->Color->find('first',array('conditions'=>array('id'=>$this->data['Product']['color'])));
								if(count($Color)==0) $err .= '<li>Bạn cần chọn màu sắc</li>';
							}
							if(!isset($this->data['Product']['size']) || count($this->data['Product']['size'])==0) $err .= '<li>Bạn chưa nhập kích thước</li>';
							if(strlen($err)>0) $this->Session->setFlash($err ,'flash_Login_bad');
							else{
								$currentUser = $this->User->GetCurrentUser($this->Session->read($this->sessionUsername));
								if(count($currentUser)>0)
								{
									$this->productwarehousing->create();
									$this->productwarehousing->set(array(
											'id_color'=>$this->data['Product']['color'],
											'id_Product'=>$id,
											'createDate' => date('Y-m-d H:i:s'),
											'byUser' => $currentUser['User']['id']
										));
									if($this->productwarehousing->save()){
										for($i=0;$i<count($this->data['Product']['size']);$i++){
											$size = $this->Size->find('first',array('conditions'=>array('id'=>$this->data['Product']['size'][$i])));
											if(count($size)>0){
												$number = $lib->parseint(isset($this->data['Product']['number'][$i])?$this->data['Product']['number'][$i]:0);
												if($number!== false && $number>0){
													$Tableinventory = $this->productinventory;
													$number = $this->data['Product']['number'][$i];
													$inventory = $this->productinventory->find('first',array('conditions',array('id_warehousing'=>$this->productwarehousing->id,'id_size'=>$this->data['Product']['size'][$i])));
													if(count($inventory)>0)
													{
														$Tableinventory->read(null,$inventory['productinventory']['id']);
														$number += $inventory['productinventory']['number'];
													} else {
														$Tableinventory->create();
													}
													$Tableinventory->set(array(
															'id_warehousing'=>$this->productwarehousing->id,
															'id_size'=>$this->data['Product']['size'][$i],
															'number'=> $number,
															'sold'=>0,
															'createDate'=>date('Y-m-d H:i:s'),
															'byUser' => $currentUser['User']['id']
														));
													$Tableinventory->save();
												}
											}
										}
										for($i=0;$i<count($this->data['Product']['image']);$i++){
											$thumbnail = '';
											if(isset($this->data['Product']['image'][$i])){
												$tmp = $lib->uploadFileCakePHP('assets/images/'.$product['product']['slug'].'/color_'.$this->productwarehousing->id,$this->data['Product']['image'][$i]);
												if(isset($tmp['urls'][0])){
													$thumbnail = str_replace('assets/images/','',$tmp['urls'][0]);
												}
											}
											if(strlen($thumbnail)>0){
												$this->productwarehousingimage->create();
												$this->productwarehousingimage->set(array(
														'id_warehousing' => $this->productwarehousing->id,
														'image' => $thumbnail,
														'creatDate' =>date('Y-m-d H:i:s'),
														'byUser' => $currentUser['User']['id']
													));
												$this->productwarehousingimage->save();
											}
										}
										$this->Session->setFlash('Nhập kho thành công','flash_Login_bad');
									}
								}
							}
						}
						$sql = 'SELECT `productwarehousings`.`id`,(CASE EXISTS(SELECT * FROM `colors` WHERE `colors`.`id`=`productwarehousings`.`id_color`) WHEN 1 THEN (SELECT `colors`.`name` FROM `colors` WHERE `colors`.`id`=`productwarehousings`.`id_color`) ELSE \'Chưa xác định\' END) as \'color\',(CASE EXISTS(SELECT * FROM `productinventories` WHERE `productinventories`.`id_warehousing`=`productwarehousings`.`id`) WHEN 1 THEN (SELECT (SUM(`productinventories`.`number`)-SUM(`productinventories`.`sold`)) FROM `productinventories` WHERE `productinventories`.`id_warehousing`=`productwarehousings`.`id` GROUP BY `productinventories`.`id_warehousing`) ELSE \'0\' END) as \'inventory\',`productwarehousings`.`createDate`, (CASE EXISTS(SELECT * FROM `users` WHERE `users`.`id`=`productwarehousings`.`byUser`) WHEN 1 THEN (SELECT CONCAT(`users`.`first_name`,\' \',`users`.`last_name`) FROM `users` WHERE `users`.`id`=`productwarehousings`.`byUser`) ELSE \'Chưa xác định\' END) as \'fullname\' FROM `productwarehousings` WHERE `productwarehousings`.`id_Product`='.$slug;
						$this->set('Tables',$this->productwarehousing->query($sql));
						$this->set('slug',$slug);
						return;
					} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'Product','action'=>'index'));
		}
		function editwarehousing($slug=null,$idwarehousing=null){
			$this->set('title','Quản lý kho hàng');
			if(isset($slug) && $slug!=null && strlen($slug)>0){
				$lib = new lib();
				$id = $lib->parseint($slug);
				if($id!==false && $id>0){
					$product = $this->product->find('first',array('conditions'=>array('id'=>$id )));
					if(count($product)>0) {
						if(isset($idwarehousing) && $idwarehousing!=null && strlen($idwarehousing)>0){
							$idWarehousing = $lib->parseint($idwarehousing);
							if($idWarehousing!==false && $idWarehousing>0){
								$Warehousing = $this->productwarehousing->find('first',array('conditions'=>array('id'=>$idWarehousing)));
								if(count($Warehousing)>0){
									if(isset($_GET['id'])){

										if(strlen($_GET['id'])>0){
											$idInventorie = $lib->parseint($_GET['id']);
											if($idInventorie!==false && $idInventorie>0){
												$DataWarehousing = $this->productinventory->find('first',array('conditions'=>array('id'=>$idInventorie)));
												if(count($DataWarehousing)>0){
													if(isset($_POST['btnsave'])){
														$number = 0;
														$err = '';
														if(!isset($this->data['Product']['Size']) || strlen($this->data['Product']['Size'])==0) $err.='<li>Bạn cần chọn kích thước</li>';
														if(!isset($this->data['Product']['number']) || strlen($this->data['Product']['number'])==0) $err.='<li>Bạn cần chọn kích thước</li>';
														else
														{
															$number = $lib->parseint($this->data['Product']['number']);
															if($number===false || $number===0) $err.='<li>Bạn cần chọn kích thước</li>';
														}
														if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
														else{
															$size = $this->Size->find('first',array('conditions'=>array('id'=>$this->data['Product']['Size'])));
															if(count($size)>0){
																$number = $lib->parseint(isset($this->data['Product']['number'])?$this->data['Product']['number']:0);
																if($number!== false && $number>0){
																	$number = $this->data['Product']['number'];
																	$this->productinventory->read(null,$_GET['id']);
																	$this->productinventory->set(array('number'=> $number));
																	if($this->productinventory->save())
																	{
																		$this->Session->setFlash('Cập nhật thành công','flash_Login_bad');
																		$this->redirect(array('controller'=>'Product','action'=>'editwarehousing','slug'=>$slug,'idwarehousing'=>$idwarehousing));
																	}
																	else $this->Session->setFlash('Lưu thất bại','flash_Login_bad');
																}
															}
														}
													}
													$this->set('Size',$DataWarehousing['productinventory']['id_size']);
													$this->set('number',$DataWarehousing['productinventory']['number']);
												} else {
													$this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
													$this->redirect(array('controller'=>'Product','action'=>'editwarehousing','slug'=>$slug,'idwarehousing'=>$idwarehousing));
												}
											} else {
												$this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
												$this->redirect(array('controller'=>'Product','action'=>'editwarehousing','slug'=>$slug,'idwarehousing'=>$idwarehousing));
											}
										} else {
												$this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
												$this->redirect(array('controller'=>'Product','action'=>'editwarehousing','slug'=>$slug,'idwarehousing'=>$idwarehousing));
											}
										
									} elseif(isset($_GET['delete'])){
										if(strlen($_GET['delete'])>0){
											$delete = $lib->parseint($_GET['delete']);
											if($delete!==false && $delete>0){
												if($this->productinventory->delete($delete)) $this->Session->setFlash('Xóa thành công','flash_Login_bad');
												else $this->Session->setFlash('Xóa thất bại','flash_Login_bad');
											} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
										} else $this->Session->setFlash('Không thể xóa dữ liệu vừa chọn','flash_Login_bad');
										$this->redirect(array('controller'=>'Product','action'=>'editwarehousing','slug'=>$slug,'idwarehousing'=>$idwarehousing));
									} elseif(isset($_POST['btnsave'])){
										$number = 0;
										$err = '';
										if(!isset($this->data['Product']['Size']) || strlen($this->data['Product']['Size'])==0) $err.='<li>Bạn cần chọn kích thước</li>';
										if(!isset($this->data['Product']['number']) || strlen($this->data['Product']['number'])==0) $err.='<li>Bạn cần chọn kích thước</li>';
										else
										{
											$number = $lib->parseint($this->data['Product']['number']);
											if($number===false || $number===0) $err.='<li>Bạn cần chọn kích thước</li>';
										}
										if(strlen($err)>0) $this->Session->setFlash($err,'flash_Login_bad');
										else{
											$size = $this->Size->find('first',array('conditions'=>array('id'=>$this->data['Product']['Size'])));
											if(count($size)>0){
												$number = $lib->parseint(isset($this->data['Product']['number'])?$this->data['Product']['number']:0);
												if($number!== false && $number>0){
													$number = $this->data['Product']['number'];
													$inventory = $this->productinventory->find('first',array(
																'conditions'=>array(
																	'id_warehousing'=>$idwarehousing,
																	'id_size'=>$size['Size']['id']
																)));
													if(count($inventory)>0)
													{
														$this->productinventory->read(null,$inventory['productinventory']['id']);
														$this->productinventory->set(array('number'=> $number + $inventory['productinventory']['number']));
														
													} else {
														$currentUser = $this->User->GetCurrentUser($this->Session->read($this->sessionUsername));
														if(count($currentUser)>0){
															$this->productinventory->create();
															$this->productinventory->set(array(
																'id_warehousing'=>$idwarehousing,
																'id_size'=>$size['Size']['id'],
																'number'=> $number,
																'sold'=>0,
																'createDate'=>date('Y-m-d H:i:s'),
																'byUser' => $currentUser['User']['id']
															));
														}
													}
													if($this->productinventory->save()) $this->Session->setFlash('Lưu thành công','flash_Login_bad');
													else $this->Session->setFlash('Lưu thất bại','flash_Login_bad');
												}
											}
										}
									}
									$DataTable_Size = $this->Size->find('all');
									$DataSize = array();
									for($i=0;$i<count($DataTable_Size);$i++){
										$DataSize[$DataTable_Size[$i]['Size']['id']] = $DataTable_Size[$i]['Size']['name'];
									}
									$this->set('DataSize', $DataSize);
									$sql='SELECT `productinventories`.`id`,`productinventories`.`number`,(CASE EXISTS(SELECT * FROM `sizes` WHERE `sizes`.`id`=`productinventories`.`id_size`) WHEN 1 THEN (SELECT `sizes`.`name` FROM `sizes` WHERE `sizes`.`id`=`productinventories`.`id_size`) ELSE \'Chưa xác định\' END) as \'Size\',`productinventories`.`number`,(`productinventories`.`number`-`productinventories`.`sold`) as \'inventories\',`productinventories`.`createDate`,(CASE EXISTS(SELECT * FROM `users` WHERE `users`.`id`=`productinventories`.`byUser`) WHEN 1 THEN (SELECT CONCAT(`users`.`first_name`,\' \',`users`.`last_name`) FROM `users` WHERE `users`.`id`=`productinventories`.`byUser`) ELSE \'Chưa xác định\' END) as \'fullname\' FROM `productinventories` WHERE `productinventories`.`id_warehousing`='.$idWarehousing;
									$this->set('images',$this->productwarehousingimage->find('all',array('conditions'=>array('id_warehousing'=>$idwarehousing))));
									$this->set('Tables',$this->productinventory->query($sql));
									$this->set('nameProduct',$product['product']['nameProduct']);
									$this->set('slug',$slug);
									$this->set('idwarehousing',$idwarehousing);
									return;

								} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
							} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
						} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
						$this->redirect(array('controller'=>'Product','action'=>'warehousing','slug'=>$slug));
						return;
					} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
				} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			} else $this->Session->setFlash('Không tìm thấy dữ liệu cần tìm','flash_Login_bad');
			$this->redirect(array('controller'=>'Product','action'=>'index'));
		}
	}