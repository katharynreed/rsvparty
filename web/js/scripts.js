$(function() {
  $("#nav-login-button").click(function(event) {
    event.preventDefault();
    var username = $("#username").val();
    var password = $("#password").val();

    $.post('/login', { username: username, password: password}, function(response) {
      if (response === 'success') {
        alert(response);
      } else {
        alert(response);
      }
    });
  });
});
