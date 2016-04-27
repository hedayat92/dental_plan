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

            //Call your service here
           //$demo ='dddd';
        $tabledetail = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
        $allcategory = $tabledetail->selectCategory(); 
        $allclients = $tabledetail->selectClients();  
        $this->layout()->setVariable('categorydetail', $allcategory);
        $this->layout()->setVariable('clientsdetail', $allclients);
           $session = new Container('User') ;
           $userid = $session->offsetGet('userId');
           $userrolepermission =  $this->getServiceLocator()->get("RolePermissionTable")->getRolePermissionsuser($userid);
           $session->offsetSet('userrolepermission', $userrolepermission);
        return parent::onDispatch($e);
        }


         public function __construct(){
         $server = '54.175.39.22';
         $username = 'Taction';
         $ip = $_SERVER['REMOTE_ADDR'];
         $ch = curl_init();
         $data = array('username' => $username,'client_ip' => $ip);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_URL, "http://{$server}/trusted");
        //Getting client web browser IP address
       //  $ip = $_SERVER['REMOTE_ADDR'];
         $this->_ip = $ip;
         $ticket = curl_exec($ch);
         $this->_token = $ticket;
         
// echo ($this->_token) ;
 // die ;
       }

	public function indexAction()
	{  
  /*
       // echo $this->_ip; 
     $id = (int) $this->params()->fromRoute('id', 0);
		 $session = new Container('User') ;
		 $useremail = $session->offsetGet('email');
		 $userrole = $session->offsetGet('roleName');
		 $userid = $session->offsetGet('userId');
		 $roleid = $session->offsetGet('roleId'); 
	//	 return new ViewModel(array('email'=>$useremail,'role'=>$userrole,'userid'=>$userid,'tokenno'=>$this->_token,'ipaddress'=>$this->_ip));
	*/
  }
	public function alldetailAction()
		 {
		 $id = $this->getRequest ()->getPost ( 'id', null );
		 $roleid = $this->getRequest ()->getPost ( 'roleid', null );
		 $userroletable =$this->getServiceLocator()->get('RolePermissionTable') ;
		 $userroledetail=  $userroletable->getRolePermissionsuser($id);
		 $view = new ViewModel(array('userroledetail'=>$userroledetail));
		 $view->setTerminal(true);
		 return $view;
		 }
     public function viewusersAction(){
       return new ViewModel(array(
            'users' => $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewUsers()));
    }
    public function viewreportsAction(){
       return new ViewModel(array(
            'reports' => $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewReports()));
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
     
    public function deleteReportsAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->deleteReports($id);
            }
         $this->redirect()->toRoute('dashboard',array('action'=>'viewreports'));
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
    public function addRoleAction()
    {
           $userroletable =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
           $allusers= $userroletable->selectUsers();
           $allpermission=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewPermission();
           $allcategory = $userroletable->selectCategory(); 
           $allclients = $userroletable->selectClients();  


           $form = new RoleForm($allusers);
           $form->get('submit')->setAttribute('value','Submit');
           $request = $this->getRequest();  // getting current request object
           if ($request->isPost()) {
             $postdetail  = $request->getPost()->toArray();
             $role =$postdetail['role']; 
             $roleexist =  $this->getServiceLocator()->get("Dashboard\Model\DashboardTable")->getRoleByName($role)->toArray();
             if(isset($roleexist['0']['rid']))
             {
             $this->flashMessenger()->addMessage(array('success'=>'This Role Allready Exist'));
             return $this->redirect()->toRoute('dashboard',array('action' =>'addrole'));
             }
             $checkedpermission = array();
             $checkedpermission = $postdetail['chkbox'] ;
             $userroletable->saveRole($role,$checkedpermission);
             $this->flashMessenger()->addMessage(array('success'=>'Role Add Successfully'));
             $this->redirect()->toRoute('dashboard',array('action' =>'viewroles' ));
            }
           return new ViewModel(array('form' => $form,'permission'=>$allpermission,'allcategorydetail'=>$allcategory,'allclientsdetail'=>$allclients));
    }
    public function editRolePermissionAction()
    {   
         $id = $this->params()->fromRoute('id');
         $allpermissionforrole = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->PermissionfForRoleId($id) ;
         $roledetail= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getRole($id)->toArray() ;
         $permission=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewPermission();                                                                 
         $rolepermission=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewRolesPermission();
         $userroletable =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
         $allcategory = $userroletable->selectCategory(); 
         $allclients = $userroletable->selectClients();  

         $form = new EditRolepermissionForm($roledetail);
         $form->get('submit')->setAttribute('value','Save');
         $request = $this->getRequest();
          if($request->isPost())
          {
        $data  = $request->getPost()->toArray(); 
        $rid = $data['role_id'] ;
        $rname = $data['role'] ;
        $perallid = $data['p_name'] ;
        $roletable= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
        $role=$roletable->editRolePermission($rid,$rname,$perallid) ;
        $session = new Container('User') ;
        $userid = $session->offsetGet('userId');
        $userrolepermission =  $this->getServiceLocator()->get("RolePermissionTable")->getRolePermissionsuser($userid);
        $session->offsetSet('userrolepermission', $userrolepermission);
        $this->flashMessenger()->addMessage(array('success' => 'Role Permission Changes Successfully ..'));
        $this->redirect()->toRoute('dashboard',array('action' =>'viewroles' ));
        }
         return new ViewModel(array('form' => $form,'permission'=>$permission,'rolepermission'=>$allpermissionforrole,'allcategorydetail'=>$allcategory,'allclientsdetail'=>$allclients));
  }
     public function viewrolepermissionAction()
    {
         $id = $this->params()->fromRoute('id');
         $allpermissionforrole = $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->PermissionfForRoleId($id) ;
         $roledetail= $this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->getRole($id)->toArray() ;
         $rolename = $roledetail['0']['role_name'];
         $permission=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewPermission();                                                                 
         $rolepermission=$this->getServiceLocator()->get('Dashboard\Model\DashboardTable')->viewRolesPermission();
         $form = new EditRolepermissionForm($roledetail);
         $request = $this->getRequest();
         return new ViewModel(array('form' => $form,'permission'=>$permission,'rolepermission'=>$allpermissionforrole,'rolename'=>$rolename));
  }
   public function addpermissionAction(){
    	    $userroletable =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
    	    $role=$userroletable->selectrole();
            $form = new PermissionForm($role);
            $form->get('submit')->setAttribute('value','Submit');
            $request = $this->getRequest();  // getting current request object
            if ($request->isPost()) {
             $postdetail  = $request->getPost()->toArray();
             $permission =$postdetail['permission'];
             $roleid = $postdetail['role_id'] ;
             $userroletable =$this->getServiceLocator()->get('Dashboard\Model\DashboardTable') ;
             $userroletable->savePermission($permission,$roleid);
             $this->redirect()->toRoute('dashboard');
            }
           return new ViewModel(array('form' => $form));
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
}
