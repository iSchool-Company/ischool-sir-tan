function showMaterials(materials, formName) {

  var materialSelect = $('#' + formName + ' [name="materials"]');
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

  data.materials.forEach((mat, i) => {

    lineLabels.push(mat.name);

    lineSeries[0].push(mat.neg);
    lineSeries[1].push(mat.neu);
    lineSeries[2].push(mat.pos);

    let part = Math.floor(i / 6);

    let currBarLabels = barLabels[part];
    let currBarSeries = barSeries[part];

    if (currBarLabels == null) {
      barLabels[part] = [];
      currBarLabels = barLabels[part];
    }

    if (currBarSeries == null) {
      barSeries[part] = [[], [], []];
      currBarSeries = barSeries[part];
    }

    currBarLabels.push(mat.name);

    currBarSeries[0].push(mat.neg);
    currBarSeries[1].push(mat.neu);
    currBarSeries[2].push(mat.pos);

    max = Math.max(max, mat.neg);
    max = Math.max(max, mat.neu);
    max = Math.max(max, mat.pos);
  });

  let size = data.materials.length;
  let remainder = size % 6;
  remainder = remainder === 0 ? 0 : 6 - remainder;

  // fill the gap
  for (let index = 0; index < remainder; index++) {

    let lastIndex = Math.floor(size / 6);
    let currBarLabels = barLabels[lastIndex];
    let currBarSeries = barSeries[lastIndex];

    currBarLabels.push('');

    currBarSeries[0].push(0);
    currBarSeries[1].push(0);
    currBarSeries[2].push(0);
  }

  summaryDone = true;

  if (activeTab == 'summary') {
    renderCharts();
  }
}

function renderCharts() {

  if (!summaryDone) {
    return;
  }

  barChartOptions.high = Math.ceil(max / 5) * 5;

  let barChartDiv = $('#summary_bar');

  barLabels.forEach((label, i) => {

    let barId = 'bar' + i;
    let chartDiv = $('<div id="' + barId + '"></div>');

    barChartDiv.append(chartDiv);

    var data = {
      labels: label,
      series: barSeries[i]
    };

    // Creation Proper
    new Chartist.Bar('#' + barId, data, barChartOptions, responsiveOptions);
  });

  if (lineLabels.length == 0) {
    return;
  }

  var data = {
    labels: lineLabels,
    series: lineSeries
  };

  new Chartist.Line('#summary_line', data, lineChartOptions, responsiveOptions);
}

function showFeedbacks(data) {

  $('#feedback_material_name').text(data.name);

  let respondents = data.respondents;
  let total = data.total;

  let respondentsCount = $('#feedback_respondents_count');
  respondentsCount.text(respondents);
  respondentsCount.addClass(respondents >= (total / 2) ? 'text-success' : 'text-danger');

  $('#feedback_total_count').text(data.total);

  showFeedbackContent('negative_feedbacks', data.feedbacks.neg);
  showFeedbackContent('neutral_feedbacks', data.feedbacks.neu);
  showFeedbackContent('positive_feedbacks', data.feedbacks.pos);
}

function showFeedbackContent(id, array) {

  let container = $('#' + id);

  if (array.length == 0) {
    container.append('No data...');
    return;
  }

  array.forEach((item, index) => {
    container.append(feedbackNode(item.displayName, item.content));
  });
}