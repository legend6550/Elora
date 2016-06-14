<?php
	App::uses('Model', 'User');
	$this->User = new User();
?>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Quản lý quận/huyện</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>Quản lý quận/huyện</h1>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->Session->flash();?>
		</div>
		<div class="col-sm-4" id="windowsInfomation">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title blue smaller">
						<i class="ace-icon fa fa-map-marker"></i>
						Thông tin
					</h4>
				</div>
			</div>
			<div class="widget-body">
				<div class="space-8"></div>
				<?php
					echo $this->Form->create('citys', array('Controller' => 'citys','Action'=>'index','method'=>'post','class'=>'form-horizontal'));
					echo $this->Form->input('name',array('class'=>'form-control','div'=>false,'label'=>false,'id'=>'txtregion','placeholder'=>'Quận/Huyện','value' =>(isset($name)?$name:'')));
					echo '<hr>';
					echo '<input readonly="" id="txtcity" type="text" class="form-control" value="'.(isset($nameCitys)?$nameCitys:'').'">';
					echo '<hr>';
					echo '<iframe id="windowsMaps" src="https://www.google.com/maps/embed/v1/place?q=binh+duong,viet+nam&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>';
					echo '<hr><div><button type="submit" class="btn btn-sm btn-primary" name="btnsave"><i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i>Lưu</button><a href="'.(isset($href)?$href:'#').'" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="ace-icon fa fa-times icon-on-right bigger-110"></i>Hủy</a></div>';
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
									<th style="width: 35%">Quận/Huyện</th>
									<th style="width: 20%">Người tạo</th>
									<th style="width: 20%">Ngày tạo</th>
									<th style="width: 15%"></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($Table as $item): ?>
									<?php $user = $this->User->find('first',array('conditions'=>array('id'=>$item['Region']['byUser'])));?>
									<?php if (count($user)>0): ?>
										<tr>
											<td><?php echo $item['Region']['id'];?></td>
											<td><?php echo $item['Region']['name'];?></td>
											<td><?php echo $item['User']['first_name'].' '.$user['User']['last_name'];?></td>
											<td><?php echo $item['Region']['createDate'];?></td>
											<td>
												<a href="?id=<?php echo $item['Region']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/region/<?php echo $slug.'/'.$item['Region']['id']?>" class="btn btn-xs btn-danger">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
											</td>
										</tr>
									<?php else: ?>
										<tr>
											<td><?php echo $item['Region']['id'];?></td>
											<td><?php echo $item['Region']['name'];?></td>
											<td><?php echo $item['Region']['createDate'];?></td>											
											<td>Không thể xác định</td>
											<td>
												<a href="?id=<?php echo $item['Region']['id']?>" class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
												<a href="/dashboard/region/<?php echo $slug.'/'.$item['Region']['id']?>" class="btn btn-xs btn-danger">
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

<script type="text/javascript">
	function initialize() {
        /*var myLatlng = new google.maps.LatLng(52.872764, -6.496128);
        var mapOptions = {
            center: myLatlng,
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };        
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: $('#txtcitys').val()
        });*/
        var iframe = document.getElementById("windowsMaps");
        if($('#txtcity').val().length==0){
        	textaddress = $('#txtcity').val()+',+Viet+nam';
			iframe.src = "https://www.google.com/maps/embed/v1/place?q=" + textaddress.replace(/ /gi,'+') + "&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU";
        } else {
        	textaddress = $('#txtregion').val()+',+'+$('#txtcity').val()+',+Viet+nam';
        	iframe.src = "https://www.google.com/maps/embed/v1/place?q=" + textaddress.replace(/ /gi,'+') + "&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU";
        }
		
    }
    function lazyloadMaps(lat,lng){
    	var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            center: myLatlng,
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };        
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: $('#txtregion').val()
        });    
    }
    $(document).ready(function () {
    	$("#txtregion").change(function() {
			textaddress = $('#txtregion').val()+',+'+$('#txtcity').val()+',+Viet+nam';
			var iframe = document.getElementById("windowsMaps");
			iframe.src = "https://www.google.com/maps/embed/v1/place?q=" + textaddress.replace(/ /gi,'+') + "&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU";
		});
		$(function () {
	        if (window.google && google.maps) {
	        	$('#windowsMaps').css("height",$('#windowsInfomation').width());
	            initialize();
	        }
	    });
    });
</script>