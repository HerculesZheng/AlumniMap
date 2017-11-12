<?php
	$third_session = $_POST['third_session'];	
	$js_code = $_POST['code'];
	$appId = '';
	$appSecret = '';
	
	$url = 'https://api.weixin.qq.com/sns/jscode2session?appid={$appId}&secret={$appSecret}&js_code={$js_code}&grant_type=authorization_code';
	
	if(empty($third_session) || !isset($_SESSION[{$third_session}])){
		$str = file_get_contents($url);
		$jsonRes = json_decode($str);
		
		if(empty($jsonRes->session_key)){
			// fail to get session_key
//			echo;
		}else{
			$time = time();
			$new_third_session = $time.(rand()*10000);
			$sessionData = array('openid'=>$jsonRes->openid,'session_key'=>$jsonRes->session_key,'time'=>time());
			
			// open session
			session_start();
			$_SESSION[{$new_third_session}] = $sessionData;
			echo $new_third_session;
		}
	}else{
		echo $_SESSION[{$third_session}]->openid;
	}
?>