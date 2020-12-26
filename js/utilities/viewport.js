
function isFullyVisible(elem) {

  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();

  var elemTop = $(elem).offset().top;
  var elemBottom = elemTop + $(elem).height();

  return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function isPartiallyVisible(elem) {

  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();

  var elemTop = $(elem).offset().top;
  var elemBottom = elemTop + $(elem).height();

  return !(
    (
      (elemBottom > docViewTop) &&
      (elemTop > docViewTop) &&
      (elemBottom > docViewBottom) &&
      (elemTop > docViewBottom)
    )
    ||
    (
      (elemBottom < docViewTop) &&
      (elemTop < docViewTop) &&
      (elemBottom < docViewBottom) &&
      (elemTop < docViewBottom)
    )
  );
}

function hideModal(id) {

  $('#' + id + '_modal').modal('hide');
}

function showIfEver(elem) {

  if (elem.css('display') === 'none') {

    elem.show();
  }
}

function hideIfEver(elem) {

  if (elem.css('display') !== 'none') {

    elem.hide();
  }
}
