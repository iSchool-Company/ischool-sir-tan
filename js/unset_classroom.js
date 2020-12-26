
$(document).ready(function () {

  unsetClassroom();
});

function unsetClassroom() {

  $.ajax({
    url: 'database/classroom/unset.php'
  });
}