<link rel="stylesheet" href="/assets/css/jquery-ui.min.css" />
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li>
			<a href="#">Quản trị website</a>
		</li>
		<li class="active">Mạng xã hội</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Mạng xã hội</h1>
	</div>
	<?php echo $this->Session->flash();?>
	<?php
		echo $this->Form->create(null, array('Controller' => 'Administrator','Action'=>'dashboard','method'=>'post','enctype'=>'multipart/form-data','class'=>'form-horizontal'));
		echo '<div>';
		echo $this->Form->input('facebook',array('class' => 'form-control','id'=>'txtFacebook','placeholder'=>'Facebook','div'=>false,'label'=>'Facebook','value'=>$facebook));
		echo '</div><hr>';
		echo '<div>';
		echo $this->Form->input('Google',array('class' => 'form-control','id'=>'txtGoogle','placeholder'=>'Google','div'=>false,'label'=>'Google','value'=>$Google));
		echo '</div><hr>';
		echo '<div>';
		echo $this->Form->input('Twitter',array('class' => 'form-control','id'=>'txtTwitter','placeholder'=>'Twitter','div'=>false,'label'=>'Twitter','value'=>$Twitter));
		echo '</div><hr>';
		echo '<div>';
		echo $this->Form->input('Intagram',array('class' => 'form-control','id'=>'txtIntagram','placeholder'=>'Intagram','div'=>false,'label'=>'Intagram','value'=>$Intagram));
		echo '</div><hr>';
		echo '<div>';
		echo $this->Form->input('youtube',array('class' => 'form-control','id'=>'txtyoutube','placeholder'=>'youtube','div'=>false,'label'=>'youtube','value'=>$youtube));
		echo '</div><hr>';

		echo '<div><button class="btn btn-info" type="submit" name="btnsave"><i class="ace-icon fa fa-check bigger-110"></i>Lưu</button></div></div>';
	?>
</div>