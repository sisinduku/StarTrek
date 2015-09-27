<style>
table tr.row-down td {
	background-color: #F9BBBC;
}
#div_loader {
	display:none;
	text-align: center;
}
#tab_container {
	font-size:0.9em; /* Biar font ngga begitu memenuhi tempat... */
}
/* disembunyikan dulu... */
#tab_container, #div_request_result {
	display:none;
}
</style>
<script>
var isLoading = false;
var REQUEST_URL = "<?php echo site_url("/ajax/cari/ap");?>";

// Fungsi init halaman, dipanggil setiap kali halaman selesai diload (onReady)
function init_page() {
	$("#form_cari").submit(submitFormCari);
	
}
function submitFormCari(event) {
	//==== Validasi dulu
	var selectedServerCount = $("#form_cari input[class='chk_server']:checked").length;;
	if (selectedServerCount == 0) {
		alert("Silakan pilih paling tidak satu server.");
		event.preventDefault();
		return;
	}
	
	//==== Baru proses submit...
	var postData = $("#form_cari").serialize();
	$.ajax({
		url: REQUEST_URL,
		method: "post",
		data: postData,
		dataType: 'json',
		beforeSend: function( xhr ) {
			isLoading = true;
			$("#div_request_result").hide();
			$("#div_loader").show();
			$("#form_cari button[type=submit], #form_cari input[type=text]")
				.attr('disabled','disabled');

			$("#div_alert_s0, #div_alert_s1").hide();
		},
		success: function(response){
			$("#tab_container").show();
			var activeTab = -1;
			
			// Proses server 0 (Sindokom)
			var datatable1 = $('#tableJatengJogja').dataTable().api();
			datatable1.clear();
			if ('s0' in response.data) {
				activeTab = 0;
				$('#server-tabs li#tab_s0 a:first').tab('show');
				
				// Ditampilkan hanya jika diminta
				$("#tab_s0").show();
				if ('list_data' in response.data.s0) {
					$("#tabpane_s0 .dataTable_wrapper").show();
			   		datatable1.rows.add(response.data.s0.list_data.data);
			   		$("#div_alert_s0").show();
					var node = document.createTextNode("Jumlah AP yang DOWN : "+response.data.s0.list_data.down);
					document.getElementById('div_alert_s0').appendChild(node);
				} else {

					// Tampilkan error di sini...
					$("#tabpane_s0 .dataTable_wrapper").hide();
					$("#div_alert_s0").html(response.data.s0.msg).show();
				}
			} else {
				$("#tab_s0").hide();
			}
			datatable1.draw();
						
			// Proses server 1 (partnership)
			var datatable2 = $('#tableJogjaPartnership').dataTable().api();
			datatable2.clear();
			if ('s1' in response.data) {
				if (activeTab == -1) {
					activeTab = 1;
					$('#server-tabs li#tab_s1 a:first').tab('show');
				}
				// Ditampilkan hanya jika diminta
				$("#tab_s1").show();
				if ('list_data' in response.data.s1) {
					$("#tabpane_s1 .dataTable_wrapper").show();
			    	datatable2.rows.add(response.data.s1.list_data.data);
			    	$("#div_alert_s1").show();
					var node = document.createTextNode("Jumlah AP yang DOWN : "+response.data.s1.list_data.down);
					document.getElementById('div_alert_s1').appendChild(node);
				} else {
					// Tampilkan error di sini...
					$("#tabpane_s1 .dataTable_wrapper").hide();
					$("#div_alert_s1").html(response.data.s1.msg).show();
				}
			} else {
				$("#tab_s1").hide();
			}
			datatable2.draw();
		},
		error: function(xhr){
			if (xhr.status != 200) {
				$("#div_request_result").html("Maaf, terjadi kesalahan: "+
						xhr.status + " " + xhr.statusText).fadeIn(200);
			} else {
				$("#div_request_result").html("Respon JSON tidak valid.")
					.fadeIn(200);
			}
		}
	}).always(function() {
		isLoading = false;
		$("#div_loader").hide();
		$("#form_cari button[type=submit], #form_cari input[type=text]")
			.removeAttr('disabled');
	});
	event.preventDefault();
}
</script>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $pageHeader;?></h1>
			<div class="panel panel-default">
				<div class="panel-body">
					<form method="POST" action="#submit" id="form_cari">
						<table class="table">
							<tr>
								<th colspan="6">Pilih Server:
									
								</th>
							</tr>
							<tr>
								<td colspan="6">
									<!-- <input type="checkbox" name="selectAll" id="selectAll">  -->
									<a href="#check-all" id="a_serverCheckAll">Pilih Semua</a> |
									<a href="#uncheck-all" id="a_serverUnCheckAll">Kosongkan Semua</a></td>
							</tr>
							<tr>
								<td colspan="3"><input type="checkbox" class="chk_server" name="server[0]"
									id="chk_server1"
									value="10.16.254.70"> <label for="chk_server1">Cisco Sindokom</label></td>
								<td colspan="3"><input type="checkbox" class="chk_server" name="server[1]"
									id="chk_server2"
									value="10.16.55.196"> <label for="chk_server2">Cisco Partnership</label></td>
							</tr>
							<tr>
								<th colspan="6">Mencari Berdasarkan:
								
								</th>
							</tr>
							<tr>
								<td><input type="radio" name="searchBy" value="name"
										id="radio_searchByName" required>
									<label for="radio_searchByName">AP Name</label></td>
								<td><input type="radio" name="searchBy" value="location"
										id="radio_searchByLoc" required> 
									<label for="radio_searchByLoc">Lokasi</label></td>
								<td><input type="radio" name="searchBy" value="ethernetMac"
										id="radio_searchByEthernetMac" required> 
									<label for="radio_searchByEthernetMac">Eth MAC Address</label></td>
								<td><input type="radio" name="searchBy" value="serialNumber"
										id="radio_searchBySerialNumber" required>
									<label for="radio_searchBySerialNumber">Serial Number</label></td>
								<td><input type="radio" name="searchBy" value="macAddress"
										id="radio_searchByMacAddress" required>
									<label for="radio_searchByMacAddress">Radio MAC Address</label></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="6">
									<div class="input-group">
										<input type="text" name="search" class="form-control"
											placeholder="Mencari..." required>
										<span class="input-group-btn">
											<button class="btn btn-primary" type="submit">Cari</button>
										</span>
										<input type='hidden' name='submit' value='1' />
									</div>
									<!-- /input-group -->
								</td>
							</tr>
							<tr>
								<td colspan="6">
									<div id="div_request_result" class="alert alert-danger"></div>
									<?php
									$errString = validation_errors();
									if(! empty ( $errString )){
										echo "<div class= \"alert alert-danger\"><ol type='1'>";
										if(! empty ( $errString )) echo validation_errors('<li>', '</li>');
										echo "</ol></div>";
									}
									?>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div style="min-height: 48px;" >
					<div id="div_loader">
						<img src="<?php echo base_url("/assets/images/loader.gif"); ?>"
							alt="Memuat." /> Sedang Memuat...
					</div>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div id="tab_container">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist" id="server-tabs">
					<li role="presentation" class="active" id="tab_s0"><a href="#jatengjogja"
						aria-controls="jatengjogja" role="tab" data-toggle="tab">Cisco
							Sindokom</a></li>
					<li role="presentation" id="tab_s1"><a href="#jogjapartnership"
						aria-controls="jogjapartnership" role="tab" data-toggle="tab">Cisco
							Partnership</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active"
						id="jatengjogja">
						<!-- DataTables Jateng Jogja -->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Cisco Sindokom (10.16.254.70)
								<?php if (!empty($daftarDevice["jatengjogja"]["msg"]))
										echo $daftarDevice["jatengjogja"]["msg"]; ?></h3>
							</div>
							<div class="panel-body" id="tabpane_s0">
								<div id="div_alert_s0" class="alert alert-danger"></div>
								<div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover"
										id="tableJatengJogja">
										<thead>
											<tr>
												<th rowspan='2' align='center'>AP Name</th>
												<th rowspan='2' align='center'>Lokasi</th>
												<th rowspan='2' align='center'>IP Address</th>
												<th colspan='2' align='center'>Mac Addr</th>
												<th colspan='2' align='center'>Controller</th>
												<th rowspan='2' align='center'>SN</th>
												<th rowspan='2' align='center'>Type</th>
												<th colspan='2' align='center'>Client Count</th>
											</tr>
											<tr>
												<th align='center'>Eth</th>
												<th align='center'>Radio</th>
												<th align='center'>Name</th>
												<th align='center'>IP</th>
												<th align='center'>2,4Ghz</th>
												<th align='center'>5Ghz</th>
											</tr>
										</thead>
										<tbody>
										<?php
										
										 /* if ($daftarDevice["jatengjogja"]["type"]){
										 	foreach ($daftarDevice["jatengjogja"]["list_data"]["data"] as $row){
										 		echo "<tr>";
												echo "<td>".$row->name."</td>";
										 		echo "<td>".$row->location."</td>";
										 		echo "<td>".$row->ipAddress."</td>";
										 		echo "<td>".$row->ethernetMac."</td>";
										 		echo "<td>".$row->macAddress."</td>";
										 		echo "<td>".$row->controllerName."</td>";
										 		echo "<td>".$row->controllerIpAddress."</td>";
										 		echo "<td>".$row->serialNumber."</td>";
										 		echo "<td>".$row->type."</td>";
										 		echo "<td>".$row->clientCount_2_4GHz."</td>";
										 		echo "<td>".$row->clientCount_5GHz."</td>";
										 		echo "</tr>";
										 	}
										 } */
										
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="jogjapartnership">

						<!-- DataTables Jogja Partnership -->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Cisco Partnership (10.16.55.196)
								<?php if (!empty($daftarDevice["jogjapartnership"]["msg"]))
										echo $daftarDevice["jogjapartnership"]["msg"];?></h3>
							</div>
							<div class="panel-body" id="tabpane_s1">
								<div id="div_alert_s1" class="alert alert-danger"></div>
								<div class="dataTable_wrapper">
									<table class="table table-striped table-bordered table-hover"
										id="tableJogjaPartnership">
										<thead>
											<tr>
												<th rowspan='2' align='center'>AP Name</th>
												<th rowspan='2' align='center'>Lokasi</th>
												<th rowspan='2' align='center'>IP Address</th>
												<th colspan='2' align='center'>Mac Addr</th>
												<th colspan='2' align='center'>Controller</th>
												<th rowspan='2' align='center'>SN</th>
												<th rowspan='2' align='center'>Type</th>
												<th colspan='2' align='center'>Client Count</th>
											</tr>
											<tr>
												<th align='center'>Eth</th>
												<th align='center'>Radio</th>
												<th align='center'>Name</th>
												<th align='center'>IP</th>
												<th align='center'>2,4Ghz</th>
												<th align='center'>5Ghz</th>
											</tr>
										</thead>
										<tbody>
										<?php
										
										 /* foreach ($daftarDevice["jogjapartnership"]["list_data"]["data"] as $row){
										 	echo "<tr>";
										 	echo "<td>".$row->name."</td>";
										 	echo "<td>".$row->location."</td>";
											echo "<td>".$row->ipAddress."</td>";
											echo "<td>".$row->ethernetMac."</td>";
											echo "<td>".$row->macAddress."</td>";
											echo "<td>".$row->controllerName."</td>";
											echo "<td>".$row->controllerIpAddress."</td>";
											echo "<td>".$row->serialNumber."</td>";
											echo "<td>".$row->type."</td>";
											echo "<td>".$row->clientCount_2_4GHz."</td>";
											echo "<td>".$row->clientCount_5GHz."</td>";
											echo "</tr>";
										 } */
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div> <!-- End div container dataTables -->
		</div>
	</div>
	<!-- /.row -->

</div>
<!-- /#page-wrapper -->
