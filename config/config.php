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
$config['table']['payment_w1']          = '___db.table.prefix___'.'payment_w1';
$config['table']['payment_master']          = '___db.table.prefix___'.'payment_master';
$config['table']['payment_liqpay']          = '___db.table.prefix___'.'payment_liqpay';
$config['table']['payment_paypro']          = '___db.table.prefix___'.'payment_paypro';
$config['table']['payment_paypal']          = '___db.table.prefix___'.'payment_paypal';
$config['table']['payment_currency']    = '___db.table.prefix___'.'payment_currency';
$config['table']['payment_target']    = '___db.table.prefix___'.'payment_target';

Config::Set('router.page.payment', 'PluginPayment_ActionPayment');


$config['type']=array('wm','liqpay','paypro','robox','master','w1','paypal'); // список разрешенных типов оплаты
$config['logs']['access']='payment_access.log'; // null либо имя файла для лога доступа
$config['logs']['error']='payment_error.log'; // null либо имя файла для лога ошибок

/**
 * Настройка Webmoney
 */
$config['wm']['payee_purse_wmz']=''; // WMZ кошелек продавца, активируется в настройках WM Merchant Interface
$config['wm']['payee_purse_wmr']=''; // WMR кошелек продавца, активируется в настройках WM Merchant Interface
$config['wm']['payee_purse_wmu']=''; // WMU кошелек продавца, активируется в настройках WM Merchant Interface
$config['wm']['wmid']=''; // WMID  продавца
$config['wm']['secret_key']=''; // Секретный ключ, указывается в настройках WM Merchant Interface
$config['wm']['hash_method']='sha256'; // Метод подсчета контрольной суммы, на данный момент поддерживается только "md5" и "sha256", указывается в настройках WM Merchant Interface

/**
 * Настройка LiqPay
 */
$config['liqpay']['merchant_id']='';
$config['liqpay']['signature']='';

/**
 * Настройки PayPro
 */
$config['paypro']['key']='';
$config['paypro']['products']=''; // Номер продукта, у этого продукта должен быть прописан урл информирования о платеже: http://вашсайт/payment/paypro/notify/
$config['paypro']['min_sum']=10; // Минимальная сумма USD которую можно оплатить через PayPro

/**
 * В настройках робокассы необходимо прописать слудующие урлы:
 * result: http://вашсайт/payment/robox/result/
 * success: http://вашсайт/payment/robox/success/
 * fail: http://вашсайт/payment/robox/fail/
 */
$config['robox']['login']='';
$config['robox']['password_1']='';
$config['robox']['password_2']='';

/**
 * Настройки процессинга PayMaster
 */
$config['master']['mid']=''; // Уникальный идентификатор сайта
$config['master']['hash_method']='md5'; // Метод подсчета контрольной суммы, на данный момент поддерживается только "md5"
$config['master']['secret_key']=''; // Секретный ключ
$config['master']['testing']=true; // При переходе в РАБОЧИЙ режим(в интерфейсе мерчанта), необходимо сменить значение на false

/**
 * Настройки Единого кошелька
 * В настройках магазина в интерфейсе Единого кошелька необходимо прописать "Адрес для оповещений":
 * http://вашсайт/payment/w1/result/
 *
 * Алгоритм шифрования нежно выбрать MD5
 */
$config['w1']['merchant_id']=''; // Номер вашего кошелька
$config['w1']['signature']='';

/**
 * Настройка PayPal
 * IPN URL: http://вашсайт/payment/paypal/result/
 */
$config['paypal']['mail']=''; // Ваш емайл продавца в PayPal
$config['paypal']['locale']='RU'; // Код страны, к которой привязаны платежи

return $config;