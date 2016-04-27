-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2016 at 04:04 AM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shreebal_dental_plan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `admin_userid` int(4) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(30) NOT NULL,
  `admin_nickname` varchar(30) NOT NULL,
  `admin_pass` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_userid`, `admin_username`, `admin_nickname`, `admin_pass`) VALUES
(1, 'admin@dental.com', 'Admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE IF NOT EXISTS `cms` (
  `page_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`page_id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10);

-- --------------------------------------------------------

--
-- Table structure for table `cms_description`
--

CREATE TABLE IF NOT EXISTS `cms_description` (
  `page_desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(100) DEFAULT NULL,
  `page_title` varchar(200) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `page_desc` text NOT NULL,
  `languages_id` tinyint(4) DEFAULT NULL,
  `sort_order` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`page_desc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `cms_description`
--

INSERT INTO `cms_description` (`page_desc_id`, `page_name`, `page_title`, `meta_description`, `meta_keywords`, `page_desc`, `languages_id`, `sort_order`, `status`, `page_id`) VALUES
(1, 'About Us', 'About Us', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>The people that made it possible.</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Team Member 1 -->\r\n            <section class="site-content site-section overflow-hidden border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items" style="height:400px;">\r\n                        \r\n                            \r\n                            <p>At DentalPlanSoftware.com our focus is to let you control your revenue instead of insurance companies.  Gone are those days where insurance companies make billions of dollars off of revenue you should be making.  We give you the software to make this a reality.  DentalPlanSoftware.com helps practices grow revenue dramatically by providing an all in one solution which creates and manages Private Dental Plans for dental practices.  Ready to have your own dental plan? Sign up today! \r\n</p>\r\n                       \r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 1 -->', 1, 1, 0, 1),
(3, 'FAQ', 'FAQ', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>All your questions answered.</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Intro Title -->\r\n            <section class="site-content site-section-mini site-section-light themed-background-social">\r\n                <div class="container">\r\n                    <h2 class="site-heading h3 site-block">\r\n                        <i class="fa fa-fw fa-chevron-right"></i> <strong>Introduction</strong>\r\n                    </h2>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro Title -->\r\n\r\n            <!-- Intro FAQ -->\r\n            <section class="site-content site-section">\r\n                <div class="container">\r\n                    <div class="row site-block">\r\n                        <div class="col-md-8 col-md-offset-2">\r\n                            <div id="faq1" class="panel-group">\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q1"><strong>How easy is the setup? </strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q1" class="panel-collapse collapse in">\r\n                                        <div class="panel-body">\r\n                                            <p>We take care of the setup for you so you dont have anything to worry about.  Setup takes about 1 hour to 2 hours depending on how many plans are being setup.</p>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q2"><strong>Do you choose the pricing for my plans?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q2" class="panel-collapse collapse">\r\n                                        <div class="panel-body">\r\n                                            <p>You choose your own pricing for your plans.</p>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q3"><strong>Do you choose the pricing for my procedures?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q3" class="panel-collapse collapse">\r\n                                        <div class="panel-body">No we do not choose your pricing for your procedures.  Your pricing is in your own hands.</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q4"><strong>Do you choose the pricing for my procedures?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q4" class="panel-collapse collapse">\r\n                                        <div class="panel-body">No we do not choose your pricing for your procedures.  Your pricing is in your own hands.</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q5"><strong>Do you take a cut out of my actual sales?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q5" class="panel-collapse collapse">\r\n                                        <div class="panel-body">No we do not!</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q6"><strong>How do I get paid?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q6" class="panel-collapse collapse">\r\n                                        <div class="panel-body">We send your earnings directly to your bank account at the end of every week.</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q7"><strong>Will I receive training?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q7" class="panel-collapse collapse">\r\n                                        <div class="panel-body">Yes training is provided.</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q7"><strong>How much does setup cost?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q7" class="panel-collapse collapse">\r\n                                        <div class="panel-body">The cost of setup depends on your practice size.  Usually between $200-$300 dollars. This cost covers your setup and the design and print of your marketing material.</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q7"><strong>Is it legal to have my own dental plan?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q7" class="panel-collapse collapse">\r\n                                        <div class="panel-body">Yes it is!</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q7"><strong>Can you help me with marketing?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q7" class="panel-collapse collapse">\r\n                                        <div class="panel-body">Yes we do help you with marketing of your new dental plan.  Your setup cost includes design and print of your brochures/pamphlets which help promote your new plan.</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q7"><strong>How much revenue can I make by using this? </strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q7" class="panel-collapse collapse">\r\n                                        <div class="panel-body">You will have recurring revenue for your own dental plan week after week.  We cannot give you an exact amount however expect a minimum of $4000/Month if all goes as planned within 2 months.</div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class="panel panel-default">\r\n                                    <div class="panel-heading">\r\n                                        <div class="panel-title">\r\n                                            <i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q7"><strong>Will I receive support?</strong></a>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div id="faq1_q7" class="panel-collapse collapse">\r\n                                        <div class="panel-body">Yes support is included within your pricing! </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro FAQ -->\r\n', 1, 2, 1, 2),
(4, 'Features', 'Features', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>The best features in one template.</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Features #1 -->\r\n            <section class="site-content site-section border-bottom">\r\n                <div class="container text-center">\r\n                    <div class="row row-items">\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-danger" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                            <img src="img/web63.png" width="48" height="48"> </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                              <h4 class="site-heading feature-heading"><strong>Patient Portal</strong></h4>\r\n                                <p class="feature-text text-muted">Your patients can login and view their coverage, change plans or add family.  Patients can see how much coverage they have used and what they have left so or the patient dont have to call their insurance company to verify what they have left to use. \r\n</p>\r\n                          </div>\r\n                      </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-success" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <img src="img/personal23.png" width="48" height="48"> \r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Doctor Dashboard</strong></h4>\r\n                                <p class="feature-text text-muted">Get a full overview of everything that is going on with your practice’s Private Dental Plan.  Dental Plan Software gives you all the information you need all in one place. </p>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-info" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <i class="fa fa-book"></i>\r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Full Analytics</strong></h4>\r\n                                <p class="feature-text text-muted">Get all the numbers of your revenue, patients in each dental plan, accepted or rejected patient referrals and more throughout your own Dental Plan Software account.</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Features #1 -->\r\n\r\n            <!-- Features #2 -->\r\n            <section class="site-content site-section border-bottom">\r\n                <div class="container text-center">\r\n                    <div class="row row-items">\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-amethyst" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <i class="gi gi-eye_open"></i>\r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Create Unlimited Plans</strong></h4>\r\n                                <p class="feature-text text-muted">One plan, two plans, three plans or more.  You can have as many plans as you want so your patients can choose what is right for them.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-flat" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <img src="img/money136.png" width="48" height="48"> \r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Recurring Billing</strong></h4>\r\n                                <p class="feature-text text-muted">Dental Plan Software pricess the recurring billing for you for all your patients so you dont have to worry about paying fees, setting up merchant accounts etc.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-passion" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <i class="gi gi-iphone_shake"></i>\r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Weekly Payouts</strong></h4>\r\n                                <p class="feature-text text-muted">Receive your recurring revenue straight to your bank account every week.  Since we process billing of your dental plans, we make sure you receive your payout without any hiccups or third parties. \r\n</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Features #2 -->\r\n\r\n            <!-- Features #3 -->\r\n            <section class="site-content site-section border-bottom">\r\n                <div class="container text-center">\r\n                    <div class="row row-items">\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-warning" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <img src="img/businessmen35.png" width="48" height="48"> \r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Patient Management System</strong></h4>\r\n                                <p class="feature-text text-muted">Dental Plan Software manages your patients and plans with top of the line security and algorithms.  You will see all of your statistics of plans and patients all in one place.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-info" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <img src="img/world58.png" width="48" height="48"> \r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Specialist Network</strong></h4>\r\n                                <p class="feature-text text-muted">Refer your patients to the top specialists in the Dental Plan Software network.  Specialists are hand chosen and the best in their field. </p>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-classy" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <img src="img/send4.png" width="48" height="48"> \r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Email Marketing</strong></h4>\r\n                                <p class="feature-text text-muted">We integrate to your practice management system so you can send mass email marketing to your patients to grow your Private Dental Plan base within your practice.</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Features #3 -->\r\n\r\n            <!-- Features #4 -->\r\n            <section class="site-content site-section">\r\n                <div class="container text-center">\r\n                    <div class="row row-items">\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-success" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <i class="fa fa-check"></i>\r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Easily Setup Patients</strong></h4>\r\n                                <p class="feature-text text-muted">Dental Plan Software makes it simple for you to add your patients to your private dental plan.  You can even add family members of your patients and grow your revenue even more. </p>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <img src="img/dollar177.png" width="48" height="48"> \r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Manage Your Fee Schedule</strong></h4>\r\n                                <p class="feature-text text-muted">Specialists can create and manage their own fee schedule to stay competitive in the market.  Patients will be able to choose the specialist they like best according to fee schedule and profile.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <a href="javascript:void(0)" class="feature visibility-none themed-background-social" data-toggle="animation-appear" data-animation-class="animation-fadeInQuickInv" data-element-offset="-100">\r\n                                <img src="img/office.png" width="48" height="48"> \r\n                            </a>\r\n                            <div class="visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick2Inv" data-element-offset="-100">\r\n                                <h4 class="site-heading feature-heading"><strong>Patient ID Cards</strong></h4>\r\n                                <p class="feature-text text-muted">Dental Plan Software automatically emails your private dental plan ID cards to patients the moment you set them up for a plan. This gives you the professional look of an insurance company and gives the patient the warmth of being part of a trusted network.</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Features #4 -->\r\n\r\n            <!-- Quick Stats -->\r\n            <section class="site-content site-section themed-background-dark">\r\n                <div class="container">\r\n                    <!-- Stats Row -->\r\n                    <!-- CountTo (initialized in js/app.js), for more examples you can check out https://github.com/mhuggins/jquery-countTo -->\r\n                    <div class="row">\r\n                        <div class="col-sm-4">\r\n                            <div class="counter site-block">\r\n                                <span data-toggle="countTo" data-to="2120" data-after="+"></span>\r\n                                <small>Total Revenue</small>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <div class="counter site-block">\r\n                                <span data-toggle="countTo" data-to="530" data-after="+"></span>\r\n                                <small>Doctors Registered</small>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <div class="counter site-block">\r\n                                <span data-toggle="countTo" data-to="3200" data-after="+"></span>\r\n                                <small>Patient Registered</small>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <!-- END Stats Row -->\r\n                </div>\r\n            </section>\r\n            <!-- END Quick Stats -->\r\n\r\n            <!-- Sign Up Action -->\r\n            <section class="site-content site-section">\r\n                <div class="container">\r\n                    <h2 class="site-heading text-center">Sign up today and receive <strong>30% discount</strong>!</h2>\r\n                    <div class="site-block text-center">\r\n                        <form action="features.html" method="post" class="form-inline" onSubmit="return false;">\r\n                            <div class="form-group">\r\n                                <label class="sr-only" for="register-username">Username</label>\r\n                                <input type="text" id="register-username" name="register-username" class="form-control input-lg" placeholder="Choose a username..">\r\n                            </div>\r\n                            <div class="form-group">\r\n                                <label class="sr-only" for="register-password">Password</label>\r\n                                <input type="password" id="register-password" name="register-password" class="form-control input-lg" placeholder="..and a password!">\r\n                            </div>\r\n                            <div class="form-group">\r\n                                <button type="submit" class="btn btn-lg btn-success">Get Started!</button>\r\n                            </div>\r\n                        </form>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Sign Up Action -->', 1, 3, 0, 3),
(6, 'Pricing', 'Pricing', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>Plans for everyone.</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Plans -->\r\n            <section class="site-content site-section">\r\n                <div class="container">\r\n                    <div class="site-block">\r\n                        <div class="row">\r\n                            <div class="col-sm-4">\r\n                                <table class="table table-borderless table-pricing">\r\n                                    <thead>\r\n                                        <tr>\r\n                                            <th>Dentists</th>\r\n                                        </tr>\r\n                                    </thead>\r\n                                    <tbody>\r\n                                        <tr class="active">\r\n                                            <td>\r\n                                                <h1>$<strong>299</strong><br><small>per month</small></h1>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Dental Plan Software</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Unlimited Dental Plans</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Unlimited Recurring Billing</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Specialist Network</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Weekly Payouts</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Online Patient Portal</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>15+ Features</td>\r\n                                        </tr>\r\n                                        <tr class="active">\r\n                                            <td>\r\n                                                <a href="javascript:void(0)" class="btn btn-effect-ripple  btn-success"><i class="fa fa-arrow-right"></i> Sign Up Today</a>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="text-muted">\r\n                                                <small><em>* All plans include free support!</em></small>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                            </div>\r\n                            <div class="col-sm-4">\r\n                                <table class="table table-borderless table-pricing">\r\n                                    <thead>\r\n                                        <tr>\r\n                                            <th>Specialists</th>\r\n                                        </tr>\r\n                                    </thead>\r\n                                    <tbody>\r\n                                        <tr class="active">\r\n                                            <td>\r\n                                                <h1>$<strong>$199</strong><br><small>per month</small></h1>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Specialist Software</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Unlimited Referrals</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Fee Schedule Management</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Accept or Decline Referrals</td>\r\n                                        </tr>\r\n                                         <tr>\r\n                                            <td><br><br><br><br><br></td>\r\n                                        </tr>\r\n                                        <tr class="active">\r\n                                            <td>\r\n                                                <a href="javascript:void(0)" class="btn btn-effect-ripple  btn-success"><i class="fa fa-arrow-right"></i> Sign Up Today</a>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="text-muted">\r\n                                                <small><em>* All plans include free support!</em></small>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                            </div>\r\n                            <div class="col-sm-4">\r\n                                <table class="table table-borderless table-pricing">\r\n                                    <thead>\r\n                                        <tr>\r\n                                            <th>Multiple Practices</th>\r\n                                        </tr>\r\n                                    </thead>\r\n                                    <tbody>\r\n                                        <tr class="active">\r\n                                            <td>\r\n                                                <h1><small>Contact For Pricing</small><br><br></h1>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Dental Plan Software</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Unlimited Dental Plans</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Unlimited Recurring Billing</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Specialist Network</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Weekly Payouts</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>Online Patient Portal</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td>15+ Features</td>\r\n                                        </tr>\r\n                                        <tr class="active">\r\n                                            <td>\r\n                                                <a href="javascript:void(0)" class="btn btn-effect-ripple  btn-success"><i class="fa fa-arrow-right"></i> Sign Up Today</a>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="text-muted">\r\n                                                <small><em>* All plans include free support!</em></small>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Plans -->\r\n\r\n            <!-- Quick Stats -->\r\n            <section class="site-content site-section themed-background-dark">\r\n                <div class="container">\r\n                    <!-- Stats Row -->\r\n                    <!-- CountTo (initialized in js/app.js), for more examples you can check out https://github.com/mhuggins/jquery-countTo -->\r\n                    <div class="row">\r\n                        <div class="col-sm-4">\r\n                            <div class="counter site-block">\r\n                                <span data-toggle="countTo" data-to="2120" data-after="+"></span>\r\n                                <small>Total Revenue</small>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <div class="counter site-block">\r\n                                <span data-toggle="countTo" data-to="530" data-after="+"></span>\r\n                                <small>Doctors Registered</small>\r\n                            </div>\r\n                        </div>\r\n                        <div class="col-sm-4">\r\n                            <div class="counter site-block">\r\n                                <span data-toggle="countTo" data-to="3200" data-after="+"></span>\r\n                                <small>Patient Registered</small>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <!-- END Stats Row -->\r\n                </div>\r\n            </section>\r\n            <!-- END Quick Stats -->\r\n\r\n            <!-- Testimonials -->\r\n            <section class="site-content site-section">\r\n                <div class="container">\r\n                    <div id="testimonials-carousel" class="carousel slide carousel-html" data-ride="carousel" data-interval="4000">\r\n                        <div class="carousel-inner text-center">\r\n                            <div class="active item">\r\n                                <blockquote>\r\n                                    <p><img src="img/placeholders/avatars/avatar13@2x.jpg" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar-2x"></p>\r\n                                    <h3>A big thanks! Our web app looks great!</h3>\r\n                                    <footer><em><strong>Maria Clark</strong>, http://example.com/</em></footer>\r\n                                </blockquote>\r\n                            </div>\r\n                            <div class="item">\r\n                                <blockquote>\r\n                                    <p><img src="img/placeholders/avatars/avatar2@2x.jpg" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar-2x"></p>\r\n                                    <h3>It just works!</h3>\r\n                                    <footer><em><strong>Roger Santos</strong>, http://example.com/</em></footer>\r\n                                </blockquote>\r\n                            </div>\r\n                            <div class="item">\r\n                                <blockquote>\r\n                                    <p><img src="img/placeholders/avatars/avatar1@2x.jpg" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar-2x"></p>\r\n                                    <h3>A great product at a great price!</h3>\r\n                                    <footer><em><strong>Edward Duncan</strong>, http://example.com/</em></footer>\r\n                                </blockquote>\r\n                            </div>\r\n                            <div class="item">\r\n                                <blockquote>\r\n                                    <p><img src="img/placeholders/avatars/avatar7@2x.jpg" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar-2x"></p>\r\n                                    <h3>Awesome purchase, I''m so happy I made it!</h3>\r\n                                    <footer><em><strong>Scott Gray</strong>, http://example.com/</em></footer>\r\n                                </blockquote>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Testimonials -->', NULL, 0, 0, 5);
INSERT INTO `cms_description` (`page_desc_id`, `page_name`, `page_title`, `meta_description`, `meta_keywords`, `page_desc`, `languages_id`, `sort_order`, `status`, `page_id`) VALUES
(7, 'Specialists', 'Specialists', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>Specialists</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Team Member 1 -->\r\n            <section class="site-content site-section overflow-hidden border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items">\r\n                        <div class="col-md-2 col-md-offset-2 text-center visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInRight" data-element-offset="-20">\r\n                            <img src="img/placeholders/avatars/avatar7@2x.jpg" alt="" class="img-circle img-thumbnail img-thumbnail-avatar-2x">\r\n                        </div>\r\n                        <div class="col-md-6 visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInLeft" data-element-offset="-20">\r\n                            <h4>\r\n                                <span class="text-muted text-uppercase pull-right">Dentist</span>\r\n                                <strong>Harry Scott</strong>\r\n                            </h4>\r\n                            <p>Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum.</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 1 -->\r\n\r\n            <!-- Team Member 2 -->\r\n            <section class="site-content site-section overflow-hidden themed-background-muted border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items">\r\n                        <div class="col-md-2 col-md-offset-2 text-center visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInRight" data-element-offset="-20">\r\n                            <img src="img/placeholders/avatars/avatar6@2x.jpg" alt="" class="img-circle img-thumbnail img-thumbnail-avatar-2x">\r\n                        </div>\r\n                        <div class="col-md-6 visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInLeft" data-element-offset="-20">\r\n                            <h4>\r\n                                <span class="text-muted text-uppercase pull-right">Orthodontist</span>\r\n                                <strong>Judy Rogers</strong>\r\n                            </h4>\r\n                            <p>Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum.</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 2 -->\r\n\r\n            <!-- Team Member 3 -->\r\n            <section class="site-content site-section overflow-hidden border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items">\r\n                        <div class="col-md-2 col-md-offset-2 text-center visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInRight" data-element-offset="-20">\r\n                            <img src="img/placeholders/avatars/avatar15@2x.jpg" alt="" class="img-circle img-thumbnail img-thumbnail-avatar-2x">\r\n                        </div>\r\n                        <div class="col-md-6 visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInLeft" data-element-offset="-20">\r\n                            <h4>\r\n                                <span class="text-muted text-uppercase pull-right">Orthodontist</span>\r\n                                <strong>Phillip Cox</strong>\r\n                            </h4>\r\n                            <p>Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum.</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 3 -->\r\n\r\n            <!-- Team Member 4 -->\r\n            <section class="site-content site-section overflow-hidden themed-background-muted border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items">\r\n                        <div class="col-md-2 col-md-offset-2 text-center visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInRight" data-element-offset="-20">\r\n                            <img src="img/placeholders/avatars/avatar12@2x.jpg" alt="" class="img-circle img-thumbnail img-thumbnail-avatar-2x">\r\n                        </div>\r\n                        <div class="col-md-6 visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInLeft" data-element-offset="-20">\r\n                            <h4>\r\n                                <span class="text-muted text-uppercase pull-right">Dentist</span>\r\n                                <strong>Carol Dunn</strong>\r\n                            </h4>\r\n                            <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum.</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 4 -->\r\n\r\n            <!-- Team Member 5 -->\r\n            <section class="site-content site-section overflow-hidden border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items">\r\n                        <div class="col-md-2 col-md-offset-2 text-center visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInRight" data-element-offset="-20">\r\n                            <img src="img/placeholders/avatars/avatar4@2x.jpg" alt="" class="img-circle img-thumbnail img-thumbnail-avatar-2x">\r\n                        </div>\r\n                        <div class="col-md-6 visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInLeft" data-element-offset="-20">\r\n                            <h4>\r\n                                <span class="text-muted text-uppercase pull-right">Orthodontist</span>\r\n                                <strong>Brian Jenkins</strong>\r\n                            </h4>\r\n                            <p>In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis.</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 5 -->', NULL, 0, 0, 6),
(5, 'Contact Us', 'Contact-Us', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>We are here if you need help.</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Google Map -->\r\n            <!-- Gmaps.js (initialized in js/pages/contact.js), for more examples you can check out http://hpneo.github.io/gmaps/examples.html -->\r\n            <div id="gmap" class="themed-background-muted" style="height: 300px;"></div>\r\n            <!-- END Google Map -->\r\n\r\n            <!-- Contact -->\r\n            <section class="site-content site-section">\r\n                <div class="container">\r\n                <div align="center" style="line-height:40px;"><strong>Address:</strong> 307 E Chapman Avenue,  Orange CA, 92866<br>\r\n<strong>Phone:</strong> (949) 929-8725<br>\r\n<strong>Email:</strong> Support@DentalPlanSoftware.com<br> \r\n<strong>Sales:</strong> Sales@DentalPlanSoftware.com<br><br><br>\r\n</div>\r\n                    <div class="row">\r\n                    \r\n                        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 site-block">\r\n                            <form action="" method="post" id="form-contact">\r\n                                <div class="form-group">\r\n                                    <label for="contact-name">Name</label>\r\n                                    <input type="text" id="contact-name" name="contact-name" class="form-control input-lg" placeholder="Your full name..">\r\n                                </div>\r\n                                <div class="form-group">\r\n                                    <label for="contact-email">Email</label>\r\n                                    <input type="text" id="contact-email" name="contact-email" class="form-control input-lg" placeholder="Your email address..">\r\n                                </div>\r\n                                <div class="form-group">\r\n                                    <label for="contact-message">Message</label>\r\n                                    <textarea id="contact-message" name="contact-message" rows="10" class="form-control input-lg" placeholder="How can we help?"></textarea>\r\n                                </div>\r\n                                <div class="form-group">\r\n                                    <button type="submit" class="btn btn-lg btn-primary">Send Message</button>\r\n                                </div>\r\n                            </form>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n', 1, 10, 0, 4),
(8, 'Potential Revenue', 'Potential Revenue', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>Potential Revenue</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Team Member 1 -->\r\n            <section class="site-content site-section overflow-hidden border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items">\r\n                        \r\n                            \r\n                            <p align="center"><img src="img/placeholders/screenshots/graph.png" width="953" height="600"><br><br></p>\r\n                       \r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 1 -->', NULL, 0, 0, 7),
(9, 'Blog', 'Blog', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>Our Latest Articles.</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Latest Posts -->\r\n            <section class="site-content site-section">\r\n                <div class="container">\r\n                    <div class="row row-items">\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo4.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">2 days ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>The autumn trip that changed my life</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo11.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">5 days ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>The best pizza you''ll ever taste</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                    </div>\r\n                    <div class="row row-items">\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo14.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">1 week ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>Best breakfast picks</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo20.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">2 weeks ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>10 productivity tips</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                    </div>\r\n                    <div class="row row-items">\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo22.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">3 weeks ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>Going with a premium account</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo21.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">1 month ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>Sunflower seeds are the best</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                    </div>\r\n                    <div class="row row-items">\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo13.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">2 months ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>Spring is upon us</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                        <div class="col-md-6">\r\n                            <a href="blog_post.html" class="post">\r\n                                <div class="post-image">\r\n                                    <img src="img/placeholders/photos/photo12.jpg" alt="" class="img-responsive">\r\n                                </div>\r\n                                <div class="text-muted pull-right">2 months ago</div>\r\n                                <h2 class="h4">\r\n                                    <strong>Going out for a drink</strong>\r\n                                </h2>\r\n                                <p>Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta.</p>\r\n                            </a>\r\n                        </div>\r\n                    </div>\r\n                    <div class="text-center">\r\n                        <ul class="pagination">\r\n                            <li class="active"><a href="javascript:void(0)">1</a></li>\r\n                            <li><a href="javascript:void(0)">2</a></li>\r\n                            <li><a href="javascript:void(0)">3</a></li>\r\n                            <li><span>...</span></li>\r\n                            <li><a href="javascript:void(0)">20</a></li>\r\n                            <li><a href="javascript:void(0)"><i class="fa fa-chevron-right"></i></a></li>\r\n                        </ul>\r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Latest Posts -->', NULL, 0, 0, 8),
(10, 'Terms & Conditions', 'Terms & Conditions', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>Terms &amp; Conditions</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Team Member 1 -->\r\n            <section class="site-content site-section overflow-hidden border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items" style="height:400px;">\r\n                        \r\n                            \r\n                            <p>At DentalPlanSoftware.com our focus is to let you control your revenue instead of insurance companies.  Gone are those days where insurance companies make billions of dollars off of revenue you should be making.  We give you the software to make this a reality.  DentalPlanSoftware.com helps practices grow revenue dramatically by providing an all in one solution which creates and manages Private Dental Plans for dental practices.  Ready to have your own dental plan? Sign up today! \r\n</p>\r\n                       \r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 1 -->', NULL, 0, 0, 9),
(11, 'Privacy Policy', 'Privacy Policy', '', '', '            <!-- Intro -->\r\n            <section class="site-section site-section-top site-section-light themed-background-dark">\r\n                <div class="container">\r\n                    <h1 class="text-center animation-fadeInQuickInv"><strong>Privacy Policy</strong></h1>\r\n                </div>\r\n            </section>\r\n            <!-- END Intro -->\r\n\r\n            <!-- Team Member 1 -->\r\n            <section class="site-content site-section overflow-hidden border-bottom">\r\n                <div class="container">\r\n                    <div class="row row-items" style="height:400px;">\r\n                        \r\n                            \r\n                            <p>At DentalPlanSoftware.com our focus is to let you control your revenue instead of insurance companies.  Gone are those days where insurance companies make billions of dollars off of revenue you should be making.  We give you the software to make this a reality.  DentalPlanSoftware.com helps practices grow revenue dramatically by providing an all in one solution which creates and manages Private Dental Plans for dental practices.  Ready to have your own dental plan? Sign up today! \r\n</p>\r\n                       \r\n                    </div>\r\n                </div>\r\n            </section>\r\n            <!-- END Team Member 1 -->\r\n', NULL, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_details`
--

CREATE TABLE IF NOT EXISTS `doctor_details` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_firstname` varchar(70) NOT NULL,
  `doc_lastname` varchar(200) NOT NULL,
  `doc_sex` varchar(10) NOT NULL,
  `doc_speciality` varchar(50) NOT NULL,
  `doc_speciality_detail` varchar(80) NOT NULL,
  `doc_address` varchar(250) NOT NULL,
  `doc_zip` varchar(10) NOT NULL,
  `doc_phone` varchar(15) NOT NULL,
  `doc_phone2` varchar(15) NOT NULL,
  `doc_email` varchar(50) NOT NULL,
  `doc_contact_person` varchar(50) NOT NULL,
  `doc_license_no` varchar(30) NOT NULL,
  `doc_username` varchar(30) NOT NULL,
  `doc_pass` varchar(80) NOT NULL,
  `doc_status` int(1) NOT NULL DEFAULT '0',
  `doc_avatar` varchar(250) NOT NULL,
  `add_date` date NOT NULL,
  `bank_routing_number` varchar(200) NOT NULL,
  `bank_account_number` varchar(200) NOT NULL,
  `account_id` varchar(150) NOT NULL,
  `bank_acc_id` varchar(150) NOT NULL,
  `bank_account_type` varchar(20) NOT NULL,
  `legal_name` varchar(100) NOT NULL,
  `cc_number` varchar(200) NOT NULL,
  `cc_month` varchar(10) NOT NULL,
  `cc_year` varchar(10) NOT NULL,
  `cust_id` varchar(150) NOT NULL,
  `subs_id` varchar(150) NOT NULL,
  `plan_token_id` varchar(150) NOT NULL,
  `subs_cancel_dt` date NOT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `doctor_details`
--

INSERT INTO `doctor_details` (`doc_id`, `doc_firstname`, `doc_lastname`, `doc_sex`, `doc_speciality`, `doc_speciality_detail`, `doc_address`, `doc_zip`, `doc_phone`, `doc_phone2`, `doc_email`, `doc_contact_person`, `doc_license_no`, `doc_username`, `doc_pass`, `doc_status`, `doc_avatar`, `add_date`, `bank_routing_number`, `bank_account_number`, `account_id`, `bank_acc_id`, `bank_account_type`, `legal_name`, `cc_number`, `cc_month`, `cc_year`, `cust_id`, `subs_id`, `plan_token_id`, `subs_cancel_dt`) VALUES
(1, 'Dr. PETER', 'NGUYEN', '1', '1', '', '1501 SUPERIOR AVE #302\r\n', '92663', '949-548-8218', '', 'GENUINEDENTALARTS@LIVE.COM', 'PETER NGUYEN', '56708', 'genuinedentalarts', 'd90cfb24c809e4fc16ccfe9ae50b2030', 1, 'avatar1.57.29.png', '2015-11-11', 'G4CqMNOQGMU+6sU8QIsH535cvMKIUiNQLHPD4om3Nms=', '79s4G7S+wnNi5fJUGC3Bd57FiZo3cbDuZsyuGft/0m4=', 'LIec/XKuet9UmO0RvruGgrawJ7XeRdWgwSCT2ftREI8=', '', 'individual', 'PETER NGUYEN DDS INC', 'KxQ36sr26iK+e2ewD1AH+SdQtNH5Hlyb8NjJWRsIfPw=', '09', '2018', 'Armz0G4tjsdZfGxxASgWBDHPUqI+BrG3yfjg3yvAAsw=', 'jRvwi5hZ42T2fDfzkp1uTtZBiRHu1EtFxk+c4nXPL+o=', '', '0000-00-00'),
(2, 'Dr. Doug', 'Barker', '1', '1', '', '400 Newport Center Drive. Suite 408', '92660', '9496440922', '', 'drdougbarker@dmd.occoxmail.com', 'Dr. Doug Barker', '123456', 'dougbarkerdmd', 'e10adc3949ba59abbe56e057f20f883e', 1, 'avatar2.39.26.png', '2015-12-09', 'c0zFQMjSZizRueBPaD3GiaIVTLVowny3sIh3rMXzmaU=', 'WWIR7UDPw1vZ+HUAmcLzJzaZGmUx2DcfD3XZj7GQBgU=', 'd1YgHtbFIfpB3UjK4ujSZY5tEWuMzxlUp7sYWiZodao=', '', 'individual', 'K. Douglas Barker, DMD Inc. ', 'hKypKTbhEtywGYytunYcl+gPMidfHkq+axYuxH5Y65c=', '10', '2017', 'siwQA81a+9Yh3TI/sRYTXxJU9zVlFYqF0TbGeK3/7oc=', 'GwsnbysGjR+ZGYxCk/6DEVBbm2qq+Di5mpEuIMgsMlE=', '', '0000-00-00'),
(3, 'Kiran', 'Singh', '1', '1', '', '17200 Newhope St. ', '92708', '9499298725', '', 'katherine@docmate.com', 'Davan Singh ', 'd9282932', 'katherine', 'e10adc3949ba59abbe56e057f20f883e', 0, '', '2015-12-21', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `doc_payments`
--

CREATE TABLE IF NOT EXISTS `doc_payments` (
  `doc_pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(4) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `pay_date` date NOT NULL,
  `pay_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`doc_pay_id`),
  UNIQUE KEY `pat_pay_id` (`doc_pay_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `doc_payments`
--

INSERT INTO `doc_payments` (`doc_pay_id`, `doc_id`, `amount`, `pay_date`, `pay_status`) VALUES
(1, 1, '300.0000', '2015-11-11', 1),
(2, 2, '300.0000', '2015-12-09', 1),
(3, 1, '300.0000', '2015-12-11', 1),
(4, 2, '300.0000', '2016-01-09', 1),
(5, 1, '300.0000', '2016-01-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doc_payout`
--

CREATE TABLE IF NOT EXISTS `doc_payout` (
  `doc_payout_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(4) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `payout_date` date NOT NULL,
  `payout_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`doc_payout_id`),
  UNIQUE KEY `pat_pay_id` (`doc_payout_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `doc_payout`
--

INSERT INTO `doc_payout` (`doc_payout_id`, `doc_id`, `amount`, `payout_date`, `payout_status`) VALUES
(1, 1, '2.0000', '2015-12-10', 1),
(2, 2, '580.0000', '2016-01-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_salutation` varchar(6) NOT NULL,
  `patient_firstname` varchar(150) NOT NULL,
  `patient_lastname` varchar(100) NOT NULL,
  `patient_dob` date NOT NULL,
  `patient_ssn` varchar(50) NOT NULL,
  `patient_sex` varchar(10) NOT NULL,
  `patient_address` varchar(350) NOT NULL,
  `patient_zip` varchar(6) NOT NULL,
  `patient_phone` varchar(15) NOT NULL,
  `patient_mobile` varchar(15) NOT NULL,
  `patient_email` varchar(50) NOT NULL,
  `patient_pass` varchar(80) NOT NULL,
  `patient_family_info` text NOT NULL,
  `patient_lastprocedure_info` text NOT NULL,
  `patient_consent` int(1) NOT NULL,
  `patient_status` int(1) NOT NULL,
  `profile_img` varchar(350) NOT NULL,
  `plan_start_date` date NOT NULL,
  `renewal_time` int(4) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `plan_id` int(4) NOT NULL,
  `plan_cycle` int(1) NOT NULL,
  `doc_id` int(4) NOT NULL,
  `cc_number` varchar(200) NOT NULL,
  `cc_month` varchar(200) NOT NULL,
  `cc_year` varchar(200) NOT NULL,
  `cust_id` varchar(150) NOT NULL,
  `subs_id` varchar(150) NOT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_salutation`, `patient_firstname`, `patient_lastname`, `patient_dob`, `patient_ssn`, `patient_sex`, `patient_address`, `patient_zip`, `patient_phone`, `patient_mobile`, `patient_email`, `patient_pass`, `patient_family_info`, `patient_lastprocedure_info`, `patient_consent`, `patient_status`, `profile_img`, `plan_start_date`, `renewal_time`, `parent_id`, `plan_id`, `plan_cycle`, `doc_id`, `cc_number`, `cc_month`, `cc_year`, `cust_id`, `subs_id`) VALUES
(1, 'Mr.', 'PETER', 'NGUYEN', '1990-11-19', '1234', '1', '123 MILLS LANE', '92653', '1234567890', '1234567890', 'VANDEEGAN@GMAIL.COM', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 1, '', '2015-11-11', 0, 0, 2, 1, 1, 'KxQ36sr26iK+e2ewD1AH+SdQtNH5Hlyb8NjJWRsIfPw=', '09', '2018', 'yqpywUIwwdxvZyGg65zBnarwwuqQTeagzowdEfKa+bM=', 'Dgs/9IxuWRpI8pj98jgvJS4Wm0aRzMXKtiIVT0e5O08='),
(2, 'Mr.', 'Rosalind', 'Melcher', '1937-09-10', '5253', '2', '340 Flower St., Costa Mesa CA ', '92627', '949-646-4321', '', 'rlm340@msn.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 1, '', '2015-12-09', 0, 0, 8, 1, 2, 'P3vfwSnKFQnSsQGlArxXJAGA8Mxi+gpNK3eUxfVeWFw=', '10', '2020', 'G+R4GIkn2sWqQKjAR3Vx+WGdAU3ZFCJ2gQvpfrq1S3U=', '5oi42vbkNljyDN1udiyhyvaE1jxPUVpoc33V5Z9BBQo='),
(3, 'Mr.', 'Charles', 'Goldsworthy', '1953-07-13', '6223', '1', '7400 W. Oceanfront Newport Beach', '92663', '949-584-4200', '949-584-4200', 'charles469@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 1, '', '2015-12-09', 0, 0, 6, 2, 2, '', '', '', '', ''),
(4, 'Mr.', 'Ron', 'Appel', '1959-12-01', '6180', '1', '2522 Chambers Road. Tustin CA ', '92780', '7149447588', '', 'ronflys1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 1, '', '2015-12-11', 0, 0, 6, 1, 2, 'BcWAQTAatlw8yNJ1QdIil6jvPslcgvcsJKe1jisPrMk=', '10', '2020', 'wc3S1h5JeSgOiD80PjzFoH5H3HsnuqOC6Bx4u+iYl9Q=', '6EzifhEFRNwkPycO2yn5njWYSltY+NPGrNlsKZhHxr4='),
(5, 'Mr.', 'Bohdan', 'Polany', '1967-08-04', '7813', '2', 'PO Box 11598 Newport Beach', '92658', '9492442016', '', 'drdougdmd@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 1, '', '2015-12-11', 0, 0, 6, 1, 2, 'NKU/2VPmjr5v4OEYLOfoOUMfQn0XRpJT8ZcWXDumdqE=', '03', '2017', 'FLce3gfBdgVUvAAwJYXYcBziSEIKb+J/+C/mZnXhn6k=', 'B3l7cCvYjTVAKqPVwx1TvZIr0sl4Wm+3s0W1HwvYBPY='),
(6, 'Mr.', 'Sandra', 'Bois', '1957-03-29', '9508', '2', '4431 Dorchester Place Carlsbad CA', '92010', '9497950656', '', 'sandibois@cox.net', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 1, '', '2015-12-11', 0, 0, 6, 1, 2, 'tQkX/5ekFvcW4hrqQGJ5oRJ16KL95LXqJFwOUlFcbDw=', '09', '2018', 'ZFCKOExkVIeyrmPv8UugizaqenDMR5jdIsFSqo5n7qE=', 'MAsQNHZ9DoTdrmQ0BKx7a+iSgEcpxz83ZIAqNJgz2Yc='),
(7, 'Mr.', 'William', 'Helm', '1955-07-23', '6901', '1', '17 Sommet\r\nNewport Coast, CA', '92657', '949 759-9157', '', 'williamhelm@cox.net', '4223f371b7a81418b4baef9e2f7e7185', '', '', 1, 1, '', '2015-12-15', 0, 0, 6, 1, 2, 'vM0ww2kQK8Rei5SmRCzrgqvdVi0Ekoijv6MekJgBQNQ=', '09', '18', 'iZNinE/5Rn2BFvtTRZkl1qGzMg0wBPGwQinq5lfi0DI=', 'Yq3FcJ1MmMSZk/QtaDG/tfvXzOmyvzWHw9hRXl11+Fo='),
(8, 'Mr.', 'Wendell', 'Maberry', '2015-12-22', '', '1', '442 Broadway\r\nCosta Mesa, CA', '92627', '949-646-1105', '', 'wendellmaberry@yahoo.com', 'cd28bfaf9a0afdf6bb4d1f4f2da426bc', '', '', 1, 1, '', '2015-12-22', 0, 0, 8, 1, 2, 'jUBcPXqOX3VAVoVYxK6UpbtDUMVRtGZWFfHuHHceLP4=', '06', '17', 'gtqC0bwzXXQjJqvHe1kJceRARHHqc2ho2phBcr6GSYs=', 'YZn8XlYnxhEbCiNwPvS9vYW9sxpPIWlCJqwd/+vyDtg='),
(9, 'Mrs.', 'Barbara', 'Maberry', '2015-12-22', '', '2', '', '', '949-378-1114', '', 'babsmaberry@sbcglobal.net', 'd41d8cd98f00b204e9800998ecf8427e', '', '', 0, 1, '', '2015-12-22', 0, 8, 0, 0, 2, '', '', '', '', ''),
(10, 'Mr.', 'Jack', 'Casey', '2015-12-22', '8330', '1', '3714 Sea Breeze\r\nSanta Ana, CA', '92704', '714-540-8989', '', 'fighton57@yahoo.com', 'a8c1ec5e976a2b12f37ed7bc21e23cf4', '', '', 1, 1, '', '2015-12-22', 0, 0, 6, 1, 2, 'm+kfUX7kXf8x9eN2vNjS1UX949y3FNoTt+KaoTmABZM=', '07', '18', 'CajrwFRMuAM5o0ktvNrlWAmiiEzh6ILszdqYuku/3zg=', 'XO9ThYtXV1kIdBx4XlHj9omCL2BUQoVLn4lPe3epFoo='),
(11, 'Mr.', 'Dinora', 'Reyes', '1958-06-18', '7812', '2', '607 North Main Street\r\nMuldrow, OK', '74948', '479-926-0386', '', 'drui58@aol.com', '79a11ab058e98ef48d50c0eb6c09d6e8', '', '', 1, 1, '', '2015-12-22', 0, 0, 6, 1, 2, 'X1oqxR3nt4JvD2Dctt2fH0gV/pftM8sIuKaG7cZkUvQ=', '07', '16', '1b7KqgV1JDn+UxEtO0ut/+6Uqe54nJ7hZdHvmIkoyyo=', '5+CLFBYe95hFDMaVbMz2jj/dPjNi/hheGWmHvoCiQvk='),
(12, 'Mr.', 'Brittany', 'James', '1984-08-27', '5128', '2', '39 Henley\r\nLaguna Niguel', '92677', '', '949-584-3000', 'brittanyjay@yahoo.com', '68faffc89f1ee95e20e73e59be61bcca', '', '', 1, 1, '', '2016-01-04', 0, 0, 6, 1, 2, 'sX0z9tLR5BqIDsYQWv6g6sRuB9aNJzurqqmckv4yELo=', '01', '19', 'Yi7q66hL+HcDMkyq9+pQoCiuJe5womA3QbAmnusJti0=', '9VeWlwi+xJ0NOmwKI9zxKVGjFipe0wbrXOcECpqTWpY='),
(13, 'Mr.', 'Patricia', 'McCurdy', '2035-01-12', '6966', '2', '18691 Portofino\r\nIrvine, CA', '92603', '9492937833', '9492937833', 'pat.mccurdy36@gmail.com', 'e5117ff195dceedc5eea3874d5c1d85e', '', '', 1, 1, '', '2016-01-12', 0, 0, 6, 1, 2, 'Zn3sNIwvyWnCqcjUW8n+5ckxAxGzEXDlpnPyknd9e+8=', '10', '19', 'IA2v0f8uMBuI//3P4FVf5pyZfAiwJh3KAPL+c3ZMiuQ=', '4tJ0ee+iUAOtythw2NXJ8vLHo8g7AyucJKTL8UxmebA=');

-- --------------------------------------------------------

--
-- Table structure for table `patients_payments`
--

CREATE TABLE IF NOT EXISTS `patients_payments` (
  `pat_pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(4) NOT NULL,
  `plan_id` int(4) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `pay_date` date NOT NULL,
  `pay_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pat_pay_id`),
  UNIQUE KEY `pat_pay_id` (`pat_pay_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `patients_payments`
--

INSERT INTO `patients_payments` (`pat_pay_id`, `patient_id`, `plan_id`, `amount`, `pay_date`, `pay_status`) VALUES
(1, 1, 2, '2.0000', '2015-11-11', 1),
(2, 2, 8, '90.0000', '2015-12-09', 1),
(3, 4, 6, '50.0000', '2015-12-11', 1),
(4, 5, 6, '50.0000', '2015-12-11', 1),
(5, 6, 6, '50.0000', '2015-12-11', 1),
(6, 7, 6, '50.0000', '2015-12-15', 1),
(7, 8, 8, '140.0000', '2015-12-22', 1),
(8, 10, 6, '50.0000', '2015-12-22', 1),
(9, 11, 6, '50.0000', '2015-12-22', 1),
(10, 12, 6, '50.0000', '2016-01-04', 1),
(11, 13, 6, '50.0000', '2016-01-12', 1),
(12, 1, 2, '2.0000', '2015-12-11', 1),
(13, 2, 8, '90.0000', '2016-01-09', 1),
(14, 4, 6, '50.0000', '2016-01-11', 1),
(15, 5, 6, '50.0000', '2016-01-11', 1),
(16, 6, 6, '50.0000', '2016-01-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(4) NOT NULL,
  `plan_name` varchar(150) NOT NULL,
  `heading_line` varchar(200) NOT NULL,
  `plan_monthly_price` decimal(10,4) NOT NULL,
  `plan_yearly_price` decimal(10,4) NOT NULL,
  `addon_monthly_price` decimal(10,4) NOT NULL,
  `addon_yearly_price` decimal(10,4) NOT NULL,
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `doc_id`, `plan_name`, `heading_line`, `plan_monthly_price`, `plan_yearly_price`, `addon_monthly_price`, `addon_yearly_price`) VALUES
(6, 2, 'Silver Plan', 'Basic Coverage', '50.0000', '600.0000', '30.0000', '360.0000'),
(7, 2, 'Gold Plan', 'Medium Plan', '70.0000', '840.0000', '40.0000', '480.0000'),
(8, 2, 'Platinum Plan', 'Most Amount of Coverage', '90.0000', '1080.0000', '50.0000', '600.0000'),
(11, 1, 'Silver Plan', 'Silver Plan', '50.0000', '600.0000', '40.0000', '480.0000');

-- --------------------------------------------------------

--
-- Table structure for table `plan_services`
--

CREATE TABLE IF NOT EXISTS `plan_services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_type` varchar(150) NOT NULL,
  `service_name1` varchar(250) NOT NULL,
  `service_name2` varchar(250) NOT NULL,
  `service_name3` varchar(250) NOT NULL,
  `service_name4` varchar(250) NOT NULL,
  `service_name5` varchar(250) NOT NULL,
  `service_name6` varchar(250) NOT NULL,
  `service_name7` varchar(250) NOT NULL,
  `service_name8` varchar(250) NOT NULL,
  `service_name9` varchar(250) NOT NULL,
  `service_name10` varchar(250) NOT NULL,
  `service_notes` text NOT NULL,
  `plan_id` int(11) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `plan_services`
--

INSERT INTO `plan_services` (`service_id`, `service_type`, `service_name1`, `service_name2`, `service_name3`, `service_name4`, `service_name5`, `service_name6`, `service_name7`, `service_name8`, `service_name9`, `service_name10`, `service_notes`, `plan_id`) VALUES
(8, 'Preventative', 'Coverage', '', '', '', '', '', '', '', '', '', '100%', 6),
(9, 'Basic Coverage', 'Coverage', '', '', '', '', '', '', '', '', '', '60%', 6),
(10, 'Coverage of Major', 'Coverage', '', '', '', '', '', '', '', '', '', '40%', 6),
(11, 'Invisalign', 'Coverage', '', '', '', '', '', '', '', '', '', '20%', 6),
(12, 'Take Home Whitening Kit', 'Coverage', '', '', '', '', '', '', '', '', '', 'FREE', 6),
(13, 'Preventative', 'Coverage', '', '', '', '', '', '', '', '', '', '100%', 7),
(14, 'Basic', 'Coverage', '', '', '', '', '', '', '', '', '', '70%', 7),
(15, 'Major Procedures', 'Coverage', '', '', '', '', '', '', '', '', '', '45%', 7),
(16, 'Invisalign', 'Coverage', '', '', '', '', '', '', '', '', '', '25% ', 7),
(17, 'Chairside Whitening', '1 Per Year', '', '', '', '', '', '', '', '', '', 'Free', 7),
(18, 'Preventative', 'Coverage', '', '', '', '', '', '', '', '', '', '100%', 8),
(19, 'Basic', 'Coverage', '', '', '', '', '', '', '', '', '', '80%', 8),
(20, 'Major Procedures', 'Coverage', '', '', '', '', '', '', '', '', '', '50%', 8),
(21, 'Invisalign', 'Coverage', '', '', '', '', '', '', '', '', '', '30% l', 8),
(22, '1 Teeth Whitening Take Home Kit & 1 Chair side Whitening', 'Coverage', '', '', '', '', '', '', '', '', '', 'FREE', 8);

-- --------------------------------------------------------

--
-- Table structure for table `plan_stripe`
--

CREATE TABLE IF NOT EXISTS `plan_stripe` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `plan_code` varchar(100) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `plan_stripe`
--

INSERT INTO `plan_stripe` (`id`, `plan_code`, `amount`) VALUES
(1, 'TEST PLAN_1_2_Ind1_Month', '2.0000'),
(2, 'Platinum Plan_Doug_Barker_8_Ind1_Month', '90.0000'),
(3, 'Silver Plan_Dr. Doug_Barker_6_Ind1_Month', '50.0000'),
(4, 'Platinum Plan_Dr. Doug_Barker_8_Add1_Month', '140.0000');

-- --------------------------------------------------------

--
-- Table structure for table `refer_patient`
--

CREATE TABLE IF NOT EXISTS `refer_patient` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(4) NOT NULL,
  `refer_by` int(4) NOT NULL,
  `comments` text NOT NULL,
  `refer_to` int(4) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `spl_services`
--

CREATE TABLE IF NOT EXISTS `spl_services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_type` varchar(150) NOT NULL,
  `service_name1` varchar(250) NOT NULL,
  `service_name2` varchar(250) NOT NULL,
  `service_name3` varchar(250) NOT NULL,
  `service_name4` varchar(250) NOT NULL,
  `service_name5` varchar(250) NOT NULL,
  `service_name6` varchar(250) NOT NULL,
  `service_name7` varchar(250) NOT NULL,
  `service_name8` varchar(250) NOT NULL,
  `service_name9` varchar(250) NOT NULL,
  `service_name10` varchar(250) NOT NULL,
  `price` decimal(10,4) NOT NULL,
  `doc_id` int(11) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE IF NOT EXISTS `support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
