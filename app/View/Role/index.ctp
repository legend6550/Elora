<?php
	App::uses('Model', 'User');
	$this->User = new User();
?>
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Quản lý nhóm tài khoản</li>
	</ul>
</div>
<div class="page-content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Session->flash();?>
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-list-alt"></i>
						Danh sách nhóm tài khoản hiện có
					</h4>
				</div>
				<div class="widget-body">

					<div class="widget-main no-padding">
						<table class="table table-bordered table-striped" width="100%">
							<thead class="thin-border-bottom">
								<tr>
									<th style="width: 10%">Mã</th>
									<th style="width: 20%">Tên</th>
									<th style="width: 40%">Mô tả</th>
									<th style="width: 10%">Ngày tạo</th>
									<th style="width: 10%">Người tạo</th>
									<th style="width: 10%"></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($Tables as $item): ?>
									<?php $user = $this->User->find('first',array('conditions'=>array('id'=>$item['authoritie']['byUser'])));?>
									<?php if (count($user)>0): ?>
										<tr>
											<td><?php echo $item['authoritie']['id'];?></td>
											<td><?php echo $item['authoritie']['name'];?></td>
											<td><?php echo $item['authoritie']['description'];?></td>
											<td><?php echo $item['authoritie']['createDate'];?></td>
											<td><?php echo $user['User']['first_name'].' '.$user['User']['last_name'];?></td>
											<td>
												<a href="/dashboard/role/<?php echo $item['authoritie']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/role/delete/<?php echo $item['authoritie']['id']?>" class="btn btn-xs btn-danger">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
											</td>
										</tr>
									<?php else: ?>
										<tr>
											<td><?php echo $item['authoritie']['id'];?></td>
											<td><?php echo $item['authoritie']['name'];?></td>
											<td><?php echo $item['authoritie']['description'];?></td>
											<td><?php echo $item['authoritie']['createDate'];?></td>
											<td>Không thể xác định</td>
											<td>
												<a href="/dashboard/role/<?php echo $item['authoritie']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/role/delete/<?php echo $item['authoritie']['id']?>" class="btn btn-xs btn-danger">
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