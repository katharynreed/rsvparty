$(function() {
  $("#nav-login-button").click(function(event) {
    event.preventDefault();
    var username = $("#username").val();
    var password = $("#password").val();

    $.post('/login', { username: username, password: password}, function(response) {
      console.log(response);
      response = jQuery.parseJSON(response);
      if (response !== 'password' && response !== 'username') {
        $("#nav-login").html("<small class='text-muted'>Now signed in as <a href='/user/" + response['id'] + "'>" + response['name'] + "</small>");
      } else {
        $("#nav-login").addClass("has-danger");
        $("#error-text").text("That's not a valid " + response + ". Try again.");
      }
    });
  });

  // $("#sign-up button").click(function(event) {
  //   event.preventDefault();
  //
  //   if ($("#user_password").val() === $("#confirm_password").val()) {
  //     $("#sign-up").submit();
  //   } else {
  //     $("#password-match").html("<small>Your passwords do not match. Please re-enter and try again.</small>");
  //   }
  // });
});
