<?php

/*
 * Описание настроек плагина для интерфейса редактирования
 */
$config['$config_scheme$'] = array(
    'type'               => array(
        'type'              => 'array',
        'name'              => 'Список разрешенных типов оплаты',
        'description'       => '',
        'show_as_php_array' => false,
        'validator'         => array(
            'type'   => 'Array',
            'params' => array(
                'min_items'      => 1,
                /*
                 * перечисление разрешенных элементов массива
                 */
                'enum'           => array(
                    'wm',
                    'liqpay',
                    'paypro',
                    'robox',
                    'master',
                    'w1'
                ),
                'item_validator' => array(
                    'type'   => 'String',
                    'params' => array(
                        'max'         => 100,
                        'integerOnly' => true,
                        'allowEmpty'  => false,
                    ),
                ),
                'allowEmpty'     => false,
            ),
        ),
    ),
    'wm.payee_purse_wmz' => array(
        'type'        => 'string',
        'name'        => 'WMZ кошелек продавца',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'wm.payee_purse_wmr' => array(
        'type'        => 'string',
        'name'        => 'WMR кошелек продавца',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'wm.payee_purse_wmu' => array(
        'type'        => 'string',
        'name'        => 'WMU кошелек продавца',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'wm.wmid'            => array(
        'type'        => 'string',
        'name'        => 'WMID  продавца',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'wm.secret_key'      => array(
        'type'        => 'string',
        'name'        => 'Секретный ключ, указывается в настройках WM Merchant Interface',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'wm.hash_method'     => array(
        'type'        => 'string',
        'name'        => 'Метод подсчета контрольной суммы',
        'description' => '',
        'validator'   => array(
            'type'   => 'Enum',
            'params' => array(
                'enum'       => array(
                    'sha256',
                    'md5',
                ),
                'allowEmpty' => false,
            ),
        ),
    ),
    'liqpay.merchant_id' => array(
        'type'        => 'string',
        'name'        => 'Merchant Id',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'liqpay.signature'   => array(
        'type'        => 'string',
        'name'        => 'Signature',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'paypro.key'         => array(
        'type'        => 'string',
        'name'        => 'Key',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'paypro.products'    => array(
        'type'        => 'string',
        'name'        => 'Номер продукта',
        'description' => 'У этого продукта должен быть прописан урл информирования о платеже: http://вашсайт/payment/paypro/notify/',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'paypro.min_sum'     => array(
        'type'        => 'string',
        'name'        => 'Минимальная сумма USD которую можно оплатить через PayPro',
        'description' => '',
        'validator'   => array(
            'type'        => 'Number',
            'integerOnly' => true,
            'params'      => array(),
        ),
    ),
    'robox.login'        => array(
        'type'        => 'string',
        'name'        => 'Login',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'robox.password_1'   => array(
        'type'        => 'string',
        'name'        => 'Password 1',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'robox.password_2'   => array(
        'type'        => 'string',
        'name'        => 'Password 2',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'master.mid'         => array(
        'type'        => 'string',
        'name'        => 'Уникальный идентификатор сайта',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'master.hash_method' => array(
        'type'        => 'string',
        'name'        => 'Метод подсчета контрольной суммы',
        'description' => '',
        'validator'   => array(
            'type'   => 'Enum',
            'params' => array(
                'enum'       => array(
                    'md5',
                ),
                'allowEmpty' => false,
            ),
        ),
    ),
    'master.secret_key'  => array(
        'type'        => 'string',
        'name'        => 'Секретный ключ',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'w1.merchant_id'     => array(
        'type'        => 'string',
        'name'        => 'Номер вашего кошелька',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
    'w1.signature'       => array(
        'type'        => 'string',
        'name'        => 'Signature',
        'description' => '',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(),
        ),
    ),
);


/**
 * Описание разделов для настроек
 * Каждый раздел группирует определенные параметры конфига
 */
$config['$config_sections$'] = array(
    /**
     * Настройки раздела
     */
    array(
        /**
         * Название раздела
         */
        'name'         => 'Оосновные',
        /**
         * Список параметров для отображения в разделе
         */
        'allowed_keys' => array(
            'type',
        ),
    ),
    array(
        'name'         => 'Webmoney',
        'allowed_keys' => array(
            'wm*',
        ),
    ),
    array(
        'name'         => 'LiqPay',
        'allowed_keys' => array(
            'liqpay*',
        ),
    ),
    array(
        'name'         => 'PayPro',
        'allowed_keys' => array(
            'paypro*',
        ),
    ),
    array(
        'name'         => 'Робокасса',
        'allowed_keys' => array(
            'robox*',
        ),
    ),
    array(
        'name'         => 'PayMaster',
        'allowed_keys' => array(
            'master*',
        ),
    ),
    array(
        'name'         => 'W1',
        'allowed_keys' => array(
            'w1*',
        ),
    ),
);

return $config;