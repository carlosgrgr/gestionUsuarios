window.addEventListener("load", ini);

function ini(){
    $(".email-signup").hide();
    $("#signup-box-link").click(function(){
      $(".email-login").fadeOut(100);
      $(".email-signup").delay(100).fadeIn(100);
      $("#login-box-link").removeClass("active");
      $("#signup-box-link").addClass("active");
    });
    $("#login-box-link").click(function(){
      $(".email-login").delay(100).fadeIn(100);;
      $(".email-signup").fadeOut(100);
      $("#login-box-link").addClass("active");
      $("#signup-box-link").removeClass("active");
    });
}