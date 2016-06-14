<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li>
			<a href="#">Quản trị website</a>
		</li>
		<li class="active">Slide Hình ảnh</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Slide hình ảnh</h1>
	</div>
	<?php echo $this->Session->flash();?>
	<div class="row">
		<div class="col-xs-5">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-file-image-o"></i>
						Thêm hình ảnh
					</h4>
				</div>
			</div>
			<div class="widget-body">
				<div class="space-4"></div>
				<?php
					echo $this->Form->create(null, array('Controller' => 'Administrator','Action'=>'settingSlide','method'=>'post','enctype'=>'multipart/form-data','class'=>'form-horizontal'));
					echo $this->Form->input('title',array('class' => 'form-control','placeholder'=>'Tiêu đề','label'=>'Tiêu đề','value'=>$titleSlide));
					echo '<hr><div>';
					echo '<label for="txtdescription">Mô tả</label>';
					echo $this->Form->textarea('description',array('class' => 'form-control','id'=>'txtdescription','placeholder'=>'Mô tả','label'=>'Mô tả','value'=>$descriptionSlide));
					echo '</div><hr>';
					echo $this->Form->input('btnlink',array('class' => 'form-control','placeholder'=>'Nút hiển thị','label'=>'Nút hiển thị','value'=>$btnlink));
					echo '<hr>';
					echo $this->Form->input('link',array('class' => 'form-control','placeholder'=>'Link liên kết','label'=>'Link liên kết','value'=>$link));
					echo '<hr>'.$picture;

					echo $this->Form->input('picture',array('type'=>"file",'id'=>"picImage",'div'=>false,'label'=>false));
				?>
				<div class="form-actions center">
					<button type="submit" class="btn btn-sm btn-success" name="btnsave">
						<i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i>
						Lưu
					</button>
					<a href="/dashboard/setting-slide" class="btn btn-sm btn-danger">
						Hủy
						<i class="ace-icon fa fa-times icon-on-right bigger-110"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-7">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-picture-o"></i>
						Danh sách hình ảnh hiện có
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main no-padding">
						<?php foreach ($Table as $item):?>
							<div class="profile-activity clearfix">
								<div>
									<img class="pull-left" alt="<?php echo $item['Slide']['title']?>" src="
									<?php
										if(strlen($item['Slide']['images'])>0 && file_exists(WWW_ROOT.'/assets/images/slide/'.$item['Slide']['images'])) 
									        echo '/assets/images/slide/'.$item['Slide']['images'];
									    else
									       echo '/assets/images/no-image.png';
					       			?>">
									<a class="user" href="#"><?php echo $item['Slide']['title']?></a>
									<div class="time">
										<?php echo $item['Slide']['content']?>
									</div>
								</div>

								<div class="tools action-buttons">
									<a href="?id=<?php echo $item['Slide']['id'] ?>" class="blue">
										<i class="ace-icon fa fa-pencil bigger-125"></i>
									</a>

									<a href="?delete=<?php echo $item['Slide']['id'] ?>" class="red">
										<i class="ace-icon fa fa-times bigger-125"></i>
									</a>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	$('#picImage').ace_file_input({
		style:'well',
		btn_choose:'Chọn hình ảnh',
		btn_change:null,
		no_icon:'ace-icon fa fa-cloud-upload',
		droppable:true,
		thumbnail:'small'
		,
		preview_error : function(filename, error_code) {
		}

	}).on('change', function(){
	});
</script>