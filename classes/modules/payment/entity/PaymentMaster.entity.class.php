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

class PluginPayment_ModulePayment_EntityPaymentMaster extends Entity
{    
    public function getPaymentId() {
        return $this->_aData['payment_id'];
    } 
    public function getLmiMerchantId() {
        return $this->_aData['LMI_MERCHANT_ID'];
    }
	public function getLmiPaymentNo() {
		return $this->_aData['LMI_PAYMENT_NO'];
	}
	public function getLmiSysPaymentId() {
		return $this->_aData['LMI_SYS_PAYMENT_ID'];
	}
	public function getLmiSysPaymentDate() {
		return $this->_aData['LMI_SYS_PAYMENT_DATE'];
	}
	public function getLmiPaymentAmount() {
		return $this->_aData['LMI_PAYMENT_AMOUNT'];
	}
	public function getLmiCurrency() {
		return $this->_aData['LMI_CURRENCY'];
	}
	public function getLmiPaidAmount() {
		return $this->_aData['LMI_PAID_AMOUNT'];
	}
	public function getLmiPaidCurrency() {
		return $this->_aData['LMI_PAID_CURRENCY'];
	}
	public function getLmiPaymentSystem() {
		return $this->_aData['LMI_PAYMENT_SYSTEM'];
	}
	public function getLmiSimMode() {
		return $this->_aData['LMI_SIM_MODE'];
	}
	public function getLmiPaymentDesc() {
		return $this->_aData['LMI_PAYMENT_DESC'];
	}

           
     
    
	public function setPaymentId($data) {
        $this->_aData['payment_id']=$data;
    }   
    public function setLmiMerchantId($data) {
        $this->_aData['LMI_MERCHANT_ID']=$data;
    }
	public function setLmiPaymentNo($data) {
		$this->_aData['LMI_PAYMENT_NO']=$data;
	}
	public function setLmiSysPaymentId($data) {
		$this->_aData['LMI_SYS_PAYMENT_ID']=$data;
	}
	public function setLmiSysPaymentDate($data) {
		$this->_aData['LMI_SYS_PAYMENT_DATE']=$data;
	}
	public function setLmiPaymentAmount($data) {
		$this->_aData['LMI_PAYMENT_AMOUNT']=$data;
	}
	public function setLmiCurrency($data) {
		$this->_aData['LMI_CURRENCY']=$data;
	}
	public function setLmiPaidAmount($data) {
		$this->_aData['LMI_PAID_AMOUNT']=$data;
	}
	public function setLmiPaidCurrency($data) {
		$this->_aData['LMI_PAID_CURRENCY']=$data;
	}
	public function setLmiPaymentSystem($data) {
		$this->_aData['LMI_PAYMENT_SYSTEM']=$data;
	}
	public function setLmiSimMode($data) {
		$this->_aData['LMI_SIM_MODE']=$data;
	}
	public function setLmiPaymentDesc($data) {
		$this->_aData['LMI_PAYMENT_DESC']=$data;
	}
}
?>