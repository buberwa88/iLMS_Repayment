<?php

/**
 * @var $content string
 */

use yii\helpers\Html;
use common\widgets\Alert;
use yii\helpers\Url;
yiister\adminlte\assets\Asset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of lal links and provides the needed markup only.
-->
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
    <style>


 
/*!
 * Bootstrap Responsive v2.3.1
 *
 * Copyright 2012 Twitter, Inc
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Designed and built with all the love in the world @twitter by @mdo and @fat.
 */.clearfix{*zoom:1}.clearfix:before,.clearfix:after{display:table;line-height:0;content:""}.clearfix:after{clear:both}.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.input-block-level{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}@-ms-viewport{width:device-width}.hidden{display:none;visibility:hidden}.visible-phone{display:none!important}.visible-tablet{display:none!important}.hidden-desktop{display:none!important}.visible-desktop{display:inherit!important}@media(min-width:768px) and (max-width:979px){.hidden-desktop{display:inherit!important}.visible-desktop{display:none!important}.visible-tablet{display:inherit!important}.hidden-tablet{display:none!important}}@media(max-width:767px){.hidden-desktop{display:inherit!important}.visible-desktop{display:none!important}.visible-phone{display:inherit!important}.hidden-phone{display:none!important}}.visible-print{display:none!important}@media print{.visible-print{display:inherit!important}.hidden-print{display:none!important}}@media(min-width:1200px){.row{margin-left:-30px;*zoom:1}.row:before,.row:after{display:table;line-height:0;content:""}.row:after{clear:both}[class*="span"]{float:left;min-height:1px;margin-left:30px}.container,.navbar-static-top .container,.navbar-fixed-top .container,.navbar-fixed-bottom .container{width:1170px}.span12{width:1170px}.span11{width:1070px}.span10{width:970px}.span9{width:870px}.span8{width:770px}.span7{width:670px}.span6{width:570px}.span5{width:470px}.span4{width:370px}.span3{width:270px}.span2{width:170px}.span1{width:70px}.offset12{margin-left:1230px}.offset11{margin-left:1130px}.offset10{margin-left:1030px}.offset9{margin-left:930px}.offset8{margin-left:830px}.offset7{margin-left:730px}.offset6{margin-left:630px}.offset5{margin-left:530px}.offset4{margin-left:430px}.offset3{margin-left:330px}.offset2{margin-left:230px}.offset1{margin-left:130px}.row-fluid{width:100%;*zoom:1}.row-fluid:before,.row-fluid:after{display:table;line-height:0;content:""}.row-fluid:after{clear:both}.row-fluid [class*="span"]{display:block;float:left;width:100%;min-height:18px;margin-left:2.564102564102564%;*margin-left:2.5109110747408616%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.row-fluid [class*="span"]:first-child{margin-left:0}.row-fluid .controls-row [class*="span"]+[class*="span"]{margin-left:2.564102564102564%}.row-fluid .span12{width:100%;*width:99.94680851063829%}.row-fluid .span11{width:91.45299145299145%;*width:91.39979996362975%}.row-fluid .span10{width:82.90598290598291%;*width:82.8527914166212%}.row-fluid .span9{width:74.35897435897436%;*width:74.30578286961266%}.row-fluid .span8{width:65.81196581196582%;*width:65.75877432260411%}.row-fluid .span7{width:57.26495726495726%;*width:57.21176577559556%}.row-fluid .span6{width:48.717948717948715%;*width:48.664757228587014%}.row-fluid .span5{width:40.17094017094017%;*width:40.11774868157847%}.row-fluid .span4{width:31.623931623931625%;*width:31.570740134569924%}.row-fluid .span3{width:15.076923076923077%;*width:23.023731587561375%}.row-fluid .span2{width:14.52991452991453%;*width:14.476723040552828%}.row-fluid .span1{width:5.982905982905983%;*width:5.929714493544281%}.row-fluid .offset12{margin-left:105.12820512820512%;*margin-left:105.02182214948171%}.row-fluid .offset12:first-child{margin-left:102.56410256410257%;*margin-left:102.45771958537915%}.row-fluid .offset11{margin-left:96.58119658119658%;*margin-left:96.47481360247316%}.row-fluid .offset11:first-child{margin-left:94.01709401709402%;*margin-left:93.91071103837061%}.row-fluid .offset10{margin-left:88.03418803418803%;*margin-left:87.92780505546462%}.row-fluid .offset10:first-child{margin-left:85.47008547008548%;*margin-left:85.36370249136206%}.row-fluid .offset9{margin-left:79.48717948717949%;*margin-left:79.38079650845607%}.row-fluid .offset9:first-child{margin-left:76.92307692307693%;*margin-left:76.81669394435352%}.row-fluid .offset8{margin-left:70.94017094017094%;*margin-left:70.83378796144753%}.row-fluid .offset8:first-child{margin-left:68.37606837606839%;*margin-left:68.26968539734497%}.row-fluid .offset7{margin-left:62.393162393162385%;*margin-left:62.28677941443899%}.row-fluid .offset7:first-child{margin-left:59.82905982905982%;*margin-left:59.72267685033642%}.row-fluid .offset6{margin-left:53.84615384615384%;*margin-left:53.739770867430444%}.row-fluid .offset6:first-child{margin-left:51.28205128205128%;*margin-left:51.175668303327875%}.row-fluid .offset5{margin-left:45.299145299145295%;*margin-left:45.1927623204219%}.row-fluid .offset5:first-child{margin-left:42.73504273504273%;*margin-left:42.62865975631933%}.row-fluid .offset4{margin-left:36.75213675213675%;*margin-left:36.645753773413354%}.row-fluid .offset4:first-child{margin-left:34.18803418803419%;*margin-left:34.081651209310785%}.row-fluid .offset3{margin-left:28.205128205128204%;*margin-left:28.0987452264048%}.row-fluid .offset3:first-child{margin-left:25.641025641025642%;*margin-left:25.53464266230224%}.row-fluid .offset2{margin-left:19.65811965811966%;*margin-left:19.551736679396257%}.row-fluid .offset2:first-child{margin-left:17.094017094017094%;*margin-left:16.98763411529369%}.row-fluid .offset1{margin-left:11.11111111111111%;*margin-left:11.004728132387708%}.row-fluid .offset1:first-child{margin-left:8.547008547008547%;*margin-left:8.440625568285142%}input,textarea,.uneditable-input{margin-left:0}.controls-row [class*="span"]+[class*="span"]{margin-left:30px}input.span12,textarea.span12,.uneditable-input.span12{width:1156px}input.span11,textarea.span11,.uneditable-input.span11{width:1056px}input.span10,textarea.span10,.uneditable-input.span10{width:956px}input.span9,textarea.span9,.uneditable-input.span9{width:856px}input.span8,textarea.span8,.uneditable-input.span8{width:756px}input.span7,textarea.span7,.uneditable-input.span7{width:656px}input.span6,textarea.span6,.uneditable-input.span6{width:556px}input.span5,textarea.span5,.uneditable-input.span5{width:456px}input.span4,textarea.span4,.uneditable-input.span4{width:356px}input.span3,textarea.span3,.uneditable-input.span3{width:256px}input.span2,textarea.span2,.uneditable-input.span2{width:156px}input.span1,textarea.span1,.uneditable-input.span1{width:56px}.thumbnails{margin-left:-30px}.thumbnails>li{margin-left:30px}.row-fluid .thumbnails{margin-left:0}}@media(min-width:768px) and (max-width:979px){.row{margin-left:-20px;*zoom:1}.row:before,.row:after{display:table;line-height:0;content:""}.row:after{clear:both}[class*="span"]{float:left;min-height:1px;margin-left:20px}.container,.navbar-static-top .container,.navbar-fixed-top .container,.navbar-fixed-bottom .container{width:724px}.span12{width:724px}.span11{width:662px}.span10{width:600px}.span9{width:538px}.span8{width:476px}.span7{width:414px}.span6{width:352px}.span5{width:290px}.span4{width:228px}.span3{width:166px}.span2{width:104px}.span1{width:42px}.offset12{margin-left:764px}.offset11{margin-left:702px}.offset10{margin-left:640px}.offset9{margin-left:578px}.offset8{margin-left:516px}.offset7{margin-left:454px}.offset6{margin-left:392px}.offset5{margin-left:330px}.offset4{margin-left:268px}.offset3{margin-left:206px}.offset2{margin-left:144px}.offset1{margin-left:82px}.row-fluid{width:100%;*zoom:1}.row-fluid:before,.row-fluid:after{display:table;line-height:0;content:""}.row-fluid:after{clear:both}.row-fluid [class*="span"]{display:block;float:left;width:100%;min-height:30px;margin-left:2.7624309392265194%;*margin-left:2.709239449864817%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.row-fluid [class*="span"]:first-child{margin-left:0}.row-fluid .controls-row [class*="span"]+[class*="span"]{margin-left:2.7624309392265194%}.row-fluid .span12{width:100%;*width:99.94680851063829%}.row-fluid .span11{width:91.43646408839778%;*width:91.38327259903608%}.row-fluid .span10{width:82.87292817679558%;*width:82.81973668743387%}.row-fluid .span9{width:74.30939226519337%;*width:74.25620077583166%}.row-fluid .span8{width:65.74585635359117%;*width:65.69266486422946%}.row-fluid .span7{width:57.18232044198895%;*width:57.12912895262725%}.row-fluid .span6{width:48.61878453038674%;*width:48.56559304102504%}.row-fluid .span5{width:40.05524861878453%;*width:40.00205712942283%}.row-fluid .span4{width:31.491712707182323%;*width:31.43852121782062%}.row-fluid .span3{width:22.92817679558011%;*width:22.87498530621841%}.row-fluid .span2{width:14.3646408839779%;*width:14.311449394616199%}.row-fluid .span1{width:5.801104972375691%;*width:5.747913483013988%}.row-fluid .offset12{margin-left:105.52486187845304%;*margin-left:105.41847889972962%}.row-fluid .offset12:first-child{margin-left:102.76243093922652%;*margin-left:102.6560479605031%}.row-fluid .offset11{margin-left:96.96132596685082%;*margin-left:96.8549429881274%}.row-fluid .offset11:first-child{margin-left:94.1988950276243%;*margin-left:94.09251204890089%}.row-fluid .offset10{margin-left:88.39779005524862%;*margin-left:88.2914070765252%}.row-fluid .offset10:first-child{margin-left:85.6353591160221%;*margin-left:85.52897613729868%}.row-fluid .offset9{margin-left:79.8342541436464%;*margin-left:79.72787116492299%}.row-fluid .offset9:first-child{margin-left:77.07182320441989%;*margin-left:76.96544022569647%}.row-fluid .offset8{margin-left:71.2707182320442%;*margin-left:71.16433525332079%}.row-fluid .offset8:first-child{margin-left:68.50828729281768%;*margin-left:68.40190431409427%}.row-fluid .offset7{margin-left:62.70718232044199%;*margin-left:62.600799341718584%}.row-fluid .offset7:first-child{margin-left:59.94475138121547%;*margin-left:59.838368402492065%}.row-fluid .offset6{margin-left:54.14364640883978%;*margin-left:54.037263430116376%}.row-fluid .offset6:first-child{margin-left:51.38121546961326%;*margin-left:51.27483249088986%}.row-fluid .offset5{margin-left:45.58011049723757%;*margin-left:45.47372751851417%}.row-fluid .offset5:first-child{margin-left:42.81767955801105%;*margin-left:42.71129657928765%}.row-fluid .offset4{margin-left:37.01657458563536%;*margin-left:36.91019160691196%}.row-fluid .offset4:first-child{margin-left:34.25414364640884%;*margin-left:34.14776066768544%}.row-fluid .offset3{margin-left:28.45303867403315%;*margin-left:28.346655695309746%}.row-fluid .offset3:first-child{margin-left:25.69060773480663%;*margin-left:25.584224756083227%}.row-fluid .offset2{margin-left:19.88950276243094%;*margin-left:19.783119783707537%}.row-fluid .offset2:first-child{margin-left:17.12707182320442%;*margin-left:17.02068884448102%}.row-fluid .offset1{margin-left:11.32596685082873%;*margin-left:11.219583872105325%}.row-fluid .offset1:first-child{margin-left:8.56353591160221%;*margin-left:8.457152932878806%}input,textarea,.uneditable-input{margin-left:0}.controls-row [class*="span"]+[class*="span"]{margin-left:20px}input.span12,textarea.span12,.uneditable-input.span12{width:710px}input.span11,textarea.span11,.uneditable-input.span11{width:648px}input.span10,textarea.span10,.uneditable-input.span10{width:586px}input.span9,textarea.span9,.uneditable-input.span9{width:524px}input.span8,textarea.span8,.uneditable-input.span8{width:462px}input.span7,textarea.span7,.uneditable-input.span7{width:400px}input.span6,textarea.span6,.uneditable-input.span6{width:338px}input.span5,textarea.span5,.uneditable-input.span5{width:276px}input.span4,textarea.span4,.uneditable-input.span4{width:214px}input.span3,textarea.span3,.uneditable-input.span3{width:152px}input.span2,textarea.span2,.uneditable-input.span2{width:90px}input.span1,textarea.span1,.uneditable-input.span1{width:28px}}@media(max-width:767px){body{padding-right:20px;padding-left:20px}.navbar-fixed-top,.navbar-fixed-bottom,.navbar-static-top{margin-right:-20px;margin-left:-20px}.container-fluid{padding:0}.dl-horizontal dt{float:none;width:auto;clear:none;text-align:left}.dl-horizontal dd{margin-left:0}.container{width:auto}.row-fluid{width:100%}.row,.thumbnails{margin-left:0}.thumbnails>li{float:none;margin-left:0}[class*="span"],.uneditable-input[class*="span"],.row-fluid [class*="span"]{display:block;float:none;width:100%;margin-left:0;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.span12,.row-fluid .span12{width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.row-fluid [class*="offset"]:first-child{margin-left:0}.input-large,.input-xlarge,.input-xxlarge,input[class*="span"],select[class*="span"],textarea[class*="span"],.uneditable-input{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.input-prepend input,.input-append input,.input-prepend input[class*="span"],.input-append input[class*="span"]{display:inline-block;width:auto}.controls-row [class*="span"]+[class*="span"]{margin-left:0}.modal{position:fixed;top:20px;right:20px;left:20px;width:auto;margin:0}.modal.fade{top:-100px}.modal.fade.in{top:20px}}@media(max-width:480px){.nav-collapse{-webkit-transform:translate3d(0,0,0)}.page-header h1 small{display:block;line-height:20px}input[type="checkbox"],input[type="radio"]{border:1px solid #ccc}.form-horizontal .control-label{float:none;width:auto;padding-top:0;text-align:left}.form-horizontal .controls{margin-left:0}.form-horizontal .control-list{padding-top:0}.form-horizontal .form-actions{padding-right:10px;padding-left:10px}.media .pull-left,.media .pull-right{display:block;float:none;margin-bottom:10px}.media-object{margin-right:0;margin-left:0}.modal{top:10px;right:10px;left:10px}.modal-header .close{padding:10px;margin:-10px}.carousel-caption{position:static}}@media(max-width:979px){body{padding-top:0}.navbar-fixed-top,.navbar-fixed-bottom{position:static}.navbar-fixed-top{margin-bottom:20px}.navbar-fixed-bottom{margin-top:20px}.navbar-fixed-top .navbar-inner,.navbar-fixed-bottom .navbar-inner{padding:5px}.navbar .container{width:auto;padding:0}.navbar .brand{padding-right:10px;padding-left:10px;margin:0 0 0 -5px}.nav-collapse{clear:both}.nav-collapse .nav{float:none;margin:0 0 10px}.nav-collapse .nav>li{float:none}.nav-collapse .nav>li>a{margin-bottom:2px}.nav-collapse .nav>.divider-vertical{display:none}.nav-collapse .nav .nav-header{color:#777;text-shadow:none}.nav-collapse .nav>li>a,.nav-collapse .dropdown-menu a{padding:9px 15px;font-weight:bold;color:#777;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}.nav-collapse .btn{padding:4px 10px 4px;font-weight:normal;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}.nav-collapse .dropdown-menu li+li a{margin-bottom:2px}.nav-collapse .nav>li>a:hover,.nav-collapse .nav>li>a:focus,.nav-collapse .dropdown-menu a:hover,.nav-collapse .dropdown-menu a:focus{background-color:#f2f2f2}.navbar-inverse .nav-collapse .nav>li>a,.navbar-inverse .nav-collapse .dropdown-menu a{color:#999}.navbar-inverse .nav-collapse .nav>li>a:hover,.navbar-inverse .nav-collapse .nav>li>a:focus,.navbar-inverse .nav-collapse .dropdown-menu a:hover,.navbar-inverse .nav-collapse .dropdown-menu a:focus{background-color:#111}.nav-collapse.in .btn-group{padding:0;margin-top:5px}.nav-collapse .dropdown-menu{position:static;top:auto;left:auto;display:none;float:none;max-width:none;padding:0;margin:0 15px;background-color:transparent;border:0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none}.nav-collapse .open>.dropdown-menu{display:block}.nav-collapse .dropdown-menu:before,.nav-collapse .dropdown-menu:after{display:none}.nav-collapse .dropdown-menu .divider{display:none}.nav-collapse .nav>li>.dropdown-menu:before,.nav-collapse .nav>li>.dropdown-menu:after{display:none}.nav-collapse .navbar-form,.nav-collapse .navbar-search{float:none;padding:10px 15px;margin:10px 0;border-top:1px solid #f2f2f2;border-bottom:1px solid #f2f2f2;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.1),0 1px 0 rgba(255,255,255,0.1);-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.1),0 1px 0 rgba(255,255,255,0.1);box-shadow:inset 0 1px 0 rgba(255,255,255,0.1),0 1px 0 rgba(255,255,255,0.1)}.navbar-inverse .nav-collapse .navbar-form,.navbar-inverse .nav-collapse .navbar-search{border-top-color:#111;border-bottom-color:#111}.navbar .nav-collapse .nav.pull-right{float:none;margin-left:0}.nav-collapse,.nav-collapse.collapse{height:0;overflow:hidden}.navbar .btn-navbar{display:block}.navbar-static .navbar-inner{padding-right:10px;padding-left:10px}}@media(min-width:980px){.nav-collapse.collapse{height:auto!important;overflow:visible!important}}

/*   
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap v2.3.1
Version: 1.1.2
Author: KeenThemes
Website: http://www.keenthemes.com/preview/?theme=metronic
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469
*/

/*********************
 GENERAL UI COLORS 
*********************/

/***
Colors
blue:  #4b8df8
light blue: #bfd5fa
red: #e02222
yellow: #ffb848
green: #35aa47
purple: #852b99
grey: #555555;
light grey: #fafafa;
***/

/*********************
 GENERAL RESET & SETUP 
*********************/

/***
Import fonts
***/

/***
Reset and overrides  
***/
/* general body settings */
 
/***
General typography 
***/
h3 small, h4 small, h5 small {
  color: #444;
}

 

h1.block, h2.block, h3.block, h4.block, h5.block, h6.block {
  padding-bottom: 10px;
}

a {
  text-shadow: none !important;
  color: #0d638f;
}

/***
General backgrounds
***/
.bg-blue {
  background-image: none !important;
  background-color: #4b8df8 !important;
}

.bg-red {
  background-image: none !important;
  background-color: #e02222 !important;
}

.bg-yellow {
  background-image: none !important;
  background-color: #ffb848 !important;
}

.bg-green {
  background-image: none !important;
  background-color: #35aa47 !important;
}

.bg-purple {
  background-image: none !important;
  background-color: #852b99 !important;
}

.bg-grey {
  background-image: none !important;
  background-color: #555555 !important;
}

/***
Apply fix for font awesome icons.
***/
[class^="icon-"], 
[class*=" icon-"],
[class^="icon-"]:hover, 
[class*=" icon-"]:hover { 
  background: none !important;
}

/***
Close icon used for modal dialog and other UI element close buttons
***/
.close {
  display: inline-block;
  margin-top: 0px;
  margin-right: 0px;
  width: 9px;
  height: 9px;
  background-repeat: no-repeat !important;
  background-image: url("../img/remove-icon-small.png") !important;
}

/***
ie8 & ie9 modes
***/
.visible-ie8 {
  display: none;
}

.ie8 .visible-ie8 {
  display: inherit !important;
}

.visible-ie9 {
  display: none;
}

.ie9 .visible-ie9 {
  display: inherit !important;
}

.hidden-ie8 {
  display: inherit;
}

.ie8 .hidden-ie8 {
  display: none !important;
}

.hidden-ie9 {
  display: inherit;
}

.ie9 .hidden-ie9 {
  display: none !important;
}

/***
Fix link outlines after click
***/
a,a:focus, a:hover, a:active {
  outline: 0;
}

/***
IE8 fix for form input height in fluid rows
***/
.ie8 .row-fluid [class*="span"] {
    min-height: 20px !important;
}

/***
Fix grid offset used for reponsive layout handling(refer app.js=>handleResponsive)
***/
.fix-offset {
  margin-left: 0px !important;
}

/***
Misc tools
***/
.visible-ie8 {
  display: none
}

.no-padding {
  padding: 0px !important;
}

.no-margin {
  margin: 0px !important;
}

.no-bottom-space {
  padding-bottom:0px !important;
  margin-bottom: 0px !important;
}

.no-top-space {
  padding-top:0px !important;
  margin-top: 0px !important;
}

.space5 {
  display: block;
  height: 5px !important;
  clear: both;
}

.space7 {
  height: 7px !important;
  clear: both;
}

.space10 {
  height: 10px !important;
  clear: both;
}

.space12 {
  height: 12px !important;
  clear: both;
}

.space15 {
  height: 15px !important;
  clear: both;
}

.space20 {
  height: 20px !important;
  clear: both;
}

.no-space {
  margin: 0px !important;
  padding: 0px !important;
}

.no-text-shadow {
  text-shadow: none !important;
}

.no-left-padding {
  padding-left: 0 !important;
}

.no-left-margin {
  margin-left: 0 !important;
}

.margin-bottom-10 {
  margin-bottom: 10px !important;
}

.hide {
  display: none;
}

.bold {
  font-weight:600 !important;
}

.fix-margin {
  margin-left: 0px !important
}

.border {
  border: 1px solid #ddd
}

hr {
  margin: 20px 0;
  border: 0;
  border-top: 1px solid #E0DFDF;
  border-bottom: 1px solid #FEFEFE;
}

/********************
 GENERAL LAYOUT 
*********************/

/***
Header and header elements.
***/
.header {
  padding: 0 !important;
  margin: 0 !important;
}

.header .brand {
  margin-top: -1px;
}

.header .btn-navbar {
  margin-bottom: 0px;
  padding-right: 0px;
  padding-top:10px;
  padding-bottom: 6px; 
  background-image: none;
  filter:none;
  box-shadow: none;
  color: #fff;
  border: 0;
}

.header .btn-navbar:hover {
  text-decoration: none;
}

.header .navbar-inner {
  width: 100%;
  margin-left: 0 0 0 110px;
  border: 0px;
  padding: 0px; 
  box-shadow: none;
  height: 42px; 
}

.header .nav {
  display: block; 
}

.header .nav > li {
  margin: 0px;
  padding: 0px;
}

.header .nav > li.dropdown, 
.header .nav > li.dropdown > a {
  padding-left: 4px; 
  padding-right: 4px;
}

.header .nav > li.dropdown:last-child {
   padding-right: 2px;
}

.header .nav > li.dropdown .dropdown-toggle {
  margin: 0px;
  padding: 14px 12px 8px 12px;
}

.header .nav > li.dropdown .dropdown-toggle i {
  font-size: 18px;
}

.header .nav > li.dropdown.user .dropdown-toggle {
  padding: 6px 4px 7px 9px;
}

.header .nav > li.dropdown.user .dropdown-toggle:hover {
  text-decoration: none;
}

.header .nav > li.dropdown.user .dropdown-toggle .username {
  color: #ddd;
}

.header .nav li.dropdown.user .dropdown-toggle i {
  display: inline-block;
  margin-top: 5px;
  margin: 0;
  font-size: 16px;
}

.header .nav > li.dropdown .dropdown-toggle .badge {
  position: absolute;
  font-size: 11px !important;
  font-weight: 300;
  top: 8px;
  right: 24px;
  text-align: center;
  height: 14px;
  background-color: #e02222;
  padding: 2px 6px 2px 6px;
  -webkit-border-radius: 12px !important;
     -moz-border-radius: 12px !important;
          border-radius: 12px !important;
  text-shadow:none !important;
}

/* firefox hack for top bar badges */
@-moz-document url-prefix() { 
  .header .nav li.dropdown .dropdown-toggle .badge {
    padding: 1px 6px 3px 6px;
  }
}

.header .nav .dropdown-menu {
  margin-top: 3px;
}

/***
Page container
***/
.page-container {
  margin: 0px;
  padding: 0px;
}

.fixed-top .page-container {
  margin-top: 42px;  
}

/***
Page sidebar
***/
.page-sidebar > ul {
  list-style: none;
  margin: 0;
  padding: 0;
  margin: 0;
  padding: 0; 
}

.page-sidebar > ul > li {
  display: block;
  margin: 0;
  padding: 0; 
  border: 0px;
}

.page-sidebar > ul > li.start > a {
   border-top-color: transparent !important;
}

.page-sidebar > ul > li:last-child > a {
   border-bottom: 1px solid transparent !important;
}

.page-sidebar > ul > li > a {
  display: block;
  position: relative;
  margin: 0;
  border: 0px;
  padding: 10px 15px;
  text-decoration: none;
  font-size: 14px;
  font-weight: 300;
}

.page-sidebar > ul > li > a i {
  font-size: 16px;
  margin-right: 5px;
  text-shadow:none; 
}

.page-sidebar > ul > li.active > a {
  border: none; 
  text-shadow:none;
}  

.page-sidebar > ul > li.active > a .selected {
  display: block;
  width: 8px;
  height: 25px;
  background-image: url("../img/sidebar-menu-arrow.png");
  float: right;
  position: absolute;
  right:0px;
  top:8px;
}

.page-sidebar ul > li > a .arrow:before {  
   float: right;
   margin-top: 1px;
   margin-right: 5px;
   display: inline;
   font-size: 16px;
   font-family: FontAwesome;
   height: auto;
   content: "\f104";
   font-weight: 300;
   text-shadow:none;
}

.page-sidebar > ul > li > a .arrow.open:before {   
   float: right;
   margin-top: 1px;
   margin-right: 5px;
   display: inline;
   font-family: FontAwesome;
   height: auto;
   font-size: 16px;
   content: "\f107";
   font-weight: 300;
   text-shadow:none;
}

.page-sidebar > ul > li > ul.sub {
  display: none;
  list-style: none;
  clear: both;
  margin: 8px 0px 8px 0px;
}

.page-sidebar > ul > li.active > ul.sub {
  display: block;
}

.page-sidebar > ul > li > ul.sub > li {
  background: none;
  margin: 0px;
  padding: 0px;
  margin-top: 1px !important;
}

.page-sidebar > ul > li > ul.sub > li > a {
  display: block;
  margin: 0px 0px 0px 0px;
  padding: 5px 0px;
  padding-left: 44px !important;
  color: #ccc;
  text-decoration: none;
  text-shadow: 0 1px 1px #000;
  font-size: 14px;
  font-weight: 300;
  background: none;
}

.page-sidebar > ul > li > ul.sub > li > a > i {
  font-size: 13px;
}

.page-sidebar .sidebar-search {
  margin: 8px 20px 20px 20px;
}

.page-sidebar .sidebar-search .submit {
  display: block;
  float: right;
  margin-top: 8px;
  width: 13px;
  height: 13px;
  background-image: url(../img/search-icon.png);
  background-repeat: no-repeat;
}
 
.page-sidebar .sidebar-search input {
  margin: 0px;
  width: 165px;
  border: 0px; 
  padding-left: 0px;
  padding-right: 0px;
  padding-bottom: 0px;
  font-size: 14px ;
  box-shadow: none;
}

.page-sidebar .sidebar-search .input-box {
   padding-bottom: 2px;
   border-bottom:1px solid #959595;
}

/***
Sidebar toggler(show/hide)
***/

.sidebar-toggler {
  cursor: pointer; 
  opacity: 0.5;
  filter: alpha(opacity=50);
  margin-top: 15px;
  margin-left: 175px;
  width: 29px;
  height: 29px;
  background-repeat: no-repeat;
}

.sidebar-toggler:hover { 
  filter: alpha(opacity=100);
  opacity: 1;
}

.sidebar-closed .sidebar-toggler {  
  margin-left: 3px;
}

.sidebar-closed .page-sidebar .sidebar-search {  
  height: 34px;    
  width: 29px;
  margin-left: 3px;  
  margin-bottom: 0px;
}

.sidebar-closed .page-sidebar .sidebar-search input {
  display: none;
}

.sidebar-closed .page-sidebar .sidebar-search .submit { 
  margin: 11px 7px !important;
  display: block !important;
}

.sidebar-closed .page-sidebar .sidebar-search .input-box {
  border-bottom: 0;
}

.sidebar-closed .page-sidebar .sidebar-search.open {  
  height: 34px;    
  width: 255px;
  overflow: hidden;
}

.sidebar-closed .page-sidebar .sidebar-search.open input {  
  margin-top: 3px;
  padding-left: 10px;
  padding-bottom: 2px;
  width: 180px;
  display: inline-block !important;
}

.sidebar-closed .page-sidebar .sidebar-search.open .submit {
  display: inline-block;
  width: 13px;
  height: 13px;
  margin: 10px 8px 9px 6px !important;
}

.sidebar-closed .page-sidebar .sidebar-search.open .remove {
  background-repeat: no-repeat;
  width: 11px;
  height: 11px;
  margin: 11px 6px 7px 8px !important;
  display: inline-block !important;
  float: left !important;
}

.sidebar-closed ul > li > a .selected {
  right: -3px !important;
}

.sidebar-closed ul > li > a .title,
.sidebar-closed ul > li > a .arrow {
  display: none !important;
}

.sidebar-closed .sidebar-toggler {
  margin-right: 3px;
}

.sidebar-closed .page-sidebar .sidebar-search {
  margin-top: 6px;
  margin-bottom: 6px;
}

.sidebar-closed > .page-sidebar > ul {
  width: 35px !important;
}

.sidebar-closed .page-sidebar > ul > li > a {
  padding-left: 7px;
}

.sidebar-closed .page-sidebar > ul > li:hover {
  width: 225px;   
  position: relative;
  z-index: 2000;
  display: block !important;
}

.sidebar-closed .page-sidebar > ul > li:hover .selected {
  display: none;
}

.sidebar-closed .page-sidebar > ul > li:hover > a > i {
  margin-right: 10px;
}

.sidebar-closed .page-sidebar > ul > li:hover .title {
  display: inline !important;
}

.sidebar-closed .page-sidebar > ul > li.has-sub .sub {
  display: none !important;
}

.sidebar-closed .page-sidebar > ul > li.has-sub:hover .sub {  
  width: 189px;
  position: absolute;
  z-index: 2000;
  left: 36px;
  margin-top: 0;
  display: block !important;
}

.sidebar-closed .page-sidebar > ul > li.has-sub:hover .sub > li > a {
  padding-left: 15px !important;
}

.sidebar-closed .page-sidebar {
  width: 35px;
}

.sidebar-closed .page-content {
  margin-left: 35px !important;
}

/* ie8 fixes */
.ie8 .page-sidebar {
  position: absolute;
  width: 225px;
}

.ie8 .page-sidebar ul{
  width: 225px;
}

/***
Page content
***/
.page-content {  
  margin-top: 0px;   
  padding: 0px;
  background-color: #fff; 
}

.ie8 .page-content { 
    margin-left: 225px; 
    margin-top: 0px;
}

/***
Page title
***/
.page-title {
  padding: 0px;
  font-size: 30px;
  letter-spacing: -1px;
  display: block;
  color: #666;
  margin: 20px 0px 15px 0px;
  font-weight: 300;
  font-family: 'Open Sans';
}

.page-title small {
  font-size: 14px;
  letter-spacing: 0px;
  font-weight: 300;
  color: #888;
}

 
/********************
 GENERAL UI ELEMENTS 
*********************/

/***
Icon stuff
***/
i.icon, a.icon {
  color: #999;
  margin-right: 5px;
  font-weight: normal;
  font-size: 13px;
}

i.icon-black {
  color: #000 !important;
}

a.icon:hover {
  text-decoration: none;
  -webkit-transition: all 0.1s ease-in-out;
  -moz-transition: all 0.1s ease-in-out;
  -o-transition: all 0.1s ease-in-out;
  -ms-transition: all 0.1s ease-in-out;
  transition: all 0.1s ease-in-out;
  opacity: .4;
  filter:alpha(opacity=40);
}

a.icon.huge i{
  font-size: 16px !important;
}

i.big {
  font-size: 20px;
}

i.warning {
  color: #d12610;
}

i.critical {
  color: #37b7f3;
}

i.normal {
  color: #52e136;
}

/***
Custom wells
***/
.well {
  background-color: #fafafa;
  border: 1px solid #eee;
  -webkit-border-radius: 0px;
     -moz-border-radius: 0px;
          border-radius: 0px;   
  -webkit-box-shadow: none !important;
     -moz-box-shadow: none !important;
          box-shadow: none !important;        
}

.well.mini {
  padding: 7px !important;
}
/***
Bordered form layout
***/

/***
Input icons
***/
/* input with right aligned and colored icons */
.input-icon input {
  padding-right: 25px !important;
}

.input-icon .input-info,
.input-icon .input-error, 
.input-icon .input-warning, 
.input-icon .input-success {
  display: inline-block !important;
  position: relative !important;
  top: 7px;
  right: 25px !important;
  font-size: 16px;
}

.input-icon .input-info {
  color:#27a9e3;
}
.input-icon .input-error {
  color:#B94A48;
}
.input-icon .input-warning {
  color: #C09853;
}
.input-icon .input-success {
  color: #468847;
}

/* input with left aligned icons */
.input-icon.left i {
  color: #ccc;
  display: block !important;
  position: absolute !important;
  z-index: 1;
  margin: 9px 2px 4px 10px; 
  width: 16px;
  height: 16px;
  border1: 1px solid #ddd;
  font-size: 16px;
  text-align: center;
}

.input-icon.left input {
  padding-left: 33px !important;
}
 
/***
System feeds
***/
.feeds {
  margin: 0px;
  padding: 0px;
  list-style: none;
}

.feeds li {
  background-color: #fafafa;
  margin-bottom: 7px;   
}

.feeds li:before, 
.feeds li:after {
  display: table;
  line-height: 0;
  content: "";
}

.feeds li:after {
  clear: both;
}

.feeds .col1 {
  float:left;
  width:100%;  
  clear: both;
}

.feeds .col2 {
  float:left;
  width:75px;
  margin-left:-75px;
}

.feeds .col1 .cont {
  float:left;
  margin-right:75px;
  overflow:hidden;
}

.feeds .col1 .cont  .cont-col1 {
  float:left;
  margin-right:-100%;
}

.feeds .col1 .cont  .cont-col1 .label {
  float: left;
  width: 14px;
  padding: 7px;
}

.feeds .col1 .cont .cont-col2 {
  float:left;
  width:100%;
}

.feeds .col1 .cont .cont-col2 .desc { 
  margin-left:35px;
  padding-top: 4px;
  padding-bottom: 4px;
  overflow:hidden;
}

.feeds .col2 .date {
  padding: 4px 9px 4px 4px;
  text-align: right;
  font-style: italic;
  color:#c1cbd0;
}

/***
Users
***/
.user-info {
  margin-bottom: 10px !important;
}

.user-info img {
  float: left;
  margin-right: 5px;
}

.user-info .details {
  display: inline-block;
}

.user-info .label {
  font-weight: 300;
  font-size: 11px;
}

/***
Accordions
***/
.accordion-heading {
  background:#eee;
}

.accordion-heading a {
  text-decoration:none;
}

.accordion-heading a:hover {
  text-decoration:none;
}

/***
Vertical inline menu
***/
.ver-inline-menu {
  margin: 0px;
  list-style: none;
}

.ver-inline-menu li {
  position:relative;
  margin-bottom:1px;
}

.ver-inline-menu li i {
  color:#b9cbd5;
  font-size:15px;
  padding:11px 9px;
  margin:0 8px 0 0;
  background:#e0eaf0 !important;
}

.ver-inline-menu li a {
  color:#557386;
  display:block;
  background:#f0f6fa;
  border-left:solid 2px #c4d5df;
}

.ver-inline-menu li:hover a,
.ver-inline-menu li:hover i {
  background:#e0eaf0;
  text-decoration:none;
}

.ver-inline-menu li:hover i {
  color:#fff;
  background:#c4d5df !important;
}

.ver-inline-menu li.active a,
.ver-inline-menu li.active i {
  color:#fff;
  background:#169ef4;
  text-decoration:none;
  border-left:solid 1px #0c91e5;
}

.ver-inline-menu li.active i {
  background:#0c91e5 !important;  
}

.ver-inline-menu li.active:after {
  content: '';
  display: inline-block;
  border-bottom: 6px solid transparent;
  border-top: 6px solid transparent;
  border-left: 6px solid #169ef4;
  position: absolute;
  top: 12px;
  right: -5px;
}
 
/***
Circle Stats(KNOB, new in v1.1.1)
***/

/* Circle stats */
.knobify {
  border: 0 !important;
  width: 0px;
}

.ie8 .knobify {
  display: none;
}

.circle-stat {
  background-color: #f8f8f8;
  padding:2px;
  margin-bottom: 10px;
}

.circle-stat:hover {
  background-color: #edf4f7;
}

.circle-stat:before,
.circle-stat:after {
  display: table;
  line-height: 0;
  content: "";
}
.circle-stat:after {
  clear: both;
}

.circle-stat .visual {
  display: block;
  float: left;
}

.circle-stat .details {
  display: block;
  float: left;  
  margin-left: 5px;
  padding-top: 7px;
}

.circle-stat .details .title {
  margin: 10px 0px 5px 0px !important;
  padding: 0px !important; 
  font-size: 13px;  
  text-transform: uppercase;
  font-weight: 300;
  color: #222;
}   

.ie8 .circle-stat .details .title {
  margin-top:5px !important;
}
.ie8 .circle-stat .details {
  padding-top: 0px !important;
  margin-bottom: 5px !important;
}

.circle-stat .details .title i {
  margin-top:2px !important;
  color: #52e136;
  font-size: 16px;
}

.circle-stat .details .title i.down {
  color: #b63625;
}

.circle-stat .details .number {
  margin: 0px !important;
  margin-bottom: 7px !important;
  font-size: 24px;
  padding: 0px; 
  font-weight: 300;
  color: #999;
}

/***
Tiles(new in v1.1.1)
***/
.tiles {
  margin-right: -10px;
}

.tile {
  display: block;
  letter-spacing: 0.02em;
  float: left;
  height: 130px;
  width: 130px !important;
  cursor: pointer;
  text-decoration: none;
  color: #ffffff;
  position: relative;
  font-weight: 300;
  font-size: 12px;
  letter-spacing: 0.02em;
  line-height: 20px;
  font-smooth: always;
  overflow: hidden;
  border: 4px solid transparent;
  margin: 0 10px 10px 0;
}

.tile:after,
.tile:before {
  content: "";
  float: left; 
}

.tile.double {
  width: 278px !important;
}

.tile.double-down {
  height: 278px !important;
}

.tile:active, .tile.selected {
  border-color: #ccc;
}

.tile:hover {
  border-color: #aaa;
}

.tile.selected .corner:after {  
  content: "";
  display: inline-block;
  border-left: 40px solid transparent;
  border-bottom: 40px solid transparent;
  border-right: 40px solid #ccc;
  position: absolute;
  top: -3px;
  right: -3px;
}

.tile.selected .check:after {  
  content: "";
  font-family: FontAwesome;
  font-size: 13px;
  content: "\f00c";
  display: inline-block;
  position: absolute;
  top: 2px;
  right: 2px;
}

.tile * {
  color: #ffffff;
}

.tile .tile-body {
  height: 100%;
  vertical-align: top;
  padding: 10px 10px;
  overflow: hidden;
  text-overflow: ellipsis;
  position: relative;
  font-weight: 400;
  font-size: 12px;
  font-smooth: always;
  color: #000000;
  color: #ffffff;
  margin-bottom: 10px;
}

.tile .tile-body img {
  float: left;
  margin-right: 10px;
}

.tile .tile-body img.pull-right {
  float: right !important;
  margin-left: 10px;
  margin-right: 0px;
}

.tile .tile-body .content {
  display: inline-block;
}

.tile .tile-body > i {
  margin-top: 17px;
  display: block;
  font-size: 56px;
  text-align: center;
}

.tile.double-down i {
  margin-top: 95px;
}

.tile .tile-body h1,
.tile .tile-body h2,
.tile .tile-body h3,
.tile .tile-body h4,
.tile .tile-body h5,
.tile .tile-body h6,
.tile .tile-body p {
  padding: 0;
  margin: 0;
  line-height: 14px;
}

.tile .tile-body h3,
.tile .tile-body h4 {
  margin-bottom: 5px;
}

.tile .tile-body h1:hover,
.tile .tile-body h2:hover,
.tile .tile-body h3:hover,
.tile .tile-body h4:hover,
.tile .tile-body h5:hover,
.tile .tile-body h6:hover,
.tile .tile-body p:hover {
  color: #ffffff;
}

.tile .tile-body p {
  font-weight: 400;
  font-size: 13px;
  font-smooth: always;
  color: #000000;
  color: #ffffff;
  line-height: 20px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.tile .tile-body p:hover {
  color: rgba(0, 0, 0, 0.8);
}

.tile .tile-body p:active {
  color: rgba(0, 0, 0, 0.4);
}

.tile .tile-body p:hover {
  color: #ffffff;
}

.tile.icon > .tile-body {
  padding: 0;
}

.tile .tile-object {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  min-height: 30px;
  background-color: transparent;
  *zoom: 1;
}

.tile .tile-object:before,
.tile .tile-object:after {
  display: table;
  content: "";
}

.tile .tile-object:after {
  clear: both;
}

.tile .tile-object > .name {
  position: absolute;
  bottom: 0;
  left: 0;
  margin-bottom: 5px;
  margin-left: 10px;
  margin-right: 15px;
  font-weight: 400;
  font-size: 13px;
  font-smooth: always;
  color: #ffffff;
}

.tile .tile-object > .name i {
  display: block;
  font-size: 24px;
}

.tile .tile-object > .number {
  position: absolute;
  bottom: 0;
  right: 0;
  margin-bottom: 0;
  color: #ffffff;
  text-align: center;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.01em;
  line-height: 14px;
  font-smooth: always;
  margin-bottom: 8px;
  margin-right: 10px;
}

.tile.image {  
  border-color1: transparent !important;
}

.tile.image > .tile-body {
  padding: 0 !important;
}

.tile.image > .tile-body > img{
  width: 100%;
  height: auto;
  min-height: 100%;
  max-width: 100%;
}

.tile.image .tile-body h3 {
  display: inline-block;
}

/***
Styler Panel
***/
.color-panel {
  z-index: 999;
  position:relative;
}

.color-panel .color-mode-icons {
  top:4px;
  right:0;
  padding:20px;
  cursor:pointer;
  position:absolute;
}

.color-panel .icon-color {
  background:#c9c9c9 url(../img/icon-color.png) center no-repeat !important;
}

.color-panel .icon-color:hover {
  background-color:#3d3d3d !important;
}

.color-panel .icon-color-close {
  display:none;
  background:#3d3d3d url(../img/icon-color-close.png) center no-repeat !important;
}

.color-panel .icon-color-close:hover {
  background-color:#222 !important;
}

.color-mode {
  top:5px;
  right:40px;
  display:none;
  padding:10px 0;
  position:absolute;
  background:#3d3d3d;
}

.color-mode p,
.color-mode ul,
.color-mode label {
  padding:0 15px;
}

.color-mode p {
  color:#cfcfcf;
  padding:0 15px;
  font-size:15px;
}

.color-mode ul {
  list-style:none;
  padding:4px 11px 5px;
}

.color-mode li {
  width:20px;
  height:30px;
  margin:0 4px;
  cursor:pointer;
  list-style:none;
  border:solid 1px #707070;
}

.color-mode li:hover,
.color-mode li.current {
  border:solid 2px #ebebeb;
  margin:0 3px;
}

.color-mode li.color-black {
  background:#333438;
}

.color-mode li.color-blue {
  background:#124f94;
}

.color-mode li.color-brown {
  background:#623f18;
}

.color-mode li.color-purple {
  background:#701584;
}

.color-mode li.color-white {
  background:#fff;
}

.color-mode label {
  color:#cfcfcf;
  padding-top:12px;
  text-transform:uppercase;
  border-top:1px solid #585858;
}

.color-mode label  span.color-mode-label {
  top:2px;
  position:relative;
}

/********************
 PAGES 
*********************/
  
 
 
 
 
 
 

 
 

 
 

 
 
 
.detail-view th {
    font-size:12px;
    width: 220px;
}
 
    .detail-view th {
    width: 150px;
   
}
.skin-blue .main-header .navbar {
    background-color: #7A94A6 !important;
}
.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
    //background-color:#425B6E !important;
     background: #f4f4f4;
    -webkit-box-shadow: inset -3px 0px 8px -4px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: inset -3px 0px 8px -4px rgba(0, 0, 0, 0.1);
    box-shadow: inset -3px 0px 8px -4px rgba(0, 0, 0, 0.07);
    //color:#123!important;
   // background: url(image/icons/left_nav_bg.png) repeat-y right 0% #f3f3f3;
}
.skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
    color: #fff;
    background: #6b7c83 !important;
    //border-left-color: #0696ea !important;
}
.text-success {
    color: #4aec0f!important;
}
.modal-lg {
    width: 600px;
}
.skin-blue .sidebar a {
    color: #112;
    font-size:16px;
}
.skin-blue .user-panel > .info, .skin-blue .user-panel > .info > a {
    color: #000;
}
.sidebar-menu > li {
    border-top: 1px solid #fff;
    border-bottom: 1px solid #dbdbdb;
    ///border: 1px solid #999;
}
    </style>
</head>
<!--
BODY TAG OPTIONS: #365C77 
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>ILMIS</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="http://placehold.it/160x160" class="img-circle" alt="User Image">
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li><!-- end message -->
                                </ul><!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li><!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li><!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="http://placehold.it/160x160" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?= Yii::$app->user->identity->username?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="http://placehold.it/160x160" class="img-circle" alt="User Image">
                                <p>
                                    
                                  <?= Yii::$app->user->identity->username?>
                                </p>
                            </li>
                            <!-- Menu Body -->
                          
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                             <?= Html::a(
                                                    'Sign out',
                                                    ['/site/logout'],
                                                    ['data-method' => 'post','class'=>'btn btn-default btn-flat']
                                                ) ?>
                                  
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="http://placehold.it/45x45" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?= Yii::$app->user->identity->username?></p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
 
            <?=
            \yiister\adminlte\widgets\Menu::widget(
                [
                    "items" => [
                        ["label" => "Dashboard", "url" => ["#"], "icon" => "dashboard"],
                        ["label" => "Complaints", "url" => ["/appeal/complaints"], "icon" => "comments"],
                        ["label" => "Complaints Token", "url" => ["/appeal/complaints/tokens"], "icon" => "folder"],
                        ["label" => "Complaints Category", "url" => ["/appeal/complaint-categories"], "icon" => "folder"],
                        ["label" => "Unverified Appeal", "url" => ["/appeal/appeal/un-verified-appeal"], "icon" => "folder"],
                        ["label" => "Verified Appeal", "url" => ["/appeal/appeal/verified-appeal"], "icon" => "folder"],
                        ["label" => "Appeal Categories", "url" => ["/appeal/appeal-category"], "icon" => "folder"],
                        ["label" => "Appeal Questions", "url" => ["/appeal/appeal-question"], "icon" => "folder"],
                    ],
                ]
            )
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?= Html::encode(isset($this->params['h1']) ? $this->params['h1'] : $this->title) ?>
            </h1>
            
            <?php if (isset($this->params['breadcrumbs'])): ?>
                <?=
                \yii\widgets\Breadcrumbs::widget(
                    [
                        'encodeLabels' => false,
                        'homeLink' => [
                            'label' => new \rmrevin\yii\fontawesome\component\Icon('home') . ' Home',
                            'url' => ["site/index"],
                        ],
                        'links' => $this->params['breadcrumbs'],
                    ]
                )
                ?>
            <?php endif; ?>
        </section>

        <!-- Main content -->
        <section class="content">
         
            <?= Alert::widget() ?>
            <?= $content ?>
                          <?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-medium',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
         
        </div>
        <!-- Default to the left -->
         
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul><!-- /.control-sidebar-menu -->

            </div><!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane1" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                            Some information about this general settings option
                        </p>
                    </div><!-- /.form-group -->
                </form>
            </div><!-- /.tab-pane -->
        </div>
    </aside><!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
