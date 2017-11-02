$(function() {
  $("form.form-signin").submit(function(event) {
    event.preventDefault();
    
    var email = $("#inputEmail").val();
    var pass  = $("#inputPassword").val();
    
    if (email.length == 0 || pass.length == 0) {
      $("#errorBox").text("Please fill out all the forms").show();
      return;
    }
    
    $.ajax({
      url: "/login",
      type: "POST",
      dataType: "json",
      data: {email: email, password: pass},
      success: function(result, textStatus, xhr) {
        if (typeof result.success !== "undefined") {
          var token = result.success.token;
          var d = new Date();
          d.setTime(d.getTime() + (1*60*60*1000));
          var expires = "expires=" + d.toUTCString();
          document.cookie = "token=" + token + "; " + expires + "; path=/";
          
          var destination = "/user/dashboard";
          window.location = destination;
        } else {
          $("#errorBox").text("You've entered a bad email or password").show();
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        $("#errorBox").text("Something went wrong").show();
      }
    });
  });
});