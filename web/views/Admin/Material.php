<?php
$templates = new Templates();

$templates->documentHead("Material");
?>
<body class="bg-[#f4f5fa]">
    <header class="bg-white mb-8">
        <div class="flex items-center justify-between md:px-20 px-8 py-6">
            <div>
                <img src="./public/img/geekbrains-logo-light.svg" class="w-[186px] h-[24px] cursor-pointer">
            </div>
            <div class="flex items-center">
                <div>
                    <a href="/logout" class="bg-[#e1e1e9] text-[#191816] text-[16px] py-[12px] px-[20px] rounded-[12px] font-onest font-medium hover:bg-[#d4d4dd] transition-all">Выход</a>
                </div>
            </div>
        </div>
    </header>
    <main>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="md:flex md:flex-grow md:gap-[24px]">
                    <div class="md:basis-3/12 md:mb-0 mb-6">
                        <?php $templates->geekBrainsNavigation("Material"); ?>
                    </div>
                    <div class="md:basis-9/12">
                        <div class="bg-white p-[32px] rounded-[32px]">
                            <div class="mb-4">
                                <h1 class="font-onest font-medium md:text-[24px] text-[20px] text-[#191816]">Материал</h1>
                            </div>
                            <div class="mb-4">
                                <button type="button" class="h-[40px] py-[10px] px-[16px] text-[14px] font-medium bg-[#8d46f640] hover:opacity-80 text-center rounded-[4px] font-onest text-[#9655f6] transition-all disabled:opacity-70 disabled:cursor-not-allowed open-modal-button" data-modal-target="#uploadNewMaterial">Загрузить материал</button>
                            </div>
                            <div class="material-block mutation-area">
                                <div class="bg-[#f1f3f4] rounded-[8px] justify-center flex items-center h-[200px] animate-pulse">
                                    <div class="grid justify-center items-center justify-items-center">
                                        <div>
                                            <span class="text-[16px] font-medium text-[#b8b8b8]">Пока тут ничего нет</span>
                                        </div>
                                        <div>
                                            <svg class="text-[#b8b8b8] w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <div class="relative z-[100] hidden opacity-0 modal" id="uploadNewMaterial" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-[100] w-screen overflow-y-auto">
        <div class="flex lg:min-h-full items-end justify-center p-4 text-center lg:items-center lg:p-0">
        <div class="modal-content relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all lg:my-8 lg:w-full lg:max-w-md lg:p-6">
            <div>
                <div class="text-center">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 font-onest" id="modal-title">Загрузка нового материала</h3>
                    <div class="mt-4">
                        <div class="text-left">
                            <label class="font-onest text-[16px] text-[#191816] mb-1 font-onest">Название материала:</label>
                            <input type="text" class="font-onest text-[15px] text-[#50667b] bg-[#ebedf7] rounded-[3px] px-[16px] py-[8px] outline-none focus:opacity-80 transition-all w-full material-name-input" placeholder="Лекция по теории электросвязи">
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100" id="dropzone-file">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 dropzone">
                                    <svg class="w-6 h-6 mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold font-onest">Кликните для загрузки</span> или перетащите</p>
                                    <p class="text-xs text-gray-500 font-onest">.docx файл</p>
                                    <p class="hidden text-xs text-green-600 file-added font-medium mt-1 font-onest">Файл загружен!</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 lg:mt-6 lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-3">
                <button type="button" class="inline-flex w-full justify-center rounded-md bg-[#8d46f640] font-onest px-3 py-2 text-sm font-semibold text-[#9655f6] shadow-sm hover:opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 lg:col-start-2 upload-new-material-button">Загрузить</button>
                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 lg:col-start-1 lg:mt-0 modal-close-button">Закрыть</button>
            </div>
        </div>
        </div>
    </div>
    </div>
    </div>

    <div class="relative z-[100] hidden opacity-0 modal" id="viewMaterial" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-[100] w-screen overflow-y-auto">
            <div class="flex lg:min-h-full items-end justify-center p-4 text-center lg:items-center lg:p-0">
            <div class="modal-content relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all lg:my-8 lg:w-full lg:max-w-7xl lg:p-6">
                <div>
                    <div class="text-center">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 font-onest material-name-title" id="modal-title"></h3>
                        <div class="mt-4">
                            <h3 class="text-sm font-semibold leading-6 text-gray-900 font-onest" id="modal-title">Список вопросов</h3>
                            <div class="questions-list">
                                <div class="bg-[#f1f3f4] rounded-[8px] justify-center flex items-center h-[200px] animate-pulse mt-2">
                                    <div class="grid justify-center items-center justify-items-center">
                                        <div>
                                            <span class="text-[16px] font-medium text-[#b8b8b8]">Пока тут ничего нет</span>
                                        </div>
                                        <div>
                                            <svg class="text-[#b8b8b8] w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-semibold leading-6 text-gray-900 font-onest" id="modal-title">Автоматическое тестирование</h3>
                            <div class="test-list">
                                <div class="bg-[#f1f3f4] rounded-[8px] justify-center flex items-center h-[200px] animate-pulse mt-2">
                                    <div class="grid justify-center items-center justify-items-center">
                                        <div>
                                            <span class="text-[16px] font-medium text-[#b8b8b8]">Пока тут ничего нет</span>
                                        </div>
                                        <div>
                                            <svg class="text-[#b8b8b8] w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 lg:mt-6 lg:grid lg:grid-flow-row-dense lg:grid-cols-3 lg:gap-3">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-[#8d46f640] font-onest px-3 py-2 text-sm font-semibold text-[#9655f6] shadow-sm hover:opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 lg:col-start-3 generate-test-button" material-id="">Сгенерировать тест</button>
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-[#8d46f640] font-onest px-3 py-2 text-sm font-semibold text-[#9655f6] shadow-sm hover:opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 lg:col-start-2 create-questions-button" material-id="">Создать вопросы</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 lg:col-start-1 lg:mt-0 modal-close-button">Закрыть</button>
                </div>
            </div>
            </div>
        </div>
    </div>

    <?php
    $templates->documentJavascript("Material");
    ?>
</body>
</html>