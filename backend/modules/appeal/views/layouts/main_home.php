<?php

/**
 * @var $content string
 */

use yii\helpers\Html;
use common\widgets\Alert;
yiister\adminlte\assets\Asset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
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
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);

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
  
    width: 220px;
}
    </style>
</head>
<!--
BODY TAG OPTIONS:
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
<body class="hold-transition skin-blue layout-top-nav">
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
                      <a class="navbar-brand" href="#"><img style="width:60%" src="login/logo.png" alt=" "></a> 
         
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
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
         <?php echo uran1980\yii\widgets\pace\Pace::widget([
            'color' => 'green',
            'theme' => 'flash',
             ]); ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
           ILMIS
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy;  <a href="#">Powered by UCC</a>  <?= date("Y") ?>
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
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
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
