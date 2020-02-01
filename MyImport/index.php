<?php
	include('../config.php');
	global $link;
	$link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	if (!$link) {
	    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
	    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}

	echo "Соединение с MySQL установлено!" . PHP_EOL;
	echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL;
?>


<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=win-1251">
</head>1111
<body>
<?php

function get_categories()
{
	global $link;

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

	$catslist = new SimpleXMLElement($output);
	$index = 0;
	foreach ($catslist->Category as $category)
	{

		$query = 'SELECT * FROM oc_category WHERE category_id='.$category->CategoryID;
		echo $query.'<br>';
		if ($stmt = mysqli_prepare($link, $query))
		{/* Выполнить запрос */
	    mysqli_stmt_execute($stmt);
    	/* Сохранить результат */
	    mysqli_stmt_store_result($stmt);
	    echo mysqli_stmt_num_rows($stmt);

		if (mysqli_stmt_num_rows($stmt) == 0)
		{
			echo 'Inserting ID ['.$category->CategoryID.']<br>';
			$query = 'INSERT INTO oc_category VALUES ("'.$category->CategoryID.'", "", "'.$category->ParentID.'", 0, 1, 0, 1, "2020-01-01 00:00:00", "2020-01-01 00:00:00");';
			echo $query.'<br>';
			$stmt = mysqli_prepare($link, $query);
			mysqli_stmt_execute($stmt);

			$query = 'INSERT INTO oc_category_description VALUES ("'.$category->CategoryID.'", 1, "'.$category->CategoryName.'", "", "'.$category->CategoryName.'", "", "");';
			echo $query.'<br>';
			$stmt = mysqli_prepare($link, $query);
			mysqli_stmt_execute($stmt);
			// -------------Вставка еще одного языка
			$query = 'INSERT INTO oc_category_description VALUES ("'.$category->CategoryID.'", 2, "'.$category->CategoryName.'", "", "'.$category->CategoryName.'", "", "");';
			echo $query.'<br>';
			$stmt = mysqli_prepare($link, $query);
			mysqli_stmt_execute($stmt);

		}
	}



/*
		$mass[$index]['id'] = $category->CategoryID;
		$mass[$index]['name'] = $category->CategoryName;
		$mass[$index]['parent'] = $category->ParentID;

*/


		$index++;
	}
/*
	for ($i=0; $i<count($mass); $i++)
	{
		for ($j = $i; $j<count($mass); $j++)
		{
			if ($mass[$i]['parent'] == 0) {}
				else {
					if ($mass[$j]['parent'] == 0)
					{
						$temp['id'] = $mass[$i]['id'];
						$temp['name'] = $mass[$i]['name'];
						$temp['parent'] = $mass[$i]['parent'];

						$mass[$i]['id'] = $mass[$j]['id'];
						$mass[$i]['name'] = $mass[$j]['name'];
						$mass[$i]['parent'] = $mass[$j]['parent'];

						$mass[$j]['id'] = $temp['id'];
						$mass[$j]['name'] = $temp['name'];
						$mass[$j]['parent'] = $temp['parent'];
					}
				}
		}
	}
	
	for ($i=0; $i<count($mass); $i++)
	{
		

		if ($num_results == 0)
		{
			echo 'Insert id['.$mass[$i]['id'].'] ['.$mass[$i]['parent'].']<br>';
		} 

	}
*/
}	

function get_items($categoryid)
{
	$url = 'https://api.dclink.com.ua/api/GetPrice';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array ('login' => 'L_gerasimoff(КПД)', 'password' => 'w5v6C2E2r1', 'доппараметр' => ''));
	curl_setopt($ch, CURLOPT_URL, $url);
	$output = curl_exec($ch);
	curl_close($ch);

	echo $output;
}	
	
	get_categories();
	
?>
</body>
</html>