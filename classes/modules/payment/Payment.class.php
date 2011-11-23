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

/**
 * Модуль онлайн оплаты Payment
 *
 */
class PluginPayment_ModulePayment extends Module {	
	
	/**
	 * Типы платежей
	 *
	 */
	const PAYMENT_TYPE_WM='wm';
	const PAYMENT_TYPE_PAYPAL='paypal';
	const PAYMENT_TYPE_LIQPAY='liqpay';
	const PAYMENT_TYPE_PAYPRO='paypro';
	const PAYMENT_TYPE_ROBOX='robox';
	const PAYMENT_TYPE_MANUAL='manual';
	
	/**
	 * Типы валют
	 */
	const PAYMENT_CURRENCY_USD=1;
	const PAYMENT_CURRENCY_RUR=2;
	const PAYMENT_CURRENCY_UAH=3;
	
	/**
	 * Состояния платежа
	 *
	 */
	const PAYMENT_STATE_NEW=0;
	const PAYMENT_STATE_PRE=1;
	const PAYMENT_STATE_SOLD=2;
	const PAYMENT_STATE_COMPLETE=3;
	const PAYMENT_STATE_FAILED=4;
	
	/**
	 * Состояния связи объекта платежа
	 *
	 */
	const PAYMENT_TARGET_STATE_NEW=0;
	const PAYMENT_TARGET_STATE_COMPLETE=1;
	
	/**
	 * Типы проверок объекта платежа
	 */
	const PAYMENT_TARGET_CHECK_MAKE_PAYMENT=1;
	
	/**
	 * Ошибки 
	 *
	 */
	const PAYMENT_ERROR_FAILED_TYPE=1;
	const PAYMENT_ERROR_FAILED_SUM=2;
	const PAYMENT_ERROR_FAILED_CURRENCY=3;
	const PAYMENT_ERROR_FAILED_MAKE=4;
	
	const PAYMENT_ERROR_WM_RESULT_NUMBER=5;
	const PAYMENT_ERROR_WM_RESULT_STATE=6;
	const PAYMENT_ERROR_WM_RESULT_KEY=7;
	const PAYMENT_ERROR_WM_RESULT_SUM=8;
	const PAYMENT_ERROR_WM_RESULT_PURSE=9;
	const PAYMENT_ERROR_WM_RESULT_HASH_METHOD=10;
	const PAYMENT_ERROR_WM_RESULT_HASH=11;
	const PAYMENT_ERROR_WM_RESULT_ADD=12;
	
	const PAYMENT_ERROR_WM_PRERESULT_NO=13;
	const PAYMENT_ERROR_WM_PRERESULT_NUMBER=14;
	const PAYMENT_ERROR_WM_PRERESULT_STATE=15;
	const PAYMENT_ERROR_WM_PRERESULT_KEY=16;
	const PAYMENT_ERROR_WM_PRERESULT_SUM=17;
	const PAYMENT_ERROR_WM_PRERESULT_PURSE=18;
	
	const PAYMENT_ERROR_WM_SUCCESS_NUMBER=19;
	const PAYMENT_ERROR_WM_SUCCESS_WM=20;
	const PAYMENT_ERROR_WM_SUCCESS_STATE=21;
	const PAYMENT_ERROR_WM_SUCCESS_INVS_NO=22;
	const PAYMENT_ERROR_WM_SUCCESS_TRANS_NO=23;
	const PAYMENT_ERROR_WM_SUCCESS_KEY=24;
	
	const PAYMENT_ERROR_WM_FAIL_NUMBER=25;
	const PAYMENT_ERROR_WM_FAIL_KEY=26;
	const PAYMENT_ERROR_WM_FAIL_STATE=27;
		
	const PAYMENT_ERROR_LIQPAY_RESULT_XML=28;
	const PAYMENT_ERROR_LIQPAY_RESULT_XML_PARSER=29;
	const PAYMENT_ERROR_LIQPAY_RESULT_SIG=30;
	const PAYMENT_ERROR_LIQPAY_RESULT_ORDER=31;
	const PAYMENT_ERROR_LIQPAY_RESULT_AMOUNT=32;
	const PAYMENT_ERROR_LIQPAY_RESULT_CURRENCY=33;
	const PAYMENT_ERROR_LIQPAY_RESULT_NOT_SOLD=34;
	const PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW=35;
	const PAYMENT_ERROR_LIQPAY_RESULT_SOLD_EXISTS=36;
	const PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW_FOR_SOLD=37;
	const PAYMENT_ERROR_LIQPAY_RESULT_NOT_SOLD_FOR_FAILED=38;
	const PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW_FOR_FAILED=39;
	const PAYMENT_ERROR_LIQPAY_RESULT_ACTION=40;
	const PAYMENT_ERROR_LIQPAY_RESULT_NOT_COMPLETE=41;
	
	const PAYMENT_ERROR_PAYPRO_RESULT_IP=42;
	const PAYMENT_ERROR_PAYPRO_RESULT_KEY=43;
	const PAYMENT_ERROR_PAYPRO_RESULT_PRODUCT_ID=44;
	const PAYMENT_ERROR_PAYPRO_RESULT_SUM=45;
	const PAYMENT_ERROR_PAYPRO_RESULT_STATE=46;
	const PAYMENT_ERROR_PAYPRO_RESULT_ADD=47;
	const PAYMENT_ERROR_PAYPRO_RESULT_TEST=48;
	
	const PAYMENT_ERROR_ROBOX_RESULT_NUMBER=49;
	const PAYMENT_ERROR_ROBOX_RESULT_KEY=50;
	const PAYMENT_ERROR_ROBOX_RESULT_SUM=51;
	const PAYMENT_ERROR_ROBOX_RESULT_STATE=52;
	const PAYMENT_ERROR_ROBOX_RESULT_SIG=53;
	const PAYMENT_ERROR_ROBOX_SUCCESS_NUMBER=54;
	const PAYMENT_ERROR_ROBOX_SUCCESS_KEY=55;
	const PAYMENT_ERROR_ROBOX_SUCCESS_SUM=56;
	const PAYMENT_ERROR_ROBOX_SUCCESS_STATE=57;
	const PAYMENT_ERROR_ROBOX_SUCCESS_SIG=58;
	const PAYMENT_ERROR_ROBOX_FAIL_NUMBER=59;
	const PAYMENT_ERROR_ROBOX_FAIL_KEY=60;
	const PAYMENT_ERROR_ROBOX_FAIL_SUM=61;
	const PAYMENT_ERROR_ROBOX_FAIL_STATE=62;	
	const PAYMENT_ERROR_ROBOX_FAIL_SIG=63;
	
	const PAYMENT_ERROR_TARGET_CHECK=64;
	
	protected $aTargetTypes=array();
	
	protected $oMapper;
	protected $oPaymentCurrent=null;
			
	/**
	 * Инициализация
	 *
	 */
	public function Init() {		
		$this->oMapper=Engine::GetMapper(__CLASS__);
	}
	
	public function GetTargetTypes() {
		return $this->aTargetTypes;
	}
	
	public function AddTargetType($sTargetName) {
		if (!in_array($sTargetName, $this->aTargetTypes)) {
			$this->aTargetTypes[]=$sTargetName;
			return true;
		}
		return false;
	}
	
	public function GetPaymentCurrent() {
		return $this->oPaymentCurrent;
	}
	
	public function AddPayment($oPayment) {
		if ($sId=$this->oMapper->AddPayment($oPayment)) {
			$oPayment->setId($sId);
			return $oPayment;
		}
		return false;
	}
	
	public function UpdatePayment($oPayment) {
		return $this->oMapper->UpdatePayment($oPayment);
	}
	
	public function GetPaymentById($sId) {
		return $this->oMapper->GetPaymentById($sId);
	}
	
	public function GetPaymentByKey($sKey) {
		return $this->oMapper->GetPaymentByKey($sKey);
	}
	
	public function GetCurrencyById($sId) {
		return $this->oMapper->GetCurrencyById($sId);
	}
	
	public function AddWm($oWm) {
		return $this->oMapper->AddWm($oWm);
	}
	
	public function GetWmByPaymentId($sId) {
		return $this->oMapper->GetWmByPaymentId($sId);
	}
	
	public function AddLiqpay($oLiqpay) {
		return $this->oMapper->AddLiqpay($oLiqpay);
	}
	
	public function AddPaypro($oPaypro) {
		return $this->oMapper->AddPaypro($oPaypro);
	}
	
	public function GetLiqpayByPaymentId($sId) {
		return $this->oMapper->GetLiqpayByPaymentId($sId);
	}
	
	public function AddTarget($oTarget) {
		return $this->oMapper->AddTarget($oTarget);
	}
	
	public function UpdateTarget($oTarget) {
		return $this->oMapper->UpdateTarget($oTarget);
	}
	
	public function GetTargetByPaymentId($sId) {
		return $this->oMapper->GetTargetByPaymentId($sId);
	}
	
	public function LogError($iNumberError,$var=null) {
		if (Config::Get('plugin.payment.logs.error')) {
			$sOldName=$this->Logger_GetFileName();
			$this->Logger_SetFileName(Config::Get('plugin.payment.logs.error'));
			$this->Logger_Error('Payment error: '.$iNumberError.' '.var_export($var,true));
			$this->Logger_SetFileName($sOldName);
		}
		return $iNumberError;
	}
	
	/**
	 * Создание счета на оплату
	 * 
	 * @param string $sTargetType
	 * @param int $iTargetId
	 * @param float $iSum
	 * @param int $iCurrencyId
	 * @param bool $bRedirect
	 */
	public function MakePayment($sTargetType,$iTargetId,$iSum,$iCurrencyId=self::PAYMENT_CURRENCY_USD,$bRedirect=TRUE) {
		if (!is_float($iSum)) {
			return $this->LogError(self::PAYMENT_ERROR_FAILED_SUM,$iSum);
		}
		if (!$this->GetCurrencyById($iCurrencyId)) {			
			return $this->LogError(self::PAYMENT_ERROR_FAILED_CURRENCY,$iCurrencyId);
		}
		/**
		 * Проверка объекта платежа
		 */
		if (!$this->CheckTarget($sTargetType,$iTargetId,self::PAYMENT_TARGET_CHECK_MAKE_PAYMENT)) {
			return $this->LogError(self::PAYMENT_ERROR_TARGET_CHECK,array($sTargetType,$iTargetId,self::PAYMENT_TARGET_CHECK_MAKE_PAYMENT));
		}
		/**
		 * Создаем платеж
		 */
		
		$sKey=func_generator(32);
		$oPayment=Engine::GetEntity('PluginPayment_ModulePayment_EntityPayment');
		$oPayment->setType(null);
		$oPayment->setSum($iSum);
		$oPayment->setState(self::PAYMENT_STATE_NEW);
		$oPayment->setIp(func_getIp());
		$oPayment->setKey($sKey);
		$oPayment->setDateAdd(date("Y-m-d H:i:s"));
		$oPayment->setCurrencyId($iCurrencyId);
		if ($this->AddPayment($oPayment)) {
			$this->oPaymentCurrent=$oPayment;
			/**
			 * Создаем связь с объектом платежа
			 */
			$oTarget=Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentTarget');
			$oTarget->setPaymentId($oPayment->getId());
			$oTarget->setTargetId($iTargetId);
			$oTarget->setTargetType($sTargetType);
			$this->AddTarget($oTarget);
			
			if ($bRedirect) {
				Router::Location(Router::GetPath('payment')."{$oPayment->getId()}/");
			} else {
				return 0;
			}
		}		
		return $this->LogError(self::PAYMENT_ERROR_FAILED_MAKE,$oPayment);
	}
	
	public function GetAvailablePaymentType($oPayment) {
		$aCurrency=array();
		if ($oPayment->getCurrencyId()==self::PAYMENT_CURRENCY_USD) {
			$aCurrency=array(self::PAYMENT_TYPE_WM,self::PAYMENT_TYPE_LIQPAY,self::PAYMENT_TYPE_PAYPRO,self::PAYMENT_TYPE_ROBOX);
		} elseif ($oPayment->getCurrencyId()==self::PAYMENT_CURRENCY_RUR) {
			$aCurrency=array(self::PAYMENT_TYPE_WM,self::PAYMENT_TYPE_LIQPAY,self::PAYMENT_TYPE_ROBOX);
		} elseif ($oPayment->getCurrencyId()==self::PAYMENT_CURRENCY_UAH) {
			$aCurrency=array(self::PAYMENT_TYPE_WM,self::PAYMENT_TYPE_LIQPAY);
		}
		if (Config::Get('plugin.payment.paypro.min_sum')>$oPayment->getSum()) {
			$aCurrency=array_diff($aCurrency, array(self::PAYMENT_TYPE_PAYPRO));
		}
		return array_intersect($aCurrency, Config::Get('plugin.payment.type'));
	}
	
	/**
	 * Проверка объекта платежа
	 * 
	 * @param string $sTargetType
	 * @param int $iTargetId
	 * @param int $iCheckType
	 */
	public function CheckTarget($sTargetType,$iTargetId,$iCheckType) {
		$sMethod = 'CheckTarget' . ucfirst ( $sTargetType );
		if (method_exists ( $this, $sMethod )) {
			return $this->$sMethod ( $iTargetId, $iCheckType );
		}
		return false;
	}
	
	/**
	 * Платеж завершен успешно, выполняется по инициативе сервера платежной системы сразу после покупки.
	 * Именно в этом методе нужно фиксировать факт оплаты
	 * Редиректы в данном методе не имеют смысла
	 * 
	 * @param PluginPayment_ModulePayment_EntityPaymentTarget $oPayment
	 */
	public function MakePaymentSuccess($oPayment) {
		if ($oTarget=$this->GetTargetByPaymentId($oPayment->getId())) {
			/**
			 * Проставляем статус связи объекту покупки
			 */
			$oTarget->setState(self::PAYMENT_TARGET_STATE_COMPLETE);
			$this->UpdateTarget($oTarget);
			$sMethod = 'MakePaymentSuccessTarget' . ucfirst ( $oTarget->getTargetType() );
			if (method_exists ( $this, $sMethod )) {
				return $this->$sMethod ( $oPayment, $oTarget );
			}
		}
		return true;
	}
	
	/**
	 * Информирование об успешном платеже - выполняется в момент редиректа пользователя после оплаты
	 * 
	 * @param PluginPayment_ModulePayment_EntityPaymentTarget $oPayment
	 */
	
	
	/**
	 * Информирование об несостоявшемся платеже - выполняется в момент редиректа пользователя после попытки оплаты
	 * 
	 * @param PluginPayment_ModulePayment_EntityPaymentTarget $oPayment
	 */
	public function ProcessPaymentFail($oPayment) {
		if ($oTarget=$this->GetTargetByPaymentId($oPayment->getId())) {
			$sMethod = 'ProcessPaymentFailTarget' . ucfirst ( $oTarget->getTargetType() );
			if (method_exists ( $this, $sMethod )) {
				return $this->$sMethod ( $oPayment, $oTarget );
			}
		}
		return true;
	}
	
	/**
	 * Проверка прав на оплату счета, если метода нет, то считаем платеж разрешенным
	 * 
	 * @param PluginPayment_ModulePayment_EntityPaymentTarget $oPayment
	 */
	public function CheckAccessForPayment($oPayment) {
		if ($oTarget=$this->GetTargetByPaymentId($oPayment->getId())) {
			$sMethod = 'CheckAccessForPaymentTarget' . ucfirst ( $oTarget->getTargetType() );
			if (method_exists ( $this, $sMethod )) {
				return $this->$sMethod ( $oPayment, $oTarget );
			}
		}
		return true;
	}
	
	/**
	 * Получает информацию об объекте покупки
	 * Возвращает ассоциативный массив с данными объекта, на данный момент поддерживаются поля 'name', 'payment_description'
	 * 
	 * @param string $sTargetType
	 * @param int $iTargetId
	 */
	public function GetTargetInfo($sTargetType,$iTargetId) {
		$aData=array(
			'name' => $this->Lang_Get('plugin.payment.payment_target_name_empty'),
		);
		$aReturn=array();
		$sMethod = 'GetTargetInfo' . ucfirst ( $sTargetType );
		if (method_exists ( $this, $sMethod )) {
			$aReturn=$this->$sMethod ( $iTargetId );
		}
		if (!is_array($aReturn)) {
			$aReturn=array();
		}
		$aReturn=array_merge($aData,$aReturn);
		if (!isset($aReturn['payment_description'])) {
			$aReturn['payment_description']=$aReturn['name'];
		}
		return array_merge($aData,$aReturn);
	}
	
	public function ConvertTo1251($sText) {
		if (function_exists('iconv')) {
			return @iconv('utf-8','windows-1251',$sText);
		}
		return $sText;
	}
	
	
	public function ResultWm() {
		/**
		 * Сначала проверяем правильность номера оплаты, ключа, суммы и кошелька
		 */
		if (!($oPayment=$this->GetPaymentById(getRequest('LMI_PAYMENT_NO',null,'post')))) {			
			return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_NUMBER,getRequest('LMI_PAYMENT_NO',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getKey()!=getRequest('key',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_KEY,array(getRequest('key',null,'post'),$oPayment));
		}
		if ($oPayment->getSum()!=getRequest('LMI_PAYMENT_AMOUNT',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_SUM,array(getRequest('LMI_PAYMENT_AMOUNT',null,'post'),$oPayment));
		}
		if (Config::Get('plugin.payment.wm.payee_purse')!=getRequest('LMI_PAYEE_PURSE',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_PURSE,array(Config::Get('plugin.payment.wm.payee_purse'),getRequest('LMI_PAYEE_PURSE',null,'post'),$oPayment));
		}
		/**
		 * Проверяем наличие предварительного запроса
		 */
		if ($oPayment->getState()!=self::PAYMENT_STATE_PRE) {
			return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_STATE,$oPayment);
		}
		/**
		 * Проверяем контрольную сумму
		 */
		$sCheckStr=getRequest('LMI_PAYEE_PURSE',null,'post').$oPayment->getSum().
					$oPayment->getId().getRequest('LMI_MODE',null,'post').getRequest('LMI_SYS_INVS_NO',null,'post').
					getRequest('LMI_SYS_TRANS_NO',null,'post').getRequest('LMI_SYS_TRANS_DATE',null,'post').
					Config::Get('plugin.payment.wm.secret_key').getRequest('LMI_PAYER_PURSE',null,'post').
					getRequest('LMI_PAYER_WM',null,'post');
		if (Config::Get('plugin.payment.wm.hash_method')=='md5') {
			if (strtoupper(md5($sCheckStr))!=getRequest('LMI_HASH',null,'post')) {
				return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_HASH,array($sCheckStr,getRequest('LMI_HASH',null,'post'),$oPayment));
			}
		} else {
			return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_HASH_METHOD,array(Config::Get('plugin.payment.wm.hash_method'),$oPayment));
		}
		/**
		 * Все проверки были успешными, добавляем запись о произошедшем платеже
		 */
		$oWm=Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentWm');
		$oWm->setLmiHash(getRequest('LMI_HASH',null,'post'));
		$oWm->setLmiMode(getRequest('LMI_MODE',null,'post'));
		$oWm->setLmiPayeePurse(getRequest('LMI_PAYEE_PURSE',null,'post'));
		$oWm->setLmiPayerPurse(getRequest('LMI_PAYER_PURSE',null,'post'));
		$oWm->setLmiPayerWm(getRequest('LMI_PAYER_WM',null,'post'));
		$oWm->setLmiPaymentAmount(getRequest('LMI_PAYMENT_AMOUNT',null,'post'));
		$oWm->setLmiSysInvsNo(getRequest('LMI_SYS_INVS_NO',null,'post'));
		$oWm->setLmiSysTransDate(getRequest('LMI_SYS_TRANS_DATE',null,'post'));
		$oWm->setLmiSysTransNo(getRequest('LMI_SYS_TRANS_NO',null,'post'));
		$oWm->setPaymentId($oPayment->getId());
		if ($this->AddWm($oWm)) {
			$oPayment->setState(self::PAYMENT_STATE_SOLD);
			$this->UpdatePayment($oPayment);
			return 0;
		}
		return $this->LogError(self::PAYMENT_ERROR_WM_RESULT_ADD,array($oWm,$oPayment));
	}
	
	public function PreResultWm() {
		/**
		 * Делаем предварительную проверку данных для оплаты
		 */
		if (getRequest('LMI_PREREQUEST',null,'post')!=1) {
			return $this->LogError(self::PAYMENT_ERROR_WM_PRERESULT_NO,getRequest('LMI_PREREQUEST',null,'post'));
		}
		if (!($oPayment=$this->GetPaymentById(getRequest('LMI_PAYMENT_NO',null,'post')))) {			
			return $this->LogError(self::PAYMENT_ERROR_WM_PRERESULT_NUMBER,getRequest('LMI_PAYMENT_NO',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getKey()!=getRequest('key',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_PRERESULT_KEY,array(getRequest('key',null,'post'),$oPayment));
		}
		if ($oPayment->getSum()!=getRequest('LMI_PAYMENT_AMOUNT',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_PRERESULT_SUM,array(getRequest('LMI_PAYMENT_AMOUNT',null,'post'),$oPayment));
		}
		if (Config::Get('plugin.payment.wm.payee_purse')!=getRequest('LMI_PAYEE_PURSE',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_PRERESULT_PURSE,array(Config::Get('plugin.payment.wm.payee_purse'),getRequest('LMI_PAYEE_PURSE',null,'post'),$oPayment));
		}
		/**
		 * Проверяем состояние нового платежа
		 */
		if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {
			return $this->LogError(self::PAYMENT_ERROR_WM_PRERESULT_STATE,$oPayment);
		}
		$oPayment->setState(self::PAYMENT_STATE_PRE);
		$this->UpdatePayment($oPayment);
		return 0;
	}
	
	
	public function SuccessWm() {		
		if (!($oPayment=$this->GetPaymentById(getRequest('LMI_PAYMENT_NO',null,'post')))) {			
			return $this->LogError(self::PAYMENT_ERROR_WM_SUCCESS_NUMBER,getRequest('LMI_PAYMENT_NO',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getKey()!=getRequest('key',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_SUCCESS_KEY,array(getRequest('key',null,'post'),$oPayment));
		}
		if ($oPayment->getState()!=self::PAYMENT_STATE_SOLD) {
			return $this->LogError(self::PAYMENT_ERROR_WM_SUCCESS_STATE,$oPayment);
		}
		if (!($oWm=$this->GetWmByPaymentId($oPayment->getId()))) {
			return $this->LogError(self::PAYMENT_ERROR_WM_SUCCESS_WM,$oPayment);
		}
		if ($oWm->getLmiSysInvsNo()!=getRequest('LMI_SYS_INVS_NO',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_SUCCESS_INVS_NO,array($oPayment,getRequest('LMI_SYS_INVS_NO',null,'post')));
		}
		if ($oWm->getLmiSysTransNo()!=getRequest('LMI_SYS_TRANS_NO',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_SUCCESS_TRANS_NO,array($oPayment,getRequest('LMI_SYS_TRANS_NO',null,'post')));
		}
		
		$oPayment->setState(self::PAYMENT_STATE_COMPLETE);
		$oPayment->setDateComplete(date("Y-m-d H:i:s"));
		$this->UpdatePayment($oPayment);
		return 0;
	}
	
	public function FailWm() {
		if (!($oPayment=$this->GetPaymentById(getRequest('LMI_PAYMENT_NO',null,'post')))) {			
			return $this->LogError(self::PAYMENT_ERROR_WM_FAIL_NUMBER,getRequest('LMI_PAYMENT_NO',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getKey()!=getRequest('key',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_WM_FAIL_KEY,array(getRequest('key',null,'post'),$oPayment));
		}
		if ($oPayment->getState()!=self::PAYMENT_STATE_PRE and $oPayment->getState()!=self::PAYMENT_STATE_NEW) {
			return $this->LogError(self::PAYMENT_ERROR_WM_FAIL_STATE,$oPayment);
		}
				
		$oPayment->setState(self::PAYMENT_STATE_FAILED);
		$oPayment->setDateComplete(date("Y-m-d H:i:s"));
		$this->UpdatePayment($oPayment);
		return 0;
	}
	
	
	public function ResultPaypro() {
		/**
		 * Проверяем IP процессинга PayPro
		 * 64.224.199.35 - 64.224.199.55
		 * 64.224.11.*
		 */
		$sIp=func_getIp();
		$aIp=explode('.',$sIp);		
		if ($aIp[0]==64 and $aIp[1]==224 and ($aIp[2]==11 or ($aIp[2]==199 and $aIp[3]>=35 and $aIp[3]<=55))) {
			// ok
		} else {
			return $this->LogError(self::PAYMENT_ERROR_PAYPRO_RESULT_IP,array($sIp,$_REQUEST));
		}
		/**
		 * Проверяем ключ
		 */
		if (!($oPayment=$this->GetPaymentByKey(getRequest('CUSTOM_FIELD1',null,'post')))) {
			return $this->LogError(self::PAYMENT_ERROR_PAYPRO_RESULT_KEY,getRequest('CUSTOM_FIELD1',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		/**
		 * Проверяем продукт
		 */
		if (getRequest('PRODUCT_ID',null,'post')!=Config::Get('plugin.payment.paypro.products')) {
			//return $this->LogError(self::PAYMENT_ERROR_PAYPRO_RESULT_PRODUCT_ID,getRequest('CUSTOM_FIELD1',null,'post'));
		}
		/**
		 * Проверяем стоимость
		 * $6.99
		 */
		$sPrice=trim(getRequest('UNIT_PRICE_IN_USD',null,'post'),'$');
		if ($oPayment->getSum()!=$sPrice) {
			return $this->LogError(self::PAYMENT_ERROR_PAYPRO_RESULT_SUM,array(getRequest('UNIT_PRICE_IN_USD',null,'post'),$oPayment));
		}
		
		if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {
			return $this->LogError(self::PAYMENT_ERROR_PAYPRO_RESULT_STATE,$oPayment);
		}
		
		if (getRequest('TEST_MODE',null,'post')==1) {
			return $this->LogError(self::PAYMENT_ERROR_PAYPRO_RESULT_TEST,$oPayment);
		}
		
		/**
		 * Все проверки были успешными, добавляем запись о произошедшем платеже
		 */
		$oPaypro=Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentPaypro',array(
			'payment_id' => $oPayment->getId(),
			'PAYMENT_METHOD_ID' => getRequest('PAYMENT_METHOD_ID',null,'post'),
			'ORDER_TIME' => date("Y-m-d H:i:s",strtotime(getRequest('ORDER_TIME',null,'post'))),
			'CUSTOMER_EMAIL' => getRequest('CUSTOMER_EMAIL',null,'post'),
			'COMPANY_NAME' => getRequest('COMPANY_NAME',null,'post'),
			'CUSTOMER_NAME' => getRequest('CUSTOMER_NAME',null,'post'),
			'CUSTOMER_FIRST_NAME' => getRequest('CUSTOMER_FIRST_NAME',null,'post'),
			'CUSTOMER_LAST_NAME' => getRequest('CUSTOMER_LAST_NAME',null,'post'),
			'CUSTOMER_PASSWORD' => getRequest('CUSTOMER_PASSWORD',null,'post'),
			'CUSTOMER_TITLE' => getRequest('CUSTOMER_TITLE',null,'post'),
			'CUSTOMER_STREET_ADDRESS' => getRequest('CUSTOMER_STREET_ADDRESS',null,'post'),
			'CUSTOMER_CITY' => getRequest('CUSTOMER_CITY',null,'post'),
			'CUSTOMER_ZIPCODE' => getRequest('CUSTOMER_ZIPCODE',null,'post'),
			'CUSTOMER_COUNTRY' => getRequest('CUSTOMER_COUNTRY',null,'post'),
			'CUSTOMER_STATE' => getRequest('CUSTOMER_STATE',null,'post'),
			'SHIPPING_FIRST_NAME' => getRequest('SHIPPING_FIRST_NAME',null,'post'),
			'SHIPPING_LAST_NAME' => getRequest('SHIPPING_LAST_NAME',null,'post'),
			'SHIPPING_STREET_ADDRESS' => getRequest('SHIPPING_STREET_ADDRESS',null,'post'),
			'SHIPPING_CITY' => getRequest('SHIPPING_CITY',null,'post'),
			'SHIPPING_STATE' => getRequest('SHIPPING_STATE',null,'post'),
			'SHIPPING_ZIPCODE' => getRequest('SHIPPING_ZIPCODE',null,'post'),
			'SHIPPING_COUNTRY' => getRequest('SHIPPING_COUNTRY',null,'post'),
			'PRODUCT_NAME' => getRequest('PRODUCT_NAME',null,'post'),
			'QUANTITY' => getRequest('QUANTITY',null,'post'),
			'PRODUCT_PRICE' => getRequest('PRODUCT_PRICE',null,'post'),
			'PRODUCT_PRICE_IN_USD' => getRequest('PRODUCT_PRICE_IN_USD',null,'post'),
			'COUPON_CODE' => getRequest('COUPON_CODE',null,'post'),
			'COUPON_ID' => getRequest('COUPON_ID',null,'post'),
			'COUPON_VALUE' => getRequest('COUPON_VALUE',null,'post'),
			'COUPON_VALUE_IN_USD' => getRequest('COUPON_VALUE_IN_USD',null,'post'),
			'CURRENCY' => getRequest('CURRENCY',null,'post'),
			'INVOICE_ID' => getRequest('INVOICE_ID',null,'post'),
			'ADD_CD' => getRequest('ADD_CD',null,'post'),
			'CUSTOMER_COUNTRY_CODE' => getRequest('CUSTOMER_COUNTRY_CODE',null,'post'),
			'SHIPPING_COUNTRY_CODE' => getRequest('SHIPPING_COUNTRY_CODE',null,'post'),
			'CUSTOMER_PHONE' => getRequest('CUSTOMER_PHONE',null,'post'),
			'ORDER_TOTAL' => getRequest('ORDER_TOTAL',null,'post'),
			'ORDER_TOTAL_IN_USD' => getRequest('ORDER_TOTAL_IN_USD',null,'post'),
			'IP_ADDRESS' => getRequest('IP_ADDRESS',null,'post'),
			'UNIT_PRICE' => getRequest('UNIT_PRICE',null,'post'),
			'UNIT_PRICE_IN_USD' => getRequest('UNIT_PRICE_IN_USD',null,'post'),
			'PRODUCT_TAG' => getRequest('PRODUCT_TAG',null,'post'),
			'PRODUCT_ID' => getRequest('PRODUCT_ID',null,'post'),
			'ADDONS' => getRequest('ADDONS',null,'post'),
			'CUSTOM_FIELD1' => getRequest('CUSTOM_FIELD1',null,'post'),
			'CUSTOM_FIELD2' => getRequest('CUSTOM_FIELD2',null,'post'),
			'CUSTOM_FIELD3' => getRequest('CUSTOM_FIELD3',null,'post'),
			'CUSTOM_FIELD4' => getRequest('CUSTOM_FIELD4',null,'post'),
			'CUSTOM_FIELD5' => getRequest('CUSTOM_FIELD5',null,'post'),
			'CUSTOM_FIELD6' => getRequest('CUSTOM_FIELD6',null,'post'),
			'CUSTOM_FIELD7' => getRequest('CUSTOM_FIELD7',null,'post'),
			'CUSTOM_FIELD8' => getRequest('CUSTOM_FIELD8',null,'post'),
			'CUSTOM_FIELD9' => getRequest('CUSTOM_FIELD9',null,'post'),
			'ORDER_ID' => getRequest('ORDER_ID',null,'post'),
			'SUBSCRIPTION_STATUS_ID' => getRequest('SUBSCRIPTION_STATUS_ID',null,'post'),
			'PRODUCT_PRICE_WITH_ADDONS' => getRequest('PRODUCT_PRICE_WITH_ADDONS',null,'post'),
			'PRODUCT_PRICE_WITH_ADDONS_IN_USD' => getRequest('PRODUCT_PRICE_WITH_ADDONS_IN_USD',null,'post'),
			'PRODUCT_PRICE_WITH_ADDONS_SELLER_PART' => getRequest('PRODUCT_PRICE_WITH_ADDONS_SELLER_PART',null,'post'),
			'PRODUCT_PRICE_WITH_ADDONS_SELLER_PART_IN_USD' => getRequest('PRODUCT_PRICE_WITH_ADDONS_SELLER_PART_IN_USD',null,'post'),
			'PRODUCT_LICENSES_LIST' => getRequest('PRODUCT_LICENSES_LIST',null,'post'),
			'PPG_EXTERNAL_CALL' => getRequest('PPG_EXTERNAL_CALL',null,'post'),
			'PAYPRO_GLOBAL' => getRequest('PAYPRO_GLOBAL',null,'post'),
			'TEST_MODE' => getRequest('TEST_MODE',null,'post'),
			'REQUEST_TYPE' => getRequest('REQUEST_TYPE',null,'post')
		));
		
		if ($this->AddPaypro($oPaypro)) {
			$oPayment->setState(self::PAYMENT_STATE_COMPLETE);
			$this->UpdatePayment($oPayment);
			return 0;
		}
		return $this->LogError(self::PAYMENT_ERROR_PAYPRO_RESULT_ADD,array($oPaypro,$oPayment));
		
	}
	
	
	public function ResultLiqpay() {
		/**
		 * Получаем XML
		 */
		if (!getRequest('operation_xml',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_XML);
		}
		if (!getRequest('signature',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_SIG);
		}
		$sXml=base64_decode(getRequest('operation_xml',null,'post'));		
		if (!($oXml=simplexml_load_string($sXml))) {
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_XML_PARSER);
		}
		if (!($oPayment=$this->GetPaymentById((string)$oXml->order_id))) {			
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_ORDER,(string)$oXml->order_id);
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getSum()!=(string)$oXml->amount) {
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_AMOUNT,array((string)$oXml->amount,$oPayment));
		}
		if ((string)$oXml->currency!='USD') {
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_CURRENCY,array((string)$oXml->currency,$oPayment));
		}
		/**
		 * Подпись
		 */
		$sSig=base64_encode(sha1(Config::Get('plugin.payment.liqpay.signature').$sXml.Config::Get('plugin.payment.liqpay.signature'),1));
		if ($sSig!=getRequest('signature',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_SIG,array($sSig,getRequest('signature',null,'post'),$oPayment));
		}
		/**
		 * Дополнительные данные
		 */
		$sAction=(string)$oXml->action;
		$sStatus=(string)$oXml->status;
		$sTransactionId=(string)$oXml->transaction_id;
		$sPayWay=(string)$oXml->pay_way;
		$sSenderPhone=(string)$oXml->sender_phone;
		/**
		 * Объект данных платежа liqpay, может быть null
		 */
		$oLiqpay=$this->GetLiqpayByPaymentId($oPayment->getId());
		
		$oLiqpayNew=Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentLiqpay');
		$oLiqpayNew->setPaymentId($oPayment->getId());
		$oLiqpayNew->setTransactionId($sTransactionId);
		$oLiqpayNew->setPayWay($sPayWay);
		$oLiqpayNew->setSenderPhone($sSenderPhone);
		/**
		 * Логика проверки статуса
		 */
		
		
		if ($sStatus=='success') {
			/**
			 * Может быть как от сервера, так и редирект
			 */
			if ($sAction=='server_url') {
				if ($oLiqpay) {
					/**
					 * Если статус платежа SOLD(был зарезервирован событияем 'wait_secure')
					 * то можно делать платеж завершенным
					 */
					if ($oPayment->getState()==self::PAYMENT_STATE_SOLD) {
						$oPayment->setState(self::PAYMENT_STATE_COMPLETE);
						$oPayment->setDateComplete(date("Y-m-d H:i:s"));
						$this->UpdatePayment($oPayment);						
						return array($sAction,'success');
						//return 0;
					} else {
						return array($sAction,'success_repeat');
						//return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_SOLD,array($sXml,$oPayment));
					}
				} else {
					/**
					 * Создаем платеж liqpay
					 */					
					if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {						
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW,array($sXml,$oPayment));
					}
					$this->AddLiqpay($oLiqpayNew);
					$oPayment->setState(self::PAYMENT_STATE_COMPLETE);
					$oPayment->setDateComplete(date("Y-m-d H:i:s"));
					$this->UpdatePayment($oPayment);
					return array($sAction,'success');
					//return 0;
				}
			} else {
				/**
				 * Редирект
				 */
				if ($oLiqpay) {
					if ($oPayment->getState()==self::PAYMENT_STATE_COMPLETE) {
						return array($sAction,'success_repeat');
					} else {
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_COMPLETE,array($sXml,$oPayment));
					}
				} else {
					if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {						
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW,array($sXml,$oPayment));
					}
					$this->AddLiqpay($oLiqpayNew);
					$oPayment->setState(self::PAYMENT_STATE_COMPLETE);
					$oPayment->setDateComplete(date("Y-m-d H:i:s"));
					$this->UpdatePayment($oPayment);
					return array($sAction,'success');
					//return 0;
				}
			}
			
			
			
			
		} elseif ($sStatus=='wait_secure') {
			if ($sAction=='server_url') {
				if ($oLiqpay) {
					return array($sAction,'wait_secure_repeat');
					//return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_SOLD_EXISTS,array($sXml,$oPayment));
				} else {
					if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {						
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW_FOR_SOLD,array($sXml,$oPayment));
					}
					$this->AddLiqpay($oLiqpayNew);
					$oPayment->setState(self::PAYMENT_STATE_SOLD);					
					$this->UpdatePayment($oPayment);
					return array($sAction,'wait_secure');
					//return 0;
				}
			} else {
				/**
				 * Редирект
				 */
				if ($oLiqpay) {
					return array($sAction,'wait_secure_repeat');
				} else {
					if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {						
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW_FOR_SOLD,array($sXml,$oPayment));
					}
					$this->AddLiqpay($oLiqpayNew);
					$oPayment->setState(self::PAYMENT_STATE_SOLD);					
					$this->UpdatePayment($oPayment);
					return array($sAction,'wait_secure');
					//return 0;
				}
			}
			
			
			
			
		} elseif ($sStatus=='failure') {
			if ($sAction=='server_url') {
				if ($oLiqpay) {
					if ($oPayment->getState()==self::PAYMENT_STATE_SOLD) {
						$oPayment->setState(self::PAYMENT_STATE_FAILED);
						$oPayment->setDateComplete(date("Y-m-d H:i:s"));
						$this->UpdatePayment($oPayment);
						return array($sAction,'failure');
						//return 0;
					} else {
						return array($sAction,'failure_repeat');
						//return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_SOLD_FOR_FAILED,array($sXml,$oPayment));
					}
				} else {
					if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {						
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW_FOR_FAILED,array($sXml,$oPayment));
					}
					$this->AddLiqpay($oLiqpayNew);
					$oPayment->setState(self::PAYMENT_STATE_FAILED);
					$oPayment->setDateComplete(date("Y-m-d H:i:s"));
					$this->UpdatePayment($oPayment);
					return array($sAction,'failure');
					//return 0;
				}
			} else {
				/**
				 * Редирект
				 */
				if ($oLiqpay) {
					if ($oPayment->getState()==self::PAYMENT_STATE_FAILED) {						
						return array($sAction,'failure_repeat');						
					} else {
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_COMPLETE,array($sXml,$oPayment));
					}
				} else {
					if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {						
						return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_NOT_NEW_FOR_FAILED,array($sXml,$oPayment));
					}
					$this->AddLiqpay($oLiqpayNew);
					$oPayment->setState(self::PAYMENT_STATE_FAILED);
					$oPayment->setDateComplete(date("Y-m-d H:i:s"));
					$this->UpdatePayment($oPayment);
					return array($sAction,'failure');
					//return 0;
				}
			}
			
						
			
		} else {
			return $this->LogError(self::PAYMENT_ERROR_LIQPAY_RESULT_ACTION,array($sXml,$oPayment));
		}
	}
	
	public function ResultRobox() {
		/**
		 * Сначала проверяем правильность номера оплаты, ключа, суммы и кошелька
		 */
		if (!($oPayment=$this->GetPaymentById(getRequest('InvId',null,'post')))) {			
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_RESULT_NUMBER,getRequest('InvId',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getKey()!=getRequest('shp_key',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_RESULT_KEY,array(getRequest('shp_key',null,'post'),$oPayment));
		}
		if ($oPayment->getSum()!=getRequest('OutSum',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_RESULT_SUM,array(getRequest('OutSum',null,'post'),$oPayment));
		}		
		/**
		 * Проверяем наличие предварительного запроса
		 */
		if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_RESULT_STATE,$oPayment);
		}		
		/**
		 * Проверяем контрольную сумму
		 */
		$sSig=md5(getRequest('OutSum',null,'post').":{$oPayment->getId()}:".Config::Get('plugin.payment.robox.password_2').":shp_key={$oPayment->getKey()}");
		if ($sSig!=strtolower(getRequest('SignatureValue',null,'post'))) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_RESULT_SIG,array($sSig,getRequest('SignatureValue',null,'post'),$oPayment));
		}
				
		/**
		 * Все проверки были успешными, добавляем запись о произошедшем платеже
		 */
		$oPayment->setState(self::PAYMENT_STATE_SOLD);
		$this->UpdatePayment($oPayment);
		return 0;
	}
	
	public function SuccessRobox() {		
		if (!($oPayment=$this->GetPaymentById(getRequest('InvId',null,'post')))) {			
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_SUCCESS_NUMBER,getRequest('InvId',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getKey()!=getRequest('shp_key',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_SUCCESS_KEY,array(getRequest('shp_key',null,'post'),$oPayment));
		}
		if ($oPayment->getSum()!=getRequest('OutSum',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_SUCCESS_SUM,array(getRequest('OutSum',null,'post'),$oPayment));
		}
		if ($oPayment->getState()!=self::PAYMENT_STATE_SOLD) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_SUCCESS_STATE,$oPayment);
		}		
		$sSig=md5(getRequest('OutSum',null,'post').":{$oPayment->getId()}:".Config::Get('plugin.payment.robox.password_1').":shp_key={$oPayment->getKey()}");
		if ($sSig!=strtolower(getRequest('SignatureValue',null,'post'))) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_SUCCESS_SIG,array($sSig,getRequest('SignatureValue',null,'post'),$oPayment));
		}
		
		$oPayment->setState(self::PAYMENT_STATE_COMPLETE);
		$oPayment->setDateComplete(date("Y-m-d H:i:s"));
		$this->UpdatePayment($oPayment);
		return 0;
	}
	
	public function FailRobox() {
		if (!($oPayment=$this->GetPaymentById(getRequest('InvId',null,'post')))) {			
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_FAIL_NUMBER,getRequest('InvId',null,'post'));
		}
		$this->oPaymentCurrent=$oPayment;
		if ($oPayment->getKey()!=getRequest('shp_key',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_FAIL_KEY,array(getRequest('shp_key',null,'post'),$oPayment));
		}
		if ($oPayment->getSum()!=getRequest('OutSum',null,'post')) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_FAIL_SUM,array(getRequest('OutSum',null,'post'),$oPayment));
		}
		if ($oPayment->getState()!=self::PAYMENT_STATE_NEW) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_FAIL_STATE,$oPayment);
		}
		$sSig=md5(getRequest('OutSum',null,'post').":{$oPayment->getId()}:".Config::Get('plugin.payment.robox.password_1').":shp_key={$oPayment->getKey()}");
		if ($sSig!=strtolower(getRequest('SignatureValue',null,'post'))) {
			return $this->LogError(self::PAYMENT_ERROR_ROBOX_FAIL_SIG,array($sSig,getRequest('SignatureValue',null,'post'),$oPayment));
		}
				
		//$oPayment->setState(self::PAYMENT_STATE_FAILED);
		//$oPayment->setDateComplete(date("Y-m-d H:i:s"));
		$this->UpdatePayment($oPayment);
		return 0;
	}
	
	public function PayProGetHash($fPrice,$sName) {
		$sHash = "";
		$s="price={$fPrice}^^^name={$sName}";
		$td = mcrypt_module_open('des', '', 'ecb', '');
		$ckey = Config::Get('plugin.payment.paypro.key');
		$iv = Config::Get('plugin.payment.paypro.key');
		mcrypt_generic_init($td, $ckey, $iv);
		$sHash = mcrypt_generic($td, $s);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return base64_encode($sHash);
	}
	
}
?>