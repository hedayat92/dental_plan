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
           $exists=0;
          $userdetails = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->checkUserid($doc_username) ;
          if(isset($userdetails[0]['doc_id'])){
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
          $doc_id= $request->getPost('doc_id');
          $savedoctor=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->savedoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username);
           }
        }
     return new ViewModel(array('doctorid'=>$doctorid,'doctordetails'=>$doctordetails,'exists'=>$exists));
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
        // print_r($request->getPost()); 
          $doc_contact_person= $request->getPost('doc_contact_person');
       ///   echo $doc_contact_person ;die ;
          $doc_username= $request->getPost('doc_username');
           $exists=0;
          $userdetails = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->checkUserid($doc_username) ;
          if(isset($userdetails[0]['doc_id'])){
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
          $doc_id= $request->getPost('doc_id');
         $savedoctor=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->savedoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username);
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
	         $this->redirect()->toRoute('dashboard',array('action'=>'doctorimagechange','id'=>$id,'uploadOk'=>$uploadOk,'success_msg'=>$success_msg));
        }  	           
       }
       return new ViewModel(array('success_msg'=>$success_msg,'id'=>$id,'doc_avatar'=>$doc_avatar,'msg_del_done'=>$msg_del_done,'uploadOk'=>$uploadOk));
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
    public function addusersAction(){
        $userroletable = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
        $selectrole = $userroletable->selectrole(); 
        $form = new UsersForm($selectrole);
        $form->get('submit')->setValue('Add User');
        $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
           $fname =  $request->getPost('fname',null);
           $lname = $request->getPost('lname',null);
           $name =  $request->getPost('uname',null);
           $email = $request->getPost('email',null);
           $role_id = $request->getPost('role_id',null);
           $userdetail =  $this->getServiceLocator()->get("UserTable")->getUserDetailByEmail($email);
          if(isset($userdetail[0]['email'])){
              $this->flashMessenger()->addMessage(array('success' => 'This E-mail Id already exists. Please try again.'));  
             }else{
              $username = substr($email, 0, strpos($email, '@'));
               /*random string generation   */
              $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $charactersLength = strlen($characters);
              $randomString = '';
              $length = 6 ;
              for ($i = 0; $i < $length; $i++) 
              {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
              $password  = $randomString ;
              $userPassword = new userPassword();
              $encyptPass = $userPassword->create($password);
              /*random string generation   end */
              $activateUrl= 'reporting.healthrise.com' ;
              $maillink = "<table>
                                      <tr><td> Hello " .'<strong>'. $fname ." ".$lname. '</strong>' .",</td></tr>
                                      <tr><td> Thank you for registering with the HealthRise Reporting website. </td></tr>
                                      <tr><td>Your username is:  ".'<strong>'. $email .'</strong>'.".  Your temporary password is:  ".'<strong>'.$password .'</strong>'."</td></tr>
                                      <tr><td>Please click on the following link in order to change your password and login:  ".$activateUrl."</td></tr>
                                      <tr><td></td></tr>
                                      
                          </table>";     
                        /* code for mail start   */
              $footer = "HealthRise Reporting";
              $html = new Mime\Part($maillink);
              $html->type = Mime\Mime::TYPE_HTML;
              $text = new Mime\Part($footer);
              $text->type = Mime\Mime::TYPE_TEXT;
              $maillink = new Mime\Message();
              $maillink->setParts(array($html, $text));
              $message = new \Zend\Mail\Message();
              $message->setBody($maillink);
              $message->setFrom('reporting@healthrise.com');
              $message->setSubject("New User Registration E-Mail");
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
            $this->flashMessenger()->addMessage(array( 'success' => 'New user has been added successfully.  The users username and password have been sent to the email provided.'));               
            $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->saveRagister($username,$email,$encyptPass,$role_id,$fname,$lname);
           }
         }
        return array('form' => $form);
    }
      public function addReportsAction()
      { 
        $tabledetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
        $allcategory = $tabledetail->selectCategory(); 
        $allclients = $tabledetail->selectClients();  
        $form = new ReportsForm($allclients,$allcategory);
        $form->get('submit')->setValue('Add Report');
        $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
         { 
           $categoryid =  $request->getPost('cat_id',null);
           $reportname =  $request->getPost('report',null);
           $reporturl =   $request->getPost('reporturl',null);
           $clientchkid =   $request->getPost('chkbox',null);
         //  print_r($clientchkid);
            $count_clientId= count($clientchkid);
            if($count_clientId==0){
              $this->flashMessenger()->addMessage(array('success' => 'Report not added .Please select atleast one client ..')); 
              $this->redirect()->toRoute('dashboard',array('action'=>'viewreports'));
            }else if($categoryid==0){
            $this->flashMessenger()->addMessage(array('success' => 'Report not added .Please select category of report ..')); 
            $this->redirect()->toRoute('dashboard',array('action'=>'viewreports'));
            }else{
           $session = new Container('User') ;
           $userid = $session->offsetGet('userId');
           $userrolepermission =  $this->getServiceLocator()->get("RolePermissionTable")->getRolePermissionsuser($userid);
           $session->offsetSet('userrolepermission', $userrolepermission);
           $this->flashMessenger()->addMessage(array('success' => 'New Reports Added Successfully..'));               
           $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->saveReports($reportname,$reporturl,$categoryid,$clientchkid);
           $this->redirect()->toRoute('dashboard',array('action'=>'viewreports'));
         }
         }
        return array('form' => $form,'clients'=>$allclients);
     }
     
   
    public function editReportsAction(){
      $id = $this->params()->fromRoute('id', 0);
      $reportsdetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getPermissionById($id) ;
      $categorydetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectCategory() ;
      $clientdetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectClients() ;
      $form = new ReportsForm($reportsdetail,$categorydetail);
      $form->get('submiteditreports')->setAttribute('value','Edit Report');
      $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
           $reportname =  $request->getPost('report',null);
           $reporturl = $request->getPost('reporturl',null);
           $categoryid =  $request->getPost('cat_id',null);
           $reportClientidArray =  $request->getPost('chkbox',null);
           $count_clientId= count($reportClientidArray);
            if($count_clientId==0){
              $this->flashMessenger()->addMessage(array('success' => 'Report not edited .Please select atleast one client ..')); 
              $this->redirect()->toRoute('dashboard',array('action'=>'viewreports'));
            }else if($categoryid==0){
            $this->flashMessenger()->addMessage(array('success' => 'Report not edited .Please select category of report ..')); 
            $this->redirect()->toRoute('dashboard',array('action'=>'viewreports'));
            }else{
           $session = new Container('User') ;
           $userid = $session->offsetGet('userId');
           $userrolepermission =  $this->getServiceLocator()->get("RolePermissionTable")->getRolePermissionsuser($userid);
           $session->offsetSet('userrolepermission', $userrolepermission);
           $clientidstring=implode(',',$reportClientidArray) ;
           $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->updateReport($id,$reportname,$reporturl,$categoryid,$clientidstring);
           $this->flashMessenger()->addMessage(array('success' => 'Report Edit Successfully..'));
           $this->redirect()->toRoute('dashboard',array('action' =>'viewreports'));  
          }
         }
      return new ViewModel(array('form'=>$form,'id'=>$id,'clientdetail'=>$clientdetail,'reportsdetail'=>$reportsdetail));
    }     
    public function editUserAction(){
      $id = $this->params()->fromRoute('id', 0);
      $allroles = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectrole() ;
      $assignrole = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->userAssignRole($id) ;
      $assignroleid = $assignrole[0]['role_id'] ;
      $userdetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getUserById($id) ;
      $form = new UsersForm($allroles,$userdetail,$assignroleid);
      $form->get('submitedituser')->setAttribute('value','Save');
      $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
           $name =  $request->getPost('uname',null);
           $email = $request->getPost('email',null);
           $fname =  $request->getPost('fname',null);
           $lname = $request->getPost('lname',null);
           $role_id = $request->getPost('role_id',null);
           $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->updateUserRole($id,$role_id,$fname,$lname,$email);
           $session = new Container('User') ;
           $userid = $session->offsetGet('userId');
           $userrolepermission =  $this->getServiceLocator()->get("RolePermissionTable")->getRolePermissionsuser($userid);
           $session->offsetSet('userrolepermission', $userrolepermission);
           $roledetail= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getRole($role_id)->toArray() ;
           $session->offsetSet('roleName', $roledetail['0']['role_name']);
           if($session->offsetGet('roleName')=='Admin')
           {
           $this->flashMessenger()->addMessage(array('success' => 'User Role Change Successfully'));
           $this->redirect()->toRoute('dashboard',array('action'=>'viewusers'));
            }else{
            $this->redirect()->toRoute('dashboard');
           }  
          }
      return new ViewModel(array('form'=>$form));
    }
    public function deleteuserAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteUser($id);
            }
         $this->redirect()->toRoute('dashboard',array('action'=>'viewusers'));
    }
    public function deleteroleAction()
    {
      $request = $this->getRequest();
        if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteRoles($id);
            }
         $this->redirect()->toRoute('dashboard',array('action'=>'viewroles'));
    }
     public function getDashboardTable()
	 {    
		 if (!$this->_dashboardTable) {
			$serviceManager   = $this->getServiceLocator();
			$this->_dashboardTable = $serviceManager->get('Dashboard\Model\DashboardTable');
		}
		return $this->_dashboardTable;
	}	
   public function viewCategoryAction()
      {
       return new ViewModel(array(
            'category' => $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewCategory()));
      }
       public function addCategoryAction()
      {
        $form = new CategoryForm();
        $form->get('submit')->setValue('Add Category');
        $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
         { 
           $categoryname =  $request->getPost('catname',null);
           $this->flashMessenger()->addMessage(array('success' => 'New Category Added Successfully..'));               
           $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->saveCategory($categoryname,$reporturl);
           $this->redirect()->toRoute('dashboard',array('action'=>'viewcategory'));
         }
        return array('form' => $form);
     }
     public function editCategoryAction(){
      $id = $this->params()->fromRoute('id', 0);
      $categorydetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getCategoryById($id) ;
      $form = new CategoryForm($categorydetail);
      $form->get('submiteditcategory')->setAttribute('value','Edit Category');
      $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
          //  print_r($request->getPost());
          //  die ;
           $catid =  $request->getPost('id',null);
           $catname = $request->getPost('catname',null);
           $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->updateCategory($catid,$catname);
           $this->flashMessenger()->addMessage(array('success' => 'Category Edit Successfully..'));
           $this->redirect()->toRoute('dashboard',array('action' =>'viewcategory'));  
         }
      return new ViewModel(array('form'=>$form,'id'=>$id));
    }
    public function deleteCategoryAction()
     {
        $request = $this->getRequest();
        if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteCategory($id);
            }
         $this->redirect()->toRoute('dashboard',array('action'=>'viewcategory'));
    }  
    public function viewClientsAction()
      {
       return new ViewModel(array(
            'clients' => $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewClients()));
      }
       public function addClientsAction()
      {
        $form = new ClientsForm();
        $form->get('submit')->setValue('Add Clients');
        $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
         { 
           $clientname =  $request->getPost('clientname',null);
           $this->flashMessenger()->addMessage(array('success' => 'New Client Added Successfully..'));               
           $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->saveClient($clientname);
           $this->redirect()->toRoute('dashboard',array('action'=>'viewclients'));
         }
        return array('form' => $form);
     }
     public function editClientsAction(){
      $id = $this->params()->fromRoute('id', 0);
      $categorydetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getClientById($id) ;
      $form = new ClientsForm($categorydetail);
      $form->get('submiteditclients')->setAttribute('value','Edit Client');
      $request = $this->getRequest() ;    // getting current request object
        if ($request->isPost())
          { 
          //  print_r($request->getPost());
          //  die ;
           $clientid =  $request->getPost('id',null);
           $clientname = $request->getPost('clientname',null);
           $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->updateClient($clientid,$clientname);
           $this->flashMessenger()->addMessage(array('success' => 'Client Edit Successfully..'));
           $this->redirect()->toRoute('dashboard',array('action' =>'viewclients'));  
         }
      return new ViewModel(array('form'=>$form,'id'=>$id));
    }
    public function deleteClientAction()
     {
        $request = $this->getRequest();
        if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteClient($id);
            }
         $this->redirect()->toRoute('dashboard',array('action'=>'viewclients'));
    } 
	
	
	
	/*-------------------Abhishek-------------------*/
	public function planAction($id = null){	 
      $doctorid= $this->params()->fromRoute('id',null);
	  $plan_list = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->selectPlansAsDoc($doctorid) ;
	  return new ViewModel(array('plans'=>$plan_list,'doc_id'=>$doctorid));

     }
	
	
	public function planEditAction($id = null,$idd = null){
         $planid= $this->params()->fromRoute('id',null);
	     $doc_id= $this->params()->fromRoute('idd',null);
		 if(!empty($planid)){
		 $request = $this->getRequest() ;    // For Edit Plan
			// print_r($request);exit;
        if ($request->isPost())
          {  $doc_id = $request->getPost('doc_id');
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
          {  $doc_id = $request->getPost('doc_id');
			 $plan_name = $request->getPost('plan_name');
			 $heading_line = $request->getPost('heading_line');
			 $plan_monthly_price = $request->getPost('plan_monthly_price');
			 $plan_yearly_price = $request->getPost('plan_yearly_price');
			 $addon_monthly_price = $request->getPost('addon_monthly_price');
			 $addon_yearly_price = $request->getPost('addon_yearly_price');	
$saveplan=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->addPlans($doc_id,$plan_name,$heading_line,$plan_monthly_price,$plan_yearly_price,$addon_monthly_price,$addon_yearly_price);
	 $this->redirect()->toRoute('dashboard',array('action'=>'plan','id'=>$doc_id));			 
		} 		 	 
return new ViewModel(array('doc_id'=>$doc_id));				
		  }
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

	
	
	
	
	
	
	
	
	
}
