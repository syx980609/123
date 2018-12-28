<?php

define("TOKEN", "weixin");//自己定义的token 就是个通信的私钥

$wechatObj = new wechatCallbackapiTest();

$wechatObj->valid();

//$wechatObj->responseMsg();

class wechatCallbackapiTest

{

    public function valid()

    {

        $echoStr = $_GET["echostr"];

        if($this->checkSignature()){

            echo $echoStr;

            exit;

        }

    }

    public function responseMsg()

    {

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $fromUsername = $postObj->FromUserName;

            $toUsername = $postObj->ToUserName;

            $keyword = trim($postObj->Content);

            $time = time();

            $textTpl = "<xml>

            <ToUserName><![CDATA[%s]]></ToUserName>

            <FromUserName><![CDATA[%s]]></FromUserName>

            <CreateTime>%s</CreateTime>

            <MsgType><![CDATA[%s]]></MsgType>

            <Content><![CDATA[%s]]></Content>

            <FuncFlag>0<FuncFlag>

            </xml>";

            if(!empty( $keyword ))

            {

                $msgType = "text";

                $contentStr = '来了老弟';

                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);

                echo $resultStr;

            }else{

                echo '欢迎';

            }

        }else {

            echo '嗨皮';

            exit;

        }

    }

    private function checkSignature()

    {

        $signature = $_GET["signature"];

        $timestamp = $_GET["timestamp"];

        $nonce = $_GET["nonce"];

        $token =TOKEN;

        $tmpArr = array($token, $timestamp, $nonce);

        sort($tmpArr);

        $tmpStr = implode( $tmpArr );

        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){

            return true;

        }else{

            return false;

        }

    }

}

?>
