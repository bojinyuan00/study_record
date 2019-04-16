<?php
    header("content-type:text/html;charset=utf8");
    function xor_enc($str,$key)
    {
        $crytxt = '';
        $keylen = strlen($key);
        
        for($i=0;$i<strlen($str);$i++)
        {   
            $k = $i%$keylen;
            $crytxt .= $str[$i] ^ $key[$k];
        }
        return $crytxt;
    }

    $str = "*******"; 
    $key = "pwd";
    $crytxt = xor_enc($str,$key); 
    echo "加密后->".$crytxt; 
    echo "<br>"; 
    echo "解密后->".xor_enc($crytxt,$key);

?>



<?php
	  	echo '<meta charset="utf-8">';
	  	$str='世界，你好';  
	    function jiami($str,$key){
		   $key=md5($key);
		   $k=md5(rand(0,100));//相当于动态密钥
		   $k=substr($k,0,3);
		   $tmp="";
		   for($i=0;$i<strlen($str);$i++){
		    	$tmp.=substr($str,$i,1) ^ substr($key,$i,1);
		   }
		   return base64_encode($k.$tmp);
	    }  
	  	function jiemi($str,$key){
		   $len=strlen($str);
		   $key=md5($key);
		   $str=base64_decode($str);
		   $str=substr($str,3,$len-3);
		   $tmp="";
		   for($i=0;$i<strlen($str);$i++){
		    	$tmp.=substr($str,$i,1) ^ substr($key,$i,1);
		   }    
		   return $tmp;
	  	}  
		$key='cc';
		$jh=jiami($str, $key);
		echo '加密前：'.$str.'<br>';
		echo '加密后：'.$jh.'<br>';
		echo '解密后：'.jiemi($jh, $key).'<br>';
		