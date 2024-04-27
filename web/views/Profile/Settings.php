<?php
$templates = new Templates();

$templates->documentHead("Settings");
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
                        <?php $templates->geekBrainsNavigation("Settings"); ?>
                    </div>
                    <div class="md:basis-9/12">
                        <div class="bg-white p-[32px] rounded-[32px]">
                            <div class="mb-4">
                                <h1 class="font-onest font-medium md:text-[24px] text-[20px] text-[#191816]">Настройки пользователя</h1>
                            </div>
                            <div>
                                <div class="md:flex grid gap-[10px]">
                                    <div class="grid mb-6 w-full">
                                        <label class="font-onest text-[16px] text-[#191816] mb-1">Старый пароль:</label>
                                        <input type="password" class="font-onest text-[15px] text-[#50667b] bg-[#ebedf7] rounded-[3px] px-[16px] py-[8px] outline-none focus:opacity-80 transition-all w-full old-password" placeholder="******">
                                    </div>
                                    <div class="grid mb-6 w-full">
                                        <label class="font-onest text-[16px] text-[#191816] mb-1">Новый пароль:</label>
                                        <input type="password" class="font-onest text-[15px] text-[#50667b] bg-[#ebedf7] rounded-[3px] px-[16px] py-[8px] outline-none focus:opacity-80 transition-all w-full new-password" placeholder="******">
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="h-[40px] py-[10px] px-[16px] text-[14px] w-full font-medium bg-[#8d46f640] hover:opacity-80 text-center rounded-[4px] font-onest text-[#9655f6] transition-all save-button disabled:opacity-70 disabled:cursor-not-allowed">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    $templates->documentJavascript("Settings");
    ?>
</body>
</html>