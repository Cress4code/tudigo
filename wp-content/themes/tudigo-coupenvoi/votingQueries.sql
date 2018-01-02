CREATE TABLE `tudigo`.`tg_voters` ( `ID` INT NOT NULL AUTO_INCREMENT , `email` INT(100) NOT NULL , `nom` VARCHAR(255) NOT NULL , `prenom` VARCHAR(255) NOT NULL , `datedenaissance` DATE NOT NULL , PRIMARY KEY (`ID`), UNIQUE (`email`)) ENGINE = InnoDB;

CREATE TABLE `tudigo`.`tg_dailyVotes` ( `ID` INT NOT NULL AUTO_INCREMENT ,  `projetID` INT NOT NULL ,  `voterID` INT NOT NULL ,  `tokenVotes` VARCHAR(255) NOT NULL ,  `dateVotes` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,  `tokenValidate` INT(1) NOT NULL DEFAULT 0 ,  `shared` INT(1) NOT NULL DEFAULT 0 ,    PRIMARY KEY  (`ID`)) ENGINE = InnoDB;
​
