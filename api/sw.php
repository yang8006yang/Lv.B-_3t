<?php
include_once "base.php";

$db=new DB($_POST['table']);

$row1=$db->find($_POST['id1']);
$row2=$db->find($_POST['id2']);

$tmp=$row1['rank'];
$row1['rank']=$row2['rank'];
$row2['rank']=$tmp;

$TRAILER->save($row1);
$TRAILER->save($row2);