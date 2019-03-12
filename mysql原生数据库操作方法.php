<?php
//Php连接数据库

1、连接数据库
2、判断是否连接成功
3、设置字符集
4、选择数据库
5、准备sql语句
6、发送sql语句
7、处理结果集
8、关闭数据库（释放资源）

1、  $link = mysqli_connect('localhost' , 'root' , 'root');  ==>连接数据库
     Var_dump($link);
2、  If(!link){
       exit('数据库连接失败');
    }                                      ==>判断是否连接成功
3、  mysqli_set_charset($link , 'utf8');   ==>设置字符集
4、  mysqli_select_db($link , 'qzo4');      ==>选择数据库
5、  $sql = “select * from user”;           ==>准备sql语句
6、  $res = mysqli_query($link , '$sql');   ==>发送sql语句
7、  $result = mysqli_fetch_assoc($res);    ==>获取和处理结果集
       var_dump($result);
8、  Mysqli_close($link);                   ==>关闭数据库


