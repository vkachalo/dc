<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=win-1251">

</head>
<body>
<?php
	$url = 'https://api.dclink.com.ua/api/GetCategories';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array ('login' => 'L_gerasimoff(КПД)', 'password' => 'w5v6C2E2r1', 'доппараметр' => ''));
	curl_setopt($ch, CURLOPT_URL, $url);
	$output = curl_exec($ch);
	curl_close($ch);

	print_r($output);
	

?>
</body>
</html>