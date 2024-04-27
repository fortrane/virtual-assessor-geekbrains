import requests
import os
import time

url_s = "http://127.0.0.1/src/Api/v1.php"
def answer2serv(answerText, questionId, userId,metrics):
    url = f"{url_s}?receiveBotAnswer"
    post_data = {
    "answerText": '',
    "questionId": '',
    "userId": '',
    "metrics": ''
    }

    post_data["answerText"] = answerText
    post_data["questionId"] = int(questionId)
    post_data["userId"] = int(userId)
    post_data["metrics"] = metrics
    print("===PostData:  ", post_data)
    response = requests.post(url, data=post_data)
    print(response.text)
def test2serv(testJson):
    url = f"{url_s}?receiveTest"
    post_data = {
    "testJson": '',
    }

    post_data["testJson"] = testJson


    response = requests.post(url, data=post_data)
    print(response.text)

def question2serv(questionsJson):
    url = f"{url_s}?receiveQuestions"
    post_data = {
    "questionsJson": '',
    }
    post_data["questionsJson"] = questionsJson
    response = requests.post(url, data=post_data)
    print(response.text)

def resume2serv(userId,resume):
    url = f"{url_s}?receiveResume"
    post_data = {
    "userId": '',
    "resume": ''
    }
    post_data["userId"] = userId
    post_data["resume"] = resume
    response = requests.post(url, data=post_data)
    print(response.text)