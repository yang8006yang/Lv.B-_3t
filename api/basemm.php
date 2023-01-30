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
        
    }
}

?>