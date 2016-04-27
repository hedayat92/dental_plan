<?php include 'inc/config.php'; /*$template['header_link'] = 'FORMS';*/ ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; 
  
if($_POST) {
	extract($_POST);
	if($pid) {
	$update_qry = "update plans set plan_name='".mysqli_real_escape_string($cn,$plan_name)."',plan_monthly_price='".mysqli_real_escape_string($cn,$plan_monthly_price)."',plan_yearly_price='".mysqli_real_escape_string($cn,$plan_yearly_price)."',addon_monthly_price='".mysqli_real_escape_string($cn,$addon_monthly_price)."',addon_yearly_price='".mysqli_real_escape_string($cn,$addon_yearly_price)."',heading_line='".mysqli_real_escape_string($cn,$heading_line)."' where plan_id=".mysqli_real_escape_string($cn,$pid);
	mysqli_query($cn,$update_qry);
	} else {
	$insert_qry = "insert into plans(`doc_id`, `plan_name`, `plan_monthly_price`, `plan_yearly_price`, `addon_monthly_price`, `addon_yearly_price`, `heading_line`) values('".mysqli_real_escape_string($cn,$_SESSION['docUserID'])."','".mysqli_real_escape_string($cn,$plan_name)."','".mysqli_real_escape_string($cn,$plan_monthly_price)."','".mysqli_real_escape_string($cn,$plan_yearly_price)."','".mysqli_real_escape_string($cn,$addon_monthly_price)."','".mysqli_real_escape_string($cn,$addon_yearly_price)."','".mysqli_real_escape_string($cn,$heading_line)."')";
	mysqli_query($cn,$insert_qry);
	$newplan_id = mysqli_insert_id($cn);
	header("location:plans_service.php?plan_id=".$newplan_id);
	exit;
	}
	header("location:plans.php");
}
?>

<!-- Page content -->
<div id="page-content">
    <!-- Forms Components Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1><?php if($_GET['plan_id']) { echo "Edit"; } else { echo "Add";}?> Plan Details</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- END Forms Components Header -->

    <!-- Form Components Row -->
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form Block -->
            <div class="block">
<?php
		if($_GET['plan_id']) {
		$plan_qry = mysqli_query($cn,"select * from plans where plan_id=".mysqli_real_escape_string($cn,$_GET['plan_id'])." and ".mysqli_real_escape_string($cn,$_SESSION['docUserID']));
		$plan_r = mysqli_fetch_object($plan_qry);
		}

?>

                <!-- General Elements Content -->
                <form action="" method="post" class="form-horizontal form-bordered">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Name</label>
                        <div class="col-md-6">
                            <input type="text" id="plan_name" name="plan_name" class="form-control" placeholder="Name" value="<?php echo $plan_r->plan_name;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Individual Price (Monthly / Annually)</label>
                        <div class="col-md-6">
                            <input type="text" id="plan_monthly_price" name="plan_monthly_price" class="smalltxt" placeholder="Individual Price Monthly" value="<?php echo $plan_r->plan_monthly_price;?>">&nbsp;&nbsp;&nbsp;<input type="text" id="plan_yearly_price" name="plan_yearly_price" class="smalltxt" placeholder="Individual Price Annually" value="<?php echo $plan_r->plan_yearly_price;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Addon Price (Monthly / Annually)</label>
                        <div class="col-md-6">
                            <input type="text" id="addon_monthly_price" name="addon_monthly_price" class="smalltxt" placeholder="Addon Price Monthly" value="<?php echo $plan_r->addon_monthly_price;?>">&nbsp;&nbsp;&nbsp;<input type="text" id="addon_yearly_price" name="addon_yearly_price" class="smalltxt" placeholder="Addon Price Annually" value="<?php echo $plan_r->addon_yearly_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Heading Line</label>
                        <div class="col-md-6">
                            <input type="text" id="heading_line" name="heading_line" class="form-control" placeholder="Heading Line" value="<?php echo $plan_r->heading_line;?>">
                        </div>
                    </div>
<?php if($_GET['plan_id']) { ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Services</label>
                        <div class="col-md-9">
                            <p class="form-control-static"><?php 
// get service plans
$service_plan_qry = mysqli_query($cn,"select * from plan_services where plan_id=".mysqli_real_escape_string($cn,$plan_r->plan_id));
if(mysqli_num_rows($service_plan_qry)) {
	while($service_plan_r = mysqli_fetch_object($service_plan_qry)) {
		echo '<b>'.$service_plan_r->service_type.'</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="plans_service.php?plan_id='.$plan_r->plan_id.'&service_id='.$service_plan_r->service_id.'">Edit</a><br />';
		for($i=1;$i<=10;$i++) {
		$servicefield = 'service_name'.$i;
			if(trim($service_plan_r->$servicefield)) {
				echo stripslashes($service_plan_r->$servicefield).'<br>';
			}
		}
		echo '<i>'.stripslashes($service_plan_r->service_notes).'</i><br>';
	}
} else { echo '<a href="plans_service.php?plan_id='. $plan_r->plan_id.'">add new</a>'; } 
?></p>
                        </div>
                    </div>
<?php } ?>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-effect-ripple btn-primary">Submit</button>
                            <button type="reset" class="btn btn-effect-ripple btn-danger" onclick="javascript: window.location.assign('plans.php')">Cancel</button>
                            <a href="plans.php?delplan_id=<?php echo $plan_r->plan_id;?>" data-toggle="tooltip" onclick="return confirm('Are you sure you want to delete this Plan?');"><button type="reset" class="btn btn-effect-ripple btn-danger">Delete</button></a>
                        </div>
                    </div>
				<input type="hidden" name="pid" value="<?php echo $_GET['plan_id'];?>" />
                </form>
                <!-- END General Elements Content -->

            </div>
        
    </div>
    <!-- END Form Components Row -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) 
<script src="js/plugins/ckeditor/ckeditor.js"></script>-->

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/formsComponents.js"></script>
<script>$(function(){ FormsComponents.init(); });</script>

<?php include 'inc/template_end.php'; ?>