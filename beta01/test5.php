CREATE TABLE IF NOT EXISTS `vr_tbl_currencies` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_code` varchar(20) NOT NULL,
  `currency_rate` float NOT NULL DEFAULT '0',
  `currency_name` varchar(50) NOT NULL,
  `currency_symbol` varchar(10) NOT NULL,
  `updated_on` int(14) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vr_tbl_currencies`
--

INSERT INTO `vr_tbl_currencies` (`currency_id`, `currency_code`, `currency_rate`, `currency_name`, `currency_symbol`, `updated_on`, `updated_by`) VALUES
(1, 'USD', 1, 'american dollar', '&#36;', 1378237982, 1),
(2, 'GBP', 0.619744, 'british pounds', '&#163;', 1378237982, 1),
(3, 'EUR', 0.731369, 'euro', '&#8364;', 1378237982, 1);
