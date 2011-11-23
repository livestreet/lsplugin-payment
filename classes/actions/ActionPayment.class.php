<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

class PluginPayment_ActionPayment extends ActionPlugin {
	
	public function Init() {
		$this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__).'css/style.css');
		$this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/main.js');
	}
	/**
	 * Регистрируем евенты
	 *
	 */
	protected function RegisterEvent() {
		$this->AddEvent('ajax-processing','EventAjaxProcessing');
		$this->AddEventPreg('/^\d+$/i','EventIndex');
		
		$this->AddEventPreg('/^wm$/i','/^result$/i','EventWmResult');
		$this->AddEventPreg('/^wm$/i','/^success$/i','EventWmSuccess');
		$this->AddEventPreg('/^wm$/i','/^fail$/i','EventWmFail');
	}


	/**********************************************************************************
	************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	**********************************************************************************
	*/
	
	
	protected function EventAjaxProcessing() {
		$this->Viewer_SetResponseAjax('json');
		
		/**
		 * Проверка платежа
		 */
		if (!($oPayment=$this->PluginPayment_Payment_GetPaymentById(getRequest('payment_id',null,'post')))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_payment_id'),$this->Lang_Get('error'));
			return;
		}
		
		/**
		 * Проверка состония платежа
		 */
		if ($oPayment->getState()!=PluginPayment_ModulePayment::PAYMENT_STATE_NEW) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_state'),$this->Lang_Get('error'));
			return;
		}
		
		/**
		 * Проверка связи с объектом покупки
		 */
		if (!($oTarget=$this->PluginPayment_Payment_GetTargetByPaymentId($oPayment->getId()))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_target'),$this->Lang_Get('error'));
			return;
		}
		
		/**
		 * Проверяем разрешение на платеж
		 */
		if (!$this->PluginPayment_Payment_CheckAccessForPayment($oPayment)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_payment_not_access'),$this->Lang_Get('error'));
			return;
		}
		
		/**
		 * Определяем допустимые типы оплаты в зависимоти от валюты
		 */
		$sType=getRequest('payment_type',null,'post');
		$aTypeAvailable=$this->PluginPayment_Payment_GetAvailablePaymentType($oPayment);
		if (!in_array($sType, $aTypeAvailable)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_payment_available_type'),$this->Lang_Get('error'));
			return;
		}
		$oPayment->setType($sType);
		$this->PluginPayment_Payment_UpdatePayment($oPayment);
		/**
		 * 
		 * Формируем описание покупки для платежной системы, добавляем в конец номер платежа (будет проще решать возможные проблемы с платежами)
		 */
		$sDescription=$oTarget->getTargetPaymentDescription().', №'.$oPayment->getId();
		$sDescription1251=$this->PluginPayment_Payment_ConvertTo1251($sDescription);
		//var_dump($sDescription1251);
		
		$oViewerLocal=$this->Viewer_GetLocalViewer();

		
		if ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_WM) {			
			$oViewerLocal->Assign('LMI_PAYMENT_AMOUNT',$oPayment->getSum());
			$oViewerLocal->Assign('LMI_PAYMENT_DESC',$sDescription);
			$oViewerLocal->Assign('LMI_PAYMENT_DESC_BASE64',base64_encode($sDescription));
			$oViewerLocal->Assign('LMI_PAYMENT_NO',$oPayment->getId());
			
			$sPurse=Config::Get('plugin.payment.wm.payee_purse_wmz');
			if ($oPayment->getCurrencyId()==PluginPayment_ModulePayment::PAYMENT_CURRENCY_RUR) {
				$sPurse=Config::Get('plugin.payment.wm.payee_purse_wmr');
			} elseif ($oPayment->getCurrencyId()==PluginPayment_ModulePayment::PAYMENT_CURRENCY_UAH) {
				$sPurse=Config::Get('plugin.payment.wm.payee_purse_wmu');
			}
			$oViewerLocal->Assign('LMI_PAYEE_PURSE',$sPurse);
			
			$oViewerLocal->Assign('LMI_SIM_MODE',0);
			$oViewerLocal->Assign('LMI_RESULT_URL',Router::getPath('payment').'wm/result/');
			$oViewerLocal->Assign('LMI_SUCCESS_URL',Router::getPath('payment').'wm/success/');
			$oViewerLocal->Assign('LMI_SUCCESS_METHOD',1);
			$oViewerLocal->Assign('LMI_FAIL_URL',Router::getPath('payment').'wm/fail/');
			$oViewerLocal->Assign('LMI_FAIL_METHOD',1);
			$oViewerLocal->Assign('key',$oPayment->getKey());

			$this->Viewer_AssignAjax('sFormText',$oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__)."payment.wm.tpl"));
		} elseif ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_LIQPAY) {
			$sCurrency='USD';
			if ($oPayment->getCurrencyId()==PluginPayment_ModulePayment::PAYMENT_CURRENCY_RUR) {
				$sCurrency='RUR';
			} elseif ($oPayment->getCurrencyId()==PluginPayment_ModulePayment::PAYMENT_CURRENCY_UAH) {
				$sCurrency='UAH';
			}
			$sXml="<request>
				<version>1.2</version>
				<result_url>".Router::getPath('payment').'liqpay/result/'."</result_url>
				<server_url>".Router::getPath('payment').'liqpay/result/'."</server_url>
				<merchant_id>".Config::Get('plugin.payment.liqpay.merchant_id')."</merchant_id>
				<order_id>{$oPayment->getId()}</order_id>
				<amount>".number_format($oPayment->getSum(), 2, '.', '')."</amount>
				<currency>".$sCurrency."</currency>
				<description>".htmlspecialchars($sDescription)."</description>				
				<pay_way>card</pay_way> 
			</request>";

			$sSig = base64_encode(sha1(Config::Get('plugin.payment.liqpay.signature').$sXml.Config::Get('plugin.payment.liqpay.signature'),1));			
			$oViewerLocal->Assign('LIQPAY_OPERATION_XML',base64_encode($sXml));
			$oViewerLocal->Assign('LIQPAY_SIGNATURE',$sSig);
			$this->Viewer_AssignAjax('sFormText',$oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__)."payment.liqpay.tpl"));
		} elseif ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_PAYPRO) {	
			$oViewerLocal->Assign('PAYPRO_PRODUCTS',44149);
			$oViewerLocal->Assign('PAYPRO_CUSTOMFIELD1',$oPayment->getKey());
			$oViewerLocal->Assign('PAYPRO_HASH',$this->PluginPayment_Payment_PayProGetHash($oPayment->getSum(),$sDescription));
			
			$this->Viewer_AssignAjax('sFormText',$oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__)."payment.paypro.tpl"));
		} elseif ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_ROBOX) {	
			$oViewerLocal->Assign('MrchLogin',Config::Get('plugin.payment.robox.login'));
			$oViewerLocal->Assign('OutSum',$oPayment->getSum());
			$oViewerLocal->Assign('InvId',$oPayment->getId());
			$oViewerLocal->Assign('Desc',$sDescription);
			$oViewerLocal->Assign('SignatureValue',md5(Config::Get('plugin.payment.robox.login').":{$oPayment->getSum()}:{$oPayment->getId()}:".Config::Get('plugin.payment.robox.password_1').":shp_key={$oPayment->getKey()}"));
			$oViewerLocal->Assign('IncCurrLabel','PCR');			
			$oViewerLocal->Assign('shp_key',$oPayment->getKey());
			
			$this->Viewer_AssignAjax('sFormText',$oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__)."payment.robox.tpl"));
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_payment_available_type'),$this->Lang_Get('error'));
			return;
		}
	}
	
	/**
	 * Страница оформления платежа
	 * Необходимо передать GET параметр payment_id - номер счета(платежа), который нужно оплатить
	 *
	 * @return unknown
	 */
	protected function EventIndex() {
		
		/**
		 * Проверка платежа
		 */
		if (!($oPayment=$this->PluginPayment_Payment_GetPaymentById($this->sCurrentEvent))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_payment_id'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		
		/**
		 * Проверка состония платежа
		 */
		if ($oPayment->getState()!=PluginPayment_ModulePayment::PAYMENT_STATE_NEW) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_state'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		
		/**
		 * Проверка связи с объектом покупки
		 */
		if (!($oTarget=$this->PluginPayment_Payment_GetTargetByPaymentId($oPayment->getId()))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_target'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		
		/**
		 * Проверяем разрешение на платеж
		 */
		if (!$this->PluginPayment_Payment_CheckAccessForPayment($oPayment)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_payment_not_access'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		
		/**
		 * Определяем допустимые типы оплаты в зависимоти от валюты
		 */
		$aTypeAvailable=$this->PluginPayment_Payment_GetAvailablePaymentType($oPayment);
		if (!count($aTypeAvailable)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.payment.error_payment_available_type'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		
		
		$this->Viewer_Assign('oPayment',$oPayment);
		$this->Viewer_Assign('oPaymentTarget',$oTarget);
		$this->Viewer_Assign('aPaymentTypeAvailable',$aTypeAvailable);
		$this->SetTemplateAction('payment');
	}

	/**
	 * Платеж завершен успешно, выполняется по инициативе сервера платежной системы сразу после покупки.
	 * Именно в этом методе нужно фиксировать факт оплаты
	 * Редиректы в данном методе не имеют смысла
	 * 
	 * @param unknown_type $oPayment
	 */
	protected function MakePaymentSuccess($oPayment) {
		$this->PluginPayment_Payment_MakePaymentSuccess($oPayment);
	}
	
	/**
	 * Информирование об успешном платеже - выполняется в момент редиректа пользователя после оплаты
	 * 
	 * @param unknown_type $oPayment
	 */
	protected function ProcessPaymentSuccess($oPayment) {
		$this->PluginPayment_Payment_ProcessPaymentSuccess($oPayment);
	}
	
	/**
	 * Информирование об несостоявшемся платеже - выполняется в момент редиректа пользователя после попытки оплаты
	 * 
	 * @param unknown_type $oPayment
	 */
	protected function ProcessPaymentFail($oPayment) {
		$this->PluginPayment_Payment_ProcessPaymentFail($oPayment);
	}
	
	protected function EventWmResult() {		
		if (getRequest('LMI_PREREQUEST')==1) {		
			$iError=$this->PluginPayment_Payment_PreResultWm();
			if ($iError==0) {
				echo('YES');
			}
			exit();
		}
		$iError=$this->PluginPayment_Payment_ResultWm();
		if ($iError==0) {
			// проводим платеж
			$this->MakePaymentSuccess($this->PluginPayment_Payment_GetPaymentCurrent());
		}
		exit();
	}
	
	protected function EventWmSuccess() {
		$iError=$this->PluginPayment_Payment_SuccessWm();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			$this->SetTemplateAction('fail');
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);
		
		if ($iError===0) {
			$this->ProcessPaymentSuccess($oPayment);
			$this->SetTemplateAction('success');
		} else {
			$this->ProcessPaymentFail($oPayment);
			$this->SetTemplateAction('fail');
		}
	}
	
	protected function EventWmFail() {
		$iError=$this->PluginPayment_Payment_FailWm();
		$this->SetTemplateAction('fail');
		
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {			
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);
		$this->ProcessPaymentFail($oPayment);
	}
}
?>