<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $pageHeader;?></h1>
			<div class="panel panel-default">
				<div class="panel-body">
					<form method="POST" action="<?php echo site_url("main/lihat_api/ap");?>">
						<table class="table">
							<tr>
								<th colspan="6">Pilih Server:
								
								</th>
							</tr>
							<tr>
								<td colspan="6"><input type="checkbox" name="selectAll"
									id="selectAll"> Pilih Semua</td>
							</tr>
							<tr>
								<td colspan="3"><input type="checkbox" name="server" id="server"
									value="sindokom"> Cisco Sindokom</td>
								<td colspan="3"><input type="checkbox" name="server" id="server"
									value="partnership"> Cisco Partnership</td>
							</tr>
							<tr>
								<th colspan="6">Mencari Berdasarkan:
								
								</th>
							</tr>
							<tr>
								<td><input type="radio" name="searchBy" value="name"> AP Name</td>
								<td><input type="radio" name="searchBy" value="location"> Lokasi</td>
								<td><input type="radio" name="searchBy" value="ethernetMac"> Eth
									MAC Address</td>
								<td><input type="radio" name="searchBy" value="serialNumber">
									Serial Number</td>
								<td><input type="radio" name="searchBy" value="macAddress">
									Radio MAC Address</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="6">
									<div class="input-group">
										<input type="text" name="seacrh" class="form-control"
											placeholder="Mencari..." required> <span class="input-group-btn">
											<button class="btn btn-primary" type="submit">Cari</button>
										</span>
									</div>
									<!-- /input-group -->
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#jatengjogja"
						aria-controls="jatengjogja" role="tab" data-toggle="tab">Cisco
							Sindokom</a></li>
					<li role="presentation"><a href="#jogjapartnership"
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
								<h3 class="panel-title">Cisco Sindokom (10.16.254.70) <?php echo $daftarDevice["jatengjogja"]["msg"];?></h3>
							</div>
							<div class="panel-body">
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
										/*
										 * if ($daftarDevice["jatengjogja"]["type"]){
										 * foreach ($daftarDevice["jatengjogja"]["list_data"]["data"] as $row){
										 * echo "<tr>";
										 * echo "<td>".$row->name."</td>";
										 * echo "<td>".$row->location."</td>";
										 * echo "<td>".$row->ipAddress."</td>";
										 * echo "<td>".$row->ethernetMac."</td>";
										 * echo "<td>".$row->macAddress."</td>";
										 * echo "<td>".$row->controllerName."</td>";
										 * echo "<td>".$row->controllerIpAddress."</td>";
										 * echo "<td>".$row->serialNumber."</td>";
										 * echo "<td>".$row->type."</td>";
										 * echo "<td>".$row->clientCount_2_4GHz."</td>";
										 * echo "<td>".$row->clientCount_5GHz."</td>";
										 * echo "</tr>";
										 * }
										 * }
										 */
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
								<h3 class="panel-title">Cisco Partnership (10.16.55.196) <?php echo $daftarDevice["jogjapartnership"]["msg"];?></h3>
							</div>
							<div class="panel-body">
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
										/*
										 * foreach ($daftarDevice["jogjapartnership"]["list_data"]["data"] as $row){
										 * echo "<tr>";
										 * echo "<td>".$row->name."</td>";
										 * echo "<td>".$row->location."</td>";
										 * echo "<td>".$row->ipAddress."</td>";
										 * echo "<td>".$row->ethernetMac."</td>";
										 * echo "<td>".$row->macAddress."</td>";
										 * echo "<td>".$row->controllerName."</td>";
										 * echo "<td>".$row->controllerIpAddress."</td>";
										 * echo "<td>".$row->serialNumber."</td>";
										 * echo "<td>".$row->type."</td>";
										 * echo "<td>".$row->clientCount_2_4GHz."</td>";
										 * echo "<td>".$row->clientCount_5GHz."</td>";
										 * echo "</tr>";
										 * }
										 */
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- /.row -->

</div>
<!-- /#page-wrapper -->