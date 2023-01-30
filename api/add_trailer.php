<?php
include_once "base.php";

if(isset($_FILES['img']['tmp_name'])){
    move_uploaded_file($_FILES['img']['tmp_name'],"../upload/".$_FILES['img']['name']);
    $rank=$TRAILER->max('rank')+1;
    $TRAILER->save(['name'=>$_POST['name'],
                    'img'=>$_FILES['img']['name'],
                    'sh'=>1,
                    'rank'=>$rank,
                    'ani'=>rand(1,3)]);
};


to("../back.php?do=trailer");