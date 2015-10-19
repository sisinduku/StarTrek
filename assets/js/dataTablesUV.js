/**
 * Adjust dataTables
 */
$(document).ready(function(){
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
	     var t = $($.fn.dataTable.tables( {visible: true, api: true} )).dataTable().api();
	     t.columns.adjust();
	} );
});