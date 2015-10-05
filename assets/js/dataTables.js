/**
 * Inisialisasi DataTables
 */

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
	$("#btn-search").click(function(){
		$("#panel-form").toggle(500);
		return false;
	});

	$('#tableJatengJogja').DataTable({
		language : langDataTables,
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
			{ data: "location", width: "400px"},
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
		language : langDataTables,
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
			{ data: "location", width: "400px"},
			{ data: "ipAddress"},
			{ data: "ethernetMac"},
			{ data: "macAddress" },
			{ data: "controllerName" },
			{ data: "controllerIpAddress" },
			{ data: "serialNumber" },
			{ data: "type" },
			{ data: "clientCount_2_4GHz" },
			{ data: "clientCount_5GHz" }
		], "autoWidth": true
	});

	$('#tableAutelan').DataTable({
		language : langDataTables,
		"lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
		"scrollX" : true,
		"scrollY": "800px",
		"scrollCollapse": true,
		responsive : true,
		"createdRow": function( row, data, dataIndex ) {
		    if ( data.status.toLowerCase() == "down" ) {
		        $(row).addClass( 'row-down' );
		    }
		},
		"autoWidth" : true,
		// Settingan kolom untuk mapping dari JSON
		"columns": [
			{ data: "loc_id" },
			{ data: "ap_name"},
			{ data: "location", width: "400px"},
			{ data: "ap_ip_address"},
			{ data: "mac_address" },
			{ data: "status" }
		]
	});

	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
	     var t = $($.fn.dataTable.tables( {visible: true, api: true} )).dataTable().api();
	     t.columns.adjust();
	} );
	
});