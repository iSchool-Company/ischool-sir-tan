
function mcChcNode(answer) {

  return $(
    '<div class="radio">' +
    '<label>' +
    '<input type="radio" name="chc" value="' + answer + '"> ' + answer +
    '</label>' +
    '</div>'
  );
}