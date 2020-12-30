$(document).ready(function() {



	 $(".owl-item1").owlCarousel({

          autoPlay 					: 5000, //Set AutoPlay to 5 seconds
          navigation 				: true,
          navigationText 		: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
          pagination 				: false,
          items 						: 1,
          itemsDesktop 			: [1199,1],
          itemsDesktopSmall : [979,1],
          itemsTablet       : [768,1],
          itemsMobile       : [479,1]

        });

		 $(".owl-item2").owlCarousel({

	          autoPlay          : false, //Set AutoPlay to 3 seconds
	          navigation 				: true,
	          navigationText 	: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
	          pagination        : false,
						lazyLoad 					: true,
	          items             : 4,
	          itemsDesktop      : [1199,4],
	          itemsDesktopSmall : [979,4],
	          itemsTablet       : [768,3],
	          itemsMobile       : [479,2]

	        });


		 $(".owl-item3").owlCarousel({

	          autoPlay          : 3000, //Set AutoPlay to 3 seconds
	          navigation 				: true,
	          navigationText 		: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
	          pagination        : false,
						lazyLoad 					: true,
	          items             : 4,
	          itemsDesktop      : [1199,4],
	          itemsDesktopSmall : [979,4],
	          itemsTablet       : [768,3],
	          itemsMobile       : [479,2]

	        });

		$(".owl-item4").owlCarousel({

					 autoPlay          	: false, //Set AutoPlay to 3 seconds
					 navigation 				: true,
					 navigationText 		: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
					 pagination        	: false,
					 items             	: 5,
					 itemsDesktop      	: [1199,5],
					 itemsDesktopSmall 	: [979,5],
					 itemsTablet       	: [768,3],
					 itemsMobile       	: [479,2]

				 });

			$(".latestVideos").owlCarousel({

		        autoPlay 						: 6000, //Set AutoPlay to 4 seconds
						navigation 					: true,
						navigationText 			: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		        pagination 		  		: true,
		        paginationNumbers 	: true,
						lazyLoad 						: true,
		        items 			  			: 1,
		        itemsDesktop      	: [1199,1],
		        itemsDesktopSmall 	: [979,1],
		        itemsTablet       	: [768,1],
		        itemsMobile       	: [479,1]
		      });

      var sync1 = $("#slideImage");
      var sync2 = $("#slideThumbImage");

			sync1.owlCarousel({
        autoPlay 						: 5000, //Set AutoPlay to 4 seconds
				navigation 					: true,
				navigationText 			: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        pagination 		  		: false,
				lazyLoad 						: true,
        items 			  			: 1,
        itemsDesktop      	: [1199,1],
        itemsDesktopSmall 	: [979,1],
        itemsTablet       	: [768,1],
        itemsMobile       	: [479,1],
        afterAction 					: syncPosition,
        responsiveRefreshRate : 200,
      });

      sync2.owlCarousel({
        items 								: 8,
        itemsDesktop      		: [1199,8],
        itemsDesktopSmall 		: [979,8],
        itemsTablet       		: [768,8],
        itemsMobile       		: [479,8],
        pagination 		  			: false,
				lazyLoad 							: true,
        responsiveRefreshRate : 100,
        afterInit : function(el){
          el.find(".owl-item").eq(0).addClass("synced");
        }
      });

      function syncPosition(el){
        var current = this.currentItem;
        $("#slideThumbImage")
          .find(".owl-item")
          .removeClass("synced")
          .eq(current)
          .addClass("synced")
        if($("#slideThumbImage").data("owlCarousel") !== undefined){
          center(current)
        }
      }

      $("#slideThumbImage").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo",number);
      });

      function center(number){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

        var num = number;
        var found = false;
        for(var i in sync2visible){
          if(num === sync2visible[i]){
            var found = true;
          }
        }

        if(found===false){
          if(num>sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", num - sync2visible.length+2)
          }else{
            if(num - 1 === -1){
              num = 0;
            }
            sync2.trigger("owl.goTo", num);
          }
        } else if(num === sync2visible[sync2visible.length-1]){
          sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
          sync2.trigger("owl.goTo", num-1)
        }
      }
});
