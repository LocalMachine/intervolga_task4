<?php

class Database
{
    private $link;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * Подключение к MySql через PDO
     * @return $this
     */
    private function connect()
    {
        $config = require_once 'db_connect.php';
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->link = new PDO($dsn, $config['username'], $config['password'], $opt);

        return $this;
    }

    /**
     * Шифрование
     * @param $country - входящая переменная (страна), которая будет зашифрована
     * @return string - результат шифрования
     */
    private function encryptData($country)
    {
        $key = "85406564D4AE5BC5880A7261";
        $iv = "ivpasswd";

        $buffer = base64_encode($country);
        $encryption = mcrypt_cbc(MCRYPT_3DES, $key, $buffer, MCRYPT_ENCRYPT, $iv);
        $new_encryption = base64_encode($encryption);

        return $new_encryption;
    }

    /**
     * Расшифровка
     * @param $country - входящая переменная (страна), которая будет расшифрована
     * @return string - результат расшифровки
     */
    private function decryptData($country)
    {
        $key = "85406564D4AE5BC5880A7261";
        $iv = "ivpasswd";

        $decryption_buffer = base64_decode($country);
        $new_decryption = mcrypt_cbc(MCRYPT_3DES, $key, $decryption_buffer, MCRYPT_DECRYPT, $iv);
        $normal_buffer = base64_decode($new_decryption);

        return $normal_buffer;
    }


    /**
     * Запрос к базе данныз для добавления
     * @param $sql - входящий SQL запрос
     * @param $placeholder - входящий массив плейсхолдеров
     * @return mixed - результат SQL запроса
     */
    public function execute($sql, $placeholder)
    {
        $encrypt_country = $this->encryptData($placeholder);
        $sth = $this->link->prepare($sql);

        return $sth->execute(array($encrypt_country));
    }

    /**
     * Запрос к базе данныз для выборки
     * @param $sql - входящий SQL запрос
     * @return array результат SQL запроса в виде многомерного ассоциативного массива
     */
    public function query($sql)
    {
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();

        for ($i = 0; $i < count($result); $i++)
        {
            foreach ($result as $row => $value)
            {
                if ($row == 'name')
                {
                    $result[$i]['name'] = $this->decryptData($result[$i]['name']);
                }
            }
        }

        if ($result === false)
        {
            return [];
        }

        return $result;

    }

}
