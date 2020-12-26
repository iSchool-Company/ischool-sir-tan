var latestInfo;

function updateInfo(data, modalId, passwordId) {

  $.ajax({
    method: 'POST',
    url: 'database/update_user_record.php',
    data: data,
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response == 'successful') {
        $(modalId).modal('hide');
        $('#prompt_modal').modal('show');
      } else if (response == 'wrong password') {
        showResult($(passwordId), true, 'Incorrect password!');
      }
    }
  });
}

function retrieveInfo() {

  $.ajax({
    url: 'database/retrieve_user_record.php',
    data: { user_id: myId },
    success: function (data, status) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response == 'found') {

        var info = responseJSON.info;
        var fullName = info.first_name + ' ' + info.middle_name + ' ' + info.last_name;

        if ($('#name_profile').text() !== fullName) {
          $('#name_profile').text(fullName)
        }

        if ($('#gender_profile').text() !== info.gender) {
          $('#gender_profile').text(info.gender);
        }

        if ($('#birthday_profile').text() !== info.birthday) {
          $('#birthday_profile').text(info.birthday);
        }

        if ($('#contact_number_profile').text() !== info.mobile_number) {
          if (info.mobile_number == null && $('#contact_number_profile').text() !== 'Not Available') {
            $('#contact_number_profile').text('Not Available');
          } else if (info.mobile_number !== null) {
            $('#contact_number_profile').text(info.mobile_number);
          }
        }

        if ($('#username_profile').text() !== info.username) {
          $('#username_profile').text(info.username);
        }

        if ($('#email_profile').text() !== info.email + '@' + info.email_extension) {
          if (info.email == null && $('#email_profile').text() !== 'Not Available') {
            $('#email_profile').text('Not Available');
          } else if (info.email !== null) {
            $('#email_profile').text(info.email + '@' + info.email_extension);
          }
        }

        latestInfo = info;
      }
    }
  });
}

function updateDP(
  usrId,
  image
) {

  var formData = new FormData();

  formData.append('user_id', usrId);
  formData.append('image', image);

  $.ajax({
    method: 'post',
    url: 'database/accounts/update_dp.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {

      window.location = 'my_profile.php';
    }
  });
}

$(document).ready(function () {

  retrieveInfo();

  setInterval(retrieveInfo, 1000);

  $('.modal').on('hidden.bs.modal', function () {
    $(this).find('[name="password"]').val('');
  });

  $('#edit_dp, #edit_dp_2').click(function () {

    $('#edit_dp_r').click();
  });

  $('#edit_dp_r').change(function () {

    var elem = $(this);
    var value = elem.val();

    if (!validImage(elem, value)) {


    } else {

      updateDP(
        myId,
        elem[0].files[0]
      );
    }
  });

  $('[href="#name_modal"]').click(function () {

    $('#edit_type').text('name');

    $('#name_form [name="first_name"]').val(latestInfo.first_name);
    $('#name_form [name="middle_name"]').val(latestInfo.middle_name);
    $('#name_form [name="last_name"]').val(latestInfo.last_name);
  });

  $('[href="#gender_modal"]').click(function () {

    $('#edit_type').text('gender');

    $('#gender_form [name="gender"]').val(latestInfo.gender);
  });

  $('[href="#birthday_modal"]').click(function () {

    $('#edit_type').text('birthday');

    $('#birthday_form [name="birthday"]').val(latestInfo.birthday_firefox);

    var value = $('#birthday_form [name="birthday"]').val();

    if (value == '') {
      $('#birthday_form [name="birthday"]').val(latestInfo.birthday_proper);
    }
  });

  $('[href="#contact_modal"]').click(function () {

    $('#edit_type').text('contact number');

    $('#contact_form [name="contact_number"]').val(latestInfo.mobile_number);
  });

  $('[href="#username_modal"]').click(function () {

    $('#edit_type').text('username');

    $('#username_form [name="username"]').val(latestInfo.username);
  });

  $('[href="#email_modal"]').click(function () {

    $('#edit_type').text('email');

    $('#email_form [name="email"]').val(latestInfo.email);
    $('#email_form [name="email_extension"]').val(latestInfo.email_extension);
  });

  $('#name_modal [name="save_button"]').click(function () {

    var editOk = true;
    var firstName = $('#name_form [name="first_name"]');
    var middleName = $('#name_form [name="middle_name"]');
    var lastName = $('#name_form [name="last_name"]');
    var password = $('#name_form [name="password"]');

    if (firstName.val() === '') {
      showResult(firstName, true, 'Enter first name!');
      editOk = false;
    } else {
      showResult(firstName, false, '');
    }

    if (middleName.val() === '') {
      showResult(middleName, true, 'Enter middle name!');
      editOk = false;
    } else {
      showResult(middleName, false, '');
    }

    if (lastName.val() === '') {
      showResult(lastName, true, 'Enter last name!');
      editOk = false;
    } else {
      showResult(lastName, false, '');
    }

    if (password.val() === '') {
      showResult(password, true, 'Enter password!');
      editOk = false;
    } else {
      showResult(password, false, '');
    }

    if (editOk) {

      var data = {
        user_id: myId,
        part: 'name',
        password: password.val(),
        first_name: firstName.val(),
        middle_name: middleName.val(),
        last_name: lastName.val()
      };

      updateInfo(data, '#name_modal', '#name_form [name="password"]');
    }
  });

  $('#gender_modal [name="save_button"]').click(function () {

    var editOk = true;
    var gender = $('#gender_form [name="gender"]');
    var password = $('#gender_form [name="password"]');

    if (gender.val() === '') {
      showResult(gender, true, 'Enter gender!');
      editOk = false;
    } else {
      showResult(gender, false, '');
    }

    if (password.val() === '') {
      showResult(password, true, 'Enter password!');
      editOk = false;
    } else {
      showResult(password, false, '');
    }

    if (editOk) {

      var data = {
        user_id: myId,
        part: 'gender',
        password: password.val(),
        gender: gender.val()
      };

      updateInfo(data, '#gender_modal', '#gender_form [name="password"]');
    }
  });

  $('#birthday_modal [name="save_button"]').click(function () {

    var editOk = true;
    var birthday = $('#birthday_form [name="birthday"]');
    var password = $('#birthday_form [name="password"]');

    if (birthday.val() === '') {
      showResult(birthday, true, 'Enter birthday!');
      editOk = false;
    } else if (!isValidDate(birthday.val())) {
      showResult(birthday, true, 'Please follow the correct date format!');
      editOk = false;
    } else {
      showResult(birthday, false, '');
    }

    if (password.val() === '') {
      showResult(password, true, 'Enter password!');
      editOk = false;
    } else {
      showResult(password, false, '');
    }

    if (editOk) {

      var data = {
        user_id: myId,
        part: 'birthday',
        password: password.val(),
        birthday: birthday.val()
      };

      updateInfo(data, '#birthday_modal', '#birthday_form [name="password"]');
    }
  });

  $('#contact_modal [name="save_button"]').click(function () {

    var editOk = true;
    var contactNumber = $('#contact_form [name="contact_number"]');
    var password = $('#contact_form [name="password"]');

    if (contactNumber.val() === '') {
      showResult(contactNumber, true, 'Enter contact number!');
      editOk = false;
    } else {
      showResult(contactNumber, false, '');
    }

    if (password.val() === '') {
      showResult(password, true, 'Enter password!');
      editOk = false;
    } else {
      showResult(password, false, '');
    }

    if (editOk) {

      var data = {
        user_id: myId,
        part: 'contact_number',
        password: password.val(),
        contact_number: contactNumber.val()
      };

      updateInfo(data, '#contact_modal', '#contact_form [name="password"]');
    }
  });

  $('#username_modal [name="save_button"]').click(function () {

    var editOk = true;
    var username = $('#username_form [name="username"]');
    var password = $('#username_form [name="password"]');

    if (username.val() === '') {
      showResult(username, true, 'Enter username!');
      editOk = false;
    } else if (username.val().length < 6) {
      showResult(username, true, 'Enter 6 characters!');
      editOk = false;
    } else {
      showResult(username, false, '');
    }

    if (password.val() === '') {
      showResult(password, true, 'Enter password!');
      editOk = false;
    } else {
      showResult(password, false, '');
    }

    if (editOk) {

      var data = {
        user_id: myId,
        part: 'username',
        password: password.val(),
        username: username.val()
      };

      updateInfo(data, '#username_modal', '#username_form [name="password"]');
    }
  });

  $('#email_modal [name="save_button"]').click(function () {

    var editOk = true;
    var email = $('#email_form [name="email"]');
    var emailExtension = $('#email_form [name="email_extension"]');
    var password = $('#email_form [name="password"]');

    if (email.val() === '') {
      showResult(email, true, 'Enter email!');
      editOk = false;
    } else {
      showResult(email, false, '');
    }

    if (emailExtension.val() === '') {
      showResult(emailExtension, true, 'Enter email extension!');
      editOk = false;
    } else {
      showResult(emailExtension, false, '');
    }

    if (password.val() === '') {
      showResult(password, true, 'Enter password!');
      editOk = false;
    } else {
      showResult(password, false, '');
    }

    if (editOk) {

      var data = {
        user_id: myId,
        part: 'email',
        password: password.val(),
        email: email.val(),
        email_extension: emailExtension.val()
      };

      updateInfo(data, '#email_modal', '#email_form [name="password"]');
    }
  });

  $('#password_modal [name="save_button"]').click(function () {
    $('#edit_type').text('password');

    var editOk = true;
    var password = $('#password_form [name="password"]');
    var newPassword = $('#password_form [name="new_password"]');
    var confirmPassword = $('#password_form [name="confirm_password"]');


    if (password.val() === '') {
      showResult(password, true, 'Enter password!');
      editOk = false;
    } else {
      showResult(password, false, '');
    }

    if (newPassword.val() === '') {
      showResult(newPassword, true, 'Enter new password!');
      editOk = false;
    } else if (newPassword.val().length < 6) {
      showResult(newPassword, true, 'Enter 6 characters!');
      editOk = false;
    } else {
      showResult(newPassword, false, '');
    }

    if (confirmPassword.val() === '') {
      showResult(confirmPassword, true, 'Enter confirm password!');
      editOk = false;
    } else if (confirmPassword.val().length < 6) {
      showResult(confirmPassword, true, 'Enter 6 characters!');
      editOk = false;
    } else if (confirmPassword.val() !== newPassword.val()) {
      showResult(confirmPassword, true, "Password doesn't match!")
      editOk = false;
    } else {
      showResult(confirmPassword, false, '');
    }

    if (editOk) {

      var data = {
        user_id: myId,
        part: 'password',
        password: password.val(),
        new_password: newPassword.val()
      };

      updateInfo(data, '#password_modal', '#password_form [name="password"]');
    }
  });
});

