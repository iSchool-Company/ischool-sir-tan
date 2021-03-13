import sys
import os
import json

from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer

analyser = SentimentIntensityAnalyzer()

file_name = "sample.txt" if len(sys.argv) < 2 else sys.argv[1]

with open(os.path.join(sys.path[0], file_name), "r") as file:
    contentJson = json.load(file)

contents = contentJson["contents"]

scores = []

for content in contents:
    polarityScore = analyser.polarity_scores(content)
    scores.append(polarityScore)

response = {"scores": scores}

print(json.dumps(response))
