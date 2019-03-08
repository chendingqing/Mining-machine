<?php

namespace Weixin\Controller;
use Think\Controller;
class BasisController extends Controller {
	public function _initialize() {
		header ( "Content-type: text/html; charset=utf-8" );
		//$useragent = $_SERVER ['HTTP_USER_AGENT'];
		///if (strpos ( $useragent, 'MicroMessenger' ) === false) {
			//echo " 非微信浏览器禁止访问";
		//}
		//if ($_GET ['debug']) {
		//} else {
			//$agent = $_SERVER ['HTTP_USER_AGENT'];
			//if (! strpos ( $agent, "icroMessenger" )) {
				//echo '请使用微信访问';
				//exit ();
			//}
		//}
		$ptname=M('wxconfig')->field('num')->find();
		$this->assign('ptname',$ptname);
	}
	public function sock_post($url, $query) {
		$data = '';
		$info = parse_url ( $url );
		$fp = fsockopen ( $info ['host'], 80, $errno, $errstr, 30 );
		if (! $fp) {
			return $data;
		}
		$head = 'POST ' . $info ['path'] . ' HTTP/1.0' . "\r\n" . '';
		$head .= 'Host: ' . $info ['host'] . "\r\n";
		$head .= 'Referer: http://' . $info ['host'] . $info ['path'] . "\r\n";
		$head .= 'Content-type: application/x-www-form-urlencoded' . "\r\n" . '';
		$head .= 'Content-Length: ' . strlen ( trim ( $query ) ) . "\r\n";
		$head .= "\r\n";
		$head .= trim ( $query );
		$write = fputs ( $fp, $head );
		$header = '';
		while ( $str = trim ( fgets ( $fp, 4096 ))) {
			$header .= $str;
		}
		while ( ! feof ( $fp ) ) {
			$data .= fgets ( $fp, 4096 );
		}
		return $data;
	}
	
	
}