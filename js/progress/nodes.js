function materialNode(
  id,
  fileName
) {

  return $(
    '<option value="' + id + '">' + fileName + '</option>'
  );
}