<?php 

$website = "https://api.telegram.org/bot5508749906:AAFMI5ULYmj1cK0Nc9i0x7TAX6qZ_24hLOk";

$websitefile = "https://api.telegram.org/file/bot5472227684:AAFp6er2a5FUxyITYy7BQblYSaeeI6b2a0M5508749906:AAFMI5ULYmj1cK0Nc9i0x7TAX6qZ_24hLOk";

$updates = file_get_contents("php://input");

$updates = json_decode($updates , TRUE);

$chat_id = $updates["message"]["chat"]["id"];

$text = $updates["message"]["text"];

$user_id = $updates["message"]["chat"]["id"];

$msg_id = $updates["message"]["message_id"];

$first_name = $updates["message"]["chat"]["first_name"];

$last_name = $updates["message"]["chat"]["last_name"];

$username = $updates["message"]["chat"]["username"];

$file_id = $updates["message"]["document"]["file_id"];

$video_id = $updates["message"]["video"]["file_id"];

$photo_id = $updates["message"]["photo"]["file_id"];

$audio_id = $updates["message"]["audio"]["file_id"];


if (strpos($text,"/start") !== false) {
sendMessage($website, $chat_id, "<b>Bienvenido</b> 

<strong>👤$first_name $last_name</strong>
🆔$chat_id");
}

if (strpos($text, "/upload ") !== false) {
$url = str_replace("/upload ", "", $text);
  sendMessage($website, $chat_id, "✅URL RECONOCIDA✅");
  if (file_get_contents($url) !== false) {
    $size = urlsize($url) / 1048576;
    editmsg($website, $chat_id, $msg_id + 1, "⏫SUBIENDO⏫
  ".$size." MB");
    
    download($website, $chat_id, $msg_id + 1, $url);
    
  } else {
 sendMessage($website, $chat_id, "🛑URL NO VALIDA🛑");
  }
} else {
if (strpos($text, "/upload") !== false) {
sendMessage($website, $chat_id, "🛑 ERROR DEL FORMATO DEL COMANDO 🛑");
}
}

if (strpos($text, "/files") !== false) {
$thefolder = "./files/$chat_id/";
if ($handler = opendir($thefolder)) {
    while (false !== ($file = readdir($handler))) {
        if ($file == "." or $file == "..") { } else {  sendMessage($website, $chat_id, urldecode($file));}
    }
    closedir($handler);
}
}

if (strpos($text, "/downpress")) {
$zip = new \ZipArchive();

//abrimos el archivo y lo preparamos para agregarle archivos

$zip->open("$chat_id.zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

//indicamos cual es la carpeta que se quiere comprimir

$origen = realpath("./files/$chat_id");

//Ahora usando funciones de recursividad vamos a explorar todo el directorio y a enlistar todos los archivos contenidos en la carpeta

$files = new \RecursiveIteratorIterator(

            new \RecursiveDirectoryIterator($origen),

            \RecursiveIteratorIterator::LEAVES_ONLY

);

//Ahora recorremos el arreglo con los nombres los archivos y carpetas y se adjuntan en el zip

foreach ($files as $name => $file)

{

   if (!$file->isDir())

   {

       $filePath = $file->getRealPath();

       $relativePath = substr($filePath, strlen($origen) + 1);

       $zip->addFile($filePath, $relativePath);

   }

}

//Se cierra el Zip

$zip->close();
  sendDocument($website, $chat_id, "./files/$chat_id.zip", "Su archivo");
}

if ($file_id == null) {

} else {
sendMessage($website, $chat_id, "🛑 Aún no tengo esa función 🛑");
}
if ($video_id == null) {

} else {

sendMessage($website, $chat_id, "🛑 Aún no tengo esa función 🛑");
  
}

if ($photo_id == null) {

} else {
sendMessage($website, $chat_id, "🛑 Aún no tengo esa función 🛑");
}

if ($audio_id == null) {

} else {
sendMessage($website, $chat_id, "🛑 Aún no tengo esa función 🛑");
}

function editmsg($website, $chat_id, $msg_id, $text) {
  
file_get_contents($website."/editMessageText?chat_id=".$chat_id."&message_id=$msg_id"."&text=".urlencode($text)."&parse_mode=HTML");
}

function download($website, $chat_id, $msg_id, $url) {
$remote_file_url = $url;
mkdir("./files/$chat_id");
 $local_file = "./files/$chat_id/".basename($url);                         //destino

 $copy = copy($remote_file_url, $local_file);

 if ($copy) {

editmsg($website, $chat_id, $msg_id, "✅SUBIDO✅");

 } else {
editmsg($website, $chat_id, $msg_id, "🛑ERROR🛑");


 }
}

function sendMessage($website, $chatId, $text) {

$url = $website."/sendmessage?chat_id=".$chatId."&text=".urlencode($text)."&parse_mode=HTML";

file_get_contents($url);

}

function sendPhoto($website, $chatId, $photourl, $text) {

$url = $website."/sendphoto?chat_id=".$chatId."&photo=".$photourl."&caption=".$text;

file_get_contents($url);

}

function sendAudio($website, $chatId, $audiourl, $text) {

$url = $website."/sendaudio?chat_id=".$chatId."&audio=".$audiourl."&caption=".$anwser;

file_get_contents($url);

}

function sendDocument($website, $chatId, $documenturl, $text) {

$url = $website."/senddocument?chat_id=".$chatId."&document=".$documenturl."&caption=".$text;

file_get_contents($url);

}

function urlsize($url):int{

   return array_change_key_case(get_headers($url,1))['content-length'];

}


?>