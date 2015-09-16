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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prefix_payment_paypal`
--
ALTER TABLE `prefix_payment_paypal`
 ADD PRIMARY KEY (`payment_id`);