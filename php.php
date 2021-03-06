<?php

1、php中传值与传引用的区别
	传值就是copy赋值一份数据
		【打个比方，我有一橦房子，我给你建筑材料，你建了一个根我的房子一模一样的房子，你在你的房子做什么事都不会影响到我，我在我的房子里做什么事也不会影响到你，彼此独立。】
	例子： 	$param2=1;               //定义变量2    
		   	$param1 = &$param2;      //将变量2的引用传给变量1    
			echo $param2;            //显示为1    
			$param1 = 2;             //把2赋值给变量1    
			echo $param2;            //显示为2  

	传引用就是共用一值，类似于指针
		【打个比方，我有一橦房子，我给你一把钥匙，我们二个都可以进入这个房子，你在房子做什么都会影响到我。】
	例子：	$param2=1;               //定义变量2    
			$param1 = &$param2;      //将变量2的引用传给变量1    
			echo $param2;            //显示为1    
			$param1 = 2;             //把2赋值给变量1    
			echo $param2;            //显示为2

	选择使用时机:传值会很耗时间，特别是对于大型的字符串和对象来说，这将会是一个代价很大的操作,传送引用，函数内的任何操作等同于对传送变量的操作，传送大型变量时效率高！



2、foo()和@foo()之间有什么区别?
	@代表所有warning忽略

3、如何把一个GB2312格式的字符串装换成UTF-8格式？
	iconv('GB2312','UTF-8','你好我是需要转换的代码');

4、如果需要原样输出用户输入的内容，在数据入库前，要用哪个函数处理？
	htmlspecialchars或者htmlentities

5、安全对一套程序来说至关重要，请说说在开发中应该注意哪些安全机制？
	A、防远程提交；
	B、防SQL注入，对特殊代码进行过滤；
	C、防止注册机灌水，使用验证码；
	D、防止CSRF攻击；
	F、防止XSS攻击。

6、什么是锁？
	数据库是一个多用户使用的共享资源。当多个用户并发地存取数据时，在数据库中就会产生多个事务同时存取同一数据的情况。若对并发操作不加控制就可能会读取和存储不正确的数据，破坏数据库的一致性。

	加锁是实现数据库并发控制的一个非常重要的技术。当事务在对某个数据对象进行操作前，先向系统发出请求，对其加锁。加锁后事务就对该数据对象有了一定的控制，在该事务释放锁之前，其他的事务不能对此数据对象进行更新操作。

	基本锁类型：锁包括行级锁和表级锁

7、索引的作用？和它的优点缺点是什么？
	索引就一种特殊的查询表，数据库的搜索引擎可以利用它加速对数据的检索。它很类似与现实生活中书的目录，不需要查询整本书内容就可以找到想要的数据。索引可以是唯一的，创建索引允许指定单个列或者是多个列。缺点是它减慢了数据录入的速度，同时也增加了数据库的尺寸大小。

8、主键、外键和索引的区别？
	定义：
	主键--唯一标识一条记录，不能有重复的，不允许为空
	外键--表的外键是另一表的主键, 外键可以有重复的, 可以是空值
	索引--该字段没有重复值，但可以有一个空值

	作用：
	主键--用来保证数据完整性
	外键--用来和其他表建立联系用的
	索引--是提高查询排序的速度

	个数：
	主键--主键只能有一个
	外键--一个表可以有多个外键
	索引--一个表可以有多个唯一索引

9、简述 private、 protected、 public修饰符的访问权限。 
	private : 私有成员, 在类的内部才可以访问。 
	protected : 保护成员，该类内部和继承类中可以访问。
	public : 公共成员，完全公开，没有访问限制。

10、常用的魔术方法有哪些？举例说明
	php规定以两个下划线（__）开头的方法都保留为魔术方法，所以建议大家函数名最好不用__开头，除非是为了重载已有的魔术方法。 
	__construct() 实例化类时自动调用。
	__destruct() 类对象使用结束时自动调用。
	__set() 在给未定义的属性赋值的时候调用。
	__get() 调用未定义的属性时候调用。
	__isset() 使用isset()或empty()函数时候会调用。
	__unset() 使用unset()时候会调用。
	__sleep() 使用serialize序列化时候调用。
	__wakeup() 使用unserialize反序列化的时候调用。
	__call() 调用一个不存在的方法的时候调用。
	__callStatic()调用一个不存在的静态方法是调用。
	__toString() 把对象转换成字符串的时候会调用。比如 echo。
	__invoke() 当尝试把对象当方法调用时调用。
	__set_state() 当使用var_export()函数时候调用。接受一个数组参数。
	__clone() 当使用clone复制一个对象时候调用

11、$this和self、parent这三个关键词分别代表什么？在哪些场合下使用？
	$this  当前对象
	self   当前类
	parent 当前类的父类

	$this在当前类中使用,使用->调用属性和方法
	self也在当前类中使用，不过需要使用::调用
	parent在类中使用、


12、PHP遍历文件夹下所有文件
	function read_all($dir){
	    if(!is_dir($dir)) return false;
	    $handle = opendir($dir);
	    if($handle){
	        while(($fl = readdir($handle)) !== false){
	            $temp = $dir.$fl;
	            //$fl !='.' && $fl != '..' 排除当前目录及父级目录
	            if(is_dir($temp) && $fl!='.' && $fl != '..'){
	                echo '目录：'.$temp.'<br>';
	                read_all($temp);
	            }else{
	                if($fl !='.' && $fl != '..'){
	                    echo '文件：'.$temp.'<br>';
	                }
	            }
	        }
	    }
	}
	read_all("./dir/");


13、php信息通过一些简单的命令来获取
	php -v 显示当前PHP版本
	php -m 显示当前php加载的有效模块
	php -i 输出无html格式的phpinfo
	php --rf function 

14、对于大流量的网站，您采用什么样的方法来解决各页面访问量统计问题。
	A、确认服务器是否能支撑当前访问量；
	B、优化数据库访问；
	C、禁止外部访问链接（盗链）, 比如图片防盗链；
	D、控制文件下载，尤其是大文件；
	E、使用不同主机分流（负载均衡）；
	F、使用浏览统计软件，了解访问量，有针对性的进行优化。

15、MySQL数据库作发布系统的存储，一天五万条以上的增量，预计运维三年,怎么优化？
	A、设计良好的数据库结构，允许部分数据冗余，尽量避免join查询，提高效率；
	B、选择合适的表字段数据类型和存储引擎，适当的添加索引；
	C、mysql库主从读写分离；
	D、找规律分表，减少单表中的数据量提高查询速度；
	E、添加缓存机制，比如memcached，redis等；
	F、不经常改动的页面，生成静态页面；
	G、书写高效率的SQL。比如 SELECT * FROM TABEL 改为 SELECT field_1, field_2, field_3 FROM TABLE。


16、//删除数组的第一个元素并返回值
	array_shift($path_arr);


17、在laravel中两种写法
	//判断线别是否存在
        if ($request->filled('track_line_id')) {
            $TrackLineSubIds = TrackLineSub::query()
                ->where('track_line_id', $request->track_line_id)
                ->pluck('id')->toArray();//获取该线别下的轨道线id数组
            $where_in = implode(",", $TrackLineSubIds);
            $page->whereRaw("(from_track_line_sub_id in ($where_in)) or (end_track_line_sub_id in ($where_in))");
        }



	if ($request->filled('track_line_id')) {
            $TrackLineSubIds = TrackLineSub::query()
                ->where('track_line_id', $request->track_line_id)
                ->pluck('id')->toArray();//获取该线别下的轨道线id数组
          $page->where(function($query) use($TrackLineSubIds){
                $query->whereIn('from_track_line_sub_id', $TrackLineSubIds)
                    ->orwhereIn('end_track_line_sub_id', $TrackLineSubIds);
            });
        }

//查询时  使用闭包增减筛选条件
DB::table('users as u')
->select('u.user_id','c.class')
->leftJoin('class as c', function($join)
{
    $join->on('c.user_id', '=', 'u.user_id')
    ->on('c.status', '=', '2');
})
->get();