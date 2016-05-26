title: 修改Maven本地依赖库的默认存放位置
date: 2016-03-02 10:01:27
tags: 
- Maven
- Java
- Eclipse
categories: Study
description: Maven默认把本地依赖库放在~/.m2/repository/文件夹（～指用户目录）。而用户目录不特意设置都会在C盘。Maven的所有构件都会被存储到依赖库中，很快，你的C盘莫名其妙就被填满了。所以，我们不得不考虑修改下Maven本地依赖库的存放位置。
---

## 前言
Maven默认把本地依赖库放在~/.m2/repository/文件夹（～指用户目录）。而用户目录不特意设置都会在C盘。Maven的所有构件都会被存储到依赖库中，很快，你的C盘莫名其妙就被填满了。所以，我们不得不考虑修改下Maven本地依赖库的存放位置。

## 修改过程

### 修改%MAVEN_HOME%/conf/settings.xml
MAVEN_HOME表示MAVEN安装目录。

	<!-- localRepository
	   | The path to the local repository maven will use to store artifacts.
	   |
	   | Default: ${user.home}/.m2/repository-->
	<localRepository>D:/work/repository</localRepository>

将<localRepository>标签内容改为你想使用的目录。

### 在Eclipse中修改settings.xml位置。

打开Eclipse，Window菜单->Preference->Maven->User Settings，右侧User Settings改为刚刚的%MAVEN_HOME%/conf/settings.xml，然后点击Update，下方Local Repository便应该已经变成你刚刚配置的Repo目录了。

![img](http://xuchen.wang/img/mavenfolder.png)