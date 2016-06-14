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
		<div class="col-xs-5">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-file-image-o"></i>
						Thông tin
					</h4>
				</div>
			</div>
			<div class="widget-body">
				<div class="space-12"></div>
				<?php
					echo $this->Form->create('Medias', array('Controller' => 'Medias','Action'=>'edit','method'=>'post','class'=>'form-horizontal'));
					echo $this->Form->input('Caption',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Tiêu đề','value' =>(isset($Caption)?$Caption:'')));
					echo '<hr>';
					echo $this->Form->textarea('Description',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Mô tả','value' =>(isset($Description)?$Description:'')));
					echo '<hr><div><button type="submit" class="btn btn-sm btn-primary" name="btnsave"><i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i>Lưu</button><a href="/dashboard/setting-slide" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="ace-icon fa fa-times icon-on-right bigger-110"></i>Hủy</a></div>';
				?>
			</div>
		</div>

		<div class="col-xs-7">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-file-image-o"></i>
						Hình ảnh
					</h4>
				</div>
			</div>
			<div class="widget-body" style="display: block;position: relative;overflow: hidden;margin: 2px;border: 2px solid #333;">
				<a href="<?php echo $images;?>" title="" data-rel="colorbox" class="cboxElement">
					<img width="100%" alt="150x150" id="images" src="<?php echo $images;?>">
				</a>
				<div style="display: inline-block;position: absolute;bottom: 0;right: 0;overflow: visible;direction: rtl;padding: 0;margin: 0;height: auto;background-color: transparent;border-width: 0;vertical-align: inherit;width: 100px;">
					<span class="label-holder">
						<span class="label label-info"><?php echo isset($format)?$format:'' ?></span>
					</span>

					<span class="label-holder">
						<span class="label label-danger"><?php echo isset($size)?$size:'' ?>KB</span>
					</span>

					<span class="label-holder">
						<span class="label label-success"><?php echo isset($dimension)?$dimension:'' ?></span>
					</span>
				</div>
			</div>
		</div>


	</div>
</div>
<script src="/assets/js/jquery.colorbox.min.js"></script>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		var $overflow = '';
		var colorbox_params = {
			rel: 'colorbox',
			reposition:true,
			scalePhotos:true,
			scrolling:false,
			previous:'<i class="ace-icon fa fa-arrow-left"></i>',
			next:'<i class="ace-icon fa fa-arrow-right"></i>',
			close:'&times;',
			current:'{current} of {total}',
			maxWidth:'100%',
			maxHeight:'100%',
			onOpen:function(){
				$overflow = document.body.style.overflow;
				document.body.style.overflow = 'hidden';
			},
			onClosed:function(){
				document.body.style.overflow = $overflow;
			},
			onComplete:function(){
				$.colorbox.resize();
			}
		};
		$('a[data-rel="colorbox"]').colorbox(colorbox_params);
		$("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");
		$(document).one('ajaxloadstart.page', function(e) {
			$('#colorbox, #cboxOverlay').remove();
	   });
	})
</script>