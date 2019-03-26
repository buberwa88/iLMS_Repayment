<?php //

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Mickidadi Kosiyanga
 * @email mickidadimsoka@gmail.com
 */

namespace common\components;
use Yii;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller {

    //put your code here
    public function beforeAction($action) {
        //Actions that dont require login
        
        $dontRequireLogin = array();
        array_push($dontRequireLogin, '/site/index');
        array_push($dontRequireLogin, '/site/login');
        array_push($dontRequireLogin,'site/refund-register');
        array_push($dontRequireLogin, '/application/default/home-page');
        array_push($dontRequireLogin, '/application/default/loan-apply');
        array_push($dontRequireLogin, '/application/default/necta');
        array_push($dontRequireLogin, '/application/default/nectain');
        array_push($dontRequireLogin, '/application/default/index');
        array_push($dontRequireLogin, '/application/default/guideline-swahili');
        array_push($dontRequireLogin, '/application/default/guideline-english');
        array_push($dontRequireLogin, '/application/default/payment-status');
		//REPAYMENT
		array_push($dontRequireLogin, '/repayment/employer/create');
		array_push($dontRequireLogin, '/repayment/default/captcha');
		array_push($dontRequireLogin, '/repayment/employer/district-name');
		array_push($dontRequireLogin, '/repayment/employer/ward-name');
		array_push($dontRequireLogin, '/repayment/employer/view-employer-success');
		array_push($dontRequireLogin, '/repayment/employer/view-employer-email-verification-code-success');
		array_push($dontRequireLogin, '/repayment/employer/employer-activate-account');		
		array_push($dontRequireLogin, '/repayment/loan-beneficiary/create');
		array_push($dontRequireLogin, '/repayment/default/password-reset-beneficiary');
		array_push($dontRequireLogin, '/repayment/loan-beneficiary/password-reset-beneficiary');
		array_push($dontRequireLogin, '/repayment/default/password-recover');
		array_push($dontRequireLogin, '/repayment/default/view-beneficiary-details');
		array_push($dontRequireLogin, '/repayment/loan-beneficiary/view-beneficiary-details');
		array_push($dontRequireLogin, '/repayment/loan-beneficiary/view-loanee-success-registered');
		array_push($dontRequireLogin, '/repayment/default/recover-password');
		array_push($dontRequireLogin, '/repayment/employer/viewemployer-verificationcode');
		array_push($dontRequireLogin, '/repayment/loan-beneficiary/verify-beneficiaryemail');
		array_push($dontRequireLogin, '/repayment/employer/programme-namepublic');
		array_push($dontRequireLogin, '/repayment/refund-claimant/nectadetails');
		//END REPAYMENT
		
             $mustLogin = array();
        array_push($mustLogin, '/site/change-password');
        array_push($mustLogin, '/app-backend/users/profile');
        array_push($mustLogin, '/app-backend/users/updatepic');
        array_push($mustLogin, '/app-backend/users/updateidentification');
        array_push($mustLogin, '/app-backend/users/changepassword');
     
        $action_id = \Yii::$app->controller->action->id;
        $controller_id = \Yii::$app->controller->id;
        $module_id = Yii::$app->controller->module->id;
        $uaction = "/{$module_id}/{$controller_id}/{$action_id}";
    
        $uaction_btrimmed1 =str_replace('/app-backend', '', $uaction);
        $uaction_btrimmed =str_replace('/app-frontend', '', $uaction_btrimmed1);
    
        //Actions accessible by any user, but must login first 
          if (\Yii::$app->user->isGuest&& !in_array($uaction, $dontRequireLogin)) {
                          $this->redirect(['/site/index']);  
           //exit();
           }else{
   
        //A user must first login
        
        if (\Yii::$app->user->isGuest && !in_array($uaction, $dontRequireLogin)) {
         $this->redirect(['/site/index']);   
        }
     //checking if user is allowed to access this action
        if (!Yii::$app->user->can($uaction_btrimmed) && !in_array($uaction, $dontRequireLogin)) {
           // echo $uaction_btrimmed;
            if (\Yii::$app->user->isGuest) {
               $this->redirect(['/site/index']);  
         //  exit();
           }
           else{
         if(!$action instanceof \yii\web\ErrorAction) {
           throw new ForbiddenHttpException("Sorry, you are not allowed to perform this action!");
              }
           }
        }
       //checking if user is logged in
       if (in_array($uaction, $mustLogin)) {
            if (\Yii::$app->user->isGuest) {
              $this->redirect(['/site/index']);
            }
           else if(!$action instanceof \yii\web\ErrorAction) {
           throw new ForbiddenHttpException("Sorry, you are not allowed to perform this action!");
              }
        }
   return parent::beforeAction($action);
        }
    }

}