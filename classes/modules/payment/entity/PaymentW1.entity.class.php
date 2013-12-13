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

class PluginPayment_ModulePayment_EntityPaymentW1 extends Entity
{    
    public function getPaymentId() {
        return $this->_aData['payment_id'];
    } 
    public function getWmiMerchantId() {
        return $this->_aData['WMI_MERCHANT_ID'];
    }
	public function getWmiPaymentAmount() {
		return $this->_aData['WMI_PAYMENT_AMOUNT'];
	}
	public function getWmiCurrencyId() {
		return $this->_aData['WMI_CURRENCY_ID'];
	}
	public function getWmiToUserId() {
		return $this->_aData['WMI_TO_USER_ID'];
	}
	public function getWmiPaymentNo() {
		return $this->_aData['WMI_PAYMENT_NO'];
	}
	public function getWmiOrderId() {
		return $this->_aData['WMI_ORDER_ID'];
	}
	public function getWmiCreateDate() {
		return $this->_aData['WMI_CREATE_DATE'];
	}
	public function getWmiUpdateDate() {
		return $this->_aData['WMI_UPDATE_DATE'];
	}



    
	public function setPaymentId($data) {
        $this->_aData['payment_id']=$data;
    }
	public function setWmiMerchantId($data) {
		$this->_aData['WMI_MERCHANT_ID']=$data;
	}
	public function setWmiPaymentAmount($data) {
		$this->_aData['WMI_PAYMENT_AMOUNT']=$data;
	}
	public function setWmiCurrencyId($data) {
		$this->_aData['WMI_CURRENCY_ID']=$data;
	}
	public function setWmiToUserId($data) {
		$this->_aData['WMI_TO_USER_ID']=$data;
	}
	public function setWmiPaymentNo($data) {
		$this->_aData['WMI_PAYMENT_NO']=$data;
	}
	public function setWmiOrderId($data) {
		$this->_aData['WMI_ORDER_ID']=$data;
	}
	public function setWmiCreateDate($data) {
		$this->_aData['WMI_CREATE_DATE']=$data;
	}
	public function setWmiUpdateDate($data) {
		$this->_aData['WMI_UPDATE_DATE']=$data;
	}
}
?>