<?php 

class Sql{
	private $host;
	public $name;
	private $pass;
	private $port;
	private $dbname;
	private $link;
	private $charset;
	public function __construct(array $info=array()){
		$this->host=$this->host?? 'localhost';
		$this->name=$this->name?? 'root';
		$this->pass=$this->pass?? 'Shazhuben123!@#';
		$this->port=$this->port?? '3306';
		$this->dbname=$this->dbname?? 'demommm';
		$this->charset=$this->charset?? 'utf8';
		$this->sql_connect();
		$this->sql_charset();
	}
	//连接数据库
	private function sql_connect(){
		$this->link=@new mysqli($this->host,$this->name,$this->pass,$this->dbname,$this->port);
		if($this->link->connect_error){
			die('Connect Error'.$this->link->connect_error);
		}
	}
	//设定字符集
	private function sql_charset(){
		$sql="set names {$this->charset}";
		$res=$this->link->query($sql);
		if(!$res){
			die('Charset Error'.$this->link->error);
		}
	}
	//记录最后一条自增长ID
	private $last_id;
	//增删改操作
	private $affected_rows;//受影响的行数  
	public function sql_exec($sql){
		$res=$this->link->query($sql);
		if(!$res){
			die('Sql Error'.$this->link->error);
		}
		$this->affected_rows=$this->link->affected_rows;
		$this->last_id=$this->link->insert_id;
		return $res;
	}
	//记录查询条数
	private $num_row;
	//查询单条记录

	public function sql_find($sql){
		$res=$this->link->query($sql);
		if(!$res){
			die('Sql Error'.$this->link->error);
		}
		$this->num_rows=$res->num_rows;

		
		return $res->fetch_assoc();
	}
	//查询多条记录
	public function sql_select($sql){
		$res=$this->link->query($sql);
		
		if(!$res){
			die('Sql Error'.$this->link->error);
		}
		$this->num_rows=$res->num_rows;
		return $res->fetch_all(MYSQLI_ASSOC);
	}
	//控制权限
	public function __get($key){
		$allow=array('last_id','affected_rows','num_row');
		if(in_array($key,$allow)){
			return $this->$key;
		}
		return false;
	}
	


}
$s=new Sql();
$res=$s->sss;
var_dump($res);

