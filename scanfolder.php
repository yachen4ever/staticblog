<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <title>生成页面</title>
	</head>
	<body>
<?php
	function xCopy($source, $destination, $child){
		if (!is_dir($destination)) mkdir ($destination);
		$handle=dir($source);
		while($entry=$handle->read()) {
			if(($entry!=".")&&($entry!="..")){
				if(is_dir($source."/".$entry)){
					if ($child)
						xCopy($source."/".$entry,$destination."/".$entry,$child);
				}
				else{
					copy($source."/".$entry,$destination."/".$entry);
				}
			}
		}
		return 1;
	}  
 
	//内容数组根据文章创建时间排序使用的交换函数
	function swap(&$array1,&$array2) {
		$arraytemp = $array1;
		$array1 = $array2;
		$array2 = $arraytemp;
	}
	

	//复制css文件到生成目录
	if (!is_dir('out')) mkdir ('out');
	xCopy('bootstrap','out',1);
	
	
	//创建内容数组和标签数组
	$content = array();
	$cnt=0;
	$tagarray = array();
	$tagcnt = 0;
	
	//引入readMdFile函数
	require_once('readfile.php');
	
	//扫描post文件夹下的所有MarkDown文件
	$dir = './post';
    if (is_dir($dir)) {  
		$handle = opendir($dir);
		while (($file = readdir($handle)) !== false) {
			if (pathinfo($file, PATHINFO_EXTENSION) == 'md' 
				&& basename($file,'.md')!= 'about' && basename($file,'.md')!='links') {
				readMdFile(basename($file,".md"),$content[$cnt]);
				$cnt++;
			}
		}
		closedir($handle);
    } 
	
	//按时间顺序排列所有md文档信息
	for ($i=0;$i<$cnt;$i++) {
		for ($j=$i+1;$j<$cnt;$j++) {
			$datei = $content[$i]['datetime'];
			$datej = $content[$j]['datetime'];
			if (strtotime($datei) > strtotime($datej)) swap($content[$i],$content[$j]);
		}
	}
	
	//根据按文章创建时间排序创建文章之间的先后关系
	$content[0]['contentpre'] = '1.html';
	$content[$cnt-1]['contentnext'] = (string)($cnt) . '.html';
	if ($cnt != 1) {
		$content[0]['contentnext'] = '2.html';
		$content[$cnt-1]['contentpre'] = (string)($cnt-1) . '.html';
	}
	
	for ($i=1;$i<$cnt-1;$i++) {
		$content[$i]['contentpre'] = (string)($i) . '.html';
		$content[$i]['contentnext'] = (string)($i+2) . '.html';
	}
	
	//循环生成每篇文章的html
	for ($i=0;$i<$cnt;$i++) {
		//代入文章属性
		$pagetitle = $content[$i]['pagetitle'];
		$datetime = $content[$i]['datetime'];
		$tags = $content[$i]['tags'];
		$postbody = $content[$i]['postbody'];
		$contentpre = $content[$i]['contentpre'];
		$contentnext = $content[$i]['contentnext'];
		
		//根据tags生成tag数组，为生成标签页面做准备
		$thispagetagcnt = count($content[$i]['tagsarray']);
	//	echo $thispagetagcnt;
		for ($j=0;$j<$thispagetagcnt;$j++) {
			$tagname = $content[$i]['tagsarray'][$j];
			if (!array_key_exists($tagname,$tagarray)) {
				$tagcnt++;
				$tagarray["$tagname"] = array();
			}
			array_push($tagarray["$tagname"],$i);
		}

		//引入页面模板
		require('pagemodule.php');
		
		//写入html
		$sHtmlDirName = "out/".(string)($i+1).".html";
		$strout = fopen($sHtmlDirName,"w");
		fwrite($strout,$str);
		fclose($strout);
		//echo $str;
	}
	
	//生成主页 
	//默认每页5条 若总数大于5每页设为5，总数小于5每页直接设为总数
	if ($cnt > 5) $pageindexcnt = 5;
	else $pageindexcnt = $cnt;
	//共有 总数/5向上取整 页
	$pagecnt = ceil($cnt/5);
	//indexcnt用于记录处理到第几条
	$indexcnt = $cnt;
	
	//对每页进行循环
	for ($k=0;$k<$pagecnt;$k++) {
		//若处理到最后一页，最后一页条数置为$indexcnt
		if ($k+1 == $pagecnt) {
			$pageindexcnt = $indexcnt;
		}
		//引入页面头部和尾部
		require('indexmodule.php');
		//对当前页每条进行循环
		for ($i=$indexcnt,$j=0;$j<$pageindexcnt;$i--,$j++) {
			//引入条目模版
			require('itemmodule.php');
			
			//代入条目属性
			$itemstr = str_replace("@pagetitle",$content[$i-1]['pagetitle'],$itemstr);
			$itemstr = str_replace("@datetime",$content[$i-1]['datetime'],$itemstr);
			$itemstr = str_replace("@tags",$content[$i-1]['tags'],$itemstr);
			$itemstr = str_replace("@description",$content[$i-1]['description'],$itemstr);
			$itemstr = str_replace("@pagelink",$i.'.html',$itemstr);
			
			$strindexhead = $strindexhead . $itemstr;
		}
		
		//生成Pre,Next按钮
		if ($k==0) $strindexend = str_replace("@prepage",'index.html',$strindexend);
		else $strindexend = str_replace("@prepage",'index'.($k).'.html',$strindexend);
		if ($k+1 == $pagecnt) $strindexend = str_replace("@nextpage",'index'.($k+1).'.html',$strindexend);
		else $strindexend = str_replace("@nextpage",'index'.($k+2).'.html',$strindexend);
		
		//拼接html字符串
		$strindexhead = $strindexhead . $strindexend;
		
		//生成主页的html文件
		$stroutindex = fopen('out/index'.($k+1).'.html',"w");
		fwrite($stroutindex,$strindexhead);
		fclose($stroutindex);
		
		//将第一页生成为index.html
		if ($k==0) {
			$stroutindex2 = fopen('out/index.html','w');
			fwrite($stroutindex2,$strindexhead);
			fclose($stroutindex2);
		}
		$indexcnt -= $pageindexcnt;
	}
	
	//生成归档页面
	require('archivemodule.php');
	for ($i=$cnt-1;$i>=0;$i--) {
		require('archiveitemmodule.php');
		$archiveitemstr = str_replace("@pagetitle",$content[$i]['pagetitle'],$archiveitemstr);
		$archiveitemstr = str_replace("@datetime",$content[$i]['datetime'],$archiveitemstr);
		$archiveitemstr = str_replace("@pagelink",($i+1).'.html',$archiveitemstr);
		
		$archive = $archive . $archiveitemstr;
	}
	$archive = $archive . $archiveend;
	
	$stroutarc = fopen('out/archive.html',"w");
	fwrite($stroutarc,$archive);
	fclose($stroutarc);	
	
	//生成标签页面
	require ('tagsindexmodule.php');			
	foreach ($tagarray as $tagname=>$linkedpagearray) {
		
		//生成单个标签对应页面
		require ('tagpagemodule.php');
		$tagpage = str_replace("@tagname",$tagname,$tagpage);
		foreach ($tagarray["$tagname"] as $linkedpage) {
			require('archiveitemmodule.php');
			$archiveitemstr = str_replace("@pagetitle",$content[$linkedpage]['pagetitle'],$archiveitemstr);
			$archiveitemstr = str_replace("@datetime",$content[$linkedpage]['datetime'],$archiveitemstr);
			$archiveitemstr = str_replace("@pagelink",'../'.($linkedpage+1).'.html',$archiveitemstr);
		
			$tagpage = $tagpage . $archiveitemstr;
		}
		$tagpage = $tagpage . $tagpageend;
		
		if (!is_dir('out/tags')) mkdir ('out/tags');
		$sHtmlDirName = "out/tags/".$tagname.".html";
		
		//Window使用GB2312存储中文文件名，在此转换
		$sHtmlDirName = iconv("utf-8","gb2312//IGNORE",$sHtmlDirName);
		$strouttag = fopen($sHtmlDirName,"w");
		fwrite($strouttag,$tagpage);
		fclose($strouttag);
		
		require('archiveitemmodule.php');
		$archiveitemstr = str_replace("@pagetitle",$tagname,$archiveitemstr);
		$archiveitemstr = str_replace("@datetime",count($tagarray["$tagname"]),$archiveitemstr);
		$archiveitemstr = str_replace("@pagelink",$tagname.'.html',$archiveitemstr);
		
		$archive = $archive . $archiveitemstr;
	}
	$archive = $archive . $archiveend;
	
	$strouttagindex = fopen('out/tags/index.html',"w");
	fwrite($strouttagindex,$archive);
	fclose($strouttagindex);

	//生成关于页面
	readMdFile('about',$about);
	
	$pagetitle = "关于";
	$datetime = $about['datetime'];
	$postbody = $about['postbody'];
	require ('aboutlinkmodule.php');
	
	$stroutabout = fopen('out/about.html',"w");
	fwrite($stroutabout,$aboutlink);
	fclose($stroutabout);
	
	//生成友链页面
	readMdFile('links',$links);
	
	$pagetitle = "友情链接";
	$datetime = $links['datetime'];
	$postbody = $links['postbody'];
	require ('aboutlinkmodule.php');
	
	$stroutlinks = fopen('out/links.html',"w");
	fwrite($stroutlinks,$aboutlink);
	fclose($stroutlinks);
	
	echo '博客生成完毕，<a href="out/index.html">点击</a>打开主页';
?>
</body>
</html>