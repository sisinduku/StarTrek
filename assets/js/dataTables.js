/**
 * Inisialisasi DataTables
 */

$(document).ready(function() {
	$("#selectAll").change(function() {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
	
	$("#a_serverCheckAll").click(function() {
		$("input:checkbox").prop('checked', 'checked');
		return false;
	});
	$("#a_serverUnCheckAll").click(function() {
		$("input:checkbox").removeAttr('checked');
		return false;
	});

	$('#tableJatengJogja').DataTable({
		language : {
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
		},
		"lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
		"scrollX" : true,
		"scrollY": "800px",
		"scrollCollapse": true,
		responsive : true,
		"createdRow": function( row, data, dataIndex ) {
		    if ( data.controllerName == "DOWN" ) {
		        $(row).addClass( 'row-down' );
		    }
		},// Settingan kolom untuk mapping dari JSON
		columns: [
			{ data: "name" },
			{ data: "location"},
			{ data: "ipAddress"},
			{ data: "ethernetMac"},
			{ data: "macAddress" },
			{ data: "controllerName" },
			{ data: "controllerIpAddress" },
			{ data: "serialNumber" },
			{ data: "type" },
			{ data: "clientCount_2_4GHz" },
			{ data: "clientCount_5GHz" }
		]
	});

	$('#tableJogjaPartnership').DataTable({
		language : {
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
		},
		"lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
		"scrollX" : true,
		"scrollY": "800px",
		"scrollCollapse": true,
		responsive : true,
		"createdRow": function( row, data, dataIndex ) {
		    if ( data.controllerName == "DOWN" ) {
		        $(row).addClass( 'row-down' );
		    }
		},
		// Settingan kolom untuk mapping dari JSON
		"columns": [
			{ data: "name" },
			{ data: "location"},
			{ data: "ipAddress"},
			{ data: "ethernetMac"},
			{ data: "macAddress" },
			{ data: "controllerName" },
			{ data: "controllerIpAddress" },
			{ data: "serialNumber" },
			{ data: "type" },
			{ data: "clientCount_2_4GHz" },
			{ data: "clientCount_5GHz" }
		]
	});
	
	$('#tableAutelan').DataTable({
		language : {
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
		},
		"lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
		"scrollX" : true,
		"scrollY": "800px",
		"scrollCollapse": true,
		responsive : true,
		"autoWidth" : false,
		// Settingan kolom untuk mapping dari JSON
		"columns": [
			{ data: "loc_id" },
			{ data: "ap_name"},
			{ data: "location", width: "50%"},
			{ data: "ap_ip_address"},
			{ data: "mac_address" },
			{ data: "status" }
		]
	});
	
});