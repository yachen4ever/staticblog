<?php
	
	require_once 'Michelf/Markdown.inc.php';
	use \Michelf\Markdown;
	
	//读取分析markdown文件
	//参数sFilename：文件名，&$array：生成出的内容数组
	function readMdFile($sFilename,&$array) {			
		//拼接得到md文件全名
		$sMdFileDirName = "post/".$sFilename.".md";
		//初始化标签数组
		$array['tags'] = "";
		$array['tagsarray'] = array();
		$handle = fopen($sMdFileDirName,"r");
		//逐行读入头部md文件信息
		while (!feof($handle)) {
			$line = fgets($handle);
			//如果读取到了'---'，则头部信息结束
			if (trim($line) == "---") {
				//直接读取完剩余正文内容调用Markdown转换器
				$sOriMdText = fread($handle,800000);
				$array['postbody'] = Markdown::defaultTransform($sOriMdText);
			}
			else {
				//去除尾部的换行符
				$strinfo = trim($line);
				$strlength = strlen($strinfo);
				//如果是title
				if (substr($strinfo,0,6)=="title:") {
					$array['pagetitle'] = substr($strinfo,6,$strlength-6);
				}
				if (substr($strinfo,0,5)=="date:") {
					$array['datetime'] = substr($strinfo,5,$strlength-5);
				}
				if (substr($strinfo,0,5)=="tags:") {					
				}
				//'- '打头说明是一个标签
				if (substr($strinfo,0,2)=="- ") {
					$taginfo = substr($strinfo,2,$strlength-2);
					//array['tags']用于直接输出页面上的标签
					$array['tags'] = $array['tags']. ' <a href="tags/'.$taginfo.'.html">'. $taginfo.'</a>';
					//array['tagsarray']是这个页面标签的数组，用于后面生成标签-文章的关联数组
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