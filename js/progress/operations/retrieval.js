function retrieveMaterials(
  crId
) {

  $.ajax({
    url: 'database/materials/retrieve/for_report.php',
    data: {
      classroom_id: crId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var materials = responseJSON.materials;

        showMaterials(materials, 'report_form');
        showMaterials(materials, 'feedback_form');

        if (materials.length > 0) {
          retrieveDetailedReview(materials[0].id, classroomId);
          retrieveFeedbacks(materials[0].id, classroomId);
        }
      } else {

        $('#report_form [name="materials"]').append('<option>No Materials Yet</option>');
      }
    }
  });
}

function retrieveDetailedReview(
  mtrlId,
  crId,
  successCallback
) {

  $.ajax({
    url: 'database/materials/retrieve/detailed_report.php',
    data: {
      classroom_id: crId,
      materials_id: mtrlId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var info = responseJSON.info;

        showDetailedReport(info);

        if (successCallback != null) {
          successCallback();
        }
      }
    }
  });
}

function retrieveSummarizedReview(
  crId,
  successCallback
) {

  $.ajax({
    url: 'database/materials/retrieve/summarized_report.php',
    data: {
      classroom_id: crId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var info = responseJSON.info;

        showSummarizedReport(info);

        if (successCallback != null) {
          successCallback();
        }
      }
    }
  });
}

function retrieveFeedbacks(
  mtrlId,
  crId,
  successCallback
) {

  $.ajax({
    url: 'database/materials/retrieve/feedbacks.php',
    data: {
      classroom_id: crId,
      materials_id: mtrlId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var info = responseJSON.info;

        showFeedbacks(info);

        if (successCallback != null) {
          successCallback();
        }
      }
    }
  });
}