<?php
	$array_date = array('DESC'=>'Giảm ngày đăng','ASC'=>'Tăng ngày đăng');
	$array_format = array('image/gif' => 'Gif','image/jpeg'=>'Jpg','image/pjpeg'=>'jpeg','image/png'=>'png','image/x-icon'=>'icon');
?>
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
		<li class="active">Danh sách hiện có</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>
			Hình ảnh
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Tất cả danh sách hiện có
			</small>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Session->flash();?>
			<div id="id-message-list-navbar" class="message-navbar clearfix" style="padding: 10px 12px 0px;">
				<form method="GET" class="form-horizontal">
					<div class="col-sm-3">
						<div class="form-group" style="margin-bottom: 10px;">
							<div class="col-xs-12">
								<input name="caption" class="form-control" placeholder="Tìm kiếm" value="<?php echo isset($_GET['caption'])?$_GET['caption']:''; ?>" />
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group" style="margin-bottom: 10px;">
							<div class="col-xs-12">
								<select name="sort_date" class="form-control">
									<option value="">Ngày đăng</option>
									<?php foreach ($array_date as $key => $value): ?>
										<?php if (isset($_GET['sort_date']) && strcmp(strtolower($_GET['sort_date']),strtolower($key))===0): ?>
											<option value="<?php echo $key;?>" selected><?php echo $value;?></option>
										<?php else: ?>
											<option value="<?php echo $key;?>"><?php echo $value;?></option>
										<?php endif ?>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group" style="margin-bottom: 10px;">
							<div class="col-xs-12">
								<select name="sort_format" class="form-control">
									<option value="">Định dạng file</option>
									<?php foreach ($array_format as $key => $value): ?>
										<?php if (isset($_GET['sort_format']) && strcmp(strtolower($_GET['sort_format']),strtolower($key))===0): ?>
											<option value="<?php echo $key;?>" selected><?php echo $value;?></option>
										<?php else: ?>
											<option value="<?php echo $key;?>"><?php echo $value;?></option>
										<?php endif ?>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group" style="margin-bottom: 10px;">
							<div class="col-xs-12">
								<button type="submit" class="btn btn-info btn-sm btn-block">
									<i class="ace-icon fa fa-search bigger-110"></i>Tìm kiếm
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="space-6"></div>
			<ul class="ace-thumbnails clearfix">
				<?php foreach ($Tables as $item): ?>
					<?php if (strlen($item['images']['FileURL'])>0 && file_exists(WWW_ROOT.'/'.$item['images']['FileURL'])): ?>
						<li>
							<a href="<?php echo $item['images']['FileURL'] ?>" title="<?php echo $item['images']['Caption'] ?>" data-rel="colorbox">
								<img width="161" height="161" alt="150x150" src="<?php echo $item['images']['FileURL'] ?>" />
							</a>

							<div class="tags">
								<span class="label-holder">
									<span class="label label-info"><?php echo $item['images']['FileType'] ?></span>
								</span>

								<span class="label-holder">
									<span class="label label-danger"><?php echo $item['images']['FileSize'] ?> KB</span>
								</span>

								<span class="label-holder">
									<span class="label label-success"><?php echo $item['images']['FileWidth'].' x '.$item['images']['FileHeight'] ?></span>
								</span>
							</div>
							<div class="tools">
								<a href="/dashboard/image/<?php echo $item['images']['id'] ?>">
									<i class="ace-icon fa fa-pencil"></i>
								</a>

								<a href="/dashboard/image/delete?id=<?php echo $item['images']['id'] ?>">
									<i class="ace-icon fa fa-times red"></i>
								</a>
							</div>
						</li>
					<?php endif ?>
				<?php endforeach ?>
			</ul>
			<ul class="pagination" style="float: right;">
				<?php if (isset($currentPage) && $currentPage>1): ?>
					<li>
						<a href="<?php echo str_replace('{page}',($currentPage-1) , $url) ; ?>">
							<i class="ace-icon fa fa-angle-double-left"></i>
						</a>
					</li>
				<?php else: ?>
					<li class="disabled">
						<a href="#">
							<i class="ace-icon fa fa-angle-double-left"></i>
						</a>
					</li>
				<?php endif ?>
				<?php 
					$start = ($currentPage-2)>=0?$currentPage-2:$currentPage;
					$end = ($currentPage+2)>=$TotalPage?$TotalPage:$currentPage+2;
					if($TotalPage<=5){
						$start = 1;
						$end = $TotalPage;
					}
					for ($i=$start; $i <= $end; $i++) { 
						if($i==$currentPage) echo '<li class="active"><a href="'.str_replace('{page}',$i , $url).'">'.$i.'</a></li>';
						else echo '<li><a href="'.str_replace('{page}',$i , $url).'">'.$i.'</a></li>';
					}
				?>
				<?php if (($currentPage+1)>=$TotalPage): ?>
					<li>
						<a href="<?php echo str_replace('{page}',($currentPage+1) , $url) ; ?>">
							<i class="ace-icon fa fa-angle-double-right"></i>
						</a>
					</li>
				<?php else: ?>
					<li class="disabled">
						<a href="#">
							<i class="ace-icon fa fa-angle-double-right"></i>
						</a>
					</li>
				<?php endif ?>
			</ul>
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
		$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
		$("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");
		$(document).one('ajaxloadstart.page', function(e) {
			$('#colorbox, #cboxOverlay').remove();
	   });
	})
</script>