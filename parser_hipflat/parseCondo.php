<meta charset="UTF-8">
<?php
include 'simple_html_dom.php';
$host = 'localhost';
$dbName   = 'u5020191_lumio_by';
$user = 'u5020191_default';
$pass = 'shifr8565';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$db = new PDO($dsn, $user, $pass, $opt);
//$result = $db->query("SELECT * FROM `catalog_pages` WHERE `status` = '0' ORDER BY `page_id` DESC;");
//$row = $result->fetch(PDO::FETCH_ASSOC);
//$page = $row['page_id'];
//echo $page;
$count = 0;
//for ($i=0; $i<50; $i++) {
    //sleep(2);
    //$page ++;
    $url = 'https://www.hipflat.com/search/sale/condo_y/any_r1/any_r2/any_p/any_b/any_a/any_w/any_i/100.62442610451406,13.77183154691727_c/12_z/list_v';
    $data = file_get_html($url)->save();
    //echo $data;
    //$items = json_decode($data)->items;
    $data = str_get_html($data);
    $listings = $data->find('ul.listings', 0);
    $lastPage = $data->find('div.list-view-paginator-wrapper a', -1);
    echo $listings;
    echo $lastPage;
    $count = 0;
    $ads = [];
    foreach ($ads as $ad) {
        $productName = trim($ad->innertext);
        $productHref = $ad->href;
        if ($productName != 'Видео о товаре') {
            $result = $db->query("SELECT * FROM `catalog_products` WHERE `href` = '$productHref'");
            $count++;
            if (!$result->rowCount()) {
                $result = $db->query("INSERT INTO `catalog_products` (name, href, status) VALUES ('$productName', '$productHref', '0');");

                echo $count . ' ' . trim($ad->innertext) . "<br>";
            }
            else{
                echo $count . ' ' . trim($ad->innertext) . " - товар уже занесен<br>";
            }
        }
    }
    //$result = $db->query("INSERT INTO `catalog_pages` (page_id, quantity, status) VALUES ('$page', '$count', '1');");
//$result = $db->query("UPDATE `catalog_pages` SET `quantity` = '$count', `status` = '1' WHERE `page_id` = '$page';");
