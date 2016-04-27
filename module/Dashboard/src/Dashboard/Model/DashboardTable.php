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
 
  public function totalpatientcount(){
      $sql = new Sql ($this->adapter);
      $countRowQuery = "SELECT
              (select count(patient_id) as pat_total from patients) as totalPatients,
              (select count(doc_id) as doc_total from doctor_details where doc_speciality<3) as totalDoctor, 
              (select count(doc_id) as doc_total from doctor_details where doc_speciality=3) as totalSpecialist, 
              (select sum(amount) as com_total from doc_payments where pay_status='1') as commissionTotal, 
              (select sum(amount) as payout_total from  doc_payout where payout_status='1') as payoutTotal,
              (select sum(amount) as total_revenue from patients_payments) as patientsPayments,
              (select count(ref_id) as ref_total from  refer_patient) as refTotal" ;
     
   $countData = $this->adapter->query($countRowQuery, Adapter::QUERY_MODE_EXECUTE)->toArray();
   return $countData;
    }
  public function changeAdminPassword($password,$userid)
    {  
    $salt = 'aUJGgadjasdgdj';
    $password=sha1($salt . $password);
    $sql = new Sql($this->adapter);
    $select = $sql->update('users')->set(array('password'=>$password))->where(array(
            'user_id' =>$userid)); 
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result ;
   }
  public function changeAdminUsername($adminuser,$userid)
    {  
    $sql = new Sql($this->adapter);
    $select = $sql->update('users')->set(array('email'=>$adminuser))->where(array(
            'user_id' =>$userid)); 
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result ;
   }
  public function doctorDetails(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('doctor_details');
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
     public function doctorDetailsFromId($docid){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('doctor_details')->where(array('doc_id'=>$docid));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
    public function checkUserid($docusername){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('doctor_details')->where(array('doc_username'=>$docusername));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
    public function saveDoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username,$doc_pass){
        if($doc_status=='on') {
         $docstatus = 1;
          } else {
            $docstatus = 0;
          }
      
    if($doc_id){
     $qry = "update doctor_details set doc_firstname='".$doc_firstname."',doc_lastname='".$doc_lastname."',doc_speciality='".$doc_speciality."',doc_license_no='".$doc_license_no."',doc_address='".addslashes($doc_address)."',doc_zip='".$doc_zip."',doc_phone='".$doc_phone."',doc_contact_person='".$doc_contact_person."',doc_status='".$docstatus."',doc_sex='".$doc_sex."' where doc_id=".$doc_id;
    }else{
      $qry = "insert into doctor_details(`doc_firstname`,`doc_lastname`, `doc_speciality`,`doc_username`, `doc_address`, `doc_zip`, `doc_phone`, `doc_email`, `doc_pass`, `doc_contact_person`, `doc_license_no`, `doc_status`,add_date,doc_sex) values('".$doc_firstname."','".$doc_lastname."','".$doc_speciality."','".$doc_username."','".addslashes($doc_address)."','".$doc_zip."','".$doc_phone."','".$doc_email."','".md5($doc_pass)."','".$doc_contact_person."','".$doc_license_no."','".$docstatus."',now(),'".$doc_sex."')";
     }
    $result = $this->adapter->query($qry, Adapter::QUERY_MODE_EXECUTE);
    return $this->adapter->getDriver()->getLastGeneratedValue();
    } 
    public function savedoctorbank($doc_data){
	
	$qry = "update doctor_details set bank_routing_number='".$doc_data['bank_routing_number']."',bank_account_number='".$doc_data['bank_account_number']."',bank_account_type='".$doc_data['bank_account_type']."',legal_name='".$doc_data['legal_name']."' where doc_id=".$doc_data['doc_id'];

	$result = $this->adapter->query($qry, Adapter::QUERY_MODE_EXECUTE);
	return $result;
	}
	public function saveDoctorBankAc($doc_data){
	
	$qry = "update doctor_details set account_id='".$doc_data['account_id']."',bank_acc_id='".$doc_data['bank_acc_id']."' where doc_id=".$doc_data['doc_id'];

	$result = $this->adapter->query($qry, Adapter::QUERY_MODE_EXECUTE);
	return $result;
	}
    public function patTotalRevenue($docid,$doc_firstname){
    $patTotalRevenue= "select sum(pp.amount) as pat_total_revenue from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=$docid";
    $result = $this->adapter->query($patTotalRevenue, Adapter::QUERY_MODE_EXECUTE)->toArray();
    return $result;
    } 
    

  public function doctorActiveDetails(){
      $sql = new Sql ($this->adapter);
      $activeDoctor="select doc_id from doctor_details where doc_speciality<3 and doc_status=1" ;
      $result= $this->adapter->query($activeDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    }  
  public function doctorInActiveDetails(){
      $sql = new Sql ($this->adapter);
      $inActiveDoctor="select doc_id from doctor_details where doc_speciality<3 and doc_status<>1" ;
      $result= $this->adapter->query($inActiveDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    } 
    public function  deleteDoctors($id)
    {
             $sql = new Sql ($this->adapter);
             $select = $sql->delete('doctor_details')->where(array('doc_id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
  public function specialistdoctorActiveDetails(){
      $sql = new Sql ($this->adapter);
      $activeDoctor="select doc_id from doctor_details where doc_speciality=3 and doc_status=1" ;
      $result= $this->adapter->query($activeDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    }  
  public function specialistdoctorInActiveDetails(){
      $sql = new Sql ($this->adapter);
      $inActiveDoctor="select doc_id from doctor_details where doc_speciality=3 and doc_status<>1" ;
      $result= $this->adapter->query($inActiveDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    } 


  public function viewSupport(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('support');
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
  public function viewReports($reportid){
     $sql = new Sql ($this->adapter);
      if($reportid=='1'){
     $report ="select sum(dp.amount) as doc_total_revenue, YEAR(dp.pay_date) as col1 from doc_payments dp, doctor_details d where d.doc_id = dp.doc_id group by YEAR(dp.pay_date) order by dp.pay_date desc" ; 
     }else if($reportid=='2'){
     $report ="select sum(dp.amount) as doc_total_revenue, MONTH(dp.pay_date) as col1, YEAR(dp.pay_date) as col2 from doc_payments dp, doctor_details d where d.doc_id = dp.doc_id group by MONTH(dp.pay_date) order by dp.pay_date desc" ;
     }else if($reportid=='3'){
     $report ="select sum(dp.amount) as doc_total_revenue, dp.pay_date as col1 from doc_payments dp, doctor_details d where d.doc_id = dp.doc_id group by dp.pay_date order by dp.pay_date desc" ;
     }else{
      $report = "select sum(dp.amount) as doc_total_revenue from doc_payments dp, doctor_details d where d.doc_id = dp.doc_id order by dp.pay_date desc" ;
     }
      $result= $this->adapter->query($report,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
   } 
    public function doctorgridListing($searchkey){
    if($searchkey==''){

     $doctorlist ="select * from doctor_details where doc_speciality <>'3'" ; 
     }else{
     $doctorlist ="select * from doctor_details where doc_speciality <>'3'  and doc_firstname like '".chr($searchkey)."%'" ;
     }
      $result= $this->adapter->query($doctorlist,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
   } 
    
   public function specialistdoctorgridListing($searchkey){
    if($searchkey==''){
     $doctorlist ="select * from doctor_details where doc_speciality ='3'" ; 
     }else{
     $doctorlist ="select * from doctor_details where doc_speciality ='3'  and doc_firstname like '".chr($searchkey)."%'" ;
     }
      $result= $this->adapter->query($doctorlist,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
   } 
    public function docPayDetails($docid,$planid){   //1->yearly,2->monthly,3->days
     $sql = new Sql ($this->adapter);
      if($planid=='1'){
     $report ="select sum(pp.amount) as pat_total_revenue, YEAR(pp.pay_date) as col1 from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=".$docid." group by YEAR(pp.pay_date) order by pp.pay_date desc" ; 
     }else if($planid=='2'){
     $report ="select sum(pp.amount) as pat_total_revenue, MONTH(pp.pay_date) as col1, YEAR(pp.pay_date) as col2 from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=".$docid." group by MONTH(pp.pay_date) order by pp.pay_date desc" ;
     }else if($planid=='3'){
     $report ="select sum(pp.amount) as pat_total_revenue, pp.pay_date as col1 from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=".$docid." group by pp.pay_date order by pp.pay_date desc" ;
     }else{
     $report = "select sum(pp.amount) as pat_total_revenue from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=".$docid." order by pp.pay_date desc" ;
     }
      $result= $this->adapter->query($report,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
   } 

    public function listPatient($docid){
     $patientlist ="select p.*, pn.plan_name from patients p, plans pn where pn.plan_id=p.plan_id and p.doc_id=$docid" ; 
     $result= $this->adapter->query($patientlist,Adapter::QUERY_MODE_EXECUTE)->toArray();  
     return $result;
   } 
   public function listPatientForDocPatient($patid,$docid){
     $patientlist ="select p.*,pl.plan_name from patients p, plans pl where p.plan_id=pl.plan_id and p.patient_id='$patid' and p.doc_id='$docid'"; 
    // echo $patientlist ; 
     $result= $this->adapter->query($patientlist,Adapter::QUERY_MODE_EXECUTE)->toArray();  
     return $result;
   } 

    public function paidAmount($st,$en,$doc_id){
     $patientlist ="select amount as amt from doc_payout where payout_date>'".$st."' and payout_date<='".$en."' and payout_status='".'1'."' and doc_id='".$doc_id."'"; 
     $result= $this->adapter->query($patientlist,Adapter::QUERY_MODE_EXECUTE)->toArray();  
     return $result;
   }
   
  public function spanAmount($st,$en,$doc_id){

    $patientlist ="select sum(pp.amount) as amt from patients_payments pp, patients p where pp.pay_date>='".$st."' and pp.pay_date<'".$en."' and pp.patient_id=p.patient_id and p.doc_id='".$doc_id."'"; 
     $result= $this->adapter->query($patientlist,Adapter::QUERY_MODE_EXECUTE)->toArray();  
     return $result;
   }
  public function listPatientsId(){
     $sql = new Sql($this->adapter);
     $select=$sql->select()->from('patients');
     $statement = $sql->prepareStatementForSqlObject($select);
     $result=$this->resultSetPrototype->initialize($statement->execute())->toArray(); 
     return $result;
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

	/*-------------------------ABhishek-----------------*/
  public function selectPlansAsDoc($doc_id){
      $sql = new Sql ($this->adapter);
      $query ="select * from plans where `doc_id`=".$doc_id ;
	  $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
	
   public function selectPlans($plan_id){
      $sql = new Sql ($this->adapter);
      $query ="select * from plans where `plan_id`=".$plan_id ;
	  $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
	
	
	
	public function editPlans($planid,$doc_id,$plan_name,$heading_line,$plan_monthly_price,$plan_yearly_price,$addon_monthly_price,$addon_yearly_price){
        $sql = new Sql ($this->adapter);
$query = "update `plans` set `doc_id`='".$doc_id."',`plan_name`='".$plan_name."',`heading_line`='".$heading_line."',`plan_monthly_price`='".$plan_monthly_price."',`plan_yearly_price`='".$plan_yearly_price."',`addon_monthly_price`='".$addon_monthly_price."',`addon_yearly_price`='".$addon_yearly_price."'where `plan_id`='".$planid."'";
		 $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
		  return $result;
    } 
	
	
	public function deletePlans($planid){
           $sql = new Sql ($this->adapter);
           $query = "delete from `plans` where `plan_id`='".$planid."'";	
		  $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
		  return $result;
    } 
	
	
	public function editPlanServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes){
        $sql = new Sql ($this->adapter);
$query = "update plan_services set `service_type` = '".$service_type."',`service_name1`='".$service_name1."',`service_name2`='".$service_name2."',`service_name3`='".$service_name3."',`service_name4`='".$service_name4."',`service_name5`='".$service_name5."',`service_name6`='".$service_name6."',`service_name6`='".$service_name6."',`service_name7`='".$service_name7."',`service_name8`='".$service_name8."',`service_name9`='".$service_name9."',`service_name10`='".$service_name10."',`service_notes`='".$service_notes."' where `service_id`='".$service_id."'";
		 $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
		  return $result;
    } 
	
	
		public function addPlanServices($service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes,$plan_id){
        $sql = new Sql ($this->adapter);
$query = "insert into `plan_services`(`service_type`,`service_name1`,`service_name2`,`service_name3`,`service_name4`,`service_name5`,`service_name6`,`service_name7`,`service_name8`,`service_name9`,`service_name10`,`service_notes`,`plan_id`) values ('".$service_type."','".$service_name1."','".$service_name2."','".$service_name3."','".$service_name4."','".$service_name5."','".$service_name6."','".$service_name7."','".$service_name8."','".$service_name9."','".$service_name10."','".$service_notes."','".$plan_id."')";
		 $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
		  return $result;
    } 
	
	
	
	
	public function editDoctorAvatar($doc_id,$doc_avatar){
      echo $query = "update doctor_details set `doc_avatar`='".$doc_avatar."' where `doc_id`='".$doc_id."'";
		    $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);		
		  return $result;
    } 
	  
	public function deleteDoctorImage($doc_id){
        $query = "update doctor_details set doc_avatar='' where doc_id=$doc_id";
        $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);    
      return $result;
    } 
	
	
	
	

	
   public function selectPlanServices($plan_id){
      $sql = new Sql ($this->adapter);
      $query ="select * from plan_services where `plan_id`=".$plan_id ;
	  $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
	
	public function selectSingleServices($service_id){
      $sql = new Sql ($this->adapter);
      $query ="select * from plan_services where `service_id` =$service_id";
	  $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
    public function splServices($docid){
      $sql = new Sql ($this->adapter);
      $query ="select * from spl_services where `doc_id` =$docid";
      $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
    public function splServicesDetails($serviceid){
      $sql = new Sql ($this->adapter);
     $query ="select * from spl_services where `service_id` =$serviceid";
      $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
	 public function selectDoctorAvatar($doc_id){
      $sql = new Sql ($this->adapter);
      $query ="select doc_avatar from doctor_details where doc_id=".$doc_id ;
	    $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
		
	public function planDeleteAvatar($plan_id){
      $sql = new Sql ($this->adapter);
      $query ="delete from plans where plan_id=".$plan_id ;
	  $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
	
	public function addPlanServiceAvatar($plan_id){
      $sql = new Sql ($this->adapter);
      $query ="delete from plans where plan_id=".$plan_id ;
	  $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
	public function referPatient($docid){
    $referPatient= "select count(*) as refercount from refer_patient where refer_to=".$docid;
    $result = $this->adapter->query($referPatient, Adapter::QUERY_MODE_EXECUTE)->toArray();
    return $result;
    } 	
	

  public function deleteSpecialServiceid($id){
          echo $query = "delete from `spl_services` where `service_id`='".$id."'";  
           $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
           return $result;
    } 
	public function selectSingleSPlServices($service_id){
      $query ="select * from spl_services where `service_id` =$service_id";
      $result= $this->adapter->query($query,Adapter::QUERY_MODE_EXECUTE)->toArray();  
      return $result;
    } 
    
  public function editSingleSPlServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$price){
$query = "update spl_services set `service_type` = '".$service_type."',`service_name1`='".$service_name1."',`service_name2`='".$service_name2."',`service_name3`='".$service_name3."',`service_name4`='".$service_name4."',`service_name5`='".$service_name5."',`service_name6`='".$service_name6."',`service_name6`='".$service_name6."',`service_name7`='".$service_name7."',`service_name8`='".$service_name8."',`service_name9`='".$service_name9."',`service_name10`='".$service_name10."',`price`='".$price."' where `service_id`='".$service_id."'";
     $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
      return $result;
    } 
   public function insertSingleSPlServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$price,$docid){
     $query = "insert into spl_services(service_type,service_name1,service_name2,service_name3,service_name4,service_name5,service_name6,service_name7,service_name8,service_name9,service_name10,price,doc_id) values('$service_type','$service_name1','$service_name2','$service_name3','$service_name4','$service_name5','$service_name6','$service_name7','$service_name8','$service_name9','$service_name10','$price','$docid')";
     $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
      return $result;
    } 
  public function addPlans($doc_id,$plan_name,$heading_line,$plan_monthly_price,$plan_yearly_price,$addon_monthly_price,$addon_yearly_price){
        $sql = new Sql ($this->adapter);
    $query = "Insert into `plans` (`doc_id`,`plan_name`,`heading_line`,`plan_monthly_price`,`plan_yearly_price`,`addon_monthly_price`,`addon_yearly_price`) values ('".$doc_id."','".$plan_name."','".$heading_line."','".$plan_monthly_price."','".$plan_yearly_price."','".$addon_monthly_price."','".$addon_yearly_price."')";
     $results = $this->adapter->query($query, Adapter::QUERY_MODE_EXECUTE);
    $lastId = $this->adapter->getDriver()->getLastGeneratedValue();
      return $lastId;
    } 
		
	
	
}




