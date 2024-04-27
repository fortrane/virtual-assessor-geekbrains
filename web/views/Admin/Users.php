<?php
$templates = new Templates();

$templates->documentHead("Users");
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
                        <?php $templates->geekBrainsNavigation("Users"); ?>
                    </div>
                    <div class="md:basis-9/12">
                        <div class="bg-white p-[32px] rounded-[32px]">
                            <div class="mb-4">
                                <h1 class="font-onest font-medium md:text-[24px] text-[20px] text-[#191816]">Все пользователи</h1>
                            </div>
                            <div class="mb-4">
                                <button type="button" class="h-[40px] py-[10px] px-[16px] text-[14px] font-medium bg-[#8d46f640] hover:opacity-80 text-center rounded-[4px] font-onest text-[#9655f6] transition-all register-new-user disabled:opacity-70 disabled:cursor-not-allowed">Создать новую учетную запись</button>
                            </div>
                            <div class="users-block">
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
    <?php
    $templates->documentJavascript("Users");
    ?>
</body>
</html>