title: 在Github上搭建Hexo静态博客记录
date: 2015-12-17 02:40:25
categories: Study
tags: 
- 静态博客
- Hexo
- Github
description: 一直以来只有一个简陋的cnblogs上的博客，还基本都是高中时的东西。大学四年更新了3次，实在是惭愧，今晚和我雪说到这个，借此机会用Hexo在Github上搭个静态博客（然而我雪自己写了个静态化程序，膜之），准备好好记录下自己到底学了些什么。以下就是过程的记录和遇到的一些问题的解决办法了。
---


一直以来只有一个简陋的cnblogs上的博客，还基本都是高中时的东西。大学四年更新了3次，实在是惭愧，今晚和我雪说到这个，借此机会用Hexo在Github上搭个静态博客（然而我雪自己写了个静态化程序，膜之），准备好好记录下自己到底学了些什么。以下就是过程的记录和遇到的一些问题的解决办法了。

# 一、准备一些工具

你需要以下软件：
>* 1. Git (http://git-scm.com/downloads)
>* 2. node.js (http://nodejs.org/download)

下载好后两者都可一路回车法进行安装。Git需要配置SSH-Key，此过程使用过GitHub的都明白，此处不再赘述。完成后打开Git Bash，执行如下命令:

	$ npm install -g hexo

这样你就安装好了hexo主程序。

# 二、使用你的Github账户新建一个Repository

请注意，新建Repo时请注意Repository name请使用username.github.io。username换成你的用户名。只有这种方式建立的Repo才可以使用Github Pages直接访问。

# 三、创建博客目录

在git bash中选择好博客存放目录，执行

	$ hexo init

hexo会自动在此文件夹生成建立博客需要的文件，接着执行

	$ npm install
	$ npm install hexo-server
	$ npm install hexo-deployer-git

以上装好hexo-server（在hexo3.0版本中hexo-server从hexo中分离了出来）还有hexo用于git的部署工具。

此时即可生成静态网页后输入hexo server测试服务器是否正常运行。git bash应该会显示：

	$ hexo g
	$ hexo server
	[info] Hexo is running at http://0.0.0.0:4000/. Press Ctrl+C to stop.

这里的0.0.0.0是默认配置ip，可以在./_config.yml中修改，不过默认的也没有问题，打开http://localhost:4000应该会看到一篇默认的文章。

# 四、配置_config.yml

hexo所有配置都在_config.yml文件中，在

	# Site
	title: YaCHEN Factory
	subtitle: 
	description: 
	author: YaCHEN
	language:
	timezone:
	# URL
	## If your site is put in a subdirectory, set url as 'http://yoursite.com/child' and root as '/child/'
	url: http://www.xuchen.wang
	root: /
	permalink: :year/:month/:day/:title/
	permalink_defaults:


中，请将对应信息改为自己的。

而在尾部

	# Deployment
	## Docs: http://hexo.io/docs/deployment.html
	deploy: 
	  type: git
	  repo: git@github.com:yachen4ever/yachen4ever.github.io.git
	  

增加一行repo: 你在github上对应repository的SSH地址，请注意必须使用SSH地址，HTTPS会导致错误。

还有一个必须要注意的地方，**冒号后面一定要有一个空格**，否则会报错。

此时即可查看http://yourname.github.io/是否提交成功。

# 五、学会使用

每次部署博客，都可按以下三步来进行。

	$ hexo clean
	$ hexo generate
	$ hexo deploy

命令涵义就是字面意思，同时，后两条命令分别也可以简写为

	$ hexo g
	$ hexo d


而创建新博客使用

	

具体请参见:https://hexo.io/docs/writing.html
推荐使用 https://www.zybuluo.com/mdeditor 如果你没有接触过Markdown

# 六、一些问题

## 我想绑定独立域名
请参考 https://help.github.com/articles/setting-up-a-custom-domain-with-github-pages/
其中加入完后请将CNAME文件在./source中放置一份，这样下次hexo deploy时就不会使CNAME文件消失了。

## 部署时提示 ｀event type error ***｀ 
出现该问题是因为安装了git bash没有配置到环境变量path中，添加进去试试。

## 我想换一个主题
这里是官方主题预览：https://hexo.io/themes/
选好想要的主题后在git bash里输入

	$ git clone 该Theme SSH地址或HTTPS地址 themes/主题名

并在./_config.yml中修改

	theme: 新主题名

重新部署即可。