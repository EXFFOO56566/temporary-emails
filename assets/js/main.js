$(window).on("load", function () {
  $(".preloader").fadeOut("slow");
});

$(document).ready(function () {

  "use strict";

  window.check_is_runing = false;
  //window.check_recaptcha = false;

  /*--------------- Features Carousel ------------------ */
  $(".features-carousel").owlCarousel({
    loop: true,
    margin: 0,
    autoplay: true,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      },
    },
  });

  /*--------------- Copy Email One Click ------------------ */

  let clipboard = new ClipboardJS(".custom-email-botton");

  $('[data-toggle="tooltip"]').tooltip();

    clipboard.on('success', function(e) {
      $(".custom-email-botton").attr('title', copied)
      .tooltip('dispose')
      .tooltip('show');
      $(e.trigger).html('<i class="fas fa-check"></i>');
      e.clearSelection();
      setTimeout(function() {
        $(".custom-email-botton").attr('title', click_to_copy)
        .tooltip('dispose')
        .tooltip('show');
        $(e.trigger).html('<i class="fas fa-copy"></i>');
      }, 1000);
    });


  $(".lang_dropdown").niceScroll({
    cursorcolor: color,
    zindex: 10000000000000,
    cursorborder:0,
    scrollspeed: 20,
    mousescrollstep: 20,
    railpadding: { top: 5, right: 0, left: 0, bottom: 1 },
});


  /*--------------- Fetch All Messages ------------------ */

  function parseData(data) {
    if (!data) return {};
    if (typeof data === 'object') return data;
    if (typeof data === 'string') return JSON.parse(data);

    return {};
  }


function messages() {
    window.check_is_runing = false;
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let captcha   = $('#captcha-response').val();

      var email = $("#trsh_mail");
      var btn_copy = $(".custom-email-botton");

      if (email.val().length == 0 || email.val() == landing) {
        btn_copy.attr("disabled", "disabled");
        email.val(landing);
        var myLand = setInterval(function () {
          var val = "";
          switch (email.val()) {
            case landing:
              val = landing+".";
              break;

            case landing+".":
              val = landing+"..";
              break;

            case landing+"..":
              val = landing+"...";
              break;
            case landing+"...":
              val = landing;
              break;
          }
          email.val(val);
        }, 300);
      }

      $.ajax({
        url: url,
        type:"POST",
        data:{
          _token: _token,
          captcha:captcha
        },
        success: function (data) {

          var d = parseData(data);

          clearInterval(myLand);
          btn_copy.removeAttr("disabled");

          Progress.configure({ color: [color] });
          Progress.configure({ speed: 0.8 });
          Progress.complete();

          email.val(d.mailbox);

          if (d.messages.length == 0) {
            $(".mailbox-empty").css("display", "block");
            $("#mailbox").html("");
          }else{
            $(".mailbox-empty").css("display", "none");
            $("#mailbox").html("");
          }

          $.each(d.messages, function (key, value) {
            var is_seen = "";
            if (!value.is_seen) {
              is_seen = '<span class="badge badge-success" >new</span>';
            }
            $("#mailbox").append(
              '<div class="message-item">' +
                is_seen +
                '<div class="row">' +
                '<div class="col-10 col-md-4 ov-h"><a href="view/' +
                value.id +
                '" class="sender_email">' +
                value.from +
                "<span>" +
                value.from_email +
                '</span><span class="d_show">'+ value.subject +'</span></a></div>' +
                '<div class="col-md-6 ov-h d_hide"><a href="view/' +
                value.id +
                '" class="subject_email">' +
                value.subject +
                "</div>" +
                '<div class="col-2  text-right"><a href="view/' +
                value.id +
                '" class="view_email"><i class="fas fa-chevron-right"></i></a></div>'
            );
          });

          window.check_is_runing = true;
        },
        error: function (data) {

          grecaptcha.reset();
          grecaptcha.execute();
          grecaptcha.getResponse();
          window.check_is_runing = true;

        },
      });
    }


    window.myCallback = function setResponse(response) { 
      document.getElementById('captcha-response').value = response; 
      window.check_recaptcha = true;
    }
    


    function check_messgaes() {
      if(window.check_is_runing && window.check_recaptcha){
        messages();
      }else{
        console.log('waiting...');
      }
    }


    function recaptcha_works() {
      if(window.check_recaptcha){
        messages();
        clearInterval(window.set_recaptch);
      }else{
        grecaptcha.execute();
        console.log('waiting...');
      }
    }


    
    try {
      setInterval(check_messgaes, fetch_time * 1000);
      window.set_recaptch = setInterval(recaptcha_works,1000);
    } catch (error) {}

  /*--------------- Navbar Collapse ------------------ */
  $(".nav-link").on("click", function () {
    $(".navbar-collapse").collapse("hide");
  });


  /*--------------- iframe height ------------------ */

  try {
    // Selecting the iframe element
    var myIframe = document.getElementById("myIframe");
      
    // Adjusting the iframe height onload event
    $('#myIframe').on('load', function() {
      myIframe.style.height = myIframe.contentWindow.document.body.scrollHeight + 'px';
    });
  
  } catch (error) {}



});
