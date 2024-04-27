<?php
    @session_start();
    @session_destroy();
    @session_unset();
    ?>
    <meta http-equiv="refresh" content="0;URL=/" />
    <?
    exit();
?>