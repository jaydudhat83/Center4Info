<?php
$data=$_GET['id'];
$receiv=$_COOKIE['user'];
$found=0;
$length=strlen($data);
$dt=mysqli_connect("localhost","root","","Center4Info") or die();
$db=mysqli_query($dt,"SELECT `userid`,`fname`,`lname` FROM login WHERE `userid`<>'$receiv'");
$tdata="";

$req=mysqli_query($dt,"SELECT `sender` FROM request WHERE `receiver`='$receiv' AND `status`='0'");
$re=mysqli_query($dt,"SELECT `receiver` FROM request WHERE `sender`='$receiv' AND `status`='0'");
$reque=mysqli_query($dt,"SELECT `sender`,`receiver` FROM request WHERE (`receiver`='$receiv' OR `sender`='$receiv') AND `status`='1'");

foreach($db as $usid){
	$id=$usid['userid'];
	$fn=$usid['fname'];
	$ln=$usid['lname'];
if(stristr($data,substr($fn, 0,$length))){
	$flag=0;
	foreach ($req as $sendr) {
		if($sendr['sender']==$id)
		{
            $flag=1;
		}
	}
	foreach ($re as $receiver) {
		if($receiver['receiver']==$id)
		{
            $flag=2;
		}
		
	}
	foreach ($reque as $receiver) {
		if($receiver['receiver']==$id||$receiver['sender']==$id)
		{
            $flag=3;
		}
		
	}
	if($flag==0)
	{
     $found=1;
     $tdata=$tdata."<tr><td class=row>$fn $ln</td><td class=row>$id</td><td class=row><form method=post action=index.php?rec=$id><input type=submit name=send value=send id=abtn></form></td></tr>";
    }
    else if($flag==1){
     $found=1;
     $tdata=$tdata."<tr><td class=row>$fn $ln</td><td class=row>$id</td><td class=row><form method=post action=index.php?rec=$id><input type=submit name=accept value=accept id=abtn></form></td></tr>";
    }
    else if($flag==2){
     $found=1;
     $tdata=$tdata."<tr><td class=row>$fn $ln</td><td class=row>$id</td><td class=row>Request Sent</td></tr>";
    }
}
}

if($found==1){
	echo "<table class=searchtbl>$tdata</table>";
}
else{
	echo "no match found";
}

?>
<?php

?>