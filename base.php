<?php

session_start();
date_default_timezone_set("Asia/Taipei");

class DB
{
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=db26";
    protected $table = "";
    protected $pdo;


    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, 'root', '');
    }

    public function find($id)
    {
        $sql = "select * from $this->table";

        if (is_array($id)) {
            $tmp = $this->arrayTOSqlArray($id);

            $sql = $sql . " where" . join(" && ", $tmp);
        } else {
            $sql = $sql . " where `id`='$id'";
        }

        // echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function all(...$arg)
    {
        $sql = "select * from $this->table";
        if (isset($arg[0])) {

            if (is_array($arg[0])) {
                $tmp = $this->arrayTOSqlArray($arg[0]);
                $sql = $sql . " where" . join(" && ", $tmp);
            } else {
                $sql = $sql . $arg[0];
            }
        }
        if (isset($arg[1])) {
            $sql = $sql . $arg[1];
        }
        // echo "<pre>";
        // echo $sql;
        // echo "</pre>";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function save($array)
    {
        if (isset($array['id'])) {
            $id = $array['id'];
            unset($array['id']);
            $tmp = $this->arrayTOSqlArray($array);
            $sql = "update $this->table set " . join(',', $tmp) . " where `id`='$id'";
            // echo $sql;
        } else {
            $cols = array_keys($array);
            $sql = "INSERT INTO `$this->table`(`" . join("`,`", $cols) . "`) VALUES ('" . join("','", $array) . "')";
        }

return $this->pdo->exec($sql);
    }
    public function del($id)
    {
        $sql = "delete from $this->table";

        if (is_array($id)) {
            $tmp = $this->arrayTOSqlArray($id);

            $sql = $sql . "where" . join(" && ", $tmp);
        } else {
            $sql = $sql . " where `id`='$id'";
        }


        return $this->pdo->exec($sql);
    }
    public function sum($col, ...$arg)
    {
        return $this->math('sum',$col,...$arg); //...為解構賦值
    }
    public function count(...$arg)
    {
        // if (isset($arg[0])) {
        //     $tmp = $this->arrayTOSqlArray($arg[0]);
        //     $sql = "select count(*) from $this->table where " . join("&", $tmp);
        // } else {
        //     $sql = "select count(*) from $this->table" ;
        // }
        // return $this->pdo->query($sql)->fetchColumn();

        return $this->math('count',...$arg);
    }
    public function max($col,...$arg)
    {
        return $this->math('sum', $col,...$arg);
    }
    public function min($col,...$arg)
    {
        return $this->math('min', $col,...$arg);
    }
    public function avg($col,...$arg)
    {
        return $this->math('avg', $col,...$arg);
    }

    private function arrayTOSqlArray($array)
    {
        foreach ($array as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }
        return $tmp;
    }

    private function math($math,...$arg){
        switch ($math) {
            case 'count':
                $sql = "select count(*) from $this->table";
                if(isset($arg[0])){
                    $con=$arg[0]; 
                }
                break;
            default:
                // $sql = "select $math($arg[0]) from $this->table";
                $col=$arg[0];
                if(isset($arg[1])){
                    $con=$arg[1];
                }
                $sql="select $math($col) from $this->table ";
        }
        if(isset($con)){
            if(is_array($con)){
                $tmp=$this->arrayToSqlArray($con);
                $sql=$sql . " where " .  join(" && ",$tmp);
            }else{
                $sql=$sql . $con;
            }
        }
        //echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }
}

function dd($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
function to($url)
{
    header("location:$url");
}
function qq($sql)
{
    $dsn = "mysql:host=localhost;charset=utf8;dbname=db26";
    $pdo = $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

$BOTTOM=new DB('bottom');
$TITLE=new DB('title');
$AD=new DB('ad');
$MVIM=new DB('mvim');
$IMG=new DB('img');
$ADMIN=new DB('admin');
$BOTTOM=new DB('bottom');
$NEWS=new DB('news');
$TOTAL=new DB('total');
$MENU=new DB('menu');
$USER=new DB('users');
$QUE=new DB('que');
$LOG=new DB('log');

if(!isset($_SESSION['total'])){
    $today=$TOTAL->find(['date'=>date("Y-m-d")]);
    if(empty($today)){
        $today=$TOTAL->save(['date'=>date("Y-m-d"),'total'=>1]);
    }else{
        $today['total']++;
    }
    $TOTAL->save($today);
    $_SESSION['total']=1;
}

