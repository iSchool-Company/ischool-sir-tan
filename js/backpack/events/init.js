
$(document).ready(function () {

  retrieveIds(myId);

  materialsRetriever = setInterval(function () {
    retrieveIds(myId);
  }, 1000);

  materialsFiller = setInterval(function () {
    traverseIds('bckpck');
  }, 1000);
});