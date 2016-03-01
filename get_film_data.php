<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
	function get_alias_name($data, $start)
	{
		$alias = NULL;
		$i = 0;
		while ($data[$start] != "\n" && $data[$start] != NULL && $data[$start] != "<")
		{
			$alias = ''.$alias.''.$data[$start].'';
			$start++;
			$i++;
		}
		return ($alias);
	}

	function get_after_x_characters($data, $start)
	{
		$i = 0;
		$new = NULL;
		while ($data[$start] != NULL)
		{
			$new = ''.$new.''.$data[$start].'';
			$start++;
		}
		return ($new);
	}

	function get_film_name($line)
	{
		$pos = 0;
		$new = NULL;
		// CACA
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		//CACA
		while ($line[$pos] != NULL && $line[$pos] != "<")
		{
			$new = ''.$new.''.$line[$pos].'';
			$pos++;
		}
		return ($new);
	}

	function get_film_summary($line)
	{
		$pos = 0;
		$new = NULL;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != "<")
		{
			$new = ''.$new.''.$line[$pos].'';
			$pos++;
		}
		return ($new);
	}

	function get_film_img($line)
	{
		$pos = 0;
		$new = NULL;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != '"')
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != '"')
		{
			$new = ''.$new.''.$line[$pos].'';
			$pos++;
		}
		return ($new);
	}

	function get_film_country($line)
	{
		$pos = 0;
		$new = NULL;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != '"')
		{
			$new = ''.$new.''.$line[$pos].'';
			$pos++;
		}
		return ($new);
	}

	function get_film_year($line)
	{
		$pos = 0;
		$new = NULL;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != '"')
		{
			$new = ''.$new.''.$line[$pos].'';
			$pos++;
		}
		return ($new);
	}

	function get_film_length($line)
	{
		$pos = 0;
		$new = NULL;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != '<')
		{
			$new = ''.$new.''.$line[$pos].'';
			$pos++;
		}
		return ($new);
	}

	function get_film_actors($line)
	{
		$all_actors = NULL;
		$i = 0;
		$tmp = NULL;
		$array = explode("<span itemprop=\"name\">", $line);
		foreach($array as $value)
		{
			if ($i)
			{
				$b = 0;
				while ($value[$b] != NULL && $value[$b] != '<')
				{
					$tmp = ''.$tmp.''.$value[$b].'';
					$b++;
				}
				if (!empty($array[$i + 1]))
				$tmp = ''.$tmp.',';
			}
			$i++;
		}
		return ($tmp);
	}

	function get_film_category($line)
	{
		$pos = 0;
		$new = NULL;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != ">")
			$pos++;
		$pos++;
		while ($line[$pos] != NULL && $line[$pos] != '<')
		{
			$new = ''.$new.''.$line[$pos].'';
			$pos++;
		}
		return ($new);
	}

	function get_film_lector($line)
	{
		$new = NULL;
		$pos = 0;
		$array = explode("<iframe src=", $line);
		$clean = get_after_x_characters($array[1], 1);
		while ($clean[$pos] != NULL && $clean[$pos] != '"')
		{
			$new = ''.$new.''.$clean[$pos].'';
			$pos++;
		}
		if (!strpos($new, "type=film&synopsis"))
			return ($new);
	}

	function get_film_data($link)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_HTTPHEADER , array(
     'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
));
		$output = utf8_encode(curl_exec($ch)); 
		curl_close($ch);
		$line = NULL;
		$film_name_alias = NULL;
		$film_name = NULL;
		$film_summary = NULL;
		$film_img = NULL;
		$film_country = NULL;
		$film_year = NULL;
		$film_length = NULL;
		$film_actors = NULL;
		$film_category = NULL;
		$line = NULL;
		$film_lector = NULL;
		$var = 0;
		$index = 0;
		while ($output[$var] != NULL)
		{
			if (!strcmp($output[$var], "\n"))
			{
				if (strpos($line, 'style="padding-bottom:0px;">'))
					$film_name_alias = get_alias_name($output, ($var + 10));
				if (strpos($line, '<b itemprop="name">'))
					$film_name = get_film_name($line);
				if (strpos($line, '<span itemprop="description">'))
					$film_summary = get_film_summary($line);
				if (strpos($line, '/images/image-non-disponible.jpg'))
					$film_img = get_film_img($line);
				if (strpos($line, 'Pays'))
					$film_country = get_film_country($line);
				if (strpos($line, 'Année'))
					$film_year = get_film_year($line);
				if (strpos($line, 'Duree :'))
					$film_length = get_film_length($line);
				if (strpos($line, 'Acteurs'))
					$film_actors = get_film_actors($line);
				if (strpos($line, 'Genre'))
					$film_category = get_film_category($line);
				if (strpos($line, 'iframe') && !strpos($line, 'pub') && !strpos($line, 'vote'))
					$film_lector = ''.$film_lector.''.get_film_lector($line).'';
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
		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' ALIAS_FOUND : ';
		echo "\e[0;34m";
		echo $film_name_alias;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM SUMMARY : ';
		echo "\e[0;34m";
		echo $film_summary;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM IMAGE LINK : ';
		echo "\e[0;34m";
		echo $film_img;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM YEAR : ';
		echo "\e[0;34m";
		echo $film_year;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM LENGTH : ';
		echo "\e[0;34m";
		echo $film_length;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM ACTORS : ';
		echo "\e[0;34m";
		echo $film_actors;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM CATGEORY : ';
		echo "\e[0;34m";
		echo $film_category;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM LECTOR : ';
		echo "\e[0;34m";
		echo $film_lector;

		echo "\n";
		echo "\e[0;35m";
		echo '('.$film_name.')';
		echo "\e[0;37m";
		echo ' FILM COUNTRY : ';
		echo "\e[0;34m";
		echo $film_country;
		echo "\n";
	}
?>