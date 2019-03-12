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
5、  $sql = "select * from user";           ==>准备sql语句
6、  $res = mysqli_query($link , '$sql');   ==>发送sql语句
7、  $result = mysqli_fetch_assoc($res);    ==>获取和处理结果集
       var_dump($result);
8、  Mysqli_close($link);                   ==>关闭数据库


对于mysql的结果集获取这里，可以采用
	While($rows = mysqli_fetch_assoc($obj)){
		var_dump($rows);
	}

对于mysql的结果集获取这里，可以采用
While($rows = mysqli_fetch_assoc($obj)){
Var_dump($rows);
}
$res = mysqli_fetch_assoc($obj);   ==>返回的是关联数组
$res = mysqli_fetch_row($obj);    ==>返回的是索引数组
$res = mysqli_fetch_array($obj);   ==>返回的是索引关联数组
$res = mysqli_num_rows($obj);   ==>返回的是数据的条数
Mysqli_affected_rows($link);==>返回 修改、删除、添加时受影响的行数
mysqli_insert_id($link);==>返回当前插入数据的自增id值


关于分页的代码实现可参考
	php_record  ==>  php基础  ==>Php数据库.docx 文件内的具体分页逻辑

