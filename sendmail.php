<?php
	function SendEmail( $from, $to, $subj, $text, $files=array(), $pack=true)
	{
		$un        = strtoupper(uniqid(time()));
		$head      = "From: {$from}\n";
		$head     .= "X-Mailer: bknProfiMailer\n";
		$head     .= "Reply-To: {$from}\n";
		$head     .= "Mime-Version: 1.0\n";
		$head     .= "Content-Type:multipart/mixed;";
		$head     .= " boundary=\"----------".$un."\"\n\n";
		if(is_array($text)){
			// Если текст передан массивом (для случая когда есть plaintext и html форма письма)
			// массив должен быть вида: array('text'=>'plaintext','html'=>'html message');
			$zag='';
			$un2        = strtoupper(uniqid(time()));
			$zag     .= "------------".$un."\r\nContent-Type:multipart/mixed;";
			$zag     .= " boundary=\"----------".$un2."\"\n\n";
			foreach($text as $type=>$val){
				$zag      .= "------------".$un2."\nContent-Type:text/$type; charset=\"utf-8\"\n";
				$zag      .= "Content-Transfer-Encoding: 8bit\n\n";
				$zag      .= "$val\n\n";
			}
			$zag.="------------".$un2."--";
		}else{
			$zag       = "------------".$un."\nContent-Type:text/html; charset=\"utf-8\"\n";
			$zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n";
		}
		foreach($files as $file){
			if (filesize($file['tmp_name'])==0) continue;
			$name=basename(array_key_exists('name',$file)?$file['name']:$file['tmp_name']);
			if($pack)
				$name.='.gz';
			// Если имя файла содержит не acii символы, то кодируем в base64
			if(preg_match('#[^:ascii:]#',$name))
				$name="=?utf-8?B?". base64_encode($name).'?=';
			$f         = fopen($file['tmp_name'],"rb");
			$zag      .= "------------".$un."\n";
			$zag      .= "Content-Type: application/octet-stream;";
			$zag      .= "name=\"$name\"\n";
			$zag      .= "Content-Transfer-Encoding:base64\n";
			$zag      .= "Content-Disposition:attachment;";
			$zag      .= "filename=\"$name\"\n\n";
			// Упаковывать файлы прои отправке или нет
			if ($pack)
				$zag      .= chunk_split(base64_encode(gzencode(fread($f,filesize($file['tmp_name'])),9)))."\n";
			else
				$zag      .= chunk_split(base64_encode(fread($f,filesize($file['tmp_name']))))."\n";
			fclose($f);
		}
		$zag.="------------".$un."--";
		// Кодируем тему письма в base64
		if (!@mail($to  , "=?utf-8?B?". base64_encode($subj) . '?=', $zag, $head))
			 return 0;
		else
			 return 1;
	}
