SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Schema mydb
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Schema tpo
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP SCHEMA IF EXISTS `tpo` ;

--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Schema tpo
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
CREATE SCHEMA IF NOT EXISTS `tpo` DEFAULT CHARACTER SET utf8 ;
USE `tpo` ;

--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`del_predmetnika`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`del_predmetnika` ;

CREATE TABLE IF NOT EXISTS `tpo`.`del_predmetnika` (
  `ID_DELPREDMETNIKA` INT(11) NOT NULL AUTO_INCREMENT,
  `NAZIV_DELAPREDMETNIKA` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `SKUPNOSTEVILOKT` INT(11) NOT NULL,
  `TIP` CHAR(2) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_DELPREDMETNIKA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 13
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`drzava`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`drzava` ;

CREATE TABLE IF NOT EXISTS `tpo`.`drzava` (
  `ID_DRZAVA` INT(11) NOT NULL AUTO_INCREMENT,
  `DVOMESTNAKODA` CHAR(2) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `TRIMESTNAKODA` CHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `ISONAZIV` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `SLOVENSKINAZIV` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `OPOMBA` CHAR(200) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_DRZAVA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 895
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`predmet`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`predmet` ;

CREATE TABLE IF NOT EXISTS `tpo`.`predmet` (
  `ID_PREDMET` INT(11) NOT NULL AUTO_INCREMENT,
  `SIFRA_PREDMET` INT(11) NOT NULL,
  `IME_PREDMET` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  `ST_KREDITNIH_TOCK` INT(11) NOT NULL DEFAULT '6',
  PRIMARY KEY (`ID_PREDMET`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 63
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`studijsko_leto`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`studijsko_leto` ;

CREATE TABLE IF NOT EXISTS `tpo`.`studijsko_leto` (
  `ID_STUD_LETO` INT(11) NOT NULL AUTO_INCREMENT,
  `STUD_LETO` CHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  PRIMARY KEY (`ID_STUD_LETO`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`oseba`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`oseba` ;

CREATE TABLE IF NOT EXISTS `tpo`.`oseba` (
  `ID_OSEBA` INT(11) NOT NULL AUTO_INCREMENT,
  `IME` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `PRIIMEK` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `SIFRA_IZVAJALCA` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `EMAIL` CHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `UPORABNISKO_IME` CHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL ,
  `GESLO` CHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `VRSTA_VLOGE` CHAR(1) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `TELEFONSKA_STEVILKA` CHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `DATUM_ROJSTVA` CHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `resetPwToken` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `resetPwExpiration` INT(11) NULL DEFAULT NULL,
  `resetPwUsed` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_OSEBA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 40
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE UNIQUE INDEX `EMAIL_UNIQUE` ON `tpo`.`oseba` (`EMAIL` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`izvedba_predmeta`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`izvedba_predmeta` ;

CREATE TABLE IF NOT EXISTS `tpo`.`izvedba_predmeta` (
  `ID_IZVEDBA` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `ID_OSEBA1` INT(11) NOT NULL,
  `ID_OSEBA2` INT(11) NULL DEFAULT NULL,
  `ID_OSEBA3` INT(11) NULL DEFAULT NULL,
  `ID_PREDMET` INT(11) NOT NULL,
  PRIMARY KEY (`ID_IZVEDBA`),
  CONSTRAINT `FK_RELATIONSHIP_18`
  FOREIGN KEY (`ID_PREDMET`)
  REFERENCES `tpo`.`predmet` (`ID_PREDMET`),
  CONSTRAINT `FK_RELATIONSHIP_19`
  FOREIGN KEY (`ID_STUD_LETO`)
  REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`),
  CONSTRAINT `Je_UCITELJ1`
  FOREIGN KEY (`ID_OSEBA1`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `Je_UCITELJ2`
  FOREIGN KEY (`ID_OSEBA2`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `Je_UCITELJ3`
  FOREIGN KEY (`ID_OSEBA3`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 28
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_18` ON `tpo`.`izvedba_predmeta` (`ID_PREDMET` ASC);

CREATE INDEX `FK_RELATIONSHIP_19` ON `tpo`.`izvedba_predmeta` (`ID_STUD_LETO` ASC);

CREATE INDEX `2131_idx` ON `tpo`.`izvedba_predmeta` (`ID_OSEBA1` ASC);

CREATE INDEX `Je_UCITELJ2_idx` ON `tpo`.`izvedba_predmeta` (`ID_OSEBA2` ASC);

CREATE INDEX `Je_UCITELJ3_idx` ON `tpo`.`izvedba_predmeta` (`ID_OSEBA3` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`stopnja`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`stopnja` ;

CREATE TABLE IF NOT EXISTS `tpo`.`stopnja` (
  `ID_STOPNJA` INT(11) NOT NULL AUTO_INCREMENT,
  `NAZIV` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `MOZEN_VPIS` INT(11) NOT NULL,
  `SIFRA` CHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  PRIMARY KEY (`ID_STOPNJA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`program`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`program` ;

CREATE TABLE IF NOT EXISTS `tpo`.`program` (
  `ID_PROGRAM` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_STOPNJA` INT(11) NOT NULL,
  `SIFRA_PROGRAM` CHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `NAZIV_PROGRAM` CHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `ST_SEMESTROV` INT(11) NOT NULL,
  `SIFRA_EVS` INT(11) NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_PROGRAM`),
  CONSTRAINT `FK_STOPNJA`
  FOREIGN KEY (`ID_STOPNJA`)
  REFERENCES `tpo`.`stopnja` (`ID_STOPNJA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 21
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_STOPNJA_idx` ON `tpo`.`program` (`ID_STOPNJA` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`kandidat`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`kandidat` ;

CREATE TABLE IF NOT EXISTS `tpo`.`kandidat` (
  `ID_KANDIDAT` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_PROGRAM` INT(11) NOT NULL,
  `ID_OSEBA` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `IZKORISCEN` INT(11) NOT NULL,
  `EMSO` CHAR(13) NULL DEFAULT NULL,
  `VPISNA_STEVILKA` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_KANDIDAT`),
  CONSTRAINT `FK_OSEBAID`
  FOREIGN KEY (`ID_OSEBA`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_PROGRAM_2`
  FOREIGN KEY (`ID_PROGRAM`)
  REFERENCES `tpo`.`program` (`ID_PROGRAM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_STUDLETOID`
  FOREIGN KEY (`ID_STUD_LETO`)
  REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_PROGRAM_idx` ON `tpo`.`kandidat` (`ID_PROGRAM` ASC);

CREATE INDEX `FK_OSEBAID_idx` ON `tpo`.`kandidat` (`ID_OSEBA` ASC);

CREATE INDEX `FK_STUDLETOID_idx` ON `tpo`.`kandidat` (`ID_STUD_LETO` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`letnik`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`letnik` ;

CREATE TABLE IF NOT EXISTS `tpo`.`letnik` (
  `ID_LETNIK` INT(11) NOT NULL AUTO_INCREMENT,
  `LETNIK` INT(11) NOT NULL,
  PRIMARY KEY (`ID_LETNIK`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`nacin_studija`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`nacin_studija` ;

CREATE TABLE IF NOT EXISTS `tpo`.`nacin_studija` (
  `ID_NACIN` INT(11) NOT NULL AUTO_INCREMENT,
  `OPIS_NACIN` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `ANG_OPIS_NACIN` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_NACIN`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`posta`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`posta` ;

CREATE TABLE IF NOT EXISTS `tpo`.`posta` (
  `ID_POSTA` INT(11) NOT NULL AUTO_INCREMENT,
  `ST_POSTA` CHAR(4) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `KRAJ` CHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  `MID_POSTA` INT(11) NULL,
  PRIMARY KEY (`ID_POSTA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 470
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`obcina`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`obcina` ;

CREATE TABLE IF NOT EXISTS `tpo`.`obcina` (
  `ID_OBCINA` INT(11) NOT NULL AUTO_INCREMENT,
  `IME_OBCINA` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `AKTIVNOST` INT(11) NULL DEFAULT NULL,
  `MID_OBCINA` INT(11) NULL,
  PRIMARY KEY (`ID_OBCINA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 214
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`naslov`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`naslov` ;

CREATE TABLE IF NOT EXISTS `tpo`.`naslov` (
  `ID_NASLOV` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_POSTA` INT(11) NULL DEFAULT NULL,
  `ID_OBCINA` INT(11) NULL DEFAULT NULL,
  `ID_DRZAVA` INT(11) NULL DEFAULT NULL,
  `ID_OSEBA` INT(11) NULL DEFAULT NULL,
  `JE_ZAVROCANJE` INT(11) NULL DEFAULT NULL,
  `JE_STALNI` INT(11) NULL DEFAULT NULL,
  `ULICA` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`ID_NASLOV`),
  CONSTRAINT `FK_RELATIONSHIP_30`
  FOREIGN KEY (`ID_POSTA`)
  REFERENCES `tpo`.`posta` (`ID_POSTA`),
  CONSTRAINT `FK_RELATIONSHIP_31`
  FOREIGN KEY (`ID_OBCINA`)
  REFERENCES `tpo`.`obcina` (`ID_OBCINA`),
  CONSTRAINT `FK_RELATIONSHIP_32`
  FOREIGN KEY (`ID_OSEBA`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `FK_RELATIONSHIP_33`
  FOREIGN KEY (`ID_DRZAVA`)
  REFERENCES `tpo`.`drzava` (`ID_DRZAVA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_30` ON `tpo`.`naslov` (`ID_POSTA` ASC);

CREATE INDEX `FK_RELATIONSHIP_31` ON `tpo`.`naslov` (`ID_OBCINA` ASC);

CREATE INDEX `FK_RELATIONSHIP_33` ON `tpo`.`naslov` (`ID_DRZAVA` ASC);

CREATE INDEX `FK_RELATIONSHIP_32_idx` ON `tpo`.`naslov` (`ID_OSEBA` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`oblika_studija`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`oblika_studija` ;

CREATE TABLE IF NOT EXISTS `tpo`.`oblika_studija` (
  `ID_OBLIKA` INT(11) NOT NULL AUTO_INCREMENT,
  `NAZIV_OBLIKA` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `ANG_OPIS_OBLIKA` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_OBLIKA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`vrsta_vpisa`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`vrsta_vpisa` ;

CREATE TABLE IF NOT EXISTS `tpo`.`vrsta_vpisa` (
  `ID_VRSTAVPISA` INT(11) NOT NULL AUTO_INCREMENT,
  `OPIS_VPISA` CHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_VRSTAVPISA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`vpis`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`vpis` ;

CREATE TABLE IF NOT EXISTS `tpo`.`vpis` (
  `ID_VPIS` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_PROGRAM` INT(11) NOT NULL,
  `ID_NACIN` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `ID_VRSTAVPISA` INT(11) NOT NULL,
  `ID_OBLIKA` INT(11) NOT NULL,
  `ID_LETNIK` INT(11) NOT NULL,
  `POTRJENOST_VPISA` INT(11) NOT NULL,
  `VPISNA_STEVILKA` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_VPIS`),
  CONSTRAINT `FK_RELATIONSHIP_10`
  FOREIGN KEY (`ID_OBLIKA`)
  REFERENCES `tpo`.`oblika_studija` (`ID_OBLIKA`),
  CONSTRAINT `FK_RELATIONSHIP_11`
  FOREIGN KEY (`ID_LETNIK`)
  REFERENCES `tpo`.`letnik` (`ID_LETNIK`),
  CONSTRAINT `FK_RELATIONSHIP_12`
  FOREIGN KEY (`ID_PROGRAM`)
  REFERENCES `tpo`.`program` (`ID_PROGRAM`),
  CONSTRAINT `FK_RELATIONSHIP_16`
  FOREIGN KEY (`ID_STUD_LETO`)
  REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`),
  CONSTRAINT `FK_RELATIONSHIP_8`
  FOREIGN KEY (`ID_VRSTAVPISA`)
  REFERENCES `tpo`.`vrsta_vpisa` (`ID_VRSTAVPISA`),
  CONSTRAINT `FK_RELATIONSHIP_9`
  FOREIGN KEY (`ID_NACIN`)
  REFERENCES `tpo`.`nacin_studija` (`ID_NACIN`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 23
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_10` ON `tpo`.`vpis` (`ID_OBLIKA` ASC);

CREATE INDEX `FK_RELATIONSHIP_11` ON `tpo`.`vpis` (`ID_LETNIK` ASC);

CREATE INDEX `FK_RELATIONSHIP_12` ON `tpo`.`vpis` (`ID_PROGRAM` ASC);

CREATE INDEX `FK_RELATIONSHIP_16` ON `tpo`.`vpis` (`ID_STUD_LETO` ASC);

CREATE INDEX `FK_RELATIONSHIP_8` ON `tpo`.`vpis` (`ID_VRSTAVPISA` ASC);

CREATE INDEX `FK_RELATIONSHIP_9` ON `tpo`.`vpis` (`ID_NACIN` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`student`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`student` ;

CREATE TABLE IF NOT EXISTS `tpo`.`student` (
  `VPISNA_STEVILKA` INT(11) NOT NULL,
  `ID_OSEBA` INT(11) NOT NULL,
  `ID_KANDIDAT` INT(11) NULL DEFAULT NULL,
  `ID_VPIS` INT(11) NULL DEFAULT NULL,
  `EMSO` CHAR(13) NULL DEFAULT NULL,
  `ID_PROGRAM` INT(11) NULL DEFAULT NULL,
  `VSOTA_OPRAVLJENIH_KREDITNIH_TOCK` INT(11) NOT NULL DEFAULT '0',
  `POVPRECNA_OCENA_OPRAVLJENIH_IZPITOV` FLOAT NOT NULL DEFAULT '0',
  PRIMARY KEY (`VPISNA_STEVILKA`),
  CONSTRAINT `FK_INHERITANCE_3`
  FOREIGN KEY (`ID_OSEBA`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `FK_PROGRAM_1`
  FOREIGN KEY (`ID_PROGRAM`)
  REFERENCES `tpo`.`program` (`ID_PROGRAM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RELATIONSHIP_5`
  FOREIGN KEY (`ID_KANDIDAT`)
  REFERENCES `tpo`.`kandidat` (`ID_KANDIDAT`),
  CONSTRAINT `FK_RELATIONSHIP_6`
  FOREIGN KEY (`ID_VPIS`)
  REFERENCES `tpo`.`vpis` (`ID_VPIS`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_INHERITANCE_3` ON `tpo`.`student` (`ID_OSEBA` ASC);

CREATE INDEX `FK_RELATIONSHIP_5` ON `tpo`.`student` (`ID_KANDIDAT` ASC);

CREATE INDEX `FK_RELATIONSHIP_6` ON `tpo`.`student` (`ID_VPIS` ASC);

CREATE INDEX `FK_PROGRAM_idx` ON `tpo`.`student` (`ID_PROGRAM` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`predmeti_studenta`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`predmeti_studenta` ;

CREATE TABLE IF NOT EXISTS `tpo`.`predmeti_studenta` (
  `ID_PREDMETISTUDENTA` INT(11) NOT NULL AUTO_INCREMENT,
  `VPISNA_STEVILKA` INT(11) NOT NULL,
  `ID_PREDMET` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `OCENA` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`ID_PREDMETISTUDENTA`),
  CONSTRAINT `FK_RELATIONSHIP_23`
  FOREIGN KEY (`VPISNA_STEVILKA`)
  REFERENCES `tpo`.`student` (`VPISNA_STEVILKA`),
  CONSTRAINT `FK_RELATIONSHIP_24`
  FOREIGN KEY (`ID_PREDMET`)
  REFERENCES `tpo`.`predmet` (`ID_PREDMET`),
  CONSTRAINT `FK_STUD_LETO_2`
  FOREIGN KEY (`ID_STUD_LETO`)
  REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1372
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_23` ON `tpo`.`predmeti_studenta` (`VPISNA_STEVILKA` ASC);

CREATE INDEX `FK_RELATIONSHIP_24` ON `tpo`.`predmeti_studenta` (`ID_PREDMET` ASC);

CREATE INDEX `FK_STUD_LETO_idx` ON `tpo`.`predmeti_studenta` (`ID_STUD_LETO` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`predmetnik`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`predmetnik` ;

CREATE TABLE IF NOT EXISTS `tpo`.`predmetnik` (
  `ID_PREDMETNIK` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_PREDMET` INT(11) NOT NULL,
  `ID_DELPREDMETNIKA` INT(11) NOT NULL,
  `ID_LETNIK` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `ID_PROGRAM` INT(11) NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_PREDMETNIK`),
  CONSTRAINT `FK_DELPREDMETNIKA`
  FOREIGN KEY (`ID_DELPREDMETNIKA`)
  REFERENCES `tpo`.`del_predmetnika` (`ID_DELPREDMETNIKA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_PREDMET`
  FOREIGN KEY (`ID_PREDMET`)
  REFERENCES `tpo`.`predmet` (`ID_PREDMET`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RELATIONSHIP_13`
  FOREIGN KEY (`ID_PROGRAM`)
  REFERENCES `tpo`.`program` (`ID_PROGRAM`),
  CONSTRAINT `FK_RELATIONSHIP_14`
  FOREIGN KEY (`ID_LETNIK`)
  REFERENCES `tpo`.`letnik` (`ID_LETNIK`),
  CONSTRAINT `FK_RELATIONSHIP_17`
  FOREIGN KEY (`ID_STUD_LETO`)
  REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 1305
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_13` ON `tpo`.`predmetnik` (`ID_PROGRAM` ASC);

CREATE INDEX `FK_RELATIONSHIP_14` ON `tpo`.`predmetnik` (`ID_LETNIK` ASC);

CREATE INDEX `FK_RELATIONSHIP_17` ON `tpo`.`predmetnik` (`ID_STUD_LETO` ASC);

CREATE INDEX `FK_PREDMET_idx` ON `tpo`.`predmetnik` (`ID_PREDMET` ASC);

CREATE INDEX `FK_DELPREDMETNIKA_idx` ON `tpo`.`predmetnik` (`ID_DELPREDMETNIKA` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`rok`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`rok` ;

CREATE TABLE IF NOT EXISTS `tpo`.`rok` (
  `ID_ROK` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_IZVEDBA` INT(11) NOT NULL,
  `DATUM_ROKA` DATE NOT NULL,
  `CAS_ROKA` TIME NOT NULL,
  `AKTIVNOST` INT(11) NULL DEFAULT NULL,
  `ID_OSEBA_IZPRASEVALEC1` INT(11) NULL DEFAULT NULL,
  `ID_OSEBA_IZPRASEVALEC2` INT(11) NULL DEFAULT NULL,
  `ID_OSEBA_IZPRASEVALEC3` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_ROK`),
  CONSTRAINT `FK_RELATIONSHIP_25`
  FOREIGN KEY (`ID_IZVEDBA`)
  REFERENCES `tpo`.`izvedba_predmeta` (`ID_IZVEDBA`),
  CONSTRAINT `fk_izvajalec1`
  FOREIGN KEY (`ID_OSEBA_IZPRASEVALEC1`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `fk_izvajalec2`
  FOREIGN KEY (`ID_OSEBA_IZPRASEVALEC2`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `fk_izvalaec3`
  FOREIGN KEY (`ID_OSEBA_IZPRASEVALEC3`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 36
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_25` ON `tpo`.`rok` (`ID_IZVEDBA` ASC);

CREATE INDEX `fk_izvajalec_idx` ON `tpo`.`rok` (`ID_OSEBA_IZPRASEVALEC1` ASC);

CREATE INDEX `fk_izvajalec2_idx` ON `tpo`.`rok` (`ID_OSEBA_IZPRASEVALEC2` ASC);

CREATE INDEX `fk_izvalaec3_idx` ON `tpo`.`rok` (`ID_OSEBA_IZPRASEVALEC3` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`prijava`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`prijava` ;

CREATE TABLE IF NOT EXISTS `tpo`.`prijava` (
  `ID_PRIJAVA` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_ROK` INT(11) NOT NULL,
  `VPISNA_STEVILKA` INT(11) NOT NULL,
  `ZAP_ST_POLAGANJ` INT(11) NOT NULL DEFAULT '0',
  `ZAP_ST_POLAGANJ_LETOS` INT(11) NOT NULL DEFAULT '0',
  `PODATKI_O_PLACILU` CHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `TOCKE_IZPITA` INT(11) NULL DEFAULT NULL,
  `OCENA_IZPITA` INT(11) NULL DEFAULT NULL,
  `DATUM_PRIJAVE` DATETIME NULL DEFAULT NULL,
  `ID_OSEBA_PRIJAVITELJ` INT(11) NULL DEFAULT NULL,
  `DATUM_ODJAVE` DATETIME NULL DEFAULT NULL,
  `ID_OSEBA_ODJAVITELJ` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_PRIJAVA`),
  CONSTRAINT `FK_RELATIONSHIP_100`
  FOREIGN KEY (`VPISNA_STEVILKA`)
  REFERENCES `tpo`.`student` (`VPISNA_STEVILKA`),
  CONSTRAINT `FK_RELATIONSHIP_200`
  FOREIGN KEY (`ID_OSEBA_PRIJAVITELJ`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `FK_RELATIONSHIP_201`
  FOREIGN KEY (`ID_OSEBA_ODJAVITELJ`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `FK_RELATIONSHIP_26`
  FOREIGN KEY (`ID_ROK`)
  REFERENCES `tpo`.`rok` (`ID_ROK`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 16
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_26` ON `tpo`.`prijava` (`ID_ROK` ASC);

CREATE INDEX `FK_RELATIONSHIP_100_idx` ON `tpo`.`prijava` (`VPISNA_STEVILKA` ASC);

CREATE INDEX `FK_RELATIONSHIP_200_idx` ON `tpo`.`prijava` (`ID_OSEBA_PRIJAVITELJ` ASC);

CREATE INDEX `FK_RELATIONSHIP_201_idx` ON `tpo`.`prijava` (`ID_OSEBA_ODJAVITELJ` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`zeton`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`zeton` ;

CREATE TABLE IF NOT EXISTS `tpo`.`zeton` (
  `ID_ZETON` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_OSEBA` INT(11) NOT NULL,
  `ID_LETNIK` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `IZKORISCEN` INT(11) NULL DEFAULT '0',
  `AKTIVNOST` INT(11) NULL DEFAULT '1',
  `ID_OBLIKA` INT(11) NOT NULL,
  `ID_VRSTAVPISA` INT(11) NOT NULL,
  `ID_NACIN` INT(11) NOT NULL,
  `ID_PROGRAM` INT(11) NOT NULL,
  `PROSTA_IZBIRNOST` INT(11) NULL DEFAULT '0',
  PRIMARY KEY (`ID_ZETON`),
  CONSTRAINT `FK_LETNIK_1`
  FOREIGN KEY (`ID_LETNIK`)
  REFERENCES `tpo`.`letnik` (`ID_LETNIK`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RELATIONSHIP_7`
  FOREIGN KEY (`ID_OSEBA`)
  REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `FK_STUD_LETO_1`
  FOREIGN KEY (`ID_STUD_LETO`)
  REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zeton_nacin_studija1`
  FOREIGN KEY (`ID_NACIN`)
  REFERENCES `tpo`.`nacin_studija` (`ID_NACIN`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zeton_oblika_studija1`
  FOREIGN KEY (`ID_OBLIKA`)
  REFERENCES `tpo`.`oblika_studija` (`ID_OBLIKA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zeton_program1`
  FOREIGN KEY (`ID_PROGRAM`)
  REFERENCES `tpo`.`program` (`ID_PROGRAM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zeton_vrsta_vpisa1`
  FOREIGN KEY (`ID_VRSTAVPISA`)
  REFERENCES `tpo`.`vrsta_vpisa` (`ID_VRSTAVPISA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  AUTO_INCREMENT = 167
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE INDEX `FK_RELATIONSHIP_7` ON `tpo`.`zeton` (`ID_OSEBA` ASC);

CREATE INDEX `FK_STUD_LETO_idx` ON `tpo`.`zeton` (`ID_STUD_LETO` ASC);

CREATE INDEX `FK_LETNIK_idx` ON `tpo`.`zeton` (`ID_LETNIK` ASC);

CREATE INDEX `fk_zeton_oblika_studija1_idx` ON `tpo`.`zeton` (`ID_OBLIKA` ASC);

CREATE INDEX `fk_zeton_vrsta_vpisa1_idx` ON `tpo`.`zeton` (`ID_VRSTAVPISA` ASC);

CREATE INDEX `fk_zeton_nacin_studija1_idx` ON `tpo`.`zeton` (`ID_NACIN` ASC);

CREATE INDEX `fk_zeton_program1_idx` ON `tpo`.`zeton` (`ID_PROGRAM` ASC);


--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
--  Table `tpo`.`posta_obcina`
--  -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -
DROP TABLE IF EXISTS `tpo`.`posta_obcina` ;

CREATE TABLE IF NOT EXISTS `tpo`.`posta_obcina` (
  `MID_POSTA` INT(11) NOT NULL,
  `MID_OBCINA` INT(11) NOT NULL)
  ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `drzava` (`ID_DRZAVA`, `DVOMESTNAKODA`, `TRIMESTNAKODA`, `ISONAZIV`, `SLOVENSKINAZIV`, `OPOMBA`, `AKTIVNOST`) VALUES
  (4, 'AF', 'AFG', 'Afghanistan', 'Afganistan', NULL, 1),
  (8, 'AL', 'ALB', 'Albania', 'Albanija', NULL, 1),
  (10, 'AQ', 'ATA', 'Antarctica', 'Antarktika', NULL, 1),
  (12, 'DZ', 'DZA', 'Algeria', 'Alžirija', NULL, 1),
  (16, 'AS', 'ASM', 'American Samoa', 'Ameriška Samoa', NULL, 1),
  (20, 'AD', 'AND', 'Andorra', 'Andora', NULL, 1),
  (24, 'AO', 'AGO', 'Angola', 'Angola', NULL, 1),
  (28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antigva in Barbuda', NULL, 1),
  (31, 'AZ', 'AZE', 'Azerbaijan', 'Azerbajdžan', NULL, 1),
  (32, 'AR', 'ARG', 'Argentina', 'Argenitna', NULL, 1),
  (36, 'AU', 'AUS', 'Australia', 'Avstralija', NULL, 1),
  (40, 'AT', 'AUT', 'Austria', 'Avstrija', NULL, 1),
  (44, 'BS', 'BHS', 'Bahamas', 'Bahami', NULL, 1),
  (48, 'BH', 'BHR', 'Bahrain', 'Bahrajn', NULL, 1),
  (50, 'BD', 'BGD', 'Bangladesh', 'Bangladeš', NULL, 1),
  (51, 'AM', 'ARM', 'Armenia', 'Armenija', NULL, 1),
  (52, 'BB', 'BRB', 'Barbados', 'Barbados', NULL, 1),
  (56, 'BE', 'BEL', 'Belgium', 'Belgija', NULL, 1),
  (60, 'BM', 'BMU', 'Bermuda', 'Bermudi', NULL, 1),
  (64, 'BT', 'BTN', 'Bhutan', 'Butan', NULL, 1),
  (68, 'BO', 'BOL', 'Bolivia, Plurinational State of', 'Bolivija', NULL, 1),
  (70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosna in Hercegovina', NULL, 1),
  (72, 'BW', 'BWA', 'Botswana', 'Bocvana', NULL, 1),
  (74, 'BV', 'BVT', 'Bouvet Island', 'Bouvetov otok', NULL, 1),
  (76, 'BR', 'BRA', 'Brazil', 'Brazilija', NULL, 1),
  (84, 'BZ', 'BLZ', 'Belize', 'Belize', NULL, 1),
  (86, 'IO', 'IOT', 'British Indian Ocean Territory', 'Britansko ozemlje v Indijskem oceanu', NULL, 1),
  (90, 'SB', 'SLB', 'Solomon Islands', 'Solomonovi otoki', NULL, 1),
  (92, 'VG', 'VGB', 'Virgin Islands, British', 'Britanski Deviški otoki', NULL, 1),
  (96, 'BN', 'BRN', 'Brunei Darussalam', 'Brunej', NULL, 1),
  (100, 'BG', 'BGR', 'Bulgaria', 'Bolgarija', NULL, 1),
  (104, 'MM', 'MMR', 'Myanmar', 'Mjanmar', NULL, 1),
  (108, 'BI', 'BDI', 'Burundi', 'Burundi', NULL, 1),
  (112, 'BY', 'BLR', 'Belarus', 'Belorusija', NULL, 1),
  (116, 'KH', 'KHM', 'Cambodia', 'Kambodža', NULL, 1),
  (120, 'CM', 'CMR', 'Cameroon', 'Kamerun', NULL, 1),
  (124, 'CA', 'CAN', 'Canada', 'Kanada', NULL, 1),
  (132, 'CV', 'CPV', 'Cape Verde', 'Kapverdski otoki (Zelenortski otoki)', NULL, 1),
  (136, 'KY', 'CYM', 'Cayman Islands', 'Kajmanski otoki', NULL, 1),
  (140, 'CF', 'CAF', 'Central African Republic', 'Srednjeafriška republika', NULL, 1),
  (144, 'LK', 'LKA', 'Sri Lanka', 'Šri Lanka', NULL, 1),
  (148, 'TD', 'TCD', 'Chad', 'Čad', NULL, 1),
  (152, 'CL', 'CHL', 'Chile', 'Čile', NULL, 1),
  (156, 'CN', 'CHN', 'China', 'Kitajska', NULL, 1),
  (158, 'TW', 'TWN', 'Taiwan, Province of China', 'Tajvan', NULL, 1),
  (162, 'CX', 'CXR', 'Christmas Island', 'Božični otok', NULL, 1),
  (166, 'CC', 'CCK', 'Cocos (Keeling) Islands', 'Kokosovi in Keelingovi otoki', NULL, 1),
  (170, 'CO', 'COL', 'Colombia', 'Kolumbija', NULL, 1),
  (174, 'KM', 'COM', 'Comoros', 'Komori', NULL, 1),
  (175, 'YT', 'MYT', 'Mayotte', 'Francoska skupnost Mejot', NULL, 1),
  (178, 'CG', 'COG', 'Congo', 'Kongo', NULL, 1),
  (180, 'CD', 'COD', 'Congo, the Democratic Republic of the', 'Demokratična republika Kongo', NULL, 1),
  (184, 'CK', 'COK', 'Cook Islands', 'Cookovi otoki', NULL, 1),
  (188, 'CR', 'CRI', 'Costa Rica', 'Kostarika', NULL, 1),
  (191, 'HR', 'HRV', 'Croatia', 'Hrvaška', NULL, 1),
  (192, 'CU', 'CUB', 'Cuba', 'Kuba', NULL, 1),
  (196, 'CY', 'CYP', 'Cyprus', 'Ciper', NULL, 1),
  (203, 'CZ', 'CZE', 'Czech Republic', 'Češka', NULL, 1),
  (204, 'BJ', 'BEN', 'Benin', 'Benin', NULL, 1),
  (208, 'DK', 'DNK', 'Denmark', 'Danska', NULL, 1),
  (212, 'DM', 'DMA', 'Dominica', 'Dominika', NULL, 1),
  (214, 'DO', 'DOM', 'Dominican Republic', 'Dominikanska republika', NULL, 1),
  (218, 'EC', 'ECU', 'Ecuador', 'Ekvador', NULL, 1),
  (222, 'SV', 'SLV', 'El Salvador', 'Salvador', NULL, 1),
  (226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Ekvatorialna Gvineja', NULL, 1),
  (231, 'ET', 'ETH', 'Ethiopia', 'Etiopija', NULL, 1),
  (232, 'ER', 'ERI', 'Eritrea', 'Eritreja', NULL, 1),
  (233, 'EE', 'EST', 'Estonia', 'Estonija', NULL, 1),
  (234, 'FK', 'FRO', 'Falkland Islands (Malvinas)', 'Falkalndski otoki', NULL, 1),
  (238, 'FO', 'FLK', 'Faroe Islands', 'Ferski otoki', NULL, 1),
  (239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'Južna Georgia in Južni Sandwichevi otoki', NULL, 1),
  (242, 'FJ', 'FJI', 'Fiji', 'Fidži', NULL, 1),
  (246, 'FI', 'FIN', 'Finland', 'Finska', NULL, 1),
  (248, 'AX', 'ALA', 'Ålland Islands', 'Alandski otoki', NULL, 1),
  (250, 'FR', 'FRA', 'France', 'Francija', NULL, 1),
  (254, 'GF', 'GUF', 'French Guiana', 'Francoska Gvajana', NULL, 1),
  (258, 'PF', 'PYF', 'French Polynesia', 'Francoska Polinezija', NULL, 1),
  (260, 'TF', 'ATF', 'French Southern Territories', 'Francoska južna ozemlja', NULL, 1),
  (262, 'DJ', 'DJI', 'Djibouti', 'Džibuti', NULL, 1),
  (266, 'GA', 'GAB', 'Gabon', 'Gabon', NULL, 1),
  (268, 'GE', 'GEO', 'Georgia', 'Gruzija', NULL, 1),
  (270, 'GM', 'GMB', 'Gambia', 'Gambija', NULL, 1),
  (275, 'PS', 'PSE', 'Palestinian Territory, Occupied', 'Palestina', NULL, 1),
  (276, 'DE', 'DEU', 'Germany', 'Nemčija', NULL, 1),
  (288, 'GH', 'GHA', 'Ghana', 'Gana', NULL, 1),
  (292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar', NULL, 1),
  (296, 'KI', 'KIR', 'Kiribati', 'Kiribati', NULL, 1),
  (300, 'GR', 'GRC', 'Greece', 'Grčija', NULL, 1),
  (304, 'GL', 'GRL', 'Greenland', 'Grenlandija', NULL, 1),
  (308, 'GD', 'GRD', 'Grenada', 'Grenada', NULL, 1),
  (312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe', NULL, 1),
  (316, 'GU', 'GUM', 'Guam', 'Guam', NULL, 1),
  (320, 'GT', 'GTM', 'Guatemala', 'Gvatemala', NULL, 1),
  (324, 'GN', 'GIN', 'Guinea', 'Gvineja', NULL, 1),
  (328, 'GY', 'GUY', 'Guyana', 'Gvajana', NULL, 1),
  (332, 'HT', 'HTI', 'Haiti', 'Haiti', NULL, 1),
  (334, 'HM', 'HMD', 'Heard Island and McDonald Islands', 'Otok Heard in otočje McDonald', NULL, 1),
  (336, 'VA', 'VAT', 'Holy See (Vatican City State)', 'Vatikan', NULL, 1),
  (340, 'HN', 'HND', 'Honduras', 'Honduras', NULL, 1),
  (344, 'HK', 'HKG', 'Hong Kong', 'Hong Kong', NULL, 1),
  (348, 'HU', 'HUN', 'Hungary', 'Madžarska', NULL, 1),
  (352, 'IS', 'ISL', 'Iceland', 'Islandija', NULL, 1),
  (356, 'IN', 'IND', 'India', 'Indija', NULL, 1),
  (360, 'ID', 'IDN', 'Indonesia', 'Indonezija', NULL, 1),
  (364, 'IR', 'IRN', 'Iran, Islamic Republic of', 'Iran', NULL, 1),
  (368, 'IQ', 'IRQ', 'Iraq', 'Irak', NULL, 1),
  (372, 'IE', 'IRL', 'Ireland', 'Irska', NULL, 1),
  (376, 'IL', 'ISR', 'Israel', 'Izrael', NULL, 1),
  (380, 'IT', 'ITA', 'Italy', 'Italija', NULL, 1),
  (384, 'CI', 'CIV', 'Côte dIvoire', 'Slonokoščena obala', NULL, 1),
  (388, 'JM', 'JAM', 'Jamaica', 'Jamajka', NULL, 1),
  (392, 'JP', 'JPN', 'Japan', 'Japonska', NULL, 1),
  (398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazahstan', NULL, 1),
  (400, 'JO', 'JOR', 'Jordan', 'Jordanija', NULL, 1),
  (404, 'KE', 'KEN', 'Kenya', 'Kenija', NULL, 1),
  (408, 'KP', 'PRK', 'Korea, Democratic Peoples Republic of', 'Severna Koreja', NULL, 1),
  (410, 'KR', 'KOR', 'Korea, Republic of', 'Južna Koreja', NULL, 1),
  (414, 'KW', 'KWT', 'Kuwait', 'Kuvajt', NULL, 1),
  (417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kirgizistan (Kirgizija)', NULL, 1),
  (418, 'LA', 'LAO', 'Lao Peoples Democratic Republic', 'Laos', NULL, 1),
  (422, 'LB', 'LBN', 'Lebanon', 'Libanon', NULL, 1),
  (426, 'LS', 'LSO', 'Lesotho', 'Lesoto', NULL, 1),
  (428, 'LV', 'LVA', 'Latvia', 'Latvija', NULL, 1),
  (430, 'LR', 'LBR', 'Liberia', 'Liberija', NULL, 1),
  (434, 'LY', 'LBY', 'Libya', 'Libija', NULL, 1),
  (438, 'LI', 'LIE', 'Liechtenstein', 'Lihtenštajn', NULL, 1),
  (440, 'LT', 'LTU', 'Lithuania', 'Litva', NULL, 1),
  (442, 'LU', 'LUX', 'Luxembourg', 'Luksemburg', NULL, 1),
  (446, 'MO', 'MAC', 'Macao', 'Makao', NULL, 1),
  (450, 'MG', 'MDG', 'Madagascar', 'Madagaskar', NULL, 1),
  (454, 'MW', 'MWI', 'Malawi', 'Malavi', NULL, 1),
  (458, 'MY', 'MYS', 'Malaysia', 'Malezija', NULL, 1),
  (462, 'MV', 'MDV', 'Maldives', 'Maldivi', NULL, 1),
  (466, 'ML', 'MLI', 'Mali', 'Mali', NULL, 1),
  (470, 'MT', 'MLT', 'Malta', 'Malta', NULL, 1),
  (474, 'MQ', 'MTQ', 'Martinique', 'Martinik', NULL, 1),
  (478, 'MR', 'MRT', 'Mauritania', 'Mavretanija', NULL, 1),
  (480, 'MU', 'MUS', 'Mauritius', 'Mauricius (Moris)', NULL, 1),
  (484, 'MX', 'MEX', 'Mexico', 'Mehika', NULL, 1),
  (492, 'MC', 'MCO', 'Monaco', 'Monako', NULL, 1),
  (496, 'MN', 'MNG', 'Mongolia', 'Mongolija', NULL, 1),
  (498, 'MD', 'MDA', 'Moldova, Republic of', 'Moldavija', NULL, 1),
  (499, 'ME', 'MNE', 'Montenegro', 'Črna Gora', NULL, 1),
  (500, 'MS', 'MSR', 'Montserrat', 'Montserat', NULL, 1),
  (504, 'MA', 'MAR', 'Morocco', 'Maroko', NULL, 1),
  (508, 'MZ', 'MOZ', 'Mozambique', 'Mozambik', NULL, 1),
  (512, 'OM', 'OMN', 'Oman', 'Oman', NULL, 1),
  (516, 'NA', 'NAM', 'Namibia', 'Namibija', NULL, 1),
  (520, 'NR', 'NRU', 'Nauru', 'Nauru', NULL, 1),
  (524, 'NP', 'NPL', 'Nepal', 'Nepal', NULL, 1),
  (528, 'NL', 'NLD', 'Netherlands', 'Nizozemska', NULL, 1),
  (531, 'CW', 'CUW', 'Curaçao', 'Kurasao', NULL, 1),
  (533, 'AW', 'ABW', 'Aruba', 'Aruba', NULL, 1),
  (534, 'SX', 'SXM', 'Sint Maarten (Dutch part)', 'Otok svetega.Martina (Nizozemska)', NULL, 1),
  (535, 'BQ', 'BES', 'Bonaire, Sint Eustatius and Saba', 'Otočje Bonaire, Sv. Eustatij in Saba', NULL, 1),
  (540, 'NC', 'NCL', 'New Caledonia', 'Nova Kaledonija', NULL, 1),
  (548, 'VU', 'VUT', 'Vanuatu', 'Republika Vanuatu', NULL, 1),
  (554, 'NZ', 'NZL', 'New Zealand', 'Nova Zelandija', NULL, 1),
  (558, 'NI', 'NIC', 'Nicaragua', 'Nikaragva', NULL, 1),
  (562, 'NE', 'NER', 'Niger', 'Niger', NULL, 1),
  (566, 'NG', 'NGA', 'Nigeria', 'Nigerija', NULL, 1),
  (570, 'NU', 'NIU', 'Niue', 'Niu', NULL, 1),
  (574, 'NF', 'NFK', 'Norfolk Island', 'Otok Norflok', NULL, 1),
  (578, 'NO', 'NOR', 'Norway', 'Norveška', NULL, 1),
  (580, 'MP', 'MNP', 'Northern Mariana Islands', 'Severni Marianski otoki', NULL, 1),
  (581, 'UM', 'UMI', 'United States Minor Outlying Islands', 'ZDA zunanji otoki', NULL, 1),
  (583, 'FM', 'FSM', 'Micronesia, Federated States of', 'Mikronezija', NULL, 1),
  (584, 'MH', 'MHL', 'Marshall Islands', 'Maršalovi otoki', NULL, 1),
  (585, 'PW', 'PLW', 'Palau', 'Palau', NULL, 1),
  (586, 'PK', 'PAK', 'Pakistan', 'Pakistan', NULL, 1),
  (591, 'PA', 'PAN', 'Panama', 'Panama', NULL, 1),
  (598, 'PG', 'PNG', 'Papua New Guinea', 'Papua Nova Gvineja', NULL, 1),
  (600, 'PY', 'PRY', 'Paraguay', 'Paragvaj', NULL, 1),
  (604, 'PE', 'PER', 'Peru', 'Peru', NULL, 1),
  (608, 'PH', 'PHL', 'Philippines', 'Filipini', NULL, 1),
  (612, 'PN', 'PCN', 'Pitcairn', 'Pitcairnovi otoki', NULL, 1),
  (616, 'PL', 'POL', 'Poland', 'Poljska', NULL, 1),
  (620, 'PT', 'PRT', 'Portugal', 'Portugalska', NULL, 1),
  (624, 'GW', 'GNB', 'Guinea-Bissau', 'Gvineja-Bissau', NULL, 1),
  (626, 'TL', 'TLS', 'Timor-Leste', 'Vzhodni Timor', NULL, 1),
  (630, 'PR', 'PRI', 'Puerto Rico', 'Portoriko', NULL, 1),
  (634, 'QA', 'QAT', 'Qatar', 'Katar', NULL, 1),
  (638, 'RE', 'REU', 'Réunion', 'Francoska skupnost Reunion', NULL, 1),
  (642, 'RO', 'ROU', 'Romania', 'Romunija', NULL, 1),
  (643, 'RU', 'RUS', 'Russian Federation', 'Ruska federacija', NULL, 1),
  (646, 'RW', 'RWA', 'Rwanda', 'Ruanda', NULL, 1),
  (652, 'BL', 'BLM', 'Saint Barthélemy', 'Sveti Bartolomej', NULL, 1),
  (654, 'SH', 'SHN', 'Saint Helena, Ascension and Tristan da Cunha', 'Sveta Helena', NULL, 1),
  (659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Sveti Kits in Nevis', NULL, 1),
  (660, 'AI', 'AIA', 'Anguilla', 'Angvila', NULL, 1),
  (662, 'LC', 'LCA', 'Saint Lucia', 'Sveta Lucija', NULL, 1),
  (663, 'MF', 'MAF', 'Saint Martin (French part)', 'Otok svetega Martina', NULL, 1),
  (666, 'PM', 'SPM', 'Saint Pierre and Miquelon', 'Sveta Pierre in Miquelon', NULL, 1),
  (670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Sveti Vincent in Grenadini', NULL, 1),
  (674, 'SM', 'SMR', 'San Marino', 'San Marino', NULL, 1),
  (678, 'ST', 'STP', 'Sao Tome and Principe', 'Sao Tome in Principe', NULL, 1),
  (682, 'SA', 'SAU', 'Saudi Arabia', 'Savdska Arabija', NULL, 1),
  (686, 'SN', 'SEN', 'Senegal', 'Senegal', NULL, 1),
  (688, 'RS', 'SRB', 'Serbia', 'Srbija', NULL, 1),
  (690, 'SC', 'SYC', 'Seychelles', 'Sejšeli', NULL, 1),
  (694, 'SL', 'SLE', 'Sierra Leone', 'Siera Leone', NULL, 1),
  (702, 'SG', 'SGP', 'Singapore', 'Singapur', NULL, 1),
  (703, 'SK', 'SVK', 'Slovakia', 'Slovaška', NULL, 1),
  (704, 'VN', 'VNM', 'Viet Nam', 'Vietnam', NULL, 1),
  (705, 'SI', 'SVN', 'Slovenia', 'Slovenija', NULL, 1),
  (706, 'SO', 'SOM', 'Somalia', 'Somalija', NULL, 1),
  (710, 'ZA', 'ZAF', 'South Africa', 'Južna afrika', NULL, 1),
  (716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabve', NULL, 1),
  (724, 'ES', 'ESP', 'Spain', 'Španija', NULL, 1),
  (728, 'SS', 'SSD', 'South Sudan', 'Južni Sudan', NULL, 1),
  (729, 'SD', 'SDN', 'Sudan', 'Sudan', NULL, 1),
  (732, 'EH', 'ESH', 'Western Sahara', 'Zahodna Sahara', NULL, 1),
  (740, 'SR', 'SUR', 'Suriname', 'Surinam', NULL, 1),
  (744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard in Jan Majen', NULL, 1),
  (748, 'SZ', 'SWZ', 'Swaziland', 'Svazi', NULL, 1),
  (752, 'SE', 'SWE', 'Sweden', 'Švedska', NULL, 1),
  (756, 'CH', 'CHE', 'Switzerland', 'Švica', NULL, 1),
  (760, 'SY', 'SYR', 'Syrian Arab Republic', 'Sirija', NULL, 1),
  (762, 'TJ', 'TJK', 'Tajikistan', 'Tadžikistan', NULL, 1),
  (764, 'TH', 'THA', 'Thailand', 'Tajska', NULL, 1),
  (768, 'TG', 'TGO', 'Togo', 'Togo', NULL, 1),
  (772, 'TK', 'TKL', 'Tokelau', 'Tokelau', NULL, 1),
  (776, 'TO', 'TON', 'Tonga', 'Tonga', NULL, 1),
  (780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinidad in Tobago', NULL, 1),
  (784, 'AE', 'ARE', 'United Arab Emirates', 'Združeni Arabski Emirati', NULL, 1),
  (788, 'TN', 'TUN', 'Tunisia', 'Tunizija', NULL, 1),
  (792, 'TR', 'TUR', 'Turkey', 'Turčija', NULL, 1),
  (795, 'TM', 'TKM', 'Turkmenistan', 'Turkmenistan', NULL, 1),
  (796, 'TC', 'TCA', 'Turks and Caicos Islands', 'Tirški in Kajkoški otoki', NULL, 1),
  (798, 'TV', 'TUV', 'Tuvalu', 'Tuvalu', NULL, 1),
  (800, 'UG', 'UGA', 'Uganda', 'Uganda', NULL, 1),
  (804, 'UA', 'UKR', 'Ukraine', 'Ukrajina', NULL, 1),
  (807, 'MK', 'MKD', 'Macedonia', 'Makedonija', NULL, 1),
  (818, 'EG', 'EGY', 'Egypt', 'Egipt', NULL, 1),
  (826, 'GB', 'GBR', 'United Kingdom', 'Velika Britanija', NULL, 1),
  (831, 'GG', 'GGY', 'Guernsey', 'Otok Guernsey', NULL, 1),
  (832, 'JE', 'JEY', 'Jersey', 'Otok Jersey', NULL, 1),
  (833, 'IM', 'IMN', 'Isle of Man', 'Otok Man', NULL, 1),
  (834, 'TZ', 'TZA', 'Tanzania, United Republic of', 'Tanzanija', NULL, 1),
  (840, 'US', 'USA', 'United States', 'Združene države Amerike', NULL, 1),
  (850, 'VI', 'VIR', 'Virgin Islands, U.S.', 'Ameriški Deviški otoki', NULL, 1),
  (854, 'BF', 'BFA', 'Burkina Faso', 'Burkina Faso', NULL, 1),
  (858, 'UY', 'URY', 'Uruguay', 'Urugvaj', NULL, 1),
  (860, 'UZ', 'UZB', 'Uzbekistan', 'Uzbekistan', NULL, 1),
  (862, 'VE', 'VEN', 'Venezuela, Bolivarian Republic of', 'Venezuela', NULL, 1),
  (876, 'WF', 'WLF', 'Wallis and Futuna', 'Otočje Valis in Futuna', NULL, 1),
  (882, 'WS', 'WSM', 'Samoa', 'Samoa', NULL, 1),
  (887, 'YE', 'YEM', 'Yemen', 'Jemen', NULL, 1),
  (894, 'ZM', 'ZMB', 'Zambia', 'Zambija', NULL, 1);

INSERT INTO `obcina` (`ID_OBCINA`, `AKTIVNOST`, `MID_OBCINA`, `IME_OBCINA`) VALUES
  (1, 1, 11027962,	'Novo mesto'),
  (2, 1, 11027113,	'Mislinja'),
  (3, 1, 11027008,	'Kungota'),
  (4, 1, 11026982,	'Krško'),
  (5, 1, 11027822,	'Lendava'),
  (6, 1, 11027016,	'Lenart'),
  (7, 1, 11027105,	'Mežica'),
  (8, 1, 11027911,	'Miren-Kostanjevica'),
  (9, 1, 11027148,	'Murska Sobota'),
  (10, 1, 11027920,	'Mozirje'),
  (11, 1, 11027156,	'Nova Gorica'),
  (12, 1, 11027083,	'Majšperk'),
  (13, 1, 11026630,	'Cerklje na Gorenjskem'),
  (14, 1, 11026788,	'Dravograd'),
  (15, 1, 11027946,	'Naklo'),
  (16, 1, 11027857,	'Ljutomer'),
  (17, 1, 11027849,	'Ljubljana'),
  (18, 1, 11027032,	'Ljubno'),
  (19, 1, 11027075,	'Luče'),
  (20, 1, 11027091,	'Mengeš'),
  (21, 1, 11027806,	'Kuzma'),
  (22, 1, 11027067,	'Loški Potok'),
  (23, 1, 11027121,	'Moravče'),
  (24, 1, 11026524,	'Beltinci'),
  (25, 1, 11026613,	'Tišina'),
  (26, 1, 11027750,	'Kobilje'),
  (27, 1, 11026958,	'Kobarid'),
  (28, 1, 11027776,	'Koper'),
  (29, 1, 11026796,	'Duplek'),
  (30, 1, 11026842,	'Gornji Petrovci'),
  (31, 1, 11026869,	'Grosuplje'),
  (32, 1, 11026893,	'Idrija'),
  (33, 1, 11027768,	'Komen'),
  (34, 1, 11026575,	'Bovec'),
  (35, 1, 11026516,	'Ajdovščina'),
  (36, 1, 11026834,	'Gornji Grad'),
  (37, 1, 11027709,	'Hrpelje-Kozina'),
  (38, 1, 11026923,	'Izola'),
  (39, 1, 11027199,	'Pesnica'),
  (40, 1, 11028012,	'Podvelka'),
  (41, 1, 11027261,	'Radlje ob Dravi'),
  (42, 1, 11027229,	'Postojna'),
  (43, 1, 11027440,	'Šentilj'),
  (44, 1, 11026877,	'Šalovci'),
  (45, 1, 11027253,	'Radenci'),
  (46, 1, 11026672,	'Črna na Koroškem'),
  (47, 1, 11026737,	'Dobrepolje'),
  (48, 1, 11026656,	'Cerkno'),
  (49, 1, 11026974,	'Kozje'),
  (50, 1, 11026915,	'Ivančna Gorica'),
  (51, 1, 11026605,	'Brežice'),
  (52, 1, 11028004,	'Pivka'),
  (53, 1, 11027245,	'Rače-Fram'),
  (54, 1, 11027423,	'Sveti Jurij ob Ščavnici'),
  (55, 1, 11027610,	'Velenje'),
  (56, 1, 11027164,	'Odranci'),
  (57, 1, 11027296,	'Ribnica'),
  (58, 1, 11027342,	'Semič'),
  (59, 1, 11027601,	'Turnišče'),
  (60, 1, 11027474,	'Škocjan'),
  (61, 1, 11027512,	'Šmarje pri Jelšah'),
  (62, 1, 11027563,	'Tolmin'),
  (63, 1, 21427705,	'Dobrna'),
  (64, 1, 11027636,	'Vipava'),
  (65, 1, 21427799,	'Jezersko'),
  (66, 1, 21428086,	'Sveti Andraž v Slov. goricah'),
  (67, 1, 21427926,	'Šempeter-Vrtojba'),
  (68, 1, 11027555,	'Štore'),
  (69, 1, 21428035,	'Polzela'),
  (70, 1, 21427764,	'Hodoš'),
  (71, 1, 21427918,	'Solčava'),
  (72, 1, 11027393,	'Slovenska Bistrica'),
  (73, 1, 11027288,	'Ravne na Koroškem'),
  (74, 1, 11027385,	'Slovenj Gradec'),
  (75, 1, 11027431,	'Šenčur'),
  (76, 1, 11028080,	'Vojnik'),
  (77, 1, 11027318,	'Rogašovci'),
  (78, 1, 11027237,	'Preddvor'),
  (79, 1, 11028039,	'Ptuj'),
  (80, 1, 21427900,	'Selnica ob Dravi'),
  (81, 1, 21427730,	'Grad'),
  (82, 1, 21436437,	'Apače'),
  (83, 1, 11027687,	'Zreče'),
  (84, 1, 11027695,	'Žiri'),
  (85, 1, 21427721,	'Dolenjske Toplice'),
  (86, 1, 11028098,	'Vuzenica'),
  (87, 1, 11028071,	'Vitanje'),
  (88, 1, 21427691,	'Dobje'),
  (89, 1, 21427969,	'Trzin'),
  (90, 1, 21427713,	'Dobrovnik'),
  (91, 1, 11026621,	'Celje'),
  (92, 1, 21428043,	'Prevalje'),
  (93, 1, 21428094,	'Velika Polana'),
  (94, 1, 11026699,	'Črnomelj'),
  (95, 1, 11028128,	'Železniki'),
  (96, 1, 21427683,	'Cerkvenjak'),
  (97, 1, 21427675,	'Cankova'),
  (98, 1, 21428078,	'Sveta Ana'),
  (99, 1, 21427888,	'Prebold'),
  (100, 1, 21427934,	'Tabor'),
  (101, 1, 21427942,	'Trnovska vas'),
  (102, 1, 11026818,	'Gorišnica'),
  (103, 1, 21436488,	'Poljčane'),
  (104, 1, 11027938,	'Muta'),
  (105, 1, 11027539,	'Šmartno ob Paki'),
  (106, 1, 11027547,	'Šoštanj'),
  (107, 1, 24063453,	'Renče-Vogrsko'),
  (108, 1, 24063461,	'Gorje'),
  (109, 1, 11027741,	'Kidričevo'),
  (110, 1, 21436445,	'Cirkulane'),
  (111, 1, 21428264,	'Šmartno pri Litiji'),
  (112, 1, 11028063,	'Videm'),
  (113, 1, 21427756,	'Hoče-Slivnica'),
  (114, 1, 21427853,	'Mirna Peč'),
  (115, 1, 11027407,	'Slovenske Konjice'),
  (116, 1, 11026702,	'Destrnik'),
  (117, 1, 21427870,	'Podlehnik'),
  (118, 1, 11026770,	'Dornava'),
  (119, 1, 21427748,	'Hajdina'),
  (120, 1, 11027172,	'Ormož'),
  (121, 1, 21427985,	'Žetale'),
  (122, 1, 21428051,	'Ribnica na Pohorju'),
  (123, 1, 21427977,	'Veržej'),
  (124, 1, 21427837,	'Križevci'),
  (125, 1, 21428019,	'Markovci'),
  (126, 1, 11026931,	'Juršinci'),
  (127, 1, 11027415,	'Starše'),
  (128, 1, 21427993,	'Žužemberk'),
  (129, 1, 11027377,	'Sežana'),
  (130, 1, 11027466,	'Šentjur'),
  (131, 1, 21433659,	'Straža'),
  (132, 1, 11026532,	'Bled'),
  (133, 1, 11026761,	'Domžale'),
  (134, 1, 21433667,	'Sveta Trojica v Slovenskih goricah'),
  (135, 1, 11027326,	'Rogaška Slatina'),
  (136, 1, 21428060,	'Sodražica'),
  (137, 1, 11027873,	'Lukovica'),
  (138, 1, 24063488,	'Rečica ob Savinji'),
  (139, 1, 11026583,	'Brda'),
  (140, 1, 24063496,	'Sveti Jurij v Slovenskih goricah'),
  (141, 1, 11026826,	'Gornja Radgona'),
  (142, 1, 11026559,	'Bohinj'),
  (143, 1, 11026664,	'Črenšovci'),
  (144, 1, 11027270,	'Radovljica'),
  (145, 1, 21428108,	'Vransko'),
  (146, 1, 21427624,	'Benedikt'),
  (147, 1, 21433683,	'Šmarješke Toplice'),
  (148, 1, 21436453,	'Kostanjevica na Krki'),
  (149, 1, 21427802,	'Komenda'),
  (150, 1, 11027580,	'Trebnje'),
  (151, 1, 24063500,	'Šentrupert'),
  (152, 1, 11027792,	'Kranjska Gora'),
  (153, 1, 11026729,	'Divača'),
  (154, 1, 11026745,	'Dobrova-Polhov Gradec'),
  (155, 1, 11027652,	'Vrhnika'),
  (156, 1, 21427667,	'Braslovče'),
  (157, 1, 24063526,	'Ankaran'),
  (158, 1, 11027628,	'Velike Lašče'),
  (159, 1, 11026753,	'Dol pri Ljubljani'),
  (160, 1, 11027865,	'Loška dolina'),
  (161, 1, 21427772,	'Horjul'),
  (162, 1, 24063518,	'Mirna'),
  (163, 1, 11026567,	'Borovnica'),
  (164, 1, 11027717,	'Ilirska Bistrica'),
  (165, 1, 24063470,	'Log-Dragomer'),
  (166, 1, 11027814,	'Laško'),
  (167, 1, 11027890,	'Medvode'),
  (168, 1, 11028055,	'Radeče'),
  (169, 1, 11026907,	'Ig'),
  (170, 1, 11027059,	'Logatec'),
  (171, 1, 11027504,	'Škofljica'),
  (172, 1, 21427659,	'Bloke'),
  (173, 1, 11026591,	'Brezovica'),
  (174, 1, 11026800,	'Gorenja vas-Poljane'),
  (175, 1, 21428116,	'Žirovnica'),
  (176, 1, 11027725,	'Jesenice'),
  (177, 1, 11027679,	'Zagorje ob Savi'),
  (178, 1, 21427845,	'Lovrenc na Pohorju'),
  (179, 1, 11027881,	'Maribor'),
  (180, 1, 11027954,	'Nazarje'),
  (181, 1, 11027334,	'Ruše'),
  (182, 1, 21428027,	'Miklavž na Dravskem polju'),
  (183, 1, 11027997,	'Piran'),
  (184, 1, 11027482,	'Škofja Loka'),
  (185, 1, 21427861,	'Oplotnica'),
  (186, 1, 21436461,	'Makole'),
  (187, 1, 11026885,	'Hrastnik'),
  (188, 1, 11026648,	'Cerknica'),
  (189, 1, 11027024,	'Litija'),
  (190, 1, 11027989,	'Osilnica'),
  (191, 1, 11027903,	'Metlika'),
  (192, 1, 11027571,	'Trbovlje'),
  (193, 1, 21436470,	'Mokronog-Trebelno'),
  (194, 1, 21427632,	'Bistrica ob Sotli'),
  (195, 1, 11027598,	'Tržič'),
  (196, 1, 11026966,	'Kočevje'),
  (197, 1, 11026940,	'Kanal'),
  (198, 1, 11027644,	'Vodice'),
  (199, 1, 21427829,	'Kostel'),
  (200, 1, 11027130,	'Moravske Toplice'),
  (201, 1, 11027369,	'Sevnica'),
  (202, 1, 21428124,	'Žalec'),
  (203, 1, 21433675,	'Sveti Tomaž'),
  (204, 1, 11027784,	'Kranj'),
  (205, 1, 21427896,	'Razkrižje'),
  (206, 1, 11027202,	'Podčetrtek'),
  (207, 1, 11028047,	'Puconci'),
  (208, 1, 11027458,	'Šentjernej'),
  (209, 1, 11027300,	'Rogatec'),
  (210, 1, 11027733,	'Kamnik'),
  (211, 1, 11028101,	'Zavrč'),
  (212, 1, 21433632,	'Središče ob Dravi');

INSERT INTO `tpo`.`letnik`
(`ID_LETNIK`, `LETNIK`)VALUES
  (1,1),
  (2,2),
  (3,3);

INSERT INTO `posta` (`ID_POSTA`, `AKTIVNOST`, `MID_POSTA`, `ST_POSTA`,  `KRAJ`) VALUES
  (1, 1, 21428698,	8321,	'Brusnice'),
  (2, 1, 21431125,	8222,	'Otočec'),
  (3, 1, 21431656,	5297,	'Prvačina'),
  (4, 1, 21432539,	5261,	'Šempas'),
  (5, 1, 21429481,	5251,	'Grgar'),
  (6, 1, 21428850,	5253,	'Čepovan'),
  (7, 1, 21432954,	5252,	'Trnovo pri Gorici'),
  (8, 1, 21431036,	8000,	'Novo mesto'),
  (9, 1, 21430854,	2382,	'Mislinja'),
  (10, 1, 21433420,	2201,	'Zgornja Kungota'),
  (11, 1, 21430412,	1231,	'Ljubljana - Črnuče'),
  (12, 1, 21430447,	1260,	'Ljubljana - Polje'),
  (13, 1, 21431150,	2211,	'Pesnica pri Mariboru'),
  (14, 1, 21429856,	2351,	'Kamnica'),
  (15, 1, 21430307,	9220,	'Lendava - Lendva'),
  (16, 1, 21433284,	2232,	'Voličina'),
  (17, 1, 21431834,	5292,	'Renče'),
  (18, 1, 21430064,	5296,	'Kostanjevica na Krasu'),
  (19, 1, 21430234,	8270,	'Krško'),
  (20, 1, 21430188,	9242,	'Križevci pri Ljutomeru'),
  (21, 1, 21430463,	1211,	'Ljubljana - Šmartno'),
  (22, 1, 21430668,	9243,	'Mala Nedelja'),
  (23, 1, 21430293,	2230,	'Lenart v Slov. goricah'),
  (24, 1, 21432024,	8281,	'Senovo'),
  (25, 1, 21431672,	2323,	'Ptujska gora'),
  (26, 1, 21431141,	2231,	'Pernica'),
  (27, 1, 21428469,	8283,	'Blanca'),
  (28, 1, 21430790,	2392,	'Mežica'),
  (29, 1, 21431613,	2391,	'Prevalje'),
  (30, 1, 21430820,	5291,	'Miren'),
  (31, 1, 21432822,	3325,	'Šoštanj'),
  (32, 1, 21430951,	9000,	'Murska Sobota'),
  (33, 1, 21433144,	9241,	'Veržej'),
  (34, 1, 21430641,	2322,	'Majšperk'),
  (35, 1, 21430986,	3331,	'Nazarje'),
  (36, 1, 21430943,	3330,	'Mozirje'),
  (37, 1, 21431010,	5000,	'Nova Gorica'),
  (38, 1, 21430439,	1261,	'Ljubljana - Dobrunje'),
  (39, 1, 21431354,	4244,	'Podnart'),
  (40, 1, 21430765,	1215,	'Medvode'),
  (41, 1, 21432644,	1296,	'Šentvid pri Stični'),
  (42, 1, 21429775,	8261,	'Jesenice na Dolenjskem'),
  (43, 1, 21428744,	4207,	'Cerklje na Gorenjskem'),
  (44, 1, 21429422,	6272,	'Gračišče'),
  (45, 1, 21429228,	2370,	'Dravograd'),
  (46, 1, 21428884,	6275,	'Črni Kal'),
  (47, 1, 21429333,	5275,	'Godovič'),
  (48, 1, 21430978,	4202,	'Naklo'),
  (49, 1, 21429236,	4203,	'Duplje'),
  (50, 1, 21430757,	4211,	'Mavčiče'),
  (51, 1, 21430480,	9240,	'Ljutomer'),
  (52, 1, 21430455,	1210,	'Ljubljana - Šentvid'),
  (53, 1, 21430404,	1000,	'Ljubljana'),
  (54, 1, 21431559,	4205,	'Preddvor'),
  (55, 1, 21433403,	4201,	'Zgornja Besnica'),
  (56, 1, 21433551,	4209,	'Žabnica'),
  (57, 1, 21430471,	3333,	'Ljubno ob Savinji'),
  (58, 1, 21430617,	3334,	'Luče'),
  (59, 1, 21430773,	1234,	'Mengeš'),
  (60, 1, 21429341,	4204,	'Golnik'),
  (61, 1, 21430242,	9263,	'Kuzma'),
  (62, 1, 21430587,	1318,	'Loški Potok'),
  (63, 1, 21430897,	1251,	'Moravče'),
  (64, 1, 21428396,	9231,	'Beltinci'),
  (65, 1, 21431451,	4223,	'Poljane nad Škofjo Loko'),
  (66, 1, 21430382,	3202,	'Ljubečna'),
  (67, 1, 21430994,	1357,	'Notranje Gorice'),
  (68, 1, 21431591,	1352,	'Preserje'),
  (69, 1, 21429961,	9227,	'Kobilje'),
  (70, 1, 21429953,	5222,	'Kobarid'),
  (71, 1, 21430030,	6000,	'Koper - Capodistria'),
  (72, 1, 21433349,	2367,	'Vuzenica'),
  (73, 1, 21432229,	2241,	'Spodnji Duplek'),
  (74, 1, 21432717,	6274,	'Šmarje'),
  (75, 1, 21428914,	5262,	'Črniče'),
  (76, 1, 21431168,	9203,	'Petrovci'),
  (77, 1, 21432512,	9204,	'Šalovci'),
  (78, 1, 21430170,	9206,	'Križevci'),
  (79, 1, 21429520,	1290,	'Grosuplje'),
  (80, 1, 21432261,	8256,	'Sromlje'),
  (81, 1, 21433390,	8272,	'Zdole'),
  (82, 1, 21429651,	5280,	'Idrija'),
  (83, 1, 21431192,	8255,	'Pišece'),
  (84, 1, 21428434,	8259,	'Bizeljsko'),
  (85, 1, 21429821,	5214,	'Kal nad Kanalom'),
  (86, 1, 21429864,	1241,	'Kamnik'),
  (87, 1, 21430340,	2372,	'Libeliče'),
  (88, 1, 21429104,	1431,	'Dol pri Hrastniku'),
  (89, 1, 21433373,	1303,	'Zagradec'),
  (90, 1, 21430013,	6223,	'Komen'),
  (91, 1, 21428345,	6280,	'Ankaran - Ancarano'),
  (92, 1, 21428833,	5273,	'Col'),
  (93, 1, 21428566,	5230,	'Bovec'),
  (94, 1, 21429899,	8258,	'Kapele'),
  (95, 1, 21428337,	5270,	'Ajdovščina'),
  (96, 1, 21429406,	3342,	'Gornji Grad'),
  (97, 1, 21432768,	3341,	'Šmartno ob Dreti'),
  (98, 1, 21428361,	8253,	'Artiče'),
  (99, 1, 21430102,	6240,	'Kozina'),
  (100, 1, 21429716,	6310,	'Izola - Isola'),
  (101, 1, 21430684,	6273,	'Marezige'),
  (102, 1, 21431893,	5215,	'Ročinj'),
  (103, 1, 21432679,	6281,	'Škofije'),
  (104, 1, 21432598,	2373,	'Šentjanž pri Dravogradu'),
  (105, 1, 21433195,	5271,	'Vipava'),
  (106, 1, 21432695,	3211,	'Škofja vas'),
  (107, 1, 21431257,	8312,	'Podbočje'),
  (108, 1, 21429015,	8257,	'Dobova'),
  (109, 1, 21428680,	4210,	'Brnik - Aerodrom'),
  (110, 1, 21429732,	2221,	'Jarenina'),
  (111, 1, 21431907,	3250,	'Rogaška Slatina'),
  (112, 1, 21431397,	2363,	'Podvelka'),
  (113, 1, 21430099,	2394,	'Kotlje'),
  (114, 1, 21428558,	8294,	'Boštanj'),
  (115, 1, 21432415,	8293,	'Studenec'),
  (116, 1, 21429830,	3233,	'Kalobje'),
  (117, 1, 21428809,	2215,	'Ceršak'),
  (118, 1, 21429376,	3263,	'Gorica pri Slivnici'),
  (119, 1, 21430161,	4294,	'Križe'),
  (120, 1, 21432369,	8322,	'Stopiče'),
  (121, 1, 21431516,	6230,	'Postojna'),
  (122, 1, 21432474,	9244,	'Sveti Jurij ob Ščavnici'),
  (123, 1, 21429988,	1338,	'Kočevska Reka'),
  (124, 1, 21432407,	1313,	'Struge'),
  (125, 1, 21430196,	1301,	'Krka'),
  (126, 1, 21431249,	6276,	'Pobegi'),
  (127, 1, 21428949,	6271,	'Dekani'),
  (128, 1, 21433179,	2284,	'Videm pri Ptuju'),
  (129, 1, 21431745,	9252,	'Radenci'),
  (130, 1, 21430226,	8262,	'Krška vas'),
  (131, 1, 21428752,	8263,	'Cerklje ob Krki'),
  (132, 1, 21432709,	1291,	'Škofljica'),
  (133, 1, 21432725,	1293,	'Šmarje - Sap'),
  (134, 1, 21433217,	1294,	'Višnja Gora'),
  (135, 1, 21432296,	1332,	'Stara Cerkev'),
  (136, 1, 21428701,	3255,	'Buče'),
  (137, 1, 21428876,	2393,	'Črna na Koroškem'),
  (138, 1, 21433152,	1312,	'Videm - Dobrepolje'),
  (139, 1, 21431273,	3254,	'Podčetrtek'),
  (140, 1, 21433608,	4226,	'Оiri'),
  (141, 1, 21432881,	9251,	'Tišina'),
  (142, 1, 21432202,	5281,	'Spodnja Idrija'),
  (143, 1, 21428787,	5282,	'Cerkno'),
  (144, 1, 21432814,	3201,	'Šmartno v Rožni dolini'),
  (145, 1, 21430323,	3261,	'Lesično'),
  (146, 1, 21432199,	4225,	'Sovodenj'),
  (147, 1, 21430129,	3260,	'Kozje'),
  (148, 1, 21433039,	1311,	'Turjak'),
  (149, 1, 21429686,	1295,	'Ivančna Gorica'),
  (150, 1, 21428671,	8250,	'Brežice'),
  (151, 1, 21431109,	1316,	'Ortnek'),
  (152, 1, 21431966,	6333,	'Sečovlje - Sicciole'),
  (153, 1, 21433128,	1315,	'Velike Lašče'),
  (154, 1, 21431206,	6257,	'Pivka'),
  (155, 1, 21429627,	6225,	'Hruševje'),
  (156, 1, 21431729,	2327,	'Rače'),
  (157, 1, 21429295,	2313,	'Fram'),
  (158, 1, 21429244,	6221,	'Dutovlje'),
  (159, 1, 21430579,	6219,	'Lokev'),
  (160, 1, 21431052,	9233,	'Odranci'),
  (161, 1, 21431842,	1310,	'Ribnica'),
  (162, 1, 21432008,	8333,	'Semič'),
  (163, 1, 21429279,	2343,	'Fala'),
  (164, 1, 21433047,	9224,	'Turnišče'),
  (165, 1, 21432580,	8297,	'Šentjanž'),
  (166, 1, 21432792,	2383,	'Šmartno pri Slovenj Gradcu'),
  (167, 1, 21429007,	3224,	'Dobje pri Planini'),
  (168, 1, 21428710,	8276,	'Bučka'),
  (169, 1, 21432733,	3240,	'Šmarje pri Jelšah'),
  (170, 1, 21433012,	8295,	'Tržišče'),
  (171, 1, 21432571,	2212,	'Šentilj v Slov. goricah'),
  (172, 1, 21433322,	2365,	'Vuhred'),
  (173, 1, 21432890,	5220,	'Tolmin'),
  (174, 1, 21429040,	3204,	'Dobrna'),
  (175, 1, 21433535,	3214,	'Zreče'),
  (176, 1, 21433489,	4206,	'Zgornje Jezersko'),
  (177, 1, 21433241,	2255,	'Vitomarci'),
  (178, 1, 21432547,	5290,	'Šempeter pri Gorici'),
  (179, 1, 21432377,	3206,	'Stranice'),
  (180, 1, 21430005,	5211,	'Kojsko'),
  (181, 1, 21431133,	2361,	'Ožbalt'),
  (182, 1, 21432458,	2353,	'Sv. Duh na Ostrem Vrhu'),
  (183, 1, 21431982,	2352,	'Selnica ob Dravi'),
  (184, 1, 21432130,	5232,	'Soča'),
  (185, 1, 21431869,	2364,	'Ribnica na Pohorju'),
  (186, 1, 21429902,	2362,	'Kapla'),
  (187, 1, 21431486,	3313,	'Polzela'),
  (188, 1, 21429210,	3222,	'Dramlje'),
  (189, 1, 21430498,	3215,	'Loče'),
  (190, 1, 21432776,	3327,	'Šmartno ob Paki'),
  (191, 1, 21431087,	2312,	'Orehova vas'),
  (192, 1, 21429562,	9205,	'Hodoš - Hodos'),
  (193, 1, 21432156,	3335,	'Solčava'),
  (194, 1, 21429201,	8343,	'Dragatuš'),
  (195, 1, 21432105,	2310,	'Slovenska Bistrica'),
  (196, 1, 21431818,	2390,	'Ravne na Koroškem'),
  (197, 1, 21432750,	2315,	'Šmartno na Pohorju'),
  (198, 1, 21431079,	2317,	'Oplotnica'),
  (199, 1, 21432563,	4208,	'Šenčur'),
  (200, 1, 21433268,	3212,	'Vojnik'),
  (201, 1, 21433209,	4212,	'Visoko'),
  (202, 1, 21431915,	9262,	'Rogašovci'),
  (203, 1, 21433357,	8292,	'Zabukovje'),
  (204, 1, 21430072,	6256,	'Košana'),
  (205, 1, 21431494,	3232,	'Ponikva'),
  (206, 1, 21431583,	1276,	'Primskovo'),
  (207, 1, 21430927,	5216,	'Most na Soči'),
  (208, 1, 21432300,	8342,	'Stari trg ob Kolpi'),
  (209, 1, 21429449,	9264,	'Grad'),
  (210, 1, 21428353,	9253,	'Apače'),
  (211, 1, 21431265,	5243,	'Podbrdo'),
  (212, 1, 21429708,	1411,	'Izlake'),
  (213, 1, 21429155,	8350,	'Dolenjske Toplice'),
  (214, 1, 21433225,	3205,	'Vitanje'),
  (215, 1, 21431303,	2381,	'Podgorje pri Slovenj Gradcu'),
  (216, 1, 21432997,	1236,	'Trzin'),
  (217, 1, 21429546,	8362,	'Hinje'),
  (218, 1, 21432270,	5224,	'Srpenica'),
  (219, 1, 21430510,	5231,	'Log pod Mangartom'),
  (220, 1, 21428736,	3000,	'Celje'),
  (221, 1, 21433110,	9225,	'Velika Polana'),
  (222, 1, 21428922,	8340,	'Črnomelj'),
  (223, 1, 21433586,	4228,	'Železniki'),
  (224, 1, 21431532,	3312,	'Prebold'),
  (225, 1, 21432865,	3304,	'Tabor'),
  (226, 1, 21428728,	9261,	'Cankova'),
  (227, 1, 21432962,	2254,	'Trnovska vas'),
  (228, 1, 21429252,	8361,	'Dvor'),
  (229, 1, 21432172,	4229,	'Sorica'),
  (230, 1, 21433187,	8344,	'Vinica'),
  (231, 1, 21428990,	1233,	'Dob'),
  (232, 1, 21431761,	1235,	'Radomlje'),
  (233, 1, 21431419,	2208,	'Pohorje'),
  (234, 1, 21432083,	5283,	'Slap ob Idrijci'),
  (235, 1, 21430749,	6242,	'Materija'),
  (236, 1, 21432440,	2233,	'Sv. Ana v Slov. goricah'),
  (237, 1, 21433055,	8323,	'Uršna sela'),
  (238, 1, 21430595,	2324,	'Lovrenc na Dravskem polju'),
  (239, 1, 21430714,	2281,	'Markovci'),
  (240, 1, 21431427,	2257,	'Polenšak'),
  (241, 1, 21433276,	5293,	'Volčja Draga'),
  (242, 1, 21429929,	2325,	'Kidričevo'),
  (243, 1, 21428612,	8280,	'Brestanica'),
  (244, 1, 21431753,	2360,	'Radlje ob Dravi'),
  (245, 1, 21431508,	6320,	'Portorož - Portorose'),
  (246, 1, 21432784,	1275,	'Šmartno pri Litiji'),
  (247, 1, 21430803,	2204,	'Miklavž na Dravskem polju'),
  (248, 1, 21429554,	2311,	'Hoče'),
  (249, 1, 21430846,	8216,	'Mirna Peč'),
  (250, 1, 21432113,	3210,	'Slovenske Konjice'),
  (251, 1, 21429309,	3213,	'Frankolovo'),
  (252, 1, 21430676,	2229,	'Malečnik'),
  (253, 1, 21431281,	2273,	'Podgorci'),
  (254, 1, 21431664,	2250,	'Ptuj'),
  (255, 1, 21428973,	2253,	'Destrnik'),
  (256, 1, 21432873,	3221,	'Teharje'),
  (257, 1, 21431338,	2286,	'Podlehnik'),
  (258, 1, 21429171,	2252,	'Dornava'),
  (259, 1, 21429848,	4246,	'Kamna Gorica'),
  (260, 1, 21431095,	2270,	'Ormož'),
  (261, 1, 21433594,	2287,	'Žetale'),
  (262, 1, 21429538,	2288,	'Hajdina'),
  (263, 1, 21431460,	2319,	'Poljčane'),
  (264, 1, 21428370,	4275,	'Begunje na Gorenjskem'),
  (265, 1, 21428655,	4243,	'Brezje'),
  (266, 1, 21433080,	3320,	'Velenje'),
  (267, 1, 21430706,	2206,	'Marjeta na Dravskem polju'),
  (268, 1, 21432849,	6222,	'Štanjel'),
  (269, 1, 21428531,	4265,	'Bohinjsko jezero'),
  (270, 1, 21430048,	8282,	'Koprivnica'),
  (271, 1, 21429813,	2256,	'Juršinci'),
  (272, 1, 21431389,	3257,	'Podsreda'),
  (273, 1, 21432326,	2205,	'Starše'),
  (274, 1, 21429384,	2272,	'Gorišnica'),
  (275, 1, 21431524,	2331,	'Pragersko'),
  (276, 1, 21428817,	2326,	'Cirkovce'),
  (277, 1, 21432903,	3326,	'Topolšica'),
  (278, 1, 21432067,	6210,	'Sežana'),
  (279, 1, 21428795,	2236,	'Cerkvenjak'),
  (280, 1, 21432504,	2258,	'Sv.Tomaž'),
  (281, 1, 21428825,	2282,	'Cirkulane'),
  (282, 1, 21428639,	2354,	'Bresternica'),
  (283, 1, 21431974,	4227,	'Selca'),
  (284, 1, 21429325,	8254,	'Globoko'),
  (285, 1, 21429074,	9223,	'Dobrovnik - Dobronak'),
  (286, 1, 21432610,	3230,	'Šentjur'),
  (287, 1, 21428477,	4260,	'Bled'),
  (288, 1, 21429511,	3231,	'Grobelno'),
  (289, 1, 21429163,	1230,	'Domžale'),
  (290, 1, 21432466,	2235,	'Sv. Trojica v Slov. goricah'),
  (291, 1, 21428400,	2234,	'Benedikt'),
  (292, 1, 21429198,	1319,	'Draga'),
  (293, 1, 21429147,	1331,	'Dolenja vas'),
  (294, 1, 21428515,	4263,	'Bohinjska Bela'),
  (295, 1, 21431176,	3301,	'Petrovče'),
  (296, 1, 21432148,	1317,	'Sodražica'),
  (297, 1, 21429937,	1412,	'Kisovec'),
  (298, 1, 21430625,	1225,	'Lukovica'),
  (299, 1, 21432237,	9245,	'Spodnji Ivanjci'),
  (300, 1, 21430218,	4245,	'Kropa'),
  (301, 1, 21430315,	4248,	'Lesce'),
  (302, 1, 21429082,	5212,	'Dobrovo v Brdih'),
  (303, 1, 21429392,	9250,	'Gornja Radgona'),
  (304, 1, 21433365,	1410,	'Zagorje ob Savi'),
  (305, 1, 21431001,	3203,	'Nova Cerkev'),
  (306, 1, 21433454,	2213,	'Zgornja Velka'),
  (307, 1, 21428523,	4264,	'Bohinjska Bistrica'),
  (308, 1, 21432253,	4267,	'Srednja vas v Bohinju'),
  (309, 1, 21432741,	8220,	'Šmarješke Toplice'),
  (310, 1, 21432601,	8310,	'Šentjernej'),
  (311, 1, 21428868,	9232,	'Črenšovci'),
  (312, 1, 21429503,	3302,	'Griže'),
  (313, 1, 21431770,	4240,	'Radovljica'),
  (314, 1, 21433292,	3305,	'Vransko'),
  (315, 1, 21430056,	8311,	'Kostanjevica na Krki'),
  (316, 1, 21429694,	2259,	'Ivanjkovci'),
  (317, 1, 21432652,	8275,	'Škocjan'),
  (318, 1, 21432393,	8351,	'Straža pri Novem mestu'),
  (319, 1, 21428957,	5210,	'Deskle'),
  (320, 1, 21431214,	6232,	'Planina'),
  (321, 1, 21430200,	8296,	'Krmelj'),
  (322, 1, 21433314,	1360,	'Vrhnika'),
  (323, 1, 21430021,	1218,	'Komenda'),
  (324, 1, 21432946,	8210,	'Trebnje'),
  (325, 1, 21432636,	8232,	'Šentrupert'),
  (326, 1, 21429643,	4276,	'Hrušica'),
  (327, 1, 21431605,	6258,	'Prestranek'),
  (328, 1, 21429350,	3303,	'Gomilsko'),
  (329, 1, 21432687,	4220,	'Škofja Loka'),
  (330, 1, 21429945,	6253,	'Knežak'),
  (331, 1, 21429414,	4282,	'Gozd Martuljek'),
  (332, 1, 21430145,	4280,	'Kranjska Gora'),
  (333, 1, 21428981,	6215,	'Divača'),
  (334, 1, 21432628,	3271,	'Šentrupert'),
  (335, 1, 21433306,	6217,	'Vremski Britof'),
  (336, 1, 21431044,	6243,	'Obrov'),
  (337, 1, 21431346,	5272,	'Podnanos'),
  (338, 1, 21432032,	6224,	'Senožeče'),
  (339, 1, 21429066,	1356,	'Dobrova'),
  (340, 1, 21428841,	1413,	'Čemšenik'),
  (341, 1, 21432911,	2371,	'Trbonje'),
  (342, 1, 21433411,	2242,	'Zgornja Korena'),
  (343, 1, 21429473,	5242,	'Grahovo ob Bači'),
  (344, 1, 21429791,	2223,	'Jurovski Dol'),
  (345, 1, 21432555,	3311,	'Šempeter v Savinjski dolini'),
  (346, 1, 21433527,	1432,	'Zidani Most'),
  (347, 1, 21433462,	4247,	'Zgornje Gorje'),
  (348, 1, 21428485,	4273,	'Blejska Dobrava'),
  (349, 1, 21431788,	8274,	'Raka'),
  (350, 1, 21430331,	8273,	'Leskovec pri Krškem'),
  (351, 1, 21432164,	5250,	'Solkan'),
  (352, 1, 21428582,	3314,	'Braslovče'),
  (353, 1, 21431621,	3262,	'Prevorje'),
  (354, 1, 21430935,	1221,	'Motnik'),
  (355, 1, 21429112,	1262,	'Dol pri Ljubljani'),
  (356, 1, 21432318,	1386,	'Stari trg pri Ložu'),
  (357, 1, 21431567,	6255,	'Prem'),
  (358, 1, 21431362,	3241,	'Podplat'),
  (359, 1, 21428540,	1353,	'Borovnica'),
  (360, 1, 21429678,	6250,	'Ilirska Bistrica'),
  (361, 1, 21430285,	1219,	'Laze v Tuhinju'),
  (362, 1, 21430277,	3270,	'Laško'),
  (363, 1, 21428442,	1223,	'Blagovica'),
  (364, 1, 21430269,	2318,	'Laporje'),
  (365, 1, 21430889,	8230,	'Mokronog'),
  (366, 1, 21432121,	1216,	'Smlednik'),
  (367, 1, 21433438,	2316,	'Zgornja Ložnica'),
  (368, 1, 21433446,	2314,	'Zgornja Polskava'),
  (369, 1, 21431885,	1314,	'Rob'),
  (370, 1, 21429783,	3273,	'Jurklošter'),
  (371, 1, 21432288,	1242,	'Stahovica'),
  (372, 1, 21430552,	3223,	'Loka pri Оusmu'),
  (373, 1, 21430366,	2341,	'Limbuš'),
  (374, 1, 21429597,	1372,	'Hotedršica'),
  (375, 1, 21432482,	3264,	'Sveti Štefan'),
  (376, 1, 21430960,	2366,	'Muta'),
  (377, 1, 21431222,	3225,	'Planina pri Sevnici'),
  (378, 1, 21429180,	5294,	'Dornberk'),
  (379, 1, 21429724,	2222,	'Jakobski dol'),
  (380, 1, 21429660,	1292,	'Ig'),
  (381, 1, 21429023,	1423,	'Dobovec'),
  (382, 1, 21430536,	1370,	'Logatec'),
  (383, 1, 21428388,	1382,	'Begunje pri Cerknici'),
  (384, 1, 21433098,	8212,	'Velika Loka'),
  (385, 1, 21433101,	2274,	'Velika Nedelja'),
  (386, 1, 21431796,	1381,	'Rakek'),
  (387, 1, 21430838,	8233,	'Mirna'),
  (388, 1, 21428663,	1351,	'Brezovica pri Ljubljani'),
  (389, 1, 21429058,	8211,	'Dobrnič'),
  (390, 1, 21433624,	8360,	'Оužemberk'),
  (391, 1, 21433616,	4274,	'Оirovnica'),
  (392, 1, 21428906,	5274,	'Črni vrh nad Idrijo'),
  (393, 1, 21429368,	4224,	'Gorenja vas'),
  (394, 1, 21432342,	2289,	'Stoperce'),
  (395, 1, 21429767,	4270,	'Jesenice'),
  (396, 1, 21430609,	2344,	'Lovrenc na Pohorju'),
  (397, 1, 21432857,	3220,	'Štore'),
  (398, 1, 21430692,	2000,	'Maribor'),
  (399, 1, 21430811,	2275,	'Miklavž pri Ormožu'),
  (400, 1, 21431826,	3332,	'Rečica ob Savinji'),
  (401, 1, 21431940,	2342,	'Ruše'),
  (402, 1, 21429465,	1384,	'Grahovo'),
  (403, 1, 21432989,	1222,	'Trojane'),
  (404, 1, 21432091,	2380,	'Slovenj Gradec'),
  (405, 1, 21429589,	1354,	'Horjul'),
  (406, 1, 21428418,	2345,	'Bistrica ob Dravi'),
  (407, 1, 21431184,	6330,	'Piran - Pirano'),
  (408, 1, 21430528,	1358,	'Log pri Brezovici'),
  (409, 1, 21430650,	2321,	'Makole'),
  (410, 1, 21431320,	1414,	'Podkum'),
  (411, 1, 21428892,	3272,	'Rimske Toplice'),
  (412, 1, 21430544,	1434,	'Loka pri Zidanem Mostu'),
  (413, 1, 21431028,	1385,	'Nova Vas'),
  (414, 1, 21428493,	9265,	'Bodonci'),
  (415, 1, 21429759,	6254,	'Jelšane'),
  (416, 1, 21429619,	1430,	'Hrastnik'),
  (417, 1, 21428779,	1380,	'Cerknica'),
  (418, 1, 21431478,	1272,	'Polšnik'),
  (419, 1, 21431737,	1433,	'Radeče'),
  (420, 1, 21430374,	1270,	'Litija'),
  (421, 1, 21431117,	1337,	'Osilnica'),
  (422, 1, 21431923,	3252,	'Rogatec'),
  (423, 1, 21431630,	3253,	'Pristava pri Mestinju'),
  (424, 1, 21430781,	8330,	'Metlika'),
  (425, 1, 21432920,	1420,	'Trbovlje'),
  (426, 1, 21431800,	4283,	'Rateče Planica'),
  (427, 1, 21430862,	4281,	'Mojstrana'),
  (428, 1, 21428426,	3256,	'Bistrica ob Sotli'),
  (429, 1, 21433004,	4290,	'Tržič'),
  (430, 1, 21432423,	8331,	'Suhor'),
  (431, 1, 21432075,	2214,	'Sladki Vrh'),
  (432, 1, 21432938,	8231,	'Trebelno'),
  (433, 1, 21429970,	1330,	'Kočevje'),
  (434, 1, 21429457,	8332,	'Gradac'),
  (435, 1, 21428507,	9222,	'Bogojina'),
  (436, 1, 21433063,	1252,	'Vače'),
  (437, 1, 21429872,	5213,	'Kanal'),
  (438, 1, 21431958,	1282,	'Sava'),
  (439, 1, 21430153,	1281,	'Kresnice'),
  (440, 1, 21431648,	9207,	'Prosenjakovci - Pсrtosfalva'),
  (441, 1, 21429287,	9208,	'Fokovci'),
  (442, 1, 21433250,	1217,	'Vodice'),
  (443, 1, 21433071,	1336,	'Kostel'),
  (444, 1, 21433136,	8213,	'Veliki Gaber'),
  (445, 1, 21428329,	8341,	'Adlešiči'),
  (446, 1, 21431311,	6244,	'Podgrad'),
  (447, 1, 21430722,	9221,	'Martjanci'),
  (448, 1, 21431699,	9201,	'Puconci'),
  (449, 1, 21433519,	2285,	'Zgornji Leskovec'),
  (450, 1, 21430919,	9226,	'Moravske Toplice'),
  (451, 1, 21432059,	8290,	'Sevnica'),
  (452, 1, 21429031,	5263,	'Dobravlje'),
  (453, 1, 21428574,	5295,	'Branik'),
  (454, 1, 21433560,	3310,	'Оalec'),
  (455, 1, 21430137,	4000,	'Kranj'),
  (456, 1, 24034658,	9246,	'Razkrižje'),
  (457, 1, 21429139,	1273,	'Dole pri Litiji'),
  (458, 1, 21429317,	1274,	'Gabrovka'),
  (459, 1, 21431435,	1355,	'Polhov Gradec'),
  (460, 1, 21431931,	1373,	'Rovte'),
  (461, 1, 21430633,	9202,	'Mačkovci'),
  (462, 1, 21433381,	2283,	'Zavrč'),
  (463, 1, 21432245,	2277,	'Središče ob Dravi'),
  (464, 1, 21428604,	5223,	'Breginj'),
  (465, 1, 21429996,	2276,	'Kog'),
  (466, 1, 21431290,	6216,	'Podgorje');


INSERT INTO `tpo`.`nacin_studija`
(`ID_NACIN`,`OPIS_NACIN`,`ANG_OPIS_NACIN`,`AKTIVNOST`)VALUES
  (1,'redni','full-time',1),
  (2,'izredni','part-time',1);


INSERT INTO `tpo`.`oblika_studija`
(`ID_OBLIKA`,`NAZIV_OBLIKA`,`ANG_OPIS_OBLIKA`,`AKTIVNOST`)VALUES
  (1,'na lokaciji','on site','e-learning'),
  (2,'na daljavo','distance learning','e-learning'),
  (3,'e-studij','e-studij','e-learning');

INSERT INTO `tpo`.`vrsta_vpisa`
(`ID_VRSTAVPISA`,`OPIS_VPISA`,`AKTIVNOST`)VALUES
  (1,'Prvi vpis v letnik',1),
  (2,'Ponavlanje letnika',1),
  (3,'Prvi vpis v letnik/dodatno leto',1);

INSERT INTO `tpo`.`stopnja`(`ID_STOPNJA`, `NAZIV`,`SIFRA`,`MOZEN_VPIS`)VALUES
  (1,'Stari dodiplomski program-uni','123',0),
  (2,'Stari dodiplomski-visokosolski', '123',0),
  (3,'1. stopnja', '123',1),
  (4,'2. stopnja', '123',1),
  (5,'3. stopnja', '123',1),
  (6,'EM', '123',1),
  (7,'Stari magistrski studij', '123',0),
  (8,'Stari doktorski studij', '123',0);

INSERT INTO `tpo`.`program`(`ID_PROGRAM`, `ID_STOPNJA`, `SIFRA_PROGRAM`, `NAZIV_PROGRAM`,
                            `ST_SEMESTROV`,`SIFRA_EVS`,`AKTIVNOST`)VALUES
  (1,8,'LE','INF. SISTEMI IN ODLOČANJE - DR',4,1000479,1),
  (2,7,'L3','INFORMAC. SISTEMI IN ODLOČANJE - MAG',4,1000480,1),
  (3,4,'X5','Kognitivna znanost MAG II. st.',4,1000472,1),
  (4,3,'MM', 'Multimedija UN 1. st.',6,1001001,1),
  (5,4,'7002801','PEDAGOŠKO RAČ. IN INF. MAG-II. st.',4,1000977,1),
  (6,1,'L2','RAČUNAL. IN INFROMATIKA UN',9,1000475,1),
  (7,1,'P7','RAČUNAL. IN MATEMATIKA UN',8,1000425,1),
  (8,2,'HB','RAČUNAL. IN INFORMATIKA VS',6,1000477,1),
  (9,3,'VV','RAČUNAL. IN MATEMA. UN-I.ST',6,1000407,1),
  (10,4,'L1','RAČUNALN. IN INFORM. MAG II.ST',4,1000471,1),
  (11,3,'VT','RAČUNALN. IN INFORM. UN-I.ST',6,1000468,1),
  (12,3,'VU','RAČUNALN. IN INFORM. VS-I.ST',6,1000470,1),
  (13,5,'X6','RAČUNALNIŠ. IN INF. DR-III ST.',6,1000474,1),
  (14,8,'7E','RAČUNALNIŠTVO IN INF. - DR', 4,1000478,1),
  (15,7,'71','RAČUNALNIŠTVO IN INF. - MAG',4,1000481,1),
  (16,3,'02','RAČUNALNIŠTVO IN INF. - VIS',8,1000900,1),
  (17,3,'03','RAČUNALNIŠTVO IN INF. - VŠ',4,1000901,1),
  (18,4,'KP00','Račnalništvo in matematika MAG II. st.',4,1000934,1),
  (19,3,'Z2','Upravna informatika UN 1. st.',6,1000469,1),
  (20,5,'XU','Humanistika in družb.-DR. III',6,1000902,1);

INSERT INTO `tpo`.`studijsko_leto`(`ID_STUD_LETO`, `STUD_LETO`)VALUES
  (0,'2015/16'),
  (1,'2016/17'),
  (2,'2017/18'),
  (3,'2018/19'),
  (4,'2019/20'),
  (5,'2020/21'),
  (6,'2021/22'),
  (7,'2022/23'),
  (8,'2023/24');

  /*
  1-100 -- > Studenti
  100-200 -- > Profesorji. Mail je: imeP@uni-lj.si
  300 = Referent
  400 = Admin
   */

INSERT INTO `tpo`.`oseba`(`ID_OSEBA`,`EMAIL`,`UPORABNISKO_IME`,`GESLO`,`VRSTA_VLOGE`,`IME`,`PRIIMEK`,`TELEFONSKA_STEVILKA`, `SIFRA_IZVAJALCA`, `DATUM_ROJSTVA`)VALUES
  (1,     'ab0001@student.uni-lj.si',      'ab0001',      '123456',     's',       'Ana',    'Balon',    '040040040'     ,NULL, '17-06-1996'),
  (2,     'bc0002@student.uni-lj.si',      'bc0002',      '123456',     's',       'Borut',    'Čementarna',    '040040040'     ,NULL, '17-06-1996'  ),
  (3,     'cd0003@student.uni-lj.si',      'cd0003',      '123456',     's',       'Cvilko',    'Debeljak',    '040040040'     ,NULL, '17-06-1996'  ),
  (4,     'de0004@student.uni-lj.si',      'de0004',      '123456',     's',       'Demir',    'Ehratatan',    '040040040'     ,NULL , '17-06-1996' ),
  (5,     'ef0005@student.uni-lj.si',      'ef0005',      '123456',     's',       'Evelina',    'Frača',    '040040040'     ,NULL, '17-06-1996'  ),
  (6,     'fg0006@student.uni-lj.si',      'fg0006',      '123456',     's',       'Filip',    'Granata',    '040040040'     ,NULL, '17-06-1996'  ),
  (7,     'gh0007@student.uni-lj.si',      'gh0007',      '123456',     's',       'Gaja',    'Hurikan',    '040040040'     ,NULL, '17-06-1996'  ),
  (8,     'hi0008@student.uni-lj.si',      'hi0008',      '123456',     's',       'Hilda',    'Ilirai',    '040040040'     ,NULL, '17-06-1996'  ),
  (9,     'ij0009@student.uni-lj.si',      'ij0009',      '123456',     's',       'Ivo',    'Jezen',    '040040040'     ,NULL, '17-06-1996'  ),
  (10,     'jk0010@student.uni-lj.si',      'jk0010',      '123456',     's',       'Jovan',    'Klepec',    '040040040'     ,NULL, '17-06-1996'  ),
  (11,     'kl0011@student.uni-lj.si',      'kl0011',      '123456',     's',       'Klemen',    'Lizard',    '040040040'     ,NULL, '17-06-1996'  ),
  (12,     'lm0012@student.uni-lj.si',      'lm0012',      '123456',     's',       'LinWun',    'MunSon',    '040040040'     ,NULL, '17-06-1996'  ),
  (13,     'mn0013@student.uni-lj.si',      'mn0013',      '123456',     's',       'Milorad',    'Namiljen',    '040040040'     ,NULL, '17-06-1996'  ),
  (14,     'no0014@student.uni-lj.si',      'no0014',      '123456',     's',       'Nik',    'Oprašič',    '040040040'     ,NULL, '17-06-1996'  ),
  (15,     'op0015@student.uni-lj.si',      'op0015',      '123456',     's',       'Olin',    'Polin',    '040040040'     ,NULL, '17-06-1996'  ),

  /* 1. Letnik - Profesorji */
  (100,   'gasperF@uni-lj.si',    'GašperF',    '123456',     'p',      'Gašper',     'Fijavž',   '040502896'     ,100100, NULL),
  (101,   'polonaO@uni-lj.si',    'PolonaO',    '123456',     'p',      'Polona',     'Oblak',    '040502896'     ,100101, NULL),
  (102,   'vilijanM@uni-lj.si',   'VilijanM',   '123456',     'p',      'Vilijan',    'Mahnič',   '040502896'     ,100102, NULL),
  (103,   'nikolajZ@uni-lj.si',   'NikolajZ',   '123456',     'p',      'Nikolaj',    'Zimic',    '040502896'     ,100103, NULL),
  (104,   'irenaD@uni-lj.si',     'IrenaD',     '123456',     'p',      'Irena',      'Drvenšek', '040502896'     ,100104, NULL),
  (105,   'bostjanS@uni-lj.si',  'BoštijanS',  '123456',     'p',      'Boštijan',   'Slivnik',  '040502896'     ,100105, NULL),
  (106,   'brankoS@uni-lj.si',    'BrankoŠ',    '123456',     'p',      'Branko',     'Šter',     '040502896'     ,100106, NULL),
  (107,   'zoranB@uni-lj.si',     'ZoranB',     '123456',     'p',      'Zoran',      'Bosnič',   '040502896'     ,100107, NULL),
  (108,    'dejanL@uni-lj.si',     'DejanL',     '123456',     'p',      'Dejan',      'Lavbič',   '040502896'     ,100108, NULL),
  (109,    'bojanO@uni-lj.si',     'BojanO',     '123456',     'p',      'Bojan',      'Orel',     '040502896'     ,100109, NULL),

  /* 2. Letnik - Profesorji */
  (110,   'patricioB@uni-lj.si',    'GašperF',    '123456',     'p',      'Patricio',     'Bulič',   '040502896'     ,100110, NULL),
  (111,   'aleksandarJ@uni-lj.si',    'aleksandarJ',    '123456',     'p',      'Aleksandar',     'Jurišič',   '040502896'     ,100111, NULL),
  (112,   'igorK@uni-lj.si',    'igorK',    '123456',     'p',      'Igor',     'Kononenko',   '040502896'     ,100112, NULL),
  (113,   'markoB@uni-lj.si',    'markoB',    '123456',     'p',      'Marko',     'Bajec',   '040502896'     ,100113, NULL),
  (114,   'borutR@uni-lj.si',    'borutR',    '123456',     'p',      'Borut',     'Robič',   '040502896'     ,100114, NULL),
  (115,   'urosL@uni-lj.si',    'urosL',    '123456',     'p',      'Uroš',     'Lotrič',   '040502896'     ,100115, NULL),
  (116,   'nezaM@uni-lj.si',    'nezaM',    '123456',     'p',      'Neža',     'Mramor Kosta',   '040502896'     ,100116, NULL),
  (117,   'ivanB@uni-lj.si',    'ivanB',    '123456',     'p',      'Ivan',     'Bratko',   '040502896'     ,100117, NULL),
  (118,   'rokZ@uni-lj.si',    'rokZ',    '123456',     'p',      'Rok',     'Žitko',   '040502896'     ,100118, NULL),

  /* 3. Letnik - Profesorji */
  /* Modul: IS */
  (119,   'tomazH@uni-lj.si',    'tomazH',    '123456',     'p',      'Tomaž',     'Hovelja',   '040502896'     ,100119, NULL),
  (120,   'denisT@uni-lj.si',    'denisT',    '123456',     'p',      'Denis',     'Trček',   '040502896'     ,100120, NULL),
  (121,   'blazZ@uni-lj.si',    'blazZ',    '123456',     'p',      'Blaž',     'Zupan',   '040502896'     ,100121, NULL),

  /* Modul: Odvladovanje informatike */
  (122,   'matjazK@uni-lj.si',    'tomazH',    '123456',     'p',      'Matjaž',     'Kukar',   '040502896'     ,100122, NULL),
  (123,   'rokR@uni-lj.si',    'rokR',    '123456',     'p',      'Rok',     'Rupnik',   '040502896'     ,100123, NULL),

  /* Modul: Razvoj prog. opreme */
  (124,   'matjazJ@uni-lj.si',    'matjazJ',    '123456',     'p',      'Matjaž B',     'Jurič',   '040502896'     ,100124, NULL),

  /* Modul: Računalniška omrežja */
  (125,   'mihaM@uni-lj.si',    'mihaM',    '123456',     'p',      'Miha',     'Mraz',   '040502896'     ,100125, NULL),
  (126,   'mojcaC@uni-lj.si',    'mojcaC',    '123456',     'p',      'Mojca',     'Ciglarič',   '040502896',100126, NULL),

  /* Modul: Umetna intelignca */
  (127,   'markoR@uni-lj.si',    'markoR',    '123456',     'p',      'Marko',     'Robnik Šikonja',   '040502896',100127, NULL),
  (128,   'matejK@uni-lj.si',    'matejK',    '123456',     'p',      'Matej',     'Kristan',   '040502896',100128, NULL),
  (129,   'danielS@uni-lj.si',    'danielS',    '123456',     'p',      'Daniel',     'Skočaj',   '040502896',100129, NULL),

  /* Modul: Medijske tehnologije */
  (130,   'narvikaB@uni-lj.si',    'narvikaB',    '123456',     'p',      'Narvika',     'Bovcon',   '040502896',100130, NULL),
  (131,   'lukaS@uni-lj.si',    'lukaS',    '123456',     'p',      'Luka',     'Šajn',   '040502896',100131, NULL),
  (132,   'matijaM@uni-lj.si',    'matijaM',    '123456',     'p',      'Matija',     'Marolt',   '040502896',100132, NULL),

  (300,   'referentFri@uni-lj.si',    'referentFri',    '123456',     'r',      'Berta',     'Prijaznik',   '040502896',NULL, NULL),
  (400,   'adminFri@uni-lj.si',    'adminFri',    '123456',     'a',      'Simon',     'Stroj',   '040502896',NULL, NULL);


--  absolvent, pogojnoNaprej, PonavljalecNaredl7, zamenjalProgram
--  preverjanje login:
--  uporabnisko ime=testS  geslo='123456'
--  VRSTA_VLOGE: admin='a', referat='r', profesor='p', student='s' in kandidat='k'


--  Inserti preko import fila
INSERT INTO `tpo`.`kandidat`(`ID_KANDIDAT`, `ID_PROGRAM`, `ID_OSEBA`, `ID_STUD_LETO`, `IZKORISCEN`, `EMSO`, `VPISNA_STEVILKA`) VALUES
  (1,11, 1, 0,1,1706996500334,63150001),
  (2,11, 2, 0,1,1706996500334,63150002),
  (3,11, 3, 0,1,1706996500334,63150003),
  (4,11, 4, 0,1,1706996500334,63150004),
  (5,11, 5, 0,1,1706996500334,63150005),
  (6,11, 6, 1,1,1706996500334,63150006),
  (7,11, 7, 1,1,1706996500334,63150007),
  (8,11, 8, 1,1,1706996500334,63150008),
  (9,11, 9, 1,1,1706996500334,63150009),
  (10,11,10,1,1,1706996500334,63150010),
  (11,11,11,2,1,1706996500334,63150011),
  (12,11,12,2,1,1706996500334,63150012),
  (13,11,13,2,1,1706996500334,63150013),
  (14,11,14,2,1,1706996500334,63150014),
  (15,11,15,2,1,1706996500334,63150015);

/*
  1. Letnik = 10-19
  2. Letnik
      -Obvezni = 20-27
      -Strokovni izbirni = 28-30
  3. Letnik
      -Obvezni = 31-33
      -Moduli =
 */
INSERT INTO `tpo`.`PREDMET`
(`ID_PREDMET`, `SIFRA_PREDMET`, `IME_PREDMET`, `AKTIVNOST`)
VALUES

  /* 1. Letnik */
  (10, 63702,'Programiranje 1', 1),
  (11, 63202,'Osnove Matematične Analize', 1),
  (12, 63203,'Diskretne Strukture', 1),
  (13, 63204,'Osnove Digitalnih Vezji', 1),
  (14, 63205,'Fizika', 1),
  (15, 63706,'Programiranje 2', 1),
  (16, 63207,'Linearna Algebra', 1),
  (17, 63212,'Arhitekrura Računalniških Sistemov', 1),
  (18, 63708,'Računalniške Komunikacije', 1),
  (19, 63215,'Osnove Informacijskih Sistemov', 1),

  /* 2. Letnik - Obvezni */
  (20, 63711,'Algoritmi in Podatkovne Strukture 1', 1),
  (21, 63723,'Algoritmi in Podatkovne Strukture 2', 1),
  (22, 63208,'Osnove Podatkovnih Baz', 1),
  (23, 63213,'Verjetnost in Statistika', 1),
  (24, 63283,'Izračunljivost in Računska Zahtevnost', 1),
  (25, 63216,'Teorija Informacij in Sistemov', 1),
  (26, 63217,'Opreacijski Sistemi', 1),
  (27, 63218,'Organizacija Računalniških Sistemov', 1),

  /* 2. Letnik - Strokovni izbirni */
  (28, 63220,'Principi Programskih Jezikov', 1),
  (29, 63219,'Matematično modeliranje', 1),
  (30, 63221,'Računalniške Tehnologije', 1),

  /* 3. Letnik - Obvezni */
  (31, 63214,'Osnove Umetne Inteligence', 1),
  (32, 63248,'Ekonomika in Podjetništvo ', 1),
  (33, 63281,'Diplomski seminar', 1),

  /* 3. Letnik - Moduli */
  (34, 63256,'Tehnologija Programske Opreme', 1),
  (35, 63254,'Postopki Razvoja Programke Opreme', 1),
  (36, 63255,'Spletno Progrmiranje', 1),

  (37, 63249,'Elektronsko Poslovanje', 1),
  (38, 63250,'Organizacija in Management', 1),
  (39, 63251,'Uvod v odkrivanje znanj iz podatkov', 1),

  (40, 63226,'Tehnologija Upravljanja Podatkov', 1),
  (41, 63725,'Razvoj Informacijskih Sistemov', 1),
  (42, 63253,'Planiranje in Upravljanje Informatike', 1),

  (43, 63258,'Komunikacijski Protokoli', 1),
  (44, 63259,'Brezžična in Mobilna Omrežja', 1),
  (45, 63257,'Modeliranje Računalniških Omrežji', 1),

  (46, 63262,'Zanesljivost in zmogljivost rač. sis.', 1),
  (47, 63260,'Digitalno načrtovanje', 1),
  (48, 63261,'Porazdeljeni sistemi', 1),

  (49, 63264,'Sistemska programska oprema', 1),
  (50, 63263,'Rač. zaht. in hevr. prog.', 1),
  (51, 63265,'Prevajalniki', 1),

  (52, 63268,'Razvoj Inteligentnih Sistemov', 1),
  (53, 63266,'Inteligentni Sistemi', 1),
  (54, 63267,'Umetno Zaznavanje', 1),

  (55, 63271,'Osnove Oblikovanja', 1),
  (56, 63270,'Multimedijski sistemi', 1),
  (57, 63269,'Računalniška grafika in tehnologija iger', 1);


/* Splosni izbirni predmeti: 100-naprej */
/* 2 Inserta zato, ker imajo spodnji predmeti definirane se kreditne tocke, razlicne od default 6 */
INSERT INTO `tpo`.`PREDMET`
(`ID_PREDMET`, `SIFRA_PREDMET`, `IME_PREDMET`, `ST_KREDITNIH_TOCK`, `AKTIVNOST`)
VALUES
  (100, 63240,'Šport', 3, 1),
  (101, 63241,'Računalništvo v praksi I', 3, 1),
  (102, 63242,'Računalništvo v praksi II', 3, 1),
  (103, 63284,'Tehnične veščine: Scala', 3, 1),
  (104, 63285,'Tehnične veščine: Računalniški vid', 3, 1),
  (105, 63767,'Tehnične veščine: OpenStack', 3, 1),
  (106, 63222,'Angleški jezik nivo A', 3, 1),
  (107, 63745,'Angleški jezik nivo B', 3, 1),
  (108, 63224,'Angleški jezik nivo C', 3, 1),
  (109, 63737,'Procesna avtomatika', 6, 1),
  (110, 64000,'Izbrana poglavja RI', 6, 1),
  (111, 64001,'Predmeti drugih fakultet', 6, 1);

INSERT INTO `tpo`.`del_predmetnika`
(`ID_DELPREDMETNIKA`, `NAZIV_DELAPREDMETNIKA`, `SKUPNOSTEVILOKT`, `TIP`, `AKTIVNOST`)
VALUES
  /* Ostali tipi */
  (1, 'Obvezni predmet', 6, 'o', 1),
  (2, 'Strokovni izbirni predmet', 6, 'st', 1),
  (3, 'Splosno izbirni predmet (6KT)', 6, 'sp', 1),
  (4, 'Splosno izbirni predmet (3KT)', 3, 'sp', 1),

  /* Moduli */
  (10, 'Razvoj programske opreme', 18, 'm', 1),
  (11, 'Informacijski sistemi', 18, 'm', 1),
  (12, 'Obvladovanje informatike', 18, 'm', 1),
  (13, 'Računalniška omrežja', 18, 'm', 1),
  (14, 'Računalniški sistemi', 18, 'm', 1),
  (15, 'Algoritmi in sistemski programi', 18, 'm', 1),
  (16, 'Umetna inteligenca', 18, 'm', 1),
  (17, 'Medijske tehnologije', 18, 'm', 1);


INSERT INTO `tpo`.`predmetnik`
(`ID_STUD_LETO`, `ID_LETNIK`, `ID_PREDMET`, `ID_DELPREDMETNIKA`, `ID_PROGRAM`, `AKTIVNOST`) VALUES

  /* -- -- -- -- -- -- -- --  STUD LETO 0 START -- -- -- -- -- -- -- --  */

  /* STUD LETO = 0 (2015/16), 1. Letnik */
  (0, 1, 10, 1, 11, 1),
  (0, 1, 11, 1, 11, 1),
  (0, 1, 12, 1, 11, 1),
  (0, 1, 13, 1, 11, 1),
  (0, 1, 14, 1, 11, 1),
  (0, 1, 15, 1, 11, 1),
  (0, 1, 16, 1, 11, 1),
  (0, 1, 17, 1, 11, 1),
  (0, 1, 18, 1, 11, 1),
  (0, 1, 19, 1, 11, 1),

  /* STUD LETO = 0 (2015/16), 2. Letnik - Obvezni */
  (0, 2, 20, 1, 11, 1),
  (0, 2, 21, 1, 11, 1),
  (0, 2, 22, 1, 11, 1),
  (0, 2, 23, 1, 11, 1),
  (0, 2, 24, 1, 11, 1),
  (0, 2, 25, 1, 11, 1),
  (0, 2, 26, 1, 11, 1),
  (0, 2, 27, 1, 11, 1),

  /* STUD LETO = 0 (2015/16), 2. Letnik - Strokovni izbirni */
  (0, 2, 28, 2, 11, 1),
  (0, 2, 29, 2, 11, 1),
  (0, 2, 30, 2, 11, 1),

  /* STUD LETO = 0 (2015/16), 2. Letnik - Splosni izbirni */
  (0, 2, 100, 4, 11, 1),
  (0, 2, 101, 4, 11, 1),
  (0, 2, 102, 4, 11, 1),
  (0, 2, 103, 4, 11, 1),
  (0, 2, 104, 4, 11, 1),
  (0, 2, 105, 4, 11, 1),
  (0, 2, 106, 4, 11, 1),
  (0, 2, 107, 4, 11, 1),
  (0, 2, 108, 4, 11, 1),
  (0, 2, 109, 3, 11, 1),
  (0, 2, 110, 3, 11, 1),
  (0, 2, 111, 3, 11, 1),

  /* STUD LETO = 0 (2015/16), 3. Letnik - Obvezni */
  (0, 3, 31, 1, 11, 1),
  (0, 3, 32, 1, 11, 1),
  (0, 3, 33, 1, 11, 1),

  /* STUD LETO = 0 (2015/16), 3. Letnik - Moduli */
  --  Razvoj prog opreme
  (0, 3, 34, 10, 11, 1),
  (0, 3, 35, 10, 11, 1),
  (0, 3, 36, 10, 11, 1),

  --  Inf. sistemi
  (0, 3, 37, 11, 11, 1),
  (0, 3, 38, 11, 11, 1),
  (0, 3, 39, 11, 11, 1),

  --  Upr. inf.
  (0, 3, 40, 12, 11, 1),
  (0, 3, 41, 12, 11, 1),
  (0, 3, 42, 12, 11, 1),

  --  Rac omz
  (0, 3, 43, 13, 11, 1),
  (0, 3, 44, 13, 11, 1),
  (0, 3, 45, 13, 11, 1),

  --  Rac sis
  (0, 3, 46, 14, 11, 1),
  (0, 3, 47, 14, 11, 1),
  (0, 3, 48, 14, 11, 1),

  --  Alg sis prog
  (0, 3, 49, 15, 11, 1),
  (0, 3, 50, 15, 11, 1),
  (0, 3, 51, 15, 11, 1),

   --  Umet int
  (0, 3, 52, 16, 11, 1),
  (0, 3, 53, 16, 11, 1),
  (0, 3, 54, 16, 11, 1),

   --  Med teh
  (0, 3, 55, 17, 11, 1),
  (0, 3, 56, 17, 11, 1),
  (0, 3, 57, 17, 11, 1),

  /* STUD LETO = 0 (2015/16), 3. Letnik - Splosni izbirni */
  (0, 3, 100, 4, 11, 1),
  (0, 3, 101, 4, 11, 1),
  (0, 3, 102, 4, 11, 1),
  (0, 3, 103, 4, 11, 1),
  (0, 3, 104, 4, 11, 1),
  (0, 3, 105, 4, 11, 1),
  (0, 3, 106, 4, 11, 1),
  (0, 3, 107, 4, 11, 1),
  (0, 3, 108, 4, 11, 1),
  (0, 3, 109, 3, 11, 1),
  (0, 3, 110, 3, 11, 1),
  (0, 3, 111, 3, 11, 1),

  /* -- -- -- -- -- -- -- --  STUD LETO 0 END   -- -- -- -- -- -- -- --  */

  /* -- -- -- -- -- -- -- --  STUD LETO 1 START -- -- -- -- -- -- -- --  */
  /* STUD LETO = 1 (2016/17), 1. Letnik */
  (1, 1, 10, 1, 11, 1),
  (1, 1, 11, 1, 11, 1),
  (1, 1, 12, 1, 11, 1),
  (1, 1, 13, 1, 11, 1),
  (1, 1, 14, 1, 11, 1),
  (1, 1, 15, 1, 11, 1),
  (1, 1, 16, 1, 11, 1),
  (1, 1, 17, 1, 11, 1),
  (1, 1, 18, 1, 11, 1),
  (1, 1, 19, 1, 11, 1),

  /* STUD LETO = 1 (2016/17), 2. Letnik - Obvezni */
  (1, 2, 20, 1, 11, 1),
  (1, 2, 21, 1, 11, 1),
  (1, 2, 22, 1, 11, 1),
  (1, 2, 23, 1, 11, 1),
  (1, 2, 24, 1, 11, 1),
  (1, 2, 25, 1, 11, 1),
  (1, 2, 26, 1, 11, 1),
  (1, 2, 27, 1, 11, 1),

  /* STUD LETO = 1 (2016/17), 2. Letnik - Strokovni izbirni */
  (1, 2, 28, 2, 11, 1),
  (1, 2, 29, 2, 11, 1),
  (1, 2, 30, 2, 11, 1),

  /* STUD LETO = 1 (2016/17), 2. Letnik - Splosni izbirni */
  (1, 2, 100, 4, 11, 1),
  (1, 2, 101, 4, 11, 1),
  (1, 2, 102, 4, 11, 1),
  (1, 2, 103, 4, 11, 1),
  (1, 2, 104, 4, 11, 1),
  (1, 2, 105, 4, 11, 1),
  (1, 2, 106, 4, 11, 1),
  (1, 2, 107, 4, 11, 1),
  (1, 2, 108, 4, 11, 1),
  (1, 2, 109, 3, 11, 1),
  (1, 2, 110, 3, 11, 1),
  (1, 2, 111, 3, 11, 1),

  /* STUD LETO = 1 (2016/17), 3. Letnik - Obvezni */
  (1, 3, 31, 1, 11, 1),
  (1, 3, 32, 1, 11, 1),
  (1, 3, 33, 1, 11, 1),

  /* STUD LETO = 1 (2016/17), 3. Letnik - Moduli */
  --  Razvoj prog opreme
  (1, 3, 34, 10, 11, 1),
  (1, 3, 35, 10, 11, 1),
  (1, 3, 36, 10, 11, 1),

  --  Inf. sistemi
  (1, 3, 37, 11, 11, 1),
  (1, 3, 38, 11, 11, 1),
  (1, 3, 39, 11, 11, 1),

  --  Upr. inf.
  (1, 3, 40, 12, 11, 1),
  (1, 3, 41, 12, 11, 1),
  (1, 3, 42, 12, 11, 1),

  --  Rac omz
  (1, 3, 43, 13, 11, 1),
  (1, 3, 44, 13, 11, 1),
  (1, 3, 45, 13, 11, 1),

  --  Rac sis
  (1, 3, 46, 14, 11, 1),
  (1, 3, 47, 14, 11, 1),
  (1, 3, 48, 14, 11, 1),

  --  Alg sis prog
  (1, 3, 49, 15, 11, 1),
  (1, 3, 50, 15, 11, 1),
  (1, 3, 51, 15, 11, 1),

   --  Umet int
  (1, 3, 52, 16, 11, 1),
  (1, 3, 53, 16, 11, 1),
  (1, 3, 54, 16, 11, 1),

   --  Med teh
  (1, 3, 55, 17, 11, 1),
  (1, 3, 56, 17, 11, 1),
  (1, 3, 57, 17, 11, 1),

  /* STUD LETO = 1 (2016/17), 3. Letnik - Splosni izbirni */
  (1, 3, 100, 4, 11, 1),
  (1, 3, 101, 4, 11, 1),
  (1, 3, 102, 4, 11, 1),
  (1, 3, 103, 4, 11, 1),
  (1, 3, 104, 4, 11, 1),
  (1, 3, 105, 4, 11, 1),
  (1, 3, 106, 4, 11, 1),
  (1, 3, 107, 4, 11, 1),
  (1, 3, 108, 4, 11, 1),
  (1, 3, 109, 3, 11, 1),
  (1, 3, 110, 3, 11, 1),
  (1, 3, 111, 3, 11, 1),

  /* -- -- -- -- -- -- -- --  STUD LETO 1 END   -- -- -- -- -- -- -- --  */

  /* -- -- -- -- -- -- -- --  STUD LETO 2 START -- -- -- -- -- -- -- --  */
  /* STUD LETO = 2 (2017/18), 1. Letnik */
  (2, 1, 10, 1, 11, 1),
  (2, 1, 11, 1, 11, 1),
  (2, 1, 12, 1, 11, 1),
  (2, 1, 13, 1, 11, 1),
  (2, 1, 14, 1, 11, 1),
  (2, 1, 15, 1, 11, 1),
  (2, 1, 16, 1, 11, 1),
  (2, 1, 17, 1, 11, 1),
  (2, 1, 18, 1, 11, 1),
  (2, 1, 19, 1, 11, 1),

  /* STUD LETO = 2 (2017/18), 2. Letnik - Obvezni */
  (2, 2, 20, 1, 11, 1),
  (2, 2, 21, 1, 11, 1),
  (2, 2, 22, 1, 11, 1),
  (2, 2, 23, 1, 11, 1),
  (2, 2, 24, 1, 11, 1),
  (2, 2, 25, 1, 11, 1),
  (2, 2, 26, 1, 11, 1),
  (2, 2, 27, 1, 11, 1),

  /* STUD LETO = 2 (2017/18), 2. Letnik - Strokovni izbirni */
  (2, 2, 28, 2, 11, 1),
  (2, 2, 29, 2, 11, 1),
  (2, 2, 30, 2, 11, 1),

  /* STUD LETO = 2 (2017/18), 2. Letnik - Splosni izbirni */
  (2, 2, 100, 4, 11, 1),
  (2, 2, 101, 4, 11, 1),
  (2, 2, 102, 4, 11, 1),
  (2, 2, 103, 4, 11, 1),
  (2, 2, 104, 4, 11, 1),
  (2, 2, 105, 4, 11, 1),
  (2, 2, 106, 4, 11, 1),
  (2, 2, 107, 4, 11, 1),
  (2, 2, 108, 4, 11, 1),
  (2, 2, 109, 3, 11, 1),
  (2, 2, 110, 3, 11, 1),
  (2, 2, 111, 3, 11, 1),

  /* STUD LETO = 2 (2017/18), 3. Letnik - Obvezni */
  (2, 3, 31, 1, 11, 1),
  (2, 3, 32, 1, 11, 1),
  (2, 3, 33, 1, 11, 1),

  /* STUD LETO = 2 (2017/18), 3. Letnik - Moduli */
  --  Razvoj prog opreme
  (2, 3, 34, 10, 11, 1),
  (2, 3, 35, 10, 11, 1),
  (2, 3, 36, 10, 11, 1),

  --  Inf. sistemi
  (2, 3, 37, 11, 11, 1),
  (2, 3, 38, 11, 11, 1),
  (2, 3, 39, 11, 11, 1),

  --  Upr. inf.
  (2, 3, 40, 12, 11, 1),
  (2, 3, 41, 12, 11, 1),
  (2, 3, 42, 12, 11, 1),

  --  Rac omz
  (2, 3, 43, 13, 11, 1),
  (2, 3, 44, 13, 11, 1),
  (2, 3, 45, 13, 11, 1),

  --  Rac sis
  (2, 3, 46, 14, 11, 1),
  (2, 3, 47, 14, 11, 1),
  (2, 3, 48, 14, 11, 1),

  --  Alg sis prog
  (2, 3, 49, 15, 11, 1),
  (2, 3, 50, 15, 11, 1),
  (2, 3, 51, 15, 11, 1),

   --  Umet int
  (2, 3, 52, 16, 11, 1),
  (2, 3, 53, 16, 11, 1),
  (2, 3, 54, 16, 11, 1),

   --  Med teh
  (2, 3, 55, 17, 11, 1),
  (2, 3, 56, 17, 11, 1),
  (2, 3, 57, 17, 11, 1),

  /* STUD LETO = 2 (2017/18), 3. Letnik - Splosni izbirni */
  (2, 3, 100, 4, 11, 1),
  (2, 3, 101, 4, 11, 1),
  (2, 3, 102, 4, 11, 1),
  (2, 3, 103, 4, 11, 1),
  (2, 3, 104, 4, 11, 1),
  (2, 3, 105, 4, 11, 1),
  (2, 3, 106, 4, 11, 1),
  (2, 3, 107, 4, 11, 1),
  (2, 3, 108, 4, 11, 1),
  (2, 3, 109, 3, 11, 1),
  (2, 3, 110, 3, 11, 1),
  (2, 3, 111, 3, 11, 1),

  /* -- -- -- -- -- -- -- --  STUD LETO 2 END   -- -- -- -- -- -- -- --  */

  /* -- -- -- -- -- -- -- --  STUD LETO 3 START -- -- -- -- -- -- -- --  */
  /* STUD LETO = 3 (2018/19) 1. Letnik */
  (3, 1, 10, 1, 11, 1),
  (3, 1, 11, 1, 11, 1),
  (3, 1, 12, 1, 11, 1),
  (3, 1, 13, 1, 11, 1),
  (3, 1, 14, 1, 11, 1),
  (3, 1, 15, 1, 11, 1),
  (3, 1, 16, 1, 11, 1),
  (3, 1, 17, 1, 11, 1),
  (3, 1, 18, 1, 11, 1),
  (3, 1, 19, 1, 11, 1),

  /* STUD LETO = 3 (2018/19), 2. Letnik - Obvezni */
  (3, 2, 20, 1, 11, 1),
  (3, 2, 21, 1, 11, 1),
  (3, 2, 22, 1, 11, 1),
  (3, 2, 23, 1, 11, 1),
  (3, 2, 24, 1, 11, 1),
  (3, 2, 25, 1, 11, 1),
  (3, 2, 26, 1, 11, 1),
  (3, 2, 27, 1, 11, 1),

  /* STUD LETO = 3 (2018/19), 2. Letnik - Strokovni izbirni */
  (3, 2, 28, 2, 11, 1),
  (3, 2, 29, 2, 11, 1),
  (3, 2, 30, 2, 11, 1),

  /* STUD LETO = 3 (2018/19), 2. Letnik - Splosni izbirni */
  (3, 2, 100, 4, 11, 1),
  (3, 2, 101, 4, 11, 1),
  (3, 2, 102, 4, 11, 1),
  (3, 2, 103, 4, 11, 1),
  (3, 2, 104, 4, 11, 1),
  (3, 2, 105, 4, 11, 1),
  (3, 2, 106, 4, 11, 1),
  (3, 2, 107, 4, 11, 1),
  (3, 2, 108, 4, 11, 1),
  (3, 2, 109, 3, 11, 1),
  (3, 2, 110, 3, 11, 1),
  (3, 2, 111, 3, 11, 1),

  /* STUD LETO = 3 (2018/19), 3. Letnik - Obvezni */
  (3, 3, 31, 1, 11, 1),
  (3, 3, 32, 1, 11, 1),
  (3, 3, 33, 1, 11, 1),

  /* STUD LETO = 3 (2018/19), 3. Letnik - Moduli */
  --  Razvoj prog opreme
  (3, 3, 34, 10, 11, 1),
  (3, 3, 35, 10, 11, 1),
  (3, 3, 36, 10, 11, 1),

  --  Inf. sistemi
  (3, 3, 37, 11, 11, 1),
  (3, 3, 38, 11, 11, 1),
  (3, 3, 39, 11, 11, 1),

  --  Upr. inf.
  (3, 3, 40, 12, 11, 1),
  (3, 3, 41, 12, 11, 1),
  (3, 3, 42, 12, 11, 1),

  --  Rac omz
  (3, 3, 43, 13, 11, 1),
  (3, 3, 44, 13, 11, 1),
  (3, 3, 45, 13, 11, 1),

  --  Rac sis
  (3, 3, 46, 14, 11, 1),
  (3, 3, 47, 14, 11, 1),
  (3, 3, 48, 14, 11, 1),

  --  Alg sis prog
  (3, 3, 49, 15, 11, 1),
  (3, 3, 50, 15, 11, 1),
  (3, 3, 51, 15, 11, 1),

   --  Umet int
  (3, 3, 52, 16, 11, 1),
  (3, 3, 53, 16, 11, 1),
  (3, 3, 54, 16, 11, 1),

   --  Med teh
  (3, 3, 55, 17, 11, 1),
  (3, 3, 56, 17, 11, 1),
  (3, 3, 57, 17, 11, 1),

  /* STUD LETO = 3 (2018/19), 3. Letnik - Splosni izbirni */
  (3, 3, 100, 4, 11, 1),
  (3, 3, 101, 4, 11, 1),
  (3, 3, 102, 4, 11, 1),
  (3, 3, 103, 4, 11, 1),
  (3, 3, 104, 4, 11, 1),
  (3, 3, 105, 4, 11, 1),
  (3, 3, 106, 4, 11, 1),
  (3, 3, 107, 4, 11, 1),
  (3, 3, 108, 4, 11, 1),
  (3, 3, 109, 3, 11, 1),
  (3, 3, 110, 3, 11, 1),
  (3, 3, 111, 3, 11, 1);

  /* -- -- -- -- -- -- -- --  STUD LETO 3 END   -- -- -- -- -- -- -- --  */
INSERT INTO `tpo`.`IZVEDBA_PREDMETA`
(`ID_IZVEDBA`, `ID_STUD_LETO`, `ID_PREDMET`, `ID_OSEBA1`, `ID_OSEBA2`, `ID_OSEBA3`) VALUES

/* -- -- - STUD LETO 0 START -- -- - */
/* 1. Letnik, Stud leto = 0, Obvezni */
(1,0,10,102,NULL,NULL),
(2,0,11,101,NULL,NULL),
(3,0,12,100,NULL,NULL),
(4,0,13,103,NULL,NULL),
(5,0,14,104,NULL,NULL),
(6,0,15,105,NULL,NULL),
(7,0,16,109,NULL,NULL),
(8,0,17,106,NULL,NULL),
(9,0,18,107,NULL,NULL),
(10,0,19,108,NULL,NULL),

/* 2. Letnik, Stud leto = 0, Obvezni */
(11,0,20,112,NULL,NULL),
(12,0,21,114,NULL,NULL),
(13,0,22,113,NULL,NULL),
(14,0,23,111,NULL,NULL),
(15,0,24,114,NULL,NULL),
(16,0,25,115,NULL,NULL),
(17,0,26,114,NULL,NULL),
(18,0,27,110,NULL,NULL),

/* 2. Letnik, Stud leto = 0, Strokovni izbirni */
(19,0,28,117,NULL,NULL),
(20,0,29,116,NULL,NULL),
(21,0,30,118,NULL,NULL),

/* 2. Letnik, Stud leto = 0, Splosni izbirni */
(22,0,100,130,NULL,NULL),
(23,0,101,107,NULL,NULL),
(24,0,102,107,NULL,NULL),
(25,0,103,108,NULL,NULL),
(26,0,104,109,NULL,NULL),
(27,0,105,113,NULL,NULL),
(28,0,106,117,NULL,NULL),
(29,0,107,117,NULL,NULL),
(30,0,108,117,NULL,NULL),
(31,0,109,115,NULL,NULL),
(32,0,110,117,NULL,NULL),
(33,0,111,107,NULL,NULL),

/* 3. Letnik, Stud leto = 0, Obvezni */
(34,0,31,107,NULL,NULL),
(35,0,32,127,128,129),
(36,0,33,109,NULL,NULL),

/* 3. Letnik, Stud leto = 0, Moduli */
--  Raz prog opr
(37,0,34,102,NULL,NULL),
(38,0,35,124,NULL,NULL),
(39,0,36,108,NULL,NULL),
--  Inf sis
(40,0,37,120,NULL,NULL),
(41,0,38,119,NULL,NULL),
(42,0,39,121,NULL,NULL),
--  Obv inf
(43,0,40,122,NULL,NULL),
(44,0,41,113,NULL,NULL),
(45,0,42,123,NULL,NULL),
--  Rac omr
(46,0,43,126,NULL,NULL),
(47,0,44,103,NULL,NULL),
(48,0,45,125,NULL,NULL),
--  Rac sis
(49,0,46,125,NULL,NULL),
(50,0,47,110,NULL,NULL),
(51,0,48,115,NULL,NULL),
--  Alg pod sis
(52,0,49,106,NULL,NULL),
(53,0,50,114,NULL,NULL),
(54,0,51,105,NULL,NULL),
--  Umet int
(55,0,52,129,NULL,NULL),
(56,0,53,127,NULL,NULL),
(57,0,54,128,NULL,NULL),
--  Med teh
(58,0,55,130,NULL,NULL),
(59,0,56,131,NULL,NULL),
(60,0,57,132,NULL,NULL),

/* -- -- - STUD LETO 0 END -- -- - */

/* -- -- - STUD LETO 1 START -- -- - */
/* 1. Letnik, Stud leto = 1, Obvezni */
(61,1,10,102,NULL,NULL),
(62,1,11,101,NULL,NULL),
(63,1,12,100,NULL,NULL),
(64,1,13,103,NULL,NULL),
(65,1,14,104,NULL,NULL),
(66,1,15,105,NULL,NULL),
(67,1,16,109,NULL,NULL),
(68,1,17,106,NULL,NULL),
(69,1,18,107,NULL,NULL),
(70,1,19,108,NULL,NULL),

/* 2. Letnik, Stud leto = 1, Obvezni */
(71,1,20,112,NULL,NULL),
(72,1,21,114,NULL,NULL),
(73,1,22,113,NULL,NULL),
(74,1,23,111,NULL,NULL),
(75,1,24,114,NULL,NULL),
(76,1,25,115,NULL,NULL),
(77,1,26,114,NULL,NULL),
(78,1,27,110,NULL,NULL),

/* 2. Letnik, Stud leto = 1, Strokovni izbirni */
(79,1,28,117,NULL,NULL),
(80,1,29,116,NULL,NULL),
(81,1,30,118,NULL,NULL),

/* 2. Letnik, Stud leto = 1, Splosni izbirni */
(82,1,100,130,NULL,NULL),
(84,1,101,107,NULL,NULL),
(85,1,102,107,NULL,NULL),
(86,1,103,108,NULL,NULL),
(87,1,104,109,NULL,NULL),
(88,1,105,113,NULL,NULL),
(89,1,106,117,NULL,NULL),
(90,1,107,117,NULL,NULL),
(91,1,108,117,NULL,NULL),
(92,1,109,115,NULL,NULL),
(93,1,110,117,NULL,NULL),
(94,1,111,107,NULL,NULL),

/* 3. Letnik, Stud leto = 1, Obvezni */
(95,1,31,107,NULL,NULL),
(96,1,32,127,128,129),
(97,1,33,109,NULL,NULL),

/* 3. Letnik, Stud leto = 11, Moduli */
--  Raz prog opr
(98,1,34,102,NULL,NULL),
(99,1,35,124,NULL,NULL),
(100,1,36,108,NULL,NULL),
--  Inf sis
(101,1,37,120,NULL,NULL),
(102,1,38,119,NULL,NULL),
(103,1,39,121,NULL,NULL),
--  Obv inf
(104,1,40,122,NULL,NULL),
(105,1,41,113,NULL,NULL),
(106,1,42,123,NULL,NULL),
--  Rac omr
(107,1,43,126,NULL,NULL),
(108,1,44,103,NULL,NULL),
(109,1,45,125,NULL,NULL),
--  Rac sis
(110,1,46,125,NULL,NULL),
(111,1,47,110,NULL,NULL),
(112,1,48,115,NULL,NULL),
--  Alg pod sis
(113,1,49,106,NULL,NULL),
(114,1,50,114,NULL,NULL),
(115,1,51,105,NULL,NULL),
--  Umet int
(116,1,52,129,NULL,NULL),
(117,1,53,127,NULL,NULL),
(118,1,54,128,NULL,NULL),
--  Med teh
(119,1,55,130,NULL,NULL),
(120,1,56,131,NULL,NULL),
(121,1,57,132,NULL,NULL),

-- Dodajanje za izbrana poglavja, Ehratatan
-- (242,1,110,130,NULL,NULL),

/* -- -- - STUD LETO 1 END -- -- -*/

/* -- -- - STUD LETO 2 START -- -- -*/

/* 1. Letnik, Stud leto = 2, Obvezni */
(122,2,10,102,NULL,NULL),
(123,2,11,101,NULL,NULL),
(124,2,12,100,NULL,NULL),
(125,2,13,103,NULL,NULL),
(126,2,14,104,NULL,NULL),
(127,2,15,105,NULL,NULL),
(128,2,16,109,NULL,NULL),
(129,2,17,106,NULL,NULL),
(130,2,18,107,NULL,NULL),
(131,2,19,108,NULL,NULL),

/* 2. Letnik, Stud leto = 2, Obvezni */
(132,2,20,112,NULL,NULL),
(133,2,21,114,NULL,NULL),
(134,2,22,113,NULL,NULL),
(135,2,23,111,NULL,NULL),
(136,2,24,114,NULL,NULL),
(137,2,25,115,NULL,NULL),
(138,2,26,114,NULL,NULL),
(139,2,27,110,NULL,NULL),

/* 2. Letnik, Stud leto = 2, Strokovni izbirni */
(140,2,28,117,NULL,NULL),
(141,2,29,116,NULL,NULL),
(142,2,30,118,NULL,NULL),

/* 2. Letnik, Stud leto = 2, Splosni izbirni */
(143,2,100,130,NULL,NULL),
(144,2,101,107,NULL,NULL),
(145,2,102,107,NULL,NULL),
(146,2,103,108,NULL,NULL),
(147,2,104,109,NULL,NULL),
(148,2,105,113,NULL,NULL),
(149,2,106,117,NULL,NULL),
(150,2,107,117,NULL,NULL),
(151,2,108,117,NULL,NULL),
(152,2,109,115,NULL,NULL),
(153,2,110,117,NULL,NULL),
(154,2,111,107,NULL,NULL),

/* 3. Letnik, Stud leto = 2, Obvezni */
(155,2,31,107,NULL,NULL),
(156,2,32,127,128,129),
(157,2,33,109,NULL,NULL),

/* 3. Letnik, Stud leto = 2, Moduli */
--  Raz prog opr
(158,2,34,102,NULL,NULL),
(159,2,35,124,NULL,NULL),
(160,2,36,108,NULL,NULL),
--  Inf sis
(161,2,37,120,NULL,NULL),
(162,2,38,119,NULL,NULL),
(163,2,39,121,NULL,NULL),
--  Obv inf
(164,2,40,122,NULL,NULL),
(165,2,41,113,NULL,NULL),
(166,2,42,123,NULL,NULL),
--  Rac omr
(167,2,43,126,NULL,NULL),
(168,2,44,103,NULL,NULL),
(169,2,45,125,NULL,NULL),
--  Rac sis
(170,2,46,125,NULL,NULL),
(171,2,47,110,NULL,NULL),
(172,2,48,115,NULL,NULL),
--  Alg pod sis
(173,2,49,106,NULL,NULL),
(174,2,50,114,NULL,NULL),
(175,2,51,105,NULL,NULL),
--  Umet int
(176,2,52,129,NULL,NULL),
(177,2,53,127,NULL,NULL),
(178,2,54,128,NULL,NULL),
--  Med teh
(179,2,55,130,NULL,NULL),
(180,2,56,131,NULL,NULL),
(181,2,57,132,NULL,NULL),

/* -- -- - STUD LETO 2 END -- -- -*/

/* -- -- - STUD LETO 3 START -- -- -*/

/* 1. Letnik, Stud leto = 3, Obvezni */
(182,3,10,102,NULL,NULL),
(183,3,11,101,NULL,NULL),
(184,3,12,100,NULL,NULL),
(185,3,13,103,NULL,NULL),
(186,3,14,104,NULL,NULL),
(187,3,15,105,NULL,NULL),
(188,3,16,109,NULL,NULL),
(189,3,17,106,NULL,NULL),
(190,3,18,107,NULL,NULL),
(191,3,19,108,NULL,NULL),

/* 2. Letnik, Stud leto = 3, Obvezni */
(192,3,20,112,NULL,NULL),
(193,3,21,114,NULL,NULL),
(194,3,22,113,NULL,NULL),
(195,3,23,111,NULL,NULL),
(196,3,24,114,NULL,NULL),
(197,3,25,115,NULL,NULL),
(198,3,26,114,NULL,NULL),
(199,3,27,110,NULL,NULL),

/* 2. Letnik, Stud leto = 3, Strokovni izbirni */
(200,3,28,117,NULL,NULL),
(201,3,29,116,NULL,NULL),
(202,3,30,118,NULL,NULL),

/* 2. Letnik, Stud leto = 3, Splosni izbirni */
(203,3,100,130,NULL,NULL),
(204,3,101,107,NULL,NULL),
(205,3,102,107,NULL,NULL),
(206,3,103,108,NULL,NULL),
(207,3,104,109,NULL,NULL),
(208,3,105,113,NULL,NULL),
(209,3,106,117,NULL,NULL),
(210,3,107,117,NULL,NULL),
(211,3,108,117,NULL,NULL),
(212,3,109,115,NULL,NULL),
(213,3,110,117,NULL,NULL),
(214,3,111,107,NULL,NULL),

/* 3. Letnik, Stud leto = 3, Obvezni */
(215,3,31,107,NULL,NULL),
(216,3,32,127,128,129),
(217,3,33,109,NULL,NULL),

/* 3. Letnik, Stud leto = 3, Moduli */
--  Raz prog opr
(218,3,34,102,NULL,NULL),
(219,3,35,124,NULL,NULL),
(220,3,36,108,NULL,NULL),
--  Inf sis
(221,3,37,120,NULL,NULL),
(222,3,38,119,NULL,NULL),
(223,3,39,121,NULL,NULL),
--  Obv inf
(224,3,40,122,NULL,NULL),
(225,3,41,113,NULL,NULL),
(226,3,42,123,NULL,NULL),
--  Rac omr
(227,3,43,126,NULL,NULL),
(228,3,44,103,NULL,NULL),
(229,3,45,125,NULL,NULL),
--  Rac sis
(230,3,46,125,NULL,NULL),
(231,3,47,110,NULL,NULL),
(232,3,48,115,NULL,NULL),
--  Alg pod sis
(233,3,49,106,NULL,NULL),
(234,3,50,114,NULL,NULL),
(235,3,51,105,NULL,NULL),
--  Umet int
(236,3,52,129,NULL,NULL),
(237,3,53,127,NULL,NULL),
(238,3,54,128,NULL,NULL),
--  Med teh
(239,3,55,130,NULL,NULL),
(240,3,56,131,NULL,NULL),
(241,3,57,132,NULL,NULL);

/* -- -- - STUD LETO 3 END -- -- -*/

INSERT INTO `tpo`.`vpis`(`ID_VPIS`, `ID_STUD_LETO`, `ID_LETNIK`, `ID_PROGRAM`, `ID_NACIN`, `ID_VRSTAVPISA`, `ID_OBLIKA`, `POTRJENOST_VPISA`, `VPISNA_STEVILKA`)VALUES
/* Stud leto = 0 -- > Vpisani v 1. letnik */
(1, 0, 1, 11, 1, 1, 1, 1, 63150001),
(2, 1, 2, 11, 1, 1, 1, 1, 63150001),
-- (3, 2, 3, 11, 1, 1, 1, 1, 63150001),

(4, 0, 1, 11, 1, 1, 1, 1, 63150002),
(5, 1, 2, 11, 1, 1, 1, 1, 63150002),
(6, 2, 3, 11, 1, 1, 1, 1, 63150002),

(7, 0, 1, 11, 1, 1, 1, 1, 63150003),
(8, 1, 2, 11, 1, 1, 1, 1, 63150003),
(9, 2, 3, 11, 1, 1, 1, 1, 63150003),

(10, 0, 1, 11, 1, 1, 1, 1, 63150004),
(11, 1, 2, 11, 1, 1, 1, 1, 63150004),
-- (12, 2, 3, 11, 1, 1, 1, 1, 63150004),

(13, 0, 1, 11, 1, 1, 1, 1, 63150005),
(14, 1, 2, 11, 1, 1, 1, 1, 63150005),
(15, 2, 3, 11, 1, 1, 1, 1, 63150005),

/* Stud leto = 1 -- > Vpisani v 1. letnik */
(16, 1, 1, 11, 1, 1, 1, 1, 63150006),
(17, 2, 2, 11, 1, 1, 1, 1, 63150006),

(18, 1, 1, 11, 1, 1, 1, 1, 63150007),
(19, 2, 2, 11, 1, 1, 1, 1, 63150007),

(20, 1, 1, 11, 1, 1, 1, 1, 63150008),
(21, 2, 2, 11, 1, 1, 1, 1, 63150008),

(22, 1, 1, 11, 1, 1, 1, 1, 63150009),
-- (23, 2, 2, 11, 1, 1, 1, 1, 63150009),

(24, 1, 1, 11, 1, 1, 1, 1, 63150010),
(25, 2, 2, 11, 1, 1, 1, 1, 63150010),

/* Stud leto = 2 -- > Vpisani v 1. letnik */
(26, 2, 1, 11, 1, 1, 1, 1, 63150011),
(27, 2, 1, 11, 1, 1, 1, 1, 63150012),
(28, 2, 1, 11, 1, 1, 1, 1, 63150013),
(29, 2, 1, 11, 1, 1, 1, 1, 63150014),
(30, 2, 1, 11, 1, 1, 1, 1, 63150015);


INSERT INTO `tpo`.`student`
(`VPISNA_STEVILKA`,`ID_OSEBA`,`ID_KANDIDAT`,`ID_VPIS`,`EMSO`,`ID_PROGRAM`,
 `VSOTA_OPRAVLJENIH_KREDITNIH_TOCK`,`POVPRECNA_OCENA_OPRAVLJENIH_IZPITOV`)VALUES
  /* Studenti 3. letnika -- > Prvi vpis v STUD_LETO=0 */
  (63150001,1,1,2,1706996500334,11,120,6),
  (63150002,2,2,6,1706996500334,11,150,7),
  (63150003,3,3,9,1706996500334,11,150,8),
  (63150004,4,4,11,1706996500334,11,120,9),
  (63150005,5,5,15,1706996500334,11,150,10),

  /* Studenti 2. letnika -- > Prvi vpis v STUD_LETO=1 */
  (63150006,6,6,17,1706996500334,11,90,6),
  (63150007,7,7,19,1706996500334,11,90,7),
  (63150008,8,8,21,1706996500334,11,90,8),
  (63150009,9,9,22,1706996500334,11,60,9),
  (63150010,10,10,25,1706996500334,11,90,10),

  /* Studenti 1. letnika -- > Prvi vpis v STUD_LETO=2 */
  (63150011,11,11,26,1706996500334,11,30,6),
  (63150012,12,12,27,1706996500334,11,30,7),
  (63150013,13,13,28,1706996500334,11,30,8),
  (63150014,14,14,29,1706996500334,11,30,9),
  (63150015,15,15,30,1706996500334,11,30,10);


INSERT INTO `tpo`.`naslov`(`ID_NASLOV`,`ID_OSEBA`,`ID_POSTA`,`ID_OBCINA`,`ID_DRZAVA`,
                           `JE_ZAVROCANJE`,`JE_STALNI`,`ULICA`) VALUES

  (1,1,420,189,705,0,1,'Litijska cesta 1'),
  (2,1,53,17,705,1,0,'Slovenska cesta 111'),
  (3,2,420,189,705,0,1,'Litijska cesta 1'),
  (4,2,53,17,705,1,0,'Slovenska cesta 111'),
  (5,3,420,189,705,0,1,'Litijska cesta 1'),
  (6,3,53,17,705,1,0,'Slovenska cesta 111'),
  (7,4,420,189,705,0,1,'Litijska cesta 1'),
  (8,4,53,17,705,1,0,'Slovenska cesta 111'),
  (9,5,420,189,705,0,1,'Litijska cesta 1'),
  (10,5,53,17,705,1,0,'Slovenska cesta 111'),
  (11,6,420,189,705,0,1,'Litijska cesta 1'),
  (12,6,53,17,705,1,0,'Slovenska cesta 111'),
  (13,7,420,189,705,0,1,'Litijska cesta 1'),
  (14,7,53,17,705,1,0,'Slovenska cesta 111'),
  (15,8,420,189,705,0,1,'Litijska cesta 1'),
  (16,8,53,17,705,1,0,'Slovenska cesta 111'),
  (17,9,420,189,705,0,1,'Litijska cesta 1'),
  (18,9,53,17,705,1,0,'Slovenska cesta 111'),
  (19,10,420,189,705,0,1,'Litijska cesta 1'),
  (20,10,53,17,705,1,0,'Slovenska cesta 111'),
  (21,11,420,189,705,0,1,'Litijska cesta 1'),
  (22,11,53,17,705,1,0,'Slovenska cesta 111'),
  (23,12,420,189,705,0,1,'Litijska cesta 1'),
  (24,12,53,17,705,1,0,'Slovenska cesta 111'),
  (25,13,420,189,705,0,1,'Litijska cesta 1'),
  (26,13,53,17,705,1,0,'Slovenska cesta 111'),
  (27,14,420,189,705,0,1,'Litijska cesta 1'),
  (28,14,53,17,705,1,0,'Slovenska cesta 111'),
  (29,15,420,189,705,0,1,'Litijska cesta 1'),
  (30,15,53,17,705,1,0,'Slovenska cesta 111');

INSERT INTO  `tpo`.`zeton`
(`ID_OSEBA`, `ID_LETNIK`, `ID_STUD_LETO`, `ID_OBLIKA`, `ID_NACIN`, `ID_VRSTAVPISA`, `ID_PROGRAM`,`IZKORISCEN`, `AKTIVNOST`)
VALUES
  /* Studenti z 1. vtisom v STUD_LETO=0 */
  (1,1,0,1,1,1,11,1,1),
  (1,2,1,1,1,1,11,1,1),
  -- (1,3,2,1,1,1,11,1,1),

  (2,1,0,1,1,1,11,1,1),
  (2,2,1,1,1,1,11,1,1),
  (2,3,2,1,1,1,11,1,1),

  (3,1,0,1,1,1,11,1,1),
  (3,2,1,1,1,1,11,1,1),
  (3,3,2,1,1,1,11,1,1),

  (4,1,0,1,1,1,11,1,1),
  (4,2,1,1,1,1,11,1,1),
  -- (4,3,2,1,1,1,11,1,1),

  (5,1,0,1,1,1,11,1,1),
  (5,2,1,1,1,1,11,1,1),
  (5,3,2,1,1,1,11,1,1),

  /* Studenti z 1. vtisom v STUD_LETO=1 */
  (6,1,1,1,1,1,11,1,1),
  (6,2,2,1,1,1,11,1,1),

  (7,1,1,1,1,1,11,1,1),
  (7,2,2,1,1,1,11,1,1),

  (8,1,1,1,1,1,11,1,1),
  (8,2,2,1,1,1,11,1,1),

  (9,1,1,1,1,1,11,1,1),
  -- (9,2,2,1,1,1,11,1,1),

  (10,1,1,1,1,1,11,1,1),
  (10,2,2,1,1,1,11,1,1),

  /* Studenti z 1. vtisom v STUD_LETO=2 */
  (11,1,2,1,1,1,11,1,1),
  (12,2,2,1,1,1,11,1,1),
  (13,2,2,1,1,1,11,1,1),
  (14,2,2,1,1,1,11,1,1),
  (15,2,2,1,1,1,11,1,1);

INSERT INTO tpo.rok
(ID_ROK, ID_IZVEDBA, DATUM_ROKA, CAS_ROKA, AKTIVNOST, ID_OSEBA_IZPRASEVALEC1, ID_OSEBA_IZPRASEVALEC2, ID_OSEBA_IZPRASEVALEC3)
VALUES

  /* Stud. leto 0 -- > Imamo le studente 1. letnika: 001-005 */
  --  Roki 1. letnik
  (1,1,'2016-01-04','10:00:00',1,102,NULL,NULL),     --  P1
  (2,2,'2016-01-05','10:00:00',1,101,NULL,NULL),     --  OMA
  (3,3,'2016-01-06','10:00:00',1,100,NULL,NULL),     --  DS
  (4,4,'2016-01-07','10:00:00',1,103,NULL,NULL),     --  ODV
  (5,5,'2016-01-08','10:00:00',1,104,NULL,NULL),     --  FIZ

  (6,6,'2016-06-06','10:00:00',1,105,NULL,NULL),     --  P2
  (7,7,'2016-06-07','10:00:00',1,109,NULL,NULL),     --  LA
  (8,8,'2016-06-08','10:00:00',1,106,NULL,NULL),     --  ARS
  (9,9,'2016-06-09','10:00:00',1,107,NULL,NULL),     --  RK
  (10,10,'2016-06-10','10:00:00',1,108,NULL,NULL),    --  OIS

  /* Stud. leto 1 -- > Imamo 5 stud 1. let, 5 stud 2. letnik */
  --  Roki 1. letnik
  (11,61,'2017-01-04','10:00:00',1,102,NULL,NULL),     --  P1
  (12,62,'2017-01-05','10:00:00',1,101,NULL,NULL),     --  OMA
  (13,63,'2017-01-06','10:00:00',1,100,NULL,NULL),     --  DS
  (14,64,'2017-01-09','10:00:00',1,103,NULL,NULL),     --  ODV
  (15,65,'2017-01-10','10:00:00',1,104,NULL,NULL),     --  FIZ

  (16,66,'2017-06-05','10:00:00',1,105,NULL,NULL),     --  P2
  (17,67,'2017-06-06','10:00:00',1,109,NULL,NULL),     --  LA
  (18,68,'2017-06-07','10:00:00',1,106,NULL,NULL),     --  ARS
  (19,69,'2017-06-08','10:00:00',1,107,NULL,NULL),     --  RK
  (20,70,'2017-06-09','10:00:00',1,108,NULL,NULL),    --  OIS

  --  Roki 2. letnik
  (21,71,'2017-01-04','10:00:00',1,112,NULL,NULL),     --  APS1
  (22,72,'2017-01-05','10:00:00',1,114,NULL,NULL),     --  APS2
  (23,73,'2017-01-06','10:00:00',1,113,NULL,NULL),     --  OPB
  (24,74,'2017-01-09','10:00:00',1,111,NULL,NULL),     --  VS
  (25,75,'2017-01-10','10:00:00',1,114,NULL,NULL),     --  IRZ
  (26,76,'2017-06-05','10:00:00',1,115,NULL,NULL),     --  TIS
  (27,77,'2017-06-06','10:00:00',1,114,NULL,NULL),     --  OS
  (28,78,'2017-06-07','10:00:00',1,110,NULL,NULL),     --  ORS

  (29,80,'2017-06-08','10:00:00',1,116,NULL,NULL),     --  MM

  /* Stud. leto 2 -- > Imamo 5 stud 1. let, 5 stud 2. letnik, 5 stud 3. letnik */
   --  Roki 1. letnik - 1. semester
  (30,122,'2018-01-04','10:00:00',1,102,NULL,NULL),     --  P1
  (31,123,'2018-01-05','10:00:00',1,101,NULL,NULL),     --  OMA
  (32,124,'2018-01-08','10:00:00',1,100,NULL,NULL),     --  DS
  (33,125,'2018-01-09','10:00:00',1,103,NULL,NULL),     --  ODV
  (34,126,'2018-01-10','10:00:00',1,104,NULL,NULL),     --  FIZ

  (35,122,'2018-01-22','10:00:00',1,102,NULL,NULL),     --  P1
  (36,123,'2018-01-23','10:00:00',1,101,NULL,NULL),     --  OMA
  (37,124,'2018-01-24','10:00:00',1,100,NULL,NULL),     --  DS
  (38,125,'2018-01-25','10:00:00',1,103,NULL,NULL),     --  ODV
  (39,126,'2018-01-26','10:00:00',1,104,NULL,NULL),     --  FIZ

  (40,122,'2018-06-18','10:00:00',1,102,NULL,NULL),     --  P1
  (41,123,'2018-06-19','10:00:00',1,101,NULL,NULL),     --  OMA
  (42,124,'2018-06-20','10:00:00',1,100,NULL,NULL),     --  DS
  (43,125,'2018-06-21','10:00:00',1,103,NULL,NULL),     --  ODV
  (44,126,'2018-06-22','10:00:00',1,104,NULL,NULL),     --  FIZ

  --  Roki 1. letnik - 2. semester
  (45,127,'2018-06-04','10:00:00',1,105,NULL,NULL),     --  P2
  (46,128,'2018-06-05','10:00:00',1,109,NULL,NULL),     --  LA
  (47,129,'2018-06-06','10:00:00',1,106,NULL,NULL),     --  ARS
  (48,130,'2018-06-07','10:00:00',1,107,NULL,NULL),     --  RK
  (49,131,'2018-06-08','10:00:00',1,108,NULL,NULL),    --  OIS

  (50,127,'2018-06-25','10:00:00',1,105,NULL,NULL),     --  P2
  (51,128,'2018-06-26','10:00:00',1,109,NULL,NULL),     --  LA
  (52,129,'2018-06-27','10:00:00',1,106,NULL,NULL),     --  ARS
  (53,130,'2018-06-28','10:00:00',1,107,NULL,NULL),     --  RK
  (54,131,'2018-06-29','10:00:00',1,108,NULL,NULL),    --  OIS

  (55,127,'2018-07-02','10:00:00',1,105,NULL,NULL),     --  P2
  (56,128,'2018-07-03','10:00:00',1,109,NULL,NULL),     --  LA
  (57,129,'2018-07-04','10:00:00',1,106,NULL,NULL),     --  ARS
  (58,130,'2018-07-05','10:00:00',1,107,NULL,NULL),     --  RK
  (59,131,'2018-07-06','10:00:00',1,108,NULL,NULL),    --  OIS

  --  Roki 2. letnik
  (60,132,'2018-01-04','10:00:00',1,112,NULL,NULL),     --  APS1 z
  (61,133,'2018-06-04','10:00:00',1,114,NULL,NULL),     --  APS2 p
  (62,134,'2018-01-08','10:00:00',1,113,NULL,NULL),     --  OPB  z
  (63,135,'2018-01-09','10:00:00',1,111,NULL,NULL),     --  VS   z
  (64,136,'2018-01-10','10:00:00',1,114,NULL,NULL),     --  IRZ  z
  (65,137,'2018-06-05','10:00:00',1,115,NULL,NULL),     --  TIS  p
  (66,138,'2018-06-06','10:00:00',1,114,NULL,NULL),     --  OS   p
  (67,139,'2018-01-15','10:00:00',1,110,NULL,NULL),     --  ORS  z
  (68,141,'2018-06-07','10:00:00',1,116,NULL,NULL),     --  MM   p

  (69,132,'2018-01-11','10:00:00',1,112,NULL,NULL),     --  APS1  z
  (70,133,'2018-06-25','10:00:00',1,114,NULL,NULL),     --  APS2  p
  (71,134,'2018-01-13','10:00:00',1,113,NULL,NULL),     --  OPB   z
  (72,135,'2018-01-14','10:00:00',1,111,NULL,NULL),     --  VS    z
  (73,136,'2018-01-15','10:00:00',1,114,NULL,NULL),     --  IRZ   z
  (74,137,'2018-06-26','10:00:00',1,115,NULL,NULL),     --  TIS   p
  (75,138,'2018-06-27','10:00:00',1,114,NULL,NULL),     --  OS    p
  (76,139,'2018-01-20','10:00:00',1,110,NULL,NULL),     --  ORS   z
  (77,141,'2018-06-28','10:00:00',1,116,NULL,NULL),     --  MM    p

  (78,132,'2018-09-03','10:00:00',1,112,NULL,NULL),     --  APS1
  (79,133,'2018-09-04','10:00:00',1,114,NULL,NULL),     --  APS2
  (80,134,'2018-09-05','10:00:00',1,113,NULL,NULL),     --  OPB
  (81,135,'2018-09-06','10:00:00',1,111,NULL,NULL),     --  VS
  (82,136,'2018-09-07','10:00:00',1,114,NULL,NULL),     --  IRZ
  (83,137,'2018-09-10','10:00:00',1,115,NULL,NULL),     --  TIS
  (84,138,'2018-09-11','10:00:00',1,114,NULL,NULL),     --  OS
  (85,139,'2018-09-12','10:00:00',1,110,NULL,NULL),     --  ORS
  (86,141,'2018-09-13','10:00:00',1,116,NULL,NULL),     --  MM

  --  Roki 3. letnik
  (87,155,'2018-01-04','10:00:00',1,107,NULL,NULL),       --  OUI   z
  (88,156,'2018-06-04','10:00:00',1,127,128,129),         --  EP    p
  (89,158,'2018-06-05','10:00:00',1,102,NULL,NULL),       --  TPO   p
  (90,159,'2018-01-09','10:00:00',1,124,NULL,NULL),       --  PRPO  z
  (91,160,'2018-01-10','10:00:00',1,108,NULL,NULL),       --  SP    z
  (92,173,'2018-01-13','10:00:00',1,106,NULL,NULL),       --  SPO   z
  (93,174,'2018-01-14','10:00:00',1,114,NULL,NULL),       --  RZHP  z
  (94,175,'2018-06-06','10:00:00',1,105,NULL,NULL),       --  PRE   p

  (95,155,'2018-01-11','10:00:00',1,107,NULL,NULL),       --  OUI   z
  (96,156,'2018-06-25','10:00:00',1,127,128,129),         --  EP    p
  (97,158,'2018-06-26','10:00:00',1,102,NULL,NULL),       --  TPO   p
  (98,159,'2018-01-14','10:00:00',1,124,NULL,NULL),       --  PRPO  z
  (99,160,'2018-01-15','10:00:00',1,108,NULL,NULL),       --  SP    z
  (100,173,'2018-01-18','10:00:00',1,106,NULL,NULL),       --  SPO  z
  (101,174,'2018-01-19','10:00:00',1,114,NULL,NULL),       --  RZHP z
  -- (102,175,'2018-06-20','10:00:00',1,105,NULL,NULL),       --  PRE  p

  (103,155,'2018-09-03','10:00:00',1,107,NULL,NULL),       --  OUI  z
  (104,156,'2018-09-04','10:00:00',1,127,128,129),         --  EP   p
  (105,158,'2018-09-05','10:00:00',1,102,NULL,NULL),       --  TPO  p
  (106,159,'2018-09-06','10:00:00',1,124,NULL,NULL),       --  PRPO p
  (107,160,'2018-09-07','10:00:00',1,108,NULL,NULL),       --  SP   z
  (108,173,'2018-09-10','10:00:00',1,106,NULL,NULL),       --  SPO  z
  (109,174,'2018-09-11','10:00:00',1,114,NULL,NULL),       --  RZHP z
  (110,175,'2018-09-12','10:00:00',1,105,NULL,NULL),       --  PRE  p

  -- Dodajanje za Izbrana poglavja RI - Ehratatan
  (111,93,'2017-09-09','10:00:00',1,105,NULL,NULL);


INSERT INTO `predmeti_studenta`
(`ID_PREDMETISTUDENTA`, `VPISNA_STEVILKA`, `ID_PREDMET`, `ID_STUD_LETO`, `OCENA`)
VALUES

  /* 1. Letnik, Stud leto=0. St. vpisanih = 5 */
  (0,63150001,10,0,6),
  (1,63150001,11,0,6),
  (2,63150001,12,0,6),
  (3,63150001,13,0,6),
  (4,63150001,14,0,6),
  (5,63150001,15,0,6),
  (6,63150001,16,0,6),
  (7,63150001,17,0,6),
  (8,63150001,18,0,6),
  (9,63150001,19,0,6),

  (10,63150002,10,0,7),
  (11,63150002,11,0,7),
  (12,63150002,12,0,7),
  (13,63150002,13,0,7),
  (14,63150002,14,0,7),
  (15,63150002,15,0,7),
  (16,63150002,16,0,7),
  (17,63150002,17,0,7),
  (18,63150002,18,0,7),
  (19,63150002,19,0,7),

  (20,63150003,10,0,8),
  (21,63150003,11,0,8),
  (22,63150003,12,0,8),
  (23,63150003,13,0,8),
  (24,63150003,14,0,8),
  (25,63150003,15,0,8),
  (26,63150003,16,0,8),
  (27,63150003,17,0,8),
  (28,63150003,18,0,8),
  (29,63150003,19,0,8),

  (30,63150004,10,0,9),
  (31,63150004,11,0,9),
  (32,63150004,12,0,9),
  (33,63150004,13,0,9),
  (34,63150004,14,0,9),
  (35,63150004,15,0,9),
  (36,63150004,16,0,9),
  (37,63150004,17,0,9),
  (38,63150004,18,0,9),
  (39,63150004,19,0,9),

  (40,63150005,10,0,10),
  (41,63150005,11,0,10),
  (42,63150005,12,0,10),
  (43,63150005,13,0,10),
  (44,63150005,14,0,10),
  (45,63150005,15,0,10),
  (46,63150005,16,0,10),
  (47,63150005,17,0,10),
  (48,63150005,18,0,10),
  (49,63150005,19,0,10),

  /* STUD_LETO=1. St. vpisanih=10 (5 v 1.let, 5 v 2.let) */

  --  Vpisi v prvi letnik
    (50,63150006,10,1,6),
    (51,63150006,11,1,6),
    (52,63150006,12,1,6),
    (53,63150006,13,1,6),
    (54,63150006,14,1,6),
    (55,63150006,15,1,6),
    (56,63150006,16,1,6),
    (57,63150006,17,1,6),
    (58,63150006,18,1,6),
    (59,63150006,19,1,6),

    (60,63150007,10,1,7),
    (61,63150007,11,1,7),
    (62,63150007,12,1,7),
    (63,63150007,13,1,7),
    (64,63150007,14,1,7),
    (65,63150007,15,1,7),
    (66,63150007,16,1,7),
    (67,63150007,17,1,7),
    (68,63150007,18,1,7),
    (69,63150007,19,1,7),

    (70,63150008,10,1,8),
    (71,63150008,11,1,8),
    (72,63150008,12,1,8),
    (73,63150008,13,1,8),
    (74,63150008,14,1,8),
    (75,63150008,15,1,8),
    (76,63150008,16,1,8),
    (77,63150008,17,1,8),
    (78,63150008,18,1,8),
    (79,63150008,19,1,8),

    (80,63150009,10,1,9),
    (81,63150009,11,1,9),
    (82,63150009,12,1,9),
    (83,63150009,13,1,9),
    (84,63150009,14,1,9),
    (85,63150009,15,1,9),
    (86,63150009,16,1,9),
    (87,63150009,17,1,9),
    (88,63150009,18,1,9),
    (89,63150009,19,1,9),

    (90,63150010,10,1,10),
    (91,63150010,11,1,10),
    (92,63150010,12,1,10),
    (93,63150010,13,1,10),
    (94,63150010,14,1,10),
    (95,63150010,15,1,10),
    (96,63150010,16,1,10),
    (97,63150010,17,1,10),
    (98,63150010,18,1,10),
    (99,63150010,19,1,10),

  --  Vpisi v drugi letnik
    /* 001 */
    (100,63150001,20,1,6),
    (101,63150001,21,1,6),
    (102,63150001,22,1,6),
    (103,63150001,23,1,6),
    (104,63150001,24,1,6),
    (105,63150001,25,1,6),
    (106,63150001,26,1,6),
    (107,63150001,27,1,6),
    --  Strokovni izbirni
    (108,63150001,29,1,6),
    --  Splosni izbirni
    (109,63150001,100,1,6),
    (110,63150001,101,1,6),

    /* 002 */
    (111,63150002,20,1,7),
    (112,63150002,21,1,7),
    (113,63150002,22,1,7),
    (114,63150002,23,1,7),
    (115,63150002,24,1,7),
    (116,63150002,25,1,7),
    (117,63150002,26,1,7),
    (118,63150002,27,1,7),
    --  Strokovni izbirni
    (119,63150002,29,1,7),
    --  Splosni izbirni
    (120,63150002,102,1,7),
    (121,63150002,103,1,7),

    /* 003 */
    (122,63150003,20,1,8),
    (123,63150003,21,1,8),
    (124,63150003,22,1,8),
    (125,63150003,23,1,8),
    (126,63150003,24,1,8),
    (127,63150003,25,1,8),
    (128,63150003,26,1,8),
    (129,63150003,27,1,8),
    -- Strokovni izbirni
    (130,63150003,29,1,8),
    -- Splosni izbirni
    (131,63150003,104,1,8),
    (132,63150003,105,1,8),

    /* 504 */
    (133,63150004,20,1,9),
    (134,63150004,21,1,9),
    (135,63150004,22,1,9),
    (136,63150004,23,1,9),
    (137,63150004,24,1,9),
    (138,63150004,25,1,9),
    (139,63150004,26,1,9),
    (140,63150004,27,1,9),
    -- Strokovni izbirni
    (141,63150004,29,1,9),
    -- Splosni izbirni
    (142,63150004,110,1,9),

    /* 505 */
    (143,63150005,20,1,10),
    (144,63150005,21,1,10),
    (145,63150005,22,1,10),
    (146,63150005,23,1,10),
    (147,63150005,24,1,10),
    (148,63150005,25,1,10),
    (149,63150005,26,1,10),
    (150,63150005,27,1,10),
    -- Strokovni izbirni
    (151,63150005,29,1,10),
    -- Splosni izbirni
    (152,63150005,111,1,10),

  /* STUD_LETO=2. St. vpisanih=15 (5 v 1.let, 5 v 2.let, 5 v 3.let) */

    --  Vpisi v prvi letnik
    (153,63150011,10,2,6),
    (154,63150011,11,2,6),
    (155,63150011,12,2,6),
    (156,63150011,13,2,6),
    (157,63150011,14,2,6),
    (158,63150011,15,2,0),
    (159,63150011,16,2,0),
    (160,63150011,17,2,0),
    (161,63150011,18,2,0),
    (162,63150011,19,2,0),

    (163,63150012,10,2,7),
    (164,63150012,11,2,7),
    (165,63150012,12,2,7),
    (166,63150012,13,2,7),
    (167,63150012,14,2,7),
    (168,63150012,15,2,0),
    (169,63150012,16,2,0),
    (170,63150012,17,2,0),
    (171,63150012,18,2,0),
    (172,63150012,19,2,0),

    (173,63150013,10,2,8),
    (174,63150013,11,2,8),
    (175,63150013,12,2,8),
    (176,63150013,13,2,8),
    (177,63150013,14,2,8),
    (178,63150013,15,2,0),
    (179,63150013,16,2,0),
    (180,63150013,17,2,0),
    (181,63150013,18,2,0),
    (182,63150013,19,2,0),

    (193,63150014,10,2,9),
    (194,63150014,11,2,9),
    (195,63150014,12,2,9),
    (196,63150014,13,2,9),
    (197,63150014,14,2,9),
    (198,63150014,15,2,0),
    (199,63150014,16,2,0),
    (200,63150014,17,2,0),
    (201,63150014,18,2,0),
    (202,63150014,19,2,0),

    (203,63150015,10,2,10),
    (204,63150015,11,2,10),
    (205,63150015,12,2,10),
    (206,63150015,13,2,10),
    (207,63150015,14,2,10),
    (208,63150015,15,2,0),
    (209,63150015,16,2,0),
    (210,63150015,17,2,0),
    (211,63150015,18,2,0),
    (212,63150015,19,2,0),

    --  Vpisi v drugi letnik
    /* 006 */
    (213,63150006,20,2,6),
    (214,63150006,21,2,0),
    (215,63150006,22,2,6),
    (216,63150006,23,2,6),
    (217,63150006,24,2,6),
    (218,63150006,25,2,0),
    (219,63150006,26,2,0),
    (220,63150006,27,2,6),
    -- Strokovni izbirni
    (221,63150006,29,2,0),
    -- Splosni izbirni
    (222,63150006,100,2,0),
    (223,63150006,101,2,0),

    /* 007 */
    (224,63150007,20,2,7),
    (225,63150007,21,2,0),
    (226,63150007,22,2,7),
    (227,63150007,23,2,7),
    (228,63150007,24,2,7),
    (229,63150007,25,2,0),
    (230,63150007,26,2,0),
    (231,63150007,27,2,7),
    -- Strokovni izbirni
    (232,63150007,29,2,0),
    -- Splosni izbirni
    (233,63150007,102,2,0),
    (234,63150007,103,2,0),

    /* 008 */
    (235,63150008,20,2,8),
    (236,63150008,21,2,0),
    (237,63150008,22,2,8),
    (238,63150008,23,2,8),
    (239,63150008,24,2,8),
    (240,63150008,25,2,0),
    (241,63150008,26,2,0),
    (242,63150008,27,2,8),
    -- Strokovni izbirni
    (243,63150008,29,2,0),
    -- Splosni izbirni
    (244,63150008,104,2,0),
    (245,63150008,105,2,0),

    /* 009 */
    -- (246,63150009,20,2,9),
    -- (247,63150009,21,2,9),
    -- (248,63150009,22,2,9),
    -- (249,63150009,23,2,9),
    -- (250,63150009,24,2,9),
    -- (251,63150009,25,2,9),
    -- (252,63150009,26,2,9),
    -- (253,63150009,27,2,9),
    -- Strokovni izbirni
    -- (254,63150009,29,2,9),
    -- Splosni izbirni
    -- (255,63150009,110,2,9),

    /* 010 */
    (256,63150010,20,2,10),
    (257,63150010,21,2,0),
    (258,63150010,22,2,10),
    (259,63150010,23,2,10),
    (260,63150010,24,2,10),
    (261,63150010,25,2,0),
    (262,63150010,26,2,0),
    (263,63150010,27,2,10),
    -- Strokovni izbirni
    (264,63150010,29,2,0),
    -- Splosni izbirni
    (265,63150010,111,2,0),

    --  Vpisi v 3. letnik
    /* 001 - Povp 6*/
    -- (266,63150001,31,2,6),
    -- (267,63150001,32,2,6),
    -- (268,63150001,33,2,6),

    -- (269,63150001,34,2,6),
    -- (270,63150001,35,2,6),
    -- (271,63150001,36,2,6),
    -- (272,63150001,49,2,6),
    -- (273,63150001,50,2,6),
    -- (274,63150001,51,2,6),
    -- (275,63150001,109,2,6),

    /* 002 - Povp 7 */
    (276,63150002,31,2,7),
    (277,63150002,32,2,0),
    (278,63150002,33,2,0),

    (279,63150002,34,2,0),
    (280,63150002,35,2,7),
    (281,63150002,36,2,7),
    (282,63150002,49,2,7),
    (283,63150002,50,2,7),
    (284,63150002,51,2,0),
    (285,63150002,109,2,7),

    /* 003 - Povp 8 */
    (286,63150003,31,2,8),
    (287,63150003,32,2,0),
    (288,63150003,33,2,0),

    (289,63150003,34,2,0),
    (290,63150003,35,2,8),
    (291,63150003,36,2,8),
    (292,63150003,49,2,8),
    (293,63150003,50,2,8),
    (294,63150003,51,2,0),
    (296,63150003,109,2,8),

    /* 004 - Povp 9 */
    -- (297,63150004,31,2,9),
    -- (298,63150004,32,2,9),
    -- (299,63150004,33,2,9),

    -- (300,63150004,34,2,9),
    -- (301,63150004,35,2,9),
    -- (302,63150004,36,2,9),
    -- (303,63150004,49,2,9),
    -- (304,63150004,50,2,9),
    -- (305,63150004,51,2,9),
    -- (306,63150004,109,2,9),

    /* 005 - Povp 10 */
    (307,63150005,31,2,10),
    (308,63150005,32,2,0),
    (309,63150005,33,2,0),

    (310,63150005,34,2,0),
    (311,63150005,35,2,10),
    (312,63150005,36,2,10),
    (313,63150005,49,2,10),
    (314,63150005,50,2,10),
    (315,63150005,51,2,0),
    (316,63150005,109,2,10);

INSERT INTO prijava(ID_PRIJAVA, ID_ROK, VPISNA_STEVILKA, ZAP_ST_POLAGANJ, ZAP_ST_POLAGANJ_LETOS, PODATKI_O_PLACILU, TOCKE_IZPITA, OCENA_IZPITA, DATUM_PRIJAVE, DATUM_ODJAVE) VALUES

  /* Prijave STUD_LETO = 0, 5 stud 1. letnik */
  --  P1
  (1,1,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (2,1,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (3,1,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (4,1,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (5,1,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  OMA
  (6,2,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (7,2,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (8,2,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (9,2,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (10,2,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  DS
  (11,3,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (12,3,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (13,3,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (14,3,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (15,3,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  ODV
  (16,4,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (17,4,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (18,4,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (19,4,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (20,4,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  FIZ
  (21,5,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (22,5,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (23,5,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (24,5,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (25,5,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  P2
  (26,6,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (27,6,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (28,6,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (29,6,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (30,6,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  LA
  (31,7,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (32,7,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (33,7,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (34,7,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (35,7,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  ARS
  (36,8,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (37,8,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (38,8,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (39,8,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (40,8,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  RK
  (41,9,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (42,9,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (43,9,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (44,9,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (45,9,63150005,1,1,1,90,10,'2016-01-01',NULL),
  --  OIS
  (46,10,63150001,1,1,1,50,6,'2016-01-01',NULL),
  (47,10,63150002,1,1,1,60,7,'2016-01-01',NULL),
  (48,10,63150003,1,1,1,70,8,'2016-01-01',NULL),
  (49,10,63150004,1,1,1,80,9,'2016-01-01',NULL),
  (50,10,63150005,1,1,1,90,10,'2016-01-01',NULL),

   /* Prijave STUD_LETO = 1, 5 stud 1. letnik, 5 stud 2. letnik */
   /* -- - 1. letnik -- - */
   --  P1
  (51,11,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (52,11,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (53,11,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (54,11,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (55,11,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  OMA
  (56,12,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (57,12,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (58,12,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (59,12,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (60,12,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  DS
  (61,13,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (62,13,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (63,13,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (64,13,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (65,13,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  ODV
  (66,14,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (67,14,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (68,14,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (69,14,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (70,14,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  FIZ
  (71,15,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (72,15,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (73,15,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (74,15,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (75,15,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  P2
  (76,16,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (77,16,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (78,16,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (79,16,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (80,16,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  LA
  (81,17,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (82,17,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (83,17,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (84,17,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (85,17,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  ARS
  (86,18,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (87,18,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (88,18,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (89,18,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (90,18,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  RK
  (91,19,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (92,19,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (93,19,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (94,19,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (95,19,63150010,1,1,1,90,10,'2017-01-01',NULL),
  --  OIS
  (96,20,63150006,1,1,1,50,6,'2017-01-01',NULL),
  (97,20,63150007,1,1,1,60,7,'2017-01-01',NULL),
  (98,20,63150008,1,1,1,70,8,'2017-01-01',NULL),
  (99,20,63150009,1,1,1,80,9,'2017-01-01',NULL),
  (100,20,63150010,1,1,1,90,10,'2017-01-01',NULL),

  /* -- - 2. letnik -- - */
  --  APS1
  (101,21,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (102,21,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (103,21,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (104,21,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (105,21,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  APS2
  (106,22,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (107,22,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (108,22,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (109,22,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (110,22,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  OPB
  (111,23,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (112,23,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (113,23,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (114,23,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (115,23,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  VS
  (116,24,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (117,24,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (118,24,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (119,24,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (120,24,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  IRZ
  (121,25,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (122,25,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (123,25,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (124,25,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (125,25,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  TIS
  (126,26,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (127,26,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (128,26,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (129,26,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (130,26,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  OS
  (131,27,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (132,27,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (133,27,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (134,27,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (135,27,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  ORS
  (136,28,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (137,28,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (138,28,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (139,28,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (140,28,63150005,1,1,1,90,10,'2017-01-01',NULL),
  --  MM
  (141,29,63150001,1,1,1,50,6,'2017-01-01',NULL),
  (142,29,63150002,1,1,1,60,7,'2017-01-01',NULL),
  (143,29,63150003,1,1,1,70,8,'2017-01-01',NULL),
  (144,29,63150004,1,1,1,80,9,'2017-01-01',NULL),
  (145,29,63150005,1,1,1,90,10,'2017-01-01',NULL),
  -- Izbrana poglavja
  (222,111,63150004,1,1,1,80,9,'2017-01-01',NULL),

  /* Stud. leto = 2. 5 v 1l, 5 v 2l, 5 v 3l */
  --  1. Letnik
   --  P1
  (146,30,63150011,1,1,1,50,6,'2018-01-01',NULL),
  (147,35,63150012,1,1,1,60,7,'2018-01-01',NULL),
  (148,30,63150013,1,1,1,70,8,'2018-01-01',NULL),
  (149,35,63150014,1,1,1,80,9,'2018-01-01',NULL),
  (150,30,63150015,1,1,1,90,10,'2018-01-01',NULL),
  --  OMA
  (151,31,63150011,1,1,1,50,6,'2018-01-01',NULL),
  (152,36,63150012,1,1,1,60,7,'2018-01-01',NULL),
  (153,31,63150013,1,1,1,70,8,'2018-01-01',NULL),
  (154,36,63150014,1,1,1,80,9,'2018-01-01',NULL),
  (155,31,63150015,1,1,1,90,10,'2018-01-01',NULL),
  --  DS
  (156,32,63150011,1,1,1,50,6,'2018-01-01',NULL),
  (157,37,63150012,1,1,1,60,7,'2018-01-01',NULL),
  (158,32,63150013,1,1,1,70,8,'2018-01-01',NULL),
  (159,37,63150014,1,1,1,80,9,'2018-01-01',NULL),
  (160,32,63150015,1,1,1,90,10,'2018-01-01',NULL),
  --  ODV
  (161,33,63150011,1,1,1,50,6,'2018-01-01',NULL),
  (162,38,63150012,1,1,1,60,7,'2018-01-01',NULL),
  (163,33,63150013,1,1,1,70,8,'2018-01-01',NULL),
  (164,38,63150014,1,1,1,80,9,'2018-01-01',NULL),
  (165,33,63150015,1,1,1,90,10,'2018-01-01',NULL),
  --  FIZ
  (166,34,63150011,1,1,1,50,6,'2018-01-01',NULL),
  (167,39,63150012,1,1,1,60,7,'2018-01-01',NULL),
  (168,34,63150013,1,1,1,70,8,'2018-01-01',NULL),
  (169,39,63150014,1,1,1,80,9,'2018-01-01',NULL),
  (170,34,63150015,1,1,1,90,10,'2018-01-01',NULL),

  --  2. letnik
  --  APS1
  (171,60,63150006,1,1,1,50,6,'2018-01-01',NULL),
  (172,69,63150007,1,1,1,60,7,'2018-01-01',NULL),
  (173,60,63150008,1,1,1,70,8,'2018-01-01',NULL),
  (174,69,63150009,1,1,1,80,9,'2018-01-01',NULL),
  (175,60,63150010,1,1,1,90,10,'2018-01-01',NULL),
  --  OPB
  (176,62,63150006,1,1,1,50,6,'2018-01-01',NULL),
  (177,71,63150007,1,1,1,60,7,'2018-01-01',NULL),
  (178,62,63150008,1,1,1,70,8,'2018-01-01',NULL),
  (179,71,63150009,1,1,1,80,9,'2018-01-01',NULL),
  (180,62,63150010,1,1,1,90,10,'2018-01-01',NULL),
  --  VS
  (181,63,63150006,1,1,1,50,6,'2018-01-01',NULL),
  (182,72,63150007,1,1,1,60,7,'2018-01-01',NULL),
  (183,63,63150008,1,1,1,70,8,'2018-01-01',NULL),
  (184,72,63150009,1,1,1,80,9,'2018-01-01',NULL),
  (185,63,63150010,1,1,1,90,10,'2018-01-01',NULL),
  --  IRZ
  (186,64,63150006,1,1,1,50,6,'2018-01-01',NULL),
  (187,73,63150007,1,1,1,60,7,'2018-01-01',NULL),
  (188,64,63150008,1,1,1,70,8,'2018-01-01',NULL),
  (189,74,63150009,1,1,1,80,9,'2018-01-01',NULL),
  (190,64,63150010,1,1,1,90,10,'2018-01-01',NULL),
  --  ORS
  (191,67,63150006,1,1,1,50,6,'2018-01-01',NULL),
  (192,76,63150007,1,1,1,60,7,'2018-01-01',NULL),
  (193,67,63150008,1,1,1,70,8,'2018-01-01',NULL),
  (194,76,63150009,1,1,1,80,9,'2018-01-01',NULL),
  (195,67,63150010,1,1,1,90,10,'2018-01-01',NULL),

  --  3. letnik
  --  OUI
  (196,87,63150001,1,1,1,50,6,'2018-01-01',NULL),
  (197,95,63150002,1,1,1,60,7,'2018-01-01',NULL),
  (198,87,63150003,1,1,1,70,8,'2018-01-01',NULL),
  (199,87,63150004,1,1,1,80,5,'2018-01-01',NULL),
  (200,87,63150005,1,1,1,90,10,'2018-01-01',NULL),
  (221,95,63150004,2,2,1,90,9,'2018-01-01',NULL),
  --  PRPO
  (201,90,63150001,1,1,1,50,6,'2018-01-01',NULL),
  (202,98,63150002,1,1,1,60,7,'2018-01-01',NULL),
  (203,90,63150003,1,1,1,70,8,'2018-01-01',NULL),
  (204,98,63150004,1,1,1,80,9,'2018-01-01',NULL),
  (205,90,63150005,1,1,1,90,10,'2018-01-01',NULL),
  --  SP
  (206,91,63150001,1,1,1,50,6,'2018-01-01',NULL),
  (207,99,63150002,1,1,1,60,7,'2018-01-01',NULL),
  (208,91,63150003,1,1,1,70,8,'2018-01-01',NULL),
  (209,99,63150004,1,1,1,80,9,'2018-01-01',NULL),
  (210,91,63150005,1,1,1,90,10,'2018-01-01',NULL),
  --  SPO
  (211,92,63150001,1,1,1,50,6,'2018-01-01',NULL),
  (212,100,63150002,1,1,1,60,7,'2018-01-01',NULL),
  (213,92,63150003,1,1,1,70,8,'2018-01-01',NULL),
  (214,100,63150004,1,1,1,80,9,'2018-01-01',NULL),
  (215,92,63150005,1,1,1,90,10,'2018-01-01',NULL),
  --  RZHP
  (216,93,63150001,1,1,1,50,6,'2018-01-01',NULL),
  (217,101,63150002,1,1,1,60,7,'2018-01-01',NULL),
  (218,93,63150003,1,1,1,70,8,'2018-01-01',NULL),
  (219,101,63150004,1,1,1,80,9,'2018-01-01',NULL),
  (220,93,63150005,1,1,1,90,10,'2018-01-01',NULL);
  -- Erhatatan, Rok 111
  -- (223,111,63150004,1,1,1,80,9,'2017-01-01',NULL);
  

INSERT INTO `posta_obcina` (`MID_POSTA`, `MID_OBCINA`) VALUES
  (21431010,	11027156),
  (21431125,	11027962),
  (21428574,	11027156),
  (21432539,	11027156),
  (21432164,	11027156),
  (21429481,	11027156),
  (21431036,	11027962),
  (21428698,	11027962),
  (21429180,	11027156),
  (21432954,	11027156),
  (21431656,	11027156),
  (21431834,	11027156),
  (21428850,	11027156),
  (21430404,	11027849),
  (21430455,	11027849),
  (21430137,	11027784),
  (21428612,	11026982),
  (21430048,	11026982),
  (21428469,	11026982),
  (21432024,	11026982),
  (21430064,	11027911),
  (21430820,	11027911),
  (21430854,	11027113),
  (21430951,	11027148),
  (21433390,	11026982),
  (21431257,	11026982),
  (21433420,	11027008),
  (21433284,	11027016),
  (21430447,	11027849),
  (21430439,	11027849),
  (21430412,	11027849),
  (21430234,	11026982),
  (21431150,	11027008),
  (21429856,	11027008),
  (21430242,	11027806),
  (21428973,	11027016),
  (21430307,	11027822),
  (21430331,	11026982),
  (21430293,	11027016),
  (21433411,	11027016),
  (21429791,	11027016),
  (21431834,	11027911),
  (21430480,	11027857),
  (21430188,	11027857),
  (21430463,	11027849),
  (21430668,	11027857),
  (21431672,	11027083),
  (21432342,	11027083),
  (21429457,	11027903),
  (21430781,	11027903),
  (21430943,	11027920),
  (21431788,	11026982),
  (21431141,	11027016),
  (21430641,	11027083),
  (21430595,	11027083),
  (21430790,	11027105),
  (21431613,	11027105),
  (21432822,	11027920),
  (21432776,	11027920),
  (21432725,	11027849),
  (21433144,	11027857),
  (21432423,	11027903),
  (21430986,	11027920),
  (21432768,	11027954),
  (21430986,	11027954),
  (21430773,	11027091),
  (21429236,	11027946),
  (21430978,	11027946),
  (21431354,	11027946),
  (21429341,	11027784),
  (21430765,	11027784),
  (21429686,	11026915),
  (21433217,	11026915),
  (21432644,	11026915),
  (21430226,	11026605),
  (21428671,	11026605),
  (21429775,	11026605),
  (21429988,	11026966),
  (21428736,	11026621),
  (21430382,	11026621),
  (21432814,	11026621),
  (21428876,	11026672),
  (21432300,	11026966),
  (21428884,	11027776),
  (21433152,	11026737),
  (21432407,	11026737),
  (21428744,	11026630),
  (21429970,	11026966),
  (21429422,	11027776),
  (21428949,	11027776),
  (21431249,	11027776),
  (21429228,	11026788),
  (21429619,	11026885),
  (21429651,	11026893),
  (21431931,	11026893),
  (21429333,	11026893),
  (21433551,	11027784),
  (21430757,	11027784),
  (21433403,	11027784),
  (21430471,	11027032),
  (21428663,	11027849),
  (21430897,	11027121),
  (21431559,	11027784),
  (21430960,	11027938),
  (21430617,	11027075),
  (21430587,	11027067),
  (21432792,	11027113),
  (21430030,	11027776),
  (21432717,	11027776),
  (21428914,	11026516),
  (21429031,	11026516),
  (21428396,	11026524),
  (21428434,	11026605),
  (21432695,	11026621),
  (21429520,	11026869),
  (21432229,	11026796),
  (21433411,	11026796),
  (21428345,	11027776),
  (21431451,	11026800),
  (21428663,	11026591),
  (21431192,	11026605),
  (21432261,	11026605),
  (21432873,	11026621),
  (21430994,	11026591),
  (21431591,	11026591),
  (21433390,	11026605),
  (21432881,	11026613),
  (21429961,	11027750),
  (21429953,	11026958),
  (21432679,	11027776),
  (21430013,	11027768),
  (21432849,	11027768),
  (21428337,	11026516),
  (21433349,	11026788),
  (21429406,	11026834),
  (21430684,	11027776),
  (21428566,	11026575),
  (21431168,	11026842),
  (21432512,	11026842),
  (21430170,	11026842),
  (21428361,	11026605),
  (21429716,	11026923),
  (21428957,	11026940),
  (21429872,	11026940),
  (21429821,	11026940),
  (21429864,	11026630),
  (21432911,	11026788),
  (21430340,	11026788),
  (21429104,	11026885),
  (21430196,	11026915),
  (21433373,	11026915),
  (21431893,	11026940),
  (21428833,	11026516),
  (21429325,	11026605),
  (21429899,	11026605),
  (21429015,	11026605),
  (21428680,	11026630),
  (21428990,	11026761),
  (21432598,	11026788),
  (21428574,	11027768),
  (21430102,	11027709),
  (21430749,	11027709),
  (21431044,	11027709),
  (21432768,	11026834),
  (21432296,	11026966),
  (21433195,	11026516),
  (21428752,	11026605),
  (21428906,	11026893),
  (21431257,	11026605),
  (21432202,	11026893),
  (21432199,	11026893),
  (21432920,	11027571),
  (21431818,	11027288),
  (21431907,	11027326),
  (21432822,	11027547),
  (21432903,	11027547),
  (21433004,	11027598),
  (21433080,	11027610),
  (21431150,	11027199),
  (21429732,	11027199),
  (21431273,	11027202),
  (21431907,	11027202),
  (21430323,	11027202),
  (21431397,	11028012),
  (21431664,	11028039),
  (21431745,	11027253),
  (21430099,	11027288),
  (21432059,	11027369),
  (21428558,	11027369),
  (21432415,	11027369),
  (21432091,	11027385),
  (21432105,	11027393),
  (21432610,	11027466),
  (21429830,	11027466),
  (21432571,	11027440),
  (21428809,	11027440),
  (21432857,	11027466),
  (21429511,	11027466),
  (21429210,	11027466),
  (21429376,	11027466),
  (21431613,	11027288),
  (21431362,	11027326),
  (21432474,	11027253),
  (21431753,	11027261),
  (21429023,	11027571),
  (21430161,	11027598),
  (21433055,	11027962),
  (21431303,	11027385),
  (21431141,	11027199),
  (21429724,	11027199),
  (21432369,	11027962),
  (21433438,	11027393),
  (21431516,	11027229),
  (21432075,	11027440),
  (21433454,	11027440),
  (21430196,	11026737),
  (21431117,	11027989),
  (21432750,	11027393),
  (21433209,	11027431),
  (21428701,	11027202),
  (21431630,	11027202),
  (21433179,	11028039),
  (21431559,	11027431),
  (21432563,	11027431),
  (21432512,	11026877),
  (21431168,	11026877),
  (21431494,	11027466),
  (21430170,	11026877),
  (21428787,	11026656),
  (21429368,	11026800),
  (21432199,	11026800),
  (21433039,	11026869),
  (21432709,	11026869),
  (21432725,	11026869),
  (21430129,	11026974),
  (21428701,	11026974),
  (21431389,	11026974),
  (21428868,	11026664),
  (21431273,	11026974),
  (21430323,	11026974),
  (21433608,	11026800),
  (21428787,	11026893),
  (21432202,	11026656),
  (21431974,	11026800),
  (21431842,	11027296),
  (21429147,	11027296),
  (21432008,	11027342),
  (21431109,	11027296),
  (21431362,	11027512),
  (21432733,	11027512),
  (21431966,	11027997),
  (21431214,	11027229),
  (21433128,	11027296),
  (21430269,	11027393),
  (21431524,	11027393),
  (21431508,	11027997),
  (21429716,	11027997),
  (21431206,	11028004),
  (21430552,	11027512),
  (21429627,	11027229),
  (21431630,	11027512),
  (21431729,	11027245),
  (21432482,	11027512),
  (21429295,	11027245),
  (21432890,	11027563),
  (21431729,	11027415),
  (21432474,	11027423),
  (21431605,	11027229),
  (21431559,	11027237),
  (21433047,	11027601),
  (21430200,	11027369),
  (21432580,	11027369),
  (21433012,	11027369),
  (21432067,	11027377),
  (21429244,	11027377),
  (21432849,	11027377),
  (21430579,	11027377),
  (21431052,	11027164),
  (21431184,	11027997),
  (21432601,	11027458),
  (21428698,	11027458),
  (21432652,	11027474),
  (21432741,	11027474),
  (21430587,	11027296),
  (21431923,	11027300),
  (21432598,	11027288),
  (21430340,	11027288),
  (21431940,	11027334),
  (21431419,	11027334),
  (21432652,	11027369),
  (21432792,	11027385),
  (21430854,	11027385),
  (21430552,	11027466),
  (21431621,	11027466),
  (21430323,	11027466),
  (21429511,	11027512),
  (21429376,	11027512),
  (21429341,	11027598),
  (21433322,	11027261),
  (21431397,	11027261),
  (21429279,	11027334),
  (21428418,	11027334),
  (21432598,	11027385),
  (21429007,	11027466),
  (21428710,	11027474),
  (21433357,	11027466),
  (21430099,	11027385),
  (21431354,	11027598),
  (21432822,	11027385),
  (21430676,	11027199),
  (21432571,	11027199),
  (21429791,	11027199),
  (21433420,	11027199),
  (21432113,	11027407),
  (21429732,	11027440),
  (21431222,	11027466),
  (21430960,	11027261),
  (21428841,	11027679),
  (21431320,	11027679),
  (21433365,	11027679),
  (21432695,	11028080),
  (21433268,	11028080),
  (21429937,	11027679),
  (21433381,	11028101),
  (21429040,	21427705),
  (21429309,	11028080),
  (21433535,	11027407),
  (21433195,	11027636),
  (21433535,	11027687),
  (21428582,	21427667),
  (21433489,	21427799),
  (21431338,	21427870),
  (21433241,	21428086),
  (21432857,	11027555),
  (21432547,	21427926),
  (21433560,	21428124),
  (21431346,	11027636),
  (21431869,	21428051),
  (21429082,	11026583),
  (21432377,	11027687),
  (21433225,	11028071),
  (21429350,	21427667),
  (21430005,	11026583),
  (21431133,	11028012),
  (21429902,	11028012),
  (21432458,	11028012),
  (21431982,	11028012),
  (21432130,	11026575),
  (21431869,	11028012),
  (21433179,	21427870),
  (21433519,	21427870),
  (21431486,	21428035),
  (21430803,	21427756),
  (21429554,	21427756),
  (21431419,	21427756),
  (21430692,	21427756),
  (21429210,	11028080),
  (21430498,	11027407),
  (21432776,	21427667),
  (21431087,	21427756),
  (21431079,	21427861),
  (21432113,	21427861),
  (21429562,	21427764),
  (21432156,	21427918),
  (21432440,	21428078),
  (21429201,	11026699),
  (21433187,	11026699),
  (21433519,	11028063),
  (21432822,	11027610),
  (21431672,	11028063),
  (21429708,	11027679),
  (21433446,	11027393),
  (21431915,	11027318),
  (21428469,	11027369),
  (21433357,	11027369),
  (21431079,	11027393),
  (21430072,	11028004),
  (21431958,	11027679),
  (21430846,	21427853),
  (21432148,	21428060),
  (21433128,	21428060),
  (21431028,	21428060),
  (21430544,	11027369),
  (21432300,	11026699),
  (21428922,	11026699),
  (21433179,	11028063),
  (21430137,	11027431),
  (21431567,	11028004),
  (21433306,	11028004),
  (21431524,	11027245),
  (21432784,	21428264),
  (21431583,	21428264),
  (21432083,	11027563),
  (21430927,	11027563),
  (21428787,	11027563),
  (21429473,	11027563),
  (21433608,	11027695),
  (21431982,	21427900),
  (21432199,	11027695),
  (21432393,	21427721),
  (21429155,	21427721),
  (21429449,	21427730),
  (21431265,	11027563),
  (21428353,	21436437),
  (21430803,	21428027),
  (21431818,	21428043),
  (21429392,	21436437),
  (21428329,	11026699),
  (21428400,	21427624),
  (21431001,	11028080),
  (21433586,	11028128),
  (21432172,	11028128),
  (21432989,	11027679),
  (21433349,	11028098),
  (21429074,	21427713),
  (21432202,	11027563),
  (21430609,	21427845),
  (21433055,	21427721),
  (21429279,	21427845),
  (21431133,	21427845),
  (21431613,	21428043),
  (21428850,	11027563),
  (21429651,	11027563),
  (21430790,	21428043),
  (21433322,	11028098),
  (21431303,	11027113),
  (21432466,	21427683),
  (21428795,	21427683),
  (21429007,	21427691),
  (21433071,	21427829),
  (21431532,	21427888),
  (21432962,	21427942),
  (21428973,	21427942),
  (21432997,	21427969),
  (21429252,	21427993),
  (21433624,	21427993),
  (21429546,	21427993),
  (21432270,	11026575),
  (21430510,	11026575),
  (21429368,	11028128),
  (21431265,	11028128),
  (21431974,	11028128),
  (21430188,	21427837),
  (21433110,	21428094),
  (21433144,	21427977),
  (21433373,	21427993),
  (21428728,	21427675),
  (21428400,	21428078),
  (21430293,	21428078),
  (21429791,	21428078),
  (21431532,	21427667),
  (21432865,	21427667),
  (21432865,	21427934),
  (21433535,	11028071),
  (21432687,	11027482),
  (21429503,	21428124),
  (21428892,	11027814),
  (21430048,	11026605),
  (21431389,	11026605),
  (21429384,	11026818),
  (21430692,	11027881),
  (21429350,	21427934),
  (21431460,	21436488),
  (21432245,	21433632),
  (21432466,	21427624),
  (21432652,	11026982),
  (21432741,	21433683),
  (21433462,	11026559),
  (21432776,	11027539),
  (21431761,	11026761),
  (21431419,	11027881),
  (21432911,	11028098),
  (21429813,	21433675),
  (21432504,	21433675),
  (21429856,	11027881),
  (21428639,	11027881),
  (21431095,	11027172),
  (21433101,	11027172),
  (21429996,	11027172),
  (21432466,	21433667),
  (21429392,	11026826),
  (21430676,	11026796),
  (21429848,	11027270),
  (21433292,	21428108),
  (21432440,	21436437),
  (21433276,	24063453),
  (21431834,	24063453),
  (21433462,	24063461),
  (21428639,	21427900),
  (21431150,	11027881),
  (21429694,	11027172),
  (21432474,	21427837),
  (21429503,	21427888),
  (21429813,	11026931),
  (21430595,	11027741),
  (21429171,	11026770),
  (21430714,	11026770),
  (21431427,	11026770),
  (21431419,	11027393),
  (21430366,	11027881),
  (21430820,	24063453),
  (21428817,	11027741),
  (21429929,	11027741),
  (21432539,	24063453),
  (21428825,	21436445),
  (21428981,	11027377),
  (21432032,	11027377),
  (21430013,	11027377),
  (21432997,	11027091),
  (21431508,	11026923),
  (21430056,	21436453),
  (21432440,	21427624),
  (21431036,	21427853),
  (21429309,	11027407),
  (21432458,	21427900),
  (21431133,	21427900),
  (21430676,	11027881),
  (21431141,	11027881),
  (21431281,	11027172),
  (21431737,	11026885),
  (21432440,	24063496),
  (21428973,	11026702),
  (21431664,	11026702),
  (21432393,	21433659),
  (21431036,	21433659),
  (21430650,	21436488),
  (21430293,	11027881),
  (21431427,	11027172),
  (21429384,	11027172),
  (21428523,	11026559),
  (21428531,	11026559),
  (21430218,	11027270),
  (21428655,	11027270),
  (21431770,	11027270),
  (21431974,	11027482),
  (21429902,	11027261),
  (21433594,	21427985),
  (21429538,	21427748),
  (21430714,	21428019),
  (21431338,	21427985),
  (21433349,	11027261),
  (21433063,	11027679),
  (21431745,	11026826),
  (21430595,	11028063),
  (21429538,	11028063),
  (21430269,	21436488),
  (21430650,	21436461),
  (21428612,	11027369),
  (21431397,	21428051),
  (21428370,	11027270),
  (21431354,	11027270),
  (21432776,	11027547),
  (21433080,	11027547),
  (21432326,	11027415),
  (21430706,	11027415),
  (21432849,	11026516),
  (21430811,	11027172),
  (21432253,	11026559),
  (21433306,	11027709),
  (21432245,	11027172),
  (21429384,	11026770),
  (21431524,	11027741),
  (21432199,	11026656),
  (21428795,	21433667),
  (21429171,	11026818),
  (21431427,	11026931),
  (21431664,	21427748),
  (21433420,	11027881),
  (21428868,	11027822),
  (21429074,	11027822),
  (21432555,	21428124),
  (21428477,	11026532),
  (21429163,	11026761),
  (21429112,	11026761),
  (21431176,	21428124),
  (21428442,	11027873),
  (21430625,	11027873),
  (21430943,	24063488),
  (21430986,	24063488),
  (21431826,	24063488),
  (21428400,	21433667),
  (21430293,	21433667),
  (21432237,	11026826),
  (21429198,	11027067),
  (21429147,	11027067),
  (21432814,	21428124),
  (21429040,	21428124),
  (21428515,	11026532),
  (21430315,	11027270),
  (21431451,	11027482),
  (21431842,	21428060),
  (21431109,	21428060),
  (21428353,	11026826),
  (21429791,	24063496),
  (21430293,	24063496),
  (21431141,	24063496),
  (21433080,	21428035),
  (21431753,	11028012),
  (21433012,	11027474),
  (21432938,	21427853),
  (21431427,	21433675),
  (21432326,	21427748),
  (21428418,	11027881),
  (21430536,	11027059),
  (21432822,	11027539),
  (21431176,	11026621),
  (21431494,	11027407),
  (21432792,	21428051),
  (21433365,	11027571),
  (21429813,	21428086),
  (21430692,	11027199),
  (21431818,	11027385),
  (21431869,	11027261),
  (21430153,	11027121),
  (21433420,	11027440),
  (21433454,	21436437),
  (21431435,	11027482),
  (21432601,	21433683),
  (21433322,	21428051),
  (21432989,	21428108),
  (21430765,	11027482),
  (21429694,	11027857),
  (21432652,	21433683),
  (21433063,	11027121),
  (21433551,	11027482),
  (21431281,	21433675),
  (21428809,	11027199),
  (21431982,	11027881),
  (21432636,	24063500),
  (21429759,	11027717),
  (21429678,	11027717),
  (21429767,	11027725),
  (21428485,	11027725),
  (21433314,	11027059),
  (21433314,	11027652),
  (21431931,	11027059),
  (21431931,	11027652),
  (21429066,	11026745),
  (21429589,	11026745),
  (21431435,	11026745),
  (21430277,	11027814),
  (21429864,	11027733),
  (21431761,	11027733),
  (21432288,	11027733),
  (21430021,	21427802),
  (21430617,	11027733),
  (21431885,	11027628),
  (21433128,	11027628),
  (21433039,	11027628),
  (21428779,	11026648),
  (21429465,	11026648),
  (21430528,	11027652),
  (21432946,	11027580),
  (21430838,	24063500),
  (21429945,	11027717),
  (21429643,	11027725),
  (21428981,	11026729),
  (21433306,	11026729),
  (21430765,	11027890),
  (21432687,	11027890),
  (21431486,	21427667),
  (21431567,	11027717),
  (21428540,	11027652),
  (21430463,	11027890),
  (21429783,	11027814),
  (21432628,	11027814),
  (21429414,	11027792),
  (21430862,	11027792),
  (21430145,	11027792),
  (21432032,	11026729),
  (21431044,	11026729),
  (21431346,	11026729),
  (21433357,	11026982),
  (21431044,	11027717),
  (21431796,	11026648),
  (21429589,	11027652),
  (21430374,	21428264),
  (21430099,	21428043),
  (21431893,	11027563),
  (21429554,	11027881),
  (21433284,	21433667),
  (21433594,	21427870),
  (21431397,	21427845),
  (21430480,	11027172),
  (21431672,	21427870),
  (24034658,	21427896),
  (21432784,	11026915),
  (21432776,	21428035),
  (21428353,	21428078),
  (21432091,	11027288),
  (21430404,	21428264),
  (21432342,	21427985),
  (21429350,	21427888),
  (21433292,	21427934),
  (21432865,	21428108),
  (21430960,	11026788),
  (21430277,	11026621),
  (21428477,	24063461),
  (21433080,	11027113),
  (21431087,	11027245),
  (21431486,	21428124),
  (21433527,	11027369),
  (21428485,	11026532),
  (21433322,	11028012),
  (21431923,	11027326),
  (21428345,	24063526),
  (21430048,	11026974),
  (21431621,	11026974),
  (21431222,	21427691),
  (21430641,	21436461),
  (21433527,	11027814),
  (21430285,	11027733),
  (21430935,	11027733),
  (21432709,	11027504),
  (21429112,	11026753),
  (21432318,	11027865),
  (21431028,	21427659),
  (21429589,	21427772),
  (21433098,	11027580),
  (21433136,	11027580),
  (21430838,	24063518),
  (21432938,	21436470),
  (21428540,	11026567),
  (21431311,	11027717),
  (21430528,	24063470),
  (21428663,	24063470),
  (21432121,	11027890),
  (21428442,	11027733),
  (21431435,	21427772),
  (21433314,	21427772),
  (21430650,	11027393),
  (21433624,	11027580),
  (21430889,	21436470),
  (21430838,	21436470),
  (21429066,	11027890),
  (21431737,	11028055),
  (21429597,	11027059),
  (21429333,	11027059),
  (21432482,	11027466),
  (21429660,	11027504),
  (21429660,	11026907),
  (21429023,	11028055),
  (21428388,	11026648),
  (21430404,	11026907),
  (21431591,	11026907),
  (21432709,	11026907),
  (21428361,	11026982),
  (21429058,	11027580),
  (21430846,	11027580),
  (21433616,	11027725),
  (21430838,	11027580),
  (21430374,	11027024),
  (21431826,	11027954),
  (21432342,	21436461),
  (21433616,	21428116),
  (21430315,	21428116),
  (21432229,	11028039),
  (21428973,	11028039),
  (21432687,	11026800),
  (21432920,	21427888),
  (21433080,	21428124),
  (21432857,	11026621),
  (21430811,	11027857),
  (21433594,	11027083),
  (21429171,	11028039),
  (21432989,	11027873),
  (21432091,	11026788),
  (21432580,	24063500),
  (21430200,	24063500),
  (21432415,	11027474),
  (21431788,	11027474),
  (21433152,	11026869),
  (21429368,	11026745),
  (21432644,	21428264),
  (21429139,	11027024),
  (21431320,	11027024),
  (21431281,	11026770),
  (21428736,	11027814),
  (21432857,	11027814),
  (21430544,	11027814),
  (21431028,	11027628),
  (21431648,	11027130),
  (21430722,	11027130),
  (21431699,	11028047),
  (21428493,	11028047),
  (21430722,	11027148),
  (21431478,	11027024),
  (21432784,	11027024),
  (21431958,	11027024),
  (21430153,	11027024),
  (21430404,	11027024),
  (21429112,	11027024),
  (21431737,	11027369),
  (21432342,	11027326),
  (21431800,	11027792),
  (21428426,	21427632),
  (21429457,	11026699),
  (21430463,	11027644),
  (21433250,	11027644),
  (21430188,	11027253),
  (21428507,	11027130),
  (21429287,	11027130),
  (21433063,	11027024),
  (21433292,	11027954),
  (21429317,	11027024),
  (21429724,	11027440),
  (21430919,	11027130),
  (21429791,	11027440),
  (21433535,	21427861),
  (21428434,	21427632),
  (21430170,	11027130),
  (21430633,	11028047),
  (21433519,	21436445),
  (21430897,	11027873),
  (21430854,	11027610),
  (21428574,	11026516),
  (21430633,	21427730),
  (21429163,	11027091),
  (21430765,	11026745),
  (21431931,	11026745),
  (21429503,	11027814),
  (21430153,	21428264),
  (21430471,	24063488),
  (21429112,	11027121),
  (21428604,	11026958),
  (21431290,	11027776);