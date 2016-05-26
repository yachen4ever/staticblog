title: ExtJS 开发环境配置（Spket）
date: 2016-02-29 15:42:47
tags: 
- ExtJS
- Skept
- Eclipse
- JavaScript
categories: Study
description: 最近系统的学习了一下ExtJS框架，一开始是一直使用Notepad++进行开发的，直到发现了Spket这个Eclipse插件可以提供很多Notepad++不具备的功能，配置起来也很简单，现将过程记录如下。
---

### 前言

最近在实习，借机系统的学习了一下ExtJS框架，一开始是一直使用Notepad++进行开发的，直到发现了Skept这个Eclipse插件可以提供很多Notepad++不具备的功能，配置起来也很简单，现将过程记录如下。

### 版本信息

>* ExtJS 3.4 (http://www.xuchen.wang/down/ext-3.4.0.zip)
>* Eclipse Kepler Java EE IDE for Web Developers（Eclipse版本差异无影响） (https://www.eclipse.org/downloads/packages/release/Kepler/SR2)
>* Spket 1.6.23 (http://www.xuchen.wang/down/spket-1.6.23.jar)

**注意：**
1. Eclipse版本差异无影响。
2. Spket需要Java 1.5及以上版本运行支持。
3. ExtJS大版本不同差异比较多，Ext2.x系列，3.x系列，4.x系列迁移起来耗时较多，建议认准一个版本然后稳定保持。

### 安装过程

1.将Spket下载好后直接使用java运行（如果你jdk版本低于1.6或没有配置jar默认打开方式为java.exe再或不想配置，可以使用cmd输入java -jar spket-1.6.23.jar）。在安装时Spket安装程序会让你选择Spket是以现有Eclipse的插件形式安装还是以一个独立IDE形式安装。如果选择插件形式，下一步你需要输入Eclipse根目录，而独立IDE也就是一个极其精简版的Eclipse。这里我们使用以插件形式安装。

2.安装完毕后打开Eclipse，打开Window菜单Preferences选项。在左侧选择Spket（如果没有说明你安装不成功）中的JavaScript Profiles，如图所示。
![extenv1](http://xuchen.wang/img/extenv1.png)

3.点击右侧的New，输入ExtJS（这个名字无所谓）。再点击Add Library，在下拉菜单中选择ExtJS。如图所示。

![extenv2](http://xuchen.wang/img/extenv2.png)

4.点击右侧的Add File,选择ExtJS存放目录下的ext.jsb2,ext-all.js,ext-all-debug.js三个文件。如图所示。

![extenv3](http://xuchen.wang/img/extenv3.png)

5.选中最开始命名的ExtJS，点击右侧Default。

重启Eclipse，即可使用。

**注意：**
如果没有自动补全和提示效果，很可能是因为你没有将Spket设置为默认JS编辑器。
解决办法：打开Eclipse的Window菜单Preferences选项，左侧选择Gerenal->Editor->File Associations，右侧上面File Types选择*.js，下侧将Spket JavaScript Editor设为Default，然后重新打开js文件即可。如图所示。
![extenv5](http://xuchen.wang/img/extenv5.png)

### 效果演示

这样Spket就安装好了，你会发现你在写ExtJS时会得到这样的效果：
![extenv4](http://xuchen.wang/img/extenv4.png)

### 一些备注

学习ExtJs我使用的这本书：
http://xuchen.wang/down/extbook.part1.rar
http://xuchen.wang/down/extbook.part2.rar
书中配套光盘中的实例文件：
http://xuchen.wang/down/ext-sample.rar