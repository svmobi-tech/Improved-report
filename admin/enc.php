<?php

function Encrypt($data, $secret)
{    
  //Generate a key from a hash
  $key = md5(utf8_encode($secret), true);

  //Take first 8 bytes of $key and append them to the end of $key.
  $key .= substr($key, 0, 8);

  //Pad for PKCS7
  $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
  $len = strlen($data);
  $pad = $blockSize - ($len % $blockSize);
  $data .= str_repeat(chr($pad), $pad);

  //Encrypt data
  $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb');

	echo base64_encode($encData);
  return base64_encode($encData);

}

function Decrypt($data, $secret)
{

    //Generate a key from a hash
    $key = md5(utf8_encode($secret), true);

    //Take first 8 bytes of $key and append them to the end of $key.
    $key .= substr($key, 0, 8);

    $data = base64_decode($data);

    $data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');

    $block = mcrypt_get_block_size('tripledes', 'ecb');
    $len = strlen($data);
    $pad = ord($data[$len-1]);
	echo substr($data, 0, strlen($data) - $pad);
    return substr($data, 0, strlen($data) - $pad);
}

 $secret = "989177778100009891777781";
    $data='YMwWikWlZsOyhuYC0VqI3w%253D%253D' ;
	decrypt($data,$secret);


?>