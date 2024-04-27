<?php

class Templates
{
    public function documentHead($pageName) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Виртуальный асессор | <?=$pageName;?></title>
            <link rel="icon" sizes="16x16" type="image/png" href="./public/img/favicon-16x16.png">
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="./public/css/gb.bundle.css">
            <?php
            switch ($pageName) {
                case 'Chat':
                    ?>
                    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
                    <?
                    break;

                default:
                    ?> <?
                    break;
            }
            ?>
        </head>
        <?
    }

    public function documentJavascript($pageName) {
        ?>
        <script src="./public/js/plugins/jquery-3.7.1.min.js"></script>
        <script src="./public/js/main.js"></script>
        <?php

        switch ($pageName) {
            case 'Sign In':
                ?>
                <script src="./public/js/pages/sign-in.js"></script>
                <?
                break;

            case 'Chat':
                ?>
                <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
                <script src="./public/js/pages/chat.js"></script>
                <?
                break;

            case 'Settings':
                ?>
                <script src="./public/js/pages/settings.js"></script>
                <?
                break;

            case 'Users':
                ?>
                <script src="./public/js/plugins/sweetalert.js"></script>
                <script src="./public/js/pages/users.js"></script>
                <?
                break;  
                
            case 'Material':
                ?>
                <script src="./public/js/plugins/dropzone.min.js"></script>
                <script src="./public/js/plugins/sweetalert.js"></script>
                <script src="./public/js/pages/material.js"></script>
                <?
                break;

            default:
                ?> <?
                break;
        }
    }

    public function geekBrainsNavigation($pageName) {

        $utilityClass = new UtilityClass();

        ?>
                        <div class="bg-white p-6 rounded-[32px] lg:grid flex items-center lg:justify-center justify-start gap-[16px] overflow-x-auto">
                            <a href="/dashboard" class="flex items-center gap-[12px] py-[12px] px-[16px] hover:bg-[#eff0f5] transition-all rounded-[8px] w-[188px] <?php if ($pageName == "Chat") {?>!bg-[#f4f5fa]<?php } ?>">
                                <div>
                                    <svg class="w-6 h-6 text-[#7c8092] <?php if ($pageName == "Chat") {?>!text-[#8d46f6]<?php } ?>" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[#7c8092] font-onest font-medium text-[18px] <?php if ($pageName == "Chat") {?>!text-[#8d46f6]<?php } ?>">Чат</span>
                                </div>
                            </a>
                            <a href="/settings" class="flex items-center gap-[12px] py-[12px] px-[16px] hover:bg-[#eff0f5] transition-all rounded-[8px] w-[188px] <?php if ($pageName == "Settings") {?>!bg-[#f4f5fa]<?php } ?>">
                                <div>
                                    <svg class="w-6 h-6 text-[#7c8092] <?php if ($pageName == "Settings") {?>!text-[#8d46f6]<?php } ?>" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[#7c8092] font-onest font-medium text-[18px] <?php if ($pageName == "Settings") {?>!text-[#8d46f6]<?php } ?>">Настройки</span>
                                </div>
                            </a>
                            <?php
                            if($utilityClass->getUsersAccessType() == "admin") {
                            ?>
                            <hr class="border">
                            <a href="/users" class="flex items-center gap-[12px] py-[12px] px-[16px] hover:bg-[#eff0f5] transition-all rounded-[8px] w-[188px] <?php if ($pageName == "Users") {?>!bg-[#f4f5fa]<?php } ?>">
                                <div>
                                    <svg class="w-6 h-6 text-[#7c8092] <?php if ($pageName == "Users") {?>!text-[#8d46f6]<?php } ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[#7c8092] font-onest font-medium text-[18px] <?php if ($pageName == "Users") {?>!text-[#8d46f6]<?php } ?>">Пользователи</span>
                                </div>
                            </a>
                            <a href="/material" class="flex items-center gap-[12px] py-[12px] px-[16px] hover:bg-[#eff0f5] transition-all rounded-[8px] w-[188px] <?php if ($pageName == "Material") {?>!bg-[#f4f5fa]<?php } ?>">
                                <div>
                                    <svg class="w-6 h-6 text-[#7c8092] <?php if ($pageName == "Material") {?>!text-[#8d46f6]<?php } ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[#7c8092] font-onest font-medium text-[18px] <?php if ($pageName == "Material") {?>!text-[#8d46f6]<?php } ?>">Материал</span>
                                </div>
                            </a>
                            <?php
                            }
                            ?>
                        </div>
        <?php
    }
}

