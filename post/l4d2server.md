title: Linux环境搭建Left 4 Dead 2/求生之路2专用服务器
date: 2015-12-18 14:52:24
tags: 
- 求生之路
- 服务器
categories: Game
description: 我和范峥以及一群朋友经常会聚在一起玩求生之路2，直接用本地建主的话ping会比较高，我们就在阿里云上搭了一个Left 4 Dead 2 Dedicated Server。借着今天我雪重装了下服务器系统的机会，我将L4D2服务器搭建的过程记录下来以供参考。
---
**首先说明，此文章所述搭建过程仅适用于Steam正版L4D2，盗版开服需要自己下载服务器破解补丁。作者和朋友们都在Steam上玩，请恕本文章并不涉及**

我和范峥以及一群朋友经常会聚在一起玩求生之路2，直接用本地建主的话ping会比较高，我们就在阿里云上搭了一个Left 4 Dead 2 Dedicated Server。借着今天我雪重装了下服务器系统的机会，我将L4D2服务器搭建的过程记录下来以供参考。

**首先说明下服务器环境和配置**
>* 阿里云的1G内存，1核，1Mbps带宽的标准学生机
>* Ubuntu 14.04 LTS x64
>* L4D2并不需要很高配置，但实测我们这个配置如果是Windows去跑玩的时候会有时略有卡顿，Linux则不会，建议还是选择Linux。

**下面开始说配置过程**

## SteamCMD的下载和配置

SteamCMD是Valve提供的Steam的命令行版本，用于在Linux搭建各个游戏的Dedicated Server。

### 安装32位运行库
如果你和我一样是Ubuntu的64位版本，第一件事要做的是安装32位运行库：
Ubuntu/Debian 64-bit:

	apt-get install lib32gcc1

如果你是32位RedHat系Linux，如CentOS 32bit:

	yum install glibc libstdc++

如果是64位RedHat系Linux：

	yum install glibc.i686 libstdc++.i686
	
**另注意：使用SteamCMD和运行服务器时，Valve非常不推荐使用root用户，你可以使用**

	adduser username
	su - username
	
**来创建并切换用户。**

### 安装SteamCMD。
如下面所示。

	mkdir ~/steamcmd
	cd ~/steamcmd
	wget https://steamcdn-a.akamaihd.net/client/installer/steamcmd_linux.tar.gz
	tar -zxvf steamcmd_linux.tar.gz

### 配置SteamCMD。

	cd ~/steamcmd
	./steamcmd.sh
	
第一次运行SteamCMD时，SteamCMD会自动下载一些文件，和Steam一样，不是很大，稍等片刻即可。
下载完后命令行显示：

	Steam Console Client (c) Valve Corporation
	-- type 'quit' to exit --
	Loading Steam API...OK.

	Steam>

这里，你可以选择是否使用匿名登录，有些游戏的Server需要你有游戏才可以下载，有些匿名登录可以下，具体表格请参见:https://developer.valvesoftware.com/wiki/Dedicated_Servers_List
在这里，因为L4D2服务器可以匿名登录下载，我们选择使用匿名登录

	Steam>login anonymous

	Connecting anonymously to Steam Public...Logged in OK
	Waiting for license info...OK

	Steam>

此时已经登录成功，我们可以使用force_install_dir指定下载目录.

	Steam>force_install_dir /home/username/l4d2

这时，就可以开始下载Left 4 Dead 2 Dedicated Server了，下载的命令语法是

	app_update <app_id> [-beta <betaname>] [-betapassword <password>] [validate]

其中，app_id是该Dedicated Server在Steam数据库中的APPID，在https://developer.valvesoftware.com/wiki/Dedicated_Servers_List 可以查询到，L4D2 Dedicated Server的APPID是222860，后面beta选项是是否参加该游戏的某项测试，和本次L4D2搭建无关，最后的validate是是否下载完成后验证一遍文件，推荐加上。
我们使用如下命令：

	Steam>app_update 222860 validate

接下来就可以慢慢等服务器下载成功了。

等到提示

	Success! App '222860' fully installed.

即说明已经下载安装成功。此时就可以键入quit退出steamcmd了。

## Left 4 Dead 2 Dedicated Server的配置

### server.cfg的配置
L4D2是一款Source引擎的游戏，其Dedicated Server配置也秉承了一系列SRCDS（Source Dedicated Server）的特点，配置起来简单方便。
简而言之，用/l4d2表示我们下载l4d2的目录(force_install_dir中设定的）我们仅仅需要在/l4d2/left4dead2/cfg/目录下新建一个server.cfg文件将我们需要进行配置的选项赋值即可。具体可配置的选项如下：

	hostname "servername"    //游戏服务器名
	rcon_password "password" //远程管理密码
	//sv_search_key yourkey  //搜索此服务器的关键词
	//sv_region 255          //服务器地区，255表示全球
	//sv_gametypes "coop,versus,survival,scavenge" //游戏模式
	//map c5m1_waterfront    //游戏地图
	//sv_voiceenable 1       //开启语音服务
	//sv_lan 0				 //是否是局域网游戏
	//sv_cheats "0"			 //是否允许作弊

	//sv_steamgroup "01234"  //Steam组号
	//sv_steamgroup_exclusive 1 //将服务器设为Steam组私有

具体选项请参阅Valve相关说明。在这里我们不需要过多配置，像游戏地图模式等我们可以在Left 4 Dead 2游戏内去选择，以下是我们组服务器配置的server.cfg文件

	hostname "YaCMap Linux @_@"
	sv_steamgroup 10658701
	sv_steamgroup_exclusive 1

可以看到，我们仅仅配置了服务器名和组服务器私有的选项，而这些就足够了。

### 服务器细节配置

>另外多说一句，和朋友一起玩可以先建立你们的Steam组，都加入后请在组管理页面获取组数字编号，如图所示。
>![steamgroup](http://xuchen.wang/img/steamgroup.png)
将其放在sv_steamgroup后面加入server.cfg即可。

在/l4d2/left4dead2目录下，你可以发现host.txt和motd.txt，他们里面的内容分别是游戏进入时显示的服务器信息和今日消息两张图片，你可以对他们进行修改，改为你的页面的图片地址。

### 服务器运行

最后，请建立一个run.sh文件，输入

	./srcds_run -game left4dead2 +exec server.cfg

这样运行L4D2虽然没有问题，但你必须保持SSH连接一直打开，万一不小心关闭了服务器就也没了，很不方便，我推荐使用后台去运行服务器，在命令前只需简单的加入一个nohup即可。

	nohup ./srcds_run -game left4dead2 +exec server.cfg

像这样后台运行，如果你想彻底关闭服务器，你需要ps -ef查看进程并kill掉srcds的pid。

可以使用绝对路径并随便将这个run.sh文件放置在任何地方，以后直接启动run.sh，你便可以和朋友们开心的L4D2了！

另外，你也可以使用screen来替代nohup，screen比nohup使用起来更为方便、容错率更高，我的下一篇博文详细描述了screen的使用方法。

## 感谢

感谢以下参阅过的资料：
https://developer.valvesoftware.com/wiki/SteamCMD
http://forums.steampowered.com/forums/showthread.php?t=1381634

最后，向大家推荐下我和朋友们玩过的所有第三方战役，请参阅：http://yacmap.xyz/l4d2maps.html