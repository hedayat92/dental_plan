<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Dashboardfront\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboardfront\Model\Dashboardfront;    
use Dashboardfront\Model\DashboardfrontTable;
use Zend\Session\Container;
use Zend\Mail\Message;
use Zend\Mime;
use Zend\Mail\Transport\Sendmail ; 
use Zend\dental\Service\AES;
//use Zend\Mvc\ModuleRouteListener;


use Zend\Mvc\MvcEvent;
class DashboardfrontController extends AbstractActionController
{
  public $inputKey = "2345432AD12H";
  public  $blockSize = 256;
  public $publishable_key = "pk_test_NLgzhGanpB897rKprLEh2dGq";
  public $stripesecret_key = 'sk_test_O02d4yUy6mq251y3wRD5lG6r';
  public function __construct(){
   $stripe['secret_key'] = ('sk_test_O02d4yUy6mq251y3wRD5lG6r');
   $stripe['publishable_key'] = ('pk_test_NLgzhGanpB897rKprLEh2dGq');
  \Stripe\Stripe::setApiKey($stripe['secret_key']);
   $inputKey = "2345432AD12H";
   $blockSize = 256;

}

  public function indexAction()
	{ 
	 return new ViewModel();
	}
    
    public function aboutusAction()
	{    
    return new ViewModel();
	}
    public function featuresAction()
	{    
    return new ViewModel();
	}
      
      public function pricingAction()
	{    
		
     return new ViewModel();
	}
      public function termsconditionAction()
  {    
    
     return new ViewModel();
  }
      public function privacypolicyAction()
  {    
    
     return new ViewModel();
  }
  public function planchoiseAction()
  {  
     $listplans= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PlansListing(); 
     $listplanservice= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->listplanservice(); 
    
     return new ViewModel(array('listplans'=>$listplans,'listplanservice'=>$listplanservice));
  }
   public function planselectionAction()
  {  $planservicetid = $this->params()->fromRoute('id',null); 
     $listplanservice= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PlanDetails($planservicetid); 
     $planservicedetails  = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PlanserviceDetails($planservicetid); 
     return new ViewModel(array('listplanservice'=>$listplanservice,'planservicedetails'=>$planservicedetails));
  }

  public function patienteditAction()
  {    
     $planid = $this->params()->fromRoute('id',null);
     $parentid = $this->params()->fromRoute('idd',null);  
 
    $session = new Container('User');
     $docid  =$session->offsetGet('userId');
     $request= $this->getRequest();
     if($request->isPost()){

      // print_r($request->getPost());die;
      $plan_id=$request->getPost('plan_id');
     // echo "fdf";
      //echo $plan_id;die;
      $plan_cycle=$request->getPost('plan_cycle');
      $patient_salutation=$request->getPost('patient_salutation');
      $patient_firstname=$request->getPost('patient_firstname');
      $patient_lastname=$request->getPost('patient_lastname');
      $patient_dob=$request->getPost('patient_dob');
      $patient_ssn=$request->getPost('patient_ssn');
      $patient_sex=$request->getPost('patient_sex');
      $patient_address=$request->getPost('patient_address');
      $patient_zip=$request->getPost('patient_zip');
      $patient_phone=$request->getPost('patient_phone');
      $patient_mobile=$request->getPost('patient_mobile');
      $patient_email=$request->getPost('patient_email');
      $patient_password=$request->getPost('patient_password');
      $pat_id=$request->getPost('pat_id');
      $addon=$request->getPost('addon');
      $parentid=$request->getPost('parent_id');
      $patient_status=$request->getPost('patient_status');
      $patient_consent=$request->getPost('patient_consent');
    if($patient_status=='on')
    $pstatus = 1;
    else
    $pstatus = 0;

    if($patient_consent=='on')
    $pconsent = 1;
    else
    $pconsent = 0;


      $parentid=$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->insertPatient($planid,$plan_cycle,$patient_salutation,$patient_firstname,$patient_lastname,$patient_dob,$patient_ssn,$patient_sex,$patient_address,$patient_zip,$patient_phone,$patient_mobile,$patient_email,$patient_password,$pat_id,$addon,$parentid,$docid); 
     // echo  $pat_id ;die;
      if($pat_id){



      }else{
       //get parent
       $patientdetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetailsById($parentid);  
       $parent_id  =$patientdetails[0]['parent_id'] ;
       if($parent_id!=0)
        $parentid = $parent_id;
       
       if($patientdetails[0]['parent_id']==0){
           $plandetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PlanDetails($planid);
                    $plan_name =$plandetails['0']['plan_name'] ;
                       $session = new Container('User');
                       $docid  =$session->offsetGet('userId');
                       $get_doc_details= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($docid);
                       $doc_name = $get_doc_details[0]['doc_firstname'].' '.$get_doc_details[0]['doc_lastname'];
                       $doc_phone = $get_doc_details[0]['doc_phone'];
                       $doc_address = $get_doc_details[0]['doc_address'].','.$get_doc_details[0]['doc_zip'];

                       $ragisteremail ='admin@dentalplansoftware.com' ;
     // $email ='skant1990it@gmail.com' ;
        $maillink='<table cellpadding="0" cellspacing="0" border="0" width="950" align="center">
      <tr>
          <td valign="top" colspan="3" height="30"></td>
        </tr>
      <tr>
          <td valign="top" width="30px;"></td>
            <td valign="top">
              <table cellpadding="0" cellspacing="0" border="0" width="890" align="center">
                    <tr>
                      <td valign="top" colspan="2"><img src="http://dentalplansoftware.com/front_img/logo3.png" width="889" height="136" alt="" title="" /></td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2" height="30"></td>
                    </tr>
                    <tr>
                      <td valign="top" width="445"></td>
                        <td valign="top" width="445">
                          <table cellpadding="0" cellspacing="0" border="0" width="445">
                                <tr>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:34px; color:#626363">Patient Name:&nbsp;<strong style="color:#2aa7e2;">'.$patient_firstname.' '.$patient_lastname.'</strong></td>
                                </tr>
                                <tr>
                                    <td valign="top" colspan="2" height="20"></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:29px; color:#626363">Patient ID:&nbsp;<strong style="color:#2aa7e2;">'.$patient_email.'</strong></td>
                                </tr>
                                <tr>
                                    <td valign="top" colspan="2" height="20"></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:29px; color:#626363">Plan Type:&nbsp;<strong style="color:#2aa7e2;">'.$plan_name.'</strong></td>
                                </tr>
                                <tr>
                                    <td valign="top" colspan="2" height="35"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2" height="30"></td>
                    </tr>
                    <tr>
                      <td valign="top" width="445" bgcolor="#2aa7e2"></td>
                        <td valign="top" width="445" bgcolor="#2aa7e2">
                          <table cellpadding="0" cellspacing="0" border="0" width="445">
                              <tr>
                                    <td valign="top" colspan="2" height="30"></td>
                                </tr>
                                <tr>
                                  <td valign="top" width="50"><img src="http://dentalplansoftware.com/front_img/front_07.png" width="39" height="39" /></td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:29px; color:#ffffff">'.$doc_name.'</td>
                                </tr>
                                <tr>
                                    <td valign="top" colspan="2" height="20"></td>
                                </tr>
                                <tr>
                                  <td valign="top"><img src="http://dentalplansoftware.com/front_img/front_07-03.png" width="39" height="39" /></td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:29px; color:#ffffff">'.$doc_phone.'</td>
                                </tr>
                                <tr>
                                    <td valign="top" colspan="2" height="20"></td>
                                </tr>
                                <tr>
                                  <td valign="top"><img src="http://dentalplansoftware.com/front_img/front_07-04.png" width="39" height="39" /></td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:29px; color:#ffffff">'.$doc_address.'</td>
                                </tr>
                                <tr>
                                    <td valign="top" colspan="2" height="35"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                 </table>
            </td>
            <td valign="top" width="30px;"></td>
        </tr>
        <tr>
          <td valign="top" colspan="3" height="30"></td>
        </tr>
    </table>';    
                        /* code for mail start   */

                         
                    $config = $this->getServiceLocator()->get('config');
                     /* code for mail start   */
                        $footer = "The Admin Team";
                        $html = new Mime\Part($maillink);
                        $html->type = Mime\Mime::TYPE_HTML;
                        $text = new Mime\Part($footer);
                        $text->type = Mime\Mime::TYPE_TEXT;
                        $maillink = new Mime\Message();
                        $maillink->setParts(array($html, $text));
                        $message = new \Zend\Mail\Message();
                        $message->setBody($maillink);
                        $message->setFrom($config['email_sender']['email']);
                        $message->setSubject("Welcome to dentalplansoftware.com");
                        $message->addTo($patient_email) ;
                        $SmtpOptions =  new \Zend\Mail\Transport\SmtpOptions();
                        $SmtpOptions->setHost($config['smtp_settings']['host'])->setPort($config['smtp_settings']['port'])
                              ->setConnectionClass($config['smtp_settings']['connection_class'])
                              ->setName('smtp.gmail.com')
                              ->setConnectionConfig(array(
                               'username'=>$config['smtp_settings']['username'],
                               'password'=>$config['smtp_settings']['password'],
                               'ssl'     =>$config['smtp_settings']['ssl']

                        ));
                        $transport  =  new \Zend\Mail\Transport\Smtp($SmtpOptions) ;
                        $transport->send($message);
                      /* code for mail start   */
       }      //    patient detail (parent id==0) if close here . 
     if($addon==1){
       return $this->redirect()->toUrl("/dashboardfront/patientedit/$planid/$parentid");
     }else{
       return $this->redirect()->toUrl("/dashboardfront/payccurl/$parentid");
     }
   }      // else part of $pat_id==0 close here ..
  $chkpid= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->getMainPatient($patient_id);
   if($chkpid!=$patient_id){ 
     return $this->redirect()->toUrl("/dashboardfront/payccurl/$chkpid");
  }else { 
    return $this->redirect()->toUrl("/dashboardfront/payccurl/$patient_id");
  }
  $patientplan= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientPlanDetails($patientid,$docid);
 // $this->redirect()->toUrl("/dashboardfront/payccurl/");  
}    // post bracket close here ...
     return new ViewModel(array('planid'=>$planid,'patientid'=>$patientid,'parentid'=>$parentid,'addon'=>$addon));
}
 public function managepatienteditAction()
  {    
     $planid = $this->params()->fromRoute('id',null);
     $parentid = $this->params()->fromRoute('idd',null);  
     $patientid = $this->params()->fromRoute('iddd',null); 
     $session = new Container('User');
     $docid  =$session->offsetGet('userId');
       $patientdetail= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetails($patientid,$docid); 
     $request= $this->getRequest();
     if($request->isPost()){
      $plan_id=$request->getPost('plan_id');
     // echo "fdf";
      //echo $plan_id;die;
      $plan_cycle=$request->getPost('plan_cycle');
      $patient_salutation=$request->getPost('patient_salutation');
      $patient_firstname=$request->getPost('patient_firstname');
      $patient_lastname=$request->getPost('patient_lastname');
      $patient_dob=$request->getPost('patient_dob');
      $patient_ssn=$request->getPost('patient_ssn');
      $patient_sex=$request->getPost('patient_sex');
      $patient_address=$request->getPost('patient_address');
      $patient_zip=$request->getPost('patient_zip');
      $patient_phone=$request->getPost('patient_phone');
      $patient_mobile=$request->getPost('patient_mobile');
      $patient_email=$request->getPost('patient_email');
      $patient_password=$request->getPost('patient_password');
      $patientid=$request->getPost('pat_id');
      $addon=$request->getPost('addon');
      $parentid=$request->getPost('parent_id');
      $patient_status=$request->getPost('patient_status');
      


      $patient_consent=$request->getPost('patient_consent');
      $parentid=$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->insertPatient($planid,$plan_cycle,$patient_salutation,$patient_firstname,$patient_lastname,$patient_dob,$patient_ssn,$patient_sex,$patient_address,$patient_zip,$patient_phone,$patient_mobile,$patient_email,$patient_password,$patientid,$addon,$parentid,$docid,$patient_status,$patient_consent); 
       //get parent
       $patientdetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetailsById($parentid);  
       $parent_id  =$patientdetails[0]['parent_id'] ;
       if($parent_id!=0)
        $parentid = $parent_id;
       if($addon==1){
       return $this->redirect()->toUrl("/dashboardfront/patientedit/$parentid");
     }
     $patientplan= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientPlanDetails($patientid,$docid); 
     $this->redirect()->toUrl("/dashboardfront/payccurl/$patientid");
     }
     return new ViewModel(array('planid'=>$planid,'patientid'=>$patientid,'patientplan'=>$patientdetail,'parentid'=>$parentid,'addon'=>$addon));
  }

  public function viewpatientAction()
  {    
     $patid = $this->params()->fromRoute('id',null); 
     $session = new Container('User');
     $docid  =$session->offsetGet('userId');
     $patient= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetails($patid,$docid);  
     $patientonly= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->listPatientsId();   
     return new ViewModel(array('patient'=>$patient,'patientonly'=>$patientonly,'patid'=>$patid));
  }
  public function payccurlAction()
  {    
    
    $patid = $this->params()->fromRoute('id',null); 
    $session = new Container('User');
    $docid  =$session->offsetGet('userId');
    $patient= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetails($patid,$docid);
    $patientonlydetail= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetailsById($patid);    // only patient table detail come here .
  
    $patientonly= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->listPatientsId();
    $request= $this->getRequest();
     if($request->isPost())
      {        
                                        // post bracket open here
       $number= $request->getPost('number');
       $exp_month= $request->getPost('exp_month');
       $exp_year= $request->getPost('exp_year');
       $patid= $request->getPost('pat_id');
       $stripeToken =  $request->getPost('stripeToken');
       $encriptnumber = $this->myownenc(substr($number,-4));
      if($patid) {       
         // check if plan exists, otherwise make a plan
          $patientonlydetail= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetailsById($patid);    // only patient table detail come here .
          $getmainpatientid = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetailsById($patid);  //   this table only get patient_id and parent_id .
         if($getmainpatientid[0]['parent_id']>0)
         $ptype = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->getPatientAddons($getmainpatientid[0]['parent_id']);
         if($ptype>0) {
          $p_type = 'Add'.$ptype;
          } else {
         $p_type = 'Ind1';
         }

       // plan cycle start
       $plan_bill_cycle[1] = 'Month';
       $plan_bill_cycle[2] = 'Year';
       // plan cycle end
      $cycle = $plan_bill_cycle[$patientonlydetail[0]['plan_cycle']];
      $plandetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PlanDetails($patientonlydetail[0]['plan_id']);
      $doctordetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($plandetails[0]['doc_id']);   
      $plancode_name = $plandetails[0]['plan_name'].'_'.$doctordetails[0]['doc_firstname'].'_'.$doctordetails[0]['doc_lastname'].'_'.$plandetails['plan_id'].'_'.$p_type.'_'.$cycle;   // here get plan code name of stripe_plan
      $stripeplandetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->chkStripePlanExists($plancode_name);
        if(!$stripeplandetails[0]['plan_code']) {     // stripe plan detail open here
        $plan_price = 0;
        $get_addons = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->getPatientAddons($patient_id);
        $get_pat_details= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PatientDetailsById($patid); 
        $plan_qry= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PlanDetails($get_pat_details[0]['plan_id']); 
          if($plan_qry[0]['plan_id']) {     // plan_query  bracket open here
            if($get_pat_details[0]['plan_cycle']==1) {
             $indvidual_monthly_price = $plan_qry[0]['plan_monthly_price'];
             if($get_addons>0)
              $addon_monthly_price = $get_addons*$plan_qry[0]['addon_monthly_price'];
             $plan_price = $indvidual_monthly_price+$addon_monthly_price;
             } else if($get_pat_details[0]['plan_cycle']==2) {
             $indvidual_yearly_price = $plan_qry[0]['plan_yearly_price'];
             if($get_addons>0)
             $addon_yearly_price = $get_addons*$plan_qry[0]['addon_yearly_price'];
             $plan_price = $indvidual_yearly_price+$addon_yearly_price;
             }
            }       // plan_query  bracket close here
       $plan_price_incents = $plan_price*100;
       $plancyclename = strtolower($plan_bill_cycle[$get_pat_details[0]['plan_cycle']]);
       $normalplanname=str_replace('_',' ',$plancode_name);
      $mkplan = \Stripe\Plan::create(array(
       "amount" => $plan_price_incents,
       "interval" => $plancyclename,
       "name" => $normalplanname,
       "currency" => "usd",
       "id" => $plancode_name)
      );
    $stripePlanInsert= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->stripePlanInsert($plancode_name,$plan_price); 
}     // stripe plan detail close here
$cust = \Stripe\Customer::create(array(
  "email" => $email,
  "description" => "Customer - ".$email.' of doctor - '.$session->offsetGet('userId'),
  "source" => $stripeToken
));
$cu = \Stripe\Customer::retrieve($cust->id);
$subs = $cu->subscriptions->create(array("plan" => $plancode_name));
$encryptcustid=$this->myownenc($cust->id);
$encryptsubsid=$this->myownenc($subs->id);
$patientUpdate= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->patientUpdate($encryptcustid,$encryptsubsid,$patid); 
if($subs->id) {    // subs_id bracket open here
$updatePatientdetail= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->updatePatientDetails($patid,$encriptnumber,$exp_month,$exp_year); 

$doctordetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($plandetails[0]['doc_id']);
 $this->redirect()->toUrl("/dashboardfront/patient");
     }   // subs_id bracket close here
   }     // pat id bracket close here 
 }    // post bracket close here 
    // print_r($patientonlydetail);die;
    $cc_number=$patientonlydetail[0]['cc_number'] ;
   // print_r($cc_number);
    if($cc_number){
     $inputText=$cc_number;
     $aes = new \MyModule\AES($inputText,$this->inputKey,$this->blockSize);
     $cc_numberAfterDecription=$aes->decrypt();
      }
     return new ViewModel(array('patient'=>$patientonlydetail,'cc_numberAfterDecription'=>$cc_numberAfterDecription,'patientonly'=>$patientonly,'patid'=>$patid,'publishablekey'=>$this->publishable_key));
}

public function myownenc($data){
   $inputKey= $this->inputKey;
   $blockSize =$this->blockSize;
  if(trim($data)) {
    $inputText = $data;
    $aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
    $enc = $aes->encrypt();
    $aes->setData($enc);
    return $enc;
    //echo $enc ;
  } 
}
public function myencrypt($data)
{
   $inputKey= $this->inputKey;
   $blockSize =$this->blockSize;
  if(trim($data)) {
    $inputText = $data;
    $aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
    $enc = $aes->encrypt();
    $aes->setData($enc);
  //  return $enc;
    echo $enc ;
  } 
}
public function docccpayAction()
  {    
     $action = $this->params()->fromRoute('id',null); 
     $request= $this->getRequest();
     $session = new Container('User');
     $docid  =$session->offsetGet('userId');
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
  
  $this->redirect()->toUrl('/dashboardfront/docccpay');
  }
     $cc_number=$doctorDetails[0]['cc_number'] ;
     if(!empty($cc_number)){   // check if $inputText value exist .
     $inputText = $cc_number;
     $aes = new \MyModule\AES($inputText,$inputKey,$blockSize);
     $cc_numberAfterDecription=$aes->decrypt();
     }
     return new ViewModel(array('docUserID'=>$docid,'doctorDetails'=>$doctorDetails,'cc_numberDecription'=>$cc_numberAfterDecription,'action'=>$action,'publishable_key'=>$this->publishable_key));
  }
 
 public function doctorccpayAction()
  {   
     $docurlid = $this->params()->fromRoute('id',null); 
     $request= $this->getRequest();
     $session = new Container('User');
     $docid  =$session->offsetGet('userId');
     $inputKey = "2345432AD12H";
     $blockSize = 256;
     $doctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($docid);
     $custid=$doctorDetails[0]['cust_id']; 
     if($request->isPost()){
      $number = $request->getPost('number');
      $cvc       = $request->getPost('cvc');
      $exp_month  = $request->getPost('exp_month');
      $exp_year = $request->getPost('exp_year');
      $data  = substr($number,-4);
        if($docurlid) { 
        $email =$doctorDetails[0]['doc_email'];
        $cust = \Stripe\Customer::create(array(
         "description" => "Customer - ".$email,
         "source" => $stripeToken
         ));
        $cu = \Stripe\Customer::retrieve($cust->id);
        if($doctorDetails[0]['doc_speciality']>3)
          $subs = $cu->subscriptions->create(array("plan" => "splplan"));
        else
          $subs = $cu->subscriptions->create(array("plan" => "docplan"));
           /*  code of myencript function    start    */
         if(trim($subs->id)) {
         $inputText = $subs->id;
         $aes = new \MyModule\AES($inputText, $this->inputKey, $this->blockSize);
         $enc = $aes->encrypt();
         $aes->setData($enc);
         $subs_id=$enc ;
         } 
         /*  code of myencript function    end     */
         $encriptCust_id=myencript($cust->id) ;

         $DoctorSubscriptionInNotChange= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->updateDoctorSubscriptionInNotChange($subs_id,$encriptCust_id,$docurlid);   
       if($subs->id){
            $DoctorSubscriptionInNotChange= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->insertDoctorSubscriptionInNotChange($docurlid,($subs->plan['amount']/100));
         }
          $inputText = $data;
    //  $vendor = new \MyModule\AES();
        $aes = new \MyModule\AES($inputText, $inputKey, $blockSize);
        $enc = $aes->encrypt();
        $aes->setData($enc);
        $number_aes =$enc; 
        $updateDoctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->updateDoctorDetails($docurlid,$number_aes,$cvc,$exp_month,$exp_year);
        $this->redirect()->toUrl('/register/1000') ;     
  } 
}
     return new ViewModel(array('docUserID'=>$docurlid,'doctorDetails'=>$doctorDetails,'action'=>$action,'publishable_key'=>$this->publishable_key));
  }

 public function patientreferAction(){
    $patid= $this->params()->fromRoute('id',null);  
    $doclinkid= $this->params()->fromRoute('idd',null);   
    $session = new Container('User');
    $docid  =$session->offsetGet('userId');
    $doctorSpacilityDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailFromDocSpacility();
    $specialServicesDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->SpecialServicesList($doclinkid);
    if($doclinkid){
    $doctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($doclinkid);
    }
    $request= $this->getRequest();
      if ($request->isPost())
          { 
            $pat_id=$request->getPost('pat_id');
            $comments=$request->getPost('comments');
         if($doclinkid){
          $doctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->insertReferPatient($doclinkid,$pat_id,$docid,$comments);
         }
     






         /*  
          $doc_username= $request->getPost('doc_username');
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
          $doc_id= $request->getPost('doc_id');
          $savedoctor=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->savedoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username);
          $msg =1;
         $this->redirect()->toRoute('dashboardfront',array('action'=>'doctoredit','id'=>$msg)); 
         */
         }
     return new ViewModel(array('doc_r'=>$doctorDetails,'pat_id'=>$patid,'doclinkid'=>$doclinkid,'spl_r'=>$doctorSpacilityDetails,'doclinkid'=>$doclinkid,'msg'=>$msg,'specialServicesDetails'=>$specialServicesDetails));
}



	 public function thanksAction()
	{    
		 return new ViewModel();
	}
   public function suscribeAction()
	{ 
	 $request= $this->getRequest();
	 if($request->isPost()){
	    $ragisteremail=$request->getPost('register-email');
	    $email ='Support@DentalPlanSoftware.com' ;
	   // $email ='skant1990it@gmail.com' ;
        $maillink='Name: '.$ragisteremail;    
                /* code for mail start   */
				$footer = "The Admin Team";
				$html = new Mime\Part($maillink);
				$html->type = Mime\Mime::TYPE_HTML;
				$text = new Mime\Part($footer);
				$text->type = Mime\Mime::TYPE_TEXT;
				$maillink = new Mime\Message();
				$maillink->setParts(array($html, $text));
				$message = new \Zend\Mail\Message();
				$message->setBody($maillink);
				$message->setFrom($config['email_sender']['email']);
				$message->setSubject("New Subscription entry");
				$message->addTo($email) ;
				$SmtpOptions =  new \Zend\Mail\Transport\SmtpOptions();
				$SmtpOptions->setHost($config['smtp_settings']['host']) 
					  ->setPort($config['smtp_settings']['port'])
					  ->setConnectionClass($config['smtp_settings']['connection_class'])
					  ->setName('smtp.gmail.com')
					  ->setConnectionConfig(array(
					   'username'=>$config['smtp_settings']['username'],
					   'password'=>$config['smtp_settings']['password'],
					   'ssl'     =>$config['smtp_settings']['ssl']

				));
				$transport  =  new \Zend\Mail\Transport\Smtp($SmtpOptions) ;
				$transport->send($message);
					/* code for mail start   */
      return $this->redirect()->toUrl('/dashboardfront/thanks');
      }  
     return new ViewModel();
	}

	 public function contactAction()
	{    	
	 $request= $this->getRequest();
	 if($request->isPost()){
	    $contactname=$request->getPost('contact-name');
	    $contactemail=$request->getPost('contact-email');
	    $contactmsg=$request->getPost('contact-message');
	    $email ='Support@DentalPlanSoftware.com' ;
	   // $email ='skant1990it@gmail.com' ;
        $maillink='Name: '.$contactname.'<br>Email: '.$contactemail.'<br>Message: '.$contactmsg;    
                         /* code for mail start   */
                        $footer = "The Admin Team";
                        $html = new Mime\Part($maillink);
                        $html->type = Mime\Mime::TYPE_HTML;
                        $text = new Mime\Part($footer);
                        $text->type = Mime\Mime::TYPE_TEXT;
                        $maillink = new Mime\Message();
                        $maillink->setParts(array($html, $text));
                        $message = new \Zend\Mail\Message();
                        $message->setBody($maillink);
                        $message->setFrom($contactemail);
                        $message->setSubject("New contact us Entry");
                        $message->addTo($email) ;
                        $SmtpOptions =  new \Zend\Mail\Transport\SmtpOptions();
                        $SmtpOptions->setHost('smtp.gmail.com') 
                              ->setConnectionClass('login')
                              ->setName('smtp.gmail.com')
                              ->setConnectionConfig(array(
                               'username'=>'reporting@healthrise.com',
                               'password'=>'healthrise',
                               'ssl'     =>'tls',
                        ));
                        $transport  =  new \Zend\Mail\Transport\Smtp($SmtpOptions) ;
                        $transport->send($message);
                            /* code for mail start   */
      return $this->redirect()->toUrl('/dashboardfront/thanks');
      }
    return new ViewModel();
	}
  public function welcomeAction()
  {
   $session = new Container('User');
   $doc_id  =$session->offsetGet('userId'); 
   $doctordashboardfrontdata= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->totalDoctorPatientCount($doc_id);
   $doc_fee =300;

   $total_pat =$doctordashboardfrontdata[0]['totalPatients'] ;
    $total_income =$doctordashboardfrontdata[0]['total_income'] ;
   if($total_income >($doc_fee*10)) {
    $net_income = $total_income-(($total_income/100)*10)-$doc_fee;
   } else {
    $net_income = $total_income-$doc_fee;
  }
  return new viewModel(array('total_pat'=>$total_pat,'total_income'=>$total_income,'net_income'=>$net_income)) ;  
  }
  public function doctorsupportAction(){
     $request= $this->getRequest();
     if($request->isPost()){
       $first_name =$request->getPost('first_name');
       $last_name =$request->getPost('last_name');
       $email_id =$request->getPost('email_id'); 
       $address =$request->getPost('address');
       $phone =$request->getPost('phone');
       $message =$request->getPost('message');
       $pid =$request->getPost('pid');
       $session = new Container('User');
       $doc_id  =$session->offsetGet('userId');
       $tabledetail = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->savesupports($doc_id,$first_name,$last_name,$email_id,$address,$phone,$message); 
       $success= 1;
      }
   return new viewModel(array('success'=>$success)) ;
    
  } 
 public function splservicesAction()
  {  $session = new Container('User');
     $docid  =$session->offsetGet('userId');
     $splserviceDetails = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->splserviceFromDocId($docid);   
     return new ViewModel(array('splserviceDetails'=>$splserviceDetails));
  }
    public function reportsAction(){
      $reportid = $this->params()->fromRoute('id',null); 
      $session = new Container('User');
      $docid  =$session->offsetGet('userId');
      if($reportid=='1') {
       $reports = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->viewReports($reportid,$docid) ;
       } else if($reportid=='2') {
      $reports = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->viewReports($reportid,$docid) ;
       } else if($reportid=='3') {
       $reports = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->viewReports($reportid,$docid) ;
       } else {
       $reports = $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->viewReports($reportid,$docid) ;
       }
       return new ViewModel(array('reports' =>$reports,'reportid'=>$reportid));
    }
     public function patientAction(){
      $session = new Container('User');
      $docid  =$session->offsetGet('userId');
      $patientActiveDetails =$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->patientActiveDetails($docid); 
      $patientInactiveDetails =$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->patientInActiveDetails($docid);
      $listPatient =$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->listPatient($docid);
      $listonlyPatient =$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->listPatientsId();
      $act_pats= count($patientActiveDetails);
      $inact_pats= count($patientInactiveDetails) ;
      $searchkey= $this->params()->fromRoute('id',null) ;
      // $doctorgrid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->doctorgridListing($searchkey);
     $view = new ViewModel(array('act_pats'=>$act_pats,'inact_pats'=>$inact_pats,'listPatient'=>$listPatient,'listonlyPatient'=>$listonlyPatient));
     return $view;
    }
   
     public function viewplandetailAction()
  {    
     $planid = $this->params()->fromRoute('id',null); 
     $session = new Container('User');
     $docid  =$session->offsetGet('userId');
     $listplanservice= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->listplanservice();
     $plandetail= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->PlanDetails($planid,$docid);  
     return new ViewModel(array('plandetail'=>$plandetail,'listplanservice'=>$listplanservice));
  }

public function splservicesaddAction()
  {    
    $spl_serviceid= $this->params()->fromRoute('id',null); 
    if(isset($spl_serviceid)){
      $spl_servicedetails=$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->servicesDetailsFromId($spl_serviceid);
    }
     $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
        {
          $service_type= $request->getPost('service_type');
          $service_name1= $request->getPost('service_name1');
          $service_name2= $request->getPost('service_name2');
          $service_name3= $request->getPost('service_name3');
          $service_name4= $request->getPost('service_name4');
          $service_name5= $request->getPost('service_name5');
          $service_name6= $request->getPost('service_name6');
          $service_name7= $request->getPost('service_name7');
          $service_name8= $request->getPost('service_name8');
          $service_name9= $request->getPost('service_name9');
          $service_name10= $request->getPost('service_name10');
          $price= $request->getPost('price');
          $session = new Container('User');
          $doc_id  =$session->offsetGet('userId');
          $savedoctor=$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->saveSplServices($service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$price,$doc_id,$spl_serviceid);
        }
     return new ViewModel(array('service_id'=>$spl_serviceid,'spl_servicedetails'=>$spl_servicedetails,'exists'=>$exists));
  }
 public function splservicesviewdetailsAction()
  { 
    $serviceid=$this->params()->fromRoute('id',null);  
    $spl_servicedetails=$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->servicesDetailsFromId($serviceid); 
    return new ViewModel(array('spl_servicedetails'=>$spl_servicedetails));
  }
  public function  delservicesAction(){
    $id = (int) $this->params()->fromRoute('id',null);
         $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->deleteservices($id);
         $this->redirect()->toRoute('dashboardfront',array('action'=>'splservices'));

  }
   public function  delpatientAction(){
    $id = (int) $this->params()->fromRoute('id',null);
         $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->delpatient($id);
         $this->redirect()->toRoute('dashboardfront',array('action'=>'patient'));

  }
    public function planAction(){
      $delplanid= $this->params()->fromRoute('id',null);
      $session = new Container('User');
      $docid  =$session->offsetGet('userId');
      $listPlan =$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->DoctorPlansListing($docid);
      $listPatient =$this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->listPatientsId($docid);
      // print_r($listPatient);
      $view = new ViewModel(array('listPlan'=>$listPlan,'listPatients'=>$listPatient,'delplanid'=>$delplanid));
      return $view;
    }
   public function  delplanAction(){
    $id = (int) $this->params()->fromRoute('id',null);
         $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->deletePlan($id);
         $this->redirect()->toRoute('dashboardfront',array('action'=>'plan','id'=>'10000'));

  }
  public function planViewAction(){
      $session = new Container('User');
      $docid  =$session->offsetGet('userId');
     $planid= $this->params()->fromRoute('id',null);
     $plan_list = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlans($planid) ;
     $plan_service = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlanServices($planid) ;
return new ViewModel(array('plans'=>$plan_list,'plan_id'=>$planid,'plan_services'=>$plan_service,'doc_id'=>$docid));
  }
 
  public function planeditAction(){
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
       $planid = $request->getPost('pid');
      $saveplan=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editPlans($planid,$doc_id,$plan_name,$heading_line,$plan_monthly_price,$plan_yearly_price,$addon_monthly_price,$addon_yearly_price);

   $this->redirect()->toRoute('dashboardfront',array('action'=>'plan')); 
      }   
    $plan_list = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlans($planid) ;
       $plan_service = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlanServices($planid) ;
return new ViewModel(array('plans'=>$plan_list,'plan_id'=>$planid,'plan_services'=>$plan_service,'doc_id'=>$doc_id));  
       
      }else{

       $session = new Container('User');
       $doc_id  =$session->offsetGet('userId'); 
       $request = $this->getRequest() ;    // For Insert Plan
        if ($request->isPost())
          {  
     //  $doc_id = $request->getPost('doc_id');
       $plan_name = $request->getPost('plan_name');
       $heading_line = $request->getPost('heading_line');
       $plan_monthly_price = $request->getPost('plan_monthly_price');
       $plan_yearly_price = $request->getPost('plan_yearly_price');
       $addon_monthly_price = $request->getPost('addon_monthly_price');
       $addon_yearly_price = $request->getPost('addon_yearly_price'); 
       $lastplanid=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->addPlans($doc_id,$plan_name,$heading_line,$plan_monthly_price,$plan_yearly_price,$addon_monthly_price,$addon_yearly_price);


   $this->redirect()->toRoute('dashboardfront',array('action'=>'plansservice','id'=>$lastplanid));      
    }        
return new ViewModel(array('plan_id'=>$planid,'plan_services'=>$plan_service,'doc_id'=>$doc_id));       
      }
   }
  
  public function plansserviceAction(){
      $planid= $this->params()->fromRoute('id',null);
      $service_id= $this->params()->fromRoute('idd',null); 
      $session = new Container('User');
      $doc_id  =$session->offsetGet('userId');      
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
      $addnext = $request->getPost('addnext');
//  print_r($service_name);exit;
$saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editPlanServices($service_id,$service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes);
  if($addnext){
  $this->redirect()->toRoute('dashboardfront',array('action'=>'plansservicenext','id'=>$planid));
  }else{
  $this->redirect()->toRoute('dashboardfront',array('action'=>'planedit','id'=>$planid,'idd'=>$doc_id)); 
   } 
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
$saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->addPlanServices($service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes,$planid);
  if($addnext){
  $this->redirect()->toRoute('dashboardfront',array('action'=>'plansservicenext','id'=>$planid));
  }else{
   $this->redirect()->toRoute('dashboardfront',array('action'=>'planedit','id'=>$planid,'idd'=>$doc_id));  
      }   
     }
   }
   if($service_id){
   $services = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectSingleServices($service_id) ;
   }
   return new ViewModel(array('services'=>$services,'plan_id'=>$planid,'service_id'=>$service_id,'doc_id'=>$doc_id));
   }  

 public function plansservicenextAction()
 {
   $planid= $this->params()->fromRoute('id',null);
   $service_id= $this->params()->fromRoute('idd',null); 
    $session = new Container('User');
    $doc_id  =$session->offsetGet('userId');  
   if(empty($service_id)){
      $request = $this->getRequest() ;    // For Edit Plan Services    
        if ($request->isPost())         
         { 
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
       $saveplan= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->addPlanServices($service_type,$service_name1,$service_name2,$service_name3,$service_name4,$service_name5,$service_name6,$service_name7,$service_name8,$service_name9,$service_name10,$service_notes,$planid);
      $this->redirect()->toRoute('dashboardfront',array('action'=>'planedit','id'=>$planid,'idd'=>$doc_id)); 
    }
  }

}
 public function doctoreditAction()
  { 
    $msg= $this->params()->fromRoute('id',null);   
    $session = new Container('User');
    $docid  =$session->offsetGet('userId');
    $doctorDetails= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->doctorDetailsFromId($docid);
     $request= $this->getRequest();
      if ($request->isPost())
          { 
          $doc_username= $request->getPost('doc_username');
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
          $doc_id= $request->getPost('doc_id');
          $savedoctor=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->savedoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username);
          $msg =1;
         $this->redirect()->toRoute('dashboardfront',array('action'=>'doctoredit','id'=>$msg)); 
         }
     return new ViewModel(array('doc_id'=>$docid,'doc_r'=>$doctorDetails,'msg'=>$msg));
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
            $result= $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->changeDoctorPassword($admin_pass,$userid);  
            }
         }
      return new ViewModel(array('err'=>$err,'errmsg'=>$errmsg));
  }

 public function doctorimagechangeAction()
      {   
         $id = (int) $this->params()->fromRoute('id',null);
         $msg_del_done = (int) $this->params()->fromRoute('idd',null);
         $uploadOk = 1;
         $success_msg=1 ;
         $doc_avatar = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectDoctorAvatar($id) ;
         $request = $this->getRequest() ;    // getting current request object     
         if ($request->isPost())
         { 
           $doc_avatar = 'avatar_'.$doc_id.substr($_FILES["doc_avatar"]["name"],strpos($_FILES["doc_avatar"]["name"],'.'));
           $target_file = $_SERVER['DOCUMENT_ROOT']."/img/placeholders/avatars/".$doc_avatar;
           $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
           $doc_id = $id;
           // Check if image file is a actual image or fake image
          $check = getimagesize($_FILES["doc_avatar"]["tmp_name"]);
    if($check== false) {
      //  $err[] = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 0;

    }else if($_FILES["doc_avatar"]["size"] > 500000) {
   // $err[] = "Sorry, your file is too large.";
    $uploadOk = 0;
      echo "2";
   }else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  //  $err[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    echo "3";
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {

  }else{  
           $saveavatar= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->editDoctorAvatar($doc_id,$doc_avatar);
            $_FILES["doc_avatar"]["tmp_name"] ;
           move_uploaded_file($_FILES["doc_avatar"]["tmp_name"], $target_file); 
           $success_msg=3 ;
           $this->redirect()->toRoute('dashboardfront',array('action'=>'doctorimagechange','id'=>$id,'uploadOk'=>$uploadOk,'success_msg'=>$success_msg));
        }              
       }
       return new ViewModel(array('success_msg'=>$success_msg,'id'=>$id,'doc_avatar'=>$doc_avatar,'msg_del_done'=>$msg_del_done,'uploadOk'=>$uploadOk));
    }
    public function deletedoctorimageAction(){
    $doctorid = (int) $this->params()->fromRoute('id',null);
    $msg_del_done=2;
    $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteDoctorImage($doctorid);
    $this->redirect()->toRoute('dashboardfront',array('action'=>'doctorimagechange','id'=>$doctorid,'idd'=>$msg_del_done));
    }

}





