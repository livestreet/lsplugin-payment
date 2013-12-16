ALTER TABLE `prefix_payment` CHANGE `type` `type` ENUM( 'wm', 'paypal', 'liqpay', 'paypro', 'robox', 'master', 'w1' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

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
  `LMI_PAYMENT_DESC` varchar(500) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `WMI_UPDATE_DATE` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Ограничения внешнего ключа таблицы `prefix_payment_master`
--
ALTER TABLE `prefix_payment_master`
  ADD CONSTRAINT `prefix_payment_master_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `prefix_payment_w1`
--
ALTER TABLE `prefix_payment_w1`
  ADD CONSTRAINT `prefix_payment_w1_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `prefix_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;