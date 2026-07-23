<?php 



$mail=mail('mehul.gediya@loop360.co','test','test','From: jay.doshi@loop360.co');
if(!$mail)
{
	echo "Error";
}
else
{
	echo "Success";
}


?>