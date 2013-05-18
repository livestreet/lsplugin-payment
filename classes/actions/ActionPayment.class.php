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

		$this->AddEventPreg('/^master$/i','/^result$/i','EventMasterResult');
		$this->AddEventPreg('/^master$/i','/^success$/i','EventMasterSuccess');
		$this->AddEventPreg('/^master$/i','/^fail$/i','EventMasterFail');

		$this->AddEventPreg('/^liqpay$/i','/^result$/i','EventLiqpayResult');

		$this->AddEventPreg('/^robox$/i','/^result$/i','EventRoboxResult');
		$this->AddEventPreg('/^robox$/i','/^success$/i','EventRoboxSuccess');
		$this->AddEventPreg('/^robox$/i','/^fail$/i','EventRoboxFail');

		$this->AddEventPreg('/^paypro$/i','/^notify$/i','EventPayproNotify');
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

		$oViewerLocal=$this->Viewer_GetLocalViewer();


		if ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_WM) {
			$oViewerLocal->Assign('LMI_PAYMENT_AMOUNT',$oPayment->getSum());
			$oViewerLocal->Assign('LMI_PAYMENT_DESC',$sDescription);
			$oViewerLocal->Assign('LMI_PAYMENT_DESC_BASE64',base64_encode($sDescription));
			$oViewerLocal->Assign('LMI_PAYMENT_NO',$oPayment->getId());
			$oViewerLocal->Assign('LMI_PAYEE_PURSE',$this->PluginPayment_Payment_GetWmPurseByCurrency($oPayment->getCurrencyId()));

			$oViewerLocal->Assign('LMI_SIM_MODE',0);
			$oViewerLocal->Assign('LMI_RESULT_URL',Router::getPath('payment').'wm/result/');
			$oViewerLocal->Assign('LMI_SUCCESS_URL',Router::getPath('payment').'wm/success/');
			$oViewerLocal->Assign('LMI_SUCCESS_METHOD',1);
			$oViewerLocal->Assign('LMI_FAIL_URL',Router::getPath('payment').'wm/fail/');
			$oViewerLocal->Assign('LMI_FAIL_METHOD',1);
			$oViewerLocal->Assign('key',$oPayment->getKey());

			$this->Viewer_AssignAjax('sFormText',$oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__)."payment.wm.tpl"));
		} elseif ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_MASTER) {
			$oViewerLocal->Assign('LMI_PAYMENT_AMOUNT',$oPayment->getSum());
			$oViewerLocal->Assign('LMI_PAYMENT_DESC',$sDescription);
			$oViewerLocal->Assign('LMI_PAYMENT_NO',$oPayment->getId());
			$oViewerLocal->Assign('LMI_MERCHANT_ID',Config::Get('plugin.payment.master.mid'));
			$oViewerLocal->Assign('LMI_SIM_MODE',0);
			$oViewerLocal->Assign('LMI_INVOICE_CONFIRMATION_URL',Router::getPath('payment').'master/result/');
			$oViewerLocal->Assign('LMI_PAYMENT_NOTIFICATION_URL',Router::getPath('payment').'master/result/');
			$oViewerLocal->Assign('LMI_SUCCESS_URL',Router::getPath('payment').'master/success/');
			$oViewerLocal->Assign('LMI_FAILURE_URL',Router::getPath('payment').'master/fail/');
			$oViewerLocal->Assign('LMI_CURRENCY','RUB'); // 643 ISO
			$oViewerLocal->Assign('key',$oPayment->getKey());

			$this->Viewer_AssignAjax('sFormText',$oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__)."payment.master.tpl"));
		} elseif ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_LIQPAY) {
			$sXml="<request>
				<version>1.2</version>
				<result_url>".Router::getPath('payment').'liqpay/result/'."</result_url>
				<server_url>".Router::getPath('payment').'liqpay/result/'."</server_url>
				<merchant_id>".Config::Get('plugin.payment.liqpay.merchant_id')."</merchant_id>
				<order_id>{$oPayment->getId()}</order_id>
				<amount>".number_format($oPayment->getSum(), 2, '.', '')."</amount>
				<currency>".$this->PluginPayment_Payment_GetLiqpayCurrency($oPayment->getCurrencyId())."</currency>
				<description>".htmlspecialchars($sDescription)."</description>				
				<pay_way>card</pay_way> 
			</request>";

			$sSig = base64_encode(sha1(Config::Get('plugin.payment.liqpay.signature').$sXml.Config::Get('plugin.payment.liqpay.signature'),1));
			$oViewerLocal->Assign('LIQPAY_OPERATION_XML',base64_encode($sXml));
			$oViewerLocal->Assign('LIQPAY_SIGNATURE',$sSig);
			$this->Viewer_AssignAjax('sFormText',$oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__)."payment.liqpay.tpl"));
		} elseif ($oPayment->getType()==PluginPayment_ModulePayment::PAYMENT_TYPE_PAYPRO) {
			$oViewerLocal->Assign('PAYPRO_PRODUCTS',Config::Get('plugin.payment.paypro.products'));
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
		return $this->PluginPayment_Payment_ProcessPaymentSuccess($oPayment);
	}

	/**
	 * Информирование об несостоявшемся платеже - выполняется в момент редиректа пользователя после попытки оплаты
	 *
	 * @param unknown_type $oPayment
	 */
	protected function ProcessPaymentFail($oPayment) {
		return $this->PluginPayment_Payment_ProcessPaymentFail($oPayment);
	}

	/**
	 * Обработка запроса Webmoney
	 * Совершение платежа
	 */
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

	/**
	 * Обработка запроса Webmoney
	 * Редирект после успешной покупки
	 */
	protected function EventWmSuccess() {
		$iError=$this->PluginPayment_Payment_SuccessWm();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			$this->SetTemplateAction('fail');
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);

		if ($iError===0) {
			$mRes=$this->ProcessPaymentSuccess($oPayment);
			if ($mRes=='next') {
				return $mRes;
			}
			$this->SetTemplateAction('success');
		} else {
			$mRes=$this->ProcessPaymentFail($oPayment);
			if ($mRes=='next') {
				return $mRes;
			}
			$this->SetTemplateAction('fail');
		}
	}

	/**
	 * Обработка запроса Webmoney
	 * Редирект после незавершенного платежа
	 */
	protected function EventWmFail() {
		$iError=$this->PluginPayment_Payment_FailWm();
		$this->SetTemplateAction('fail');

		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);
		$mRes=$this->ProcessPaymentFail($oPayment);
		if ($mRes=='next') {
			return $mRes;
		}
	}

	/**
	 * Обработка запроса PayMaster
	 * Совершение платежа
	 */
	protected function EventMasterResult() {
		if (getRequest('LMI_PREREQUEST')==1) {
			$iError=$this->PluginPayment_Payment_PreResultMaster();
			if ($iError==0) {
				echo('YES');
			}
			exit();
		}
		$iError=$this->PluginPayment_Payment_ResultMaster();
		if ($iError==0) {
			// проводим платеж
			$this->MakePaymentSuccess($this->PluginPayment_Payment_GetPaymentCurrent());
		}
		exit();
	}

	/**
	 * Обработка запроса PayMaster
	 * Редирект после успешной покупки
	 */
	protected function EventMasterSuccess() {
		$iError=$this->PluginPayment_Payment_SuccessMaster();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			$this->SetTemplateAction('fail');
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);

		if ($iError===0) {
			$mRes=$this->ProcessPaymentSuccess($oPayment);
			if ($mRes=='next') {
				return $mRes;
			}
			$this->SetTemplateAction('success');
		} else {
			$mRes=$this->ProcessPaymentFail($oPayment);
			if ($mRes=='next') {
				return $mRes;
			}
			$this->SetTemplateAction('fail');
		}
	}

	/**
	 * Обработка запроса PayMaster
	 * Редирект после незавершенного платежа
	 */
	protected function EventMasterFail() {
		$iError=$this->PluginPayment_Payment_FailMaster();
		$this->SetTemplateAction('fail');

		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);
		$mRes=$this->ProcessPaymentFail($oPayment);
		if ($mRes=='next') {
			return $mRes;
		}
	}

	/**
	 * Обработка запроса LiqPay
	 */
	protected function EventLiqpayResult() {
		$result=$this->PluginPayment_Payment_ResultLiqpay();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			$this->SetTemplateAction('fail');
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);

		if (is_array($result)) {
			if ($result[1]=='success') {
				// проводим платеж
				$this->MakePaymentSuccess($oPayment);

				if ($result[0]=='server_url') {
					exit();
				} else {
					$this->SetTemplateAction('success');
					$mRes=$this->ProcessPaymentSuccess($oPayment);
					if ($mRes=='next') {
						return $mRes;
					}
				}
			} elseif ($result[1]=='success_repeat') {
				if ($result[0]=='server_url') {
					exit();
				} else {
					$this->SetTemplateAction('success');
					$mRes=$this->ProcessPaymentSuccess($oPayment);
					if ($mRes=='next') {
						return $mRes;
					}
				}
			} elseif ($result[1]=='wait_secure') {
				$this->SetTemplateAction('wait');
				if ($result[0]=='server_url') {
					exit();
				}
			} elseif ($result[1]=='wait_secure_repeat') {
				$this->SetTemplateAction('wait');
				if ($result[0]=='server_url') {
					exit();
				}
			} elseif ($result[1]=='failure') {
				if ($result[0]=='server_url') {
					exit();
				} else {
					$this->SetTemplateAction('fail');
					$mRes=$this->ProcessPaymentFail($oPayment);
					if ($mRes=='next') {
						return $mRes;
					}
				}
			} elseif ($result[1]=='failure_repeat') {
				if ($result[0]=='server_url') {
					exit();
				} else {
					$this->SetTemplateAction('fail');
					$mRes=$this->ProcessPaymentFail($oPayment);
					if ($mRes=='next') {
						return $mRes;
					}
				}
			} else {
				$this->SetTemplateAction('fail');
				$mRes=$this->ProcessPaymentFail($oPayment);
				if ($mRes=='next') {
					return $mRes;
				}
				return ;
			}
		} else {
			$this->SetTemplateAction('fail');
			$mRes=$this->ProcessPaymentFail($oPayment);
			if ($mRes=='next') {
				return $mRes;
			}
			return ;
		}
	}

	/**
	 * Обработка запроса Робокассы
	 * Совершение платежа
	 */
	protected function EventRoboxResult() {
		$iError=$this->PluginPayment_Payment_ResultRobox();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if ($iError==0) {
			if (!$oPayment) {
				$this->SetTemplateAction('fail');
				exit();
			}

			// проводим платеж
			$this->MakePaymentSuccess($oPayment);
			echo('OK'.$oPayment->getId());
		}
		exit();
	}

	/**
	 * Обработка запроса Робокассы
	 * Редирект после успешной покупки
	 */
	protected function EventRoboxSuccess() {
		$iError=$this->PluginPayment_Payment_SuccessRobox();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			$this->SetTemplateAction('fail');
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);

		if ($iError===0) {
			$mRes=$this->ProcessPaymentSuccess($oPayment);
			if ($mRes=='next') {
				return $mRes;
			}
			$this->SetTemplateAction('success');
		} else {
			$mRes=$this->ProcessPaymentFail($oPayment);
			if ($mRes=='next') {
				return $mRes;
			}
			$this->SetTemplateAction('fail');
		}
	}

	/**
	 * Обработка запроса Робокассы
	 * Редирект после незавершенного платежа
	 */
	protected function EventRoboxFail() {
		$iError=$this->PluginPayment_Payment_FailRobox();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		$this->SetTemplateAction('fail');
		if (!$oPayment) {
			return ;
		}
		$this->Viewer_Assign('oPayment',$oPayment);
		$mRes=$this->ProcessPaymentFail($oPayment);
		if ($mRes=='next') {
			return $mRes;
		}
	}

	/**
	 * Обработка запроса от PayPro (оплата paypal)
	 */
	protected function EventPayproNotify() {
		$iError=$this->PluginPayment_Payment_ResultPaypro();
		$oPayment=$this->PluginPayment_Payment_GetPaymentCurrent();
		if (!$oPayment) {
			exit();
		}

		/**
		 * Платеж прошел успешно
		 */
		if ($iError===0) {
			// проводим платеж
			$this->MakePaymentSuccess($oPayment);
		} else {

		}
		exit();
	}
}
?>