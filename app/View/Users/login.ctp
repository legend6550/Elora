<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="login-container">
			<div class="center">
				<h1>
					<i class="ace-icon fa fa-tachometer green"></i>
					<span class="grey" id="id-text2">Administrator</span>
				</h1>
			</div>

			<div class="space-6"></div>

			<div class="position-relative">
				<div id="login-box" class="login-box visible widget-box no-border">
					<div class="widget-body">
						<div class="widget-main">
							<h4 class="header blue lighter bigger">
								<i class="ace-icon fa fa-coffee green"></i>
								Thông tin đăng nhập
							</h4>
							<div class="space-6"></div>
							<?php
									echo $this->Form->create('User', array('Action' => 'login','method'=>'post'));
									echo '<fieldset>';
									echo '<label class="block clearfix">';
									echo '<span class="block input-icon input-icon-right">';
									echo $this->Form->input('username',array('div'=>false,'class'=>'form-control','label'=>false,'placeholder'=>'Tài khoản'));	
									echo '<i class="ace-icon fa fa-user"></i></span></label>';
									echo '<label class="block clearfix">';
									echo '<span class="block input-icon input-icon-right">';
									echo $this->Form->input('password',array('div'=>false,'class'=>'form-control','label'=>false,'placeholder'=>'Mật khẩu'));
									echo '<i class="ace-icon fa fa-lock"></i></span></label>';
									echo '<div class="space"></div>';
									echo $this->Session->flash();
									echo '<div class="clearfix">';
									echo '<button type="summit" name="btnsave" class="width-40 pull-right btn btn-sm btn-primary">';
									echo '<i class="ace-icon fa fa-key"></i>';
									echo '<span class="bigger-110">Đăng nhập</span>';
									echo '</button></div><div class="space-4"></div></fieldset>';
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>