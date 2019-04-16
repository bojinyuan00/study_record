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
