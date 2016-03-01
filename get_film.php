<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("get_film_data.php");
	function get_film_lecteur_and_infos($line)
	{
		$i = 0;
		$link = NULL;
		$l_i = 0;
		while ($line[$i] != NULL)
		{
			if ($line[$i] == "h" && $line[($i + 1)] == "r" && $line[($i + 2)] == "e" && $line[($i + 3)] == "f")
			break ;
			$i++;
		}
		$i += 6;
		while ($line[$i] != NULL && $line[$i] != "\"")
		{
			$link = ''.$link.''.$line[$i].'';
			$l_i++;
			$i++;
		}
		get_film_data('http://www.dpstream.net/'.$link.'');
	}

	function get_film($link)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch); 
		curl_close($ch);
		$line = NULL;
		$var = 0;
		$index = 0;
		$lector = 0;
		while ($output[$var] != NULL)
		{
			if (!strcmp($output[$var], "\n"))
			{
				if (strpos($line, "<a class=\"b\" href=\"") && $line[(strlen($line) -2)] == "d")
				{
					get_film_lecteur_and_infos($line);
					$lector = 1;
					break ;
				}
				$index = 0;
				$line = NULL;
			}
			else
			{
				$line = ''.$line.''.$output[$var].'';
				$index++;
			}
			$var++;
		}
		if (!$lector)
			get_film_data($link);
	}
?>