title: GNU Mannal Screen命令中文摘要
date: 2015-12-19 12:48:50
tags: 
- Linux
- Screen
categories: Study
description: Screen是一个在远程连接Linux时非常实用的工具。当你SSH远程使用Linux服务器运行一些需要很长时间才能完成的任务，此时我们就不能关闭这个SSH链接，否则这个任务就会被kill了，非常不方便。Screen的出现解决了这个问题。这篇文章中，我对Screen的GNU Mannul进行了一些摘要。
---

## 总览

>* 后台运行
>* 会话恢复
>* 多窗口运行
>* 会话共享

当你SSH远程使用Linux服务器时，可能经常运行一些需要很长时间才能完成的任务，此时我们就不能关闭这个SSH链接，否则这个任务就会被kill了，非常不方便。

Screen的出现解决了这个问题。Screen是一款由GNU计划开发的用于命令行终端切换的自由软件。用户可以通过该软件同时连接多个本地或远程的命令行会话，并在其间自由切换。

当然，Screen的功能不仅局限于此，Screen可以看作是窗口管理器的命令行界面版本。它提供了统一的管理多个会话的界面和相应的功能。

在Screen环境下，所有的会话都独立的运行，并拥有各自的编号、输入、输出和窗口缓存。用户可以通过快捷键在不同的窗口下切换，并可以自由的重定向各个窗口的输入和输出。Screen实现了基本的文本操作，如复制粘贴等；还提供了类似滚动条的功能，可以查看窗口状况的历史记录。窗口还可以被分区和命名，还可以监视后台窗口的活动。

并且，Screen还可以实现会话共享，多个用户从不同终端多次登录一个会话，并共享会话的所有特性（比如可以看到完全相同的输出）。它同时提供了窗口访问权限的机制，还可以对窗口进行密码保护。


## 开始使用Screen
### 安装GNU Screen
一般来说，常见Linux发行版都会自带GNU Screen，但神奇的是我购买的VirMach服务器装的Ubuntu 14.04 Minimal自带了Screen，反倒是Aliyun装的Ubuntu 14.04.3 LTS没有，不过问题不大，我们来自己安装一下。

	# apt-get install screen

### 创建一个Screen
#### 语法

	# screen [-S <ScreenName>][-s <program>]

#### 使用-S参数
-S参数提供了一个screen名称标识，可以使用

	# screen -S screenname

来新建一个以screenname标识的screen，此时就好像清屏了一样看不出区别，但其实你已经在一个screen中工作了，输入exit，可以看到

	[screen is terminating]
	# 
	
#### 使用-s参数
-s参数指定了建立新Screen时，所要执行的程序。默认是bash。-s可以省略，比如我们如果想在一个新Screen中运行vi，可以直接输入

	# screen vi


### 查询并恢复Screen
查询：

	# screen -ls

恢复

	# screen -r <数字标号或screen名称>


### Screen下的操作
在一个Screen下，所有命令都以Ctrl+A开始，按下Ctrl+A后，你可以使用以下常用命令。
>* Ctrl+A c --> 创建一个新的运行shell的窗口并切换到该窗口
>* Ctrl+A n --> (Next)切换到下一个screen
>* Ctrl+A p --> (Previous)切换到上一个screen
>* Ctrl+A 0..9 --> 切换到第0~9个screen
>* Ctrl+A [Space] --> 循环依次切换screen
>* Ctrl+A Ctrl+A --> 在两个最近使用的screen来回切换
>* Ctrl+A d --> (Detach)暂时离开当前screen，返回主bash，此时该Screen中的进程继续后台运行不受影响
>* Ctrl+A w --> 显示当前所有Screen列表
>* Ctrl+A k --> (kill)杀死当前screen并强行结束其中所有进程
>* Ctrl+A x --> 锁住当前Screen，恢复需要密码
>* Ctrl+A ? --> 帮助
>* Ctrl+A [ --> 进入Copy模式
>* Ctrl+A ] --> Paste

## 使用示例
说这么多不如一次实践，我们来尝试一下使用Screen。

### 暂时断开

举个例子，我们现在先建立一个screen用来使用vi编辑文档

	# screen -S yacvi vi
	
![screen1](http://xuchen.wang/img/screen1.png)
突然写到一半我想重启电脑或是怎么样，必须断开连接，这时我只需要Ctrl+A d断开连接再关闭SSH即可。
![screen2](http://xuchen.wang/img/screen2.png)
待回来后，哪怕你换了一台电脑甚至换了一个人，连接SSH后，只需

	# screen -ls
	
即可查看服务器中有的Screen。
![screen3](http://xuchen.wang/img/screen3.png)
可以看到，我们建立的名为yacvi的screen还在，其数字标号是4304，我们输入

	# screen -r 4304

或
	# screen -r yacvi
	
即可继续进行编辑。

### 同时进行其他工作

比如，我们在编辑vi时突然想用w3m网上冲浪一把（别问我上网为什么用w3m）
我们在刚才的vi界面按下Ctrl+A c，这样就建立一个新screen，在其中输入w3m 网址就可以上网了。按下Ctrl+A w，可以看到已经有了2个Screen
![screen4](http://xuchen.wang/img/screen4.png)
**其中1后面的*就标识了这是你当前screen。**
根据我们上面提到的快捷键，连按两下Ctrl+A Ctrl+A，可以非常方便的在两个Screen来回切换。

### 杀死Screen

正常情况下，当你退出一个Screen中最后一个程序（通常是对bash进行exit），这个Screen就随之关闭了。当然我们使用Ctrl+A k可以更快捷的kill这个Screen。我们对运行w3m的Screen直接Ctrl+A k。这个Screen便不复存在。

## 一些补充

### 复制粘贴
在一个Screen中复制粘贴到另一个Screen是非常方便的。当你在一个Screen中按下Ctrl+A [，就进入了Copy Mode，在这里所有操作和Vi基本相同。
具体请参阅：http://www.gnu.org/software/screen/manual/screen.html#Copy

### 会话共享
假设你和朋友以相同用户登录一台机器，在你创建一个screen会话后，你朋友输入

	# screen -x

这样你在这个screen上的所有操作都会同步给他，他的所有操作也会同步给你，可以用来演示操作。

### 清扫dead screen
有时，一个screen进程可能被人为kill掉了，这样在screen -ls就会显示(Dead)。 如果出现这样的Screen，应使用screen -wipe清除。

## 感谢
本文参考了一下文档：
http://www.gnu.org/software/screen/manual/screen.html
http://www.cnblogs.com/mchina/archive/2013/01/30/2880680.html
在此表示感谢！