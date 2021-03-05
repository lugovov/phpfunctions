<?php 

# Clone from from https://github.com/Saleh7/TelegramBot

class Telegram{
    /**
     * Token API telegram
     * @example https://core.telegram.org/bots/api
     */ 
    private $TokenAPI;
    private $API_URL = 'https://api.telegram.org/bot';
    
    function __construct($TokenAPI){
        $this->TokenApi = $TokenAPI; 
    }
    
    /**
     * @param string url proxyurl
     */
    public function setProxy($url){
        $this->API_URL = $url;
    }
    /**
     * @example (getMe,array_Parameters)
     */
    protected function Request($Method, array $Parameters = []){
        //Code
        $resource = curl_init($this->API_URL.$TOkenAPI.'/'.$Method);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_CONNECTTIMEOUT => 600,
            CURLOPT_SSL_VERIFYPEER => false );
        //SendApiBot ....
        if (!is_null($Parameters)) {
            $options[CURLOPT_POSTFIELDS] = http_build_query($Parameters); 
        }
        curl_setopt_array($resource, $options);
        $GetBody = curl_exec($resource);
        curl_close($resource);
        $ResultJson = json_decode($GetBody,true);
        return $ResultJson;
        
    }

    /**
     * @example (getMe,array_Parameters)
     */
    protected function RequestFile($Method, array $Parameters = []){
        //TODO
    }

    /**
     * @param integer|null offset
     * @param integer|null limit | Defaults to 100
     * @param integer|null timeout
     * @telegram https://core.telegram.org/bots/api#getupdates
     */
    public function GetUpdates($offset = null, $limit = null, $timeout = null)
    {
        $data=[];
        $data['offset'] = $offset;
        $data['limit'] = $limit;
        $data['timeout'] = $timeout;
        return $this->Request("getUpdates", $data);
    }
    /**
     * @param string    url
     * @param InputFile certificate
     * @telegram https://core.telegram.org/bots/api#setwebhook
     */
    public function SetWebhook($url = null, $certificate = null)
    {
        $data=[];
        $data['url'] = $url;
        $data['certificate'] = $certificate;
        return $this->Request("setWebhook", $data);
    }
    /**
     * @param string getMe
     *  A simple method for testing your bot's auth token.
     *  Requires no parameters. Returns basic information about the bot in form of a User object.
     * @telegram https://core.telegram.org/bots/api#getme
     */
    public function getMe(){
        return $this->Request('getMe');
    }
    /**
     * @param integer  chat_id
     * @param string   text
     * @param array    data other options
     * @telegram https://core.telegram.org/bots/api#sendmessage
     * Optional. For text messages, the actual UTF-8 text of the message
     */
    public function SendMessage($chat_id, $text, $data=[]){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["text"]= $text;
        return $this->Request("sendMessage", $data);
    }
    /**
     * @param integer chat_id
     * @param integer from_chat_id
     * @param integer message_id
     * @tutorial https://core.telegram.org/bots/api#forwardmessage
     */
    public function ForwardMessage($chat_id, $from_chat_id, $message_id){
        $data=[];
        $data["chat_id"] = $chat_id;
        $data["from_chat_id"] = $from_chat_id;
        $data["message_id"] = $message_id;
        
        return $this->Request("forwardMessage", $data);
    }
    /**
     * @param integer      chat_id
     * @param string       photo | or InputFile
     * @param string|null  caption 
     * @param array    data other options
     * @telegram https://core.telegram.org/bots/api#sendphoto
     * Use this method to send photos. On success, the sent Message is returned.
     */
    public function SendPhoto($chat_id, $photo, $caption = null, $data=[]){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["photo"]= $photo;
        $data["caption"] = $caption;
        $data["reply_to_message_id"] = $reply_to_message_id;
        $data["reply_markup"] = $reply_markup;
        return $this->Request("sendPhoto", $data);
    }
    /**
     * @param integer      chat_id
     * @param string       audio | or InputFile
     * @param array    data other options
     * @telegram https://core.telegram.org/bots/api#sendaudio
     * can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     */
    public function SendAudio($chat_id, $audio, $data=[]){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["audio"]= $audio;
        $data["duration"] = $duration;
        $data["performer"] = $performer;
        $data["title"] = $title;
        $data["reply_to_message_id"] = $reply_to_message_id;
        $data["reply_markup"] = $reply_markup;
        return $this->RequestFile("sendAudio", $data);
    }
   /**
     * @param integer      chat_id
     * @param string       document | or InputFile
     * @param integer|null reply_to_message_id
     * @param null         reply_markup
     * @telegram https://core.telegram.org/bots/api#senddocument
     * can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     */
    public function SendDocument($chat_id, $document, $reply_to_message_id = null, $reply_markup = null){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["document"]= $document;
        $data["reply_to_message_id"] = $reply_to_message_id;
        $data["reply_markup"] = $reply_markup;
        return $this->RequestFile("sendDocument", $data);
    }
    /**
     * @param integer      chat_id
     * @param string       sticker | or InputFile
     * @param integer|null reply_to_message_id
     * @param null         reply_markup
     * @telegram https://core.telegram.org/bots/api#sendsticker
     * Use this method to send .webp stickers. On success, the sent Message is returned.
     */
    public function SendSticker($chat_id, $sticker, $reply_to_message_id = null, $reply_markup = null){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["sticker"]= $sticker;
        $data["reply_to_message_id"] = $reply_to_message_id;
        $data["reply_markup"] = $reply_markup;
        return $this->RequestFile("sendSticker", $data);
    }
    /**
     * @param integer      chat_id
     * @param string       video | or InputFile
     * @param integer|null duration 
     * @param string|null  caption
     * @param integer|null reply_to_message_id
     * @param null         reply_markup
     * @telegram https://core.telegram.org/bots/api#sendvideo
     * can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     */
    public function SendVideo($chat_id, $video, $duration = null, $caption = null, $reply_to_message_id = null, $reply_markup = null){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["video"]= $video;
        $data["duration"] = $duration;
        $data["caption"] = $caption;
        $data["reply_to_message_id"] = $reply_to_message_id;
        $data["reply_markup"] = $reply_markup;
        return $this->RequestFile("sendVideo", $data);
    }
    /**
     * @param integer      chat_id
     * @param string       voice | or InputFile
     * @param integer|null duration 
     * @param string|null  caption
     * @param integer|null reply_to_message_id
     * @param null         reply_markup
     * @telegram https://core.telegram.org/bots/api#sendvoice
     * can currently send voice files of up to 50 MB in size, this limit may be changed in the future.
     */
    public function SendVoice($chat_id, $voice, $duration = null, $reply_to_message_id = null, $reply_markup = null){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["voice"]= $voice;
        $data["duration"] = $duration;
        $data["reply_to_message_id"] = $reply_to_message_id;
        $data["reply_markup"] = $reply_markup;
        return $this->RequestFile("sendVoice", $data);
    }
    /**
     * @param integer      chat_id
     * @param Float number latitude
     * @param Float number longitude
     * @param array         data other options
     * @telegram https://core.telegram.org/bots/api#sendlocation
     * Use this method to send point on the map. On success, the sent Message is returned.
     */
    public function SendLocation($chat_id, $latitude, $longitude, $data=[]){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["latitude"]= $latitude;
        $data["longitude"] = $longitude;
        $data["reply_to_message_id"] = $reply_to_message_id;
        $data["reply_markup"] = $reply_markup;
        return $this->Request("sendLocation", $data);
    }
    /**
     * @param integer      chat_id
     * @param string       action
     * @telegram https://core.telegram.org/bots/api#sendchataction
     * Use this method when you need to tell the user that something is happening on the bot's side. The status is set for 5 seconds or less
     */
    public function SendChatAction($chat_id, $action){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data["action"]= $action;
        return $this->Request("sendChatAction", $data);
    }
    /**
     * @param integer      chat_id
     * @param integer      offset
     * @param integer      limit
     * @telegram https://core.telegram.org/bots/api#getuserprofilephotos
     * Use this method when you need to tell the user that something is happening on the bot's side. The status is set for 5 seconds or less
     */
    public function GetUserPhotos($chat_id, $offset = null, $limit = null){
        $data=[];
        $data["chat_id"]= $chat_id;
        $data['offset'] = $offset;
        $data['limit'] = $limit;
        return $this->Request("getUserProfilePhotos", $data);
    }
    /**
     * @param integer      chat_id
     * @param integer      offset
     * @param integer      limit
     * @telegram https://core.telegram.org/bots/api#getfile
     * Use this method to get basic info about a file and prepare it for downloading.
     * https://api.telegram.org/file/bot<token>/<file_path>
     */
    public function GetFile($file_id){
        $data=[];
        $data["file_id"]= $file_id;
        return $this->Request("getFile", $data);
    }

}
