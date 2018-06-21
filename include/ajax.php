<?php // только аякс запросы
require_once 'main.php';
$db = new Database();

/**
 * Добавление страны в базу
 * Проверка на совпадения названия страны
 */
if (isset($_POST['act']) && $_POST['act'] === 'add_country') {

    $country = trim($_POST['country']);
    @$all_country = $db->query("SELECT `name` FROM `country`");

    foreach ($all_country  as $row => $value)
    {
        if ($all_country[$row]['name'] == $country)
        {
            echo true;
            die();
        }
    }

    $db->execute("INSERT INTO `country` SET `name`= ?", $country);
    echo "Страна $country успешно добавлен(а)";

}


/**
 * Вывод стран
 */
if (isset($_POST['act']) && $_POST['act'] === 'select_country') {

    @$country = $db->query("SELECT * FROM `country` ORDER BY `name` ASC ");

    echo json_encode($country);

}
