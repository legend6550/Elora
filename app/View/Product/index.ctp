<style type="text/css">
	tbody td{text-overflow: ellipsis;line-height: 40px !important;height: 40px;}
	tbody tr{height: 40px !important;overflow: hidden;}
	.thumbnailProduct{margin: -4px 0px 0 0;border-radius: 100%;border: 2px solid #FFF;max-width: 40px;max-height: 40px;}
	.width-2{width: 2% !important}
	.width-4{width: 4% !important}
	.width-13{width: 13% !important}
	.width-6{width: 6% !important}
	.width-7{width: 7% !important}
	.width-1{width: 1% !important}
</style>
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li class="active">Danh sách sản phẩm</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1> Danh sách sản phẩm
		</h1>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="well" style="box-shadow:none;margin-bottom: 0px;border-bottom: 0px;">
				<h4 class="green smaller lighter">Normal Well</h4>
				Use the well as a simple effect on an element to give it an inset effect.
			</div>
			<table class="table table-striped table-bordered table-hover">
				<thead class="thin-border-bottom">
					<tr>
						<th class="width-2" data-tabindex="1" rowspan="2">STT</th>
						<th class="width-4" data-tabindex="2" rowspan="2">Ảnh</th>
						<th class="width-10" data-tabindex="3" rowspan="2">Mã SP</th>
						<th class="width-13" data-tabindex="4" rowspan="2">Tên SP</th>
						<th colspan="2" class="text-center">Giá</th>
						<th colspan="2" class="text-center">Số ảo</th>
						<th colspan="3" class="text-center">Sản phẩm</th>
						<th rowspan="2" data-tabindex="12" class="width-5">View</th>
						<th rowspan="2" data-tabindex="13" class="width-10">Ngày tạo</th>
						<th rowspan="2" data-tabindex="14" class="width-10">Người tạo</th>
						<th rowspan="2" class="width-7"></th>
					</tr>
					<tr>
						<th data-tabindex="5" class="width-6 text-center">Gốc</th>
						<th data-tabindex="6" class="width-6 text-center">Hiện tại</th>
						<th data-tabindex="7" class="width-6 text-center">Số lượng</th>
						<th data-tabindex="8" class="width-7 text-center">Người mua</th>
						<th data-tabindex="9" class="width-1 text-center">Hot</th>
						<th data-tabindex="10" class="width-6 text-center">Bán chạy</th>
						<th data-tabindex="11" class="width-4 text-center">Slide</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>	

<script type="text/javascript">
	$data=[<?php for ($i=0; $i < count($tables); $i++){
			$thumbnail = '/assets/images/no-image.png';
			if (strlen($tables[$i]['products']['thumbnailMiss'])>0 && file_exists(WWW_ROOT.'/assets/images/'.$tables[$i]['products']['thumbnailMiss']))
				$thumbnail='/assets/images/'.$tables[$i]['products']['thumbnailMiss'];
			echo '{\'STT\':\''.($i+1).'\',\'thumbnail\':\''.$thumbnail.'\',\'code\':\''.$tables[$i]['products']['idProduct'].'\',\'name\':\''.$tables[$i]['products']['nameProduct'].'\',\'priceCode\':\''.number_format($tables[$i]['products']['priceCode'],0).' đ'.'\',\'priceSell\':\''.(isset($tables[$i][0]['priceSell'])?number_format($tables[$i][0]['priceSell'],0).' đ':'Chưa xác định').'\',\'numberVirtual\':\''.$tables[$i]['products']['numberVirtual'].'\',\'numberSellVirtual\':\''.$tables[$i]['products']['numberSellVirtual'].'\',\'hot\':\''.$tables[$i]['products']['productHot'].'\',\'Selling\':\''.$tables[$i]['products']['productSelling'].'\',\'Slide\':\''.$tables[$i]['products']['productSlide'].'\',\'views\':\''.$tables[$i]['products']['views'].'\',\'createDate\':\''.$tables[$i]['products']['createDate'].'\',\'username\':\''.(isset($tables[$i][0]['fullname'])?$tables[$i][0]['fullname']:'Chưa xác định').'\',\'id\':\''.$tables[$i]['products']['id'].'\'},';
		}?>];
	$( document ).ready(function() {
		$width_1 = $('th[data-tabindex="1"]').width();
		$width_2 = $('th[data-tabindex="2"]').width();
		$width_3 = $('th[data-tabindex="3"]').width();
		$width_4 = $('th[data-tabindex="4"]').width();
		$width_5 = $('th[data-tabindex="5"]').width();
		$width_6 = $('th[data-tabindex="6"]').width();
		$width_7 = $('th[data-tabindex="7"]').width();
		$width_8 = $('th[data-tabindex="8"]').width();
		$width_9 = $('th[data-tabindex="9"]').width();
		$width_10 = $('th[data-tabindex="10"]').width();
		$width_11 = $('th[data-tabindex="11"]').width();
		$width_12 = $('th[data-tabindex="12"]').width();
		$width_13 = $('th[data-tabindex="13"]').width();
		$width_14 = $('th[data-tabindex="14"]').width();
		$.each($data, function(i, item) {
			$class = "!important;white-space: nowrap;text-overflow: ellipsis; overflow: hidden;";
			$checkBox='<label><input data-option="{option}" data-id="8" {checked} type="checkbox" class="ace"><span class="lbl"></span></label>';
			$btn = '<div class="btn-group"><button data-toggle="dropdown" class="btn btn-xs dropdown-toggle" aria-expanded="false">Action<span class="ace-icon fa fa-caret-down icon-on-right"></span></button><ul class="dropdown-menu dropdown-menu-right"><li><a href="/dashboard/product/promotion/'+item.id+'">Quản lý Khuyến mãi</a></li><li><a>Quản lý hình ảnh</a></li><li><a href="/dashboard/product/infomation/'+item.id+'">Quản lý thông tin chi tiết</a></li><li class="divider"></li><li><a href="/dashboard/product/warehousing/'+item.id+'">Nhập kho</a></li></ul></div>';
			$html = '<tr>';
			$html += '<td style="width:'+$width_1+'px"><div style="width: ' + $width_1 + 'px ' + $class + '">'+item.STT+'</div></td>';
			$html += '<td style="width:'+$width_2+'px"><img class="thumbnailProduct" src="'+item.thumbnail+'" alt="'+item.name+'"></td>';
			$html += '<td style="width:'+$width_3+'px"><div style="width: ' + $width_3 + 'px ' + $class + '">'+item.code+'</div></td>';
			$html += '<td style="width:'+$width_4+'px"><div style="width: ' + $width_4 + 'px ' + $class + '">'+item.name+'</div></td>';
			$html += '<td style="width:'+$width_5+'px"><div style="width: ' + $width_5 + 'px ' + $class + '">'+item.priceCode+'</div></td>';
			$html += '<td style="width:'+$width_6+'px"><div style="width: ' + $width_6 + 'px ' + $class + '">'+item.priceSell+'</div></td>';
			$html += '<td style="width:'+$width_7+'px"><div style="width: ' + $width_7 + 'px ' + $class + '">'+item.numberVirtual+'</div></td>';
			$html += '<td style="width:'+$width_8+'px"><div style="width: ' + $width_8 + 'px ' + $class + '">'+item.numberSellVirtual+'</div></td>';
			$html += '<td class="center" style="width:'+$width_9+'px"><div style="width: ' + $width_9 + 'px ' + $class + '">'+$checkBox.replace('{option}','producthot').replace('{checked}',(item.hot=='1'?'checked':''))+'</div></td>';
			$html += '<td class="center" style="width:'+$width_10+'px"><div style="width: ' + $width_10 + 'px ' + $class + '">'+$checkBox.replace('{option}','productSelling').replace('{checked}',(item.Selling=='1'?'checked':''))+'</div></td>';
			$html += '<td class="center" style="width:'+$width_11+'px"><div style="width: ' + $width_11 + 'px ' + $class + '">'+$checkBox.replace('{option}','productslide').replace('{checked}',(item.Slide=='1'?'checked':''))+'</div></td>';


			$html += '<td style="width:'+$width_12+'px"><div style="width: ' + $width_12 + 'px ' + $class + '">'+item.views+'</div></td>';
			$html += '<td style="width:'+$width_13+'px"><div style="width: ' + $width_13 + 'px ' + $class + '">'+item.createDate+'</div></td>';
			$html += '<td style="width:'+$width_13+'px"><div style="width: ' + $width_13 + 'px ' + $class + '">'+item.username+'</div></td>';
			$html += '<td>'+$btn+'</td>';
			$html += '</tr>';
			$('tbody').append($html);
		});
	});
</script>