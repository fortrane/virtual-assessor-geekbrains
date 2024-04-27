from langchain_community.document_loaders import Docx2txtLoader, PyPDFLoader
from langchain.text_splitter import CharacterTextSplitter
#import ocr


def docx_loader(path):
    loader = Docx2txtLoader(path)
    data = loader.load()
    #data[0].page_content +=ocr.docx_ocr(path)
    return data


def pdf_loader(path):
    loader = PyPDFLoader(path)
    pages = loader.load_and_split()
    return pages


def text_splitter(text):
    text_splitter = CharacterTextSplitter.from_tiktoken_encoder(
        separator='. ',
        encoding_name='cl100k_base',
        chunk_size=2500,
        chunk_overlap=0
    )
    texts = text_splitter.split_text(text)
    return texts


def pre_processing(data):
    stroke = data[0].page_content.replace('\n', ' ')
    new_stroke = stroke.replace('  ', ' ')

    return new_stroke

