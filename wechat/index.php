<?php
/*
    方倍工作室 http://www.fangbei.org/
    CopyRight 2016 All Rights Reserved
*/
header('Content-type:text');

define("TOKEN", "lyt123");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
} else {
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    //验证签名
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)) {
            $this->logger("R \r\n" . $postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            //消息类型分离
            switch ($RX_TYPE) {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                case "shortvideo":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: " . $RX_TYPE;
                    break;
            }
            $this->logger("T \r\n" . $result);
            echo $result;
        } else {
            echo "";
            exit;
        }
    }

    //接收事件消息
    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event) {
            case "subscribe":
                $content = "欢迎关注方倍工作室 \n请回复以下关键字：文本 表情 单图文 多图文 图文1 图文2 图文3 图文4 图文5 音乐\n请按住说话 或 点击 + 再分别发送以下内容：语音 图片 小视频 我的收藏 位置";
                if (!empty($object->EventKey)) {
                    $content .= "\n来自二维码场景 " . str_replace("qrscene_", "", $object->EventKey);
                }
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "CLICK":
                switch ($object->EventKey) {
                    case "COMPANY":
                        $content = array();
                        $content[] = array("Title" => "方倍工作室", "Description" => "", "PicUrl" => "http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" => "http://m.cnblogs.com/?u=txw1958");
                        break;
                    default:
                        $content = "点击菜单：" . $object->EventKey;
                        break;
                }
                break;
            case "VIEW":
                $content = "跳转链接 " . $object->EventKey;
                break;
            case "SCAN":
                $content = "扫描场景 " . $object->EventKey;
                break;
            case "LOCATION":
                $content = "上传位置：纬度 " . $object->Latitude . ";经度 " . $object->Longitude;
                break;
            case "scancode_waitmsg":
                if ($object->ScanCodeInfo->ScanType == "qrcode") {
                    $content = "扫码带提示：类型 二维码 结果：" . $object->ScanCodeInfo->ScanResult;
                } else if ($object->ScanCodeInfo->ScanType == "barcode") {
                    $codeinfo = explode(",", strval($object->ScanCodeInfo->ScanResult));
                    $codeValue = $codeinfo[1];
                    $content = "扫码带提示：类型 条形码 结果：" . $codeValue;
                } else {
                    $content = "扫码带提示：类型 " . $object->ScanCodeInfo->ScanType . " 结果：" . $object->ScanCodeInfo->ScanResult;
                }
                break;
            case "scancode_push":
                $content = "扫码推事件";
                break;
            case "pic_sysphoto":
                $content = "系统拍照";
                break;
            case "pic_weixin":
                $content = "相册发图：数量 " . $object->SendPicsInfo->Count;
                break;
            case "pic_photo_or_album":
                $content = "拍照或者相册：数量 " . $object->SendPicsInfo->Count;
                break;
            case "location_select":
                $content = "发送位置：标签 " . $object->SendLocationInfo->Label;
                break;
            case "ShakearoundUserShake":
                $content = "摇一摇\nUuid：" . $object->ChosenBeacon->Uuid .
                    "\nMajor：" . $object->ChosenBeacon->Major .
                    "\nMinor：" . $object->ChosenBeacon->Minor .
                    "\nDistance：" . $object->ChosenBeacon->Distance .
                    "\nRssi：" . $object->ChosenBeacon->Rssi .
                    "\nMeasurePower：" . $object->ChosenBeacon->MeasurePower .
                    "\nChosenPageId：" . $object->ChosenBeacon->ChosenPageId;
                break;
            default:
                $content = "receive a new event: " . $object->Event;
                break;
        }

        if (is_array($content)) {
            $result = $this->transmitNews($object, $content);
        } else {
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        //多客服人工回复模式
        if (strstr($keyword, "请问在吗") || strstr($keyword, "在线客服")) {
            $result = $this->transmitService($object);
            return $result;
        }

        //自动回复模式
        if (strstr($keyword, "文本")) {
            $content = "这是个文本消息";
        } else if (strstr($keyword, "表情")) {
            $content = "微笑：/::)\n乒乓：/:oo\n太阳：☀\n仙人掌：🌵\n玉米：🌽\n蘑菇：🍄\n皇冠：👑";
        } else if (strstr($keyword, "链接")) {
            $content = "电话号码：0755-87654321\n\n电子邮件：12345@qq.com\n\n公司网址：<a href='http://xw.qq.com/index.htm'>腾讯网</a>";
        } else if (strstr($keyword, "单图文") || strstr($keyword, "图文1")) {
            $content = array();
            $content[] = array("Title" => "单图文标题", "Description" => "单图文内容", "PicUrl" => "http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" => "http://m.cnblogs.com/?u=txw1958");
        } else if (strstr($keyword, "多图文") || strstr($keyword, "图文2")) {
            $content = array();
            $content[] = array("Title" => "多图文1标题", "Description" => "", "PicUrl" => "http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" => "http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title" => "多图文2标题", "Description" => "", "PicUrl" => "http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" => "http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title" => "多图文3标题", "Description" => "", "PicUrl" => "http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" => "http://m.cnblogs.com/?u=txw1958");
        } else if (strstr($keyword, "图文3") || strstr($keyword, "空气")) {
            $content = array();
            $content[] = array("Title" => "深圳空气质量",
                "Description" => "空气质量指数(AQI)：32\n" .
                    "空气质量等级：优\n" .
                    "细颗粒物(PM2.5)：12\n" .
                    "可吸入颗粒物(PM10)：31\n" .
                    "一氧化碳(CO)：0.9\n" .
                    "二氧化氮(NO2)：31\n" .
                    "二氧化硫(SO2)：5\n" .
                    "臭氧(O3)：20\n" .
                    "更新时间： 2014-06-30",
                "PicUrl" => "",
                "Url" => "");
        } else if (strstr($keyword, "图文4" || strstr($keyword, "教程"))) {
            $content = array();
            $content[] = array("Title" => "微信公众平台开发教程", "Description" => "", "PicUrl" => "", "Url" => "");
            $content[] = array("Title" => "【基础入门】免费\n1. 申请服务器资源\n2. 启用开发模式\n3. 消息类型详解\n4. 获取接收消息\n5. 回复不同消息", "Description" => "", "PicUrl" => "http://e.hiphotos.bdimg.com/wisegame/pic/item/9e1f4134970a304e1e398c62d1c8a786c9175c0a.jpg", "Url" => "http://m.cnblogs.com/99079/3153567.html?full=1");
            $content[] = array("Title" => "【初级教程】双11六折促销\n1.小黄鸡机器人\n2.英语类公众账号开发", "Description" => "", "PicUrl" => "http://g.hiphotos.bdimg.com/wisegame/pic/item/3166d0160924ab186196512537fae6cd7b890b24.jpg", "Url" => "http://israel.duapp.com/taobao/index.php?id=1");
        } else if (strstr($keyword, "图文5") || strstr($keyword, "关注")) {
            $content[] = array("Title" => "欢迎关注方倍工作室", "Description" => "", "PicUrl" => "", "Url" => "");
            $content[] = array("Title" => "【1】新闻 天气 空气 股票 彩票 星座\n" .
                "【2】快递 人品 算命 解梦 附近 苹果\n" .
                "【3】公交 火车 汽车 航班 路况 违章\n" .
                "【4】翻译 百科 双语 听力 成语 历史\n" .
                "【5】团购 充值 菜谱 贺卡 景点 冬吴\n" .
                "【6】情侣相 夫妻相 亲子相 女人味\n" .
                "【7】相册 游戏 笑话 答题 点歌 树洞\n" .
                "【8】微社区 四六级 华强北 世界杯\n\n" .
                "更多精彩，即将亮相，敬请期待！", "Description" => "", "PicUrl" => "", "Url" => "");
            $content[] = array("Title" => "回复对应数字查看使用方法\n发送 0 返回本菜单", "Description" => "", "PicUrl" => "", "Url" => "");
        } else if (strstr($keyword, "常用") || strstr($keyword, "常用链接")) {
            $content[] = array("Title" => "欢迎关注方倍工作室", "Description" => "", "PicUrl" => "", "Url" => "");
            $content[] = array("Title" => "违章查询", "Description" => "", "PicUrl" => "http://pic25.nipic.com/20121107/7185356_171642579104_2.jpg", "Url" => "http://app.eclicks.cn/violation2/webapp/index?appid=10");
            $content[] = array("Title" => "公交查询", "Description" => "", "PicUrl" => "http://g.hiphotos.bdimg.com/wisegame/pic/item/91d3572c11dfa9ec144e43be6bd0f703918fc133.jpg", "Url" => "http://map.baidu.com/mobile/webapp/third/transit/");
            $content[] = array("Title" => "黄历查询", "Description" => "", "PicUrl" => "http://f.hiphotos.bdimg.com/wisegame/pic/item/3aee3d6d55fbb2fb8e689396464a20a44723dcf0.jpg", "Url" => "http://baidu365.duapp.com/uc/Calendar.html");
            $content[] = array("Title" => "常用电话", "Description" => "", "PicUrl" => "http://f.hiphotos.bdimg.com/wisegame/pic/item/15094b36acaf2edd4eed636a841001e939019311.jpg", "Url" => "http://m.hao123.com/n/v/dianhua");
            $content[] = array("Title" => "四六级查分", "Description" => "", "PicUrl" => "http://f.hiphotos.bdimg.com/wisegame/pic/item/c70f4bfbfbedab6476d56388f536afc378311ed6.jpg", "Url" => "http://cet.fangbei.org/index.php");
            $content[] = array("Title" => "实时路况", "Description" => "", "PicUrl" => "http://e.hiphotos.bdimg.com/wisegame/pic/item/e18ba61ea8d3fd1f754c8276384e251f95ca5f30.jpg", "Url" => "http://map.baidu.com/mobile/webapp/third/traffic/foo=bar/traffic=on");

        } else if (strstr($keyword, "音乐")) {
            $content = array();
            $content = array("Title" => "最炫民族风", "Description" => "歌手：凤凰传奇", "MusicUrl" => "http://mascot-music.stor.sinaapp.com/zxmzf.mp3", "HQMusicUrl" => "http://mascot-music.stor.sinaapp.com/zxmzf.mp3");
        } else {
            $content = date("Y-m-d H:i:s", time()) . "\n技术支持 方倍工作室";
            // $content = "";
        }

        if (is_array($content)) {
            if (isset($content[0])) {
                $result = $this->transmitNews($object, $content);
            } else if (isset($content['MusicUrl'])) {
                $result = $this->transmitMusic($object, $content);
            }
        } else {
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收图片消息
    private function receiveImage($object)
    {

        include("faceplusplus.php");
        $imgurl = strval($object->PicUrl);
        $content = getFaceValue($imgurl);
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，经度为：" . $object->Location_Y . "；纬度为：" . $object->Location_X . "；缩放级别为：" . $object->Scale . "；位置为：" . $object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)) {
            $content = "你刚才说的是：" . $object->Recognition;
            $result = $this->transmitText($object, $content);
        } else {
            $content = array("MediaId" => $object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }
        return $result;
    }

    //接收视频消息
    private function receiveVideo($object)
    {
        $content = array("MediaId" => $object->MediaId, "ThumbMediaId" => $object->ThumbMediaId, "Title" => "", "Description" => "");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：" . $object->Title . "；内容为：" . $object->Description . "；链接地址为：" . $object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)) {
            return "";
        }

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if (!is_array($newsArray)) {
            return "";
        }
        $itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item) {
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        $item_str    </Articles>
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        if (!is_array($musicArray)) {
            return "";
        }
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
    </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //日志记录
    private function logger($log_content)
    {
        if (isset($_SERVER['HTTP_APPNAME'])) {   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        } else if ($_SERVER['REMOTE_ADDR'] != "127.0.0.1") { //LOCAL
            $max_size = 1000000;
            $log_filename = "log.xml";
            if (file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)) {
                unlink($log_filename);
            }
            file_put_contents($log_filename, date('Y-m-d H:i:s') . " " . $log_content . "\r\n", FILE_APPEND);
        }
    }
}

?>