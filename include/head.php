<?php

class Head
{
    private $title;

    /**
     * Подключение стилей/скриптов
     * динамическое изменение загаловка
     */
    public function __construct($myTitle)
    {
        $this->title = $myTitle;

        echo '
                    <!DOCTYPE html>
                    <html lang="ru">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                        <title>'.$this->title.'</title>
                        <link rel="stylesheet" href="/css/bootstrap.min.css">
                        <script src="/js/jquery.min.js"></script>
                        <script src="/js/bootstrap.min.js"></script>
                        <script src="/js/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                        <link rel="stylesheet" href="css/style.css">
                    </head>
                 ';
    }
}
