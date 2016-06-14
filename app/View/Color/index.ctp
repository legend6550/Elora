<?php
	App::uses('Model', 'User');
	$this->User = new User();
?>
<link href="/assets/plugin/colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="/assets/plugin/colorpicker/dist/css/bootstrap-colorpicker-plus.css" rel="stylesheet">
<style type="text/css">
    .color-fill-icon{display:inline-block;width:16px;height:16px;border:1px solid #000;background-color:#fff;margin: 2px;}
    .dropdown-color-fill-icon{position:relative;float:left;margin-left:0;margin-right: 0}
	.well .markup{
		background: #fff;
		color: #777;
		position: relative;
		padding: 45px 15px 15px;
		margin: 15px 0 0 0;
		background-color: #fff;
		border-radius: 0 0 4px 4px;
		box-shadow: none;
	}

	.well .markup::after{
		content: "Example";
		position: absolute;
		top: 15px;
		left: 15px;
		font-size: 12px;
		font-weight: bold;
		color: #bbb;
		text-transform: uppercase;
		letter-spacing: 1px;
	}
</style>
<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Quản lý màu sắc</li>
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
				<?php
					echo $this->Form->create('color', array('Controller' => 'Color','Action'=>'index','method'=>'post','class'=>'form-horizontal'));
					echo $this->Form->input('Caption',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Tiêu đề','value' =>(isset($name)?$name:'')));
					echo '<hr>';
					echo '<div class="input-group">';
					echo $this->Form->input('value',array('class'=>'form-control','id'=>'color','div'=>false,'label'=>false,'placeholder'=>'Màu sắc (mã màu)','value' =>(isset($value)?$value:'#fff')));
					echo '<div class="input-group-addon" style="padding: 6px;"><div style="width: 20px;height: 20px;" id="colorBackrought"></div></div></div>';
					echo '<hr>';
					echo $this->Form->textarea('Description',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Mô tả','value' =>(isset($Description)?$Description:'')));
					echo '<hr><div><button type="submit" class="btn btn-sm btn-primary" name="btnsave"><i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i>Lưu</button><a href="/dashboard/color" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="ace-icon fa fa-times icon-on-right bigger-110"></i>Hủy</a></div>';
				?>
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
									<th style="width: 10%">Mã</th>
									<th style="width: 20%">Tên</th>
									<th style="width: 35%">Mô tả</th>
									<th style="width: 5%">Màu</th>
									<th style="width: 20%">Người tạo</th>
									<th style="width: 10%"></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($Table as $item): ?>
									<?php $user = $this->User->find('first',array('conditions'=>array('id'=>$item['Color']['byUser'])));?>
									<?php if (count($user)>0): ?>
										<tr>
											<td><?php echo $item['Color']['id'];?></td>
											<td><?php echo $item['Color']['name'];?></td>
											<td><?php echo $item['Color']['Description'];?></td>
											<td>
												<div style="width: 20px;height: 20px;background-color: <?php echo $item['Color']['Values'];?>">
												</div>
											</td>
											<td><?php echo $user['User']['first_name'].' '.$user['User']['last_name'];?></td>
											<td>
												<a href="?id=<?php echo $item['Color']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/color/<?php echo $item['Color']['id']?>" class="btn btn-xs btn-danger">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
											</td>
										</tr>
									<?php else: ?>
										<tr>
											<td><?php echo $item['Color']['id'];?></td>
											<td><?php echo $item['Color']['name'];?></td>
											<td><?php echo $item['Color']['Description'];?></td>
											<td>
												<div style="width: 20px;height: 20px;background-color: <?php echo $item['Color']['Values'];?>">
												</div>
											</td>
											<td>Không thể xác định</td>
											<td>
												<a href="?id=<?php echo $item['Color']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/color/<?php echo $item['Color']['id']?>" class="btn btn-xs btn-danger">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
											</td>
										</tr>
									<?php endif ?>
									
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script src="/assets/plugin/colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="/assets/plugin/colorpicker/dist/js/bootstrap-colorpicker-plus.js"></script>
<script type="text/javascript">
    $(function(){
    	$('#colorBackrought').css('background-color', $('#color').val());
        var demo1 = $('#color');
        demo1.colorpickerplus();
        demo1.on('changeColor', function(e,color){
			if(color==null)
			{
				$(this).val('#fff');
				$('#colorBackrought').css('background-color', '#fff');
			}
			else
			{
				$(this).val(color);
				$('#colorBackrought').css('background-color', color);
			}
        });
    });
</script>