<?php
$strindexhead=<<<INDEXHEAD
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
        <title>我的博客</title>
	</head>
	
<body>
	
    <div id="header" class="header">
        <div class="header_wrapper">
          <h1 class="title"><a href="index.html">我的博客</a></h1>
          <ul class="navfz">
            <li><a href="index.html">首页</a></li>
            <li><a href="archive.html">归档</a></li>
            <li><a href="tags/index.html">标签</a></li>
            <!-- <li><a href="category">分类</a></li> -->
            <li><a href="links.html">友链</a></li>
            <li><a href="about.html">关于</a></li>
          </ul>
        </div>
    </div>
	
	<div id="main">
INDEXHEAD;

$strindexend=<<<INDEXEND
	</div>
	
	<nav>
		<ul class="pager">
			<li class="previous"><a href="@prepage">Pre</a></li>
			<li class="next"><a href="@nextpage">Next</a></li>
		</ul>
	</nav>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/contents.js"></script>
</body>
</html>
INDEXEND;
?>