
var firstDone = false;

$(document).ready(function () {

  retrieveNotifCount(myId);

  setInterval(function () {

    firstDone = true;

    retrieveNotifCount(myId);
  }, 2000);
});