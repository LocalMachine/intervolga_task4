<?php

class Database
{
    private $link;

    public function __construct()
    {
        $this->connect();
    }

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

    private function encryptData($country)
    {
        $key = "85406564D4AE5BC5880A7261";
        $iv = "ivpasswd";

        $buffer = base64_encode($country);
        $encryption = mcrypt_cbc(MCRYPT_3DES, $key, $buffer, MCRYPT_ENCRYPT, $iv);
        $new_encryption = base64_encode($encryption);

        return $new_encryption;
    }

    private function decryptData($country)
    {
        $key = "85406564D4AE5BC5880A7261";
        $iv = "ivpasswd";

        $decryption_buffer = base64_decode($country);
        $new_decryption = mcrypt_cbc(MCRYPT_3DES, $key, $decryption_buffer, MCRYPT_DECRYPT, $iv);
        $normal_buffer = base64_decode($new_decryption);

        return $normal_buffer;
    }


    public function execute($sql,$placeholder)
    {
        $encrypt_country = $this->encryptData($placeholder);
        $sth = $this->link->prepare($sql);

        return $sth->execute(array($encrypt_country));
    }

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
