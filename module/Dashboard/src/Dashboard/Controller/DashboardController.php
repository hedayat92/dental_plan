<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Dashboard\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Dashboard\Model\Dashboard;    
use Dashboard\Model\DashboardTable; 
use Dashboard\Form\DashboardForm;
use Dashboard\Form\PermissionForm; 
use Dashboard\Form\RoleForm ; 
use Dashboard\Form\UsersForm ; 
use Dashboard\Form\ReportsForm ; 
use Dashboard\Form\CategoryForm ; 
use Dashboard\Form\ClientsForm ; 
use Dashboard\Form\EditRolepermissionForm ;
use ZF2AuthAcl\Utility\UserPassword;
use Zend\Mail\Message;
use Zend\Mime;
use Zend\Mail\Transport\Sendmail ;

//use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
class DashboardController extends AbstractActionController
{
	public $inputKey = "2345432AD12H";
	public $blockSize = 256;
	public $publishable_key = "pk_test_NLgzhGanpB897rKprLEh2dGq";
	public $stripesecret_key = 'sk_test_O02d4yUy6mq251y3wRD5lG6r';
	public function __construct(){	   
	  \Stripe\Stripe::setApiKey($this->stripesecret_key);	   

	}
    public function onDispatch(MvcEvent $e) {

 
           $tabledetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
           $session = new Container('User') ;
           $userid = $session->offsetGet('userId');
           $userrolepermission =  $this->getServiceLocator()->get("RolePermissionTable")->getRolePermissionsuser($userid);
           $session->offsetSet('userrolepermission', $userrolepermission);
        return parent::onDispatch($e);
        }

	public function indexAction()
	{
		   
    $totalpatient = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->totalpatientcount() ;
    return new ViewModel(array('payoutTotal'=>$totalpatient[0]['payoutTotal'],'commissionTotal'=>$totalpatient[0]['commissionTotal'],'totalPatients'=>$totalpatient[0]['totalPatients'],'patientsPayments'=>$totalpatient[0]['patientsPayments'],'refTotal'=>$totalpatient[0]['refTotal'],'totalSpecialist'=>$totalpatient[0]['totalSpecialist'],'totalDoctor'=>$totalpatient[0]['totalDoctor']));
	}
	
	 public function contactAction()
	 {    

		echo "dfd"; die ;
	// $this->layout()->setTemplate('layout/newLayout');	
	 $request= $this->getRequest();
	 if($request->isPost()){
       echo "fsdf";
        die;
	 }
    return new ViewModel();
	}
   
    public function changepasswordAction()
  {    
      $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
             $admin_pass = $request->getPost('admin_pass');
             $admin_cpass = $request->getPost('admin_cpass');
             if(strlen($admin_pass)<6) {
            $errmsg = 'Password length should be 6 characters';
             $err = 1;
             } else if($admin_pass!=$admin_cpass) {
            $errmsg = 'Password and confirm password should be same';
            $err = 1;
            }else{
            $session = new Container('User') ;
            $userid = $session->offsetGet('userId');
            $result= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->changeAdminPassword($admin_pass,$userid);  
            }

          }
      return new ViewModel(array('err'=>$err,'errmsg'=>$errmsg));
  }
    public function changeusernameAction()
  {    
      $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
             $admin_user = $request->getPost('admin_user');
             $admin_cuser = $request->getPost('admin_cuser');
             if (!filter_var($admin_user, FILTER_VALIDATE_EMAIL)) {
                $errmsg = "Invalid Email ID";
                $err = 1;
               }else if($admin_user!=$admin_cuser) {
                $errmsg = 'New Username and confirm username should be same';
               $err = 1;
              }else{
             $session = new Container('User') ;
             $userid = $session->offsetGet('userId');
             $result= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->changeAdminUsername($admin_user,$userid);  
            }
    }
      return new ViewModel(array('err'=>$err,'errmsg'=>$errmsg));
  }
   public function doctorgridAction()
		 {
		 $doctorActiveDetails =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorActiveDetails(); 
		 $doctorInactiveDetails =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorInActiveDetails();
     $activeDocNo= count($doctorActiveDetails);
     $inactiveDocNo= count($doctorInactiveDetails) ;
     $searchkey= $this->params()->fromRoute('id',null) ;
     $doctorgrid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorgridListing($searchkey);
     $view = new ViewModel(array('activeDocNo'=>$activeDocNo,'inactiveDocNo'=>$inactiveDocNo,'doctorgrid'=>$doctorgrid));
		 return $view;
		 }

   public function doctordetailsgridAction()
     {
     // select sum(pp.amount) as pat_total_revenue from patients_payments pp, patients p where p.patient_id = pp.patient_id and p.doc_id=".mysqli_real_escape_string($cn,$_GET['doc_id']));
     $doctorid= $this->params()->fromRoute('id',null); 
     $doctorgrid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
     $patTotalRevenue=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->patTotalRevenue($doctorid);
     $view = new ViewModel(array('doctorgrid'=>$doctorgrid,'patTotalRevenue'=>$patTotalRevenue));
     return $view;
     }
  public function doctoraddAction()
  {    
    $doctorid= $this->params()->fromRoute('id',null); 
    if(isset($doctorid)){
           $doctordetails=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
   }
     $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
          //  print_r($request->getPost());die ;
          $doc_username= $request->getPost('doc_username');
          $doc_id= $request->getPost('doc_id');
          $doc_pass= $request->getPost('doc_pass');
           $exists=0;
          $userdetails = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->checkUserid($doc_username) ;
          if(isset($userdetails[0]['doc_id'])&& !$doc_id){
            $exists = 1;
          }else{  
          $doc_firstname= $request->getPost('doc_firstname');
          $doc_lastname= $request->getPost('doc_lastname');
          $doc_email= $request->getPost('doc_email');
          $doc_phone= $request->getPost('doc_phone');
          $doc_zip= $request->getPost('doc_zip');
          $doc_address= $request->getPost('doc_address');
          $doc_phone2= $request->getPost('doc_phone2');
          $doc_sex= $request->getPost('doc_sex');
          $doc_speciality= $request->getPost('doc_speciality');
          $doc_license_no= $request->getPost('doc_license_no');
          $doc_contact_person= $request->getPost('doc_contact_person');
          $doc_status= $request->getPost('doc_status');
          $savedoctor =  $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->saveDoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username,$doc_pass);
           //echo '<pre>';print_r($savedoctor);exit;
           $this->redirect()->toRoute('dashboard',array('action'=>'doctorbank','id'=>$savedoctor));
           }
			
        }
     return new ViewModel(array('doctorid'=>$doctorid,'doctordetails'=>$doctordetails,'exists'=>$exists));
  }
	public function doctorbankAction()
	{    
		$doctorid= $this->params()->fromRoute('id',null); 
		if(isset($doctorid)){
		   $doctordetails=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
		}
		$request = $this->getRequest() ;    // getting current request object
		$success_msg='';
		
		
        if ($request->isPost())
        { 
			$stripeToken = $request->getPost('stripeToken');  
			$doc_data = array();  
			$doc_data['bank_routing_number']= $request->getPost('bank_routing_number');
			$doc_data['bank_account_number']= $request->getPost('bank_account_number');
			$doc_data['bank_account_type']= $request->getPost('bank_account_type');
			$doc_data['legal_name']= $request->getPost('legal_name');		
			$doc_data['doc_id']= $request->getPost('doc_id');          
			$savedoctor=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->savedoctorbank($doc_data);			
			$doctordetails=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
			//echo '<pre>'; print_r($doctordetails);
			$bank_rauting = new \MyModule\AES($doc_data['bank_routing_number'], $this->inputKey, $this->blockSize);
			$enc_rauting = $bank_rauting->encrypt();
			$bank_account = new \MyModule\AES($doc_data['bank_account_number'], $this->inputKey, $this->blockSize);
			$enc_account = $bank_rauting->encrypt();
			
				\Stripe\Stripe::setApiKey($this->stripesecret_key);
				$account = \Stripe\Account::create(array(
				  "managed" => true,
				  "country" => "US",
				  "external_account" => array(
					"object" => "bank_account",
					"country" => "US",
					"currency" => "usd",
					"routing_number" => $enc_rauting,
					"account_number" => $enc_account,
				  ),
				  "tos_acceptance" => array(
					"date" => "1460094682",
					"ip" => "122.160.74.176"
				  )
				));
				$aes = new \MyModule\AES($account->id, $this->inputKey, $this->blockSize);
				$enc_acid = $aes->encrypt();
				
				/*\Stripe\Stripe::setApiKey($this->stripesecret_key);
				$account = \Stripe\Account::create(array(
				"managed" => false,
				"country" => "US",
				"email" => $doctordetails[0]['doc_email']
				));
				
				$aes = new \MyModule\AES($account->id, $this->inputKey, $this->blockSize);
				$enc_acid = $aes->encrypt();				
				//$enc_acid = $account->id;	
				*/			
				//echo '<pre>';
				//print_r($account);
				/*$cu = \Stripe\Account::retrieve($account->id);
				$bankdetails = $cu->external_accounts->create(array("external_account" => $stripeToken));
				
				$aes = new \MyModule\AES($bankdetails->id, $this->inputKey, $this->blockSize);
				$enc_acid = $aes->encrypt();*/
				
				//$aes->setData($enc);
				//$subs_id=$enc ;
				
				
				
				$doc_ac_data = array();
				$doc_ac_data['account_id'] = $enc_acid;
				$doc_ac_data['bank_acc_id'] = '';
				$doc_ac_data['doc_id'] = $doc_data['doc_id'];
				
				$savedoctorac=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->saveDoctorBankAc($doc_ac_data);
				$success_msg='Bank account saved successfully.';
				/*$update_qry = "update doctor_details set account_id='".mysqli_real_escape_string($cn,myencrypt($account->id))."' where doc_id=".mysqli_real_escape_string($cn,$doc_id);
				mysqli_query($cn,$update_qry);*/
				
				/*$update_qry = "update doctor_details set bank_acc_id='".mysqli_real_escape_string($cn,myencrypt($bankdetails->id))."' where doc_id=".mysqli_real_escape_string($cn,$doc_id);
				mysqli_query($cn,$update_qry);*/

				
				//  print_r($request->getPost());die ;
        
        }
        //print_r($doctordetails);
     return new ViewModel(array('success_msg'=>$success_msg,'doctorid'=>$doctorid,'doctordetails'=>$doctordetails,'publishable_key'=>$this->publishable_key));
  }
  public function doctorccpayAction()
  {    
     $action = $this->params()->fromRoute('id',null); 
     $request= $this->getRequest();
     //$session = new Container('User');
     $docid  = $this->params()->fromRoute('idd',null);
     $inputKey = "2345432AD12H";
     $blockSize = 256;
     $doctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($docid);
     $doctor_custid= $doctorDetails[0]['cust_id'] ;
     
     if($action==8){                    /*   for cancel subscription   */
		$inputText =$doctor_custid;
		//$aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
		//$dec=$aes->decrypt();
		 
		\Stripe\Stripe::setApiKey($this->stripesecret_key);
		$cu = \Stripe\Customer::retrieve($doctor_custid);

		$inputText = $doctorDetails[0]['subs_id'] ;
		$aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
		$dec_subid=$aes->decrypt();

		$cu->subscriptions->retrieve($dec_subid)->cancel();
		$updateDoctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->cancelDoctorSubscription($docid);

     }else if($action==3){

       
      /*
    $inputText =$custid;
    \Stripe\Stripe::setApiKey($stripe['secret_key']);
    $aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
    $dec=$aes->decrypt(); 
      echo  $stripeToken ;
      $cu = \Stripe\Customer::retrieve($dec);
      $cu->source = $stripeToken; // obtained with Stripe.js
      $cu->save();
       */
     }
     if($request->isPost()){

		$number = $request->getPost('number');
		$cvc       = $request->getPost('cvc');
		$exp_month  = $request->getPost('exp_month');
		$exp_year = $request->getPost('exp_year');
		$stripeToken = $request->getPost('stripeToken');
		$data  = substr($number,-4);
		/**create cc_number*/
		$inputText = $data;
		//$vendor = new \MyModule\AES();
		$aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
		$enc = $aes->encrypt();
		$aes->setData($enc);
		$number_aes =$enc;

		if($action==3){               // for change subscription 
		$doctor_custid= $doctorDetails[0]['cust_id'] ;

		$inputText = $doctor_custid;

		// $vendor = new \MyModule\AES();
		$aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
		$dec = $aes->decrypt(); 
		// $dec = 'cus_85lvrrlNI8RjNl';
		$cu = \Stripe\Customer::retrieve($dec);
		$cu->source = $stripeToken; // obtained with Stripe.js
		$cu->save();
		}else{
		$email =$doctorDetails[0]['doc_email'];
		$cust = \Stripe\Customer::create(array(
		 "description" => "Customer - ".$email,
		 "source" => $stripeToken,
		 ));

		$cu = \Stripe\Customer::retrieve($cust->id);

		$subs = $cu->subscriptions->create(array("plan" => "docplan"));
		/*  code of myencript function    start    */
		if(trim($subs->id)) {
		$inputText = $subs->id;
		$aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
		$enc = $aes->encrypt();
		$aes->setData($enc);
		$subs_id=$enc ;
		} 



		/*  code of myencript function    end     */

		$DoctorSubscriptionInNotChange= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->updateDoctorSubscriptionInNotChange($subs_id,$cust->id,$docid);   
		//echo '#1';
		if($subs->id){

			$DoctorSubscriptionInNotChange= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->insertDoctorSubscriptionInNotChange($docid,($subs->plan['amount']/100));
		 //   echo '#2';exit;
		 }
		}

		$updateDoctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->updateDoctorDetails($docid,$number_aes,$cvc,$exp_month,$exp_year); 

		$this->redirect()->toUrl('/dashboard/doctorccpay/'.$action.'/'.$docid);
	}
     $cc_number=$doctorDetails[0]['cc_number'] ;
     if(!empty($cc_number)){   // check if $inputText value exist .
     $inputText = $cc_number;
     $aes = new \MyModule\AES($inputText,$inputKey,$blockSize);
     $cc_numberAfterDecription=$aes->decrypt();
     }
     //print_r($doctorDetails);exit;
     return new ViewModel(array('docUserID'=>$docid,'doctorDetails'=>$doctorDetails,'cc_numberDecription'=>$cc_numberAfterDecription,'action'=>$action,'publishable_key'=>$this->publishable_key));
  }

  public function specialistdoctorgridAction()
     {
     $doctorActiveDetails =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->specialistdoctorActiveDetails(); 
     $doctorInactiveDetails =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->specialistdoctorInActiveDetails();
     $activeDocNo= count($doctorActiveDetails);
     $inactiveDocNo= count($doctorInactiveDetails) ;
    $searchkey= $this->params()->fromRoute('id',null) ;
     $specialistdoctorgrid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->specialistdoctorgridListing($searchkey);
    // print_r($specialistdoctorgrid);die ;
     $view = new ViewModel(array('activeDocNo'=>$activeDocNo,'inactiveDocNo'=>$inactiveDocNo,'specialistdoctorgrid'=>$specialistdoctorgrid));
     return $view;
     }
     
   public function specialistsdoctoraddAction()
    {    
    $doctorid= $this->params()->fromRoute('id',null); 
    if(isset($doctorid)){
           $doctordetails=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
      }
     $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
          $doc_contact_person= $request->getPost('doc_contact_person');
          $doc_username= $request->getPost('doc_username');
          $doc_pass= $request->getPost('doc_pass');
           $exists=0;
          $doc_id= $request->getPost('doc_id');
          $userdetails = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->checkUserid($doc_username) ;
          if(isset($userdetails[0]['doc_id'])&& !$doc_id){
            $exists = 1;
          }else{
          $doc_firstname= $request->getPost('doc_firstname');
          $doc_lastname= $request->getPost('doc_lastname');
          $doc_email= $request->getPost('doc_email');
          $doc_phone= $request->getPost('doc_phone');
          $doc_zip= $request->getPost('doc_zip');
          $doc_address= $request->getPost('doc_address');
          $doc_phone2= $request->getPost('doc_phone2');
          $doc_sex= $request->getPost('doc_sex');
          $doc_speciality= $request->getPost('doc_speciality'); 
          $doc_speciality_detail= $request->getPost('doc_speciality_detail'); 
          $doc_license_no= $request->getPost('doc_license_no');
          $doc_contact_person= $request->getPost('doc_contact_person');
          $doc_status= $request->getPost('doc_status');
         
          $savedoctorid =  $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->saveDoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username,$doc_pass,$doc_speciality_detail);
          if(!$doc_id){
            $doc_id=$savedoctorid ;
          }
          $this->redirect()->toUrl("/dashboard/doctorspacilistccpay/$doc_id");
            }
          }
    return new ViewModel(array('doctorid'=>$doctorid,'doctordetails'=>$doctordetails,'exists'=>$exists));
  }

    public function docpaydetailAction()
     {
     $frameid= $this->params()->fromRoute('idd',null); 
       $doctorid = $this->params()->fromRoute('id',null); 
      if($frameid=='1') {
       $paymentreports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->docPayDetails($doctorid,$frameid) ;
       } else if($frameid=='2') {
      $paymentreports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->docPayDetails($doctorid,$frameid) ;
       } else if($frameid=='3') {
       $paymentreports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->docPayDetails($doctorid,$frameid) ;
       } else {
       $paymentreports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->docPayDetails($doctorid,$frameid) ;
       }
     $doctorgrid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
   //  $patTotalRevenue=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->patTotalRevenue($doctorid);
     $view = new ViewModel(array('doctorgrid'=>$doctorgrid,'paymentreports'=>$paymentreports,'frameid'=>$frameid));
     return $view;
     }
       public function doctorsdelAction()
    {   
         $id = (int) $this->params()->fromRoute('id',null);
         $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteDoctors($id);
         $this->redirect()->toRoute('dashboard',array('action'=>'doctorgrid'));
    }
    public function doctorimagechangeAction()
      {   
         $doc_id = (int) $this->params()->fromRoute('id',null);
         $msg_del_done = (int) $this->params()->fromRoute('idd',null);
         $uploadOk = 1;
         $success_msg=1 ;
         $doc_avatardetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectDoctorAvatar($doc_id) ;
         $request = $this->getRequest() ;    // getting current request object		 
         if ($request->isPost())
         { 
           $doc_avatar = 'avatar_'.$doc_id.substr($_FILES["doc_avatar"]["name"],strpos($_FILES["doc_avatar"]["name"],'.'));
            $target_file = $_SERVER['DOCUMENT_ROOT']."/img/placeholders/avatars/".$doc_avatar;
           $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
           // Check if image file is a actual image or fake image
          $check = getimagesize($_FILES["doc_avatar"]["tmp_name"]);
    if($check== false) {
      //  $err[] = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 0;
           $success_msg=1 ;
    }else if($_FILES["doc_avatar"]["size"] > 500000) {
   // $err[] = "Sorry, your file is too large.";
    $uploadOk = 0;
       $success_msg=1 ;
      echo "2";
   }else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  //  $err[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
 
    echo "3";
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $success_msg=1 ;
  }else{	
        
           $saveavatar= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editDoctorAvatar($doc_id,$doc_avatar);
          $doc_avatardetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectDoctorAvatar($doc_id) ;
	         move_uploaded_file($_FILES["doc_avatar"]["tmp_name"], $target_file); 
           $success_msg=3 ;
          $success_msgtext= "The file ". basename($_FILES["doc_avatar"]["name"]). " has been uploaded.";
	        return new ViewModel(array('success_msg'=>$success_msg,'id'=>$doc_id,'doc_avatar'=>$doc_avatardetail,'msg_del_done'=>$msg_del_done,'uploadOk'=>$uploadOk,'success_msgtext'=>$success_msgtext));
        }  	           
       }
       return new ViewModel(array('success_msg'=>$success_msg,'id'=>$doc_id,'doc_avatar'=>$doc_avatardetail,'msg_del_done'=>$msg_del_done,'uploadOk'=>$uploadOk,'success_msgtext'=>$success_msgtext));
    }
    public function deletedoctorimageAction(){
    $doctorid = (int) $this->params()->fromRoute('id',null);
    $msg_del_done=2;
    $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteDoctorImage($doctorid);
    $this->redirect()->toRoute('dashboard',array('action'=>'doctorimagechange','id'=>$doctorid,'idd'=>$msg_del_done));
    }
    public function docpayoutdetailAction(){
     $doctorid = (int) $this->params()->fromRoute('id',null);
     $doctordetails=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
    
     $reg_dt=$doctordetails[0]['add_date'];
     $curr_dt = date('Y-m-d',time());
     $st_dt = $reg_dt;
     $docpayoutdetail=Array();
     $i=0;
     while($curr_dt>$st_dt) {
    $en_dt = date('Y-m-d',strtotime("+1 month",strtotime($st_dt)));
   
    $span = date('d-m-Y',strtotime($st_dt))." - ".date('d-m-Y',strtotime($en_dt));
    $chkpayout=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->paidAmount($st_dt,$en_dt,$doctorid);
    $spanamt=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->spanAmount($st_dt,$en_dt,$doctorid);
    $docpayoutdetail[$i]['span']= $span  ;
    $docpayoutdetail[$i]['chkpayout']= $chkpayout  ;
    $docpayoutdetail[$i]['spanamt']= $spanamt  ;
    $st_dt = $en_dt;
    $i++;
}
    $view = new ViewModel(array('doctordetails'=>$doctordetails,'doctorid'=>$doctorid,'curr_dt'=>$curr_dt,'st_dt'=>$st_dt,'docpayoutdetail'=>$docpayoutdetail));
     return $view;
    }

     


  public function listpatientsAction()
     {
     $doctorid= $this->params()->fromRoute('id',null); 
     $listpatient=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->listPatient($doctorid);
     $listPatientsId=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->listPatientsId();
     $view = new ViewModel(array('listpatient'=>$listpatient,'listPatientsId'=>$listPatientsId));
     return $view;
     }
     public function patientdetailsAction()
     {
     $patid= $this->params()->fromRoute('id',null); 
     $doctorid= $this->params()->fromRoute('idd',null); 
     $listPatients=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->listPatientsId();
     $listPatientForDocPatient=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->listPatientForDocPatient($patid,$doctorid);
     $view = new ViewModel(array('listPatientForDocPatient'=>$listPatientForDocPatient,'listPatients'=>$listPatients));
     return $view;
     }
     public function supportAction(){
       return new ViewModel(array(
            'support' => $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewSupport()));
    }
    public function reportsAction(){
      $reportid = $this->params()->fromRoute('id',null); 
      if($reportid=='1') {
       $reports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewReports($reportid) ;
       } else if($reportid=='2') {
      $reports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewReports($reportid) ;
       } else if($reportid=='3') {
       $reports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewReports($reportid) ;
       } else {
       $reports = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewReports($reportid) ;
       }
       return new ViewModel(array('reports' =>$reports,'reportid'=>$reportid));
    }

    public function viewrolesAction()
    {
       $form = new RoleForm($rolevalue) ;
       $form->get('submit')->setValue('Update Role');           
       $permission=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewPermission();                                                                 
       $role=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewRoles();
       $rolepermission=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewRolesPermission();
       return new ViewModel(array('form' => $form,'role'=>$role,'permission'=>$permission,'rolepermission'=>$rolepermission));
    }
      public function reportAction()
      {
       $reportid = $this->params()->fromRoute('id',null);
       $form = new RoleForm($rolevalue) ;
       $form->get('submit')->setValue('Update Role');           
       $permissiondetail=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getPermissionById($reportid);                                                                 
       return new ViewModel(array('reportdetail'=>$permissiondetail,'tokenno'=>$this->_token));
      }
   
	
	
	
	/*-------------------Abhishek-------------------*/
	public function planAction($id = null){	 
      $doctorid= $this->params()->fromRoute('id',null);
	  $plan_list = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlansAsDoc($doctorid) ;
	  return new ViewModel(array('plans'=>$plan_list,'doc_id'=>$doctorid));

     }
	
	public function planViewAction($id = null,$idd = null){
		 $planid= $this->params()->fromRoute('id',null);
		 $doc_id= $this->params()->fromRoute('idd',null);
		 $plan_list = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlans($planid) ;
		 $plan_service = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlanServices($planid) ;
return new ViewModel(array('plans'=>$plan_list,'plan_id'=>$planid,'plan_services'=>$plan_service,'doc_id'=>$doc_id));
     }
	
	
	public function planDeleteAction($id = null,$idd = null){
		 $planid= $this->params()->fromRoute('id',null);
		 $doc_id= $this->params()->fromRoute('idd',null);		 
         $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deletePlans($planid);         
         $this->redirect()->toRoute('dashboard',array('action'=>'plan','id'=>$doc_id));
     }
	
	 public function plansserviceAction($id = null,$idd = null,$iddd = null){
		  $planid= $this->params()->fromRoute('id',null);
		  $service_id= $this->params()->fromRoute('idd',null);			
		  $doc_id= $this->params()->fromRoute('iddd',null);
		 if($service_id !=0){
		 $request = $this->getRequest() ;    // For Edit Plan Services		
        if ($request->isPost())          { 
			 $service_type  = $request->getPost('service_type');
			 $service_name  = $request->getPost('service_name');
			 $service_name1 = $service_name[0];
			 $service_name2 = $service_name[1];
			 $service_name3 = $service_name[2];
			 $service_name4 = $service_name[3];
			 $service_name5 = $service_name[4];
			 $service_name6 = $service_name[5];
			 $service_name7 = $service_name[6];
			 $service_name8 = $service_name[7];
			 $service_name9 = $service_name[8];
			 $service_name10 = $service_name[9];
			 $service_notes = $request->getPost('service_notes');	
//	print_r($service_name);exit;
$saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editPlanServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes);
	 $this->redirect()->toRoute('dashboard',array('action'=>'plan_edit','id'=>$planid,'idd'=>$doc_id));	 
		}	 
		 
	 }else{
			 
		$request = $this->getRequest() ;    // For Edit Plan Services		
        if ($request->isPost()) { 
			 $service_type  = $request->getPost('service_type');
			 $service_name  = $request->getPost('service_name');
			 $service_name1 = $service_name[0];
			 $service_name2 = $service_name[1];
			 $service_name3 = $service_name[2];
			 $service_name4 = $service_name[3];
			 $service_name5 = $service_name[4];
			 $service_name6 = $service_name[5];
			 $service_name7 = $service_name[6];
			 $service_name8 = $service_name[7];
			 $service_name9 = $service_name[8];
			 $service_name10 = $service_name[9];
			 $service_notes = $request->getPost('service_notes');	
	//print_r($request);exit;
$saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->addPlanServices($service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes,$planid);
	 $this->redirect()->toRoute('dashboard',array('action'=>'plan_edit','id'=>$planid,'idd'=>$doc_id));	  
		 }
	 }
			 $services = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectSingleServices($service_id) ;		
				return new ViewModel(array('services'=>$services,'plan_id'=>$planid,'service_id'=>$service_id,'doc_id'=>$doc_id));
	 }	
  
  
public function doctorspacilistccpayAction()
  {   
     $docurlid = $this->params()->fromRoute('id',null); 
     $request= $this->getRequest();
     $session = new Container('User');
     $docid  =$session->offsetGet('userId');
     $inputKey = "2345432AD12H";
     $blockSize = 256;
     $doctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($docurlid);
     $custid=$doctorDetails[0]['cust_id']; 
     if($request->isPost()){
        $number = $request->getPost('number');
        $cvc       = $request->getPost('cvc');
        $exp_month  = $request->getPost('exp_month');
        $exp_year = $request->getPost('exp_year');
        $stripeToken = $request->getPost('stripeToken');
        $docurlid = $request->getPost('doc_id');
        $data  = substr($number,-4);
        if($docurlid) { 
         $email =$doctorDetails[0]['doc_email'];
         $cust = \Stripe\Customer::create(array(
  "description" => "Customer - ".$email,
  "source" => $stripeToken
      ));
         $cu = \Stripe\Customer::retrieve($cust->id);
         $subs = $cu->subscriptions->create(array("plan" => "splplan"));
         /*  code of myencript function    start    */
         if(trim($subs->id)) {
         $inputText = $subs->id;
         $aes = new \MyModule\AES($inputText, $this->inputKey, $this->blockSize);
         $enc = $aes->encrypt();
         $aes->setData($enc);
         $subs_id=$enc ;
         } 
         /*  code of myencript function    end     */
         $encriptCust_id=$cust->id ;
         $DoctorSubscriptionInNotChange= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->updateDoctorSubscriptionInNotChange($subs_id,$encriptCust_id,$docurlid);   
         if($subs->id){
            $DoctorSubscriptionInNotChange= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->insertDoctorSubscriptionInNotChange($docurlid,($subs->plan['amount']/100));
         }
        $inputText = $data;
        $aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
        $enc = $aes->encrypt();
        $aes->setData($enc);
        $number_aes =$enc; 
        $updateDoctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->updateDoctorDetails($docurlid,$number_aes,$cvc,$exp_month,$exp_year);
        $this->redirect()->toUrl('/dashboard/specialistdoctorgrid') ;     
  } 
}
     $cc_number=$doctorDetails[0]['cc_number'] ; 
     if(!empty($cc_number)){   // check if $inputText value exist .
     $inputText = $cc_number;
     $aes = new \MyModule\AES($inputText,$inputKey,$blockSize);
     $cc_numberAfterDecription=$aes->decrypt();
     }
return new ViewModel(array('docUserID'=>$docurlid,'doctorDetails'=>$doctorDetails,'action'=>$action,'publishable_key'=>$this->publishable_key,'cc_numberDecription'=>$cc_numberAfterDecription));
  }
   
 public function specialistdelAction()
    {   
         $id = (int) $this->params()->fromRoute('id',null);
         $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteDoctors($id);
         $this->redirect()->toRoute('dashboard',array('action'=>'specialistdoctorgrid'));
    }
 public function specialistsdetailsgridAction()
     {
     $doctorid= $this->params()->fromRoute('id',null); 
     $doctorgrid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorDetailsFromId($doctorid);
     $refercount=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->referPatient($doctorid);
     $view = new ViewModel(array('doctorgrid'=>$doctorgrid,'refercount'=>$refercount[0]['refercount']));
     return $view;
     }
public function specialserviceAction()
{
  $docid = (int) $this->params()->fromRoute('id',null);
  $splServices =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->splServices($docid);
  $view = new ViewModel(array('splServices'=>$splServices));
  return $view;
} 
public function specialservicedetailAction()
{
  $serviceid = (int) $this->params()->fromRoute('id',null);
  $splServices =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->splServicesDetails($serviceid);
  $view = new ViewModel(array('splServicesDetail'=>$splServices));
  return $view;
} 
public function deletespecialserviceAction($id = null){
     $deletespecialserviceid= $this->params()->fromRoute('id',null);
     $docid= $this->params()->fromRoute('idd',null);  
     $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteSpecialServiceid($deletespecialserviceid);
     $this->flashMessenger()->addMessage(array(
                        'error' => 'Sorry, an incorrect username and/or password has been entered.'
                  ));     
     $this->redirect()->toRoute('dashboard',array('action'=>'specialservice','id'=>$docid));
     }
public function specialserviceeditAction(){
      $service_id= $this->params()->fromRoute('id',null);      
      $doc_id= $this->params()->fromRoute('idd',null);
      $request = $this->getRequest() ;    // For Edit Plan Services    
        if ($request->isPost()) { 
       $service_type  = $request->getPost('service_type');
       $service_name  = $request->getPost('service_name');
       $service_name1 = $service_name[0];
       $service_name2 = $service_name[1];
       $service_name3 = $service_name[2];
       $service_name4 = $service_name[3];
       $service_name5 = $service_name[4];
       $service_name6 = $service_name[5];
       $service_name7 = $service_name[6];
       $service_name8 = $service_name[7];
       $service_name9 = $service_name[8];
       $service_name10 = $service_name[9];
       $service_price = $request->getPost('price'); 
       $doc_id = $request->getPost('doc_id'); 
       $service_id = $request->getPost('service_id'); 
      $addnext = $request->getPost('addnext'); 
       if($service_id==0){
      $saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->insertSingleSPlServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_price,$doc_id);
       if($addnext==1){
          $this->redirect()->toRoute('dashboard',array('action'=>'specialserviceedit','id'=>0,'idd'=>$doc_id));
          }else{
          $this->redirect()->toRoute('dashboard',array('action'=>'specialservice','id'=>$doc_id));
          }
     }else{
        $saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editSingleSPlServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_price,$doc_id);
        if($addnext==1){
          $this->redirect()->toRoute('dashboard',array('action'=>'specialserviceedit','id'=>0,'idd'=>$doc_id));
          }else{
          $this->redirect()->toRoute('dashboard',array('action'=>'specialservice','id'=>$doc_id));
          }
     }
    }  
  $services = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectSingleSPlServices($service_id) ;
  return new ViewModel(array('services'=>$services,'plan_id'=>$planid,'service_id'=>$service_id,'doc_id'=>$doc_id));
   }  

   public function planEditAction($id = null,$idd = null){
         $planid= $this->params()->fromRoute('id',null);
       $doc_id= $this->params()->fromRoute('idd',null);
     if(!empty($planid)){
     $request = $this->getRequest() ;    // For Edit Plan
      // print_r($request);exit;
        if ($request->isPost())
          {  
       $doc_id = $request->getPost('doc_id');
       $plan_name = $request->getPost('plan_name');
       $heading_line = $request->getPost('heading_line');
       $plan_monthly_price = $request->getPost('plan_monthly_price');
       $plan_yearly_price = $request->getPost('plan_yearly_price');
       $addon_monthly_price = $request->getPost('addon_monthly_price');
       $addon_yearly_price = $request->getPost('addon_yearly_price'); 
$saveplan=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editPlans($planid,$doc_id,$plan_name,$heading_line,$plan_monthly_price,$plan_yearly_price,$addon_monthly_price,$addon_yearly_price);
   $this->redirect()->toRoute('dashboard',array('action'=>'plan','id'=>$doc_id)); 
      }   
    $plan_list = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlans($planid) ;
       $plan_service = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlanServices($planid) ;
return new ViewModel(array('plans'=>$plan_list,'plan_id'=>$planid,'plan_services'=>$plan_service,'doc_id'=>$doc_id));  
       
      }else{
    $request = $this->getRequest() ;    // For Insert Plan
        if ($request->isPost())
          {  
       $doc_id = $request->getPost('doc_id');
       $plan_name = $request->getPost('plan_name');
       $heading_line = $request->getPost('heading_line');
       $plan_monthly_price = $request->getPost('plan_monthly_price');
       $plan_yearly_price = $request->getPost('plan_yearly_price');
       $addon_monthly_price = $request->getPost('addon_monthly_price');
       $addon_yearly_price = $request->getPost('addon_yearly_price'); 
$lastplanid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->addPlans($doc_id,$plan_name,$heading_line,$plan_monthly_price,$plan_yearly_price,$addon_monthly_price,$addon_yearly_price);
$this->redirect()->toRoute('dashboard',array('action'=>'spacilistplansservice','id'=>$lastplanid,'idd'=>0,'iddd'=>$doc_id)); 
    }        
return new ViewModel(array('doc_id'=>$doc_id));       
   }
   }
  public function spacilistplansserviceAction(){
     $planid= $this->params()->fromRoute('id',null);
      $service_id= $this->params()->fromRoute('idd',null);     
      $doc_id= $this->params()->fromRoute('iddd',null);
     if($service_id !=0){
     $request = $this->getRequest() ;    // For Edit Plan Services    
        if ($request->isPost())          { 
       $service_type  = $request->getPost('service_type');
       $service_name  = $request->getPost('service_name');
       $service_name1 = $service_name[0];
       $service_name2 = $service_name[1];
       $service_name3 = $service_name[2];
       $service_name4 = $service_name[3];
       $service_name5 = $service_name[4];
       $service_name6 = $service_name[5];
       $service_name7 = $service_name[6];
       $service_name8 = $service_name[7];
       $service_name9 = $service_name[8];
       $service_name10 = $service_name[9];
       $service_notes = $request->getPost('service_notes'); 
//  print_r($service_name);exit;
$saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editPlanServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes);
   $this->redirect()->toRoute('dashboard',array('action'=>'plan_edit','id'=>$planid,'iddd'=>$doc_id));  
    }  
     
   }else{

        $request = $this->getRequest() ;    // For Edit Plan Services  
        if ($request->isPost()) { 
       $service_type  = $request->getPost('service_type');
       $service_name  = $request->getPost('service_name');
       $service_name1 = $service_name[0];
       $service_name2 = $service_name[1];
       $service_name3 = $service_name[2];
       $service_name4 = $service_name[3];
       $service_name5 = $service_name[4];
       $service_name6 = $service_name[5];
       $service_name7 = $service_name[6];
       $service_name8 = $service_name[7];
       $service_name9 = $service_name[8];
       $service_name10 = $service_name[9];
       $service_notes = $request->getPost('service_notes'); 
       $addnext = $request->getPost('addnext'); 
       $planid  = $request->getPost('plan_id');
      $saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->addPlanServices($service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes,$planid);
       if($addnext==1){
          $this->redirect()->toRoute('dashboard',array('action'=>'spacilistplansservice','id'=>$planid,'idd'=>0,'iddd'=>$doc_id));
          }else{
          $this->redirect()->toRoute('dashboard',array('action'=>'plan_edit','id'=>$planid,'idd'=>$doc_id)); 
          }
     }
   }
   if($service_id){
  $services = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectSingleServices($service_id) ;   
    }
  return new ViewModel(array('services'=>$services,'plan_id'=>$planid,'service_id'=>$service_id,'doc_id'=>$doc_id));
}  

}
