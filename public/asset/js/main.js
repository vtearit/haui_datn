
        $(document).ready(function () {
            $(".icon").click(function () {
                $("#myMenu").toggleClass("active");
                $("#coat").addClass("active")
            });
            $("#coat").click(function () {
                $("#coat,#myMenu").removeClass("active");
            });

            var owl = $('.owl-carousel');
            owl.owlCarousel({
                loop: true,
                margin: 10,
                navRewind: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            })
        });
