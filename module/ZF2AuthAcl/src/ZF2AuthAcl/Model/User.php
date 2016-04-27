<?php
namespace ZF2AuthAcl\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class User extends AbstractTableGateway
{

    public $table = 'users';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }
   public function updateUid($email){
	$currenttime =  date("Y-m-d H:i:s");   
    $RowQuery = "UPDATE users set uidnumber=UUID(),uidcreated_time='$currenttime'   where email='$email'" ;
    $result  = $this->adapter->query($RowQuery, Adapter::QUERY_MODE_EXECUTE); 
   return $result ; 
   }
    public function selectUidfromemail($email){
     $sql = new Sql ($this->adapter);
            $select = $sql->select()
                 ->from('users')
                 ->where(array('email'=>$email,'status'=>'Y'));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result ;
   }
     public function getUserDetailByUuid($uuid){
     $sql = new Sql ($this->adapter);
     $select = $sql->select()
                 ->from('users')
                 ->where(array('uidnumber'=>$uuid,'status'=>'Y'));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result ;
   } 
 

    public function getUserDetailByEmail($email){
     $sql = new Sql ($this->adapter);
            $select = $sql->select()
                 ->from('users')
                 ->where(array('email'=>$email,'status'=>'Y'));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result ;
   }
     public function authenticate($email,$password){
     $sql = new Sql ($this->adapter);
     $select = $sql->select()
                 ->from('users')
                 ->where(array('email'=>$email ,'password'=>$password,'status'=>'Y'));
     // $selectString = $sql->getSqlStringForSqlObject($select); 
    //  echo  $selectString  ;
    //  die ;           
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result ;
   }
  public function authenticateDoctor($email,$password){
     $sql = new Sql ($this->adapter);
     $select = $sql->select()
                 ->from('doctor_details')
                 ->where(array('doc_email'=>$email ,'doc_pass'=>$password));
     // $selectString = $sql->getSqlStringForSqlObject($select); 
    //  echo  $selectString  ;
    //  die ;           
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result ;
   }
   public function AfterUnsuccessfulLogin(){ 
     $ip  = $_SERVER["REMOTE_ADDR"] ;
     $sql = new Sql ($this->adapter);
     $select = $sql->select()
                 ->from('loginattempts')
                 ->where(array('ip'=>$ip));          
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result ;
      }
                                 
     public function AfterUnsuccessfullForgetPasswordAttempt(){ 
     $ip  = $_SERVER["REMOTE_ADDR"] ;
     $sql = new Sql ($this->adapter);
     $select = $sql->select()
                 ->from('forgetpasswordattempt')
                 ->where(array('ip'=>$ip));          
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result ;
      }
     public function inserLoginAttempt()
       { 
       $ip  = $_SERVER["REMOTE_ADDR"] ; 
       $insert_time = date("Y-m-d H:i:s");
       $sql = new Sql($this->adapter);
       $select= $sql->insert('loginattempts')->values(array('id'=>'','ip'=>$ip,'attempts'=>1,'lastlogin'=>$insert_time));
       $statement =  $sql->prepareStatementForSqlObject($select);
       $result = $this->resultSetPrototype->initialize($statement->execute ());
       return $result ;
        } 
        public function insertForgetPasswordAttempt()
       { 
       $ip  = $_SERVER["REMOTE_ADDR"] ; 
       $insert_time = date("Y-m-d H:i:s");
       $sql = new Sql($this->adapter);
       $select= $sql->insert('forgetpasswordattempt')->values(array('id'=>'','ip'=>$ip,'attempts'=>1,'lastlogin'=>$insert_time));
       $statement =  $sql->prepareStatementForSqlObject($select);
       $result = $this->resultSetPrototype->initialize($statement->execute ());
       return $result ;
        }
      public function  updateLastLoginAttempt($attempts){
      $sql = new Sql($this->adapter);
      $lastlogintime = date("Y-m-d H:i:s") ;
      $ip  = $_SERVER["REMOTE_ADDR"] ; 
      $update= $sql->update('loginattempts')->set(array('lastlogin'=>$lastlogintime,'attempts'=>$attempts))->where(array('ip'=>$ip));
      $statement =  $sql->prepareStatementForSqlObject($update);
      $result = $this->resultSetPrototype->initialize($statement->execute ());
      return $result ; 
       }
      public function  updateUnsuccessfullForgetPasswordAttempt($attempts){
      $sql = new Sql($this->adapter);
      $lastlogintime = date("Y-m-d H:i:s") ;
      $ip  = $_SERVER["REMOTE_ADDR"] ; 
      $update= $sql->update('forgetpasswordattempt')->set(array('lastlogin'=>$lastlogintime,'attempts'=>$attempts))->where(array('ip'=>$ip));
      $statement =  $sql->prepareStatementForSqlObject($update);
      $result = $this->resultSetPrototype->initialize($statement->execute ());
      return $result ; 
       }
      public  function updateLoginAttemptAfterLoginSuccess()
      {
      $ip  = $_SERVER["REMOTE_ADDR"] ;  
      $sql = new Sql($this->adapter);
      $update= $sql->update('loginattempts')->set(array('attempts'=>0))->where(array('ip'=>$ip));
      $statement =  $sql->prepareStatementForSqlObject($update);
      $result = $this->resultSetPrototype->initialize($statement->execute ());
      return $result ;
      }
      public function  updateLoginAttempt($attempts){
      $ip  = $_SERVER["REMOTE_ADDR"] ;  
      $sql = new Sql($this->adapter);
      $update= $sql->update('loginattempts')->set(array('attempts'=>$attempts))->where(array('ip'=>$ip));
      $statement =  $sql->prepareStatementForSqlObject($update);
      $result = $this->resultSetPrototype->initialize($statement->execute ());
      return $result ; 
       }               
      public function  updateForgetPasswordAttempt($attempts=0){
      $ip  = $_SERVER["REMOTE_ADDR"] ;  
      $sql = new Sql($this->adapter);
      $update= $sql->update('forgetpasswordattempt')->set(array('attempts'=>$attempts))->where(array('ip'=>$ip));
      $statement =  $sql->prepareStatementForSqlObject($update);
      $result = $this->resultSetPrototype->initialize($statement->execute ());
      return $result ; 
      } 
      public function unlockUserReset($username,$email,$encyptPass)
       {
        $ip  = $_SERVER["REMOTE_ADDR"] ; 
        $loginno ='0' ;
        $sql = new Sql($this->adapter);
        $update= $sql->update('users')->set(array('password'=>$encyptPass,'login_no'=>$loginno))->where(array('email'=>$email));
       //  $selectString = $sql->getSqlStringForSqlObject($update); 
        $statement =  $sql->prepareStatementForSqlObject($update);
       $result = $this->resultSetPrototype->initialize($statement->execute ());
      $update= $sql->update('loginattempts')->set(array('attempts'=>0))->where(array('ip'=>$ip));
      $statement =  $sql->prepareStatementForSqlObject($update);
      $result = $this->resultSetPrototype->initialize($statement->execute ()); 
      return $result ; 
      }
     public function getUserDetailById($userid)
     {
     $sql = new Sql ($this->adapter);
     $select = $sql->select()
                 ->from('users')
                 ->where(array('user_id'=>$userid));
      $selectString = $sql->getSqlStringForSqlObject($select); 
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result ;
   }
   public function updatePassword($email,$password){
      $sql = new Sql($this->adapter);
      $update= $sql->update('users')->set(array('password'=>$password))->where(array('email'=>$email));
       $statement =  $sql->prepareStatementForSqlObject($update);
       $result = $this->resultSetPrototype->initialize($statement->execute ());
	     return $result ;
   }
    public function updateDocPassword($email,$password){
       $sql = new Sql($this->adapter);
       $update= $sql->update('doctor_details')->set(array('doc_pass'=>$password))->where(array('doc_email'=>$email));
       $statement =  $sql->prepareStatementForSqlObject($update);
       $result = $this->resultSetPrototype->initialize($statement->execute ());
       return $result ;
   }
    public function deleteuid($email){
	   $sql = new Sql($this->adapter);
       $update= $sql->update('users')->set(array('uidnumber'=>'0'))->where(array('email'=>$email));
       $statement =  $sql->prepareStatementForSqlObject($update);
       $result = $this->resultSetPrototype->initialize($statement->execute ());
	   return $result ;		
	}
   
    public function updateRagisterPassword($email,$password){
      $loginno ='1' ;
      $sql = new Sql($this->adapter);
      $update= $sql->update('users')->set(array('password'=>$password,'login_no'=>$loginno))->where(array('email'=>$email));
      $selectString = $sql->getSqlStringForSqlObject($update); 
    //  echo $selectString ;
    //  die ;
      $statement =  $sql->prepareStatementForSqlObject($update);
      $result = $this->resultSetPrototype->initialize($statement->execute ());
      return $result ;
   }
    public function getUsers($where = array(), $columns = array())
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array(
                'user' => $this->table
            ));
            
            if (count($where) > 0) {
                $select->where($where);
            }
            
            if (count($columns) > 0) {
                $select->columns($columns);
            }
            
            $select->join(array('userRole' => 'user_role'), 'userRole.user_id = user.user_id', array('role_id'), 'LEFT');
            $select->join(array('role' => 'role'), 'userRole.role_id = role.rid', array('role_name'), 'LEFT');
            $statement = $sql->prepareStatementForSqlObject($select);
            $users = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $users;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }    
}
