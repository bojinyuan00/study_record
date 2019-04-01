<?php
'//参考网址==>https://blog.csdn.net/zhanghao143lina/article/details/78925453       http://www.bkjia.com/jingyan/471187.html
'表单重复提交是在多用户Web应用中最常见、带来很多麻烦的一个问题。有很多的应用场景都会遇到重复提交问题，比如：

点击提交按钮两次。
点击刷新按钮。
使用浏览器后退按钮重复之前的操作，导致重复提交表单。
使用浏览器历史记录重复提交表单。
浏览器重复的HTTP请求。

用户提交表单时可能因为网速的原因，或者网页被恶意刷新，致使同一条记录重复插入到数据库中，这是一个比较棘手的问题。我们可以从客户端和服务器端一起着手，设法避免同一表单的重复提交。下面帮客之家收集了8种常见的有效防止表单重复提交的方法：来源www.bkjia.com



'1、js禁掉提交按钮。'

表单提交后使用Javascript使提交按钮disable。这种方法防止心急的用户多次点击按钮。但有个问题，如果客户端把Javascript给禁止掉，这种方法就无效了。


我之前的文章曾说过用一些Jquery插件效果不错。参考：js防止表单重复提交的方法和代码

 

'2、使用Post/Redirect/Get模式。'

在提交后执行页面重定向，这就是所谓的Post-Redirect-Get (PRG)模式。简言之，当用户提交了表单后，你去执行一个客户端的重定向，转到提交成功信息页面。

这能避免用户按F5导致的重复提交，而其也不会出现浏览器表单重复提交的警告，也能消除按浏览器前进和后退按导致的同样问题。

 

'3、在session中存放一个特殊标志。'

在服务器端，生成一个唯一的标识符，将它存入session，同时将它写入表单的隐藏字段中，然后将表单页面发给浏览器，用户录入信息后点击提交，在服务器端，获取表单中隐藏字段的值，与session中的唯一标识符比较，相等说明是首次提交，就处理本次请求，然后将session中的唯一标识符移除；不相等说明是重复提交，就不再处理。

这使你的web应用有了更高级的XSRF保护。

请见如下代码：

[html] view plain copy
<?php  
session_start();  
//根据当前SESSION生成随机数  
$code = mt_rand(0,1000000);  
$_SESSION['code'] = $code;  
?>  
在页面表单上将随机数作为隐藏值进行传递，代码如下：  
<input type="hidden" name="originator" value="<?=$code?>">  
   
    在接收页面的PHP代码如下：  
   
<?php  
session_start();  
if(isset($_POST['originator'])) {  
if($_POST['originator'] == $_SESSION['code']){  
// 处理该表单的语句，省略  
}else{  
echo ‘请不要刷新本页面或重复提交表单！’;  
}  
}  
?>  
<? php
'4．使用header函数转向'

除了上面的方法之外，还有一个更简单的方法，那就是当用户提交表单，服务器端处理后立即转向其他的页面，代码如下所示。

if (isset($_POST['action']) && $_POST['action'] == 'submitted') {

//处理数据，如插入数据后，立即转向到其他页面

header('location:submits_success.php');

}

这样，即使用户使用刷新键，也不会导致表单的重复提交，因为已经转向新的页面，而这个页面脚本已经不理会任何提交的数据了。

'5.表单过期的处理'

在开发过程中，经常会出现表单出错而返回页面的时候填写的信息全部丢失的情况，为了支持页面回跳，可以通过以下两种方法实现。

'5.1．使用header头设置缓存控制头Cache-control。'

header('Cache-control: private, must-revalidate'); //支持页面回跳

'5.2．使用session_cache_limiter方法。'

session_cache_limiter('private, must-revalidate'); //要写在session_start方法之前

下面的代码片断可以防止用户填写表单的时候，单击“提交”按钮返回时，刚刚在表单上填写的内容不会被清除：

session_cache_limiter('nocache');

session_cache_limiter('private');

session_cache_limiter('public');

session_start();

//以下是表单内容，这样在用户返回该表单时，已经填写的内容不会被清空

将该段代码贴到所要应用的脚本顶部即可。

Cache-Control消息头域说明
Cache-Control指定请求和响应遵循的缓存机制。在请求消息或响应消息中设置Cache-Control并不会修改另一个消息处理过程中的缓存处理过程。

请求时的缓存指令包括no-cache、no-store、max-age、max-stale、min-fresh和only-if-cached，响应消息中的指令包括public、private、no-cache、no-store、no-transform、must-revalidate、proxy-revalidate和max-age。各个消息中的指令含义如表5-3所示。

表5-3

缓存指令

说 明

public

指示响应可被任何缓存区缓存

private

指示对于单个用户的整个或部分响应消息，不能被共享缓存处理。这允许服务器仅仅描述当用户的部分响应消息，此响应消息对于其他用户的请求无效

no-cache

指示请求或响应消息不能缓存

no-store

用于防止重要的信息被无意的发布。在请求消息中发送将使得请求和响应消息都不使用缓存

max-age

指示客户机可以接收生存期不大于指定时间（以秒为单位）的响应

min-fresh

指示客户机可以接收响应时间小于当前时间加上指定时间的响应

max-stale

指示客户机可以接收超出超时期间的响应消息。如果指定max-stale消息的值，那么客户机可以接收超出超时期指定值之内的响应消息

有关Session和Cookie的介绍，详细内容请参阅第10章“PHP会话管理”。

'6.判断表单动作的技巧'

表单可以通过同一个程序来分配应该要处理的动作，在表单中有不同的逻辑，要怎么判别使用者按下的按钮内容不过是个小问题。

其实只要通过提交按钮的name 就可以知道了，表单在提交出去的时候，只有按下的submit类型的按钮才会被送到表单数组去，所以只要判断按钮的值就可以知道使用者按下哪一个按钮，以如下表单为例：

<FORM method="POST" Action=test.php>

<input type=submit name="btn" value="a">

<input type=submit name="btn" value="b">

</FORM>

当使用者按下“a”按钮的时候btn=a，按下“b”按钮，则btn=b。

另外也可以通过提交按钮的名字（name）来判断，请见如下代码：

<FORM method="POST" Action=test.php>

<input type=submit name="a" value="提交A">

<input type=submit name="b" value="提交B">

</FORM>

这样只要POST/GET的参数里面有a或b，就可以知道按下的按钮是哪个。
?>
<?php

print_r($_POST);

?>

<? php 

'7、在数据库里添加约束。'

在数据库里添加唯一约束或创建唯一索引，防止出现重复数据。这是最有效的防止重复提交数据的方法。

你是如何克服数据重复提交问题的？你遇到过什么重复提交数据的现实例子吗？

转载自：http://www.bkjia.com/jingyan/471187.html

5.使用客户端脚本

提到客户端脚本，经常使用的是JavaScript进行常规输入验证。在下面的例子中，我们使用它处理表单的重复提交问题，请看下面的代码：

<form method="post" name="register" action="test.php" enctype="multipart/form-data">

<input name="text" type="text" id="text" />

<input name="cont" value="提交" type="button" onClick="document.register.cont.value='正在提交,请等待...';document.register.cont.disabled=true;document.the_form.submit();">

</form>

当用户单击“提交”按钮后，该按钮将变为灰色不可用状态。

上面的例子中使用OnClick事件检测用户的提交状态，如果单击了“提交”按钮，该按钮立即置为失效状态，用户不能单击按钮再次提交。

 

'8.使用Cookie处理'

使用Cookie记录表单提交的状态，根据其状态可以检查是否已经提交表单，请见下面的代码：

if(isset($_POST['go'])){

setcookie("tempcookie","",time()+30);

header("Location:".$_SERVER[PHP_SELF]);

exit();

}

if(isset($_COOKIE["tempcookie"])){

setcookie("tempcookie","",0);

echo "您已经提交过表单";

}

?>