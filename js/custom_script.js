jQuery(document).ready(function() {

    jQuery('.dTable').DataTable( {
  		"ordering": false,
	});

	jQuery('.dTableCustom').DataTable( {
  		"paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
	});


});