<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<link rel="stylesheet" href="/assets/css/jquery-ui.custom.min.css" />
<link rel="stylesheet" href="/assets/css/chosen.min.css" />
<link rel="stylesheet" href="/assets/css/datepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="/assets/css/daterangepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="/assets/css/colorpicker.min.css" />
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
		<?php
			echo $this->Form->create('Users', array('Controller' => 'Users','Action'=>'add','method'=>'post','enctype'=>'multipart/form-data','class'=>'form-horizontal'));
			echo '<div class="col-sm-4">';
			echo '<div class="widget-box transparent">';
			echo '<div class="widget-header widget-header-flat">';
			echo '<h4 class="widget-title lighter">';
			echo '<i class="ace-icon fa fa-file-image-o"></i>';
			echo 'Thông tin cơ bản';
			echo '</h4>';
			echo '</div>';

			echo '<div class="widget-body">';
			echo '<div class="widget-main no-padding">';
			echo '<div class="space-8"></div>';
			echo $this->Form->input('image',array('type'=>"file",'id'=>"txtavatar",'div'=>false,'label'=>false));
			echo '<hr>';
			echo '<div class="row">';
			echo '<div class="col-xs-6">';
			echo $this->Form->input('first_name',array('placeholder'=>'Họ và tên đệm','class'=>'form-control','div'=>false,'label'=>false));
			echo '</div>';
			echo '<div class="col-xs-6">';
			echo $this->Form->input('last_name',array('placeholder'=>'Tên','class'=>'form-control','div'=>false,'label'=>false));
			echo '</div></div>';


			echo '<hr><div class="input-group"><div class="input-group" style="width: 100%;">'.$this->Form->input('fullname',array('placeholder'=>'Sinh nhật','class'=>'form-control date-picker','div'=>false,'label'=>false,'data-date-format'=>'yyyy-mm-dd')).'<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span></div>';


			echo '<label style="display: table-cell;width: 1%;white-space: nowrap;vertical-align: middle;">'.$this->Form->checkbox('Gender', array('class'=>'ace ace-switch ace-switch-4 btn-flat'));
			echo '<span class="lbl"></span></label></div>';

			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '<div class="col-sm-8">';
			echo '<div class="row"><div class="col-sm-12">';
			echo '<div class="widget-box transparent">';
			echo '<div class="widget-header widget-header-flat">';
			echo '<h4 class="widget-title lighter">';
			echo '<i class="ace-icon fa fa-info"></i>';
			echo 'Thông tin liên hệ';
			echo '</h4>';
			echo '</div>';
			echo '<div class="widget-body">';
			echo '<div class="widget-main no-padding">';
			echo '<div class="space-8"></div>';
			echo '<div class="row">';
			echo '<div class="col-sm-6">';
			echo $this->Form->input('citys', array('options' => $citys,'empty' => '','id'=>'cboCitys','class'=>'chosen-select form-control','data-placeholder'=>'Chọn Tỉnh/Thành phố','div'=>false,'label'=>false)).'</div>';
			echo '<div class="col-sm-6">';
			echo $this->Form->input('region', array('options' => array(),'empty' => '','id'=>'cboRegion','class'=>'chosen-select form-control','data-placeholder'=>'Chọn Quận/Huyện','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '<div class="space-8"></div><div class="input-group">'.$this->Form->input('address',array('placeholder'=>'Số nhà & tên đường','class'=>'form-control','div'=>false,'label'=>false)).'<span class="input-group-addon"><i class="ace-icon fa fa-map-marker"></i></span></div>';
			echo '</div>';
			echo '<hr>';
			echo '<div class="row">';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-phone"></i></span>';
			echo $this->Form->input('phone', array('class'=>'form-control','placeholder'=>'Số điện thoại','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-facebook"></i></span>';
			echo $this->Form->input('facebook', array('class'=>'form-control','placeholder'=>'địa chỉ Facebook','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '</div>';


			echo '<hr><div class="row">';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-google-plus"></i></span>';
			echo $this->Form->input('gmail', array('class'=>'form-control','placeholder'=>'Gmail','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-globe"></i></span>';
			echo $this->Form->input('zalo', array('class'=>'form-control','placeholder'=>'địa chỉ zalo','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '</div>';

			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';


			echo '<div class="hr hr32 hr-dotted"></div><div class="row"><div class="col-sm-12">';
			echo '<div class="widget-box transparent">';
			echo '<div class="widget-header widget-header-flat">';
			echo '<h4 class="widget-title lighter">';
			echo '<i class="ace-icon fa fa-info"></i>';
			echo 'Thông tin tài khoản';
			echo '</h4>';
			echo '</div>';
			echo '<div class="widget-body">';
			echo '<div class="widget-main no-padding">';
			echo '<div class="space-8"></div>';


			echo '<div class="row">';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-user"></i></span>';
			echo $this->Form->input('username', array('class'=>'form-control','placeholder'=>'Tài khoản','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-at"></i></span>';
			echo $this->Form->input('mail', array('class'=>'form-control','placeholder'=>'Địa chỉ mail','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '</div>';

			echo '<hr><div class="row">';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-key"></i></span>';
			echo $this->Form->password('password', array('class'=>'form-control','placeholder'=>'Mật khẩu','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '<div class="col-sm-6">';
			echo '<div class="input-group"><span class="input-group-addon"><i class="ace-icon fa fa-share"></i></span>';
			echo $this->Form->password('repassword', array('class'=>'form-control','placeholder'=>'Nhập lại mật khẩu','div'=>false,'label'=>false)).'</div>';
			echo '</div>';
			echo '</div>';

			echo '<hr><div class="row">';
			echo '<div class="col-sm-6">';
			echo $this->Form->input('authorities', array('options' => $authorities,'empty' => '','class'=>'chosen-select form-control','data-placeholder'=>'Chọn nhóm phân quyền','div'=>false,'label'=>false));
			echo '</div>';
			echo '</div>';





			echo '</div>';
			echo '<hr><div><button class="btn btn-lg btn-success" name="btnsave"><i class="ace-icon fa fa-check"></i>Lưu dữ liệu</button>';
			echo '<a href="'.Router::url( array('controller'=>'Users','action'=>'index'), true ).'" class="btn btn-lg btn-danger" style="margin-left: 5px;"><i class="ace-icon fa fa-reply-all"></i>Trở về</a></div>';
			echo '</div></div>';
		?>
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
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	$('#txtavatar').ace_file_input({
		style:'well',
		btn_choose:'Chọn hình ảnh upload',
		btn_change:null,
		no_icon:'ace-icon fa fa-cloud-upload',
		droppable:true,
		thumbnail:'fit'
	}).on('change', function(){
	});
	$('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true
	})
	.next().on(ace.click_event, function(){
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
	});
</script>