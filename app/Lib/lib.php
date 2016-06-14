<?php
	App::uses('Model', 'User');
	class lib{
		function uploadFiles($nameFile) {
			if($_FILES[$nameFile]['name'] != NULL){
		        if($_FILES[$nameFile]['type'] == "image/jpeg" || $_FILES[$nameFile]['type'] == "image/png" || $_FILES[$nameFile]['type'] == "image/gif"){ 
		            if($_FILES[$nameFile]['size'] > 1048576){
		                echo "File không được lớn hơn 1mb";
		            }else{
		                $path = WWW_ROOT.'/assets/images/';
		                $tmp_name = $_FILES[$nameFile]['tmp_name'];
		                $name = basename($_FILES[$nameFile]['name'],'.'.pathinfo($_FILES[$nameFile]['name'], PATHINFO_EXTENSION));
		                $tmp = $name;
		                $index = 0;
		                while(1){
		                	if(file_exists($path.$tmp.'.'.pathinfo($_FILES[$nameFile]['name'], PATHINFO_EXTENSION)))
		                	{
		                		$tmp=$name.$index;
		                		$index += 1;
		                	}
		                	else
	                		{
	                			$name = $tmp;
	                			break;
	                		}
		                }
		                move_uploaded_file($tmp_name,$path.$name.'.'.pathinfo($_FILES[$nameFile]['name'], PATHINFO_EXTENSION));
		                return $name.'.'.pathinfo($_FILES[$nameFile]['name'], PATHINFO_EXTENSION);
		           }
		        }else 
		        	return '';
		   }else return '';
		}
		function uploadFileCakePHP($folder, $file){
			$folder_url = WWW_ROOT.$folder;
			$rel_url = $folder;
			if(!is_dir($folder_url)) {
				mkdir($folder_url);
			}
			$permitted = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-icon');
			$filename = $this->to_slug($file['name']);
			$format = '';
			$typeOK = false;
			foreach($permitted as $type) {
				if($type == $file['type']) {
					$typeOK = true;
					switch ($type) {
						case 'image/gif':
							$format = '.gif';
							break;
						case 'image/jpeg':
							$format = '.jpg';
							break;
						case 'image/pjpeg':
							$format = '.jpg';
							break;
						case 'image/png':
							$format = '.png';
							break;
						case 'image/x-icon':
							$format = '.ico';
							break;
					}
					break;
				}
			}
			if($typeOK) {
				switch($file['error']) {
					case 0:
						if(!file_exists($folder_url.'/'.$filename)) {
							$full_url = $folder_url.'/'.$filename;
							$url = $rel_url.'/'.$filename.$format;
							$success = move_uploaded_file($file['tmp_name'], $url);
						} else {
							ini_set('date.timezone', 'Europe/London');
							$now = date('Y-m-d-His');
							$full_url = $folder_url.'/'.$now.$filename;
							$url = $rel_url.'/'.$now.$filename.$format;
							$success = move_uploaded_file($file['tmp_name'], $url);
						}
						if($success) {
							$result['urls'][] = $url;
						} else {
							$result['errors'][] = "Error uploaded $filename. Please try again.";
						}
						break;
					case 3:
						$result['errors'][] = "Error uploading $filename. Please try again.";
						break;
					default:
						$result['errors'][] = "System error uploading $filename. Contact webmaster.";
						break;
				}
			} elseif($file['error'] == 4) {
				$result['nofiles'][] = "No file Selected";
			} else {
				$result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
			}
			return $result;
		}
		function parseint($val) {
			$int_value = ctype_digit($val) ? intval($val) : null;
			if ($int_value === null)
			{
			    return false;
			}
			return $int_value;
		}
		function totalpage($val){
			$tmp=(int)$val;
			if($tmp<$val) return $tmp+1;
			else return $tmp;
		}
		function ExportHtmlTreeView($Tables){
			$html = '';
			for($i=0;$i<count($Tables);$i++){
				if($Tables[$i]['role']['type_node'] === '0'){
					$subHtml = '';
					for($j=0;$j<count($Tables);$j++){
						if($Tables[$j]['role']['id_parrent']===$Tables[$i]['role']['id']){
							$subHtml .= '\''.$Tables[$j]['role']['id'].'\': {\'text\': \''.$Tables[$j]['role']['name'].'\', \'type\': \'item\',\'id\':\''.$Tables[$j]['role']['id'].'\'},';

						}
					}
					if(strlen($subHtml)>0){
						$html .= '\''.$Tables[$i]['role']['id'].'\':{text: \''.$Tables[$i]['role']['name'].'\', type: \'folder\',\'additionalParameters\':{\'children\' : {'.substr($subHtml,0,strlen($subHtml)-1).'}}},';
					} else $html .='\''.$Tables[$i]['role']['id'].'\':{text: \''.$Tables[$i]['role']['name'].'\', type: \'item\',\'id\':\''.$Tables[$i]['role']['id'].'\'},';
				}
			}
			return substr($html,0,strlen($html)-1);
		}
		function ExportHtmlTreeViewForUpdate($Tables){
			$html = '';
			for($i=0;$i<count($Tables);$i++){
				if($Tables[$i]['roles']['type_node'] === '0'){
					$subHtml = '';
					for($j=0;$j<count($Tables);$j++){
						if($Tables[$j]['roles']['id_parrent']===$Tables[$i]['roles']['id']){
							$subHtml .= '\''.$Tables[$j]['roles']['id'].'\': {\'text\': \''.$Tables[$j]['roles']['name'].'\', \'type\': \'item\',\'id\':\''.$Tables[$j]['roles']['id'].'\''.((isset($Tables[$j][0]['CheckRoles']) && $Tables[$j][0]['CheckRoles']==='1')?',\'additionalParameters\':{\'item-selected\':true}':'').'},';

						}
					}
					if(strlen($subHtml)>0){
						$html .= '\''.$Tables[$i]['roles']['id'].'\':{text: \''.$Tables[$i]['roles']['name'].'\', type: \'folder\',\'additionalParameters\':{\'children\' : {'.substr($subHtml,0,strlen($subHtml)-1).'}}},';
					} else $html .='\''.$Tables[$i]['roles']['id'].'\':{text: \''.$Tables[$i]['roles']['name'].'\', type: \'item\',\'id\':\''.$Tables[$i]['roles']['id'].'\''.((isset($Tables[$j][0]['CheckRoles']) && $Tables[$j][0]['CheckRoles']==='1')?',\'additionalParameters\':{\'item-selected\':true}':'').'},';
				}
			}
			return substr($html,0,strlen($html)-1);
		}
		function ExportHtmlMenu($Tables,$thisAction,$thisController){
			$html = '';
			for($i=0;$i<count($Tables);$i++){
				if(isset($Tables[$i])){
					if($Tables[$i]['roles']['type_node'] === '0'){
						$subHtml = '';
						$dem = 0;
						for($j=$i+1;$j<count($Tables);$j++) {

							if(isset($Tables[$j]['roles']['type_node'])){
								if($Tables[$j]['roles']['id_parrent']===$Tables[$i]['roles']['id'] && $Tables[$j]['roles']['isShow']==='1'){
									if(isset($Tables[$j][0]['CheckRoles']) && $Tables[$j][0]['CheckRoles']==='1'){
										$subHtml .= '<li class="'.($Tables[$j]['roles']['ControllerName']==$thisController && $Tables[$j]['roles']['ActionName']==$thisAction?'active':'').'"><a href="'.Router::url( array('controller'=>$Tables[$j]['roles']['ControllerName'],'action'=>$Tables[$j]['roles']['ActionName']), true ).'"><i class="menu-icon fa '.(strlen($Tables[$j]['roles']['icon'])==0?'fa-caret-right':$Tables[$j]['roles']['icon']).'"></i><span class="menu-text">'.$Tables[$j]['roles']['NameMenu'].'</span></a><b class="arrow"></b></li>';
										$dem++;
										unset($Tables[$j]);
									}
								}
									
							}

						}
						if($dem>0){
							if($dem==1 && $Tables[$i]['roles']['isShow']==='0'){
								$html .= str_replace('class="active"','class="active"',$subHtml);
							} else {
								$html .= '<li class="'.(strpos($subHtml,'class="active"')!==false?'active open':'').'"><a href="#" class="dropdown-toggle"><i class="menu-icon fa '.(strlen($Tables[$i]['roles']['icon'])==0?'fa-caret-right':$Tables[$i]['roles']['icon']).'"></i><span class="menu-text">'.$Tables[$i]['roles']['NameMenu'].'</span><b class="arrow fa fa-angle-down"></b></a><b class="arrow"></b><ul class="submenu">'.$subHtml.'</ul></li>';
							}
						}

					}
				}
			}
			return '<ul class="nav nav-list">'.$html.'</ul>';
		}
		function to_slug($str) {
		    $str = trim(mb_strtolower($str));
		    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		    $str = preg_replace('/(đ)/', 'd', $str);
		    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
		    $str = preg_replace('/([\s]+)/', '-', $str);
		    return $str;
		}
		function ExportHtmlMenuForCombobox($Tables,$valueSelect,$ID){
			$html = '';
			for($i=0;$i<count($Tables);$i++){
				if(isset($Tables[$i])){
					if($Tables[$i]['role']['type_node'] === '0'){
						$html .= '<option value="'.$Tables[$i]['role']['id'].'"><b>'.$Tables[$i]['role']['NameMenu'].(($Tables[$i]['role']['ActionName']!='#' && $Tables[$i]['role']['ControllerName']!='#')?'':'(Không được chọn)').'</b></option>';
						for($j=$i+1;$j<count($Tables);$j++) {

							if(isset($Tables[$j]['role']['type_node'])){
								if($Tables[$j]['role']['id_parrent']===$Tables[$i]['role']['id'] && $Tables[$j]['role']['ActionName']!='#' && $Tables[$j]['role']['ControllerName']!='#'){
									$html .= '<option value="'.$Tables[$j]['role']['id'].'" '.(($Tables[$j]['role']['id']===$valueSelect)?'selected':'').'>&nbsp&nbsp&nbsp&nbsp'.$Tables[$j]['role']['NameMenu'].'</option>';
									unset($Tables[$j]);
								}
							}
						}
					}
				}
			}
			return '<select id="'.$ID.'" class="form-control" name="'.$ID.'">'.$html.'</select>';
		}
		function ParseDatetime($string){
			try
			{
				$result = '';
				$data = explode(' ',$string);
				if(isset($data[0]))
				{
					$tmp = explode('/',$data[0]);
					$result .= $tmp[2].'-'.$tmp[0].'-'.$tmp[1].' ';
				}
				if(isset($data[1])){
					$jump = 0;
					if(isset($data[2])){
						switch ($data[2]) {
							case 'PM':
								$jump += 12;
								break;
							
							default:
								$jump = 0;
								break;
						}
					}
					$tmp = explode(':',$data[1]);
					$result .= ($tmp[0]+$jump).':'.$tmp[1].':00';
				}
				return $result;
			}
			catch(Exception $e){
				return date('Y-m-d H:i:s');
			}
		}
		function ParseDatetimePicker($string){
			$result = '';
			$data = explode(' ',$string);
			if(isset($data[0]))
			{
				$tmp = explode('-',$data[0]);
				if($tmp[1]==='0000' || $tmp[2]==='00' || $tmp[0]==='00') return '01/01/1999 00:00 AM';
				else $result .= $tmp[1].'/'.$tmp[2].'/'.$tmp[0]. ' ';
			}
			if(isset($data[1])){
				$format = 'AM';
				$tmp = explode(':',$data[1]);
				if($tmp[0]>12){
					$format = 'PM';
					$tmp[0] = $tmp[0]-12;
				}
				$result .=$tmp[0].':'.$tmp[1].' '.$format;
			}
			return $result;
		}
	}