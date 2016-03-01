<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("get_film.php");
require_once("config.php");
function handle_line_and_send_link($line)
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
	echo "\e[3;32m";
	echo "\nNEW FILM FOUND";
	echo "\e[0;37m";
	echo "\n______________\n\n";
	echo 'FILM PRINCIPAL LINK : ';
	echo "\e[0;34m";
	echo 'http://www.dpstream.net/'.$link.'';
	echo "\n";
	get_film('http://www.dpstream.net/'.$link.'');
}
	$page = 1;
	while ($page <= 190)
	{
		echo "\n";
		echo "\e[0;31m";
		echo 'NEW PAGE FOUND : '.$page.'';
		echo "\n";

		$url = 'http://www.dpstream.net/fichiers/includes/inc_liste_film/fonction_liste_film2.php?p=0-0-'.$page.'-0-0-0-0-0-0-0';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch); 
		curl_close($ch);
		$line = NULL;
		$var = 0;
		$index = 0;
		while ($output[$var] != NULL)
		{
			if (!strcmp($output[$var], "\n"))
			{
				if (strpos($line, "class=\"lienfilm\""))
				{
					handle_line_and_send_link($line);
					//break ;
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
		$page++;
	}
?>