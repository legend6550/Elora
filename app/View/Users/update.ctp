<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<link rel="stylesheet" href="/assets/css/jquery-ui.custom.min.css" />
<link rel="stylesheet" href="/assets/css/chosen.min.css" />
<link rel="stylesheet" href="/assets/css/datepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="/assets/css/daterangepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="/assets/css/colorpicker.min.css" />
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" />

<style type="text/css">
	input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
	    content: "Nam\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0Nữ";
	    font-size: 15px;
	    line-height: 31px;
	    height: 34px;
	    overflow: hidden;
	    border-radius: 12px;
	    background-color: #8b9aa3;
	    border: 1px solid #8b9aa3;
	    color: #FFF;
	    width: 85px;
	    /* text-indent: -25px; */
	    text-shadow: 0 0 0 #FFF;
	    display: inline-block;
	    position: relative;
	    box-shadow: none;
	    -webkit-transition: all .3s ease;
	    -o-transition: all .3s ease;
	    transition: all .3s ease;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
	    content: 'III';
	    font-size: 20px;
	    position: absolute;
	    top: 2px;
	    left: 2px;
	    letter-spacing: 0;
	    width: 30px;
	    height: 30px;
	    line-height: 29px;
	    text-shadow: none!important;
	    color: #939393;
	    background-color: #FFF;
	    -webkit-transition: all .3s ease;
	    -o-transition: all .3s ease;
	    transition: all .3s ease;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
	    left: 53px;
	    background-color: #FFF;
	    color: #848484;
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
</style>
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li><a href="#">Quản lý tài khoản</a></li>
		<li class="active">Thêm tài khoản</li>
	</ul>
</div>
<div class="page-content">
	<div class="row">
		<div class="col-sm-12" id="WindowsMsg">
			<?php echo $this->Session->flash();?>
		</div>
		<?php echo $this->Form->create('Users', array('Controller' => 'Users','Action'=>'update','method'=>'post','enctype'=>'multipart/form-data','class'=>'form-horizontal'));?>
		<div class="col-sm-4">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-file-image-o"></i>
						Thông tin tài khoản
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						<div class="space-8"></div>
							<div class="center" style="width:100%">
								<span class="profile-picture">
									<img id="avatar" class="editable img-responsive editable-click editable-empty" alt="Avatar" src="<?php echo $avatar?>">
								</span>
							</div>
						<?php echo $this->Form->input('image',array('type'=>"file",'id'=>"txtavatar",'div'=>false,'label'=>false));?>
						<hr>
						<div class="row">
							<div class="col-xs-6">
								<?php echo $this->Form->input('first_name',array('placeholder'=>'Họ và tên đệm','value'=>isset($first_name)?$first_name:'','class'=>'form-control','div'=>false,'label'=>false));?>
							</div>
							<div class="col-xs-6">
								<?php echo $this->Form->input('last_name',array('placeholder'=>'Tên','class'=>'form-control','value'=>isset($last_name)?$last_name:'','div'=>false,'label'=>false));?>
							</div>
						</div>
						<hr>
						<div class="input-group">
							<div class="input-group" style="width: 100%;">
								<?php echo $this->Form->input('birthday',array('placeholder'=>'Sinh nhật','class'=>'form-control date-picker','div'=>false,'label'=>false,'data-date-format'=>'yyyy-mm-dd','value'=>isset($birthday)?$birthday:''))?>
								<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i>
								</span>
							</div>
							<label style="display: table-cell;width: 1%;white-space: nowrap;vertical-align: middle;">
								<?php echo $this->Form->checkbox('Gender', array('class'=>'ace ace-switch ace-switch-4 btn-flat'))?>
								<span class="lbl"></span>
							</label>
						</div>
						<div class="space-8"></div>
						<div class="row">
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="ace-icon fa fa-user"></i>
									</span>
									<?php echo $this->Form->input('username', array('class'=>'form-control','placeholder'=>'Tài khoản','value'=>(isset($username)?$username:''),'div'=>false,'label'=>false))?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="ace-icon fa fa-at"></i>
									</span>
									<?php echo $this->Form->input('mail', array('class'=>'form-control','placeholder'=>'Địa chỉ mail','value'=>isset($gmail)?$gmail:'','div'=>false,'label'=>false))?>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="ace-icon fa fa-key"></i>
									</span>
									<?php echo $this->Form->password('password', array('class'=>'form-control','placeholder'=>'Mật khẩu','value'=>isset($password)?$password:'','div'=>false,'label'=>false))?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="ace-icon fa fa-share"></i>
									</span>
									<?php echo $this->Form->password('repassword', array('class'=>'form-control','placeholder'=>'Nhập lại mật khẩu','value'=>isset($password)?$password:'','div'=>false,'label'=>false))?>
								</div>
							</div>
						</div>
						<hr>
						<div>
							<button class="btn btn-lg btn-success" name="btnsave">
								<i class="ace-icon fa fa-check"></i>Lưu dữ liệu
							</button>
						</div>



					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="widget-box transparent" id="windowsContant">
				<div class="widget-header widget-header-flat">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-volume-control-phone"></i>
						Thông tin liên hệ
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						
						<div class="space-8"></div>
						<div class="tabbable">
							<ul class="nav nav-tabs" id="myTab">
								<li class="active">
									<a data-toggle="tab" href="#street" aria-expanded="false">
										<i class="green ace-icon fa fa-street-view bigger-120"></i>Địa chỉ
									</a>
								</li>
								<li>
									<a data-toggle="tab" href="#phone" aria-expanded="true">
										<i class="green ace-icon fa fa-phone bigger-120"></i>
										Số điện thoại
									</a>
								</li>

								<li class="">
									<a data-toggle="tab" href="#facebook" aria-expanded="true">
										<i class="green ace-icon fa fa-facebook bigger-120"></i>
										Facbook
									</a>
								</li>
								<li class="">
									<a data-toggle="tab" href="#gmail" aria-expanded="true">
										<i class="green ace-icon fa fa-google-plus bigger-120"></i>
										Gmail
									</a>
								</li>
								<li class="">
									<a data-toggle="tab" href="#zalo" aria-expanded="true">
										<i class="green ace-icon fa fa-globe bigger-120"></i>
										Zalo
									</a>
								</li>
							</ul>
							<div class="tab-content" style="border: 1px solid #c5d0dc;">
								<div id="street" class="tab-pane fade active in">
									<div class="space-8"></div>
									<div class="row">
										<div class="col-sm-12" id="windowsMsg_Address"></div>
										<div class="col-sm-6">
											<?php echo $this->Form->input('citys', array('options' => $citys,'empty' => '','id'=>'cboCitys','class'=>'chosen-select form-control width-100','data-placeholder'=>'Chọn Tỉnh/Thành phố','div'=>false,'label'=>false))?>
										</div>
										<div class="col-sm-6">
											<?php echo $this->Form->input('region', array('options' => array(),'empty' => '','id'=>'cboRegion','class'=>'chosen-select form-control width-100','data-placeholder'=>'Chọn Quận/Huyện','div'=>false,'label'=>false))?>
										</div>
									</div>
									<div class="space-8"></div>
									<div class="input-group">
										<span class="input-group-addon"><i class="ace-icon fa fa-street-view"></i></span>
										<?php echo $this->Form->input('address',array('placeholder'=>'Số nhà & tên đường','id'=>'txtstreet','class'=>'form-control','div'=>false,'label'=>false))?>
									</div>
									<div class="space-8"></div>
									<div>
										<?php echo $this->Form->textarea('notes',array('placeholder'=>'Ghi chú','id'=>'txtnotes','class'=>'form-control','div'=>false,'label'=>false))?>

									</div>
									<div class="space-8"></div>
									<div>
										<button class="btn btn-sm btn btn-primary" type="button" data-option="saveLoaction">
											<i class="ace-icon fa fa-paper-plane-o bigger-110"></i>
											Lưu địa chỉ
										</button>
									</div>
									<div class="space-8"></div>
									<table id='DataTableCitys' class='table table-striped table-bordered table-hover'>
										<thead>
											<tr>
												<th>STT</th>
												<th>Đường</th>
												<th>Quận/huyện</th>
												<th>Tỉnh/Thành Phố</th>
												<th>Ghi chú</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php echo $DataCitys;?>
										</tbody>
									</table>
								</div>
								<div id="phone" class="tab-pane fade">
									<div class="space-8"></div>
									<div class="row"><div class="col-sm-12" data-option="messages"></div></div>
									<div class="input-group">
										<?php echo $this->Form->input('phone',array('placeholder'=>'Số điện thoại','id'=>'txtphone','class'=>'form-control','div'=>false,'label'=>false))?>
										<span class="input-group-addon"><i class="ace-icon fa fa-phone"></i></span>
									</div>
									<div class="space-8"></div>
									<div>
										<?php echo $this->Form->textarea('notesPhone',array('placeholder'=>'Ghi chú','id'=>'txtnotesPhone','class'=>'form-control','div'=>false,'label'=>false))?>
									</div>
									<div class="space-8"></div>
									<div>
										<button class="btn btn-sm btn btn-primary" type="button" data-textares-id="txtnotesPhone" data-value-id="txtphone" data-key="PHONE" data-option="savecontants">
											<i class="ace-icon fa fa-paper-plane-o bigger-110"></i>
											Lưu số điện thoại
										</button>
									</div>
									<div class="space-8"></div>
									<table id='DataTablePhone' class='table table-striped table-bordered table-hover'>
										<thead>
											<tr>
												<th>STT</th>
												<th>Số điện thoại</th>
												<th>Ghi chú</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php echo $DataPhone;?>
										</tbody>
									</table>
								</div>
								<div id="facebook" class="tab-pane fade">
									<div class="space-8"></div>
									<div class="row"><div class="col-sm-12" data-option="messages"></div></div>
									<div class="input-group">
										<?php echo $this->Form->input('facebook',array('placeholder'=>'Địa chỉ facebook','id'=>'txtfacebook','class'=>'form-control','div'=>false,'label'=>false))?>
										<span class="input-group-addon"><i class="ace-icon fa fa-facebook"></i></span>
									</div>
									<div class="space-8"></div>
									<div>
										<?php echo $this->Form->textarea('notesFacebook',array('placeholder'=>'Ghi chú','id'=>'txtnotesFacebook','class'=>'form-control','div'=>false,'label'=>false))?>
									</div>
									<div class="space-8"></div>
									<div>
										<button class="btn btn-sm btn btn-primary" type="button" data-key="FACEBOOK" data-option="savecontants">
											<i class="ace-icon fa fa-paper-plane-o bigger-110"></i>
											Lưu địa chỉ
										</button>
									</div>
									<div class="space-8"></div>
									<table id='DataTableFacebook' class='table table-striped table-bordered table-hover'>
										<thead>
											<tr>
												<th>STT</th>
												<th>Địa chỉ</th>
												<th>Ghi chú</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php echo $DataFacebook;?>
										</tbody>
									</table>
								</div>

								<div id="gmail" class="tab-pane fade">
									<div class="space-8"></div>
									<div class="row"><div class="col-sm-12" data-option="messages"></div></div>
									<div class="input-group">
										<?php echo $this->Form->input('gmail',array('placeholder'=>'Địa chỉ gmail','id'=>'txtgmail','class'=>'form-control','div'=>false,'label'=>false))?>
										<span class="input-group-addon"><i class="ace-icon fa fa-facebook"></i></span>
									</div>
									<div class="space-8"></div>
									<div>
										<?php echo $this->Form->textarea('notesgmail',array('placeholder'=>'Ghi chú','id'=>'txtnotesgmail','class'=>'form-control','div'=>false,'label'=>false))?>
									</div>
									<div class="space-8"></div>
									<div>
										<button class="btn btn-sm btn btn-primary" type="button" data-key="GMAIL" data-option="savecontants">
											<i class="ace-icon fa fa-paper-plane-o bigger-110"></i>
											Lưu địa chỉ
										</button>
									</div>
									<div class="space-8"></div>
									<table id='DataTableGmail' class='table table-striped table-bordered table-hover'>
										<thead>
											<tr>
												<th>STT</th>
												<th>Địa chỉ</th>
												<th>Ghi chú</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php echo $DataGmail;?>
										</tbody>
									</table>
								</div>

								<div id="zalo" class="tab-pane fade">
									<div class="space-8"></div>
									<div class="row"><div class="col-sm-12" data-option="messages"></div></div>
									<div class="input-group">
										<?php echo $this->Form->input('zalo',array('placeholder'=>'Địa chỉ zalo','id'=>'txtzalo','class'=>'form-control','div'=>false,'label'=>false))?>
										<span class="input-group-addon"><i class="ace-icon fa fa-facebook"></i></span>
									</div>
									<div class="space-8"></div>
									<div>
										<?php echo $this->Form->textarea('noteszalo',array('placeholder'=>'Ghi chú','id'=>'txtnoteszalo','class'=>'form-control','div'=>false,'label'=>false))?>
									</div>
									<div class="space-8"></div>
									<div>
										<button class="btn btn-sm btn btn-primary" type="button" data-key="ZALO" data-option="savecontants">
											<i class="ace-icon fa fa-paper-plane-o bigger-110"></i>
											Lưu địa chỉ
										</button>
									</div>
									<div class="space-8"></div>
									<table id='DataTableZalo' class='table table-striped table-bordered table-hover'>
										<thead>
											<tr>
												<th>STT</th>
												<th>Địa chỉ</th>
												<th>Ghi chú</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php echo $DataZalo;?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
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
<script src="/assets/js/jquery.jqGrid.min.js"></script>
<script src="/assets/js/grid.locale-en.js"></script>
<script src="/assets/js/bootbox.min.js"></script>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	function removeParrentTr(ele){
		if (ele[0] != null){
			if(ele[0].nodeName.toLowerCase()=='tr'){ ele.remove();return; }
			else findParrentTr(ele.parent());
		}
		return null;
	}
	function load($val){
		if($val==='hidden'){
			$('#windowsContant').removeClass("position-relative");
			$('#windowsContant').find('.widget-box-overlay').remove();
		}
		else{
			$('#windowsContant').addClass("position-relative");
			$('#windowsContant').append('<div class="widget-box-overlay"><i class=" ace-icon loading-icon fa fa-spinner fa-spin fa-2x white"></i></div>')
		}
	}
	$('#txtavatar').ace_file_input({
		no_file:'Chọn hình ảnh',
		btn_choose:'Chọn',
		btn_change:'Đổi ảnh',
		droppable:false,
		onchange:null,
		thumbnail:false, //| true | large
		whitelist:'gif|png|jpg|jpeg'
	});
	$('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	$(document).ready(function () {
		$( "#cboCitys" ).change(function() {
			$.ajax({
                type: 'POST',
                url: "/api/v2/data/select-region.json",
                data: {
                    citys: $('#cboCitys').val(),
                },
                success: function (data) {
                    if (data.result != null) {
                    	$('#cboRegion option').each(function() {$(this).remove();});
						$('#cboRegion').append($('<option>', { value: '',text : ''}));
                        $.each(data.result, function (i, item) {
						    $('#cboRegion').append($('<option>', { 
						        value: item.id,
						        text : item.name 
						    }));
						});
						$('#cboRegion').trigger("chosen:updated");
                    }
                    else {
                    	$('#WindowsMsg').after('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-chain-broken green"></i>Lỗi kết nối server</div>');
                    }

                },
                error: function () {
                    $('#WindowsMsg').after('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-chain-broken green"></i>Lỗi kết nối server</div>');
                }
            });
		});
		$('button[data-option="saveLoaction"]').on('click', function (e) {
			load('show');
			 $.ajax({
                type: 'POST',
                url: "/api/v2/data/saveaddress.json",
                data: {
                    street: $('#txtstreet').val(),
                    region:$('#cboRegion').val(),
                    citys:$('#cboCitys').val(),
                    user:'<?php echo $user_id?>',
                    note:$('#txtnotes').val(),
                    byUser:'<?php echo $current_User; ?>'
                },
                success: function (data) {
                    if (data.error != null) {
                    	html =  '<div class="alert alert-danger" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><ul>';
                    	$.each(data.error,function(index, value){
                    		html+='<li>'+value+'</li>';
                    	});
                    	$('#windowsMsg_Address').html(html+'</ul></div>');
                    }
                    else {
                    	if (data.success != null) {
                    		$('#windowsMsg_Address').html('<div class="alert alert-info" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-check" aria-hidden="true"></i>Lưu thành công<br></div>');
                    		STT = $('#DataTableCitys').find('tbody').find('tr').length+1;
                    		html='<tr class="'+(STT%2==0?'even pointer':'odd pointer')+'" data-id="'+data.success+'">';
                    		html+='<td>' + STT + '</td>';
                    		html+='<td>' + $('#txtstreet').val() + '</td>';
                    		html+='<td>' + $("#cboRegion option:selected").html() + '</td>';
                    		html+='<td>' + $("#cboCitys option:selected").html() + '</td>';
                    		html+='<td>' + $('#txtnotes').val() + '</td>';
                    		html+='<td><div class="hidden-sm hidden-xs action-buttons"><a class="red" data-option="removeAddress" href="javascript:void()" data-id="'+data.success+'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div></td><div class="hidden-md hidden-lg"><div class="inline pos-rel"><button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"><li><a href="javascript:void()" "'+data.success+'" data-option="removeAddress"  class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i</span></a></li></ul></div></div></tr>';
                    		$('#DataTableCitys').find('tbody').append(html);
                    	}
                    }
                    load('hidden');
                    return;
                },
                error: function () {
                    $('#windowsMsg_Address').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-times" aria-hidden="true"></i>lỗi kết nối server<br></div>');
                }
            });
		});
		$('a[data-option="removeAddress"]').on('click', function (e) {
			$this = $(this);
			bootbox.confirm({
				message: "Dữ liệu đã xóa sẽ không thể phục hồi. Bạn có chắc không ?",
				buttons: {
				  confirm: {
					 label: "Xóa",
					 className: "btn-primary btn-sm",
				  },
				  cancel: {
					 label: "hủy",
					 className: "btn-sm",
				  }
				},
				callback: function(result) {
					if(result){
						load('show');
						 $.ajax({
			                type: 'POST',
			                url: "/api/v2/data/remove-address.json",
			                data: {
			                    id: $this.attr('data-id'),
			                    byUser:'<?php echo $current_User; ?>'
			                },
			                success: function (data) {
			                    if (data.error != null) {
			                    	$('#windowsMsg_Address').html('<div class="alert alert-danger" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Xóa dữ liệu thất bại</div>');
			                    }
			                    else {
			                    	if (data.success != null) {
			                    		$('#windowsMsg_Address').html('<div class="alert alert-info" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-check" aria-hidden="true"></i>Xóa thành công<br></div>');
			                    		removeParrentTr($this);
			                    	}
			                    }
			                    load('hidden');
			                    return;
			                },
			                error: function () {
			                    $('#windowsMsg_Address').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-times" aria-hidden="true"></i>lỗi kết nối server<br></div>');
			                }
			            });
					}
				}
			});
		});
		$('button[data-option="savecontants"]').on('click', function (e) {
			$this = $(this);
			$input = $(this).parent().parent().find('input[class="form-control"]');
			$textarea = $(this).parent().parent().find('textarea[class="form-control"]');
			$message = $this.parent().parent().find('div[data-option="messages"]');
			$tables = $this.parent().parent().find('table');
			load('show');
			$.ajax({
                type: 'POST',
                url: "/api/v2/data/save-contant.json",
                data: {
                	value : $input.val(),
                    key : $this.attr('data-key'),
                    byUser : '<?php echo $current_User; ?>',
                    user : '<?php echo $user_id?>',
                    node : $textarea.val()
                },
                success: function (data) {
                    if (data.error != null) {
                    	html = '<div class="alert alert-danger" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><ul>';
                    	$.each(data.error,function(index, value){
                    		html+='<li>'+value+'</li>';
                    	});
                    	$message.html(html+'</ul></div>');
                    }
                    else {
                    	if (data.success != null) {
                    		STT = $tables.find('tbody').find('tr').length+1;
                    		html = '<tr class="'+(STT%2==0?'even pointer':'odd pointer')+'">';
                    		html += '<td>'+STT+'</td>';
                    		html += '<td>'+$input.val()+'</td>';
                    		html += '<td>'+$textarea.val()+'</td>';
                    		html += '<td><a class="red" href="javascript:void(0);" data-option="removecontants" data-id="'+data.success+'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td>';
                    		html +='</tr>';
                    		$tables.append(html);
                    		$message.html('<div class="alert alert-info" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-check" aria-hidden="true"></i>Thêm thành công<br></div>');
                    	}
                    }
                    load('hidden');
                    return;
                },
                error: function () {
                    $message.html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-times" aria-hidden="true"></i>lỗi kết nối server<br></div>');
                }
            });
		});
		$('a[data-option="removecontants"]').on('click', function (e) {
			$this = $(this);
			$message = $this.parent().parent().find('div[data-option="messages"]');
			bootbox.confirm({
				message: "Dữ liệu đã xóa sẽ không thể phục hồi. Bạn có chắc không ?",
				buttons: {
				  confirm: {
					 label: "Xóa",
					 className: "btn-primary btn-sm",
				  },
				  cancel: {
					 label: "hủy",
					 className: "btn-sm",
				  }
				},
				callback: function(result) {
					if(result){
						load('show');
						 $.ajax({
			                type: 'POST',
			                url: "/api/v2/data/remove-contant.json",
			                data: {
			                    id: $this.attr('data-id'),
			                    byUser:'<?php echo $current_User; ?>'
			                },
			                success: function (data) {
			                    if (data.error != null) {
			                    	$message.html('<div class="alert alert-danger" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Xóa dữ liệu thất bại</div>');
			                    }
			                    else {
			                    	if (data.success != null) {
			                    		$this.parent().parent().remove();
			                    		$message.html('<div class="alert alert-info" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-check" aria-hidden="true"></i>Xóa thành công<br></div>');
			                    	}
			                    }
			                    load('hidden');
			                    return;
			                },
			                error: function () {
			                    $message.html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="fa fa-times" aria-hidden="true"></i>lỗi kết nối server<br></div>');
			                }
			            });
					}
				}
			});
		});
		if(!ace.vars['touch']) {
			$('.chosen-select').chosen({allow_single_deselect:true}); 
	
			$(window)
			.off('resize.chosen')
			.on('resize.chosen', function() {
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': $this.parent().width()});
				})
			}).trigger('resize.chosen');
			//resize chosen on sidebar collapse/expand
			$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
				if(event_name != 'sidebar_collapsed') return;
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': $this.parent().width()});
				})
			});
		}
		$('#DataTableCitys').dataTable({
			bAutoWidth: false,
			'aoColumns': [
				null,null,null,null,null,
				{ 'bSortable': false }
			],
			'aaSorting': [],
		});
		$('#DataTablePhone,#DataTableFacebook,#DataTableGmail,#DataTableZalo').dataTable({
			bAutoWidth: false,
			'aoColumns': [
				null,null,null,
				{ 'bSortable': false }
			],
			'aaSorting': [],
		});
	});
</script>