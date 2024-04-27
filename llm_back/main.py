import os
import requests
from fastapi import FastAPI, File, UploadFile, Form, Body, HTTPException, BackgroundTasks
from llm_part import qa_generator, test_generator
from document_loaders import docx_loader
from pydantic import BaseModel
import req
import json
import llm_part


app = FastAPI()


class QuestionRequest(BaseModel):
    fileUrl: str
    materialId: str


@app.post("/create-questions")
async def qa_generate(data: QuestionRequest, background_tasks: BackgroundTasks):
    background_tasks.add_task(qa_gen, data.fileUrl, data.materialId)
    return {"response": "success"}


@app.post("/create-questions-old-version")
async def download_file(data: QuestionRequest):
    try:
        # Скачиваем файл
        response = requests.get(data.fileUrl, stream=True)
        response.raise_for_status()

        filename = data.fileUrl.split("/")[-1]
        filepath = os.path.join("temp", filename)

        with open(filepath, "wb") as f:
            for chunk in response.iter_content(chunk_size=8192):
                f.write(chunk)
        result = qa_generator(docx_loader(filepath), material_id=data.materialId)

        print(f"File {filename} has been downloaded and saved to {filepath}")

        res_form = json.dumps({"data": result})
        print(res_form)

        req.question2serv(res_form)
        return {"status": "success", "message": result}
    except requests.exceptions.RequestException as e:
        return {"status": "error", "message": f"Failed to fetch file: {str(e)}"}
    except Exception as e:
        return {"status": "error", "message": f"An error occurred: {str(e)}"}


@app.post("/create-test")
async def qa_test_gen(data: QuestionRequest, background_tasks: BackgroundTasks):
    background_tasks.add_task(test_gen, data.fileUrl, data.materialId)
    return {"response": "success"}


@app.post("/create-test-old-version")
async def test_generation(data: QuestionRequest):
    try:
        response = requests.get(data.fileUrl, stream=True)
        response.raise_for_status()

        filename = data.fileUrl.split("/")[-1]
        filepath = os.path.join("temp", filename)
        with open(filepath, "wb") as f:
            for chunk in response.iter_content(chunk_size=8192):
                f.write(chunk)
        result = test_generator(docx_loader(filepath))

        res_form = json.dumps({"data": result, "materialId": data.materialId})
        print(res_form)
        req.test2serv(res_form)

        return {"data": result, "materialId": data.materialId}
    except requests.exceptions.RequestException as e:
        return {"status": "error", "message": f"Failed to fetch file: {str(e)}"}

    except Exception as e:
        return {"status": "error", "message": f"An error occurred: {str(e)}"}


class similarity(BaseModel):
    user_id: int
    question_id: int
    question: str
    ideal_answer: str
    answer_text: str


class responseSuccess(BaseModel):
    response: str


@app.post("/user-answer")
async def qa_leading_gen(user: similarity, background_tasks: BackgroundTasks) -> responseSuccess:
    background_tasks.add_task(qa_lead, user.question, user.ideal_answer, user.answer_text, user.question_id,
                              user.user_id)
    return {"response": "success"}


def qa_lead(question, ideal_answer, answer_text, question_id, user_id):
    metric = llm_part.sim_generator(question, ideal_answer, answer_text)
    if metric == 1:
        req.answer2serv("Правильно ответил", question_id, user_id, metric)
    else:

        res = llm_part.qa_leading_generator(question, ideal_answer, answer_text)

        req.answer2serv(res[0]['question'], question_id, user_id, metric)


def qa_gen(fileUrl, materialId):
    try:
        # Скачиваем файл
        response = requests.get(fileUrl, stream=True)
        response.raise_for_status()

        filename = fileUrl.split("/")[-1]
        filepath = os.path.join("temp", filename)

        with open(filepath, "wb") as f:
            for chunk in response.iter_content(chunk_size=8192):
                f.write(chunk)
        result = qa_generator(docx_loader(filepath), material_id=materialId)

        print(f"File {filename} has been downloaded and saved to {filepath}")

        res_form = json.dumps({"data": result})
        print(res_form)

        req.question2serv(res_form)
        return {"status": "success", "message": result}
    except requests.exceptions.RequestException as e:
        return {"status": "error", "message": f"Failed to fetch file: {str(e)}"}
    except Exception as e:
        return {"status": "error", "message": f"An error occurred: {str(e)}"}


def test_gen(fileUrl, materialId):
    try:
        response = requests.get(fileUrl, stream=True)
        response.raise_for_status()

        filename = fileUrl.split("/")[-1]
        filepath = os.path.join("temp", filename)
        with open(filepath, "wb") as f:
            for chunk in response.iter_content(chunk_size=8192):
                f.write(chunk)
        result = test_generator(docx_loader(filepath))

        res_form = json.dumps({"data": result, "materialId": materialId})
        print(res_form)
        req.test2serv(res_form)

        return {"data": result, "materialId": materialId}
    except requests.exceptions.RequestException as e:
        return {"status": "error", "message": f"Failed to fetch file: {str(e)}"}

    except Exception as e:
        return {"status": "error", "message": f"An error occurred: {str(e)}"}


class resume(BaseModel):
    userId: str
    chatHistory: str


@app.post("/request-resume")
async def resume_generate(data: resume, background_tasks: BackgroundTasks):
    background_tasks.add_task(resume_gen, data.userId, data.chatHistory)
    return {"response": "success"}


def resume_gen(userId, chatHistory):
    res = llm_part.summarize_all_answers(chatHistory)
    req.resume2serv(userId, res)
