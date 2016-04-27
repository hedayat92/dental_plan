<?php
/*
*@author : Ashwani Singh
*@date : 30-09-2013
*
*/

namespace Dashboard\Model;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class DashboardTable
{
	 protected $adapter;
   public $resultSetPrototype;
   public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
         $this->resultSetPrototype = new ResultSet ();
    }

	public function savePermission($permisssion,$roleid)
	{   
		$resource_id=1 ;
		$sql = new Sql ($this->adapter);
		$select = $sql->insert('permission')->values(array(
         'id' => '',
         'permission_name' => $permisssion,
         'resource_id'=>$resource_id,
     ));
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    $permissionlastId = $this->adapter->getDriver()->getLastGeneratedValue();
    $select = $sql->insert('role_permission')->values(array(
         'id' => '',
         'role_id' => $roleid,
         'permission_id'=>$permissionlastId ,
     ));
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result;
	}
  public function changeAdminPassword()
    {  
      echo "sfsdf"; die ;
    /*
    $sql = new Sql($this->adapter);
    $select = $sql->update('users')->set(array('password'=>$password))->where(array(
            'user_id' =>$userid)); 
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    $select = $sql->delete('role_permission')->where(array('role_id'=>$roleid)) ;
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    for($i=0;$i<count($perallid);$i++)
    {
    $select = $sql->insert('role_permission')->values(array(
            'id' => '',
            'role_id' =>$roleid,
            'permission_id'  => $perallid[$i] ,
    )); 
    //$select = $sql->getSqlStringForSqlObject($select);
   // echo $select ;
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ());
   }
   */
  }


    public function saveRagister($username,$email,$password,$roleid,$fname,$lname)
    {
        $status = 'N' ;
        $loginno = '0' ;
        $sql = new Sql($this->adapter);
        $select = $sql->insert('users')->values(array(
            'user_id' => '',
            'username' =>$username,
            'email' =>$email,
            'password'  => $password ,
            'login_no'  => $loginno ,
			'fname'  => $fname ,
			'lname'  => $lname ,
   ));
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    $userlastId = $this->adapter->getDriver()->getLastGeneratedValue();
    $select = $sql->insert('user_role')->values(array(
         'id' => '',
         'role_id' => $roleid,
         'user_id'=>$userlastId ,
     ));
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result; 
  }
  public function saveReports($reportname,$reporturl,$categoryid,$clientchkid)
    {
      $multipleclientid=implode(',',$clientchkid);
      $sql = new Sql($this->adapter);
      $select = $sql->insert('permission')->values(array(
            'id' => '',
            'permission_name' =>$reportname,
            'permission_url' =>$reporturl,
            'cat_id' =>$categoryid,
            'client_id' =>$multipleclientid,
   ));
    $query = $sql->getSqlStringForSqlObject($select);
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    $select = $sql->update('report_category')->set(array(
            'catclient_id' =>$multipleclientid,
   ))->where(array('id'=>$categoryid));
    $query = $sql->getSqlStringForSqlObject($select);
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result; 
  }
 public function saveRole($role,$permission)
	{    
    $status = 'Active' ;
		$sql = new Sql($this->adapter);
		$select = $sql->insert('role')->values(array(
            'rid' => '',
            'role_name' =>$role,
            'status'  => $status ,
   )); 
   $statement = $sql->prepareStatementForSqlObject($select);
   $result = $this->resultSetPrototype->initialize ($statement->execute ());
   $rolelastId = $this->adapter->getDriver()->getLastGeneratedValue();  
   for($i=0;$i<count($permission);$i++)
    {
    $select = $sql->insert('role_permission')->values(array(
            'id' => '',
            'role_id' =>$rolelastId,
            'permission_id'  =>$permission[$i],
   )); 
    $query = $sql->getSqlStringForSqlObject($select);
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
   }
    return $result;	
	}
   public function editRolePermission($roleid,$rolename,$perallid)
    {  
    $status = 'Active' ;
    $sql = new Sql($this->adapter);
    $select = $sql->update('role')->set(array('role_name'=>$rolename))->where(array(
            'rid' =>$roleid)); 
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    $select = $sql->delete('role_permission')->where(array('role_id'=>$roleid)) ;
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    for($i=0;$i<count($perallid);$i++)
    {
    $select = $sql->insert('role_permission')->values(array(
            'id' => '',
            'role_id' =>$roleid,
            'permission_id'  => $perallid[$i] ,
    )); 
    //$select = $sql->getSqlStringForSqlObject($select);
   // echo $select ;
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ());
   }
  }
    public function selectrole(){
    	    $status='Active';
    	    $sql = new Sql ($this->adapter);
          $select = $sql->select()
                 ->from('role')
                 ->where(array('status'=>$status));
          $statement = $sql->prepareStatementForSqlObject ($select);
          $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
          return $result;
  }
    public function selectUsers(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('users');
          $statement = $sql->prepareStatementForSqlObject ($select);
          $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
          return $result;
    }  
    public function userAssignRole($id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('user_role')
                 ->where(array('user_id'=>$id));
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function  updateUserRole($userid,$roleid,$fname,$lname,$email)
    {
          $sql = new Sql ($this->adapter);
          $select = $sql->update('user_role')->set(array('role_id'=>$roleid))->where(array('user_id'=>$userid)) ;
          $statement = $sql->prepareStatementForSqlObject ($select);
          $result = $this->resultSetPrototype->initialize ($statement->execute ()); 
          $select = $sql->update('users')->set(array('fname'=>$fname,'lname'=>$lname,'email'=>$email))->where(array('user_id'=>$userid)) ;
          $statement = $sql->prepareStatementForSqlObject ($select);
          $result = $this->resultSetPrototype->initialize ($statement->execute ());

         // echo $sql->getSqlStringForSqlObject($select);
         // die ;
          return $result;  
    }
    public function  updateReport($permissionid,$permissionname,$permissionurl,$categoryid,$clientidstring)
    {
      $sql = new Sql ($this->adapter);
      $select = $sql->update('permission')->set(array('permission_name'=>$permissionname,'permission_url'=>$permissionurl,'cat_id'=>$categoryid,'client_id'=>$clientidstring))->where(array('id'=>$permissionid)) ;
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ());
       $select = $sql->update('report_category')->set(array(
            'catclient_id' =>$clientidstring,
   ))->where(array('id'=>$categoryid));
    $query = $sql->getSqlStringForSqlObject($select);
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
      return $result;    
    }

    public function getUserById($id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('users')
                 ->where(array('user_id'=>$id,'status'=>'Y'));
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function getPermissionById($id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('permission')
                 ->where(array('id'=>$id));
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function viewPermission(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('permission');
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function viewRolesPermission(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('role_permission');
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
      public function PermissionfForRoleId($id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('role_permission')->where(array('role_id'=>$id));
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function viewUsers(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('users')->where(array('status'=>'Y'));
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
          return $result;
    }
      public function viewReports(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('permission');
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function viewRoles()
    {
    $sql = new Sql ($this->adapter);
    $select = $sql->select()
                 ->from('role')->where(array('status'=>'Active'));   
    $statement = $sql->prepareStatementForSqlObject ($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function getRole($roleid)
    {
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('role')->where(array('rid'=>$roleid));
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ());
      return $result;
    }
    public function getRoleByName($rolename)
    {
      $sql = new Sql ($this->adapter);
      $active= 'Active';
      $select = $sql->select()
                 ->from('role')->where(array('role_name'=>$rolename,'status'=>$active));
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ());
      return $result;
    }
    public function  deleteUser($id)
    {
             $sql = new Sql ($this->adapter);
             $select =$sql->delete('users')->where(array('user_id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
    public function  deleteReports($id)
    {
             $sql = new Sql ($this->adapter);
             $select = $sql->delete('permission')->where(array('id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
    public function  deleteRoles($rid)
    {
             $sql = new Sql ($this->adapter);
             $select = $sql->update('role')->set(array('status'=>'Inactive'))->where(array('rid'=>$rid)) ;
             $selectString = $sql->getSqlStringForSqlObject($select); 
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             $delrolepermission=$sql->delete('role_permission')->where(array('role_id'=>$rid)) ;
             $delrole= $sql->getSqlStringForSqlObject($delrolepermission);
             $statement = $sql->prepareStatementForSqlObject($delrolepermission);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
   public function findPassword($email)
	 {
     $rowset = $this->tableGateway->select(array('email' => $email));  // if we not write toArray() then value access by using foreach loop .but if we write then we can access it directly by using array 
     return $rowset ;
	}
    public function viewCategory(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('report_category');
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function saveCategory($categoryname)
    {
      $sql = new Sql($this->adapter);
      $select = $sql->insert('report_category')->values(array(
            'id' => '',
            'category_name' =>$categoryname,
   ));
    $query = $sql->getSqlStringForSqlObject($select);
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result; 
  }
     public function  deleteCategory($id)
    {
             $sql = new Sql ($this->adapter);
             $select = $sql->delete('report_category')->where(array('id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
      public function getCategoryById($id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('report_category')
                 ->where(array('id'=>$id));
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
       public function  updateCategory($id,$catname)
    {
      $sql = new Sql ($this->adapter);
      $select = $sql->update('report_category')->set(array('category_name'=>$catname))->where(array('id'=>$id)) ;
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ());
      return $result;    
    }
    public function selectCategory(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('report_category');
          $statement = $sql->prepareStatementForSqlObject ($select);
          $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
          return $result;
    } 
    public function viewClients(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('client');
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    } 
       public function saveClient($clientsname)
    {
      $sql = new Sql($this->adapter);
      $select = $sql->insert('client')->values(array(
            'id' => '',
            'client_name' =>$clientsname,
   ));
    $query = $sql->getSqlStringForSqlObject($select);
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result; 
  }
    public function  deleteClient($id)
    {
             $sql = new Sql ($this->adapter);
             $select = $sql->delete('client')->where(array('id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
     public function getClientById($id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('client')
                 ->where(array('id'=>$id));
      $statement = $sql->prepareStatementForSqlObject($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
      return $result;
    }
    public function  updateClient($id,$clientname)
    {
      $sql = new Sql ($this->adapter);
      $select = $sql->update('client')->set(array('client_name'=>$clientname))->where(array('id'=>$id)) ;
      $statement = $sql->prepareStatementForSqlObject ($select);
      $result = $this->resultSetPrototype->initialize ($statement->execute ());
      return $result;    
    }
    public function selectClients(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('client');
          $statement = $sql->prepareStatementForSqlObject ($select);
          $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
          return $result;
    } 
}
