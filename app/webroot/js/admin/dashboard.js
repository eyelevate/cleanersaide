/* [ ---- Gebo Admin Panel - dashboard ---- ] */

	$(document).ready(function() {
		//* small charts
		//gebo_peity.init();
		//* charts
		//gebo_charts.fl_1();
		//gebo_charts.fl_2();
		//* sortable/searchable list
		
		$(".sendPackage").click(function(){
			window.location.replace("/reservations/add/checkout");
		});
		
	sidebar.deleteSidebar();
	sidebar.clearcart();

		gebo_flist.init();
		
		//* responsive table
		gebo_media_table.init();
		//* resize elements on window resize
		var lastWindowHeight = $(window).height();
		var lastWindowWidth = $(window).width();
		$(window).on("debouncedresize",function() {
			if($(window).height()!=lastWindowHeight || $(window).width()!=lastWindowWidth){
				lastWindowHeight = $(window).height();
				lastWindowWidth = $(window).width();
				//* rebuild calendar
				$('#calendar').fullCalendar('render');
			}
		});
		//* small gallery grid
        gebo_gal_grid.small();
		
		//* to top
		$().UItoTop({inDelay:200,outDelay:200,scrollSpeed: 500});
		
		
		//* datepicker
		gebo_datepicker.init();
		//* timepicker
		//gebo_timepicker.init();
	
	
	$('.bargraph').visualize({ 
      type: 'bar',
      height: '200px',
      colors: ['#005ba8','#1175c9','#92d5ea','#ee8310','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744'], 
      appendTitle: false
    });

    $('.linegraph').visualize({ 
      type: 'line',
      height: '200px',
      lineWeight: 2,
      colors: ['#005ba8','#1175c9','#92d5ea','#ee8310','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744'],
      appendTitle: false
    });

    $('.areagraph').visualize({ 
      type: 'bar',
      height: '210px',
      lineWeight: 1,
      colors: ['#CA9397', '#8f8f8f','#a7a7a7','#bdbdbd','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744'],
      appendTitle: false
    });
    
    $('.piechart').visualize({ 
      type: 'pie',
      height: '250px',
      width: '300px',
      lineWeight: 1,
      colors: ['#BDBCBD','#CA9397','#6c6c6c','#ee8310','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744'],
      appendTitle: false,
      textColors: ['#231f20','#ad2a30']
    });

    $('.linegraph').hide(); 
    $('.bargraph').hide();
    $('.areagraph').hide();
    $('.piechart').hide();
		

	
	});
	
	//* bootstrap datepicker
	gebo_datepicker = {
		init: function() {
			$('#dp1').datepicker().on('changeDate', function(ev){
				$("#dp1").datepicker('hide');
			});
			$('#dp2').datepicker().on('changeDate', function(ev){
				$("#dp2").datepicker('hide');
			});

			$("#dp3").datepicker().change(function() {
				var date = $(this).val();
				gebo_datepicker.editSelect(date, '#addEditSelectableDates','#selectedSpan');
				
				$(this).val('');
				$(this).blur();
			});

		}, 
		editSelect: function(date, updateClass, updateCount){ //creates a multi select of the datepicker
			var oldCount = $(updateClass+" li").length;
			var count = parseInt(oldCount)+1;
			var code_append = '<li class="label label-info" style="margin-bottom:1; margin-top:1px; margin-right:0px; margin-left:0px;"><button type="button" class="close closeEditSchedule" count="'+count+'">×</button><span class="date_to_edit">'+date+'</span></li>';
			$(updateClass).append(code_append).fadeIn('slow');
			gebo_datepicker.editCounter(count,updateCount);
			gebo_datepicker.minusCounter(count,updateClass,updateCount);
			
		}, 
		editCounter: function(count,counterClass){ //adds to the counter
			$(counterClass).html(count);	
		},
		minusCounter: function(count,updateClass,counterClass){ //removes from the counter
			$(".closeEditSchedule[count='"+count+"']").click(function(){
				$(this).parent().fadeTo("slow", 0.00, function(){ //fade           	
	                $(this).remove(); //then remove from the DOM
	                var newCount = $(updateClass+" li").length;
	                $(counterClass).html(newCount);
	            });
         	});
		}
	};
	

	//* filterable list
	gebo_flist = {
		init: function(){
			//*typeahead
			var list_source = [];
			$('.user_list li').each(function(){
				var search_name = $(this).find('.sl_name').text();
				//var search_email = $(this).find('.sl_email').text();
				list_source.push(search_name);
			});
			// commented out 10/9 JFD
			//$('.user-list-search').typeahead({source: list_source, items:5});
			
			var pagingOptions = {};
			var options = {
				valueNames: [ 'sl_name', 'sl_status', 'sl_email' ],
				page: 10,
				plugins: [
					[ 'paging', {
						pagingClass	: "bottomPaging",
						innerWindow	: 1,
						left		: 1,
						right		: 1
					} ]
				]
			};
			var userList = new List('user-list', options);
			
			$('#filter-online').on('click',function() {
				$('ul.filter li').removeClass('active');
				$(this).parent('li').addClass('active');
				userList.filter(function(item) {
					if (item.values().sl_status == "online") {
						return true;
					} else {
						return false;
					}
				});
				return false;
			});
			$('#filter-offline').on('click',function() {
				$('ul.filter li').removeClass('active');
				$(this).parent('li').addClass('active');
				userList.filter(function(item) {
					if (item.values().sl_status == "offline") {
						return true;
					} else {
						return false;
					}
				});
				return false;
			});
			$('#filter-none').on('click',function() {
				$('ul.filter li').removeClass('active');
				$(this).parent('li').addClass('active');
				userList.filter();
				return false;
			});
			
			$('#user-list').on('click','.sort',function(){
					$('.sort').parent('li').removeClass('active');
					if($(this).parent('li').hasClass('active')) {
						$(this).parent('li').removeClass('active');
					} else {
						$(this).parent('li').addClass('active');
					}
				}
			);
		}
	};
	
	//* gallery grid
    gebo_gal_grid = {
        small: function() {
            //* small gallery grid
            $('#small_grid ul').imagesLoaded(function() {
                // Prepare layout options.
                var options = {
                  autoResize: true, // This will auto-update the layout when the browser window is resized.
                  container: $('#small_grid'), // Optional, used for some extra CSS styling
                  offset: 6, // Optional, the distance between grid items
                  itemWidth: 120, // Optional, the width of a grid item (li)
				  flexibleItemWidth: false
                };
                
                // Get a reference to your grid items.
                var handler = $('#small_grid ul li');
                
                // Call the layout function.
                handler.wookmark(options);
                
                $('#small_grid ul li > a').attr('rel', 'gallery').colorbox({
                    maxWidth	: '80%',
                    maxHeight	: '80%',
                    opacity		: '0.2', 
                    loop		: false,
                    fixed		: true
                });
            });
        }
    };
	
	//* calendar
	
	
    //* responsive tables
    gebo_media_table = {
        init: function() {
			$('.mediaTable').mediaTable();
        }
    };
    
    sidebar = {
	//delete individual trips form the ferry sidebar
	deleteSidebar: function(){
		$(".removeFerry").click(function(){
			if(confirm('Are you sure you want to remove this trip from the cart?')){
				var thisRow = $(this).attr('row');

				if(thisRow == '0' || thisRow == ''){
					thisRow = 'zero';
				}
				$(this).parents('li:first').remove();
				$.post(
					'/reservations/request_delete_sidebar',
					{
						type:'RESERVATION_DELETE_SIDEBAR',
						deleteSidebar: thisRow
					},	function(results){
						var countFerry = $(".ferrySidebarLi").length;
						var countHotel = $(".hotelSidebarLi").length;
						var countAttraction = $(".attractionSidebarLi").length;
						var countPackage = $(".packageSidebarLi").length;
						
						var totalCount = countFerry + countHotel + countAttraction + countPackage;
						$("#countReservation").html(totalCount);	
						location.reload();					
			
					}
				);					
				
			}
		});
		$(".removeHotel").click(function(){
			if(confirm('Are you sure you want to remove this hotel from the cart?')){
				var thisRow = $(this).attr('row');
				if(thisRow == '0' || thisRow == ''){
					thisRow = 'zero';
				}
				$(this).parent().remove();
				$.post(
					'/reservations/request_delete_hotel',
					{
						type:'RESERVATION_DELETE_HOTEL',
						deleteSidebar: thisRow
					},	function(results){
						var countFerry = $(".ferrySidebarLi").length;
						var countHotel = $(".hotelSidebarLi").length;
						var countAttraction = $(".attractionSidebarLi").length;
						var countPackage = $(".packageSidebarLi").length;
						
						var totalCount = countFerry + countHotel + countAttraction + countPackage;
						$("#countReservation").html(totalCount);						
						location.reload();
					}
				);					
				
			}
		});		
		$(".removeAttraction").click(function(){
			if(confirm('Are you sure you want to remove this attraction from the cart?')){
				var thisRow = $(this).attr('row');
				if(thisRow == '0' || thisRow == ''){
					thisRow = 'zero';
				}
				$(this).parent().remove();
				$.post(
					'/reservations/request_delete_attraction',
					{
						type:'RESERVATION_DELETE_ATTRACTION',
						deleteSidebar: thisRow
					},	function(results){
						var countFerry = $(".ferrySidebarLi").length;
						var countHotel = $(".hotelSidebarLi").length;
						var countAttraction = $(".attractionSidebarLi").length;
						var countPackage = $(".packageSidebarLi").length;
						
						var totalCount = countFerry + countHotel + countAttraction + countPackage;
						$("#countReservation").html(totalCount);						
						location.reload();
					}
				);					
				
			}
		});	
		$(".removePackage").click(function(){
			if(confirm('Are you sure you want to remove this package from the cart?')){
				var thisRow = $(this).attr('row');
				if(thisRow == '0' || thisRow ==''){
					thisRow = 'zero';
				}
				$(this).parent().parent().remove();
				$.post(
					'/reservations/request_delete_package',
					{
						type:'RESERVATION_DELETE_PACKAGE',
						deleteSidebar: thisRow
					},	function(results){
						var countFerry = $(".ferrySidebarLi").length;
						var countHotel = $(".hotelSidebarLi").length;
						var countAttraction = $(".attractionSidebarLi").length;
						var countPackage = $(".packageSidebarLi").length;
						
						var totalCount = countFerry + countHotel + countAttraction + countPackage;
						$("#countReservation").html(totalCount);
						location.reload();
					}
				);					
				
			}
		});				
	},
	//delete the whole entire cart
	clearcart: function(){ //currently not in use
		$("#clearcart").click(function(e){
			if(confirm('Are you sure you would like to remove all contents from your cart?')){
				//remove all of the ferry data
				$(".ferrySidebarLi").remove();
				//remove all of the hotel data
				$(".hotelSidebarLi").remove();
				
				//remove all of the attraction data
				$(".attractionSidebarLi").remove();
				
				//remove all of the package data
				$('.packageSidebarLi').remove();
				$.post(
					'/reservations/request_clear_cart',
					{
						type:'RESERVATION_CLEAR_CART',
					},	function(results){
						
						var countFerry = $(".ferrySidebarLi").length;
						var countHotel = $(".hotelSidebarLi").length;
						var countAttraction = $(".attractionSidebarLi").length;
						var countPackage = $(".packageSidebarLi").length;
						
						var totalCount = countFerry + countHotel + countAttraction + countPackage;
						$("#countReservation").html(totalCount);			
					}
				);				
			}
			// Prevent the anchor's default click action
		    e.preventDefault();
		});
	}
}


	

