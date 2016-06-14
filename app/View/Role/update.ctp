<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li>
			<a href="#">Quản lý nhóm tào khoản</a>
		</li>
		<li class="active">Cập nhật</li>
	</ul>
</div>
<div class="page-content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Session->flash();?>
		</div>
		<div class="col-sm-4">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Thông tin
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-12"></div>
					<?php
						echo $this->Form->create('authoritie', array('Controller' => 'Role','Action'=>'update','id'=>'frminfomation','method'=>'post','class'=>'form-horizontal'));
						echo $this->Form->input('name',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Tên nhóm quyền','value' =>(isset($name)?$name:'')));

						echo $this->Form->input('roles',array('div'=>false,'label'=>false,'style'=>'display:none','id'=>'rolesHidden'));
						echo '<hr>';
						echo $this->Form->textarea('Description',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Chú thích','value' =>(isset($Description)?$Description:'')));
						echo '<hr>';
						echo $htmlCombobox;
						echo '<hr><div class="checkbox"><label>';
						echo $this->Form->checkbox('DefaultRegister', array('class'=>'ace','checked'=>(isset($Check)?($Check==='1'?true:false):false)));
						echo '<span class="lbl">Nhóm tài khoản mật định khi đăng ký</span></label></div>';
						echo '<hr><div><button type="submit" class="btn btn-sm btn-primary" name="btnsave"><i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i>Lưu</button><a href="/dashboard/role" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="ace-icon fa fa-times icon-on-right bigger-110"></i>Hủy</a></div>';
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="widget-box widget-color-blue2">
				<div class="widget-header">
					<h4 class="widget-title lighter smaller">Chọn chức năng</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-8">
						<ul id="treeRole"></ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/assets/js/fuelux.tree.min.js"></script>
<script type="text/javascript">
	jQuery(function($){
		var sampleData = initiateDemoData();
		$('#treeRole').ace_tree({
			dataSource: sampleData['dataSource1'],
			multiSelect: true,
			cacheItems: true,
			'open-icon' : 'ace-icon tree-minus',
			'close-icon' : 'ace-icon tree-plus',
			'selectable' : true,
			'selected-icon' : 'ace-icon fa fa-check',
			'unselected-icon' : 'ace-icon fa fa-times',
			loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'
		});
		$( "#frminfomation" ).submit(function( event ) {
			selectItem = '';
			$.each($('#treeRole').tree('selectedItems'), function( index, value ) {
				selectItem += value.id + '|';
			});
			if(selectItem.length>0) $('#rolesHidden').val(selectItem.substring(0, selectItem.length-1));
		});
	});
	function initiateDemoData(){
		var tree_data =  {<?php echo $htmlRole;?>};

		var dataSource1 = function(options, callback){
			var $data = null
			if(!("text" in options) && !("type" in options)){
				$data = tree_data;
				callback({ data: $data });
				return;
			}
			else if("type" in options && options.type == "folder") {
				if("additionalParameters" in options && "children" in options.additionalParameters)
					$data = options.additionalParameters.children || {};
				else $data = {}
			}
			
			if($data != null) setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);
		}
		return {'dataSource1': dataSource1 }
	}
</script>