<?php
$num = readLine("Inserisci il tuo numero di telefono: ");

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://my.telegram.org/auth/send_password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=".urlencode($num));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = "Origin: https://my.telegram.org";
$headers[] = "Accept-Encoding: gzip, deflate, br";
$headers[] = "Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4";
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";
$headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
$headers[] = "Accept: application/json, text/javascript, */*; q=0.01";
$headers[] = "Referer: https://my.telegram.org/auth";
$headers[] = "X-Requested-With: XMLHttpRequest";
$headers[] = "Connection: keep-alive";
$headers[] = "Dnt: 1";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$result = json_decode($result, true);
$hash = $result["random_hash"];
echo "\nHASH: $hash\n";
$password = readLine("Inserisci la password ricevuta: ");
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://my.telegram.org/auth/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=".urlencode($num)."&random_hash=$hash&password=$password");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = "Origin: https://my.telegram.org";
$headers[] = "Accept-Encoding: gzip, deflate, br";
$headers[] = "Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4";
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";
$headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
$headers[] = "Accept: application/json, text/javascript, */*; q=0.01";
$headers[] = "Referer: https://my.telegram.org/auth";
$headers[] = "X-Requested-With: XMLHttpRequest";
$headers[] = "Connection: keep-alive";
$headers[] = "Dnt: 1";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$result = curl_exec($ch);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
if(strpos($result, 'Invalid confirmation code!') !== false)
{
    echo "\nPassword non valida\n";
}
else if(strpos($result, 'Sorry, too many tries. Please try again later.') !== false)
{
    echo "\nErrore, troppe richieste\n";
}
else
{
    $token = explode("Set-Cookie: stel_token=", $result);
    $asd = explode(";", $token["1"]);
    $token = $asd["0"];
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://my.telegram.org/apps");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    
    $headers = array();
    $headers[] = "Dnt: 1";
    $headers[] = "Accept-Encoding: gzip, deflate, sdch, br";
    $headers[] = "Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";
    $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
    $headers[] = "Referer: https://my.telegram.org/";
    $headers[] = "Cookie: stel_token=$token";
    $headers[] = "Connection: keep-alive";
    $headers[] = "Cache-Control: max-age=0";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
    $sad = explode('<input type="hidden" name="hash" value="', $result);
    $sad2 = explode('"/>', $sad["1"]);
    $hash = $sad2["0"];

    echo "\nHo eseguito l'accesso\nLOGIN HASH: $hash\nstel_token=$token\n";
    
    $title = readLine("Inserisci il nome della tua app: ");
    $shortitle = readLine("Inserisci un nome  corto per la tua app: ");
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://my.telegram.org/apps/create");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "hash=$hash&app_title=$title&app_shortname=$shortitle&app_url=asd&app_platform=ios&app_desc=");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    
    $headers = array();
    $headers[] = "Cookie: stel_token=$token";
    $headers[] = "Origin: https://my.telegram.org";
    $headers[] = "Accept-Encoding: gzip, deflate, br";
    $headers[] = "Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";
    $headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
    $headers[] = "Accept: */*";
    $headers[] = "Referer: https://my.telegram.org/apps";
    $headers[] = "X-Requested-With: XMLHttpRequest";
    $headers[] = "Connection: keep-alive";
    $headers[] = "Dnt: 1";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://my.telegram.org/apps");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    
    $headers = array();
    $headers[] = "Dnt: 1";
    $headers[] = "Accept-Encoding: gzip, deflate, sdch, br";
    $headers[] = "Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";
    $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
    $headers[] = "Referer: https://my.telegram.org/";
    $headers[] = "Cookie: stel_token=$token";
    $headers[] = "Connection: keep-alive";
    $headers[] = "Cache-Control: max-age=0";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
    $cose = explode('<label for="app_id" class="col-md-4 text-right control-label">App api_id:</label>
      <div class="col-md-7">
        <span class="form-control input-xlarge uneditable-input" onclick="this.select();"><strong>', $result);
    $asd = explode("</strong></span>", $cose["1"]);
    $apiid = $asd["0"];
    $cose = explode('<label for="app_hash" class="col-md-4 text-right control-label">App api_hash:</label>
      <div class="col-md-7">
        <span class="form-control input-xlarge uneditable-input" onclick="this.select();">', $result);
    $asd = explode("</span>", $cose["1"]);
    $apihash = $asd["0"];
    $cose = explode('-----BEGIN RSA PUBLIC KEY-----', $result);
    $asd = explode("-----END RSA PUBLIC KEY-----", $cose["1"]);
    $rsakey = "-----BEGIN RSA PUBLIC KEY-----".$asd["0"]."-----END RSA PUBLIC KEY-----";
    echo "API-ID: $apiid\nAPI-HASH: $apihash\nRSA: $rsakey";
}
