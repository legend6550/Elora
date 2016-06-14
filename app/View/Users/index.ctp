<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Trang chủ</a>
		</li>
		<li>
			<a href="#">Quản lý tài khoản</a>
		</li>
		<li class="active">Danh sách hiện có</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>
			Các tài khoản hiện có
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12" id="WindowsMsg"><?php echo $this->Session->flash();?></div>
		<div class="col-xs-12">
			<div class="widget-box transparent" id="windowsTables">
				<div class="widget-body">
					<table id='DataTable' class='table table-striped table-bordered table-hover'>
						<thead>
							<tr>
								<th>Mã</th>
								<th>Tài khoản</th>
								<th>Họ và tên</th>
								<th>Gmail</th>
								<th>Ngày tạo</th>
								<th>SDT</th>
								<th>Phân quyền</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php echo $Tables;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="/assets/js/dataTables.tableTools.min.js"></script>
<script src="/assets/js/dataTables.colVis.min.js"></script>
<script src="/assets/js/jquery.jqGrid.min.js"></script>
<script src="/assets/js/grid.locale-en.js"></script>
<script type='text/javascript'>
	function load($val){
		if($val==='hidden'){
			$('#windowsTables').removeClass("position-relative");
			$('#windowsTables').find('.widget-box-overlay').remove();
		}
		else{
			$('#windowsTables').addClass("position-relative");
			$('#windowsTables').append('<div class="widget-box-overlay"><i class=" ace-icon loading-icon fa fa-spinner fa-spin fa-2x white"></i></div>')
		}
	}
	$(document).ready(function () {
		$('select[data-option="permission"]' ).change(function() {
			$this=$(this);
			valueSelect = $this.attr('data-value');
			load('show');
			$.ajax({
                type: 'POST',
                url: "/api/v2/data/set-permission.json",
                data: {
                    Permission: $this.val(),
                    user:$this.attr('data-id'),
                    byUser:'<?php echo $username;?>'
                },
                success: function (data) {
                    if (data.error != null) {
                    	html =  '<div class="alert alert-danger" style="margin-bottom: 20px;"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><ul>';
                    	$.each(data.error,function(index, value){
                    		html+='<li>'+value+'</li>';
                    	});
                    	$this.val(valueSelect);
                    	$('#WindowsMsg').html(html+'</ul></div>');
                    }
                    else if(data.success != null){
                    	$this.attr('data-value',$this.val());
                    	$('#WindowsMsg').html('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>Cập nhật hoàn tất</div>');
                    }
                    load('hidden');
                },
                error: function () {
                    $('#WindowsMsg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-chain-broken green"></i>Lỗi kết nối server</div>');
                    $this.val(valueSelect);
                    load('hidden');
                }
            });
		});
	});


	jQuery(function ($) {var oTable1 =$('#DataTable').dataTable({
		bAutoWidth: false,
		'aoColumns': [
			null,null,null,null,null,null,null,
			{ 'bSortable': false }
		],
		'aaSorting': [],
	});
	TableTools.classes.container = 'btn-group btn-overlap';
	TableTools.classes.print = {
		'body': 'DTTT_Print',
		'info': 'tableTools-alert gritter-item-wrapper gritter-info gritter-center white',
		'message': 'tableTools-print-navbar'
	};
	var tableTools_obj = new $.fn.dataTable.TableTools(oTable1, {
		'sSwfPath': 'assets/swf/copy_csv_xls_pdf.swf',
		'sRowSelector': 'td:not(:last-child)',
		'sRowSelect': 'multi',
		'fnRowSelected': function (row) { try { $(row).find('input[type=checkbox]').get(0).checked = true } catch (e) { }
		},
		'fnRowDeselected': function (row) {try { $(row).find('input[type=checkbox]').get(0).checked = false }catch (e) { }},
		'sSelectedClass': 'success'
	});
	$(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
	setTimeout(function () {
		$(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function () {var div = $(this).find('> div');
	if (div.length > 0) div.tooltip({ container: 'body' });else $(this).tooltip({ container: 'body' });}); }, 200);var colvis = new $.fn.dataTable.ColVis(oTable1, {'buttonText': "<i class='fa fa-search'></i>",'aiExclude': [0, 5],'bShowAll': true,'sAlign': 'right','fnLabel': function (i, title, th) {return $(th).text();}});$(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold');$(colvis.button()).prependTo('.tableTools-container .btn-group').attr('title', 'Show/hide columns').tooltip({ container: 'body' });$(colvis.dom.collection).addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right').find('li').wrapInner('<a href="javascript:void(0)"/>').find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');$(document).on('click', '#DataTable .dropdown-toggle', function (e) {e.stopImmediatePropagation();e.stopPropagation();e.preventDefault();});})
</script>