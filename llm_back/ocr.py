# pip install easyocr
import asyncio
import easyocr
from docx import Document
import io
from PIL import Image
import numpy as np


@staticmethod
def extract_and_ocr_images(doc_path):
    doc = Document(doc_path)
    full_text = ""
    reader = easyocr.Reader(['ru'])

    # Перебор всех частей документа, содержащих изображения
    for rel in doc.part.rels.values():
        if 'image' in rel.reltype:
            image_part = rel.target_part
            image_bytes = image_part.blob
            image_stream = io.BytesIO(image_bytes)

            # Открытие изображения для OCR
            image = Image.open(image_stream)
            ocr_results = reader.readtext(np.array(image))

            # Собираем весь распознанный текст
            text_from_image = ' '.join([res[1] for res in ocr_results])
            full_text += text_from_image

            # Потенциально закрываем изображение после использования
            image.close()

    return full_text

@staticmethod
def docx_ocr(docx_path):
    doc_text = extract_and_ocr_images(docx_path)
    result = "Вот картинки которые прилагались к документу:   " + doc_text
    return result

