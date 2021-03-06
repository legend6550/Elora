<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<link rel="stylesheet" href="/assets/css/jquery-ui.custom.min.css" />
<link rel="stylesheet" href="/assets/css/chosen.min.css" />
<link rel="stylesheet" href="/assets/css/datepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="/assets/css/daterangepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="/assets/css/colorpicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-switch.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li><a href="#">Quản lý sản phẩm</a></li>
		<li class="active">Quản lý khuyến mãi</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Quản lý khuyến mãi</h1>
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
				<?php echo $this->Form->create('Product', array('Controller' => 'Product','Action'=>'promotion','method'=>'post','class'=>'form-horizontal'))?>
					<div class="space-8"></div>
					<div>
						<?php echo $this->Form->input('price',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Giá Khuyến mãi','value'=>(isset($price)?$price:'')));?>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->input('todate',array('class'=>'form-control','div'=>false,'id'=>'txttodate','label'=>false,'placeholder'=>'Từ ngày','value'=>(isset($todate)?$todate:'')));?>
						</div>
						<div class="col-sm-6">
						<?php echo $this->Form->input('fromdate',array('class'=>'form-control','div'=>false,'id'=>'txtfromdate','label'=>false,'placeholder'=>'Đến ngày','value'=>(isset($formdate)?$formdate:'')));?>
						</div>
					</div>
					<hr>
					<div>
						<button class="btn btn-sm btn-success" name="btnsave" type="submit">
							<i class="ace-icon fa fa-check"></i>
							Lưu dữ liệu
						</button>
						<a href="/dashboard/product<?php echo !isset($_GET['id'])?'':'/promotion/'.$slugID ?>" class="btn btn-sm btn-danger">
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
						<table class="table table-bordered table-striped" width="100%">
							<thead class="thin-border-bottom">
								<tr>
									<th>STT</th>
									<th>Giá khuyến mãi</th>
									<th>Từ ngày</th>
									<th>Đến ngày</th>
									<th>Người tạo</th>
									<th>Trạng thái</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								<?php for($i=0;$i<count($Tables);$i++):?>

									<tr>
										<td><?php echo ($i+1) ?></td>
										<td><?php echo number_format($Tables[$i]['productpromotions']['price'],0).' đ';?></td>
										<td><?php echo $Tables[$i]['productpromotions']['todate'];?></td>
										<td><?php echo $Tables[$i]['productpromotions']['formdate']?></td>
										<td><?php echo isset($Tables[$i][0]['fullname'])?$Tables[$i][0]['fullname']:'Chưa xác định';?></td>
										<td>
											<?php
												$label = 'arrowed';
												if(isset($Tables[$i][0]['status']) && strpos($Tables[$i][0]['status'],'Đang')!==false) $label = 'label-success arrowed-in arrowed-in-right';
												else if(isset($Tables[$i][0]['status']) && strpos($Tables[$i][0]['status'],'Chưa')!==false) $label = 'label-info arrowed-right arrowed-in';
												else if(isset($Tables[$i][0]['status']) && strpos($Tables[$i][0]['status'],'Đã')!==false) $label = 'label-warning arrowed arrowed-right';
												echo isset($Tables[$i][0]['status'])?'<span class="label '.$label.'">'.$Tables[$i][0]['status'].'</span>':'<span class="label '.$label.'">Chưa xác định</span>';
											?>
										</td>
										<td>
											<div class="hidden-sm hidden-xs action-buttons">
												<a class="green" href="?id=<?php echo $Tables[$i]['productpromotions']['id'];?>">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
												</a>
												<a class="red" href="?delete=<?php echo $Tables[$i]['productpromotions']['id'];?>">
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
															<a href="?id=<?php echo $Tables[$i]['productpromotions']['id'];?>" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
																<span class="green">
																	<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																</span>
															</a>
														</li>
														<li>
															<a href="?delete=<?php echo $Tables[$i]['productpromotions']['id'];?>" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
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
		</div>
	</div>
</div>
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
<script src="/assets/js/markdown.min.js"></script>
<script src="/assets/js/bootstrap-markdown.min.js"></script>
<script src="/assets/js/jquery.hotkeys.min.js"></script>
<script src="/assets/js/bootstrap-wysiwyg.min.js"></script>
<script src="/assets/js/bootbox.min.js"></script>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script src="/assets/js/ap-fullscreen-modal.js"></script>
<script src="/assets/plugin/jstree/dist/jstree.min.js"></script>
<script src="http://www.bootstrap-switch.org/dist/js/bootstrap-switch.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		$('#txttodate,#txtfromdate').datetimepicker().next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	});
</script>