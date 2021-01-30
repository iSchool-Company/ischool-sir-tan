function materialNode(
  id,
  fileName
) {

  return $(
    '<option value="' + id + '">' + fileName + '</option>'
  );
}

function feedbackNode(
  displayName,
  content
) {
  return $(
    '<b>' + displayName + '</b><br>' + content + '<br>'
  );
}