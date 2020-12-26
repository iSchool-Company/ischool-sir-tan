
$(document).ready(function () {

  if (type != 0) {

    $('#type').val(type);
  } else {

    type = $('#type').val();
  }

  display = $('#display').val();

  retrieveClassrooms(
    myId,
    0
  );

  $('#classroom, #type').change(function () {

    classroomId = $('#classroom').val();
    type = $('#type').val();

    refreshChoices();
  });

  $('#display').change(function () {

    display = $('#display').val();

    retrieveSummary();
  });
});

$(document).on('change', '[name="choice"] input:checkbox', function () {

  var length = $('[name="choice"] input:checkbox:checked').length;

  ids = [];

  $('[name="choice"] input:checkbox:checked').each(function (i) {

    ids.push($(this).val());
  });

  retrieveSummary();
});

function classroomNode(
  id,
  name
) {

  return $(
    '<option value="' + id + '">' + name + '</option>'
  );
}

function choiceNode(
  id,
  name
) {

  return $(
    '<div id="' + id + '" class="checkbox" name="choice"> ' +
    '<label> ' +
    '<input type="checkbox" value="' + id + '"/> ' +
    name +
    '</label> ' +
    '</div> '
  );
}

function tableNode() {

  return $(
    '<table class="table table-condensed table-bordered"> ' +
    '<thead class="bg-info"> ' +
    '<tr> ' +
    '<td>Name</td>' +
    '</tr> ' +
    '</thead>' +
    '<tbody>' +
    '</tbody>' +
    '</table> '
  );
}

function trNode(name) {

  return $(
    '<tr> ' +
    '<td>' + name + '</td>' +
    '</tr> '
  );
}

function retrieveClassrooms(
  usrId,
  crId
) {

  $.ajax({
    url: 'database/classroom/retrieve/names.php',
    data: {
      user_id: usrId,
      classroom_id: crId
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var classrooms = responseJSON.classrooms;

        showClassrooms(classrooms);
        refreshChoices();
      }
    }
  });
}

function retrieveChoices(
  crId,
  usrId,
  type
) {

  $.ajax({
    url: 'database/report/choices.php',
    data: {
      user_id: usrId,
      classroom_id: crId,
      type: type
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      $('#choices_panel').empty();

      if (response === 'found') {

        var choices = responseJSON.choices;

        showChoices(choices);
      } else {

        $('#choices_panel').append('<p>No current ' + type + '.</p>');
      }

      ids = [];

      retrieveSummary();
    }
  });
}

function retrieveSummary() {

  $.ajax({
    url: 'database/report/summary.php',
    data: {
      type: type,
      display: display,
      ids: ids
    },
    success: function (data) {

      var responseJSON = JSON.parse(data);
      var response = responseJSON.response;

      if (response === 'found') {

        var summaries = responseJSON.summaries;

        showSummaries(summaries);
      } else {

        $('#detailed_panel').empty();
        $('#detailed_panel').hide();
        $('.ct-chart').hide();
      }
    }
  });
}

function showClassrooms(classrooms) {

  var classroomSelect = $('#classroom');
  var length = classrooms.length;

  for (var i = 0; i < length; i++) {

    var classroomNodeTemp = classroomNode(
      classrooms[i].id,
      classrooms[i].name
    );

    classroomSelect.append(classroomNodeTemp);
  }

  if (classroomId != 0) {

    $('#classroom').val(classroomId);
  } else {

    classroomId = $('#classroom').val();
  }
}

function showChoices(choices) {

  var length = choices.length;

  for (var i = 0; i < length; i++) {

    var choiceNodeTemp = choiceNode(
      choices[i].id,
      choices[i].title
    );

    $('#choices_panel').append(choiceNodeTemp);
  }
}

function showSummaries(summaries) {

  var length = summaries.length;

  $('#detailed_panel').empty();

  if (display !== 'Detailed') {

    $('#detailed_panel').hide();
    $('.ct-chart').show();

    if (display == 'Line Graph') {

      var labels = [];
      var series = [];

      for (var i = 0; i < length; i++) {

        labels.push($('#' + summaries[i].number).text());
        series.push(summaries[i].percent);
      }

      lineGraph(
        labels,
        series
      );
    } else {

      var labels = [];
      var series = [];

      for (var i = 0; i < length; i++) {

        labels.push($('#' + summaries[i].number).text());
        series.push(summaries[i].percent);
      }

      barGraph(
        labels,
        series
      );
    }
  } else {

    $('#detailed_panel').show();
    $('.ct-chart').hide();

    var tableNodeTemp = tableNode();
    var legend = $('<div></div>');

    for (var i = 0; i < length; i++) {

      tableNodeTemp.find('thead > tr').append('<td>' + (i + 1) + '</td>');

      for (var j = 0; j < summaries[i].records.length; j++) {

        if (i === 0) {

          var trNodeTemp = trNode(summaries[i].records[j].name);

          tableNodeTemp.find('tbody').append(trNodeTemp);
        }

        tableNodeTemp.find('tbody > tr').eq(j).append('<td>' + summaries[i].records[j].rate + '</td>');
      }

      legend.append('<p>' + (i + 1) + ' = ' + $('#' + summaries[i].number).text() + '</p>');
    }

    $('#detailed_panel').append(tableNodeTemp);
    $('#detailed_panel').append('<h4>Legend:</h4>');
    $('#detailed_panel').append(legend);
  }
}

function refreshChoices() {

  classroomId = $('#classroom').val();
  type = $('#type').val();
  display = $('#display').val();

  retrieveChoices(
    classroomId,
    myId,
    type
  );
}

function detailed() {

}

function barGraph(
  labels,
  series
) {

  new Chartist.Bar('.ct-chart', {
    labels: labels,
    series: series
  }, {
    distributeSeries: true,
    high: 100
  });
}

function lineGraph(
  labels,
  series
) {

  new Chartist.Line('.ct-chart', {
    labels: labels,
    series: [
      series
    ]
  }, {
    low: 0,
    high: 100,
    showArea: true
  });
}