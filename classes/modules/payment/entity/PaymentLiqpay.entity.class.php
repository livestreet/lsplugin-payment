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

class PluginPayment_ModulePayment_EntityPaymentLiqpay extends Entity 
{    
    public function getPaymentId() {
        return $this->_aData['payment_id'];
    } 
    public function getTransactionId() {
        return $this->_aData['transaction_id'];
    }
    public function getPayWay() {
        return $this->_aData['pay_way'];
    }
    public function getSenderPhone() {
        return $this->_aData['sender_phone'];
    }
   
           
     
    
	public function setPaymentId($data) {
        $this->_aData['payment_id']=$data;
    }   
    public function setTransactionId($data) {
        $this->_aData['transaction_id']=$data;
    } 
    public function setPayWay($data) {
        $this->_aData['pay_way']=$data;
    }
    public function setSenderPhone($data) {
        $this->_aData['sender_phone']=$data;
    }    
}
?>