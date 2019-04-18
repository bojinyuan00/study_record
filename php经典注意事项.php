<?php
1、  数据表类型有哪些
       MyISAM、InnoDB、HEAP、BOB,ARCHIVE,CSV等
       MyISAM：成熟、稳定、易于管理，快速读取。一些功能不支持（事务等），表级锁。
       InnoDB：支持事务、外键等特性、数据行锁定。空间占用大，不支持全文索引等。


2、  防sql注入方法
      mysql_escape_string(strip_tags($arr["$val"]));

	/**
	* 函数名称：post_check() 
	* 函数作用：对提交的编辑内容进行处理 
	* 参　　数：$post: 要提交的内容 
	* 返 回 值：$post: 返回过滤后的内容 
	*/
	function post_check($post){
	if(!get_magic_quotes_gpc()){// 判断magic_quotes_gpc是否为打开 
	$post = addslashes($post);// 进行magic_quotes_gpc没有打开的情况对提交数据的过滤 
	}
	$post = str_replace("_","\_",$post);// 把 '_'过滤掉
	$post = str_replace("%","\%",$post);// 把 '%'过滤掉
	$post = nl2br($post);// 回车转换 
	$post =htmlspecialchars($post);// html标记转换 
	 
	return $post;
	}


3、  MySQL把一个大表拆分多个表后,如何解决跨表查询效率问题?
	大表分表后每个表的结构相同，可以用sql的union
	(SELECT xx FROM table1 WHERE type=1) union
	(SELECT xx FROM table1 WHERE type=1) union
	(SELECT xx FROM table1 WHERE type=1) union
	(SELECT xx FROM table1 WHERE type=1)

	SELECT xxx FROM (
	    (SELECT xx FROM table1 WHERE type=1) union
	    (SELECT xx FROM table1 WHERE type=1) union
	    (SELECT xx FROM table1 WHERE type=1) union
	    (SELECT xx FROM table1 WHERE type=1) 
	) t WHERE t.xxx....

	还可以建一张主表将你要连表查询的字段放在其中，做好索引；你还记录下用户经常查询的条件，把查出的数据缓存，以便用户经常调用


4、  索引应用
        什么情况下考虑索引
        什么情况不适合索引
        一个语句是否用到索引如何判断
        经常发生的用不到索引的场景：
                like '%.....'
                数据类型隐式转换
                or 关键字加其它条件约束
       全文索引：
                只能用于MYIsAM表，在CHAR,VARCHAR,TEXT类型的列上创建。


5、  当客户端禁用cookie，可以通过以下几种方式改变session对客户端cookie的依赖，使session抛开客户端cookie
	设置php.ini中的session.use_trans_sid = 1或者编译时打开了--enable-trans-sid选项，让PHP自动跨页传递session id。当session.use_trans_sid为有效时，session.use_only_cookies一定要设置为无效0。

　　　　手动通过URL传值、隐藏表单传递session id。

　　　　用文件、数据库等形式保存session_id,在跨页过程中手动调用。

　　　　改变session客户端ID保存方式：

　　　　　　session.use_cookies //控制客户端保存SessionID时使用哪一种方式，当它为“1”时，就说明启动了session cookie（初始值为1）

　　　　　　可以使用上面我们提到的函数来查询得到目前的session id：echo $_COOKIE["PHPSESSID"];

　　　　　　但是，如果client的浏览器不支持cookie的话，即使session.use_cookies这个参数的值等于“1”，用上述的查询也只会得到null。

　　　　　　php.ini中两个和该选项相关的配置参数：

　　　　　　　　session.use_cookies = 1  //是否使用cookies(默认值为1)
　　　　　　　　session.use_only_cookies=1//为1时只使用cookie；为0时可使用cookie和其它方式，这时如果客户端cookie可用，则session还是默认用cookie(默认值为1)

　　　　　　注意：如果客户的浏览器是支持cookie的，强烈推荐“session.use_only_cookies = 1”，当session.use_only_cookies为有效时，即使想通过URL来传递session id也会被认为无效，这样可以减少通过sessionid被攻击的可能性。

　　　　　　在php代码页面中设置方式：

　　　　　　       ini_set('session.use_cookies','1');
　　　　　　　　　　ini_set('session.use_only_cookies','1');　　


		php.ini 文件中还有两个选项

	session.use_cookies表示是否开始基于cookies的session会话
	session.use_only_cookies 表示是否只开启基于cookies的session的会话方式

	所以如果想要在浏览器开启cookie的时候用基于cookie的方式，在未开启cookie的时候使用url的方式就进行如下设置（最常用的方式，推荐）
	在php.ini文件中：
	session.use_trans_sid=1
	session.use_only_cookies=0
	session.use_cookies=1
	或者 在php程序中
	ini_set("session.use_trans_sid","1″);
	ini_set("session.use_only_cookies",0);
	ini_set("session.use_cookies",1);

	如果不管浏览器是否开启cookie，都使用url的方式就进行如下设置（这个例子主要想说明一下设置session.use_only_cookies 和 session.use_cookies的区别）
	在php.ini文件中
	session.use_trans_sid=1
	session.use_only_cookies=0
	session.use_cookies=0
	或者 在php程序中
	ini_set("session.use_trans_sid","1″);
	ini_set("session.use_only_cookies",0);
	ini_set("session.use_cookies",0);
	动手自己试一试 你就会明白session.use_only_cookies 和 session.use_cookies的区别。　　　　



6、  关于用户登录状态存session,cookie还是数据库或者memcache的优劣
	session中保存登陆状态：
	优：整个应用可以从session中获取用户信息,并且查询时很方便.在session中保存用户信息是不可缺少的(web应用中)
	缺:session中不宜保存大量信息,会增减内存消耗量

	cookie中保存登陆状态：
	优:数据保存在客户端,方便用户下次登录.如：”记住我“功能
	缺:安全性不高,一般都是讲数据加密后保存在cookie中

	memcache应用主要体现在对大量数据的cache,如:将经常用到的数据保存在memcache中,减少对数据库的访问次数,在web应用中也是不可缺少的
	缺:当cache爆掉后,造成数据丢失

	从效率考虑：cookie > memcache > 数据库
	cookie对服务器端负载没影响，如果加密、解密会多消耗一点点cpu。带宽倒是会消耗得多一点，同域名下的所有http request header都会附带cookie，所以在大流量下，把js、css、图片放到另外一个域名下会节约掉这部分流量。
	memcache会占用一些服务器内存
	数据库连接本来就是典型的瓶颈，能免则免

	从安全性考虑：memcache/数据库 > cookie
	cookie存放在客户端，需要考虑的安全性比较多一点
	memcache、数据库都在服务器端，相对cookie来说会稍微安全点

	从服务器可扩展性考虑：cookie > memcache/数据库
	如果有多台后端服务器，就需要共享session数据
	memcache、数据库都可以做到在多台服务器之间共享session，但是容易形成单点瓶颈，大负载下需要考虑存储路由之类
	cookie完全不需要在服务器端共享session数据，与REST无状态风格暗合


7、 SQL语言共分为四大类：
	数据查询语言DQL，数据操纵语言DML， 
	数据定义语言DDL，数据控制语言DCL。 

	数据查询语言DQL Q = Query 
	数据查询语言DQL用于检索数据库
	基本结构是由SELECT子句，FROM子句，WHERE子句组成的查询块： 
	SELECT <字段名表> 
	FROM <表或视图名> 
	WHERE <查询条件>


	数据操纵语言DML M = Manipulation 
	数据操纵语言DML用于改变数据库数据
	主要有三种形式： 
	1) 插入：INSERT 
	2) 更新：UPDATE 
	3) 删除：DELETE 


	数据定义语言DDL D = Definition
	数据定义语言DDL用于建立，修改，删除数据库中的各种对象-----表、视图、 
	索引、同义词、聚簇等如： 
	CREATE TABLE/VIEW/INDEX/SYN/CLUSTER 
	| | | | | 
	表 视图 索引 同义词 簇 


	数据控制语言DCL（自动提交事务） 
	数据控制语言DCL用来授予或回收访问数据库的某种特权，并控制 
	数据库操纵事务发生的时间及效果，对数据库实行监视等。
	包含两条命令： 
	1) GRANT：授权。
	2）REVOKE：撤回。

	提交数据有三种类型：显式提交、隐式提交及自动提交。下面分 
	别说明这三种类型。 
	(1) 显式提交 
	用COMMIT命令直接完成的提交为显式提交。其格式为： 
	SQL>COMMIT； 
	(2) 隐式提交 
	用SQL命令间接完成的提交为隐式提交。这些命令是： 
	ALTER，AUDIT，COMMENT，CONNECT，CREATE，DISCONNECT，DROP， 
	EXIT，GRANT，NOAUDIT，QUIT，REVOKE，RENAME。 
	(3) 自动提交 
	若把AUTOCOMMIT设置为ON，则在插入、修改、删除语句执行后， 
	系统将自动进行提交，这就是自动提交。其格式为： 
	SQL>SET AUTOCOMMIT ON；


8、  session跨域共享解决方案
	方式一：
	打开 php.ini 文件，修改下面两个参数：
	session.save_handler = memcache
	session.save_path = "tcp://Mem服务器1:端口号,tcp://Mem服务器2:端口号..." 

	方式二：
	在 php 文件中使用 ini_set 函数，进行配置，此方法会解决共享服务器的 php 的配置问题
	ini_set("session.save_handler", "memcache");
	ini_set("session.save_path", "tcp://Mem服务器1:端口号,tcp://Mem服务器2:端口号...");


9、 PHP连接MySQL数据库用到的三种API
	1、PHP的MySQL扩展
	2、PHP的mysqli扩展
	3、PHP数据对象(PDO)	


10、 php中的长连接和短连接
	长连接==》服务器主动推动消息   一般用于静态网页
	短连接==》请求连接再获取		一般用于动态网页


11、 单例模式
	实际项目中像数据库查询，日志输出，全局回调，统一校验等模块。这些模块功能单一，但需要多次访问，如果能够全局唯一，多次复用会大大提升性能。这也就是单例存在的必要性。
	好处 :减少频繁创建，节省了cpu。
		：静态对象公用，节省了内存。
		：功能解耦，代码已维护
	写法：	私有静态属性，又来储存生成的唯一对象
			私有构造函数
			私有克隆函数，防止克隆——clone
			公共静态方法，用来访问静态属性储存的对象，如果没有对象，则生成此单例
	代码：  

	class SingleInstance{
        private function _construct(){
            
        }
       private static $instance;
       
       private function _clone(){ 
       }
       public static function getInstance(){
           if(!self::$instance instanceof SingleInstance){
               self::$instance=new SingleInstance();
           }
           return self ::$instance;
       }
    }




