<?php
	
	require_once 'Michelf/Markdown.inc.php';
	use \Michelf\Markdown;
	
	//读取分析markdown文件
	function readMdFile($sFilename,&$array) {
				
		//读取markdown文件
		$sMdFileDirName = "post/".$sFilename.".md";
		$array['tags'] = "";
		$array['tagsarray'] = array();
		$handle = fopen($sMdFileDirName,"r");
		while (!feof($handle)) {
			$line = fgets($handle);
			if (trim($line) == "---") {
				$sOriMdText = fread($handle,800000);
				$array['postbody'] = Markdown::defaultTransform($sOriMdText);
			}
			else {
				$strinfo = trim($line);
				$strlength = strlen($strinfo);
				if (substr($strinfo,0,6)=="title:") {
					$array['pagetitle'] = substr($strinfo,6,$strlength-6);
				}
				if (substr($strinfo,0,5)=="date:") {
					$array['datetime'] = substr($strinfo,5,$strlength-5);
				}
				if (substr($strinfo,0,5)=="tags:") {					
				}
				if (substr($strinfo,0,2)=="- ") {
					$taginfo = substr($strinfo,2,$strlength-2);
					$array['tags'] = $array['tags']. ' <a href="tags/'.$taginfo.'.html">'. $taginfo.'</a>';
					array_push($array['tagsarray'],$taginfo);
				}
				if (substr($strinfo,0,12)=="description:") {
					$des = substr($strinfo,12,$strlength-12);
					$array['description'] = $des;
				}
				
			}
		}
		
	}
?>