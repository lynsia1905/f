<?php

header("Content-Type: application/json; utf-8;");

include "../../server/authcontrol.php";

if (!isset($_POST["tc"]) && !isset($_POST["ad"]) && !isset($_POST["soyad"]) && !isset($_POST["adresil"])) {
    die(json_encode(array("success" => "false", "message" => "param error")));
}

$tc = $_POST["tc"];
$ad = $_POST["ad"];
$soyad = $_POST["soyad"];
$adresil = $_POST["adresil"];

$query = http_build_query(array(
    "tc" => $tc,
    "ad" => $ad,
    "soyad" => $soyad,
    "adresil" => $adresil
));

if (empty($tc)) {
    $tc = "Yok";
}
if (empty($ad)) {
    $ad = "Yok";
}
if (empty($soyad)) {
    $soyad = "Yok";
}
if (empty($adresil)) {
    $adresil = "Yok";
}

$checkCooldown = checkCooldown($kid);
if ($checkCooldown["success"] == "false") {
    die(json_encode($checkCooldown));
} else {
    addCooldown($kid);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://37.221.122.170/api/2015/api.php?auth=f9OqyqPRmGhuZZJWjIzP0cikrNlUsImDZGJkYWyCj6DRmm1tU91ubGFTeNKmn8e9l5tmtmVbWRwkpZug4l9gIaxfI1X0aCknlepm8eg1YyEeJ3Yo8akmRiZl9hkGxvnJpnaWiFi5melKnLZWiVnWBsag");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
echo $response;

wizortbook($sorguURL, "Sorgu Denetleyicisi", "2015 Sorgu", "**$kadi** isimli üye **$tc** - **$ad** - **$soyad** - **$adresil** için sorgu yaptı!");
