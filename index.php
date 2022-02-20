<?php
date_default_timezone_set('Asia/Tehran');
error_reporting(0);
define('API_KEY','1498413768:AAGxOy1qrTcojBTmHez5oQgeXKeEO0r9wn4'); //توکن
$host="http://llbots.cf/RoBot/ocr";//آدرس دامین و پوشه سورس 
//=======================================================================
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);}}
function Botinfo($what){
    return bot('GetMe',[])->result->$what;}
function SaniTize($value){
    $level1 = trim($value);
    $level2 = strip_tags($level1);
    return $level2;
}
//======================================================================
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$from_id = $message->from->id;
$text = $message->text;
$first_name = $message->from->first_name;
$last_name = $message->from->last_name;
$username = $message->from->username;
$tc = $update->message->chat->type;
$data = $update->callback_query->data;
$messageid = $update->callback_query->message->message_id;
$chatid = $update->callback_query->message->chat->id;
$fromid = $update->callback_query->from->id;
$textt = $update->callback_query->message->text;
$inline = $update->inline_query->query;
$inline_message_id = $update->callback_query->inline_message_id;
$new_chat_member_id = $update->message->new_chat_member->id;
$new_chat_member_username = $update->message->new_chat_member->username;
$rpto = $update->message->reply_to_message->forward_from->id;
@mkdir('data');
@mkdir('data/users');
@mkdir('photo');
@mkdir("data/$from_id");
//======================================================================
$menu = json_encode(['keyboard'=>[
[['text'=>"⚡استخراج متن از عکس⚡"]],
[['text'=>"🎛دیگر ربات های ما🎛"]],
], 'resize_keyboard' => true]);
//======================================================================            
$tik = json_encode(['inline_keyboard'=>[
[['text'=>'✅','callback_data'=>'llBots']]
],'resize_keyboard'=>true,]);
//======================================================================            
$back = json_encode(['keyboard' => [
    [['text' => "🔙بازگشت"]],
], 'resize_keyboard' => true]);
//======================================================================
$admins = array("991986395","991986395","991986395"); // ایدی عددی مدیران
$botusername = "ExtractTextFromPhotosBot"; // ایدی ربات بدون @
$channel = "llBots"; // ایدی چنل بدون @
//======================================================================
$bugun = date('d-M Y',strtotime('3 hour'));
$name_bot = Botinfo('first_name');
$forchaneel = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@$channel&user_id=".$chat_id));
$user = json_decode(file_get_contents("data/users/$from_id.json"),true);
$stats_n = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=$chat_id&user_id=".$from_id),true);
$statjsonq = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=$chatid&user_id=".$fromid),true);
$setp = $user['step']; // User STEP
$status_n = $stats_n['result']['status']; // STATS
$statusq = $statjsonq['result']['status']; // STATS
$tch = $forchaneel->result->status; // True Channel
$all_users = file_get_contents("data/allusers.txt");
if(isset($data)){
$fid = $update->callback_query->from->id;}
if(isset($message->from)){
$fid = $message->from->id;}
//━━//
function deletefolder($path){
 if($handle=opendir($path)){
  while (false!==($file=readdir($handle))){
   if($file<>"." AND $file<>".."){
    if(is_file($path.'/'.$file)){ 
     @unlink($path.'/'.$file); } 
    if(is_dir($path.'/'.$file)) { 
     deletefolder($path.'/'.$file); 
     @rmdir($path.'/'.$file); }} } }}
function step($from_id,$step){
$user = json_decode(file_get_contents("data/users/$from_id.json"),true);
$user["step"] = "$step";
$outjson = json_encode($user,true);
file_put_contents("data/users/$from_id.json",$outjson);
return true;
}
//======================================================================
if($tc == "private" ){
$all_users2 = explode("\n",$all_users); 
if(!in_array($chat_id,$all_users2)){
$tctctct = fopen("data/allusers.txt", "a") or die("Unable to open file!");
fwrite($tctctct, "$chat_id\n");
fclose($tctctct);}}
$user_flood = file_get_contents("data/spam/$fid.txt");
if($user_flood < time()){ 
$spamtime = 0.09; // تایم اسپم پشت سرهم
$tt = time() + $spamtime;
file_put_contents("data/spam/$fid.txt",$tt);
}
//======================================================================
if($text == "/start"){
step($chat_id,"none");
if($tch != 'member' && $tch != 'creator' && $tch != 'administrator' ){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"❗️کاربر گرامی برای استفاده از ربات و حمایت از ما ابتدا در چنل زیر عضو شوید و سپس /start را ارسال کنید!",
 'reply_markup' => json_encode([
 'inline_keyboard' => [
    [['text' => "🛎️ عضویت در کانال️", 'url' => "https://t.me/$channel"]],
]])
]);
}else{
step($chat_id,"none");
 bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"🌹 سلام خوش آمدید\n\nبا این ربات میتونید متن رو از عکس استخراج کنید.(به ۲۵ زبان دنیا)\n\n@$channel\n@$botusername"
 ,'reply_markup'=> $menu
]);  
}}
//===============================================================
if($text == "🔙بازگشت"){
step($chat_id,"none");
bot('sendmessage',[
'chat_id'=>$from_id, 
'text'=> "به منوی اصلی برگشتیم\n\n@$channel\n@$botusername" ,'reply_markup'=> $menu
]);
}
//===============================================================
if($text == "⚡استخراج متن از عکس⚡"){
step($chat_id,"ocr");
bot('sendmessage',[
'chat_id'=>$from_id, 
'text'=> "♻️ لطفا زبان مورد نظر خود را انتخاب کنید ♻️\n\n@$channel\n@$botusername" ,'reply_markup'=> $lng
]);
}
//===============================================================
if(in_array($data,array('Persian','Bulgarian','Croatian','Dutch','German','Italian','Slovenian','Polish','Swedish',English,ChineseSimplified,Czech,Finnish,Greek,Japanese,Spanish,Portuguese,Turkish,Arabic,ChineseTraditional,Danish,French,Hungarian,Korean,Russian))){
$lang = str_replace(['Persian','Bulgarian','Croatian','Dutch','German','Italian','Slovenian','Polish','Swedish',English,ChineseSimplified,Czech,Finnish,Greek,Japanese,Spanish,Portuguese,Turkish,Arabic,ChineseTraditional,Danish,French,Hungarian,Korean,Russian],['Persian','Bulgarian','Croatian','Dutch','German','Italian','Slovenian','Polish','Swedish',English,ChineseSimplified,Czech,Finnish,Greek,Japanese,Spanish,Portuguese,Turkish,Arabic,ChineseTraditional,Danish,French,Hungarian,Korean,Russian],$data);
file_put_contents("data/$fromid/lang.txt","$lang");
bot('editMessagetext',[
 'chat_id'=>$chatid,
'message_id'=>$messageid,
'text'=> "♻️ تصویر مورد نظر خود را جهت استخراج متن ارسال کنید ♻️\n\n@$channel\n@$botusername" ,
'parse_mode'=>"MarkDown",
'reply_markup'=> $tik
]);
}
if($user['step']=='ocr'){
if(isset($message->photo)){
$photo = $message->photo; 
$file = $photo[count($photo)-1]->file_id; 
$get = bot('getfile',['file_id'=>$file])->result->file_path; 
$im = imagecreatefromjpeg("https://api.telegram.org/file/bot" . API_KEY . "/$get"); 
imagepng($im , "photo/$from_id.jpg");
bot('sendmessage',[
'chat_id'=>$from_id, 
'text'=> "♻️ صبور باشید ♻️\n\n@$channel\n@$botusername",
'reply_markup'=> $back
]);
step($chat_id,"none");
}}
//--------------------------------------------------------------------//
if($data == "llBots" ){
bot('answercallbackquery', [
'callback_query_id' => $update->callback_query->id,
'text'=>"دیگر ربات های ما\n@$channel",
'show_alert' => true
]);}
if($text == '👤پشتیبانی👤'){
  bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"جهت وجود مشکل یا هرگونه سوال به آیدی زیر مراجعه کنید\n@Fake_GG"
]);}
if($text == '🎛دیگر ربات های ما🎛'){
  bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"دیگر ربات های ما\n@$channel"
]);}
//--------------------------------------------------------------------//
//==============================  panel   ============================
if($text == "/panel"){
if($tc == "private" ){
if(in_array($chat_id,$admins)){
step($chat_id,"none");
 bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"💒 به پنل مدیریتی ربات خوش آمدید.",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
 'inline_keyboard'=>[
                  [['text'=>"🪄 پاکسازی لیست کاربران",'callback_data'=>'delusers']],
 [['text'=>"📊 آمار کلی",'callback_data'=>'stats']],
 [['text'=>"❓ بلاک شخص",'callback_data'=>'black'],['text'=>"❔ آنبلاک شخص",'callback_data'=>'unblack']],
[['text'=>"📨 فوروارد به کاربران",'callback_data'=>'foruser']],
[['text'=>"🗳 ارسال به کاربران",'callback_data'=>'senduser']],
]])
]); 
}}}
//======================================================================
if($data == "stats" ){
$ex1 = explode("n",$all_users);
$ex2 = explode("\n",$all_gaps);
$c1 = count($ex1)-1;
$c2 = count($ex2)-1;
$document = 'data/kalamat';
$scan = scandir($document);
$scan = array_diff($scan, ['.','..']);
$fil = count($scan);
$ca = count($admins);
bot('answercallbackquery', [
        'callback_query_id' => $update->callback_query->id,
 'text'=>"📊 آمار ربات شما:

🚻 کاربران: $c1
🛃 ادمین ها: $ca",
 'show_alert' => true
]);}
//======================================================================
if($data == "back_p" ){
step($chatid,"none");
bot('editMessagetext',[
 'chat_id'=>$chatid,
'message_id'=>$messageid,
 'text'=>"💒 به منوی اصلی پنل مدیریت بازگشتید!",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
 'inline_keyboard'=>[
                  [['text'=>"🪄 پاکسازی لیست کاربران",'callback_data'=>'delusers']],
 [['text'=>"📊 آمار کلی",'callback_data'=>'stats']],
 [['text'=>"❓ بلاک شخص",'callback_data'=>'black'],['text'=>"❔ آنبلاک شخص",'callback_data'=>'unblack']],
[['text'=>"📨 فوروارد به کاربران",'callback_data'=>'foruser']],
[['text'=>"🗳 ارسال به کاربران",'callback_data'=>'senduser']],
]])
]);  }
//======================================================================
if($data == "delusers"){
deletefolder("data/users");
bot('answercallbackquery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "🗑️ لیست کاربران پاکسازی شد!",
        'show_alert' => true
    ]);}
//======================================================================
if($data == "senduser" ){
step($chatid,"senduser");
bot('editMessagetext',[
 'chat_id'=>$chatid,
'message_id'=>$messageid,
 'text'=>"📥 پیام را ارسال کنید:",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                  [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ]
        ]) ]); }
//======================================================================
	elseif($user['step'] == "senduser"  && $tc == "private"){
	if($tc == "private" && in_array($chat_id,$admins)){
	step($chat_id,"none");
	 bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"📳 در حال انجام، لطفا صبر کنید ...",
 'parse_mode'=>"MarkDown",
	 ]); 
     $ex = explode("\n",$all_users);
      foreach($ex as $key){
  bot('sendMessage',[
 'chat_id'=>$key,
 'text'=>$text,
   'disable_web_page_preview'=>true,
	]);}
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"📑 پیام به همه کاربران ارسال شد!",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                  [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ]  ]) ]);  } }
//======================================================================
if($data == "foruser" ){
step($chatid,"foruser");
bot('editMessagetext',[
 'chat_id'=>$chatid,
'message_id'=>$messageid,
 'text'=>"📥 پیام را فوروارد کنید:",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                  [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ] ]) ]); }
//======================================================================
elseif($user['step'] == "foruser"  && $tc == "private"){
if($tc == "private" && in_array($chat_id,$admins)){
step($chat_id,"none");
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"📳 در حال انجام، لطفا صبر کنید ...",
 'parse_mode'=>"MarkDown", ]); 
   $ex = explode("\n",$all_users);
   foreach($ex as $key){
   bot('ForwardMessage',[
'chat_id'=>$key,
'from_chat_id'=>$chat_id,
'message_id'=>$message_id
]);}
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"📑 پیام به همه کاربران فوروارد شد!",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
    [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ] ]) ]);  } }
//======================================================================
if($data == "unblack" ){
step($chatid,"unblack");
bot('editMessagetext',[
 'chat_id'=>$chatid,
'message_id'=>$messageid,
 'text'=>"🎓 شناسه کاربر را ارسال کنید:",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                  [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ]
        ]) ]); }
//======================================================================
elseif($user['step'] == "unblack"  && $tc == "private"){
if($tc == "private" && in_array($chat_id,$admins)){
$tt = time();
file_put_contents("data/spam/$text.txt",$tt);
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"🗑️ کاربر از بلاک لیست خارج شد!",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                  [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ]
        ]) ]); 
 bot('sendMessage',[
 'chat_id'=>$text,
 'text'=>"♥️ شما توسط میدیرت از لیست بلاک خارج شدید!",
 'parse_mode'=>"MarkDown",
	 ]);  } }  
//======================================================================
if($data == "black" ){
step($chatid,"black");
bot('editMessagetext',[
 'chat_id'=>$chatid,
'message_id'=>$messageid,
 'text'=>"🎓 شناسه کاربر را ارسال کنید:",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                  [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ]
       ]) ]); }
//======================================================================
elseif($user['step'] == "black"  && $tc == "private"){
if($tc == "private" && in_array($chat_id,$admins)){
$tt = time() + 9999999999999999999;
file_put_contents("data/spam/$text.txt",$tt);
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"🛡️ کاربر از ربات بلاک شد!",
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                  [['text'=>"🏛 منوی اصلی️",'callback_data'=>'back_p']],
              ]
       ]) ]); 
 bot('sendMessage',[
 'chat_id'=>$text,
 'text'=>"💬 شما توسط مدیریت از ربات مسدود شدید!",
 'parse_mode'=>"MarkDown",
 ]);  } }
?>
