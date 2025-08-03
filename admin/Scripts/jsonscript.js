
	$(document).ready(function () {


	// Leads List

	if($('#leads_list').length > 0) {
		var readytable = $('#leads_list').DataTable({
				"bFilter": false, 
			"bInfo": false,
			"searching": true,
					"ordering": true,
				"autoWidth": true,"autoWidth": true,
				"language": {
					search: ' ',
					sLengthMenu: '_MENU_',
					searchPlaceholder: "Search",
					info: "_START_ - _END_ of _TOTAL_ items",
					"lengthMenu":     "Show _MENU_ entries",
					paginate: {
						next: 'Next <i class=" fa fa-angle-right"></i> ',
						previous: '<i class="fa fa-angle-left"></i> Prev '
					},
					},
				initComplete: (settings, json)=>{
					$('.dataTables_paginate').appendTo('.datatable-paginate');
					$('.dataTables_length').appendTo('.datatable-length');
				},	
				"data":[
					{
						"id" : 1,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Collins",
						"company_name" : "NovaWave LLC",
						"company_image" : "images/icons/company-icon-01.svg",
						"company_address" : "Newyork, USA",
						"phone" : "+1 875455453",
						"email" : "robertson@example.com",
						"created_date" : "25 Sep 2023, 01:22 pm",
						"owner" : "Hendry",
						"source" : "Paid Social",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Konopelski",
						"company_name" : "BlueSky Industries",
						"company_image" : "images/icons/company-icon-02.svg",
						"company_address" : "Winchester, KY",
						"phone" : "+1 989757485",
						"email" : "sharon@example.com",
						"created_date" : "29 Sep 2023, 04:15 pm",
						"owner" : "Guillory",
						"source" : "Referrals",
						"status" : "2",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Adams",
						"company_name" : "SilverHawk",
						"company_image" : "images/icons/company-icon-03.svg",
						"company_address" : "Jametown, NY",
						"phone" : "+1 546555455",
						"email" : "vaughan12@example.com",
						"created_date" : "04 Oct 2023, 10:18 am",
						"owner" : "Jami",
						"source" : "Campaigns",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Schumm",
						"company_name" : "SummitPeak",
						"company_image" : "images/icons/company-icon-04.svg",
						"company_address" : "Compton, RI",
						"phone" : "+1 454478787",
						"email" : "jessica13@example.com",
						"created_date" : "17 Oct 2023, 03:31 pm",
						"owner" : "Theresa",
						"source" : "Google",
						"status" : "3",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Wisozk",
						"company_name" : "RiverStone Ventur",
						"company_image" : "images/icons/company-icon-05.svg",
						"company_address" : "Dayton, OH",
						"phone" : "+1 124547845",
						"email" : "caroltho3@example.com",
						"created_date" : "24 Oct 2023, 09:14 pm",
						"owner" : "Espinosa",
						"source" : "Paid Social",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Heller",
						"company_name" : "Bright Bridge Grp",
						"company_image" : "images/icons/company-icon-06.svg",
						"company_address" : "Lafayette, LA",
						"phone" : "+1 478845447",
						"email" : "dawnmercha@example.com",
						"created_date" : "08 Nov 2023, 09:56 am",
						"owner" : "Martin",
						"source" : "Referrals",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Gutkowski",
						"company_name" : "CoastalStar Co.",
						"company_image" : "images/icons/company-icon-07.svg",
						"company_address" : "Centerville, VA",
						"phone" : "+1 215544845",
						"email" : "rachel@example.com",
						"created_date" : "14 Nov 2023, 04:19 pm",
						"owner" : "Newell",
						"source" : "Campaigns",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Walter",
						"company_name" : "HarborView",
						"company_image" : "images/icons/company-icon-08.svg",
						"company_address" : "Providence, RI",
						"phone" : "+1 121145471",
						"email" : "jonelle@example.com",
						"created_date" : "23 Nov 2023, 11:14 pm",
						"owner" : "Janet",
						"source" : "Google",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Hansen",
						"company_name" : "Golden Gate Ltd",
						"company_image" : "images/icons/company-icon-09.svg",
						"company_address" : "Swayzee, IN",
						"phone" : "+1 321454789",
						"email" : "jonathan@example.com",
						"created_date" : "10 Dec 2023, 06:43 am",
						"owner" : "Craig",
						"source" : "Paid Social",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"lead_name" : "Leuschke",
						"company_name" : "Redwood Inc",
						"company_image" : "images/icons/company-icon-10.svg",
						"company_address" : "Florida City, FL",
						"phone" : "+1 278907145",
						"email" : "brook@example.com",
						"created_date" : "25 Dec 2023, 08:17 pm",
						"owner" : "Daniel",
						"source" : "Referrals",
						"status" : "1",
						"Action" : ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="fa fa-star"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="leads-details.html" class="title-name">'+row['lead_name']+'</a>';
				}},
				{ "render": function ( data, type, row ){
					return '<h2 class="table-avatar d-flex align-items-center"><a href="company-details.html" class="company-img"><img class="avatar-img" src="'+row['company_image']+'" alt="User Image"></a><a href="company-details.html" class="profile-split d-flex flex-column">'+row['company_name']+'<span>'+row['company_address']+' </span></a></h2>';
				}},
				{ "data": "phone" },
				{ "data": "email" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Closed" } else if(row['status'] == "1") { var class_name = "bg-danger";var status_name ="Lost" } else if(row['status'] == "2") { var class_name = "bg-pending";var status_name ="Not Contacted"}
					else { var class_name = "bg-warning";var status_name ="Contacted"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['owner']+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item edit-popup" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash text-danger"></i> Delete</a><a class="dropdown-item" href="#"><i class="ti ti-clipboard-copy text-blue-light"></i> Clone</a></div></div>';
				}}
			]
		});
	}
		$('#customSearch').on('keyup', function () {
			readytable.search(this.value).draw();
		});

	if ($('#deals-project').length > 0) {
		$('#deals-project').DataTable({
			"bFilter": false,
			"bInfo": false,
			"ordering": false,
			"paging": false,
			"data": [
				{
					"id": 1,
					"deal_name": "Collins",
					"stage": "Conversation",
					"deal_value": "$04,51,000",
					"probability": "85%",
					"status": "1"
				},
				{
					"id": 2,
					"deal_name": "Konopelski",
					"stage": "Pipeline",
					"deal_value": "$14,51,000",
					"probability": "56%",
					"status": "2"
				},
				{
					"id": 3,
					"deal_name": "Adams",
					"stage": "Won",
					"deal_value": "$12,51,000",
					"probability": "15%",
					"status": ""
				},
				{
					"id": 4,
					"deal_name": "Schumm",
					"stage": "Lost",
					"deal_value": "$51,000",
					"probability": "45%",
					"status": "1"
				},
				{
					"id": 5,
					"deal_name": "Wisozk",
					"stage": "Follow Up",
					"deal_value": "$67,000",
					"probability": "5%",
					"status": "2"
				}

			],
			"columns": [
				{ "data": "deal_name" },
				{ "data": "stage" },
				{ "data": "deal_value" },
				{ "data": "probability" },
				{
					"render": function (data, type, row) {
						if (row['status'] == "0") { var class_name = "bg-pending"; var status_name = "Open" } if (row['status'] == "1") { var class_name = "bg-danger"; var status_name = "Lost" } else { var class_name = "bg-success"; var status_name = "Won" }
						return '<span class="badge badge-pill  ' + class_name + '" >' + status_name + '</span>';
					}
				},
			]
		});
	}


});