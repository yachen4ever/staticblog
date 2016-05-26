title: Navicat连接Oracle数据库时提示不支持字符集ZHS16GBK的解决办法
date: 2016-03-02 11:37:18
tags:
- Navicat
- Oracle
- ZHS16GBK
- 数据库
categories: Study
description: 一直没有接触对于我这种个人用户来说很“臃肿的”Oracle，今天使用Navicat连接公司的Oracle数据库时，Navicat提示“unsupported server character set zhs16gbk”，我搜索了一些资料，将解决方法记录如下。
---

## 前言

一直没有接触对于我这种个人用户来说很“臃肿的”Oracle。而我平时管理数据库一直使用备受我雪推荐的Navicat。今天使用Navicat连接公司的Oracle数据库时，Navicat提示“unsupported server character set zhs16gbk”，我搜索了一些资料，将解决方法记录如下。

## 问题描述

### 软件版本
>* Navicat Premium 11.0
>* 服务器Oracle 10g

### 错误截图
当尝试使用Navicat连接数据库时，提示：
![img](http://xuchen.wang/img/navicatoracle1.png)

### 错误原因
ZHS16GBK是Oracle一种特有的中文字符集命名方式。Oracle提供了Oracle Call Interface（Oracle调用接口），而Navicat正是使用OCI去连接Oracle数据库。在Navicat菜单中选择“工具->选项->其他->OCI”，在右侧可以看到Navicat使用的OCI Library地址，如图所示。
![img2](http://xuchen.wang/img/navicatoracle2.png)
我安装的Navicat此配置为“..\Navicat Premium\instantclient_10_2\oci.dll”。

可以看到，此处OCI版本为10.2，而根据Oracle文档，OCI11以上版本才提供了zhs16gbk字符集支持。

### 解决办法
我们只需要下载最新版的Instant Client然后将Navicat的OCI路径修改一下就可以运行了。

Instant Client：http://www.oracle.com/technetwork/topics/winsoft-085727.html

下载后解压至Navicat Premium目录，路径设置为..\Navicat Premium\instantclient_12\OCI.dll。

至此，即可正常使用Navicat连接管理zhs16gbk编码的Oracle数据库。