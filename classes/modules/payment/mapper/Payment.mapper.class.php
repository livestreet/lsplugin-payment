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

class PluginPayment_ModulePayment_MapperPayment extends Mapper {	
	
	public function AddPayment($oPayment) {
		$sql = "INSERT INTO ".Config::Get('plugin.payment.table.payment')." 
			SET `key`=?, `type`=?, `sum`=?f, currency_id=?, date_add=?, `ip`=?, `state`=?
		";			
		if ($iId=$this->oDb->query($sql,$oPayment->getKey(),$oPayment->getType(),$oPayment->getSum(),$oPayment->getCurrencyId(),$oPayment->getDateAdd(),$oPayment->getIp(),$oPayment->getState())) 
		{
			return $iId;
		}		
		return false;
	}
	
	public function UpdatePayment($oPayment) {
		$sql = "UPDATE ".Config::Get('plugin.payment.table.payment')." 
			SET date_complete = ?, `state` = ? 		
			WHERE id = ?d
		";			
		if ($this->oDb->query($sql,$oPayment->getDateComplete(),$oPayment->getState(),$oPayment->getId())) {
			return true;
		}		
		return false;
	}
			
	public function GetPaymentById($sId) {
		$sql = "SELECT * FROM ".Config::Get('plugin.payment.table.payment')." WHERE id = ? ";
		if ($aRow=$this->oDb->selectRow($sql,$sId)) {
			return Engine::GetEntity('PluginPayment_ModulePayment_EntityPayment',$aRow);
		}
		return null;
	}
	
	public function GetPaymentByKey($sKey) {
		$sql = "SELECT * FROM ".Config::Get('plugin.payment.table.payment')." WHERE `key` = ? ";
		if ($aRow=$this->oDb->selectRow($sql,$sKey)) {
			return Engine::GetEntity('PluginPayment_ModulePayment_EntityPayment',$aRow);
		}
		return null;
	}
	
	public function GetWmByPaymentId($sId) {
		$sql = "SELECT * FROM ".Config::Get('plugin.payment.table.payment_wm')." WHERE payment_id = ? ";
		if ($aRow=$this->oDb->selectRow($sql,$sId)) {
			return Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentWm',$aRow);
		}
		return null;
	}
	
	public function GetCurrencyById($sId) {
		$sql = "SELECT * FROM ".Config::Get('plugin.payment.table.payment_currency')." WHERE id = ? ";
		if ($aRow=$this->oDb->selectRow($sql,$sId)) {
			return Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentCurrency',$aRow);
		}
		return null;
	}
	
	public function AddWm($oWm) {
		$sql = "INSERT INTO ".Config::Get('plugin.payment.table.payment_wm')." 
			SET payment_id=?, LMI_PAYEE_PURSE=?, LMI_PAYMENT_AMOUNT=?, LMI_MODE=?, LMI_SYS_INVS_NO=?, LMI_SYS_TRANS_NO=?,  
				LMI_PAYER_PURSE=?, LMI_PAYER_WM=?, LMI_HASH=?, LMI_SYS_TRANS_DATE=?
		";			
		if ($this->oDb->query($sql,$oWm->getPaymentId(),$oWm->getLmiPayeePurse(),$oWm->getLmiPaymentAmount(),$oWm->getLmiMode(),$oWm->getLmiSysInvsNo(),
				$oWm->getLmiSysTransNo(),$oWm->getLmiPayerPurse(),$oWm->getLmiPayerWm(),$oWm->getLmiHash(),$oWm->getLmiSysTransDate())===0) 
		{
			return true;
		}		
		return false;
	}
	
	public function AddLiqpay($oLiqpay) {
		$sql = "INSERT INTO ".Config::Get('plugin.payment.table.payment_liqpay')." 
			SET payment_id=?, transaction_id=?, pay_way=?, sender_phone=? 
		";			
		if ($this->oDb->query($sql,$oLiqpay->getPaymentId(),$oLiqpay->getTransactionId(),$oLiqpay->getPayWay(),$oLiqpay->getSenderPhone())===0) 
		{
			return true;
		}		
		return false;
	}
	
	public function GetLiqpayByPaymentId($sId) {
		$sql = "SELECT * FROM ".Config::Get('plugin.payment.table.payment_liqpay')." WHERE payment_id = ? ";
		if ($aRow=$this->oDb->selectRow($sql,$sId)) {
			return Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentLiqpay',$aRow);
		}
		return null;
	}
	
	public function AddPaypro($oPaypro) {
		$sql = "INSERT INTO ".Config::Get('plugin.payment.table.payment_paypro')." SET ?a ";			
		if ($this->oDb->query($sql,$oPaypro->_getData())===0) {
			return true;
		}		
		return false;
	}
	
	public function AddTarget($oTarget) {
		$sql = "INSERT INTO ".Config::Get('plugin.payment.table.payment_target')." 
			SET payment_id=?d, target_id=?d, target_type=?
		";			
		if ($this->oDb->query($sql,$oTarget->getPaymentId(),$oTarget->getTargetId(),$oTarget->getTargetType())===0) 
		{
			return true;
		}		
		return false;
	}
	
	public function UpdateTarget($oTarget) {
		$sql = "UPDATE ".Config::Get('plugin.payment.table.payment_target')." 
			SET state=?d WHERE payment_id = ?d
		";			
		return $this->oDb->query($sql,$oTarget->getState(),$oTarget->getPaymentId());
	}
	
	public function GetTargetByPaymentId($sId) {
		$sql = "SELECT * FROM ".Config::Get('plugin.payment.table.payment_target')." WHERE payment_id = ? ";
		if ($aRow=$this->oDb->selectRow($sql,$sId)) {
			return Engine::GetEntity('PluginPayment_ModulePayment_EntityPaymentTarget',$aRow);
		}
		return null;
	}
}
?>