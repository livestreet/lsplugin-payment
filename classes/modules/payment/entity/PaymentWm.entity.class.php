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

class PluginPayment_ModulePayment_EntityPaymentWm extends Entity 
{    
    public function getPaymentId() {
        return $this->_aData['payment_id'];
    } 
    public function getLmiPayeePurse() {
        return $this->_aData['LMI_PAYEE_PURSE'];
    }
    public function getLmiPaymentAmount() {
        return $this->_aData['LMI_PAYMENT_AMOUNT'];
    }
    public function getLmiMode() {
        return $this->_aData['LMI_MODE'];
    }
    public function getLmiSysInvsNo() {
        return $this->_aData['LMI_SYS_INVS_NO'];
    }
    public function getLmiSysTransNo() {
        return $this->_aData['LMI_SYS_TRANS_NO'];
    }
    public function getLmiPayerPurse() {
        return $this->_aData['LMI_PAYER_PURSE'];
    }
    public function getLmiPayerWm() {
        return $this->_aData['LMI_PAYER_WM'];
    }
    public function getLmiHash() {
        return $this->_aData['LMI_HASH'];
    }
    public function getLmiSysTransDate() {
        return $this->_aData['LMI_SYS_TRANS_DATE'];
    }
           
     
    
	public function setPaymentId($data) {
        $this->_aData['payment_id']=$data;
    }   
    public function setLmiPayeePurse($data) {
        $this->_aData['LMI_PAYEE_PURSE']=$data;
    } 
    public function setLmiPaymentAmount($data) {
        $this->_aData['LMI_PAYMENT_AMOUNT']=$data;
    }
    public function setLmiMode($data) {
        $this->_aData['LMI_MODE']=$data;
    }
    public function setLmiSysInvsNo($data) {
        $this->_aData['LMI_SYS_INVS_NO']=$data;
    }
    public function setLmiSysTransNo($data) {
        $this->_aData['LMI_SYS_TRANS_NO']=$data;
    }
    public function setLmiPayerPurse($data) {
        $this->_aData['LMI_PAYER_PURSE']=$data;
    }
    public function setLmiPayerWm($data) {
        $this->_aData['LMI_PAYER_WM']=$data;
    }
    public function setLmiHash($data) {
        $this->_aData['LMI_HASH']=$data;
    }
    public function setLmiSysTransDate($data) {
        $this->_aData['LMI_SYS_TRANS_DATE']=$data;
    }   
}
?>