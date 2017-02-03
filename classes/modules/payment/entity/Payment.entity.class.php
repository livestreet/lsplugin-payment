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

class PluginPayment_ModulePayment_EntityPayment extends Entity
{
    public function getId()
    {
        return $this->_aData['id'];
    }

    public function getKey()
    {
        return $this->_aData['key'];
    }

    public function getType()
    {
        return $this->_aData['type'];
    }

    public function getSum()
    {
        return $this->_aData['sum'];
    }

    public function getCurrencyId()
    {
        return $this->_aData['currency_id'];
    }

    public function getDateAdd()
    {
        return $this->_aData['date_add'];
    }

    public function getDateComplete()
    {
        return $this->_aData['date_complete'];
    }

    public function getState()
    {
        return $this->_aData['state'];
    }

    public function getIp()
    {
        return $this->_aData['ip'];
    }


    public function getCurrencyName()
    {
        if ($oCurrency = $this->PluginPayment_Payment_GetCurrencyById($this->getCurrencyId())) {
            return $oCurrency->getName();
        }
        return null;
    }


    public function setId($data)
    {
        $this->_aData['id'] = $data;
    }

    public function setKey($data)
    {
        $this->_aData['key'] = $data;
    }

    public function setType($data)
    {
        $this->_aData['type'] = $data;
    }

    public function setSum($data)
    {
        $this->_aData['sum'] = $data;
    }

    public function setCurrencyId($data)
    {
        $this->_aData['currency_id'] = $data;
    }

    public function setDateAdd($data)
    {
        $this->_aData['date_add'] = $data;
    }

    public function setDateComplete($data)
    {
        $this->_aData['date_complete'] = $data;
    }

    public function setState($data)
    {
        $this->_aData['state'] = $data;
    }

    public function setIp($data)
    {
        $this->_aData['ip'] = $data;
    }

}

?>