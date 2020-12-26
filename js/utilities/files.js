
function validFile(elem, file) {

  var extension = file.split('.').pop().toLowerCase();

  switch (extension) {
    case 'doc':
    case 'docx':
    case 'xls':
    case 'xlsx':
    case 'ppt':
    case 'pptx':
    case 'pdf':
    case 'txt':
      return true;
      break;
    default:
      return false;
  }
}

function validImage(elem, file) {

  var extension = file.split('.').pop().toLowerCase();

  switch (extension) {
    case 'png':
    case 'jpg':
    case 'jpeg':
    case 'gif':
      return true;
      break;
    default:
      return false;
  }
}

function getFileSize(file) {
  return (file[0].files[0].size / 1024).toFixed(2);
}