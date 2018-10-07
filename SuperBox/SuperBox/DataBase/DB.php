<?php
namespace SuperBox\DataBase;
use \SuperBox\Registry\ApplicationRegistry;
class DB{
	private $pdo;   //PDO对象
	private $table; //数据表
	private $where; //where方法
	private $fields="*"; //field方法
    private $limit;   //limit方法
    private $order="ORDER BY id ASC";   //order方法
	private function __construct($table){
		try{
			$this->table=$table;
			//从注册表单例类中 获取 配置信息 PDO参数(dsn,数据库账号，密码);
			$dsn=ApplicationRegistry::getDSN();
			$user=ApplicationRegistry::getUSER();
			$pass=ApplicationRegistry::getPASS();
			$pdo=new \PDO($dsn,$user,$pass);
			$pdo->query("SET NAMES UTF8");
			$this->pdo=$pdo;	
		}
		catch(\PDOException $e){
			echo $e->getMessage();
		}
	}
	static function table($table){
		return new self($table);
	}
	//insert新增数据(成功：返回新增记录的id，失败：返回0);
	public function insert($data){
	    //获取$data下标 组成 数组；
        $keys=array_keys($data);
        $fields=implode(",",$keys);
        foreach($data as $key=>$value){
            $data[$key]="'".$value."'";
        }
        $values=implode(",",$data);
        $sql="INSERT {$this->table}($fields) VALUES($values)";
        $this->pdo->prepare($sql)->execute();
        return $this->pdo->lastInsertId();
    }
    //update更改数据
    //调用：$DB->where($condition)->update($array);
          //$condition=array($key=>$value);
          //$condition=array($key=>$value,'>=');
    public function update($data){
        //处理待更新数据$data 成sql语句
        $update="";
        foreach($data as $key=>$value){
            $update.="$key='$value',";
        }
        $update=substr($update,0,-1);//删除最后逗号
        //组合成sql语句
        $sql="UPDATE {$this->table} SET $update $this->where";
        $result=$this->pdo->prepare($sql);
        $result->execute();
        //返回 影响的 行数
        return $result->rowCount();
    }
    //delete删除数据
    //调用：$DB->where($condition)->delete();
          //$condition=array($key=>$value);
          //$condition=array($key=>$value,'>=');
    //或 $DB->delete($id);
    public function delete($int=NULL){
        //若提前调用where()方法
        if($this->where){
            $sql="DELETE FROM $this->table $this->where";
        }
	    //若delete()参数不为空且是整数
        elseif($int) {
            $where = "id=$int";

            $sql = "DELETE FROM $this->table WHERE $where";
        }
	    $result=$this->pdo->prepare($sql);
	    $result->execute();
	    return $result->rowCount();//返回删除的行数
    }
    //find单条查询
    //调用:   $DB->fields("字段1,字段2")->where($condition)->find();
    //或     $DB->where($condition)->find();
    public function find($int=NULL){
	    if($this->where){
            $sql="SELECT $this->fields FROM $this->table $this->where";
        }
        if($int){
	        $where="id=$int";
	        $sql="SELECT $this->fields FROM $this->table WHERE $where";
        }
        $result=$this->pdo->prepare($sql);
        $result->execute();
        return $result->fetchObject();
	}
	//select多条查询
    //调用: $DB->fields("字段1，字段2")->where($condition)->order("字段 desc")->limit($int)->select();
          //$condition=array('$key'=>$value,'>=');
    public function select(){
	    $sql="SELECT $this->fields FROM $this->table $this->where $this->order $this->limit";
	    $result=$this->pdo->prepare($sql);
	    $result->execute();
	    $objects=array();
	    //fetchObject()：返回下一行数据;
	    while($row=$result->fetchObject()){
	        $objects[]=$row;
        }
        return $objects;
    }
    public function count(){
        $sql="SELECT $this->fields FROM $this->table $this->where $this->order $this->limit";
        $result=$this->pdo->prepare($sql);
        $result->execute();
        return $result->rowCount();
    }
    //Where语句
    //调用 where($condition);
    // $condition=array('key'=>value);
    // 或 $condition=array('key'=>value,'>=');
    public function where($array){
	    //获取$array第一个元素key和value
        $key=key($array);
        $value=current($array);
        //此时指针右移，$array[0]指向第二个元素
        $sign=empty($array[0])?'=':strtoupper($array[0]);
        if(!isset($this->where)){
            $this->where.="WHERE $key $sign '$value'";
        }
        else{
            $this->where.=" AND $key $sign '$value'";
        }
        return $this;
    }
    //fields语句
    //fields("字段1，字段2，字段3，...");
    public function fields($fields){
        $this->fields=$fields;
        return $this;
    }
    //limit语句
    //调用 limit($int)
    //或 limit($start,$length);
    public function limit($start,$end=NULL){
	    if(is_null($end)){
	        $this->limit="LIMIT $start";
        }
        else{
            $this->limit="LIMIT $start,$end";
        }
	    return $this;
    }
    //分页功能(当前页数，每页显示条数);
    //返回当前页数的 指定N条数据
    public function page($PageNum=1,$PageSize=5){
        $this->limit="LIMIT ".(($PageNum-1)*$PageSize).",".$PageSize;
        $sql="SELECT $this->fields FROM $this->table $this->where $this->order $this->limit";
        $result=$this->pdo->prepare($sql);
        $result->execute();
        $objects=array();
        //fetchObject()：返回下一行数据;
        while($row=$result->fetchObject()){
            $objects[]=$row;
        }
        return $objects;
    }
    //order语句
    //order("字段 desc");
    public function order($string){
        $order=explode(" ",$string);
        $this->order="ORDER BY $order[0] ".strtoupper($order[1]);
        return $this;
    }
}

?>