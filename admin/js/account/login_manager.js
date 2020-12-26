
$(document).ready(function () {

  $('#log_in_form').submit(function (e) {

    e.preventDefault();

    var rootDOM = $(this);
    var usernameInput = rootDOM.find('[name="username"]');
    var passwordInput = rootDOM.find('[name="password"]');
    var usernameValue = usernameInput.val();
    var passwordValue = passwordInput.val();
    var hasNoError = true;

    if (usernameValue == '') {
      hasNoError = false;
      showResult(usernameInput, true, 'Please provide your username!');
    } else {
      showResult(usernameInput, false, '');
    }

    if (passwordValue == '') {
      hasNoError = false;
      showResult(passwordInput, true, 'Please provide your password!');
    } else {
      showResult(passwordInput, false, '');
    }

    if (hasNoError) {

      $.post('database/account/log_in.php',
        {
          username: usernameValue,
          password: passwordValue
        },
        function (data) {

          var responseJSON = JSON.parse(data);

          if (responseJSON.response == 'failed') {
            showResult(usernameInput, true, 'Account not found!');
            showResult(passwordInput, true, '');
          } else if (responseJSON.response == 'wrong password') {
            showResult(passwordInput, true, 'Incorrect password!');
          } else if (responseJSON.response == 'successful') {
            setTimeout(function () {
              window.location = 'home.php';
            }, 1000);
          }
        });
    }
  });

  $('[name="username"], [name="password"]').blur(function () {

    var input = $(this);
    var value = input.val();
    var name = input.attr('name');

    if (value === '') {
      showResult(input, true, 'Please provide your ' + name + '!');
    } else {
      showResult(input, false, '');
    }
  });
});