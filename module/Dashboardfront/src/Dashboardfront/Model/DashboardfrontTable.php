<?php


namespace Dashboardfront\Model;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;


class DashboardfrontTable
{
	 protected $adapter;
   public $resultSetPrototype;
   public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet ();
    }
  public function savesupports($doc_id,$first_name,$last_name,$email_id,$address,$phone,$message)
  {
    $sql = new Sql($this->adapter);
    $sqlquery= "insert into support(`doc_id`, `first_name`, `last_name`, `email_id`, `address`, `phone`, `message`, `add_date`) values('$doc_id','$first_name','$last_name','$email_id','$address','$phone','$message',now())";
    $result= $this->adapter->query($sqlquery,Adapter::QUERY_MODE_EXECUTE) ;
    return $result;
  }
  public function splserviceFromDocId($docid){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('spl_services')->where(array('doc_id'=>$docid));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
  public function doctorDetailFromDocSpacility(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('doctor_details')->where(array('doc_speciality'=>'3'));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
  public function servicesDetailsFromId($serviceid){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('spl_services')->where(array('service_id'=>$serviceid));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
  
  public function saveSplServices($service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$price,$doc_id,$spl_serviceid){
    if($spl_serviceid){
     $qry = "update spl_services set service_type='$service_type',service_name1='$service_name1',service_name2='$service_name2',service_name3='$service_name3',service_name4='$service_name4',service_name5='$service_name5',service_name6='$service_name6',service_name7='$service_name7',service_name8='$service_name8',service_name9='$service_name9',service_name10='$service_name10',price='$price' where service_id=".$spl_serviceid ;
    }else{
     $qry = "insert into spl_services(`service_type`, `service_name1`, `service_name2`, `service_name3`, `service_name4`, `service_name5`, `service_name6`, `service_name7`, `service_name8`, `service_name9`, `service_name10`, `price`, `doc_id`) values('$service_type','$service_name1','$service_name2','$service_name3','$service_name4','$service_name5','$service_name6','$service_name7','$service_name8','$service_name9','$service_name10','$price','$doc_id')"; 
     }
    $result = $this->adapter->query($qry, Adapter::QUERY_MODE_EXECUTE);
    return $result;
    } 
     public function  deleteservices($id)
    {

             $sql = new Sql ($this->adapter);
             $select = $sql->delete('spl_services')->where(array('service_id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }


  public function totalDoctorPatientCount($docid){
      $sql = new Sql ($this->adapter);
      $countRowQuery = "SELECT
              (select count(patient_id) as pat_total from patients where doc_id=$docid and patient_status=1) as totalPatients,
              (select sum(pp.amount) as pat_total_revenue from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=$docid group by MONTH(pp.pay_date) order by pp.pay_date desc limit 1) as total_income" ;
     
   $countData = $this->adapter->query($countRowQuery, Adapter::QUERY_MODE_EXECUTE)->toArray();
   return $countData;
    }
  public function changeAdminPassword($password,$userid)
    {  
    $sql = new Sql($this->adapter);
    $select = $sql->update('users')->set(array('password'=>md5($password)))->where(array(
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
      public function PlansListing(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('plans');
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
    public function DoctorPlansListing($doc_id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('plans')->where(array('doc_id'=>$doc_id));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
   public function listplanservice(){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('plan_services');
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
    public function PlanDetails($plan_id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('plans')->where(array('plan_id'=>$plan_id));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
    public function PlanserviceDetails($plan_id){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('plan_services')->where(array('plan_id'=>$plan_id));
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
    public function checkUseridByEmail($docusername){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('doctor_details')->where(array('doc_email'=>$docusername));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
    return $result;
    } 
    public function checkadminUseridByEmail($docusername){
      $sql = new Sql ($this->adapter);
      $select = $sql->select()
                 ->from('users')->where(array('email'=>$docusername));
     $statement = $sql->prepareStatementForSqlObject ($select);
     $result = $this->resultSetPrototype->initialize ($statement->execute ())->toArray();
     return $result;
    } 
  public function saveDoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username,$password,$doc_speciality_detail){
        if($doc_status=='on') {
         $docstatus = 1;
          } else {
            $docstatus = 0;
          }
      $salt = 'aUJGgadjasdgdj';
      $password=sha1($salt . $password); 
    if($doc_id){
     $qry = "update doctor_details set doc_firstname='".$doc_firstname."',doc_lastname='".$doc_lastname."',doc_speciality='".$doc_speciality."',doc_license_no='".$doc_license_no."',doc_address='".addslashes($doc_address)."',doc_zip='".$doc_zip."',doc_phone='".$doc_phone."',doc_contact_person='".$doc_contact_person."',doc_status='".$docstatus."',doc_sex='".$doc_sex."',doc_speciality_detail='".$doc_speciality_detail."' where doc_id=".$doc_id;
    }else{
     $qry = "insert into doctor_details(`doc_firstname`,`doc_lastname`, `doc_speciality`,`doc_username`, `doc_address`, `doc_zip`, `doc_phone`, `doc_email`, `doc_pass`, `doc_contact_person`, `doc_license_no`, `doc_status`,add_date,doc_sex,doc_speciality_detail) values('".$doc_firstname."','".$doc_lastname."','".$doc_speciality."','".$doc_username."','".addslashes($doc_address)."','".$doc_zip."','".$doc_phone."','".$doc_email."','".$password."','".$doc_contact_person."','".$doc_license_no."','".$docstatus."',now(),'".$doc_sex."','".$doc_speciality_detail."')";
     }
    $result = $this->adapter->query($qry, Adapter::QUERY_MODE_EXECUTE);
      return $this->adapter->getDriver()->getLastGeneratedValue();
    }  
    public function updateDoctorDetails($docid,$number,$cvc,$exp_month,$exp_year){

	$update_qry = "update doctor_details set cc_number='$number',cc_month='$exp_month',cc_year='$exp_year' where doc_id=$docid";
	
    $result = $this->adapter->query($update_qry, Adapter::QUERY_MODE_EXECUTE);
    return $result;
    }
   public function cancelDoctorSubscription($docid){
    $update_qry = "update doctor_details set subs_cancel_dt=now(),doc_status='0' where doc_id=".$docid ; 
    $result = $this->adapter->query($update_qry, Adapter::QUERY_MODE_EXECUTE);
    return $result;
    }
   public function updateDoctorSubscriptionInNotChange($subsid,$custid,$docid)
   {
	
   $update_qry = "update doctor_details set cust_id='$custid',subs_id='$subsid' where doc_id='$docid'";
   $result = $this->adapter->query($update_qry, Adapter::QUERY_MODE_EXECUTE);
   return $result;
   }
    
  public function insertDoctorSubscriptionInNotChange($docid,$subsplanamt)
  {
  $insert_qry = "insert into doc_payments(doc_id,amount,pay_date,pay_status) values('$doc_id','$subsplanamt',now(),'1')";
  $result = $this->adapter->query($insert_qry, Adapter::QUERY_MODE_EXECUTE);
  return $result;
  }


    public function patTotalRevenue($docid,$doc_firstname){
    $patTotalRevenue= "select sum(pp.amount) as pat_total_revenue from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=$docid";
    $result = $this->adapter->query($patTotalRevenue, Adapter::QUERY_MODE_EXECUTE)->toArray();
    return $result;
    } 
  public function PatientDetails($patid,$docUserID){
    $patTotalRevenue= "select p.*,pl.plan_name from patients p, plans pl where p.plan_id=pl.plan_id and p.patient_id='$patid' and p.doc_id='$docUserID'";
    $result = $this->adapter->query($patTotalRevenue, Adapter::QUERY_MODE_EXECUTE)->toArray();
    return $result;
    } 
    

  public function doctorActiveDetails(){
      $sql = new Sql ($this->adapter);
      $activeDoctor="select doc_id from doctor_details where doc_speciality<3 and doc_status=1" ;
      $result= $this->adapter->query($activeDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    }  
  public function PatientPlanDetails($pat_id,$docUserID){
      $sql = new Sql ($this->adapter);
      $PatientPlan="select p.*, pn.plan_name from patients p, plans pn where pn.plan_id=p.plan_id and patient_id='$pat_id'" ;
      $result= $this->adapter->query($PatientPlan, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    }  
  public function doctorInActiveDetails(){
      $sql = new Sql ($this->adapter);
      $inActiveDoctor="select doc_id from doctor_details where doc_speciality<3 and doc_status<>1" ;
      $result= $this->adapter->query($inActiveDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    } 
    public function PatientDetailsById($patient_id){
      $sql = new Sql ($this->adapter);
      $patients="select * from patients where patient_id=$patient_id" ;
      $result= $this->adapter->query($patients, Adapter::QUERY_MODE_EXECUTE)->toArray();
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
  public function viewReports($reportid,$doc_id){
     $doc_id=$doc_id;
     $sql = new Sql ($this->adapter);
      if($reportid=='1'){
     $report ="select sum(pp.amount) as pat_total_revenue, YEAR(pp.pay_date) as col1 from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=$doc_id group by YEAR(pp.pay_date) order by pp.pay_date desc" ; 
     }else if($reportid=='2'){
     $report ="select sum(pp.amount) as pat_total_revenue, MONTH(pp.pay_date) as col1, YEAR(pp.pay_date) as col2 from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id='$doc_id' group by MONTH(pp.pay_date) order by pp.pay_date desc" ;
     }else if($reportid=='3'){
     $report ="select sum(pp.amount) as pat_total_revenue, pp.pay_date as col1 from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id='$doc_id' group by pp.pay_date order by pp.pay_date desc" ;
     }else{
      $report = "select sum(pp.amount) as pat_total_revenue from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id='$doc_id' order by pp.pay_date desc" ;
     }
      $result= $this->adapter->query($report,Adapter::QUERY_MODE_EXECUTE)->toArray();  
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
  
    public function patientInActiveDetails($docUserID){
      $sql = new Sql ($this->adapter);
      $activeDoctor="select patient_id from patients where doc_id='$docUserID' and patient_status<>1" ;
      $result= $this->adapter->query($activeDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    }  
  public function patientActiveDetails($docUserID){
      $sql = new Sql ($this->adapter);
      $inActiveDoctor="select patient_id from patients where doc_id=$docUserID and patient_status=1" ;
      $result= $this->adapter->query($inActiveDoctor, Adapter::QUERY_MODE_EXECUTE)->toArray();
      return $result;
    } 
  
    public function  delpatient($id)
    {      
             $sql = new Sql ($this->adapter);
             $select = $sql->delete('patients')->where(array('patient_id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
      public function  deletePlan($id)
    {      
             $sql = new Sql ($this->adapter);
             $select = $sql->delete('plans')->where(array('plan_id'=>$id)) ;
             $statement = $sql->prepareStatementForSqlObject ($select);
             $result = $this->resultSetPrototype->initialize ($statement->execute ());
             return $result;  
    }
     public function insertPatient($plan_id,$plan_cycle,$patient_salutation,$patient_firstname,$patient_lastname,$patient_dob,$patient_ssn,$patient_sex,$patient_address,$patient_zip,$patient_phone,$patient_mobile,$patient_email,$patient_password,$pat_id,$addon,$parent_id,$docid,$patient_status,$patient_consent) 
     {
     $datearray=explode('-',$patient_dob);
     $newDateOB=$datearray[2].'-'.$datearray[0].'-'.$datearray[1];
     if($patient_password==''){
      $patient_password =0;
     }
     if($patient_password==''){
      $patient_password =0;
     }
     if($patient_status=='on')
    $pstatus = 1;
  else
    $pstatus = 0;
  if($patient_consent=='on')
    $pconsent = 1;
  else
    $pconsent = 0;
   if(empty($pat_id)){
     $patientinsert ="insert into patients(patient_salutation,patient_firstname,patient_lastname,patient_ssn,patient_dob,patient_sex,patient_address,patient_zip,patient_phone,patient_mobile,patient_email,patient_pass,patient_family_info,patient_lastprocedure_info,patient_consent,plan_id, doc_id,plan_start_date,plan_cycle,parent_id) values('$patient_salutation','$patient_firstname','$patient_lastname','$patient_ssn','$newDateOB','$patient_sex','$patient_address','$patient_zip','$patient_phone','$patient_mobile','$patient_email',md5($patient_password),'$patient_family_info','$patient_lastprocedure_info','$pconsent','$plan_id','$docid',now(),'$plan_cycle','$parent_id')";
     }else{
        $patientinsert ="update patients set patient_salutation='$patient_salutation', patient_firstname='$patient_firstname',patient_lastname='$patient_lastname',patient_ssn='$patient_ssn',patient_dob='$newDateOB',patient_address='$patient_address',patient_zip='$patient_zip',patient_phone='$patient_phone' ,patient_mobile='$patient_mobile',patient_family_info='$patient_family_info',patient_lastprocedure_info='$patient_lastprocedure_info',patient_status='$pstatus',patient_consent='$pconsent' where patient_id=".$pat_id; 
     } 
     echo $patientinsert ;
     $result= $this->adapter->query($patientinsert,Adapter::QUERY_MODE_EXECUTE); 
     $userlastId = $this->adapter->getDriver()->getLastGeneratedValue(); 
     return $userlastId;
   die;
   }

  public function changeDoctorPassword($password,$userid)
    {  
    $salt = 'aUJGgadjasdgdj';
    $password=sha1($salt . $password); 
    $sql = new Sql($this->adapter);
    $select = $sql->update('doctor_details')->set(array('doc_pass'=>$password))->where(array(
            'doc_id' =>$userid)); 
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $this->resultSetPrototype->initialize ($statement->execute ());
    return $result ;
   }
 public function planstripInsert($stripeplancode,$plan_price)
 {
  $planstripInsert ="insert into plan_stripe(plan_code,amount) values('$stripeplancode','$plan_price')"; 
  $result= $this->adapter->query($planstripInsert,Adapter::QUERY_MODE_EXECUTE); 
  return $result;
 }
  public function getPatientAddons($parent_id)
 {
  $sql=new Sql($this->adapter);
  $select = $sql->select()->from('patients')->where(array('parent_id'=>$parent_id)) ;
  $statement=$sql->prepareStatementForSqlObject($select) ;
  $result=$this->resultSetPrototype->initialize($statement->execute());
  return $result->count();
 }
  public function getMainPatient($patient_id)
 {
  $sql=new Sql($this->adapter);
  $select = $sql->select()->from('patients')->where(array('patient_id'=>$patient_id)) ;
  $statement=$sql->prepareStatementForSqlObject($select) ;
  $result=$this->resultSetPrototype->initialize($statement->execute());
  if($result[0]['parent_id']==0) {
      return $result[0]['patient_id'];
    } else {
      return $result[0]['parent_id'];
    }
 }
  public function chkStripePlanExists($planstringname)
 {
     $sql = new Sql($this->adapter);
     $select=$sql->select()->from('plan_stripe')->where(array('plan_code'=>$planstringname)) ;
     $statement = $sql->prepareStatementForSqlObject($select);
     $result=$this->resultSetPrototype->initialize($statement->execute())->toArray(); 
     return $result;
 }  

 public function stripePlanInsert($stripeplancode,$plan_price){
    $sql = new Sql($this->adapter);
    $select= "insert into plan_stripe(plan_code,amount) values('$stripeplancode','$plan_price')";
    $result= $this->adapter->query($select,Adapter::QUERY_MODE_EXECUTE); 
    return $result;
  }
 public function patientUpdate($encryptcustid,$encryptsubsid,$patid)
 {
  $sql = new Sql($this->adapter);
  $select =$sql->update('patients')->set(array('cust_id'=>$encryptcustid,'subs_id'=>$encryptsubsid))->where(array('patient_id'=>$patid)) ;
 // echo $sql->getSqlStringForSqlObject($select); die;
  $statement = $sql->prepareStatementForSqlObject($select);
  $result=$this->resultSetPrototype->initialize($statement->execute()); 
  return $result;
 }
 public function patientsPaymentsInsert($patid,$planid,$amt,$status)
 {
  $sql = new Sql($this->adapter);
  $select= "insert into patients_payments (patient_id, plan_id,amount,pay_date,pay_status) values('$patid','$planid','$amt',now(),'1')";
  $result= $this->adapter->query($select,Adapter::QUERY_MODE_EXECUTE); 
  return $result;

 }
  public function updatePatientDetails($patid,$encriptnumber,$encriptexp_month,$encriptexp_year){
    $update_qry = "update patients set cc_number='$encriptnumber',cc_month='$encriptexp_month',cc_year='$encriptexp_year' where patient_id=$patid";
    $result = $this->adapter->query($update_qry, Adapter::QUERY_MODE_EXECUTE);
    return $result;
    }
 public function SpecialServicesList()
 {
   $sql =new Sql($this->adapter);
   $select= $sql->select()->from('spl_services');
   $statement = $sql->prepareStatementForSqlObject($select);
   $result=$this->resultSetPrototype->initialize($statement->execute())->toArray(); 
  return $result;
 }
    public function insertReferPatient($doclinkid,$pat_id,$docid,$comments)
  {
    $sql =new Sql($this->adapter);
    $select= $sql->insert('refer_patient')->values(array('patient_id'=>$pat_id,
        'refer_by'=> $docid   ,
        'comments'=>$comments ,
        'refer_to'=>$doclinkid,
     )) ;
    $statement = $sql->prepareStatementForSqlObject($select);
   $result=$this->resultSetPrototype->initialize($statement->execute()); 
  }
 public function DoctorReferralsListing($docid){
 $update_qry = "select p.*, r.*, d.doc_firstname, d.doc_lastname from patients p, refer_patient r, doctor_details d where r.refer_by=d.doc_id and p.patient_id=r.patient_id and d.doc_id=".$docid;
    $result = $this->adapter->query($update_qry, Adapter::QUERY_MODE_EXECUTE);
    return $result;
  }
  public function SpecilistPatientListing($docid){
   $update_qry = "select p.*, r.*, d.doc_firstname, d.doc_lastname from patients p, refer_patient r, doctor_details d where r.refer_by=d.doc_id and p.patient_id=r.patient_id and d.doc_id=".$docid; 
    $result = $this->adapter->query($update_qry, Adapter::QUERY_MODE_EXECUTE);
    return $result;
  }

}


