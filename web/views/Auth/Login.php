<?php
$templates = new Templates();

$templates->documentHead("Sign In");
?>
<body>
    <div class="flex flex-col h-screen justify-between">
        <header>
            <div class="px-4 sm:px-16 lg:px-24 mt-6">
                <div class="flex items-center justify-start">
                        <div class="">
                            <img src="./public/img/geekbrains-logo-light.svg" class="w-[186px] h-[24px] cursor-pointer">
                        </div>
                </div>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl">
                    <div class="text-center mb-6">
                        <h1 class="font-onest text-[18px] text-[#aaaaaa] font-normal">Вход на платформу</h1>
                    </div>
                    <div class="grid items-center justify-center">
                        <div>
                            <form class="sign-in-form">
                                <div class="mb-4">
                                    <input type="text" class="font-onest text-[15px] text-[#50667b] bg-[#ebedf7] rounded-[3px] px-[16px] py-[8px] outline-none focus:opacity-80 transition-all md:w-[400px] w-[300px] login-input" placeholder="Логин">
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="font-onest text-[15px] text-[#50667b] bg-[#ebedf7] rounded-[3px] px-[16px] py-[8px] outline-none focus:opacity-80 transition-all md:w-[400px] w-[300px] password-input" placeholder="Пароль">
                                </div>
                                <div>
                                    <button type="submit" class="h-[40px] py-[10px] px-[16px] text-[14px] w-full bg-[#08d092] hover:opacity-80 text-center rounded-[4px] font-onest text-[#ffffff] transition-all">Войти</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="px-4 sm:px-16 lg:px-24 mb-4">
                <div>
                    <p class="font-onest text-[14px] text-[#7c8092] leading-[18px] mb-1">Версия 1.0</p>
                    <p class="font-onest text-[14px] text-[#7c8092] leading-[18px]">Developed: <span class="cursor-pointer opacity-80">Neural Club</span></p>
                </div>
            </div>
        </footer>
    </div>
    <?php
    $templates->documentJavascript("Sign In");
    ?>
</body>
</html>