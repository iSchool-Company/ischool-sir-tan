
function quizNode(id) {

  return $(
    '<div id="prgrssqz' + id + '" class="row"> ' +
    '<div class="timeline-left"> ' +
    '<div class="img-circle-left"> ' +
    '<span class="fa fa-book icon-left"></span> ' +
    '</div> ' +
    '<div class="progress-left"> ' +
    '<h4><span name="title">OOP</span> <br class="visible-xs"> <small name="date_time">Sep 3, 2017</small></h4> ' +
    '<p>You <span name="remarks">passed</span> the quiz! Your score is <span name="score">4/5</span>.</p> ' +
    '</div> ' +
    '</div> ' +
    '</div> '
  );
}

function assignmentNode(id) {

  return $(
    '<div id="prgrssas' + id + '" class="row"> ' +
    '<div class="timeline-right"> ' +
    '<div class="img-circle-right"> ' +
    '<span class="fa fa-list-ul icon-right"></span> ' +
    '</div> ' +
    '<div class="progress-right"> ' +
    '<h4><span name="title">Review on HTML</span> <br class="visible-xs"> <small name="date_time">Sep 5, 2014</small></h4> ' +
    '<p>You <span name="remarks">Failed</span> the quiz! Your grade is <span name="score">72%</span>.</p> ' +
    '</div> ' +
    '</div> ' +
    '</div> '
  );
}