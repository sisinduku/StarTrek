/**
 * Inisialisasi DataTables
 */

$(document).ready(function() {
	$("#selectAll").change(function() {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
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
		"scrollX" : true,
		responsive : true
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
		"scrollX" : true,
		responsive : true
	});
});