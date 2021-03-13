
function mcChcNode(answer) {

  let encodedHtml = answer.replace(/[\u00A0-\u9999<>\&]/g, function (i) {
    return '&#' + i.charCodeAt(0) + ';';
  });

  let escapedString = answer.replace(/"/g, '&quot;');

  return $(
    '<div class="radio">' +
    '<label>' +
    '<input type="radio" name="chc" value="' + escapedString + '"> ' + encodedHtml +
    '</label>' +
    '</div>'
  );
}