<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<link rel="stylesheet" href="/assets/css/jquery-ui.custom.min.css" />
<link rel="stylesheet" href="/assets/css/chosen.min.css" />
<link rel="stylesheet" href="/assets/css/datepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="/assets/css/daterangepicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="/assets/css/colorpicker.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-switch.min.css" />
<link rel="stylesheet" href="/assets/css/jstree.css" />
<link rel="stylesheet" href="/assets/plugin/jstree/dist/themes/default/style.min.css" />
<style type="text/css">
	.ace-spinner{
		width: 100% !important;
	}
</style>
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li>
			<a href="#">Quản lý sản phẩm</a>
		</li>
		<li class="active">Thêm sản phẩm</li>
	</ul>
</div>
<div class="page-content">
	<?php echo $this->Session->flash();?>
	<?php echo $this->Form->create('product', array('Controller' => 'Product','Action'=>'add','type'=>'file','class'=>'form-horizontal')) ?>
	<div class="row">
		<div class="col-sm-8">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Thông tin cơ bản
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<div class="row">
						<div class="col-sm-8">
							<label for="txtname">Tên sản phẩm</label>
							<?php echo $this->Form->input('name',array('class'=>'form-control','div'=>false,'id'=>'txtname','label'=>false,'placeholder'=>'Tên sản phẩm'));?>
						</div>
						<div class="col-sm-4">
							<label for="txtcode">Mã sản phẩm</label>
							<?php echo $this->Form->input('code',array('class'=>'form-control','div'=>false,'id'=>'txtcode','label'=>false,'placeholder'=>'Mã sản phẩm'));?>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-3">
							<label for="txtpriceCode">Giá gốc</label>
							<?php echo $this->Form->input('priceCode',array('class'=>'form-control','div'=>false,'id'=>'txtpriceCode','label'=>false,'placeholder'=>'Giá gốc'));?>
						</div>
						<div class="col-sm-3">
							<label for="txtpriceSelling">Giá bán</label>
							<?php echo $this->Form->input('priceSelling',array('class'=>'form-control','div'=>false,'id'=>'txtpriceSelling','label'=>false,'placeholder'=>'Giá bán thực tế'));?>
						</div>
						<div class="col-sm-3">
							<label for="txtpriceSale">Giá Khuyến mãi</label>
							<?php echo $this->Form->input('priceSale',array('class'=>'form-control','div'=>false,'id'=>'txtpriceSale','label'=>false,'placeholder'=>'Giá Khuyến mãi'));?>
						</div>
						<div class="col-sm-3">
							<label for="txtdeadlineSale">Hạn chót</label>
							<?php echo $this->Form->input('deadlineSale',array('class'=>'form-control','div'=>false,'id'=>'txtdeadlineSale','label'=>false,'placeholder'=>'Thời hạn khuyến mãi'));?>
						</div>
					</div>

					<hr>
					<div class="row">
						<div class="col-sm-6">
							<label for="txtnumberVirtual">Số lượng ảo</label>
							<?php echo $this->Form->input('numberVirtual',array('class'=>'spinbox-input form-control text-center','div'=>false,'id'=>'txtnumberVirtual','label'=>false,'placeholder'=>'Giá bán thực tế'));?>
						</div>
						<div class="col-sm-6">
							<label for="txtnumberSellVirtual">Số lượng người mua ảo</label>
							<?php echo $this->Form->input('numberSellVirtual',array('class'=>'spinbox-input form-control text-center','div'=>false,'id'=>'txtnumberSellVirtual','label'=>false,'placeholder'=>'Giá Khuyến mãi'));?>
						</div>
					</div>
					<hr>
					<div>
						<ul id="tasks" class="item-list ui-sortable">
							<li class="item-orange clearfix ui-sortable-handle">
								<label class="inline">
									<?php echo $this->Form->checkbox('productHot',array('class'=>'ace','div'=>false,'id'=>'chkproductHot','label'=>false));?>
									<span class="lbl"> Sản phẩm thuộc nhóm sản phẩm hót</span>
								</label>
							</li>

							<li class="item-red clearfix ui-sortable-handle">
								<label class="inline">
									<?php echo $this->Form->checkbox('productSelling',array('class'=>'ace','div'=>false,'id'=>'chkproductSelling','label'=>false));?>
									<span class="lbl"> Sản phẩm thuộc nhóm sản phẩm bán chạy</span>
								</label>
							</li>
							<li class="item-default clearfix ui-sortable-handle">
								<label class="inline">
									<?php echo $this->Form->checkbox('Showslide',array('class'=>'ace','div'=>false,'id'=>'chkShowslide','label'=>false));?>
									<span class="lbl"> Tích vào đây nếu muốn sản phẩm này hiện ở "Slide trang chủ".</span>
								</label>
							</li>
						</ul>
					</div>
					
				</div>
			</div>
			<div class="space-8"></div>
			<div class="hr hr-double dotted"></div>
			<div class="space-8"></div>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Mô tả sản phẩm
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<div>
						<label for="txtshortDescription">Mô tả ngắn</label>
						<div class="wysiwyg-editor" id="txtshortDescription" data-option="Description" style="border-width: 1px !important;height: 150px;">
							<?php echo isset($shortDescription)?$shortDescription:''; ?>
						</div>
						<?php echo $this->Form->textarea('shortDescription',array('class'=>'form-control','id'=>'txtshortDescriptionHidden','placeholder'=>'Mô tả ngắn','style'=>'display: none;'));?>
					</div>
					<hr>
					<div>
						<label for="txtDescriptionDetail">Mô tả chi tiết</label>
						<div class="wysiwyg-editor" id="txtDescriptionDetail" data-option="Description" style="border-width: 1px !important;height: 300px;">
							<?php echo isset($DescriptionDetail)?$DescriptionDetail:''; ?>
						</div>
						<?php echo $this->Form->textarea('DescriptionDetail',array('class'=>'form-control','id'=>'txtDescriptionDetailHidden','placeholder'=>'Mô tả chi tiết','style'=>'display: none;'));?>
					</div>
				</div>
			</div>
			<div class="space-8"></div>
			<div class="hr hr-double dotted"></div>
			<div class="space-8"></div>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Chi tiết sản phẩm
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<div class="row"><div class="col-sm-12" id="windowsMsgInformation"></div></div>
					<div class="row">
						<div class="col-sm-3" id="windownInfomationName">
							<input type="text" class="form-control" placeholder="Tên thông tin" id="txtinfomationName">
							
						</div>
						<div class="col-sm-7" id="windowninfomationDetail">
							<input type="text" class="form-control" placeholder="chi tiết" id="txtinfomationDetail">
						</div>
						<div class="col-sm-2">
							<button class="btn btn-primary btn-sm btn-block" type="button" data-option="addInformation">Thêm</button>
						</div>
					</div>
					<hr>
					<div>
						<table id="tableInfomation" class="table table-bordered table-striped">
							<thead class="thin-border-bottom">
								<tr>
									<th style="width:20%"> Tên Thông tin</th>
									<th style="width:70%">Chi tiết</th>
									<th style="width:10%"></th>
								</tr>
							</thead>
							<tbody>
								<?php for($i=0;$i<count($infomationName);$i++):?>
									<?php if (isset($infomationDetail[$i]) && isset($infomationName[$i])): ?>
										<tr>
											<td><?php echo isset($infomationName[$i])?$infomationName[$i]:''?></td>
											<td><?php echo isset($infomationDetail[$i])?$infomationDetail[$i]:''?></td>
											<td>
												<input type="hidden" name="data[product][infomationName][]" value="<?php echo $infomationName[$i] ?>">
												<input type="hidden" name="data[product][infomationDetail][]" value="<?php echo $infomationDetail[$i] ?>">
												<div class="hidden-sm hidden-xs action-buttons">
													<a href="javascript:void(0)" class="red" data-option="removeInfomation">
														<i class="ace-icon fa fa-trash-o bigger-130"></i>
													</a>
												</div>
											</td>
										</tr>
									<?php endif ?>
								<?php endfor;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Ảnh đại diện
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<?php echo $this->Form->file('thumbnail',array('class'=>'form-control','id'=>'imgThumbnail','div'=>false,'label'=>false));?>
				</div>
			</div>
			<div class="space-8"></div>
			<div class="hr hr-double dotted"></div>
			<div class="space-8"></div>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Slide Hình ảnh
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<?php echo $this->Form->file('thumbnailSlide.',array('class'=>'form-control','id'=>'imgthumbnailSlide','div'=>false,'label'=>false,'multiple'=>'multiple'));?>
				</div>
			</div>

			<div class="space-8" data-type="slideImage" style="display:none"></div>
			<div class="hr hr-double dotted" data-type="slideImage" style="display:none"></div>
			<div class="space-8" data-type="slideImage" style="display:none"></div>
			<div class="widget-box transparent" data-type="slideImage" style="display:none">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Slide trang chủ
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<?php echo $this->Form->file('slideImage',array('class'=>'form-control','id'=>'imgslideImage','div'=>false,'label'=>false));?>
				</div>
			</div>
			<div class="space-8"></div>
			<div class="hr hr-double dotted"></div>
			<div class="space-8"></div>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Loại sản phẩm
					</h4>
				</div>
				<div class="widget-body" id="windowsCategory">
					<div class="space-8"></div>
					<div id="jstree-checkable"></div>
				</div>
			</div>
			<div class="space-8"></div>
			<div class="hr hr-double dotted"></div>
			<div class="space-8"></div>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Thông tin SEO
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<div>
						<label for="txtseoTitle">Tiêu đề - Title</label>
						<?php echo $this->Form->textarea('seoTitle',array('class'=>'form-control','id'=>'txtseoTitle','placeholder'=>'Tiêu đề SEO'));?>
					</div>
					<hr>
					<div>
						<label for="txtseoKeyword">Từ khóa - Keyword</label>
						<?php echo $this->Form->textarea('seoKeyword',array('class'=>'form-control','id'=>'txtseoKeyword','placeholder'=>'Từ khóa SEO'));?>
					</div>
					<hr>
					<div>
						<label for="txtseoDescription">Mô tả - Description</label>
						<?php echo $this->Form->textarea('seoDescription',array('class'=>'form-control','id'=>'txtseoDescription','placeholder'=>'Mô tả SEO'));?>
					</div>
				</div>
			</div>
			<div class="space-8"></div>
			<div class="hr hr-double dotted"></div>
			<div class="space-8"></div>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Lưu trữ dữ liệu
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-8"></div>
					<label>Thời gian hiển thị</label>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->input('dateShow',array('class'=>'form-control','div'=>false,'id'=>'txtdateShow','label'=>false,'placeholder'=>'Từ ngày','value' =>(isset($name)?$name:'')));?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->input('dateHidden',array('class'=>'form-control','div'=>false,'id'=>'txtdateShow','label'=>false,'placeholder'=>'Đến ngày','value' =>(isset($name)?$name:'')));?>
						</div>
					</div>
					<hr>
					<button class="btn btn-lg btn-success" name="btnsave">
						<i class="ace-icon fa fa-check"></i>
						Lưu sản phẩm
					</button>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end()?>
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
		$('input[data-option="active"]').bootstrapSwitch();
		$('#txtdeadlineSale,#txtdateShow').datetimepicker().next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		$('.spinbox-input').ace_spinner({value:0,min:0,max:10000,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		function showErrorAlert (reason, detail) {
			var msg='';
			if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
			else {
			}
			$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
			 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
		}
		$('div[data-option="Description"]').ace_wysiwyg({
			toolbar:
			[
				'font',
				null,
				'fontSize',
				null,
				{name:'bold', className:'btn-info'},
				{name:'italic', className:'btn-info'},
				{name:'strikethrough', className:'btn-info'},
				{name:'underline', className:'btn-info'},
				null,
				{name:'insertunorderedlist', className:'btn-success'},
				{name:'insertorderedlist', className:'btn-success'},
				{name:'outdent', className:'btn-purple'},
				{name:'indent', className:'btn-purple'},
				null,
				{name:'justifyleft', className:'btn-primary'},
				{name:'justifycenter', className:'btn-primary'},
				{name:'justifyright', className:'btn-primary'},
				{name:'justifyfull', className:'btn-inverse'},
				null,
				{name:'createLink', className:'btn-pink'},
				{name:'unlink', className:'btn-pink'},
				null,
				{name:'insertImage', className:'btn-success'},
				null,
				'foreColor',
				null,
				{name:'undo', className:'btn-grey'},
				{name:'redo', className:'btn-grey'}
			],
			'wysiwyg': {
				fileUploadError: showErrorAlert
			}
		}).prev().addClass('wysiwyg-style2');
		$('[data-toggle="buttons"] .btn').on('click', function(e){
			var target = $(this).find('input[type=radio]');
			var which = parseInt(target.val());
			var toolbar = $('#editor1').prev().get(0);
			if(which >= 1 && which <= 4) {
				toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
				if(which == 1) $(toolbar).addClass('wysiwyg-style1');
				else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
				if(which == 4) {
					$(toolbar).find('.btn-group > .btn').addClass('btn-white btn-round');
				} else $(toolbar).find('.btn-group > .btn-white').removeClass('btn-white btn-round');
			}
		});
		if ( typeof jQuery.ui !== 'undefined' && ace.vars['webkit'] ) {
			
			var lastResizableImg = null;
			function destroyResizable() {
				if(lastResizableImg == null) return;
				lastResizableImg.resizable( "destroy" );
				lastResizableImg.removeData('resizable');
				lastResizableImg = null;
			}

			var enableImageResize = function() {
				$('.wysiwyg-editor')
				.on('mousedown', function(e) {
					var target = $(e.target);
					if( e.target instanceof HTMLImageElement ) {
						if( !target.data('resizable') ) {
							target.resizable({
								aspectRatio: e.target.width / e.target.height,
							});
							target.data('resizable', true);
							
							if( lastResizableImg != null ) {
								//disable previous resizable image
								lastResizableImg.resizable( "destroy" );
								lastResizableImg.removeData('resizable');
							}
							lastResizableImg = target;
						}
					}
				})
				.on('click', function(e) {
					if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
						destroyResizable();
					}
				})
				.on('keydown', function() {
					destroyResizable();
				});
		    }
			enableImageResize();
		}
		$('button[data-option="addInformation"]').on('click', function () {
			$err = '';
			if($('#txtinfomationName').val().trim().length==0) $err += '<li>Bạn cần nhập tên thông tin</li>';
			if($('#txtinfomationDetail').val().trim().length==0) $err += '<li>Bạn cần nhập thông tin chi tiết</li>';
			if($err.length==0){
				$html='<tr>';
					$html += '<td>'+$('#txtinfomationName').val()+'</td>';
					$html += '<td>'+$('#txtinfomationDetail').val()+'</td>';
					$html += '<td>';
						$html += '<input type="hidden" name="data[product][infomationName][]" value="'+$('#txtinfomationName').val()+'">';
						$html += '<input type="hidden" name="data[product][infomationDetail][]" value="'+$('#txtinfomationDetail').val()+'">';
						$html += '<div class="hidden-sm hidden-xs action-buttons">';
							$html += '<a href="javascript:void(0)" class="red" data-option="removeInfomation">';
								$html += '<i class="ace-icon fa fa-trash-o bigger-130"></i>';
							$html += '</a>';
						$html += '</div>';
					$html += '</td>';
				$html+='</tr>';
				$('#tableInfomation').append($html);
			} else {
				$('#windowsMsgInformation').html('<div class="alert alert-danger" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><ul>' + $err + '</ul></div>');
			}
		});
		$('a[data-option="removeInfomation"]').on('click', function () {
			$(this).parent().parent().parent().remove();
		});
		$('#imgThumbnail').ace_file_input({
			style:'well',
			btn_choose:'Chọn hình một đại diện (800 x 781)',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'large',
			allowExt : ["jpeg", "jpg", "png", "gif" , "bmp"],
			allowMime : ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"]//large | fit
			//,icon_remove:null//set null, to hide remove/reset button
			/**,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}*/
			/**,before_remove : function() {
				return true;
			}*/
			,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}
		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
		});
		$('#imgthumbnailSlide').ace_file_input({
			style:'well',
			btn_choose:'Chọn danh sách hình ảnh (800 x 781)',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'small',
			allowExt : ["jpeg", "jpg", "png", "gif" , "bmp"],
			allowMime : ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"]//large | fit
			//,icon_remove:null//set null, to hide remove/reset button
			/**,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}*/
			/**,before_remove : function() {
				return true;
			}*/
			,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}
		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
		});
		$('#imgslideImage').ace_file_input({
			style:'well',
			btn_choose:'Chọn một hình ảnh đại diện (1170 x 495)',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'small',
			allowExt : ["jpeg", "jpg", "png", "gif" , "bmp"],
			allowMime : ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"]//large | fit
			//,icon_remove:null//set null, to hide remove/reset button
			/**,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}*/
			/**,before_remove : function() {
				return true;
			}*/
			,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}
		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
		});
		$("#chkShowslide").change(function() {
		    if(this.checked) {
		    	$('div[data-type="slideImage"]').attr('style','');
		    }
		    else{
		    	$('div[data-type="slideImage"]').css('display','none');
		    }
		});
		$('#jstree-checkable').jstree({
	        'plugins': ["wholerow", "checkbox", "types"],
	        'core': {
	            "themes": {
	                "responsive": false
	            },    
	            'data': <?php echo $categoryTreeView; ?>
	        },
	        "types": {
	            "default": {
	                "icon": "fa fa-folder text-primary fa-lg"
	            },
	            "file": {
	                "icon": "fa fa-file text-success fa-lg"
	            }
	        }
	    });
		$("form").submit( function(event) {
			var checked_ids = [];
			$('#txtshortDescriptionHidden').val($('#txtshortDescription').html());
			$('#txtDescriptionDetailHidden').val($('#txtDescriptionDetail').html());
			$("#jstree-checkable").find(".jstree-undetermined").each(function (i, element) {
				$('#windowsCategory').append('<input type="hidden" name="data[product][category][]" value="'+$(element).attr("id")+'">');
	        });
	        var selectedElements = $('#jstree-checkable').jstree("get_selected", true);
	        $.each(selectedElements, function () {
	        	$('#windowsCategory').append('<input type="hidden" name="data[product][category][]" value="'+this.id+'">');
	        });
		});
	});
</script>