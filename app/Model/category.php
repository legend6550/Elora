<?php

	class category extends AppModel {
		var $name = 'category';
		public function ExportStringCombobox($type_parent,$jump,$nodeselect){
			$result = '';
			$Data = $this->find('all',array('conditions'=>array('id_parrent'=>$type_parent),'order' => array('index ASC')));
			if(count($Data)>0){
				$result = '';
				for($i=0;$i<count($Data);$i++){
					$tmp = $this->ExportStringCombobox($Data[$i]['category']['id'], $jump.'&nbsp&nbsp&nbsp&nbsp',$nodeselect);
					$result .= '<option value=\''.$Data[$i]['category']['id'].'\' '.($nodeselect===$Data[$i]['category']['id']?'selected':'').'>'.$jump.$Data[$i]['category']['name'].'</option>'.$tmp;
				}
				return $result;
			} else return '';
		}
		public function ExportStringTables($type_parent){
			$result = '';
			$Data=$this->query('SELECT `categories`.*,`users`.`first_name`,`users`.`last_name` FROM `categories`,`users` WHERE `categories`.`id_parrent`=\''.$type_parent.'\' and `categories`.`byUser`=`users`.`id` ORDER BY `categories`.`index` ASC');
			if(count($Data)>0){
				$result = '';
				for($i=0;$i<count($Data);$i++){
					$tmp = $this->ExportStringTables($Data[$i]['categories']['id']);
					$result .= '<tr class="'.($i%2===0?'even pointer':'odd pointer').'" data-tt-id=\''.$Data[$i]['categories']['id'].'\' '.($Data[$i]['categories']['id_parrent']==='0'?'':'data-tt-parent-id=\''.$type_parent.'\'').'>';
					$result .= '<td>'.$Data[$i]['categories']['name'].'</td>';
					$result .= '<td>'.$Data[$i]['categories']['index'].'</td>';
					$result .= '<td><input data-option="active" data-on-text="khóa" data-id="'.$Data[$i]['categories']['id'].'" data-off-text="mở khóa" type="checkbox" '.($Data[$i]['categories']['active']==='1'?'checked':'').' ></td>';
					$result .= '<td>'.$Data[$i]['categories']['node'].'</td>';
					$result .= '<td>'.$Data[$i]['categories']['createDate'].'</td>';
					$result .= '<td>'.$Data[$i]['users']['first_name'].' '.$Data[$i]['users']['last_name'].'</td>';

					$result .= '<td><div class="hidden-sm hidden-xs action-buttons">';
					$result .= '<a class="green" href="?id='.$Data[$i]['categories']['id'].'">';
					$result .= '<i class="ace-icon fa fa-pencil bigger-130"></i>';
					$result .= '</a>';
					$result .= '<a class="red" href="#">';
					$result .= '<i class="ace-icon fa fa-trash-o bigger-130"></i>';
					$result .= '</a></div>';
					$result .= '<div class="hidden-md hidden-lg">';
					$result .= '<div class="inline pos-rel">';
					$result .= '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">';
					$result .= '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>';
					$result .= '</button>';
					$result .= '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">';
					$result .= '<li>';
					$result .= '<a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">';
					$result .= '<span class="green">';
					$result .= '<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>';
					$result .= '</span>';
					$result .= '</a>';
					$result .= '</li>';
					$result .= '<li>';
					$result .= '<a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">';
					$result .= '<span class="red">';
					$result .= '<i class="ace-icon fa fa-trash-o bigger-120"></i>';
					$result .= '</span>';
					$result .= '</a>';
					$result .= '</li>';
					$result .= '</ul>';
					$result .= '</div>';
					$result .= '</div></td>';
					$result .= '</tr>'.$tmp;
				}
				return $result;
			} else return '';
		}
		public function ExportStringTreeView($type_parent){
			$result = '';
			$Data=$this->query('SELECT `categories`.*,`users`.`first_name`,`users`.`last_name` FROM `categories`,`users` WHERE `categories`.`id_parrent`=\''.$type_parent.'\' and `categories`.`byUser`=`users`.`id` ORDER BY `categories`.`index` ASC');
			if(count($Data)>0){
				$result = '';
				for($i=0;$i<count($Data);$i++){
					$tmp = $this->ExportStringTreeView($Data[$i]['categories']['id']);
					$result .= '{\'id\':\''.$Data[$i]['categories']['id'].'\',\'text\': \''.$Data[$i]['categories']['name'].'\',\'children\': ['.$tmp.']},';
				}
				return strlen($result)>0?substr($result, 0,strlen($result)-1):'';
			} else return '';
		}
	}