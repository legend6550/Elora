<style type="text/css">
.fileUpload {
    position: relative;
    overflow: hidden;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Thông tin cá nhân</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Thông tin cá nhân</h1>
	</div>
	<?php echo $this->Session->flash();?>
	<div class="row">
		<form class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
		<div class="col-xs-12 col-sm-3 center">
			<span class="profile-picture">
				<img id="avatar" class="editable img-responsive editable-click editable-empty" alt="Alex's Avatar" src="
				<?php
					if(strlen($user['User']['avatar'])>0 && file_exists(WWW_ROOT.'/assets/images/'.$user['User']['avatar'])) 
				        echo '/assets/images/'.$user['User']['avatar'];
				    else
				       echo '/assets/images/no-avatar.jpg';
       			?>"></img>
			</span>
			<div class="input-group">
				<input type="text" id="fileUpload" class="form-control" placeholder="Chọn file" disabled="disabled" />
				<div class="input-group-btn">
					<div class="fileUpload btn btn-sm btn-default" style="padding-top: 5px;">
						<span>Upload</span>
					    <input id="uploadBtn" name="txtavatar" type="file" class="upload" />
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-9">
			<div class="row">
				<div class="profile-user-info profile-user-info-striped">
					<div class="profile-info-row">
						<div class="profile-info-name"> Tài khoản </div>
						<div class="profile-info-value" data-id="username">
							<span id="username" style="display: inline;"><?php echo $user['User']['username'] ?></span>
						</div>
					</div>
					<div class="profile-info-row">
						<div class="profile-info-name"> Gmail </div>
						<div class="profile-info-value" data-id="gmail">
							<span id="gmail" style="display: inline;"><?php echo $user['User']['gmail'] ?></span>
						</div>
					</div>
					<div class="profile-info-row">
						<div class="profile-info-name"> Ngày tạo </div>
						<div class="profile-info-value" data-id="createDate">
							<span id="createDate" style="display: inline;"><?php echo $user['User']['createDate']?></span>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Họ và tên</div>
						<div class="profile-info-value" data-id="txtfullname">
							<input type="text" id="txtfullname" name="txtfullname" placeholder="Họ và tên" class="form-control input-sm" value="<?php echo $user['User']['fullname']?>">
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Giới tính</div>
						<div class="profile-info-value" data-id="rdgender">
						<?php
							if($user['User']['gender']=='1'){
								echo '<input type="radio" id="rdgendertrue" name="rdgender" value="1" checked><label for="rdgendertrue">Nam</label><input type="radio" id="rdgenderfalse" name="rdgender" value="0"><label for="rdgenderfalse">Nữ</label>';
							}
							else
								echo '<input type="radio" id="rdgendertrue" name="rdgender" value="1"><label for="rdgendertrue">Nam</label><input type="radio" id="rdgenderfalse" checked name="rdgender" value="0"><label for="rdgenderfalse">Nữ</label>';
						?>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Ngày sinh</div>
						<div class="profile-info-value" data-id="txtbirthday">
							<input type="text" id="txtbirthday" name="txtbirthday" placeholder="Ngày sinh" class="form-control" value="<?php echo $user['User']['birthday']?>">
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Địa chỉ</div>
						<div class="profile-info-value" data-id="txtStreet">
							<div class="row">
							<div class="col-md-4">
								<input type="text" id="txtStreet" name="txtStreet" placeholder="Đường" class="form-control" value="<?php echo $user['User']['Street']?>">
							</div>
							<div class="col-md-4">
								<input type="text" id="txtregion" name="txtregion" placeholder="Quận/Huyện/Xã" class="form-control" value="<?php echo $user['User']['region']?>">
							</div>
							<div class="col-md-4">
								<input type="text" id="txtcity" name="txtcity" placeholder="Tỉnh/Thành Phố" class="form-control" value="<?php echo $user['User']['city']?>">
							</div>
						</div>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Số điện thoại</div>
						<div class="profile-info-value" data-id="txtphone">
							<input type="text" id="txtphone" name="txtphone" placeholder="Số điện thoại" class="form-control" value="<?php echo $user['User']['phone']?>">
						</div>
					</div>
					<?php
						if(isset($_GET['id'])){
							echo '<div class="profile-info-row"><div class="profile-info-name"> Phân quyền</div>
								<div class="profile-info-value" data-id="txtphone">
									<select id="cborule" name="cborule" class="form-control">
										<option value="0">Administrator</option>
										<option value="1">Users</option>
									</select>
								</div>
							</div>';
						}
					?>
					<div class="profile-info-row">
						<div class="profile-info-name"> &nbsp;</div>
						<div class="profile-info-value" data-id="txtphone">
							<button type="submit" class="btn btn-primary" name="btnsave">Lưu Thông tin</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<script src="/assets/js/ace-extra.min.js"></script>
<script src="/assets/js/jquery-ui.min.js"></script>
<script src="/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		document.getElementById("uploadBtn").onchange = function () {
		    document.getElementById("uploadFile").value = this.value;
		};
		$( "#txtbirthday" ).datepicker({
			showOtherMonths: true,
			selectOtherMonths: false,
		});
	});
</script>