// Extra function to control menu state from anywhere on your page/ inside your script
	function expandfullscreenmenu(action){ //param: 'open', 'close', or empty to toggle menu state
		var togglebox = document.getElementById("togglebox")
		var newstate =	(action == 'open')? true : (action == 'close')? false : !togglebox.checked
		togglebox.checked = newstate
    }


    $('#carouselExample').on('slide.bs.carousel', function (e) {


        var $e = $(e.relatedTarget);
        var idx = $e.index();
        var itemsPerSlide = 7;
        var totalItems = $('.carousel-item').length;

        if (idx >= totalItems-(itemsPerSlide-1)) {
            var it = itemsPerSlide - (totalItems - idx);
            for (var i=0; i<it; i++) {
                // append slides to end
                if (e.direction=="left") {
                    $('.carousel-item').eq(i).appendTo('.carousel-inner');
                }
                else {
                    $('.carousel-item').eq(0).appendTo('.carousel-inner');
                }
            }
        }
    });


      $('#carouselExample').carousel({
                    interval: 2000
            });


            $('.owl-carousel').owlCarousel({
                loop:true,
                margin:10,
                nav:true,

                responsive:{
                    0:{
                        items:2
                    },
                    600:{
                        items:4
                    },
                    1000:{
                        items:4
                    }
                }
            })

            $('.owl-carousel-product').owlCarousel({
                loop:true,
                margin:25,
                nav:true,

                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:4
                    },
                    1000:{
                        items:4
                    }
                }
            })






      // Slider
      $('#preference').modal('show');
      $('#preference').modal({
        show: false,
        backdrop: 'static'
    })

//tooltip
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

/*--- Range slider-- */

