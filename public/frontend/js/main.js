$(document).ready(function () {
    $(".slider").slick({
      dots: true,               // Show dots for pagination
      infinite: true,           // Enable infinite scrolling
      slidesToShow: 1,          // Number of slides to show at once
      slidesToScroll: 1,        // Number of slides to scroll
      autoplay: true,           // Autoplay slides
      autoplaySpeed: 3000,      // Time between each slide (3 seconds)
   
    });
  });

  
  $(document).ready(function () {
$(".news-slider").slick({
dots: true,               // Show dots for pagination
infinite: true,           // Enable infinite scrolling
slidesToShow: 3,          // Number of slides to show at once
slidesToScroll: 1,        // Number of slides to scroll
autoplay: true,           // Autoplay slides
autoplaySpeed: 3000,      // Time between each slide (3 seconds)

responsive: [
  {
    breakpoint: 1024,     // At 1024px screen width
    settings: {
      slidesToShow: 3,    // Show 3 slides
    }
  },
  {
    breakpoint: 768,      // At 768px screen width (tablet)
    settings: {
      slidesToShow: 2,    // Show 2 slides
    }
  },
  {
    breakpoint: 480,      // At 480px screen width (mobile)
    settings: {
      slidesToShow: 1,    // Show 1 slide
    }
  }
]
});
});