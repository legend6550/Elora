<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<link rel="stylesheet" href="/assets/css/jquery-ui.custom.min.css" />
<link rel="stylesheet" href="/assets/css/chosen.min.css" />
<style type="text/css">
	.ace-spinner{
		width: 100% !important;
	}
	.chosen-container-single .chosen-single {
	    border-radius: 0;
	}
	.chosen-container>.chosen-single, [class*=chosen-container]>.chosen-single {
	    line-height: 28px;
	    height: 32px;
	    box-shadow: none;
	    background: #FAFAFA;
	}
	.chosen-container-single .chosen-search input[type=text]{
		background: none
	}
	.chosen-container-single .chosen-single abbr:after {
	    content: "\f00d";
	    display: inline-block;
	    color: #888;
	    font-family: FontAwesome;
	    font-size: 13px;
	    position: absolute;
	    right: 0;
	    top: -7px;
	}
	td.details-control {
    background: url('../resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('../resources/details_close.png') no-repeat center center;
}
</style>
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li><a href="#">Quản lý sản phẩm</a></li>
		<li><a href="#"><?php echo $nameProduct;?></a></li>
		<li class="active">Quản lý kho</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Quản lý kho</h1>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Session->flash();?>
		</div>
		<div class="col-sm-4" id="windowsInfomation">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-map-marker"></i>
						Thông tin
					</h4>
				</div>
			</div>
			<div class="widget-body">
				<?php echo $this->Form->create('Product', array('Controller' => 'Product','Action'=>'promotion','type'=>'file','method'=>'post','class'=>'form-horizontal'))?>
					<div class="space-8"></div>
					<div>
						<?php echo $this->Form->input('Size',array('options'=>$DataSize,'empty' => '','default'=>(isset($Size)?$Size:''),'class'=>'form-control chosen-select','data-placeholder'=>'Chọn kích thước','div'=>false,'label'=>false,'id'=>'cboSize'));?>
					</div>
					<hr>
					<div>
						<?php echo $this->Form->input('number',array('div'=>false,'label'=>false,'id'=>'txtnumber','value'=>(isset($number)?$number:'')));?>
					</div>
					<hr>
					<div>
						<button class="btn btn-sm btn-success" name="btnsave" type="submit">
							<i class="ace-icon fa fa-check"></i>
							Lưu dữ liệu
						</button>
						<a href="/dashboard/product<?php echo !isset($_GET['id'])?'/warehousing/'.$slug:'/warehousing/'.$slug.'/'.$idwarehousing ?>" class="btn btn-sm btn-danger">
							<i class="ace-icon fa fa-check"></i>
							Trở lại
						</a>
					</div>
				<?php echo $this->Form->end()?>
			</div>

		</div>
		<div class="col-sm-8">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-list"></i>
						Danh sách
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						<table id="DataTable" class="table table-bordered table-striped" width="100%">
							<thead class="thin-border-bottom">
								<tr>
									<th>STT</th>
									<th>Kích thước</th>
									<th>Nhập kho</th>
									<th>Tồn kho</th>
									<th>Ngày tạo</th>
									<th>Người tạo</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								<?php for($i=0;$i<count($Tables);$i++):?>

									<tr data-id="<?php echo $Tables[$i]['productinventories']['id'];?>">
										<td><?php echo ($i+1) ?></td>
										<td><?php echo $Tables[$i][0]['Size'];?></td>
										<td><?php echo number_format($Tables[$i]['productinventories']['number'],0)?></td>
										<td><?php echo number_format($Tables[$i][0]['inventories'],0)?></td>
										<td><?php echo $Tables[$i]['productinventories']['createDate']?></td>
										<td><?php echo isset($Tables[$i][0]['fullname'])?$Tables[$i][0]['fullname']:'Chưa xác định';?></td>
										<td>
											<div class="hidden-sm hidden-xs action-buttons">
												<a class="green" href="/dashboard/product/warehousing/<?php echo $slug.'/'.$idwarehousing.'?id='.$Tables[$i]['productinventories']['id']?>">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
												</a>
												<a class="red" href="/dashboard/product/warehousing/<?php echo $slug.'/'.$idwarehousing.'?delete='.$Tables[$i]['productinventories']['id']?>">
													<i class="ace-icon fa fa-trash-o bigger-130"></i>
												</a>
											</div>
											<div class="hidden-md hidden-lg">
												<div class="inline pos-rel">
													<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
														<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
													</button>
													<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
														<li>
															<a href="/dashboard/product/warehousing/<?php echo $slug.'/'.$idwarehousing.'?id='.$Tables[$i]['productinventories']['id']?>" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
																<span class="green">
																	<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																</span>
															</a>
														</li>
														<li>
															<a href="/dashboard/product/warehousing/<?php echo $slug.'/'.$idwarehousing.'?delete='.$Tables[$i]['productinventories']['id']?>" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
																<span class="red">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</td>
									</tr>
								<?php endfor ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="space-8"></div>
			<div class="hr hr-double dotted"></div>
			<div class="space-8"></div>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-picture-o"></i>
						Hình ảnh
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						<ul class="ace-thumbnails clearfix">
							<li><input></li>
							<?php foreach ($images as $item): ?>
								<?php if (strlen($item['productwarehousingimage']['image'])>0 && file_exists(WWW_ROOT.'/assets/images/'.$item['productwarehousingimage']['image'])): ?>
									<li>
										<a href="<?php echo '/assets/images/'.$item['productwarehousingimage']['image'] ?>" data-rel="colorbox">
											<img width="161" height="161" alt="150x150" src="<?php echo '/assets/images/'.$item['productwarehousingimage']['image'] ?>" />
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
					</div>
				</div>
			</div>




		</div>
	</div>
</div>
<script src="/assets/js/jquery.colorbox.min.js"></script>
<script src="/assets/js/jquery-ui.custom.min.js"></script>
<script src="/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="/assets/js/chosen.jquery.min.js"></script>
<script src="/assets/js/fuelux.spinner.min.js"></script>
<script src="/assets/js/bootstrap-datepicker.min.js"></script>
<script src="/assets/js/bootstrap-timepicker.min.js"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/daterangepicker.min.js"></script>
<script src="/assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="/assets/js/bootstrap-colorpicker.min.js"></script>
<script src="/assets/js/jquery.knob.min.js"></script>
<script src="/assets/js/jquery.autosize.min.js"></script>
<script src="/assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="/assets/js/jquery.maskedinput.min.js"></script>
<script src="/assets/js/bootstrap-tag.min.js"></script>
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="/assets/js/dataTables.tableTools.min.js"></script>
<script src="/assets/js/dataTables.colVis.min.js"></script>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	function format ( d ) {
	    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
	        '<tr>'+
	            '<td>Full name:</td>'+
	            '<td>'+d.name+'</td>'+
	        '</tr>'+
	        '<tr>'+
	            '<td>Extension number:</td>'+
	            '<td>'+d.extn+'</td>'+
	        '</tr>'+
	        '<tr>'+
	            '<td>Extra info:</td>'+
	            '<td>And any further details here (images etc)...</td>'+
	        '</tr>'+
	    '</table>';
	}
	$(document).ready(function () {
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
		var table = $('#DataTable').dataTable({
			bAutoWidth: false,
			"columns": [
	            { "data": "STT" },
	            { "data": "Size" },
	            { "data": "number" },
	            { "data": "TonKho" },
	            { "data": "CreateDate" },
	            { "data": "NguoiTao" },
	            { "data": "" }
	        ],
	        'aaSorting': [],
		});
		$('#txtavatar').ace_file_input({
			style:'well',
			btn_choose:'Chọn hình ảnh upload',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'small'
		}).on('change', function(){
		});
		$('#txtnumber').ace_spinner({value:0,min:0,max:10000,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		if(!ace.vars['touch']) {
			$('.chosen-select').chosen({allow_single_deselect:true}); 
	
			$(window).off('resize.chosen').on('resize.chosen', function() {
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': $this.parent().width()});
				})

			}).trigger('resize.chosen');

			$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
				if(event_name != 'sidebar_collapsed') return;
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': $this.parent().width()});
				})
			});
		}
	});
</script>