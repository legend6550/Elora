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
		<li class="active">Cài đặt website</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Cài đặt website</h1>
	</div>
	<?php echo $this->Session->flash();?>
	<?php
		echo $this->Form->create(null, array('Controller' => 'Administrator','Action'=>'dashboard','method'=>'post','enctype'=>'multipart/form-data','class'=>'form-horizontal'));
		echo '<div>';
		echo $this->Form->input('title',array('class' => 'form-control','id'=>'txttitle','placeholder'=>'Tiêu đề','div'=>false,'label'=>'Tiêu đề trang','value'=>$titleSite));
		echo '</div><hr>';
		echo '<div>';
		echo '<label for="txtdescription">Mô tả trang</label>';
		echo $this->Form->textarea('description',array('class' => 'form-control','id'=>'txtdescription','placeholder'=>'Mô tả trang','value'=>$description));
		echo '</div><hr>';
		echo '<div>';
		echo '<label for="txtkeywords">keywords</label>';
		echo $this->Form->textarea('keywords',array('class' => 'form-control','id'=>'txtkeywords','placeholder'=>'keywords','value'=>$keywords));
		echo '</div><hr>';
		echo '<div><label for="imglogo">logo website</label>';
		echo $this->Form->input('logo',array('type'=>"file",'id'=>"imglogo",'div'=>false,'label'=>false));
		echo '<label class="ace-file-input ace-file-multiple"><span class="ace-file-container hide-placeholder selected">';
		echo '<span class="ace-file-name" data-title="'.$nameicon.'">';
		echo '<img class="middle" src="'.$logo.'" style="width: 50px; height: 50px;"><i class=" ace-icon fa fa-picture-o file-image"></i></span></span></label>';
		echo '</div><hr>';

		echo '<div><label for="imgIcon">Icon website</label>';
		echo $this->Form->input('icon',array('type'=>"file",'id'=>"imgIcon",'div'=>false,'label'=>false));
		echo '<label class="ace-file-input ace-file-multiple"><span class="ace-file-container hide-placeholder selected">';
		echo '<span class="ace-file-name" data-title="'.$nameicon.'">';
		echo '<img class="middle" src="'.$icon.'" style="width: 50px; height: 50px;"><i class=" ace-icon fa fa-picture-o file-image"></i></span></span></label>';
		echo '</div><hr>';


		echo '<div><button class="btn btn-info" type="submit" name="btnsave"><i class="ace-icon fa fa-check bigger-110"></i>Lưu</button></div></div>';
	?>
</div>
<script src="/assets/js/ace-elements.min.js"></script>
<script src="/assets/js/ace.min.js"></script>
<script type="text/javascript">
	$('#imgIcon,#imglogo').ace_file_input({
		no_file:'Chọn file hình ảnh',
		btn_choose:'Chọn hình',
		btn_change:'Đổi hình',
		droppable:false,
		onchange:null,
		thumbnail:false, //| true | large
		whitelist:'gif|png|jpg|jpeg'
		//blacklist:'exe|php'
		//onchange:''
		//
	});
</script>