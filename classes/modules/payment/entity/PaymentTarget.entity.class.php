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

class PluginPayment_ModulePayment_EntityPaymentTarget extends Entity {    
    
	/**
	 * Возвращает название объекта покупки (товара)
	 */
	public function getTargetName() {
		$aData=$this->PluginPayment_Payment_GetTargetInfo($this->getTargetType(),$this->getTargetId());
		return $aData['name'];
	}
	
	/**
	 * Возвращает описание товара, которое указывается на странице оплаты платежной системы
	 */
	public function getTargetPaymentDescription() {
		$aData=$this->PluginPayment_Payment_GetTargetInfo($this->getTargetType(),$this->getTargetId());
		return $aData['payment_description'];
	}
}
?>