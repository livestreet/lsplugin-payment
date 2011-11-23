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

$config['table']['payment']             = '___db.table.prefix___'.'payment';
$config['table']['payment_wm']          = '___db.table.prefix___'.'payment_wm';
$config['table']['payment_liqpay']          = '___db.table.prefix___'.'payment_liqpay';
$config['table']['payment_paypro']          = '___db.table.prefix___'.'payment_paypro';
$config['table']['payment_currency']    = '___db.table.prefix___'.'payment_currency';
$config['table']['payment_target']    = '___db.table.prefix___'.'payment_target';

Config::Set('router.page.payment', 'PluginPayment_ActionPayment');


$config['type']=array('wm','liqpay','paypro','robox'); // список разрешенных типов оплаты
$config['logs']['access']='payment_access.log'; // null либо имя файла для лога доступа
$config['logs']['error']='payment_error.log'; // null либо имя файла для лога ошибок

$config['wm']['payee_purse_wmz']=''; // WMZ кошелек продавца, активируется в настройках WM Merchant Interface
$config['wm']['payee_purse_wmr']=''; // WMR кошелек продавца, активируется в настройках WM Merchant Interface
$config['wm']['payee_purse_wmu']=''; // WMU кошелек продавца, активируется в настройках WM Merchant Interface
$config['wm']['wmid']=''; // WMID  продавца
$config['wm']['secret_key']=''; // Секретный ключ, указывается в настройках WM Merchant Interface
$config['wm']['hash_method']='md5'; // Метод подсчета контрольной суммы, на данный момент поддерживается только "md5", указывается в настройках WM Merchant Interface

$config['liqpay']['merchant_id']='';
$config['liqpay']['signature']='';

$config['paypro']['key']='';
$config['paypro']['products']='';
$config['paypro']['min_sum']=10; // Минимальная сумма USD которую можно оплатить через PayPro

$config['robox']['login']='';
$config['robox']['password_1']='';
$config['robox']['password_2']='';

return $config;
?>