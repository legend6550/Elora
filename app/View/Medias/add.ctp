<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li>
			<a href="#">Quản lý hình ảnh</a>
		</li>
		<li class="active">Thêm hình ảnh</li>
	</ul>
</div>
<div class="page-content">
	<?php echo $this->Session->flash();?>
	<div class="row">
		<div class="col-xs-12">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-file-image-o"></i>
						Thêm hình ảnh
					</h4>
				</div>
			</div>
			<div class="widget-body">
				<div class="space-12"></div>
				<?php
					echo $this->Form->create(null, array('Controller' => 'Administrator','Action'=>'settingSlide','method'=>'post','enctype'=>'multipart/form-data','class'=>'form-horizontal'));
					echo $this->Form->input('image.',array('type'=>"file",'id'=>"image","multiple"=>"multiple",'div'=>false,'label'=>false));
					echo '<hr><div><button type="submit" class="btn btn-sm btn-primary" name="btnsave"><i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i>Lưu</button><a href="/dashboard/setting-slide" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="ace-icon fa fa-times icon-on-right bigger-110"></i>Hủy</a></div>';
				?>
			</div>
		</div>
	</div>
</div>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		$('#image').ace_file_input({
			style:'well',
			btn_choose:'Chọn hình ảnh',
			btn_change:null,
			droppable:true,
			'no_icon': "ace-icon fa fa-picture-o",
			'allowExt': ["jpeg", "jpg", "png", "gif" , "bmp"],
			'allowMime': ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"],
			thumbnail:'smart',
			preview_error : function(filename, error_code) {
			}

		}).on('change', function(){
		});
	});
</script>