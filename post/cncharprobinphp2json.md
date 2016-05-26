title: 让PHP输出Json时正常显示中文
date: 2015-12-21 20:24:42
tags: 
- PHP
- Json
categories: Study
description: 在使用PHP读取数据库生成Json文件的时候，我遇到了这样一个问题：中文部分全部被PHP的json_encode函数替换为了\u+utf8编码的形式，在一般情况下，如果我们不会特意去使用其他不支持直接解码\u+utf8的软件读取Json，并不需要对其进行操作。这里我参考总结了下PHP为什么要这么做和一些让你在Json中看到能显示ASCII可显示字符之外的字符方法，记录了下来。
---

## 问题描述

在使用PHP读取数据库生成Json文件的时候，我遇到了这样一个问题：PHP会自动将中文转换成\u+utf8编码。

PHP读取数据库输出Json代码截取如下：

	<?php
		require_once('conn.php');
		header('Content-type:text/json'); 
		
		class Map{
			public $id,$name,$cnname;
		}
		
		$sql = "select * from dbname";
		$res = mysql_query($sql,$db);
		
		$arr=array();
		
		while ($row=mysql_fetch_object($res)) {
			$m=new Map();
			$m->id=$row->id;
			$m->name=$row->name;
			$m->cnname=$row->cnname;
			$arr[]=$m;
		}
		
		$str = json_encode($arr);
		echo $str;
		mysql_close($db);
	?>


此时，输出显示摘取如下：

	[
	{"id":"1","name":"Questionable Ethics","cnname":"\u4f26\u7406\u95ee\u9898"},
	{"id":"2","name":"Questionable Ethics 2 : Alpha Test","cnname":"\u4f26\u7406\u95ee\u98982\uff1aA\u6d4b"},
	{"id":"3","name":"We Don't Go To Ravenholm","cnname":"\u6211\u4eec\u4e0d\u53bb\u83b1\u6e29\u970d\u59c6"}
	]


而数据库截图截取如下：
![db](http://xuchen.wang/img/cncharprobinphp2json1.png)

可以看到，中文部分全部被PHP的json_encode函数替换为了\u+utf8编码的形式。不过在前端，Javascript也认这些编码并会自动翻译成中文，所以在一般情况下，如果我们不会特意去使用其他不支持直接解码\u+utf8的软件读取Json，并不需要对其进行操作。这里我参考总结了下PHP为什么要这么做和一些让你在Json中看到能显示ASCII可显示字符之外的字符方法，记录了下来。

## PHP为什么这样处理

PHP这样处理，就把所有 ASCII 可显示字符以外的统统转义为Unicode明文。即使你的文档是ANSI编码，你得到的出ASCII可显示字符之外的字符也都是\u+utf8编码，这样就保证了前端得到Json时编码统一。无论文件编码是否一致，都不会出现乱码。

其实，在实际工作中，这个问题可以不用像PHP那样为我们考虑的这么周到。因为你不会直用静态的页面为其他站点提供接口，往往生成出Json只是自己内部用而已，就算后台提交给前台或前台提交给后台，首先JS会自动解码还原，而且一个项目下编码也肯定会是同意的，所以内部不需要考虑那些兼容问题。

## 解决方案

### 老子版本高法
在PHP 5.4及以上版本中，PHP已经给json_encode函数增加了一个选项：JSON_UNESCAPED_UNICODE。加上这个选项后，就不会自动把ASCII可显示字符之外的字符编码为Unicode明文了。
示例：
	echo json_encode("测试", JSON_UNESCAPED_UNICODE);


### url编码遮蔽法
大家都知道PHP中有个URL编解码函数对：urlencode()和urldecode()。这个方法就是在使用json_encode()编码文字之前，我先用urlencode()把中文变成url字符，比如"测试"这个字符串经过urlencode()后，就变成了"%B2%E2%CA%D4"，json_encode自然不会认识这是个中文，所以就不会对其进行操作。待你将其json_encode()后，再用urldecode()将它变回"测试"即可。
示例

	echo urldecode(json_encode(urlencode("测试")));


### 手动替换法
当然，我们也可以直接对已经变为\uXXXX的汉字进行直接替换。替换代码如下：

	return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $str);
	//windows
	return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2LE', 'UTF-8', pack('H4', '\\1'))", $str);

我这里使用了url编码遮蔽，效果如下图，可以看到输出已经变成中文了。
![img](http://xuchen.wang/img/cncharprobinphp2json2.png)

## 感谢
1. http://blog.csdn.net/aoyoo111/article/details/16883241
2. http://www.jb51.net/article/50317.htm
3. http://www.cnblogs.com/52cik/p/js-json-stringify-escape.html