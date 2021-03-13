import sys
import os
import json

from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer

analyser = SentimentIntensityAnalyzer()

file_name = "sample.txt" if len(sys.argv) < 2 else sys.argv[1]

with open(os.path.join(sys.path[0], file_name), "r") as file:
    contentJson = json.load(file)

scoreGroups = []

groups = contentJson["groups"]

for group in groups:

    scores = []

    for content in group:

        polarityScore = analyser.polarity_scores(content)

        scores.append(polarityScore)

    scoreGroups.append(scores)

response = {"groups": scoreGroups}

print(json.dumps(response))
