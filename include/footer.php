<?php

class Footer
{
    /**
     * Подключение скриптов
     */
    public function __construct()
    {
        echo '
                 <script src="/js/script.js"></script>
                 ';
    }
}

$footer = new Footer();