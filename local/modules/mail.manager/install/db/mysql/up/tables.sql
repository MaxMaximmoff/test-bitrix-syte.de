CREATE TABLE IF NOT EXISTS `y_addresses` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `CITY` varchar(255) NOT NULL,
    `STREET` varchar(255) NOT NULL,
    `HOUSE` int(11) NOT NULL,
    PRIMARY KEY(`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `y_emails` (
                    `ID` int(11) NOT NULL AUTO_INCREMENT,
                    `NAME` varchar(255) NOT NULL,
                    `EMAIL` varchar(255) NOT NULL,
                    `ADDRESS` int(11) NOT NULL,
                    PRIMARY KEY(`ID`),
                    FOREIGN KEY (`ADDRESS`) REFERENCES `y_addresses` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
