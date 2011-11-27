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

class PluginTestpay_ActionTestpay extends ActionPlugin {
	
	/**
	 * Инициализация
	 * 
	 */
	public function Init() {
		$this->SetDefaultEvent('index');
	}
	
	/**
	 * Регистрируем евенты
	 *
	 */
	protected function RegisterEvent() {
		$this->AddEvent('index','EventIndex');
	}


	/**********************************************************************************
	************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	**********************************************************************************
	*/
	
	/**
	 * Обработка страницы с созданием платежа
	 */
	protected function EventIndex() {
		/**
		 * Получаем список уже оплаченных бубликов
		 */
		$aPaymentTargets=$this->PluginPayment_Payment_GetTargetsByFilter(array(
			'target_type' => 'bublik',
			'state' => PluginPayment_ModulePayment::PAYMENT_TARGET_STATE_COMPLETE,
		));
		/**
		 * Формируем список уже проплаченных бубликов
		 */
		$aBublikIdPay=array();
		foreach ($aPaymentTargets as $oTarget) {
			$aBublikIdPay[]=$oTarget->getTargetId();
		}
		$this->Viewer_Assign('aPaymentTargets',$aPaymentTargets);
		
		/**
		 * Обрабатываем создание платежа
		 */
		if (getRequest('submit_buy')) {
			$this->Security_ValidateSendForm();
			
			$iNumber=getRequest('bublik_number');
			if (!(is_numeric($iNumber) and $iNumber>=1 and $iNumber<=6)) {
				$this->Message_AddError('Нужно выбрать верный номер бублика - от 1 до 6',$this->Lang_Get('error'));
				return ;
			}
			
			$fSum=getRequest('bublik_sum');
			if (!func_check($fSum,'float')) {
				$this->Message_AddError('Неверная сумма за бублик, необходимо ввести число (можно дробное)',$this->Lang_Get('error'));
				return ;
			}
			
			/**
			 * Создаем платеж
			 * Последний параметр - делать или нет редирект на страницу оплату в случаи успешного создания платежа
			 */
			$iError=$this->PluginPayment_Payment_MakePayment('bublik',$iNumber,$fSum,PluginPayment_ModulePayment::PAYMENT_CURRENCY_USD,true);
			if ($iError!==0) {
				$this->Message_AddError('При создании платежа возникла ошибка, смотри логи плагина payment',$this->Lang_Get('error'));
			}
		}	
	}
}
?>