UPDATE chantiers SET CHA_DateFinReel = CHA_DateDebut WHERE CHA_NumDevis IN (SELECT CHA_NumDevis FROM chantieretatmax WHERE Id=5);

CREATE TABLE IF NOT EXISTS `typecontact` (
  `TC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TC_Nom` varchar(12) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`TC_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `typecontact` (`TC_ID`, `TC_Nom`) VALUES
(1, 'Fournisseur'),
(2, 'Client');

ALTER TABLE `clients` ADD `CLI_Prenom` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `CLI_Nom`;

/*DROP TABLE `insertion2`;
DROP TABLE `salaries2`;
DROP TABLE `personnes2`;*/

CREATE TABLE IF NOT EXISTS `personnes2` (
  `PER_Num` int(11) NOT NULL AUTO_INCREMENT,
  `PER_Nom` varchar(25) NOT NULL,
  `PER_Prenom` varchar(25) NOT NULL,
  `PER_TelFixe` varchar(15) DEFAULT NULL,
  `PER_TelPort` varchar(15) DEFAULT NULL,
  `PER_Fax` varchar(15) DEFAULT NULL,
  `PER_Email` varchar(50) DEFAULT NULL,
  `PER_Adresse` varchar(50) DEFAULT NULL,
  `PER_CodePostal` varchar(5) DEFAULT NULL,
  `PER_Ville` varchar(50) DEFAULT NULL,
  `PER_DateN` date DEFAULT NULL,
  `PER_LieuN` varchar(45) DEFAULT 'CAEN',
  `PER_Nation` varchar(45) DEFAULT 'FRANCAISE',
  `PER_NPoleEmp` varchar(45) DEFAULT NULL,
  `PER_NSecu` varchar(45) NULL,
  `PER_NCaf` varchar(45) DEFAULT NULL,
  `PER_Sexe` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`PER_Num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `salaries2` (
  `SAL_NumSalarie` int(11) NOT NULL AUTO_INCREMENT,
  `PER_Num` int(11) NOT NULL,
  `TYP_Id` int(11) NOT NULL,
  `SAL_Actif` tinyint(1) NOT NULL DEFAULT '1',
  `FCT_Id` int(11) NOT NULL,
  `SAL_DateSortie` date DEFAULT NULL,
  PRIMARY KEY (`SAL_NumSalarie`),
  KEY `FCT_Id` (`FCT_Id`),
  KEY `SAL_Actif` (`SAL_Actif`),
  KEY `TYP_Id` (`TYP_Id`),
  KEY `PER_Num` (`PER_Num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `insertion2` (
  `SAL_NumSalarie` int(11) NOT NULL,
  `INS_DateEntretien` date NOT NULL,
  `INS_SituationF` varchar(45) DEFAULT NULL,
  `INS_NivScol` varchar(15) NOT NULL,
  `INS_Diplome` varchar(45) NOT NULL,
  `INS_Permis` tinyint(1) NOT NULL,
  `INS_RecoTH` tinyint(1) NOT NULL,
  `INS_Revenu` varchar(45) NOT NULL,
  `INS_Mutuelle` varchar(45) NOT NULL,
  `CNV_Id` int(11) NOT NULL,
  `CNT_Id` int(11) NOT NULL,
  `INS_DateEntree` date NOT NULL,
  `INS_NbHeures` int(5) DEFAULT NULL,
  `INS_NbJours` int(3) DEFAULT NULL,
  `INS_RevenuDepuis` varchar(45) NOT NULL,
  `INS_SEDepuis` varchar(45) NOT NULL,
  `INS_PEDepuis` varchar(45) NOT NULL,
  `INS_Repas` tinyint(1) NOT NULL,
  `INS_TRepas` tinyint(1) NOT NULL,
  `INS_Positionmt` varchar(45) NOT NULL,
  `INS_SituGeo` varchar(45) NOT NULL,
  `REF_NumRef` int(11) NOT NULL,
  `TYS_ID` int(11) DEFAULT NULL,
  `INS_PlusDetails` text,
  `INS_UrgNom` varchar(25) DEFAULT NULL,
  `INS_UrgPrenom` varchar(25) DEFAULT NULL,
  `INS_UrgTel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`SAL_NumSalarie`),
  KEY `SAL_NumSalarie` (`SAL_NumSalarie`,`CNV_Id`,`CNT_Id`,`REF_NumRef`,`TYS_ID`),
  KEY `SAL_NumSalarie_2` (`SAL_NumSalarie`),
  KEY `CNV_Id` (`CNV_Id`),
  KEY `CNT_Id` (`CNT_Id`),
  KEY `REF_NumRef` (`REF_NumRef`),
  KEY `TYS_ID` (`TYS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
**************************************************************************************************
                        EXECTUTE TableApdapter.php BEFORE THE FOLLOWING SQL CODE
**************************************************************************************************
*/
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE `insertion`;
DROP TABLE `salaries`;
DROP TABLE `personnes`;

RENAME TABLE `insertion2` TO `insertion`;
RENAME TABLE `salaries2` TO `salaries`;
RENAME TABLE `personnes2` TO `personnes`;

ALTER TABLE `salaries`
  ADD CONSTRAINT `fk_salaries_fctid` FOREIGN KEY (`FCT_Id`) REFERENCES `fonction` (`FCT_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_salaries_pernum` FOREIGN KEY (`PER_Num`) REFERENCES `personnes` (`PER_Num`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_salaries_typeid` FOREIGN KEY (`TYP_Id`) REFERENCES `type` (`TYP_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `insertion`
  ADD CONSTRAINT `fk_insertion_tysid` FOREIGN KEY (`TYS_ID`) REFERENCES `typesortie` (`TYS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_insertion_cntid` FOREIGN KEY (`CNT_Id`) REFERENCES `contrat` (`CNT_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_insertion_cnvid` FOREIGN KEY (`CNV_Id`) REFERENCES `convention` (`CNV_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_insertion_refnumref` FOREIGN KEY (`REF_NumRef`) REFERENCES `referents` (`REF_NumRef`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_insertion_salnumsalarie` FOREIGN KEY (`SAL_NumSalarie`) REFERENCES `salaries` (`SAL_NumSalarie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE IF NOT EXISTS `cursus` (
  `CUR_Date` date NOT NULL,
  `SAL_NumSalarie` int(5) NOT NULL,
  `TYP_Id` int(11) NOT NULL,
  `CUR_Comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CUR_Date`,`SAL_NumSalarie`),
  KEY `fk_numero_salarie` (`SAL_NumSalarie`),
  KEY `fk_type_salarie` (`TYP_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `cursus`
  ADD CONSTRAINT `fk_cursus_salnum` FOREIGN KEY (`SAL_NumSalarie`) REFERENCES `salaries` (`SAL_NumSalarie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cursus_type` FOREIGN KEY (`TYP_Id`) REFERENCES `type`(`TYP_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*
**************************************************************************************************
                        EXECTUTE Metaquery.php BEFORE THE FOLLOWING SQL CODE
**************************************************************************************************
*/

SELECT `co`.`CHA_NumDevis` AS `CNumDevis`,concat(`cl`.`CLI_Nom`,' ',ifnull(`cl`.`CLI_Prenom`, '')) AS `Client`,'none' AS `ClientP`,`cl`.`CLI_Telephone` AS `ClientTel`,
`cl`.`CLI_Email` AS `ClientEmail`,`cl`.`CLI_Adresse` AS `ClientAd`,`cl`.`CLI_Ville` AS `ClienV`,`cl`.`CLI_CodePostal` AS `ClientCP`,`cl`.`CLI_NumClient` AS `NumClient`,
'structure' AS `Structure`
FROM (`revivre`.`commanditer` `co` join `revivre`.`clients` `cl` on((`co`.`CLI_NumClient` = `cl`.`CLI_NumClient`)))

UPDATE salaries SET SAL_DateSortie = NULL WHERE SAL_DateSortie =  "1970-01-01";