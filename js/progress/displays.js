function showMaterials(materials) {

  var materialSelect = $('#report_form [name="materials"]');
  var length = materials.length;

  materialSelect.empty();

  for (var i = 0; i < length; i++) {

    var materialsNodeTemp = materialNode(
      materials[i].id,
      materials[i].fileName
    );

    materialSelect.append(materialsNodeTemp);
  }
}

function showDetailedReport(data) {

  $('#detailed_material_name').text(data.name);

  let respondents = data.respondents;
  let total = data.total;

  let respondentsCount = $('#detailed_respondents_count');
  respondentsCount.text(respondents);
  respondentsCount.addClass(respondents >= (total / 2) ? 'text-success' : 'text-danger');

  $('#detailed_total_count').text(data.total);

  if (respondents === 0) {
    return;
  }

  $('#detailed_rate_neg').text(data.overall_rate.neg);
  $('#detailed_rate_neu').text(data.overall_rate.neu);
  $('#detailed_rate_pos').text(data.overall_rate.pos);

  showCriteriaDetails(data, respondents, '1');
  showCriteriaDetails(data, respondents, '2');
  showCriteriaDetails(data, respondents, '3');
  showCriteriaDetails(data, respondents, '4');
  showCriteriaDetails(data, respondents, '5');

  let sentimentAnalysisNeg = data.sentiment_analysis.neg;
  let sentimentAnalysisPos = data.sentiment_analysis.pos;
  let sentimentAnalysisNegPercentage = Math.round((sentimentAnalysisNeg / respondents) * 100);
  let sentimentAnalysisPosPercentage = Math.round((sentimentAnalysisPos / respondents) * 100);
  let sentimentAnalysisNeuPercentage = 100 - sentimentAnalysisNegPercentage - sentimentAnalysisPosPercentage;

  $('#detailed_sentiment_analysis_neg').css('width', sentimentAnalysisNegPercentage + '%');
  $('#detailed_sentiment_analysis_neg>div').text(sentimentAnalysisNegPercentage === 0 ? '' : sentimentAnalysisNegPercentage + '%');
  $('#detailed_sentiment_analysis_neu').css('width', sentimentAnalysisNeuPercentage + '%');
  $('#detailed_sentiment_analysis_neu>div').text(sentimentAnalysisNeuPercentage === 0 ? '' : sentimentAnalysisNeuPercentage + '%');
  $('#detailed_sentiment_analysis_pos').css('width', sentimentAnalysisPosPercentage + '%');
  $('#detailed_sentiment_analysis_pos>div').text(sentimentAnalysisPosPercentage === 0 ? '' : sentimentAnalysisPosPercentage + '%');
}

function showCriteriaDetails(data, respondents, rateNum) {

  let ratePos = data['rate_' + rateNum].pos;
  let rateNeg = data['rate_' + rateNum].neg;
  let rateNegPercentage = Math.round((rateNeg / respondents) * 100);
  let ratePosPercentage = Math.round((ratePos / respondents) * 100);
  let rateNeuPercentage = 100 - rateNegPercentage - ratePosPercentage;

  $('#detailed_rate_' + rateNum + '_neg').text(rateNegPercentage === 0 ? '' : rateNegPercentage + '%');
  $('#detailed_rate_' + rateNum + '_neg').css('width', rateNegPercentage + '%');
  $('#detailed_rate_' + rateNum + '_neu').text(rateNeuPercentage === 0 ? '' : rateNeuPercentage + '%');
  $('#detailed_rate_' + rateNum + '_neu').css('width', rateNeuPercentage + '%');
  $('#detailed_rate_' + rateNum + '_pos').text(ratePosPercentage === 0 ? '' : ratePosPercentage + '%');
  $('#detailed_rate_' + rateNum + '_pos').css('width', ratePosPercentage + '%');
}

function showSummarizedReport(data) {

  data.materials.forEach(mat => {

    chartLabels.push(mat.name);

    chartSeries[0].push(mat.neg);
    chartSeries[1].push(mat.neu);
    chartSeries[2].push(mat.pos);
  });
}