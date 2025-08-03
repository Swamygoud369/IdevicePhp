$(document).ready(function () {


   const htmlEl = $('html');
    const bodyEl = $('body');
    const themeIcon = $('#theme-icon');
    
    // Load saved theme
    let currentTheme = localStorage.getItem('theme') || 'light';
    htmlEl.attr('data-bs-theme', currentTheme);
    bodyEl.toggleClass('dark-mode', currentTheme === 'dark');
    updateIcon(currentTheme);

    // On toggle
    $('#toggle-theme').click(function () {
      console.log("changes first");
      currentTheme = htmlEl.attr('data-bs-theme') === 'dark' ? 'light' : 'dark';
      htmlEl.attr('data-bs-theme', currentTheme);
      bodyEl.toggleClass('dark-mode', currentTheme === 'dark');
      localStorage.setItem('theme', currentTheme);
      updateIcon(currentTheme);
       console.log("changes");
    });

    function updateIcon(theme) {
      theme === 'dark'
        ? themeIcon.text('light_mode') // Sun icon
        : themeIcon.text('dark_mode'); // Moon icon
    }


    
  $('#bookingForm, #bookingFormPage').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: 'submit_booking.php',
        type: 'POST',
        data: $(this).serialize(), 
        success: function (response) {
          if (response.trim() === "success") {
            setTimeout(function () {
              window.location.href = 'index.php';
            }, 1000);
          } else {
            alert("Error: " + response);
          }
        },
        error: function () {
          alert("Something went wrong!");
        }
      });
    });


    
    $('#categorySelect').on('change', function () {
      const categoryId = $(this).val();
      $('#modelSelect').html('<option>Loading...</option>');

      if (categoryId) {
        $.ajax({
          url: 'get_models.php',
          type: 'POST',
          data: { category_id: categoryId },
          success: function (response) {
            $('#modelSelect').html(response);
          },
          error: function () {
            $('#modelSelect').html('<option>Error loading models</option>');
          }
        });
      } else {
        $('#modelSelect').html('<option value="">Select Model</option>');
      }
    });



    

   flatpickr("#bookingDateTime", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
  
  });


    new Swiper('.service-slide', {
      loop: true,
      spaceBetween: 25,
      navigation: {
        nextEl: '.controller-icon.next',
        prevEl: '.controller-icon.prev',
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        }
      }
    });
 new Swiper('.testimonials-slide', {
      loop: true,
      spaceBetween: 25,
      navigation: {
        nextEl: '.testimonials.next',
        prevEl: '.testimonials.prev',
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 2,
        }
      }
    });
    new Swiper(".banner-slide", {
      loop: true,
      spaceBetween: 25,
      navigation: {
        nextEl: ".banner.next",
        prevEl: ".banner.prev",
      },
    });
    $('.gallery-pop-view').magnificPopup({
      delegate: 'a.view', // child items selector, by clicking on it popup will open
      type: 'image',
      gallery: {
        enabled: true // Enable gallery mode
      },
      removalDelay: 300,
      mainClass: 'mfp-fade'
    });
    // $('#backtotop').click(function () {
    //   $('html, body').animate({ scrollTop: 0 }, 600); // 600ms smooth scroll
    // });

     $('#backtotop').click(function () {
      $('html, body').animate({ scrollTop: 0 }, 600);
    });

    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
      $('#navbar').addClass('sticky');
    } else {
      $('#navbar').removeClass('sticky');
    }
      if ($(this).scrollTop() > 200) {
        $('#backtotop').fadeIn();
      } else {
        $('#backtotop').fadeOut();
      }
    });

    
               
  });