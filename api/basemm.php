<?php
date_default_timezone_set("Asia/Taipei");
session_start();

class DB{
    protected $dsn= "mysql:host=localhost;charset=utf8;dbname=db36";
    protected $table='';
    protected $pdo='';

    protected function __construct($table)
    {
        $this->table=$table;
        $this->pdo=new pdo($this->dsn,'root','');
    }

    private function arrayTOSqlArray($array){
        foreach($array as $key => $vaule){
            $tmp[]="`$key`='$vaule'";
        }
        return $tmp;
    }

    public function find($id){
        $sql= "SELECT * from $this->table WHERE ";
        if(is_array($id)){
            $tmp=$this->arrayTOSqlArray($id);
            $sql= $sql . join('&&',$tmp);
        }else{
            $sql= $sql . "`id`=$id";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    
    public function all(...$arg){
        $sql= "SELECT * from $this->table ";
        if(isset($arg[0])){
            if(is_array($arg[0])){
                $tmp=$this->arrayTOSqlArray($arg[0]);
                $sql= $sql ."WHERE ". join('&&',$tmp);    
            }else{
                $sql= $sql .$arg[0];
            }
        }
        if(isset($arg[1])){
            $sql= $sql .$arg[1];
        }
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($array){
        if(isset($array['id'])){
            $id= $array['id'];
            unset($array['id']);
            $tmp= $this->arrayTOSqlArray($array);
            $sql= "UPDATE $this->table SET ". join(',',$tmp). "WHERE id=`$id`";
        }else{
            $cols= array_keys($array);
            $sql="INSERT INTO `$this->table` (`". join('`,`',$cols) . "`) VALUES ('". join("','",$array) . "')";
        }
        return $this->pdo->exec($sql)
    }

}

?>