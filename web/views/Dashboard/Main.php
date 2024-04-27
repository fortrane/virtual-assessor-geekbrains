<?php
$templates = new Templates();

$templates->documentHead("Dashboard");
?>
<body class="bg-[#f4f5fa]">
    <header class="bg-white mb-8">
        <div class="flex items-center justify-between lg:px-20 px-8 py-6">
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
                <div class="lg:flex lg:flex-grow lg:gap-[24px]">
                    <div class="lg:basis-3/12 lg:mb-0 mb-6">
                        <?php $templates->geekBrainsNavigation("Chat"); ?>
                    </div>
                    <div class="lg:basis-9/12">
                        <div class="bg-white lg:p-[32px] p-[16px] rounded-[32px]">
                            <div class="mb-4">
                                <h1 class="font-onest font-medium lg:text-[24px] text-[20px] text-[#191816]">Чат с экспертом</h1>
                            </div>
                            <div class="w-full rounded-t-[32px] bg-[#f4f5fa] px-6 pt-6 pb-8">
                                <div class="grid items-center gap-y-2">
                                    <div class="w-full">
                                        <span>Выбор материала для общения:</span>
                                    </div>
                                    <div class="lg:flex grid gap-2">
                                        <div class="w-full">
                                            <select class="font-onest text-[15px] text-[#50667b] bg-[#ebedf7] border-2 border-[#e2e2e2] rounded-[3px] px-[16px] py-[8px] outline-none focus:opacity-80 transition-all w-full material-select"></select>
                                        </div>
                                        <div>
                                            <button type="button" class="p-2 bg-[#8d46f640] hover:opacity-80 text-center rounded-[4px] font-onest text-[#9655f6] transition-all save-button disabled:opacity-70 disabled:cursor-not-allowed lg:w-auto w-full material-change-button">
                                                Применить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-4">
                                    <div class="w-full h-[1px] bg-[#e6e6e6]"></div>
                                </div>
                                <div class="chat-block h-[500px] overflow-y-scroll">
                                    <div class="grid justify-center py-8">
                                        <div class="place-self-center grid justify-items-center gap-y-2">
                                            <svg class="animate-spin h-6 w-6 fill-[#8d46f6] text-gray-200 mr-2" aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                            </svg>
                                            <span class="text-[14px] font-normal leading-[1.5] text-zinc-400">Загрузка чата...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full px-6 pt-6 pb-4 bg-[#f4f5fa] relative rounded-b-[32px]">
                                <input type="text" class="font-onest text-[15px] text-[#50667b] bg-[#ebedf7] border-2 border-[#e2e2e2] rounded-[3px] px-[16px] py-[8px] outline-none focus:opacity-80 transition-all w-full pr-[50px] disabled:opacity-70 disabled:cursor-not-allowed message-input" placeholder="Привет, давай начнем проверку моих знаний!" disabled>
                                <button type="button" class="p-2 bg-[#8d46f640] hover:opacity-80 text-center rounded-[4px] font-onest text-[#9655f6] transition-all save-button disabled:opacity-70 disabled:cursor-not-allowed absolute right-0 mr-[30px] mt-[5px] send-new-message-button" disabled>
                                    <svg class="w-4 h-4" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    $templates->documentJavascript("Chat");
    ?>
</body>
</html>