<?php
$str=<<<PAGESIGNAL
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/agate.css">
		<script src="js/highlight.pack.js"></script>
		<script>hljs.initHighlightingOnLoad();</script>
        <title>$pagetitle</title>
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
		<div class="detail">
            <div class="post">
                <div class="content">
                    <h1 class="title">$pagetitle</h1>
					<div class="info">
						<span class="date"><i class="glyphicon glyphicon-calendar"></i>
						$datetime
						</span>
						<span class="tags"><i class="glyphicon glyphicon-tags"></i>
						$tags
						</span>
					</div>
					<div class="post_body">
					$postbody
					</div>
				</div>
			</div>
			<div class="other_posts">
				<a href=$contentpre class="pre">上一篇文章</a>
				<a href=$contentnext class="next">下一篇文章</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/contents.js"></script>
</body>
</html>
PAGESIGNAL;
?>