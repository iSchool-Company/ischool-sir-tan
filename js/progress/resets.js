function resetDetailedReport() {

  $('#report_form [name="materials"]').prop('disabled', true);
  $('#per_module_loading').show();
  $('#per_module_main').hide();

  let respondentsCount = $('#detailed_respondents_count');
  respondentsCount.text('0');
  respondentsCount.removeClass('text-success text-danger');

  $('#detailed_total_count').text('0');

  $('#detailed_rate_neg').text('0');
  $('#detailed_rate_neu').text('0');
  $('#detailed_rate_pos').text('0');

  resetCriteriaDetails(1);
  resetCriteriaDetails(2);
  resetCriteriaDetails(3);
  resetCriteriaDetails(4);
  resetCriteriaDetails(5);

  $('#detailed_sentiment_analysis_neg').css('width', '0%');
  $('#detailed_sentiment_analysis_neg>div').text('');
  $('#detailed_sentiment_analysis_neu').css('width', '0%');
  $('#detailed_sentiment_analysis_neu>div').text('');
  $('#detailed_sentiment_analysis_pos').css('width', '0%');
  $('#detailed_sentiment_analysis_pos>div').text('');
}

function resetCriteriaDetails(rateNum) {
  $('#detailed_rate_' + rateNum + '_neg').text('');
  $('#detailed_rate_' + rateNum + '_neg').css('width', '0%');
  $('#detailed_rate_' + rateNum + '_neu').text('');
  $('#detailed_rate_' + rateNum + '_neu').css('width', '0%');
  $('#detailed_rate_' + rateNum + '_pos').text('');
  $('#detailed_rate_' + rateNum + '_pos').css('width', '0%');
}

function resetFeedbacks() {

  $('#feedback_form [name="materials"]').prop('disabled', true);
  $('#feedbacks_loading').show();
  $('#feedbacks_main').hide();

  $('#negative_feedbacks').html('Loading...');
  $('#neutral_feedbacks').html('Loading...');
  $('#positive_feedbacks').html('Loading...');
}