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
						<?php echo $this->Form->input('color',array('options'=>$DataColor,'empty' => '','class'=>'form-control chosen-select','data-placeholder'=>'Chọn màu sắc','div'=>false,'label'=>false));?>
					</div>
					<hr>
					<div>
						<?php echo $this->Form->input('Size',array('options'=>$DataSize,'empty' => '','class'=>'form-control chosen-select','data-placeholder'=>'Chọn kích thước','div'=>false,'label'=>false,'id'=>'cboSize'));?>
						<div class="space-8"></div>
						<div class="input-group">
							<?php echo $this->Form->input('number',array('div'=>false,'label'=>false,'id'=>'txtnumber'));?>
							<span class="input-group-btn" id="btnAddSize">
								<button class="btn btn-sm btn-default" type="button" data-option="saveSize" style="padding: 4px 9px 3px 8px;margin-left: 5px;">
									<i class="ace-icon fa fa-floppy-o bigger-110"></i>
									Lưu
								</button>
							</span>
						</div>
						<div class="space-8"></div>

						<table id="DataTableSize" class="table table-bordered table-striped" width="100%">
							<thead class="thin-border-bottom">
								<tr>
									<th>Size</th>
									<th>Số lượng</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<hr>
					<div>
						<?php echo $this->Form->file('image.',array('id'=>"txtavatar",'div'=>false,'label'=>false,'multiple'=>'multiple'));?>
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
						<table id="DataTable" class="table table-bordered table-striped" width="100%">
							<thead class="thin-border-bottom">
								<tr>
									<th></th>
									<th>STT</th>
									<th>Màu sắc</th>
									<th>Tồn kho</th>
									<th>Ngày tạo</th>
									<th>Người tạo</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								<?php for($i=0;$i<count($Tables);$i++):?>

									<tr data-id="<?php echo $Tables[$i]['productwarehousings']['id'];?>">
										<td></td>
										<td><?php echo ($i+1) ?></td>
										<td><?php echo $Tables[$i][0]['color'];?></td>
										<td><?php echo $Tables[$i][0]['inventory']?></td>
										<td><?php echo $Tables[$i]['productwarehousings']['createDate']?></td>
										<td><?php echo isset($Tables[$i][0]['fullname'])?$Tables[$i][0]['fullname']:'Chưa xác định';?></td>
										<td>
											<div class="hidden-sm hidden-xs action-buttons">
												<a class="green" href="/dashboard/product/warehousing/<?php echo $slug.'/'.$Tables[$i]['productwarehousings']['id']?>">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
												</a>
												<a class="red" href="?delete=<?php echo $Tables[$i]['productwarehousings']['id'];?>">
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
															<a href="/dashboard/product/warehousing/<?php echo $slug.'/'.$Tables[$i]['productwarehousings']['id']?>" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
																<span class="green">
																	<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																</span>
															</a>
														</li>
														<li>
															<a href="?delete=<?php echo $Tables[$i]['productwarehousings']['id'];?>" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
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
		var table = $('#DataTable').dataTable({
			bAutoWidth: false,
			"columns": [
	            {
	                "className": 'details-control',
	                "orderable": false,
	                "data": null,
	                "defaultContent": ''
	            },
	            { "data": "STT" },
	            { "data": "Color" },
	            { "data": "TonKho" },
	            { "data": "CreateDate" },
	            { "data": "NguoiTao" },
	            { "data": "" }
	        ],
	        'aaSorting': [],
		});

		$('#DataTable tbody').on('click', 'td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var $id = tr.attr('data-id');
	        if(tr.attr('class').indexOf('shown')!=-1){
	        	row.child.hide();
	            tr.removeClass('shown');
	        } else{
	        	$html = '<div class="widget-box transparent position-relative" data-subjects="' + $id + '">' +
							'<div class="widget-body">' +
								'<div class="widget-main no-padding">' +
									'<table data-subjects="' + $id + '" class="table table-bordered table-striped" style="border: 1px solid #E5E5E5;">' +
										'<thead>' +
											'<tr>' +
												'<th>STT</th>' +
												'<th>Size</th>' +
												'<th>Số lượng</th>' +
												'<th>Tồn kho</th>' +
											'</tr>'+
										'</thead>' +
										'<tbody>' +
										'</tbody>' +
										'</table>' +
								'</div>' +
							'</div>' +
							'<div class="widget-box-overlay"><i class=" ace-icon loading-icon fa fa-spinner fa-spin fa-2x white"></i></div>'+
						'</div>';
	        	$.ajax({
	                type: 'POST',
	                url: "/api/v2/data/get-inventories-by-id-warehousing.json",
	                data: {
	                    id: $id,
	                    byUser:'<?php echo $usernameLogin;?>'
	                },
	                success: function (data) {
	                    if (data.error != null) {
	                    	$('div[data-subjects="' + $id + '"]').find(".widget-main").removeClass('no-padding');
	                		$('div[data-subjects="' + $id + '"]').find(".widget-main").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-chain-broken green"></i>' + data.error + '</div>');
	                    }
	                    else if(data.data != null){
	                    	$dataHtml = '';
	                    	if(Object.keys(data.data).length==0) $dataHtml='';
	                    	else{
	                    		$.each(data.data, function(i, item) {
								    $dataHtml += '<tr>';
								    $dataHtml += '<td>'+(i+1)+'</td>';
								    $dataHtml += '<td>'+item.name+'</td>';
								    $dataHtml += '<td>'+item.number+'</td>';
								    $dataHtml += '<td>'+item.inventorie+'</td>';
								    $dataHtml += '</tr>';
								});
	                    	}
	                    	$('table[data-subjects="' + $id + '"]').find('tbody').append($dataHtml);
	                    }
	                    $('div[data-subjects="' + $id + '"]').removeClass('position-relative');
	                     $('div[data-subjects="' + $id + '"]').find('.widget-box-overlay').remove();
	                    
	                },
	                error: function () {
	                	$('div[data-subjects="' + $id + '"]').find(".widget-main").removeClass('no-padding');
	                	$('div[data-subjects="' + $id + '"]').find(".widget-main").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-chain-broken green"></i>Lỗi kết nối server</div>');
	                }
	            });
	            tr.after('<tr data-type=""><td colspan="7">'+$html+'</td></tr>');
	            tr.addClass('shown');
	        }
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
		$('button[data-option="saveSize"]').on('click', function(e){
			$('#cboSize').parent().find('div[data-type="alert"]').remove();
			$err = '';
			if($('#cboSize').val()==null || $('#cboSize').val().length==0) $err +='<li>Bạn cần chọn size</li>';
			if($('#txtnumber').val()==null || $('#txtnumber').val().length==0 || isNaN($('#txtnumber').val()) || parseInt($('#txtnumber').val())==0) $err +='<li>Bạn cần nhập số lượng</li>';
			if($err.length>0){
				$html = '<div class="alert alert-danger" data-type="alert">';
				$html += '<button type="button" class="close" data-dismiss="alert">';
				$html += '<i class="ace-icon fa fa-times"></i>';
				$html += '</button><ul>' + $err + '</ul></div>';
				$('#cboSize').before($html);
			}
			else{

				$html = '<tr>';
				$html += '<td>' + $("#cboSize :selected").text() + '</td>';
				$html += '<td>'+$("#txtnumber").val()+'</td>';
				$html += '<td><input name="data[Product][size][]" value="'+$("#cboSize").val()+'" type="hidden"><input name="data[Product][number][]" value="'+$("#txtnumber").val()+'" type="hidden"><a class="red" href="javascript:void(0)" onclick="removeSize(this)"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td>';
				$html += '</tr>';
				$('#DataTableSize').find('tbody').append($html);
				$('#cboSize').chosen('destroy');  
				$('#cboSize').prop("selectedIndex", -1);   
				$('#cboSize').chosen();
				$("#txtnumber").val(0);

				$html = '<div class="alert alert-info" data-type="alert">';
				$html += '<button type="button" class="close" data-dismiss="alert">';
				$html += '<i class="ace-icon fa fa-times"></i>';
				$html += '</button>Thêm thành công</div>';
				$('#cboSize').before($html);
			}
			//
		});
	});
	function removeSize($ele){
		$($ele).parent().parent().remove()
	}
</script>