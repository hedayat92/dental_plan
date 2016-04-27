<?php
namespace ZF2AuthAcl\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZF2AuthAcl\Form\LoginForm;
use ZF2AuthAcl\Form\ForgetpasswrdForm;
use ZF2AuthAcl\Form\Filter\ForgetpasswrdFilter;
use ZF2AuthAcl\Form\Filter\LoginFilter;
use ZF2AuthAcl\Utility\UserPassword;
use Zend\Session\Container;
use Zend\Mail\Message;
use Zend\Mime;
use Zend\Mail\Transport\Sendmail ;
class IndexController extends AbstractActionController
{
    public function indexAction()
    {   
      $frontcheckid = $this->params()->fromRoute('id', 0);
      if($frontcheckid==1){    /* for doctor login                               */
         $session = new Container('User'); 
         if ($session->offsetExists('userId'))
           {
                $this->redirect()->toRoute('logout');
           }
        $request = $this->getRequest(); 
        if($request->isPost()) {
           $data = $request->getPost();
           $userPassword = new UserPassword();
                $encyptPass = $userPassword->create($data['password']);
                $authService = $this->getServiceLocator()->get('AuthService');
                $userdetail  =  $this->getServiceLocator()->get("UserTable")->authenticateDoctor($data['email'] ,$encyptPass);
                $resultid = $userdetail['0']['doc_id'] ;
                if (isset($resultid)) {
                    $userid = $userdetail[0]['doc_id'] ;
                    $session = new Container('User');
                    $session->offsetSet('email', $data['email']);
                    $session->offsetSet('userId', $userdetail[0]['doc_id']);
                    $session->offsetSet('doc_speciality', $userdetail[0]['doc_speciality']);
                    $session->offsetSet('doc_firstname', $userdetail[0]['doc_firstname']);
                    $session->offsetSet('doc_lastname', $userdetail[0]['doc_lastname']);
                    $session->offsetSet('userdetail', $userdetail[0]);
                    return $this->redirect()->toUrl('/dashboardfront/welcome');
                    // Redirect to page after successful login
            } else {
                    $this->flashMessenger()->addMessage(array(
                        'error' => 'Sorry, an incorrect username and/or password has been entered.'
                  ));
                    // Redirect to page after login failure
                }
                return $this->redirect()->tourl('/admin/1');
                // Logic for login authentication
        }
        return new ViewModel(array('loginForm'=>$loginForm,'frontcheckid'=>$frontcheckid));
      }else{    /* else start here */
         $session = new Container('User'); 
         if ($session->offsetExists('userId'))
           {
                $this->redirect()->toRoute('logout');
           }
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost();
                $userPassword = new UserPassword();
                $encyptPass = $userPassword->create($data['password']);
                $authService = $this->getServiceLocator()->get('AuthService');
                $result  =  $this->getServiceLocator()->get("UserTable")->authenticate($data['email'] ,$encyptPass);
                $resultid = $result['0']['user_id'] ;
                if (isset($resultid)) {
                     $userDetails = $this->_getUserDetails(array(
                        'email' => $data['email']
                    ), array(
                        'user_id'
                    ));
                $userdetail =  $this->getServiceLocator()->get("UserTable")->getUserDetailByEmail($data['email']);
                    $userid = $userdetail[0]['user_id'] ;
                    $session = new Container('User');
                    $session->offsetSet('email', $data['email']);
                    $session->offsetSet('userId', $userdetail[0]['user_id']);
                    $session->offsetSet('roleId', $userDetails[0]['role_id']);
                    $session->offsetSet('fname', $userdetail[0]['fname']);
                    $session->offsetSet('lname', $userdetail[0]['lname']);
                    $session->offsetSet('roleName', $userDetails[0]['role_name']);
                   // die('here');
                    //  $category =  $this->getServiceLocator()->get("report_category")->getRolePermissionsuser($userid);
                  //  return $this->redirect()->toRoute('dashboard');
                  return $this->redirect()->toRoute('dashboard');
                    // Redirect to page after successful login
            } else {
                    $this->flashMessenger()->addMessage(array(
                        'error' => 'Sorry, an incorrect username and/or password has been entered.'
                  ));
                    // Redirect to page after login failure
                }
                return $this->redirect()->tourl('/admin');
                // Logic for login authentication
        }
     return new ViewModel(array('loginForm'=>$loginForm,'frontcheckid'=>$frontcheckid));
      }   /* else close here */
    }
  
    public function forgetpassAction(){
      $request = $this->getRequest();
            if($request->isPost()){
             $postdetail  = $request->getPost('reminder-email');
             $userdetail =  $this->getServiceLocator()->get("Dashboardfront\Model\DashboardfrontTable")->checkUseridByEmail($postdetail); // find doctor detail by email
            if($postdetail=''){
              $err = 1;  
            }else if(!isset($userdetail[0]['doc_email'])){
              $err = 2;
            }else{
                $newpass = substr(md5(substr(time(),5)),0,6);
                $userPassword = new UserPassword();
                $encyptPass = $userPassword->create($newpass);  
                $updateDocPassword  =  $this->getServiceLocator()->get("UserTable")->updateDocPassword($userdetail[0]['doc_email'],$encyptPass); 
                $email = $userdetail[0]['doc_email'];
               $maillink = 'Hi '.$userdetail[0]['doc_firstname'].' '.$userdetail[0]['doc_lastname'].',<br />Your Password is reset and your new password is: '.$newpass.' <br />You can login by <a href="'.$_SERVER['SERVER_NAME'].'/admin/1" target="_blank">click here</a>';

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
                        $message->setSubject("Your password is reset for dentalplansoftware.com");
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
                        $err = 3;
                     }
               } 
            return array('form' => $forgetpasswrdForm,'err'=>$err);
  }
   public function adminforgetpassAction(){
      $request = $this->getRequest();
            if($request->isPost()){
             $postdetail  = $request->getPost('reminder-email');
             $userdetail =  $this->getServiceLocator()->get("Dashboardfront\Model\DashboardfrontTable")->checkAdminUseridByEmail($postdetail); // find doctor detail by email
            if($postdetail=''){
              $err = 1;  
            }else if(!isset($userdetail[0]['email'])){
              $err = 2;
            }else{
                $newpass = substr(md5(substr(time(),5)),0,6);
                $userPassword = new UserPassword();
                $encyptPass = $userPassword->create($newpass);  
                $updateDocPassword  =  $this->getServiceLocator()->get("UserTable")->updatePassword($userdetail[0]['email'],$encyptPass); 
                $email = $userdetail[0]['email'];
                $maillink = 'Hi Admin user,<br />Your Password is reset and your new password is: '.$newpass.' <br />You can login by <a href="'.$_SERVER['SERVER_NAME'].'/admin" target="_blank">click here</a>';
                       
                        /* code for mail start   */
                        $config = $this->getServiceLocator()->get('config');
                        $footer = "";
                        $html = new Mime\Part($maillink);
                        $html->type = Mime\Mime::TYPE_HTML;
                        $text = new Mime\Part($footer);
                        $text->type = Mime\Mime::TYPE_TEXT;
                        $maillink = new Mime\Message();
                        $maillink->setParts(array($html, $text));
                        $message = new \Zend\Mail\Message();
                        $message->setBody($maillink);
                        $message->setFrom($config['email_sender']['email']);
                        $message->setSubject("Your password is reset for dentalplansoftware.com");
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
                        $err = 3;
                     return $this->redirect()->toUrl('/adminforgetpass');
                     }
               } 
            return array('form' => $forgetpasswrdForm,'err'=>$err);
  }
   
    public function changeadminpassAction(){
      $request = $this->getRequest();
            if($request->isPost()){
             $postdetail  = $request->getPost('reminder-email');
             $userdetail =  $this->getServiceLocator()->get("Dashboardfront\Model\DashboardfrontTable")->checkAdminUseridByEmail($postdetail); // find doctor detail by email
            if($postdetail=''){
              $err = 1;  
            }else if(!isset($userdetail[0]['email'])){
              $err = 2;
            }else{
                $newpass = substr(md5(substr(time(),5)),0,6);
                $userPassword = new UserPassword();
                $encyptPass = $userPassword->create($newpass);  
                $updateDocPassword  =  $this->getServiceLocator()->get("UserTable")->updatePassword($userdetail[0]['email'],$encyptPass); 
                $email = 'admin@dentalplansoftware.com';
                $maillink = 'Hi Admin user,<br />Your Password is reset and your new password is: '.$newpass.' <br />You can login by <a href="/admin" target="_blank">click here</a>';
                   
                        /* code for mail start   */
                        $footer = "";
                        $html = new Mime\Part($maillink);
                        $html->type = Mime\Mime::TYPE_HTML;
                        $text = new Mime\Part($footer);
                        $text->type = Mime\Mime::TYPE_TEXT;
                        $maillink = new Mime\Message();
                        $maillink->setParts(array($html, $text));
                        $message = new \Zend\Mail\Message();
                        $message->setBody($maillink);
                        $message->setFrom($userdetail[0]['email']);
                        $message->setSubject("Your password is reset for dentalplansoftware.com");
                        $message->addTo($email) ;
                        $SmtpOptions =  new \Zend\Mail\Transport\SmtpOptions();
                        $SmtpOptions->setHost('smtp.gmail.com') 
                              ->setConnectionClass('login')
                              ->setName('smtp.gmail.com')
                              ->setConnectionConfig(array(
                               'username'=>'shashikant@tactionsoftware.com',
                               'password'=>'skant1990it',
                               'ssl'     =>'tls',
                        ));
                        $transport  =  new \Zend\Mail\Transport\Smtp($SmtpOptions) ;
                        $transport->send($message);
                        /* code for mail start   */
                        $err = 3;
                     return $this->redirect()->toUrl('/adminforgetpass');
                     }
               } 
            return array('form' => $forgetpasswrdForm,'err'=>$err);
  }

 public function registerAction()
  {     
        $uuid = $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
         if($request->isPost()){
            $doc_id =0;
            $postdetail  =$request->getPost();
            $doc_firstname = $postdetail['doc_firstname'];  
            $doc_lastname = $postdetail['doc_lastname'];
            $doc_email = $postdetail['doc_email'];  
            $doc_phone = $postdetail['doc_phone'];
            $doc_phone2 = $postdetail['doc_phone2'];  
            $conf_passwrd = $postdetail['password-verify'];
            $doc_zip = $postdetail['doc_zip'];  
            $doc_sex = $postdetail['doc_sex'];
            $doc_speciality = $postdetail['doc_speciality']; 
            $doc_address = $postdetail['doc_address'];
            $doc_username = $postdetail['doc_username'];
            $doc_pass = $postdetail['doc_pass'];  
            $passwordverify = $postdetail['password-verify'];
            $doc_license_no = $postdetail['doc_license_no'];  
            $doc_contact_person = $postdetail['doc_contact_person'];
            $doc_status = 1;
            $userdetail =  $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->checkUserid($doc_username);
                  if(!isset($userdetail[0]['doc_username']))
                  {
                      $userdetail =  $this->getServiceLocator()->get('Dashboardfront\Model\DashboardfrontTable')->saveDoctor($doc_id,$doc_firstname,$doc_lastname,$doc_email,$doc_phone,$doc_zip,$doc_address,$doc_phone2,$doc_sex,$doc_speciality,$doc_license_no,$doc_contact_person,$doc_status,$doc_username,$conf_passwrd);
                  $action =1;
                   /* code of mail sending */
                  $maillink = "Hi $doc_firstname $doc_lastname,<br>You are registered with dentalplansoftware.com successfully.<br>You can login at :".$_SERVER['SERVER_NAME']."/admin/1<br>Email: .".$doc_email."<br>Password: ".$passwordverify."<br>Thanks,<br>Admin<br>dentalplansoftware.com";                  
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
                        $message->addTo($doc_email) ;
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


                  return $this->redirect()->toUrl("/admin/1");
                  }else{ 
                      $exists = 1;
                      //return $this->redirect()->toUrl("/register");
                      }
        $lastdocid = $userdetail[0]['doc_id'];     
        
       }
         return new ViewModel(array('action'=>$action,'exists'=>$exists,'action1'=>$uuid));
  }
public function logoutAction(){
        $authService = $this->getServiceLocator()->get('AuthService');
        $session = new Container('User');
        $session->getManager()->destroy();
        $authService->clearIdentity();
        $this->flashMessenger()->addMessage(array(
                        'error' => 'You Logout Successfully.'
                    ));
        return $this->redirect()->toUrl('/');
    }
    private function _getUserDetails($where, $columns)
    {
        $userTable = $this->getServiceLocator()->get("UserTable");
        $users = $userTable->getUsers($where, $columns);
        return $users;
    }
}
