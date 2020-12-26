
$(document).ready(function () {

  loadMoreGc(
    myId,
    lastId
  );

  gcRetriever = setInterval(function () {

    if (lastId == Number.MAX_SAFE_INTEGER) {

      loadMoreGc(
        myId,
        lastId
      );
    } else {

      retrieveGc(
        myId,
        lastId
      );
    }
  }, 2000);
});