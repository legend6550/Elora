<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Đổi mật khẩu</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Đổi mật khẩu</h1>
	</div>
	<?php echo $this->Session->flash();?>
	<div class="row">
		<div class="col-xs-12">
			<form class="form-horizontal" method="POST" role="form">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="txtpasswordold"> Mật khẩu cũ </label>
					<div class="col-sm-9">
						<input type="password" id="txtpasswordold" name="txtpasswordold" class="col-xs-10 col-sm-5">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="txtpasswordnew"> Mật khẩu mới </label>
					<div class="col-sm-9">
						<input type="password" id="txtpasswordnew" name="txtpasswordnew" class="col-xs-10 col-sm-5">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="txtpasswordrelay"> nhập lại Mật khẩu</label>
					<div class="col-sm-9">
						<input type="password" id="txtpasswordrelay" name="txtpasswordrelay" class="col-xs-10 col-sm-5">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="txtpasswordrelay"> &nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" class="btn btn-primary" name="btnsave">Đổi mật khẩu</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>