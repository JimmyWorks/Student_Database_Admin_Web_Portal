CREATE TABLE IF NOT EXISTS `student` (
  `ID` int NOT NULL,
  `Name` varchar(128) DEFAULT NULL,
  `Major` varchar(128) DEFAULT NULL,
  `Year` varchar(128) DEFAULT NULL,
  `userid` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL);

INSERT INTO `student` (`ID`, `Name`, `Major`, `Year`, `userid`, `email`) VALUES
(1, 'Andy', 'CS', 'Freshman', 'student1', 'andy@utdallas.edu'),
(2, 'Brad', 'CS', 'Senior', 'student2', 'brad@utdalals.edu'),
(3, 'Evan', 'EE', 'Junior', 'student3', 'evan@utdallas.edu'),
(4, 'Josh', 'SE', 'Freshman', 'student4', 'josh@utdallas.edu'),
(5, 'James', 'CS', 'Senior', 'student5', 'james@utdallas.edu'),
(6, 'Justin', 'SE', 'Junior', 'student6', 'justin@utdallas.edu');
