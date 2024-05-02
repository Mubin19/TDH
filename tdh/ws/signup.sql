CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `fullName` varchar(120) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `contactNumber` char(10) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);