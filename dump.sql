-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 16 2015 г., 17:13
-- Версия сервера: 5.5.39
-- Версия PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `payment`
--

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment`
--

CREATE TABLE IF NOT EXISTS `prefix_payment` (
`id` int(11) NOT NULL,
  `key` varchar(32) NOT NULL,
  `type` enum('wm','paypal','liqpay','paypro','robox','master','w1') DEFAULT NULL,
  `sum` float(9,2) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_complete` datetime DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_currency`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_currency` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prefix_payment_currency`
--

INSERT INTO `prefix_payment_currency` (`id`, `name`) VALUES
(1, 'USD'),
(2, 'RUR'),
(3, 'UAH');

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_liqpay`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_liqpay` (
  `payment_id` int(11) NOT NULL,
  `transaction_id` varchar(500) NOT NULL,
  `pay_way` varchar(50) NOT NULL,
  `sender_phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_master`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_master` (
  `payment_id` int(11) NOT NULL,
  `LMI_MERCHANT_ID` varchar(50) NOT NULL,
  `LMI_PAYMENT_NO` varchar(50) NOT NULL,
  `LMI_SYS_PAYMENT_ID` varchar(50) NOT NULL,
  `LMI_SYS_PAYMENT_DATE` varchar(50) NOT NULL,
  `LMI_PAYMENT_AMOUNT` varchar(50) NOT NULL,
  `LMI_CURRENCY` varchar(50) NOT NULL,
  `LMI_PAID_AMOUNT` varchar(50) NOT NULL,
  `LMI_PAID_CURRENCY` varchar(50) NOT NULL,
  `LMI_PAYMENT_SYSTEM` varchar(50) NOT NULL,
  `LMI_SIM_MODE` varchar(50) NOT NULL,
  `LMI_PAYMENT_DESC` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_paypal`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_paypal` (
  `payment_id` int(11) NOT NULL,
  `mc_gross` varchar(50) NOT NULL,
  `payer_id` varchar(50) NOT NULL,
  `tax` varchar(50) NOT NULL,
  `payment_date` varchar(100) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `mc_fee` varchar(50) NOT NULL,
  `custom` varchar(250) NOT NULL,
  `payer_status` varchar(50) NOT NULL,
  `business` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `verify_sign` varchar(250) NOT NULL,
  `payer_email` varchar(250) NOT NULL,
  `txn_id` varchar(50) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `receiver_email` varchar(250) NOT NULL,
  `receiver_id` varchar(50) NOT NULL,
  `txn_type` varchar(50) NOT NULL,
  `mc_currency` varchar(10) NOT NULL,
  `residence_country` varchar(10) NOT NULL,
  `ipn_track_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_paypro`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_paypro` (
  `payment_id` int(11) NOT NULL,
  `PAYMENT_METHOD_ID` int(11) NOT NULL,
  `ORDER_TIME` datetime NOT NULL,
  `CUSTOMER_EMAIL` varchar(250) NOT NULL,
  `COMPANY_NAME` varchar(250) NOT NULL,
  `CUSTOMER_NAME` varchar(250) NOT NULL,
  `CUSTOMER_FIRST_NAME` varchar(250) NOT NULL,
  `CUSTOMER_LAST_NAME` varchar(250) NOT NULL,
  `CUSTOMER_PASSWORD` varchar(250) NOT NULL,
  `CUSTOMER_TITLE` varchar(250) NOT NULL,
  `CUSTOMER_STREET_ADDRESS` varchar(250) NOT NULL,
  `CUSTOMER_CITY` varchar(250) NOT NULL,
  `CUSTOMER_ZIPCODE` varchar(250) NOT NULL,
  `CUSTOMER_COUNTRY` varchar(250) NOT NULL,
  `CUSTOMER_STATE` varchar(250) NOT NULL,
  `SHIPPING_FIRST_NAME` varchar(250) NOT NULL,
  `SHIPPING_LAST_NAME` varchar(250) NOT NULL,
  `SHIPPING_STREET_ADDRESS` varchar(250) NOT NULL,
  `SHIPPING_CITY` varchar(250) NOT NULL,
  `SHIPPING_STATE` varchar(250) NOT NULL,
  `SHIPPING_ZIPCODE` varchar(250) NOT NULL,
  `SHIPPING_COUNTRY` varchar(250) NOT NULL,
  `PRODUCT_NAME` varchar(250) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `PRODUCT_PRICE` varchar(250) NOT NULL,
  `PRODUCT_PRICE_IN_USD` varchar(250) NOT NULL,
  `COUPON_CODE` varchar(250) NOT NULL,
  `COUPON_ID` varchar(250) NOT NULL,
  `COUPON_VALUE` varchar(250) NOT NULL,
  `COUPON_VALUE_IN_USD` varchar(250) NOT NULL,
  `CURRENCY` varchar(250) NOT NULL,
  `INVOICE_ID` varchar(250) NOT NULL,
  `ADD_CD` varchar(250) NOT NULL,
  `CUSTOMER_COUNTRY_CODE` varchar(250) NOT NULL,
  `SHIPPING_COUNTRY_CODE` varchar(250) NOT NULL,
  `CUSTOMER_PHONE` varchar(250) NOT NULL,
  `ORDER_TOTAL` varchar(250) NOT NULL,
  `ORDER_TOTAL_IN_USD` varchar(250) NOT NULL,
  `IP_ADDRESS` varchar(250) NOT NULL,
  `UNIT_PRICE` varchar(250) NOT NULL,
  `UNIT_PRICE_IN_USD` varchar(250) NOT NULL,
  `PRODUCT_TAG` varchar(250) NOT NULL,
  `PRODUCT_ID` varchar(250) NOT NULL,
  `ADDONS` varchar(250) NOT NULL,
  `CUSTOM_FIELD1` varchar(250) NOT NULL,
  `CUSTOM_FIELD2` varchar(250) NOT NULL,
  `CUSTOM_FIELD3` varchar(250) NOT NULL,
  `CUSTOM_FIELD4` varchar(250) NOT NULL,
  `CUSTOM_FIELD5` varchar(250) NOT NULL,
  `CUSTOM_FIELD6` varchar(250) NOT NULL,
  `CUSTOM_FIELD7` varchar(250) NOT NULL,
  `CUSTOM_FIELD8` varchar(250) NOT NULL,
  `CUSTOM_FIELD9` varchar(250) NOT NULL,
  `ORDER_ID` int(11) NOT NULL,
  `SUBSCRIPTION_STATUS_ID` varchar(250) NOT NULL,
  `PRODUCT_PRICE_WITH_ADDONS` varchar(250) NOT NULL,
  `PRODUCT_PRICE_WITH_ADDONS_IN_USD` varchar(250) NOT NULL,
  `PRODUCT_PRICE_WITH_ADDONS_SELLER_PART` varchar(250) NOT NULL,
  `PRODUCT_PRICE_WITH_ADDONS_SELLER_PART_IN_USD` varchar(250) NOT NULL,
  `PRODUCT_LICENSES_LIST` varchar(250) NOT NULL,
  `PPG_EXTERNAL_CALL` varchar(250) NOT NULL,
  `PAYPRO_GLOBAL` varchar(250) NOT NULL,
  `TEST_MODE` varchar(250) NOT NULL,
  `REQUEST_TYPE` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_target`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_target` (
  `payment_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_type` varchar(20) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_w1`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_w1` (
  `payment_id` int(11) NOT NULL,
  `WMI_MERCHANT_ID` varchar(50) CHARACTER SET latin1 NOT NULL,
  `WMI_PAYMENT_AMOUNT` varchar(50) CHARACTER SET latin1 NOT NULL,
  `WMI_CURRENCY_ID` varchar(50) CHARACTER SET latin1 NOT NULL,
  `WMI_TO_USER_ID` varchar(50) CHARACTER SET latin1 NOT NULL,
  `WMI_PAYMENT_NO` varchar(50) CHARACTER SET latin1 NOT NULL,
  `WMI_ORDER_ID` varchar(50) CHARACTER SET latin1 NOT NULL,
  `WMI_CREATE_DATE` varchar(50) CHARACTER SET latin1 NOT NULL,
  `WMI_UPDATE_DATE` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_payment_wm`
--

CREATE TABLE IF NOT EXISTS `prefix_payment_wm` (
  `payment_id` int(11) NOT NULL,
  `LMI_PAYEE_PURSE` varchar(15) NOT NULL,
  `LMI_PAYMENT_AMOUNT` float(9,2) NOT NULL,
  `LMI_MODE` tinyint(1) NOT NULL,
  `LMI_SYS_INVS_NO` int(11) NOT NULL,
  `LMI_SYS_TRANS_NO` int(11) NOT NULL,
  `LMI_PAYER_PURSE` varchar(15) NOT NULL,
  `LMI_PAYER_WM` varchar(15) NOT NULL,
  `LMI_HASH` varchar(32) NOT NULL,
  `LMI_SYS_TRANS_DATE` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prefix_payment`
--
ALTER TABLE `prefix_payment`
 ADD PRIMARY KEY (`id`), ADD KEY `currency_id` (`currency_id`);

--
-- Indexes for table `prefix_payment_currency`
--
ALTER TABLE `prefix_payment_currency`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prefix_payment_liqpay`
--
ALTER TABLE `prefix_payment_liqpay`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `prefix_payment_master`
--
ALTER TABLE `prefix_payment_master`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `prefix_payment_paypal`
--
ALTER TABLE `prefix_payment_paypal`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `prefix_payment_paypro`
--
ALTER TABLE `prefix_payment_paypro`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `prefix_payment_target`
--
ALTER TABLE `prefix_payment_target`
 ADD PRIMARY KEY (`payment_id`), ADD KEY `target_id` (`target_id`,`target_type`), ADD KEY `state` (`state`), ADD KEY `target_type` (`target_type`);

--
-- Indexes for table `prefix_payment_w1`
--
ALTER TABLE `prefix_payment_w1`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `prefix_payment_wm`
--
ALTER TABLE `prefix_payment_wm`
 ADD PRIMARY KEY (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prefix_payment`
--
ALTER TABLE `prefix_payment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prefix_payment_currency`
--
ALTER TABLE `prefix_payment_currency`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `prefix_payment_liqpay`
--
ALTER TABLE `prefix_payment_liqpay`
ADD CONSTRAINT `prefix_payment_liqpay_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `prefix_payment_master`
--
ALTER TABLE `prefix_payment_master`
ADD CONSTRAINT `prefix_payment_master_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `prefix_payment_paypro`
--
ALTER TABLE `prefix_payment_paypro`
ADD CONSTRAINT `prefix_payment_paypro_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `prefix_payment_target`
--
ALTER TABLE `prefix_payment_target`
ADD CONSTRAINT `prefix_payment_target_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `prefix_payment_w1`
--
ALTER TABLE `prefix_payment_w1`
ADD CONSTRAINT `prefix_payment_w1_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `prefix_payment_wm`
--
ALTER TABLE `prefix_payment_wm`
ADD CONSTRAINT `prefix_payment_wm_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
