<script>
var langDataTables = {
		"search" : "Cari:",
		"emptyTable" : "Tidak ada data pada tabel",
		"infoEmpty" : "Menampilkan 0 Access Point",
		"info" : "Menampilkan _START_ - _END_ dari _TOTAL_ Access Point",
		"infoFiltered" : "(Disortir dari _MAX_ total Access Point)",
		"lengthMenu" : "Menampilkan _MENU_ Access Point",
		"loadingRecords" : "Memuat...",
		"processing" : "Memproses...",
		"zeroRecords" : "Pencarian tidak ditemukan",
		"paginate" : {
			"first" : "Pertama",
			"last" : "Terakhir",
			"next" : "Selanjutnya",
			"previous" : "Sebelumnya"
		},
		"aria" : {
			"sortAscending" : ": Mensortir kolom secara ascending",
			"sortDescending" : ": Mensortir kolom secara descending"
		}
	};
	
function init_page() {
	$('#table-autelan, #table-cisco').DataTable({
		language : langDataTables,
		"lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
		"scrollX" : true,
		"scrollY": "800px",
		"scrollCollapse": true,
		responsive : true
	});

	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
	     var t = $($.fn.dataTable.tables( {visible: true, api: true} )).dataTable().api();
	     t.columns.adjust();
	} );
}
</script>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $pageHeader;?></h1>
			<div id="tab_container">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist" id="server-tabs">
					<li role="presentation" class="active" id="tab_s0"><a
						href="#tab-autelan" aria-controls="Autelan" role="tab"
						data-toggle="tab">Autelan</a></li>
					<li role="presentation" id="tab_s1"><a href="#tab-cisco"
						aria-controls="Cisco" role="tab" data-toggle="tab">
						Cisco</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
<?php //======================================= AUTELAN ================================== ?>
					<div role="tabpanel" class="tab-pane fade in active"
						id="tab-autelan">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">UV Autelan</h3>
							</div>
							<div class="panel-body" id="tabpane_s0">
								<?php 
								if(isset($apDataAutelan['list_data'])){
									echo '<div id="div_info_s0" class="alert alert-info">';
									echo '<ul id="ul_s0">';
									echo 'Total AP : '. $apDataAutelan['total'];
									echo '</ul>';
									echo '</div>';
								}else{
									echo '<div id="div_alert_s0" class="alert alert-danger">';
									echo $apDataAutelan['msg'];
									echo '</div>'; 
								}
								?>
								<div class="dataTable_wrapper">
									<a href="<?php echo site_url("/main/ap_unverified/uv?type=xlsx&amp;server=autelan"); ?>"
										class="btn btn-default <?php
											if (empty($apDataAutelan['list_data']['data'])) echo "disabled"; ?>"
											target="_blank"><span class="glyphicon glyphicon-save"></span>&nbsp;Download
											versi Excel
									</a>
									<table class="table table-striped table-bordered table-hover"
										style="width: 100%;" id="table-autelan">
										<thead>
											<tr>
												<th align='center'>WITEL</th>
												<th align='center'>LOC_ID</th>
												<th align='center'>AP_NAME</th>
												<th align='center'>MAC_ADDRESS</th>
												<th align='center'>AP_IP_ADDRESS</th>
												<th align='center'>SN</th>
												<th align='center'>LOCATION</th>
												<th align='center'>STATUS</th>
												<th align='center'>THROUGHPUT</th>
												<th align='center'>HOLDING_TIME</th>
												<th align='center'>JUMLAH_USER</th>
												<th align='center'>UP_TIME</th>
												<th align='center'>NSR</th>
												<th align='center'>PROPINSI</th>
												<th align='center'>KOTA</th>
												<th align='center'>USER_AUTH</th>
												<th align='center'>USER_ASOC</th>
												<th align='center'>PO</th>
												<th align='center'>JML_CLIENT</th>
												<th align='center'>PROGRAM</th>
												<th align='center'>REGIONAL</th>
												<th align='center'>BSR</th>
												<th align='center'>ONAIR_DATE</th>
												<th align='center'>DIVISIO</th>
												<th align='center'>ONAIR_LOC</th>
												<th align='center'>BATCH_P</th>
												<th align='center'>SEGMEN1</th>
												<th align='center'>SEGMEN2</th>
												<th align='center'>JENIS</th>
												<th align='center'>UNDER_VERIFY</th>
												<th align='center'>PARTNERSHIP</th>
												<th align='center'>NMS_SOURCE</th>
												<th align='center'>CONTR_NAME</th>
												<th align='center'>P_CONTR_NAME</th>
												<th align='center'>TAG</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										if (!empty($apDataAutelan['list_data']['data'])) {
											foreach ($apDataAutelan['list_data']['data'] as $itemRow) {
												echo "<tr>";
												foreach ($itemRow as $colKey => $colValue) {
													if ($colKey != 'id')
														echo "<td>".$colValue."</td>\n";
												}
												echo "</tr>\n";
											}
										}
										
										?>
										</tbody>
									</table>
								</div>
								<!-- End table wrapper -->
							</div>
						</div>
					</div>
<?php //======================================= CISCO ================================== ?>
					<div role="tabpanel" class="tab-pane fade in"
						id="tab-cisco">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">UV Cisco</h3>
							</div>
							<div class="panel-body" id="tabpane_s0">
								<?php 
								if(isset($apDataCisco['list_data'])){
									echo '<div id="div_info_s0" class="alert alert-info">';
									echo '<ul id="ul_s0">';
									echo 'Total AP : '. $apDataCisco['total'];
									echo '</ul>';
									echo '</div>';
								}else{
									echo '<div id="div_alert_s0" class="alert alert-danger">';
									echo $apDataCisco['msg'];
									echo '</div>'; 
								}
								?>
								<div class="dataTable_wrapper">
									<a href="<?php echo site_url("/main/ap_unverified/uv?type=xlsx&amp;server=cisco"); ?>"
										class="btn btn-default <?php
											if (empty($apDataCisco['list_data']['data'])) echo "disabled"; ?>"
											target="_blank">
										<span class="glyphicon glyphicon-save"></span>&nbsp;Download
											versi Excel
									</a>
									<table class="table table-striped table-bordered table-hover"
										style="width: 100%;" id="table-cisco">
										<thead>
											<tr>
												<th align='center'>WITEL</th>
												<th align='center'>LOC_ID</th>
												<th align='center'>AP_NAME</th>
												<th align='center'>MAC_ADDRESS</th>
												<th align='center'>AP_IP_ADDRESS</th>
												<th align='center'>SN</th>
												<th align='center'>LOCATION</th>
												<th align='center'>STATUS</th>
												<th align='center'>THROUGHPUT</th>
												<th align='center'>HOLDING_TIME</th>
												<th align='center'>JUMLAH_USER</th>
												<th align='center'>UP_TIME</th>
												<th align='center'>NSR</th>
												<th align='center'>PROPINSI</th>
												<th align='center'>KOTA</th>
												<th align='center'>USER_AUTH</th>
												<th align='center'>USER_ASOC</th>
												<th align='center'>PO</th>
												<th align='center'>JML_CLIENT</th>
												<th align='center'>PROGRAM</th>
												<th align='center'>REGIONAL</th>
												<th align='center'>BSR</th>
												<th align='center'>ONAIR_DATE</th>
												<th align='center'>DIVISIO</th>
												<th align='center'>ONAIR_LOC</th>
												<th align='center'>BATCH_P</th>
												<th align='center'>SEGMEN1</th>
												<th align='center'>SEGMEN2</th>
												<th align='center'>JENIS</th>
												<th align='center'>UNDER_VERIFY</th>
												<th align='center'>PARTNERSHIP</th>
												<th align='center'>NMS_SOURCE</th>
												<th align='center'>CONTR_NAME</th>
												<th align='center'>P_CONTR_NAME</th>
												<th align='center'>TAG</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										if (!empty($apDataCisco['list_data']['data'])) {
											foreach ($apDataCisco['list_data']['data'] as $itemRow) {
												echo "<tr>";
												foreach ($itemRow as $colKey => $colValue) {
													if ($colKey != 'id')
														echo "<td>".$colValue."</td>\n";
												}
												echo "</tr>\n";
											}
										}
										?>
										</tbody>
									</table>
								</div>
								<!-- End table wrapper -->
							</div>
						</div>
					</div>
				</div>
			</div><!-- End Tab Container -->
		</div>
	</div>
</div>