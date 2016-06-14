<?php
	App::uses('Model', 'User');
	$this->User = new User();
?>
<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<link rel="stylesheet" href="/assets/css/jquery-ui.custom.min.css" />
<link rel="stylesheet" href="/assets/css/chosen.min.css" />
<link rel="stylesheet" href="/assets/css/jquery.treetable.css" />
<link rel="stylesheet" href="/assets/css/jquery.treetable.theme.default.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-switch.min.css" />
<style type="text/css">
	.ace-spinner{
		margin-left: 5px;
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
<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Quản lý loại sản phẩm</li>
	</ul>
</div>
<div class="page-content">
	<?php echo $this->Session->flash();?>
	<div class="row">
		<div class="col-sm-4">
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
				<?php echo $this->Form->create('Categorys', array('Controller' => 'Categorys','Action'=>'index','method'=>'post','class'=>'form-horizontal')); ?>
					<div class="input-group">
						<?php echo $this->Form->input('name',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Tên loại','value' =>(isset($name)?$name:'')));?>
						<div style="display: table-cell;width: 1%;white-space: nowrap;vertical-align: middle;">
							<?php echo $this->Form->input('index',array('class'=>'form-control','div'=>false,'id'=>'txtindex','label'=>false,'value' =>(isset($index)?$index:'')));?>
						</div>
					</div>
					<hr>
					<div>
						<select name="cbomenu" id="cbomenu" class="form-control chosen-select">
							<option value="0">Menu chính</option>
							<?php echo $optionMenu?>
						</select>
					</div>
					<hr>
					<div>
						<?php echo $this->Form->textarea('nodes',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Ghi chú','value' =>(isset($nodes)?$nodes:'')));?>
					</div>
					<hr>
					<div>
						<button name="btnsave" class="btn btn-lg btn-primary">Lưu dữ liệu</button>
					</div>
				<?php $this->Form->end()?>
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
						<table id="DataTables" class="table table-bordered table-striped">
							<thead>
					          <tr>
					            <th>Tên loại</th>
					            <th>Vị trí</th>
					            <th>Kích hoạt</th>
					            <th>Ghi chú</th>
					            <th>Ngày tạo</th>
					            <th>Người tạo</th>
					            <th></th>
					          </tr>
					        </thead>
							<tbody>
								<?php echo $DataTables;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script src="/assets/js/fuelux.spinner.min.js"></script>
<script src="/assets/js/chosen.jquery.min.js"></script>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script src="/assets/js/jquery.treetable.js"></script>

<script src="http://www.bootstrap-switch.org/dist/js/bootstrap-switch.js"></script>



<script type="text/javascript">
    $(function(){
    	$('input[data-option="active"]').bootstrapSwitch();

    	$('input[data-option="active"]').on('switchChange.bootstrapSwitch', function(event, state) {

    		


			console.log(this); // DOM element
			console.log(event); // jQuery event
			console.log(state); // true | false



			
		});


      	$("#DataTables").treetable({ expandable: true });
    	$('#txtindex').ace_spinner({value:0,min:0,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
		.closest('.ace-spinner')
		.on('changed.fu.spinbox', function(){
			//alert($('#spinner1').val())
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