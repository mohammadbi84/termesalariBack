$(function () {

	//------------------------------Data Table----------------------------------
	    $('#dataTable-table').DataTable({
	        "language": {
	            "paginate": {
	                "next": "بعدی",
	                "previous" : "قبلی",
	            },
	            // "searchPanes":{
	            // 	"count":'{total} found',
	            // 	"countFiltered": '{shown} ({total})',
	            // },
	            "decimal": ",",
	            "thousands": ".",
	            "search" : "جستجو : ",
	            "lengthMenu":'نمایش   <select>'+
	                '<option value="10">10</option>'+
	                '<option value="20">20</option>'+
	                '<option value="30">30</option>'+
	                '<option value="40">40</option>'+
	                '<option value="50">50</option>'+
	                '<option value="-1">همه</option>'+
	                '</select> سطر' ,

	        },
			"info" : false,
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"autoWidth": true,
			"scrollX": true,
	       	"responsive": true,
	       	"order":[],
	       	"columnDefs":[
		       	{ "targets":'no-sort',"orderable":false,},
		       	{ "width": "10%", "targets": 9 }
	       	],
	       	// "saerchPanes":{
	       	// 	"viewTotal":true,
	       	// },
	       	// "dom":'Pfrtip'

			
	    });

});