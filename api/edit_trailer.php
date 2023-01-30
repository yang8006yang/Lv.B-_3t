<?php

include_once "base.php";

foreach ($_POST['id'] as $key=>$id) {
    if(isset($_POST['del']) && in_array($id, $_POST['del'])){
        $TRAILER->del($id);
    }else{
        $row=$TRAILER->find($id);
        $row['name']=$_POST['name'][$key];
        $row['sh']=(isset($_POST['sh']) && in_array($id, $_POST['sh']))?1:0;
        $row['ani']=$_POST['ani'][$key];

        $TRAILER->save($row);
    }
}
to("../back.php?do=trailer");