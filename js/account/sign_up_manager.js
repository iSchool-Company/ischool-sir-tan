
function validateBlank(inputType) {

  var value = inputType.val();
  var name = '';

  if (
    value == ''
    ||
    (
      inputType.attr('name') === 'gender'
      &&
      value === null
    )
  ) {

    switch (inputType.attr('name')) {

      case 'first_name':
        name = 'first name';
        break;

      case 'last_name':
        name = 'last name';
        break;

      case 'gender':
        name = 'gender';
        break;
    }

    showResult(inputType, true, 'Please provide your ' + name + '!');
    return true;
  } else {
    showResult(inputType, false, '');
    return false;
  }
}

function validateAll(
  firstName,
  middleName,
  lastName,
  gender,
  username,
  password,
  confirmPassword
) {

  var signUpOk = true;

  showResult(middleName, false, '');

  signUpOk = validateBlank(firstName) ? false : signUpOk;
  signUpOk = validateBlank(lastName) ? false : signUpOk;
  signUpOk = validateBlank(gender) ? false : signUpOk;

  if (username.val() === '') {
    showResult(username, true, 'Please provide your username!');
    signUpOk = false;
  } else {

    var ok = true;

    $.ajax({
      method: 'post',
      url: 'database/accounts/check.php',
      data: { username: username.val() },
      async: false,
      success: function (data, status) {

        var responseJSON = JSON.parse(data);

        if (responseJSON.response === 'existing') {
          showResult(username, true, 'Username already existing!');
          ok = false;
        }
      }
    });

    signUpOk = ok;
  }

  if (password.val() === '') {
    showResult(password, true, 'Please provide your password!');
    signUpOk = false;
  } else if (password.val().length < 6) {
    showResult(password, true, 'Password should be 6 characters and above!');
    signUpOk = false;
  }

  if (confirmPassword.val() === '') {
    showResult(confirmPassword, true, 'Please type a confirm password!');
    signUpOk = false;
  } else if (password.val() !== confirmPassword.val()) {
    showResult(confirmPassword, true, 'Password doesn\'t match!');
  }

  return signUpOk;
}

function showInModal(
  firstName,
  middleName,
  lastName,
  gender,
  username
) {

  $('#name_modal').text(firstName + ' ' + middleName + ' ' + lastName);
  $('#gender_modal').text(gender);
  $('#username_modal').text(username);

  $('#submit_modal').modal('show');
}

function signUp(
  firstName,
  middleName,
  lastName,
  gender,
  username,
  password
) {

  $('#prompt_modal').modal({ backdrop: 'static', keyboard: false });

  $.ajax({
    type: 'post',
    url: 'database/sign_up.php',
    data: {
      type: type,
      first_name: firstName.val(),
      middle_name: middleName.val(),
      last_name: lastName.val(),
      gender: gender.val(),
      username: username.val(),
      password: password.val()
    },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);

      if (responseJSON.response === 'successful') {

        $('#welcome_name').text(firstName.val());

        setTimeout(function () {

          $('#prompt_modal').modal('hide');
          $('#welcome_modal').modal('show');

          setTimeout(function () {
            window.location = 'home.php';
          }, 3000);
        }, 1000);
      }
    }
  });
}

$(document).ready(function () {

  $('[name="gender"]').change(function () {

    var input = $('[name="gender"]');
    var value = input.val();

    switch (value) {

      case 'Male':
        $('#gender_icon').addClass('fa-male');
        $('#gender_icon').removeClass('fa-user fa-female');
        break;

      case 'Female':
        $('#gender_icon').addClass('fa-female');
        $('#gender_icon').removeClass('fa-user fa-male');
        break;
    }
  });

  $('[name="first_name"], ' +
    '[name="last_name"], ' +
    '[name="gender"]'
  ).blur(function () {
    validateBlank($(this));
  });

  $('[name="middle_name"]').blur(function () {
    showResult($(this), false, '');
  });

  $('[name="username"]').on('keyup paste change blur', function () {

    var input = $('[name="username"]');
    var value = input.val();

    if (value === '') {
      showResult(input, true, 'Please provide your username!');
    } else if (value.length < 6) {
      showResult(input, true, 'Username should be 6 characters and above!');
    } else {

      var url = 'database/accounts/check.php';
      var data = { username: value };

      input.parents('.form-group').find('.help-block').text('');
      $('#loading').show();

      $.post(url, data, function (data, status) {

        var responseJSON = JSON.parse(data);

        if (responseJSON.response === 'existing') {
          showResult(input, true, 'Username already existing!');
        } else {
          showResult(input, false, 'Username available!');
        }

        $('#loading').hide();
      });
    }
  });

  $('[name="password"]').blur(function () {

    var password = $('[name="password"]');
    var confirmPassword = $('[name="confirm_password"]');
    var passwordValue = password.val();
    var confirmPasswordValue = confirmPassword.val();

    if (passwordValue === '') {
      showResult(password, true, 'Please provide your password!');
    } else if (passwordValue.length < 6) {
      showResult(password, true, 'Password should be 6 characters and above!');
    } else {
      showResult(password, false, '');
    }

    if (confirmPasswordValue !== '') {
      if (passwordValue !== confirmPasswordValue) {
        showResult(confirmPassword, true, 'Password doesn\'t match!');
      } else {
        showResult(confirmPassword, false, '');
      }
    }
  });

  $('[name="confirm_password"]').blur(function () {

    var password = $('[name="password"]');
    var confirmPassword = $('[name="confirm_password"]');
    var passwordValue = password.val();
    var confirmPasswordValue = confirmPassword.val();

    if (confirmPasswordValue === '') {
      showResult(confirmPassword, true, 'Please type a confirm password!');
    } else if (passwordValue === '') {
      showResult(confirmPassword, true, 'Password not yet set!');
    } else if (passwordValue !== confirmPasswordValue) {
      showResult(confirmPassword, true, 'Password doesn\'t match!');
    } else {
      showResult(confirmPassword, false, '');
    }
  });

  $('#sign_up_form').submit(function (e) {

    e.preventDefault();

    var firstNameInput = $('[name="first_name"]');
    var middleNameInput = $('[name="middle_name"]');
    var lastNameInput = $('[name="last_name"]');
    var genderInput = $('[name="gender"]');
    var usernameInput = $('[name="username"]');
    var passwordInput = $('[name="password"]');
    var passwordConfirmInput = $('[name="confirm_password"]');

    var signUpOk = validateAll(
      firstNameInput,
      middleNameInput,
      lastNameInput,
      genderInput,
      usernameInput,
      passwordInput,
      passwordConfirmInput
    );

    if (signUpOk) {
      showInModal(
        firstNameInput.val(),
        middleNameInput.val(),
        lastNameInput.val(),
        genderInput.val(),
        usernameInput.val()
      );
    }
  });

  $('#sign_up_form [name="cancel_button"]').click(function () {
    $('#sign_up_form input, #sign_up_form select').each(function () {
      clearResult($(this));
    });
  });

  $('#submit_modal_yes').click(function () {

    var firstNameInput = $('[name="first_name"]');
    var middleNameInput = $('[name="middle_name"]');
    var lastNameInput = $('[name="last_name"]');
    var genderInput = $('[name="gender"]');
    var usernameInput = $('[name="username"]');
    var passwordInput = $('[name="password"]');

    signUp(
      firstNameInput,
      middleNameInput,
      lastNameInput,
      genderInput,
      usernameInput,
      passwordInput
    );
  });

  $('#welcome_modal').on('hidden.bs.modal', function () {
    window.location = 'home.php';
  });
});