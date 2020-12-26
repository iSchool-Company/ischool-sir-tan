
function phpDate(dateString) {

  var m = dateString.substr(0, 2);
  var d = dateString.substr(3, 2);
  var y = dateString.substr(6, 4);
  var date = y + '-' + m + '-' + d;

  return date;
}

function isValidDate(dateString) {

  var regEx = /^(\d{2})\/(\d{2})\/(\d{4})$/;
  var date =
    dateString.substr(6, 4) +
    '-' +
    dateString.substr(0, 2) +
    '-' +
    dateString.substr(3, 2);

  if (!dateString.match(regEx))
    return false;

  var d;

  if (!((d = new Date(date)) | 0))
    return false;

  return d.toISOString().slice(0, 10) == date;
}

function differenceDate(dateString) {

  var date =
    dateString.substr(6, 4) +
    '-' +
    dateString.substr(0, 2) +
    '-' +
    dateString.substr(3, 2);

  var currentDate =
    (new Date()).getFullYear() +
    '-' +
    ((new Date()).getMonth() + 1) +
    '-' +
    (new Date()).getDate();

  var d = new Date(date);
  var n = new Date(currentDate);
  var difference = (d - n) / 60 / 60 / 24 / 1000;

  return difference;
}

function differenceDate2(dateString, timeString) {

  var date =
    dateString.substr(6, 4) +
    '-' +
    dateString.substr(0, 2) +
    '-' +
    dateString.substr(3, 2);

  var d = new Date(date + ' ' + timeString);
  var n = new Date();
  var difference = (d - n) / 60 / 60 / 1000;

  return difference;
}