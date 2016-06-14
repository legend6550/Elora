<?php
	App::uses('Model', 'User');
	$this->User = new User();
?>
<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Quản lý size</li>
	</ul>
</div>
<div class="page-content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Session->flash();?>
		</div>
		<div class="col-sm-4">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-info-circle"></i>
						Thông tin
					</h4>
				</div>
				<div class="widget-body">
					<div class="space-12"></div>
					<?php
						echo $this->Form->create('size', array('Controller' => 'Size','Action'=>'index','method'=>'post','class'=>'form-horizontal'));
						echo $this->Form->input('name',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Tên size','value' =>(isset($name)?$name:'')));
						echo '<hr>';
						echo $this->Form->textarea('Description',array('class'=>'form-control','div'=>false,'label'=>false,'placeholder'=>'Chú thích','value' =>(isset($Description)?$Description:'')));
						echo '<hr><div><button type="submit" class="btn btn-sm btn-primary" name="btnsave"><i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i>Lưu</button><a href="/dashboard/size" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="ace-icon fa fa-times icon-on-right bigger-110"></i>Hủy</a></div>';
					?>
				</div>
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
									<th style="width: 10%">Mã Quản lý</th>
									<th style="width: 20%">Tên</th>
									<th style="width: 40%">Mô tả</th>
									<th style="width: 20%">Người tạo</th>
									<th style="width: 10%"></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($Table as $item): ?>
									<?php $user = $this->User->find('first',array('conditions'=>array('id'=>$item['Size']['byUser'])));?>
									<?php if (count($user)>0): ?>
										<tr>
											<td><?php echo $item['Size']['id'];?></td>
											<td><?php echo $item['Size']['name'];?></td>
											<td><?php echo $item['Size']['Description'];?></td>
											<td><?php echo $user['User']['first_name'].' '.$user['User']['last_name'];?></td>
											<td>
												<a href="?id=<?php echo $item['Size']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/size/<?php echo $item['Size']['id']?>" class="btn btn-xs btn-danger">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
											</td>
										</tr>
									<?php else: ?>
										<tr>
											<td><?php echo $item['Size']['id'];?></td>
											<td><?php echo $item['Size']['name'];?></td>
											<td><?php echo $item['Size']['Description'];?></td>
											<td>Không thể xác định</td>
											<td>
												<a href="?id=<?php echo $item['Size']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/size/<?php echo $item['Size']['id']?>" class="btn btn-xs btn-danger">
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