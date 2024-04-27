from langchain.llms.huggingface_pipeline import HuggingFacePipeline
from langchain.prompts import PromptTemplate
from langchain.text_splitter import RecursiveCharacterTextSplitter
from transformers import AutoTokenizer
from langchain.chains import LLMChain
from prompts import QA_CREATOR, WRONG_A_GENERTOR, REGENERATOR_1, SIM_CREATOR, QA_LEADING_CREATOR, SUM_ALL_ANSWR_2, \
    COMBINE_SUM_ALL_ANSWER
from document_loaders import pre_processing
from huggingface_hub import login
import ast
import os
import torch


print(torch.cuda.is_available())

login(token="hf-token")

os.environ['CUDA_VISIBLE_DEVICES'] = '2'

gpu_saiga_llama = HuggingFacePipeline.from_model_id(
    model_id="IlyaGusev/saiga_llama3_8b",
    task="text-generation",
    device=0,  # -1 for CPU
    batch_size=6,  # adjust as needed based on GPU map and model size.
    model_kwargs={
        "temperature": 0.01,
        "max_length": 1536,
        "exponential_decay_length_penalty": (1280, 2.5),
        "top_p": 0.9,
        "do_sample": True},
)

tokenizer = AutoTokenizer.from_pretrained('IlyaGusev/saiga_llama3_8b')
text_splitter_llama = RecursiveCharacterTextSplitter.from_huggingface_tokenizer(
    tokenizer=tokenizer,
    chunk_size=512,  # 768
    chunk_overlap=128,
    add_start_index=True,
)


def splitter_llama(text):
    chunks = text_splitter_llama.create_documents([text])
    chunks_content = [item.page_content for item in chunks]
    return chunks_content


def regenerator(chunk, first_output):
    regen_template = REGENERATOR_1
    regen_prompt = PromptTemplate.from_template(regen_template)

    regen_chain = LLMChain(llm=gpu_saiga_llama, prompt=regen_prompt)
    res = regen_chain.invoke({"chunk": chunk, "question": first_output})
    print(f"\nПосле регена:\n{res['text']}")

    return res['text']


def check_questions_and_answers(input_strings):
    questions_only = True
    for string in input_strings:
        if '?' not in string:
            questions_only = False
            break
    return not questions_only


def string_to_sets(string, chunk):
    final_qa_list = []
    if "\n" in string:
        substrings = string.split('\n')
        for substring in substrings:
            listed_string = ast.literal_eval(substring)
            if check_questions_and_answers(listed_string):
                final_qa_list.append(listed_string)
    else:
        listed_string = ast.literal_eval(string)
        if check_questions_and_answers(listed_string):
            final_qa_list.extend(listed_string)
        else:
            answers = regenerator(chunk, string)
            index = answers.find('[')
            subanswers = answers[index:]
            if "\n" in subanswers:
                listed_answers = ast.literal_eval(subanswers.replace("\n", ","))
                for i in range(len(listed_string)):
                    pair = [listed_string[i], listed_answers[i][0]]
                    final_qa_list.append(pair)
            else:
                listed_answers = ast.literal_eval(subanswers)

                for i in range(len(listed_string)):
                    pair = [listed_string[i], listed_answers[i]]
                    final_qa_list.append(pair)

    return final_qa_list


def string_to_sets_wa(string):
    pre_string = string.strip("[]")
    pre_string = pre_string.strip("''")
    if "','" in pre_string:
        segments = pre_string.split("','")
    elif "',\n'" in pre_string:
        segments = pre_string.split("',\n'")
    else:
        segments = pre_string.split("', '")
    return segments


def wa_validation(set_a, set_wa):
    new_set = []

    for segments_wa, segments_a in zip(set_wa, set_a):
        if len(segments_a[0]) > 5:
            valid_segment = {f"question": segments_a[0], "answer1": segments_a[1], "answer2": segments_wa[0],
                             "answer3": segments_wa[1], "answer4": segments_wa[2], "right": '1'}
            new_set.append(valid_segment)

    valid_set = []
    for segm in new_set:
        if segm["answer1"] != segm["answer2"] != segm["answer3"]:
            valid_set.append(segm)

    return valid_set


def test_generator(document):
    # Убираем лишнее
    document_content = pre_processing(document)

    chunks = splitter_llama(document_content)

    qa_creator_template = QA_CREATOR
    qa_creator_prompt = PromptTemplate.from_template(qa_creator_template)
    # Сет с вопросами и ответами для всех чанков
    qa_sets = []
    for chunk in chunks:
        qa_chain = LLMChain(llm=gpu_saiga_llama, prompt=qa_creator_prompt)
        answers = qa_chain.invoke({"chunk": chunk})
        if answers['text'].startswith(("Не люблю менять тему разговора",
                                       "Что-то в вашем вопросе меня смущает",
                                       "Как у нейросетевой языковой модели у меня не может быть настроения")):
            return {"status_code": 401, "Blacklisted chunk": chunk}

        print(f"\nВходной чанк:\n{answers['chunk']}\nОтвет llm:\n{answers['text']}\n")

        qa_sets.extend(string_to_sets(answers['text'], chunk))

    print(f"Отформатированное множество:\n{qa_sets}\n")
    wrong_answers_template = WRONG_A_GENERTOR
    wrong_answers_prompt = PromptTemplate.from_template(wrong_answers_template)

    worng_a_chain = LLMChain(llm=gpu_saiga_llama, prompt=wrong_answers_prompt)
    # Сет с неверными ответами
    wa_sets = []
    for qa in qa_sets:
        q = qa[0]
        a = qa[1]
        variant = worng_a_chain.invoke({"question": q, "answer": a})
        print(f"Входной вопрос:\n{variant['question']}\nОтвет: {variant['answer']}\nОтвет llm:\n{variant['text']}\n")
        wa = string_to_sets_wa(variant['text'])
        wa_sets.append(wa)
    print(f"Множество ответов:\n{wa_sets}\n\n")

    validated_test = wa_validation(qa_sets, wa_sets)
    print(validated_test)
    return validated_test


def qa_validation(set_a, material_id):
    new_set = []
    count = 0
    for segments_a in set_a:
        count += 1
        valid_segment = {f"question": segments_a[0], "answer": segments_a[1], "materialId": material_id}
        new_set.append(valid_segment)
    return new_set


def qa_generator(document, material_id):
    # Убираем лишнее
    document_content = pre_processing(document)
    # Делим на чанки
    chunks = splitter_llama(document_content)

    qa_creator_template = QA_CREATOR
    qa_creator_prompt = PromptTemplate.from_template(qa_creator_template)
    # Сет с вопросами и ответами для всех чанков
    qa_sets = []
    for chunk in chunks:
        qa_chain = LLMChain(llm=gpu_saiga_llama, prompt=qa_creator_prompt)
        answers = qa_chain.invoke({"chunk": chunk})
        if answers['text'].startswith(("Не люблю менять тему разговора",
                                       "Что-то в вашем вопросе меня смущает",
                                       "Как у нейросетевой языковой модели у меня не может быть настроения")):
            return {"status_code": 401, "Blacklisted chunk": chunk}

        print(f"\nВходной чанк:\n{answers['chunk']}\nОтвет llm:\n{answers['text']}\n")

        qa_sets.extend(string_to_sets(answers['text'], chunk))

    print(f"Отформатированное множество:\n{qa_sets}\n")

    validated_test = qa_validation(qa_sets, material_id)
    print(validated_test)
    return validated_test


gpu_saiga_mistral = HuggingFacePipeline.from_model_id(
    model_id="IlyaGusev/saiga_mistral_7b_merged",
    task="text-generation",
    device=0,  # -1 for CPU
    batch_size=6,  # adjust as needed based on GPU map and model size.
    model_kwargs={
        "temperature": 0.01,
        "max_length": 1536,
        "exponential_decay_length_penalty": (1280, 2.5),
        "top_p": 0.9,
        "do_sample": True},
)


def sim_generator(question, ideal_answer, answer):
    sim_creator_template = SIM_CREATOR
    sim_creator_prompt = PromptTemplate.from_template(sim_creator_template)
    sim_chain = LLMChain(llm=gpu_saiga_mistral, prompt=sim_creator_prompt)
    answers = sim_chain.invoke({"question": question, "idealanswer": ideal_answer, "answer": answer})
    print(answers["text"])
    match = answers["text"]

    if "1" in match or "2" in match:
        result = 1
    else:
        result = 0

    return result


def qa_leading_generator(question, ideal_answer, answer):
    sim_creator_template = QA_LEADING_CREATOR
    sim_creator_prompt = PromptTemplate.from_template(sim_creator_template)
    sim_chain = LLMChain(llm=gpu_saiga_llama, prompt=sim_creator_prompt)
    answers = sim_chain.invoke({"question": question, "idealanswer": ideal_answer, "answer": answer})
    print("answers: ", answers["text"])
    qa_sets = []
    qa_sets.extend(
        [string_to_sets(answers['text'], {"question": question, "idealanswer": ideal_answer, "answer": answer})])
    wrong_answers_template = WRONG_A_GENERTOR
    wrong_answers_prompt = PromptTemplate.from_template(wrong_answers_template)
    print("QA_SETS: ", qa_sets)
    worng_a_chain = LLMChain(llm=gpu_saiga_llama, prompt=wrong_answers_prompt)
    # Сет с неверными ответами
    wa_sets = []
    for qa in qa_sets:
        q = qa[0]
        a = qa[1]
        variant = worng_a_chain.invoke({"question": q, "answer": a})
        print(f"Входной вопрос:\n{variant['question']}\nОтвет: {variant['answer']}\nОтвет llm:\n{variant['text']}\n")
        wa = string_to_sets_wa(variant['text'])
        wa_sets.append(wa)
    print(f"Множество ответов:\n{wa_sets}\n\n")
    validated_test = wa_validation(qa_sets, wa_sets)
    print(validated_test)
    return validated_test


def summarize_all_answers(answers):
    chunks = splitter_llama(answers)
    chunks_string = ""
    for chunk in chunks:
        summ_all_answers_template = SUM_ALL_ANSWR_2
        summ_all_answ_prompt = PromptTemplate.from_template(summ_all_answers_template)
        sim_chain = LLMChain(llm=gpu_saiga_llama, prompt=summ_all_answ_prompt)

        chunk_res = sim_chain.invoke({"answers": chunk})
        chunks_string += f"{chunk_res['text']}\n\n"
        print("chunk:", chunk_res)

    combine_summ_template = COMBINE_SUM_ALL_ANSWER
    combine_summ_prompt = PromptTemplate.from_template(combine_summ_template)
    combine_chain = LLMChain(llm=gpu_saiga_llama, prompt=combine_summ_prompt)

    res = combine_chain.invoke({"all_chunks": chunks_string})

    return res["text"]
