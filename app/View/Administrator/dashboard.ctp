
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
input[type=text]{
	clear: both;
	font-family: "frutiger linotype","lucida grande","verdana",sans-serif;
	padding: 1%;
	width: 100%;
	font-size: 14px;
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
	<?php
		echo $this->Form->create(null, array('Controller' => 'Administrator','Action'=>'dashboard','method'=>'post','enctype'=>'multipart/form-data','class'=>'form-horizontal'));
		echo '<div>';
		echo $this->Form->input('title',array('class' => 'form-control','id'=>'txttitle','placeholder'=>'Tiêu đề','div'=>false,'label'=>'Tiêu đề trang'));
		echo '</div><hr>';
		echo '<div>';
		echo '<label for="txtdescription">Mô tả trang</label>';
		echo $this->Form->textarea('description',array('class' => 'form-control','id'=>'txtdescription','placeholder'=>'Mô tả trang'));
		echo '</div><hr>';
		echo '<div>';
		echo '<label for="txtkeywords">keywords</label>';
		echo $this->Form->textarea('keywords',array('class' => 'form-control','id'=>'txtkeywords','placeholder'=>'keywords'));
		echo '</div><hr>';
		echo '<div><label for="imglogo">logo website</label>';
		echo $this->Form->input('logo',array('type'=>"file",'id'=>"imglogo",'div'=>false,'label'=>false));
		echo '<label class="ace-file-input ace-file-multiple"><span class="ace-file-container hide-placeholder selected">';
		echo '<span class="ace-file-name">';
		echo '<img class="middle" src="/assets/images/12439306_1814966525390043_6032224889367440998_n1.jpg" style="width: 50px; height: 50px;"><i class=" ace-icon fa fa-picture-o file-image"></i></span></span></label>';
		echo '</div><hr>';

		echo '<div><label for="imgIcon">Icon website</label>';
		echo $this->Form->input('icon',array('type'=>"file",'id'=>"imgIcon",'div'=>false,'label'=>false));
		echo '<label class="ace-file-input ace-file-multiple"><span class="ace-file-container hide-placeholder selected">';
		echo '<span class="ace-file-name">';
		echo '<img class="middle" src="/assets/images/12439306_1814966525390043_6032224889367440998_n1.jpg" style="width: 50px; height: 50px;"><i class=" ace-icon fa fa-picture-o file-image"></i></span></span></label>';
		echo '</div><hr>';

	?>
	<div class="form-group">
		<div class="col-xs-12">
			
		</div>
	</div>
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