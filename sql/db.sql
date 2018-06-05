SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema tpo
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `tpo` ;

-- -----------------------------------------------------
-- Schema tpo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tpo` DEFAULT CHARACTER SET utf8 ;
USE `tpo` ;

-- -----------------------------------------------------
-- Table `tpo`.`del_predmetnika`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`drzava`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`predmet`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`studijsko_leto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tpo`.`studijsko_leto` ;

CREATE TABLE IF NOT EXISTS `tpo`.`studijsko_leto` (
  `ID_STUD_LETO` INT(11) NOT NULL AUTO_INCREMENT,
  `STUD_LETO` CHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NOT NULL,
  PRIMARY KEY (`ID_STUD_LETO`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


-- -----------------------------------------------------
-- Table `tpo`.`oseba`
-- -----------------------------------------------------
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
  `resetPwToken` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_slovenian_ci' NULL DEFAULT NULL,
  `resetPwExpiration` INT(11) NULL DEFAULT NULL,
  `resetPwUsed` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_OSEBA`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 40
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;

CREATE UNIQUE INDEX `EMAIL_UNIQUE` ON `tpo`.`oseba` (`EMAIL` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`izvedba_predmeta`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`stopnja`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`program`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`kandidat`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`letnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tpo`.`letnik` ;

CREATE TABLE IF NOT EXISTS `tpo`.`letnik` (
  `ID_LETNIK` INT(11) NOT NULL AUTO_INCREMENT,
  `LETNIK` INT(11) NOT NULL,
  PRIMARY KEY (`ID_LETNIK`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_slovenian_ci;


-- -----------------------------------------------------
-- Table `tpo`.`nacin_studija`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`posta`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`obcina`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`naslov`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`oblika_studija`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`vrsta_vpisa`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`vpis`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`student`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`predmeti_studenta`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`predmetnik`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`rok`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`prijava`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`zeton`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `tpo`.`posta_obcina`
-- -----------------------------------------------------
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
  (16,3,'02','RAČUNALNIŠTVO IN INF. - VIS',8,1,1),
  (17,3,'03','RAČUNALNIŠTVO IN INF. - VŠ',4,1,1),
  (18,4,'KP00','Račnalništvo in matematika MAG II. st.',4,1000934,1),
  (19,3,'Z2','Upravna informatika UN 1. st.',6,1000469,1),
  (20,5,'XU','Humanistika in družb.-DR. III',6,1,1);

INSERT INTO `tpo`.`studijsko_leto`(`ID_STUD_LETO`, `STUD_LETO`)VALUES
  (1,'2016/17'),
  (2,'2017/18'),
  (3,'2018/19'),
  (4,'2019/20'),
  (5,'2020/21'),
  (6,'2021/22'),
  (7,'2022/23'),
  (8,'2023/24');

INSERT INTO `tpo`.`oseba`(`ID_OSEBA`,`EMAIL`,`UPORABNISKO_IME`,`GESLO`,`VRSTA_VLOGE`,`IME`,`PRIIMEK`,`TELEFONSKA_STEVILKA`, `SIFRA_IZVAJALCA`)VALUES

  (1,'testS', 'testS', '123456', 's', '1Janez', 'Novak','040040040'             ,NULL  ),
  (2,'testP', 'testP', '123456', 'p', 'Viljan', 'Mahnič','030030030'              ,315010),
  (3,'testR', 'testR', '123456', 'r', 'Ancka', 'Novak','050505050'                ,NULL),
  (4,'testS2', 'testS2', '123456', 's', '1Janezek', 'Novakovic','123581321'       ,NULL),
  (5,'testA', 'testA', '123456', 'a', 'Admin', 'Admin','123581321'                ,NULL),
  (6,'testK', 'testK', '123456', 'k', 'kIme', 'kPriimek','123456789'              ,NULL),
  (7,'LukaS', 'LukaS', '123456', 's', '1PonavljalecLuka', 'An','04004001'         ,NULL),
  (8,'Miha', 'MihaS', '123456', 's', '1MihanNad8,5', 'Ban','040040042'            ,NULL),
  (9,'Maja', 'MajaS', '123456', 's', '1MajaPavzer', 'Cankar','040040043'          ,NULL),
  (10,'Špela', 'ŠpelaS', '123456', 's', '2ŠpelaNad8,5', 'Čopkič','040040044'      ,NULL),
  (11,'Sara', 'SaraS', '123456', 's', '2SaraPonavljalec', 'Dragovan','040040045' ,NULL ),
  (12,'Nik', 'NikS', '123456', 's', '2NikPavzer', 'Engelj','040040046'           ,NULL ),
  (13,'Marko', 'MarkoP', '123456', 'p', 'Marko', 'Poženel','040040040',315011),
  (14,'Luka', 'LukaP', '123456', 'p', 'Luka', 'Fuerst','040040040',315012),

  (15,'Jan', 'JanS', '123456', 's', '4JanAbsolvent', 'Ferlič','040040045',NULL),
  (16,'Mojca', 'MojcaS', '123456', 's', '2MojcaPogojnoNaprej', 'Golaž','040040045',NULL),
  (17,'Nino', 'NinoS', '123456', 's', '3Nino', 'Hovelja','040040045',NULL),
  (18,'Jože', 'JožeS', '123456', 's', '1JožePonavljalecNaredl7', 'Indijanec','040040045',NULL),
  (19,'Klemen', 'KlemenS', '123456', 's', '2KlemenPonavljalecNaredl4', 'Klemen','040040045',NULL),
  (20,'Tadej', 'TadejS', '123456', 's', '2TadejZamenjalProgram', 'Lindič','040040045',NULL),
  (21,'Jure', 'JureS', '123456', 's', 'Jure', 'Mohar','040040045',NULL),
  (22,'Anja', 'AnjaS', '123456', 's', 'Anja', 'Novak','040040045',NULL),
  (23,'Svit', 'SvitS', '123456', 's', 'Svit', 'Oblak','040040045',NULL),
  (24,'David', 'DavidS', '123456', 's', 'David', 'Pahor','040040045',NULL),
  (25,'Martin', 'MartinS', '123456', 's', 'Martin', 'Rešetič','040040045',NULL),
  (26,'Manca', 'MancaS', '123456', 's', 'Manca', 'Srečko','040040045',NULL),
  (27,'Tjaša', 'TjašaS', '123456', 's', 'Tjaša', 'Šenica','040040045',NULL),
  (28,'Benjamin', 'Benjamin', '123456', 's', 'Testen', 'Dragovan','040040045',NULL),
  (29,'GašperF','GašperF','123456','p','Gašper','Fijavž','040502896'                  ,315021),
  (30,'PolonaO','PolonaO','123456','p','Polona','Oblak','040502896'                   ,315022),
  (31,'VilijanM','VilijanM','123456','p','Vilijan','Mahnič','040502896'               ,315023),
  (32,'NikolajZ','NikolajZ','123456','p','Nikolaj','Zimic','040502896'                ,315024),
  (33,'IrenaD','IrenaD','123456','p','Irena','Drvenšek','040502896'                   ,315025),
  (34,'BoštijanS','BoštijanS','123456','p','Boštijan','Slivnik','040502896'           ,315026),
  (35,'BrankoŠ','BrankoŠ','123456','p','Branko','Šter','040502896'                    ,315027),
  (36,'ZoranB','ZoranB','123456','p','Zoran','Bosnič','040502896'                     ,315028),
  (37,'DejanL','DejanL','123456','p','Dejan','Lavbič','040502896'                     ,315029),
  (38,'BojanO','BojanO','123456','p','Bojan','Orel','040502896'                       ,315020),
  (39,'MajaMaja','MajaMaja','123456','s','Maja','Maja','040502806',NULL),
  (41,'test2L','test2L','123456','s','test2L','test2L','040502896',NULL),
  (42,'test3L1','test3L1','123456','s','test3L1','test3L1','040502896',NULL),
  (43,'test3L2','test3L2','123456','s','test3L2','test3L2','040502896',NULL);

# absolvent, pogojnoNaprej, PonavljalecNaredl7, zamenjalProgram
# preverjanje login:
# uporabnisko ime=testS  geslo='123456'
# VRSTA_VLOGE: admin='a', referat='r', profesor='p', student='s' in kandidat='k'


# Inserti preko import fila
INSERT INTO `tpo`.`kandidat` (`ID_KANDIDAT`, `ID_PROGRAM`, `ID_OSEBA`, `ID_STUD_LETO`, `IZKORISCEN`, `EMSO`, `VPISNA_STEVILKA`) VALUES
  (1,11,1,2,1,1706996500334,63150000),
  (2,11,4,2,1,1706996500334,63150001),

  (3,11,6,1,0,1706996500334,63150100),
  (4,11,41,1,1,1706996500334,63150101),
  (5,11,42,1,1,1706996500334,63150102),
  (6,11,43,1,1,1706996500334,63150102);

INSERT INTO `tpo`.`PREDMET`
(`ID_PREDMET`, `SIFRA_PREDMET`, `IME_PREDMET`, `AKTIVNOST`)
VALUES
  (6, 63702,'Programiranje 1', 1),
  (9, 63202,'Osnove Matematične Analize', 1),
  (10, 63203,'Diskretne Strukture', 1),
  (11, 63204,'Osnove Digitalnih Vezji', 1),
  (12, 63205,'Fizika', 1),
  (13, 63706,'Programiranje 2', 1),
  (14, 63207,'Linearna Algebra', 1),
  (15, 63212,'Arhitekrura Računalniških Sistemov', 1),
  (16, 63708,'Računalniške Komunikacije', 1),
  (17, 63215,'Osnove Informacijskih Sistemov', 1),


  (18, 63711,'Algoritmi in Podatkovne Strukture 1', 1),
  (19, 63723,'Algoritmi in Podatkovne Strukture 2', 1),
  (20, 63208,'Osnove Podatkovnih Baz', 1),
  (21, 63213,'Verjetnost in Statistika', 1),
  (22, 63283,'Izračunljivost in Računska Zahtevnost', 1),
  (23, 63216,'Teorija Informacij in Sistemov', 1),
  (24, 63217,'Opreacijski Sistemi', 1),
  (25, 63218,'Organizacija Računalniških Sistemov', 1),

  (7, 63220,'Principi Programskih Jezikov', 1),
  (54, 63219,'Matematično modeliranje', 1),
  (27, 63221,'Računalniške Tehnologije', 1),


  (1, 63256,'Tehnologija Programske Opreme', 1),
  (2, 63254,'Postopki Razvoja Programke Opreme', 1),
  (3, 63255,'Spletno Progrmiranje', 1),

  (4, 63249,'Elektronsko Poslovanje', 1),
  (5, 63250,'Organizacija in Management', 1),
  (53, 63251,'Uvod v odkrivanje znanj iz podatkov', 1),

  (29, 63226,'Tehnologija Upravljanja Podatkov', 1),
  (30, 63725,'Razvoj Informacijskih Sistemov', 1),
  (31, 63253,'Planiranje in Upravljanje Informatike', 1),

  (32, 63258,'Komunikacijski Protokoli', 1),
  (33, 63259,'Brezžična in Mobilna Omrežja', 1),
  (34, 63257,'Modeliranje Računalniških Omrežji', 1),

  (35, 63262,'Zanesljivost in zmogljivost računalniških sistemov', 1),
  (36, 63260,'Digitalno načrtovanje', 1),
  (37, 63261,'Porazdeljeni sistemi', 1),

  (39, 63264,'Sistemska programska oprema', 1),
  (40, 63263,'Računska zahtevnost in hevristično programiranje', 1),
  (38, 63265,'Prevajalniki', 1),

  (41, 63268,'Razvoj Inteligentnih Sistemov', 1),
  (42, 63266,'Inteligentni Sistemi', 1),
  (43, 63267,'Umetno Zaznavanje', 1),

  (44, 63271,'Osnove Oblikovanja', 1),
  (45, 63270,'Multimedijski sistemi', 1),
  (46, 63269,'Računalniška grafika in tehnologija iger', 1),

  (47, 63214,'Osnove Umetne Inteligence', 1),
  (48, 63248,'Ekonomika in Podjetništvo ', 1),
  (49, 63281,'Diplomski seminar', 1),


  (50, 63222,'Angleški jezik nivo A', 1),
  (51, 63745,'Angleški jezik nivo B', 1),
  (52, 63224,'Angleški jezik nivo C', 1);
INSERT INTO `tpo`.`PREDMET`
(`ID_PREDMET`, `SIFRA_PREDMET`, `IME_PREDMET`, `ST_KREDITNIH_TOCK`, `AKTIVNOST`)
VALUES
  (8, 63240,'Sport', 3, 1),
  (26, 63241,'Računalništvo v praksi I', 3, 1),
  (28, 63242,'Računalništvo v praksi II', 3, 1),
  (55, 63284,'Tehnične veščine: Scala', 3, 1),
  (56, 63285,'Tehnične veščine: Računalniški vid', 3, 1),
  (57, 63767,'Tehnične veščine: OpenStack', 3, 1);

INSERT INTO `tpo`.`del_predmetnika`
(`ID_DELPREDMETNIKA`, `NAZIV_DELAPREDMETNIKA`, `SKUPNOSTEVILOKT`, `TIP`, `AKTIVNOST`)
VALUES
  (3, "Obvezni predmet", 6, 'o', 1),
  (4, "Strokovni izbirni predmet", 6, 'st', 1),
  (5, "Splosno izbirni predmet", 6, 'sp', 1),
  (13, "Splosno izbirni predmet", 3, 'sp', 1),

  (1, "Razvoj programske opreme", 18, 'm', 1),
  (2, "Informacijski sistemi", 18, 'm', 1),
  (6, "Obvladovanje informatike", 18, 'm', 1),
  (7, "duplikat", 18, 'm', 0),
  (8, "Računalniška omrežja", 18, 'm', 1),
  (9, "Računalniški sistemi", 18, 'm', 1),
  (10, "Algoritmi in sistemski programi", 18, 'm', 1),
  (11, "Umetna inteligenca", 18, 'm', 1),
  (12, "Medijske tehnologije", 18, 'm', 1);

INSERT INTO `tpo`.`predmetnik`
(`ID_PREDMET`, `ID_DELPREDMETNIKA`, `ID_LETNIK`, `ID_STUD_LETO`, `ID_PROGRAM`, `AKTIVNOST`)
VALUES
  #ID_STUD_LETO = 1
  (1 , 1, 3, 1, 11, 1),
  (2 , 1, 3, 1, 11, 1),
  (3 , 1, 3, 1, 11, 1),
  (4 , 2, 3, 1, 11, 1),
  (5 , 2, 3, 1, 11, 1),
  (6 , 3, 1, 1, 11, 1),
  (7 , 4, 2, 1, 11, 1),

  (9 , 3, 1, 1, 11, 1),
  (10, 3, 1, 1, 11, 1),
  (11, 3, 1, 1, 11, 1),
  (12, 3, 1, 1, 11, 1),
  (13, 3, 1, 1, 11, 1),
  (14, 3, 1, 1, 11, 1),
  (15, 3, 1, 1, 11, 1),
  (16, 3, 1, 1, 11, 1),
  (17, 3, 1, 1, 11, 1),
  (18, 3, 2, 1, 11, 1),
  (19, 3, 2, 1, 11, 1),
  (20, 3, 2, 1, 11, 1),
  (21, 3, 2, 1, 11, 1),
  (22, 3, 2, 1, 11, 1),
  (23, 3, 2, 1, 11, 1),
  (24, 3, 2, 1, 11, 1),
  (25, 3, 2, 1, 11, 1),
  
  (27, 4, 2, 1, 11, 1),

  (29, 6, 3, 1, 11, 1),
  (30, 6, 3, 1, 11, 1),
  (31, 6, 3, 1, 11, 1),
  (32, 8, 3, 1, 11, 1),
  (33, 8, 3, 1, 11, 1),
  (34, 8, 3, 1, 11, 1),
  (35, 9, 3, 1, 11, 1),
  (36, 9, 3, 1, 11, 1),
  (37, 9, 3, 1, 11, 1),
  (38, 10,3, 1, 11, 1),
  (39, 10,3, 1, 11, 1),
  (40, 10,3, 1, 11, 1),
  (41, 11,3, 1, 11, 1),
  (42, 11,3, 1, 11, 1),
  (43, 11,3, 1, 11, 1),
  (44, 12,3, 1, 11, 1),
  (45, 12,3, 1, 11, 1),
  (46, 12,3, 1, 11, 1),
  (47, 3, 3, 1, 11, 1),
  (48, 3, 3, 1, 11, 1),
  (49, 3, 3, 1, 11, 1),

  (53, 2, 3, 1, 11, 1),
  (54, 4, 2, 1, 11, 1),

  (50, 5, 2, 1, 11, 1),
  (50, 5, 3, 1, 11, 1),
  (51, 5, 2, 1, 11, 1),
  (51, 5, 3, 1, 11, 1),
  (52, 5, 2, 1, 11, 1),
  (52, 5, 3, 1, 11, 1),
  (8 ,13, 2, 1, 11, 1),
  (8 ,13, 3, 1, 11, 1),
  (26,13, 2, 1, 11, 1),
  (26,13, 3, 1, 11, 1),
  (28,13, 2, 1, 11, 1),
  (28,13, 3, 1, 11, 1),
  (55,13, 2, 1, 11, 1),
  (55,13, 3, 1, 11, 1),
  (56,13, 2, 1, 11, 1),
  (56,13, 3, 1, 11, 1),
  (57,13, 2, 1, 11, 1),
  (57,13, 3, 1, 11, 1),

#ID_STUD_LETO = 2
  (1 , 1, 3, 2, 11, 1),
  (2 , 1, 3, 2, 11, 1),
  (3 , 1, 3, 2, 11, 1),
  (4 , 2, 3, 2, 11, 1),
  (5 , 2, 3, 2, 11, 1),
  (6 , 3, 1, 2, 11, 1),
  (7 , 4, 2, 2, 11, 1),

  (9 , 3, 1, 2, 11, 1),
  (10, 3, 1, 2, 11, 1),
  (11, 3, 1, 2, 11, 1),
  (12, 3, 1, 2, 11, 1),
  (13, 3, 1, 2, 11, 1),
  (14, 3, 1, 2, 11, 1),
  (15, 3, 1, 2, 11, 1),
  (16, 3, 1, 2, 11, 1),
  (17, 3, 1, 2, 11, 1),
  (18, 3, 2, 2, 11, 1),
  (19, 3, 2, 2, 11, 1),
  (20, 3, 2, 2, 11, 1),
  (21, 3, 2, 2, 11, 1),
  (22, 3, 2, 2, 11, 1),
  (23, 3, 2, 2, 11, 1),
  (24, 3, 2, 2, 11, 1),
  (25, 3, 2, 2, 11, 1),
  
  (27, 4, 2, 2, 11, 1),

  (29, 6, 3, 2, 11, 1),
  (30, 6, 3, 2, 11, 1),
  (31, 6, 3, 2, 11, 1),
  (32, 8, 3, 2, 11, 1),
  (33, 8, 3, 2, 11, 1),
  (34, 8, 3, 2, 11, 1),
  (35, 9, 3, 2, 11, 1),
  (36, 9, 3, 2, 11, 1),
  (37, 9, 3, 2, 11, 1),
  (38, 10,3, 2, 11, 1),
  (39, 10,3, 2, 11, 1),
  (40, 10,3, 2, 11, 1),
  (41, 11,3, 2, 11, 1),
  (42, 11,3, 2, 11, 1),
  (43, 11,3, 2, 11, 1),
  (44, 12,3, 2, 11, 1),
  (45, 12,3, 2, 11, 1),
  (46, 12,3, 2, 11, 1),
  (47, 3, 3, 2, 11, 1),
  (48, 3, 3, 2, 11, 1),
  (49, 3, 3, 2, 11, 1),

  (53, 2, 3, 2, 11, 1),
  (54, 4, 2, 2, 11, 1),

  (50, 5, 2, 2, 11, 1),
  (50, 5, 3, 2, 11, 1),
  (51, 5, 2, 2, 11, 1),
  (51, 5, 3, 2, 11, 1),
  (52, 5, 2, 2, 11, 1),
  (52, 5, 3, 2, 11, 1),
  (8 ,13, 2, 2, 11, 1),
  (8 ,13, 3, 2, 11, 1),
  (26,13, 2, 2, 11, 1),
  (26,13, 3, 2, 11, 1),
  (28,13, 2, 2, 11, 1),
  (28,13, 3, 2, 11, 1),
  (55,13, 2, 2, 11, 1),
  (55,13, 3, 2, 11, 1),
  (56,13, 2, 2, 11, 1),
  (56,13, 3, 2, 11, 1),
  (57,13, 2, 2, 11, 1),
  (57,13, 3, 2, 11, 1),

  #ID_STUD_LETO = 3
  (1 , 1, 3, 3, 11, 1),
  (2 , 1, 3, 3, 11, 1),
  (3 , 1, 3, 3, 11, 1),
  (4 , 2, 3, 3, 11, 1),
  (5 , 2, 3, 3, 11, 1),
  (6 , 3, 1, 3, 11, 1),
  (7 , 4, 2, 3, 11, 1),

  (9 , 3, 1, 3, 11, 1),
  (10, 3, 1, 3, 11, 1),
  (11, 3, 1, 3, 11, 1),
  (12, 3, 1, 3, 11, 1),
  (13, 3, 1, 3, 11, 1),
  (14, 3, 1, 3, 11, 1),
  (15, 3, 1, 3, 11, 1),
  (16, 3, 1, 3, 11, 1),
  (17, 3, 1, 3, 11, 1),
  (18, 3, 2, 3, 11, 1),
  (19, 3, 2, 3, 11, 1),
  (20, 3, 2, 3, 11, 1),
  (21, 3, 2, 3, 11, 1),
  (22, 3, 2, 3, 11, 1),
  (23, 3, 2, 3, 11, 1),
  (24, 3, 2, 3, 11, 1),
  (25, 3, 2, 3, 11, 1),
  
  (27, 4, 2, 3, 11, 1),

  (29, 6, 3, 3, 11, 1),
  (30, 6, 3, 3, 11, 1),
  (31, 6, 3, 3, 11, 1),
  (32, 8, 3, 3, 11, 1),
  (33, 8, 3, 3, 11, 1),
  (34, 8, 3, 3, 11, 1),
  (35, 9, 3, 3, 11, 1),
  (36, 9, 3, 3, 11, 1),
  (37, 9, 3, 3, 11, 1),
  (38, 10,3, 3, 11, 1),
  (39, 10,3, 3, 11, 1),
  (40, 10,3, 3, 11, 1),
  (41, 11,3, 3, 11, 1),
  (42, 11,3, 3, 11, 1),
  (43, 11,3, 3, 11, 1),
  (44, 12,3, 3, 11, 1),
  (45, 12,3, 3, 11, 1),
  (46, 12,3, 3, 11, 1),
  (47, 3, 3, 3, 11, 1),
  (48, 3, 3, 3, 11, 1),
  (49, 3, 3, 3, 11, 1),

  (53, 2, 3, 3, 11, 1),
  (54, 4, 2, 3, 11, 1),

  (50, 5, 2, 3, 11, 1),
  (50, 5, 3, 3, 11, 1),
  (51, 5, 2, 3, 11, 1),
  (51, 5, 3, 3, 11, 1),
  (52, 5, 2, 3, 11, 1),
  (52, 5, 3, 3, 11, 1),
  (8 ,13, 2, 3, 11, 1),
  (8 ,13, 3, 3, 11, 1),
  (26,13, 2, 3, 11, 1),
  (26,13, 3, 3, 11, 1),
  (28,13, 2, 3, 11, 1),
  (28,13, 3, 3, 11, 1),
  (55,13, 2, 3, 11, 1),
  (55,13, 3, 3, 11, 1),
  (56,13, 2, 3, 11, 1),
  (56,13, 3, 3, 11, 1),
  (57,13, 2, 3, 11, 1),
  (57,13, 3, 3, 11, 1),

  #ID_STUD_LETO = 4
  (1 , 1, 3, 4, 11, 1),
  (2 , 1, 3, 4, 11, 1),
  (3 , 1, 3, 4, 11, 1),
  (4 , 2, 3, 4, 11, 1),
  (5 , 2, 3, 4, 11, 1),
  (6 , 3, 1, 4, 11, 1),
  (7 , 4, 2, 4, 11, 1),

  (9 , 3, 1, 4, 11, 1),
  (10, 3, 1, 4, 11, 1),
  (11, 3, 1, 4, 11, 1),
  (12, 3, 1, 4, 11, 1),
  (13, 3, 1, 4, 11, 1),
  (14, 3, 1, 4, 11, 1),
  (15, 3, 1, 4, 11, 1),
  (16, 3, 1, 4, 11, 1),
  (17, 3, 1, 4, 11, 1),
  (18, 3, 2, 4, 11, 1),
  (19, 3, 2, 4, 11, 1),
  (20, 3, 2, 4, 11, 1),
  (21, 3, 2, 4, 11, 1),
  (22, 3, 2, 4, 11, 1),
  (23, 3, 2, 4, 11, 1),
  (24, 3, 2, 4, 11, 1),
  (25, 3, 2, 4, 11, 1),
  
  (27, 4, 2, 4, 11, 1),

  (29, 6, 3, 4, 11, 1),
  (30, 6, 3, 4, 11, 1),
  (31, 6, 3, 4, 11, 1),
  (32, 8, 3, 4, 11, 1),
  (33, 8, 3, 4, 11, 1),
  (34, 8, 3, 4, 11, 1),
  (35, 9, 3, 4, 11, 1),
  (36, 9, 3, 4, 11, 1),
  (37, 9, 3, 4, 11, 1),
  (38, 10,3, 4, 11, 1),
  (39, 10,3, 4, 11, 1),
  (40, 10,3, 4, 11, 1),
  (41, 11,3, 4, 11, 1),
  (42, 11,3, 4, 11, 1),
  (43, 11,3, 4, 11, 1),
  (44, 12,3, 4, 11, 1),
  (45, 12,3, 4, 11, 1),
  (46, 12,3, 4, 11, 1),
  (47, 3, 3, 4, 11, 1),
  (48, 3, 3, 4, 11, 1),
  (49, 3, 3, 4, 11, 1),

  (53, 2, 3, 4, 11, 1),
  (54, 4, 2, 4, 11, 1),

  (50, 5, 2, 4, 11, 1),
  (50, 5, 3, 4, 11, 1),
  (51, 5, 2, 4, 11, 1),
  (51, 5, 3, 4, 11, 1),
  (52, 5, 2, 4, 11, 1),
  (52, 5, 3, 4, 11, 1),
  (8 ,13, 2, 4, 11, 1),
  (8 ,13, 3, 4, 11, 1),
  (26,13, 2, 4, 11, 1),
  (26,13, 3, 4, 11, 1),
  (28,13, 2, 4, 11, 1),
  (28,13, 3, 4, 11, 1),
  (55,13, 2, 4, 11, 1),
  (55,13, 3, 4, 11, 1),
  (56,13, 2, 4, 11, 1),
  (56,13, 3, 4, 11, 1),
  (57,13, 2, 4, 11, 1),
  (57,13, 3, 4, 11, 1),

  #ID_STUD_LE4O = 5
  (1 , 1, 3, 5, 11, 1),
  (2 , 1, 3, 5, 11, 1),
  (3 , 1, 3, 5, 11, 1),
  (4 , 2, 3, 5, 11, 1),
  (5 , 2, 3, 5, 11, 1),
  (6 , 3, 1, 5, 11, 1),
  (7 , 4, 2, 5, 11, 1),

  (9 , 3, 1, 5, 11, 1),
  (10, 3, 1, 5, 11, 1),
  (11, 3, 1, 5, 11, 1),
  (12, 3, 1, 5, 11, 1),
  (13, 3, 1, 5, 11, 1),
  (14, 3, 1, 5, 11, 1),
  (15, 3, 1, 5, 11, 1),
  (16, 3, 1, 5, 11, 1),
  (17, 3, 1, 5, 11, 1),
  (18, 3, 2, 5, 11, 1),
  (19, 3, 2, 5, 11, 1),
  (20, 3, 2, 5, 11, 1),
  (21, 3, 2, 5, 11, 1),
  (22, 3, 2, 5, 11, 1),
  (23, 3, 2, 5, 11, 1),
  (24, 3, 2, 5, 11, 1),
  (25, 3, 2, 5, 11, 1),
  
  (27, 4, 2, 5, 11, 1),

  (29, 6, 3, 5, 11, 1),
  (30, 6, 3, 5, 11, 1),
  (31, 6, 3, 5, 11, 1),
  (32, 8, 3, 5, 11, 1),
  (33, 8, 3, 5, 11, 1),
  (34, 8, 3, 5, 11, 1),
  (35, 9, 3, 5, 11, 1),
  (36, 9, 3, 5, 11, 1),
  (37, 9, 3, 5, 11, 1),
  (38, 10,3, 5, 11, 1),
  (39, 10,3, 5, 11, 1),
  (40, 10,3, 5, 11, 1),
  (41, 11,3, 5, 11, 1),
  (42, 11,3, 5, 11, 1),
  (43, 11,3, 5, 11, 1),
  (44, 12,3, 5, 11, 1),
  (45, 12,3, 5, 11, 1),
  (46, 12,3, 5, 11, 1),
  (47, 3, 3, 5, 11, 1),
  (48, 3, 3, 5, 11, 1),
  (49, 3, 3, 5, 11, 1),

  (53, 2, 3, 5, 11, 1),
  (54, 4, 2, 5, 11, 1),

  (50, 5, 2, 5, 11, 1),
  (50, 5, 3, 5, 11, 1),
  (51, 5, 2, 5, 11, 1),
  (51, 5, 3, 5, 11, 1),
  (52, 5, 2, 5, 11, 1),
  (52, 5, 3, 5, 11, 1),
  (8 ,13, 2, 5, 11, 1),
  (8 ,13, 3, 5, 11, 1),
  (26,13, 2, 5, 11, 1),
  (26,13, 3, 5, 11, 1),
  (28,13, 2, 5, 11, 1),
  (28,13, 3, 5, 11, 1),
  (55,13, 2, 5, 11, 1),
  (55,13, 3, 5, 11, 1),
  (56,13, 2, 5, 11, 1),
  (56,13, 3, 5, 11, 1),
  (57,13, 2, 5, 11, 1),
  (57,13, 3, 5, 11, 1),

  #ID_STUD_LETO = 6
  (1 , 1, 3, 6, 11, 1),
  (2 , 1, 3, 6, 11, 1),
  (3 , 1, 3, 6, 11, 1),
  (4 , 2, 3, 6, 11, 1),
  (5 , 2, 3, 6, 11, 1),
  (6 , 3, 1, 6, 11, 1),
  (7 , 4, 2, 6, 11, 1),

  (9 , 3, 1, 6, 11, 1),
  (10, 3, 1, 6, 11, 1),
  (11, 3, 1, 6, 11, 1),
  (12, 3, 1, 6, 11, 1),
  (13, 3, 1, 6, 11, 1),
  (14, 3, 1, 6, 11, 1),
  (15, 3, 1, 6, 11, 1),
  (16, 3, 1, 6, 11, 1),
  (17, 3, 1, 6, 11, 1),
  (18, 3, 2, 6, 11, 1),
  (19, 3, 2, 6, 11, 1),
  (20, 3, 2, 6, 11, 1),
  (21, 3, 2, 6, 11, 1),
  (22, 3, 2, 6, 11, 1),
  (23, 3, 2, 6, 11, 1),
  (24, 3, 2, 6, 11, 1),
  (25, 3, 2, 6, 11, 1),
  
  (27, 4, 2, 6, 11, 1),

  (29, 6, 3, 6, 11, 1),
  (30, 6, 3, 6, 11, 1),
  (31, 6, 3, 6, 11, 1),
  (32, 8, 3, 6, 11, 1),
  (33, 8, 3, 6, 11, 1),
  (34, 8, 3, 6, 11, 1),
  (35, 9, 3, 6, 11, 1),
  (36, 9, 3, 6, 11, 1),
  (37, 9, 3, 6, 11, 1),
  (38, 10,3, 6, 11, 1),
  (39, 10,3, 6, 11, 1),
  (40, 10,3, 6, 11, 1),
  (41, 11,3, 6, 11, 1),
  (42, 11,3, 6, 11, 1),
  (43, 11,3, 6, 11, 1),
  (44, 12,3, 6, 11, 1),
  (45, 12,3, 6, 11, 1),
  (46, 12,3, 6, 11, 1),
  (47, 3, 3, 6, 11, 1),
  (48, 3, 3, 6, 11, 1),
  (49, 3, 3, 6, 11, 1),

  (53, 2, 3, 6, 11, 1),
  (54, 4, 2, 6, 11, 1),

  (50, 5, 2, 6, 11, 1),
  (50, 5, 3, 6, 11, 1),
  (51, 5, 2, 6, 11, 1),
  (51, 5, 3, 6, 11, 1),
  (52, 5, 2, 6, 11, 1),
  (52, 5, 3, 6, 11, 1),
  (8 ,13, 2, 6, 11, 1),
  (8 ,13, 3, 6, 11, 1),
  (26,13, 2, 6, 11, 1),
  (26,13, 3, 6, 11, 1),
  (28,13, 2, 6, 11, 1),
  (28,13, 3, 6, 11, 1),
  (55,13, 2, 6, 11, 1),
  (55,13, 3, 6, 11, 1),
  (56,13, 2, 6, 11, 1),
  (56,13, 3, 6, 11, 1),
  (57,13, 2, 6, 11, 1),
  (57,13, 3, 6, 11, 1);

INSERT INTO `tpo`.`IZVEDBA_PREDMETA`
(`ID_IZVEDBA`, `ID_STUD_LETO`, `ID_OSEBA1`, `ID_OSEBA2`, `ID_OSEBA3`, `ID_PREDMET`)
VALUES
  (1, 1, 2,13,  14,   1),
  (2, 1, 2,NULL,NULL, 6),
  (3, 1,13,14,  NULL, 4),
  (5, 2, 2,13,  14,   1),
  (6, 2, 2,NULL,NULL, 6),
  (7, 2,13,14,  NULL, 4),
  (9, 3, 2,13,  14,   1),
  (10,3, 2,NULL,NULL, 6),
  (11,3,13,14,  NULL, 4),
  (244,4, 2,13,  14,   1),
  (245,4, 2,NULL,NULL, 6),
  (246,4,13,14,  NULL, 4),
  (247,5, 2,13,  14,   1),
  (248,5, 2,NULL,NULL, 6),
  (249,5,13,14,  NULL, 4),
  (250,6, 2,13,  14,   1),
  (251,6, 2,NULL,NULL, 6),
  (252,6,13,14,  NULL, 4),

  #ID_STUD_LETO = 1
  (13,1,29,NULL,NULL,10),
  (15,1,32,NULL,NULL,11),
  (16,1,34,NULL,NULL,13),
  (17,1,35,NULL,NULL,15),
  (18,1,36,NULL,NULL,16),
  (19,1,37,NULL,NULL,17),
  (20,1,38,NULL,NULL,14),
  (21,1,2, 30,  NULL, 9),
  (22,1,14,NULL,NULL,12),
  (23,1,36,NULL,NULL,18),
  (24,1,37,NULL,NULL,19),

  (27,1,14,NULL,NULL,12),
  (28,1,32,NULL,NULL,20),
  (29,1,34,NULL,NULL,21),
  (30,1,35,NULL,NULL,22),
  (31,1,36,NULL,NULL,23),
  (32,1,37,NULL,NULL,24),
  (33,1,38,NULL,NULL,25),
  (34,1,29,NULL,NULL,26),
  (35,1,30,NULL,NULL,27),
  (36,1,31,NULL,NULL,29),
  (37,1,32,NULL,NULL,7),
  (38,1,33,NULL,NULL,8),
  (39,1,29,NULL,NULL,2),
  (40,1,30,NULL,NULL,3),
  (41,1,31,NULL,NULL,5),
  (42,1,32,NULL,NULL,30),
  (43,1,33,NULL,NULL,31),
  (44,1,32,NULL,NULL,32),
  (45,1,31,NULL,NULL,33),
  (46,1,30,NULL,NULL,54),
  (47,1,29,NULL,NULL,53),
  (48,1,38,NULL,NULL,52),
  (49,1,37,NULL,NULL,51),
  (50,1,36,NULL,NULL,50),
  (51,1,35,NULL,NULL,55),
  (52,1,34,NULL,NULL,56),
  (238,1,34,NULL,NULL,57),


  (53,2,29,NULL,NULL,10),
  (54,2,32,NULL,NULL,11),
  (55,2,34,NULL,NULL,13),
  (56,2,35,NULL,NULL,15),
  (57,2,36,NULL,NULL,16),
  (58,2,37,NULL,NULL,17),
  (59,2,38,NULL,NULL,14),
  (60,2,2, 30,  NULL, 9),
  (61,2,14,NULL,NULL,12),
  (62,2,36,NULL,NULL,18),
  (63,2,37,NULL,NULL,19),

  (64,2,14,NULL,NULL,12),
  (65,2,32,NULL,NULL,20),
  (66,2,34,NULL,NULL,21),
  (67,2,35,NULL,NULL,22),
  (68,2,36,NULL,NULL,23),
  (69,2,37,NULL,NULL,24),
  (70,2,38,NULL,NULL,25),
  (71,2,29,NULL,NULL,26),
  (72,2,30,NULL,NULL,27),
  (73,2,31,NULL,NULL,29),
  (74,2,32,NULL,NULL,7),
  (75,2,33,NULL,NULL,8),
  (76,2,29,NULL,NULL,2),
  (77,2,30,NULL,NULL,3),
  (78,2,31,NULL,NULL,5),
  (79,2,32,NULL,NULL,30),
  (80,2,33,NULL,NULL,31),
  (81,2,32,NULL,NULL,32),
  (82,2,31,NULL,NULL,33),
  (83,2,30,NULL,NULL,54),
  (84,2,29,NULL,NULL,53),
  (85,2,38,NULL,NULL,52),
  (86,2,37,NULL,NULL,51),
  (87,2,36,NULL,NULL,50),
  (88,2,35,NULL,NULL,55),
  (89,2,34,NULL,NULL,56),
  (239,2,34,NULL,NULL,57),


  (90,3,29,NULL,NULL,10),
  (91,3,32,NULL,NULL,11),
  (92,3,34,NULL,NULL,13),
  (93,3,35,NULL,NULL,15),
  (94,3,36,NULL,NULL,16),
  (95,3,37,NULL,NULL,17),
  (96,3,38,NULL,NULL,14),
  (97,3,2, 30,  NULL, 9),
  (98,3,14,NULL,NULL,12),
  (99,3,36,NULL,NULL,18),
  (100,3,37,NULL,NULL,19),

  (101,3,14,NULL,NULL,12),
  (102,3,32,NULL,NULL,20),
  (103,3,34,NULL,NULL,21),
  (104,3,35,NULL,NULL,22),
  (105,3,36,NULL,NULL,23),
  (106,3,37,NULL,NULL,24),
  (107,3,38,NULL,NULL,25),
  (108,3,29,NULL,NULL,26),
  (109,3,30,NULL,NULL,27),
  (110,3,31,NULL,NULL,29),
  (111,3,32,NULL,NULL,7),
  (112,3,33,NULL,NULL,8),
  (113,3,29,NULL,NULL,2),
  (114,3,30,NULL,NULL,3),
  (115,3,31,NULL,NULL,5),
  (116,3,32,NULL,NULL,30),
  (117,3,33,NULL,NULL,31),
  (118,3,32,NULL,NULL,32),
  (119,3,31,NULL,NULL,33),
  (120,3,30,NULL,NULL,54),
  (121,3,29,NULL,NULL,53),
  (122,3,38,NULL,NULL,52),
  (123,3,37,NULL,NULL,51),
  (124,3,36,NULL,NULL,50),
  (125,3,35,NULL,NULL,55),
  (126,3,34,NULL,NULL,56),
  (240,3,34,NULL,NULL,57),


  (127,4,29,NULL,NULL,10),
  (128,4,32,NULL,NULL,11),
  (129,4,34,NULL,NULL,13),
  (130,4,35,NULL,NULL,15),
  (131,4,36,NULL,NULL,16),
  (132,4,37,NULL,NULL,17),
  (133,4,38,NULL,NULL,14),
  (134,4,2, 30,  NULL, 9),
  (135,4,14,NULL,NULL,12),
  (136,4,36,NULL,NULL,18),
  (137,4,37,NULL,NULL,19),

  (138,4,14,NULL,NULL,12),
  (139,4,32,NULL,NULL,20),
  (140,4,34,NULL,NULL,21),
  (141,4,35,NULL,NULL,22),
  (142,4,36,NULL,NULL,23),
  (143,4,37,NULL,NULL,24),
  (144,4,38,NULL,NULL,25),
  (145,4,29,NULL,NULL,26),
  (146,4,30,NULL,NULL,27),
  (147,4,31,NULL,NULL,29),
  (148,4,32,NULL,NULL,7),
  (149,4,33,NULL,NULL,8),
  (150,4,29,NULL,NULL,2),
  (151,4,30,NULL,NULL,3),
  (152,4,31,NULL,NULL,5),
  (153,4,32,NULL,NULL,30),
  (154,4,33,NULL,NULL,31),
  (155,4,32,NULL,NULL,32),
  (156,4,31,NULL,NULL,33),
  (157,4,30,NULL,NULL,54),
  (158,4,29,NULL,NULL,53),
  (159,4,38,NULL,NULL,52),
  (160,4,37,NULL,NULL,51),
  (161,4,36,NULL,NULL,50),
  (162,4,35,NULL,NULL,55),
  (163,4,34,NULL,NULL,56),
  (241,4,34,NULL,NULL,57),


  (164,5,29,NULL,NULL,10),
  (165,5,32,NULL,NULL,11),
  (166,5,34,NULL,NULL,13),
  (167,5,35,NULL,NULL,15),
  (168,5,36,NULL,NULL,16),
  (169,5,37,NULL,NULL,17),
  (170,5,38,NULL,NULL,14),
  (171,5,2, 30,  NULL, 9),
  (172,5,14,NULL,NULL,12),
  (173,5,36,NULL,NULL,18),
  (174,5,37,NULL,NULL,19),

  (175,5,14,NULL,NULL,12),
  (176,5,32,NULL,NULL,20),
  (177,5,34,NULL,NULL,21),
  (178,5,35,NULL,NULL,22),
  (179,5,36,NULL,NULL,23),
  (180,5,37,NULL,NULL,24),
  (181,5,38,NULL,NULL,25),
  (182,5,29,NULL,NULL,26),
  (183,5,30,NULL,NULL,27),
  (184,5,31,NULL,NULL,29),
  (185,5,32,NULL,NULL,7),
  (186,5,33,NULL,NULL,8),
  (187,5,29,NULL,NULL,2),
  (188,5,30,NULL,NULL,3),
  (189,5,31,NULL,NULL,5),
  (190,5,32,NULL,NULL,30),
  (191,5,33,NULL,NULL,31),
  (192,5,32,NULL,NULL,32),
  (193,5,31,NULL,NULL,33),
  (194,5,30,NULL,NULL,54),
  (195,5,29,NULL,NULL,53),
  (196,5,38,NULL,NULL,52),
  (197,5,37,NULL,NULL,51),
  (198,5,36,NULL,NULL,50),
  (199,5,35,NULL,NULL,55),
  (200,5,34,NULL,NULL,56),
  (242,5,34,NULL,NULL,57),


  (201,6,29,NULL,NULL,10),
  (202,6,32,NULL,NULL,11),
  (203,6,34,NULL,NULL,13),
  (204,6,35,NULL,NULL,15),
  (205,6,36,NULL,NULL,16),
  (206,6,37,NULL,NULL,17),
  (207,6,38,NULL,NULL,14),
  (208,6,2, 30,  NULL, 9),
  (209,6,14,NULL,NULL,12),
  (210,6,36,NULL,NULL,18),
  (211,6,37,NULL,NULL,19),

  (212,6,14,NULL,NULL,12),
  (213,6,32,NULL,NULL,20),
  (214,6,34,NULL,NULL,21),
  (215,6,35,NULL,NULL,22),
  (216,6,36,NULL,NULL,23),
  (217,6,37,NULL,NULL,24),
  (218,6,38,NULL,NULL,25),
  (219,6,29,NULL,NULL,26),
  (220,6,30,NULL,NULL,27),
  (221,6,31,NULL,NULL,29),
  (222,6,32,NULL,NULL,7),
  (223,6,33,NULL,NULL,8),
  (224,6,29,NULL,NULL,2),
  (225,6,30,NULL,NULL,3),
  (226,6,31,NULL,NULL,5),
  (227,6,32,NULL,NULL,30),
  (228,6,33,NULL,NULL,31),
  (229,6,32,NULL,NULL,32),
  (230,6,31,NULL,NULL,33),
  (231,6,30,NULL,NULL,54),
  (232,6,29,NULL,NULL,53),
  (233,6,38,NULL,NULL,52),
  (234,6,37,NULL,NULL,51),
  (235,6,36,NULL,NULL,50),
  (236,6,35,NULL,NULL,55),
  (237,6,34,NULL,NULL,56),
  (243,6,33,NULL,NULL,57),
  
  (244,6,32,NULL,NULL,47),
  (245,6,31,NULL,NULL,48),
  (246,6,30,NULL,NULL,49);


INSERT INTO `tpo`.`vpis`(`ID_VPIS`,`ID_PROGRAM`,`ID_NACIN`,`ID_STUD_LETO`,`ID_VRSTAVPISA`,
                         `ID_OBLIKA`,`ID_LETNIK`,`POTRJENOST_VPISA`,`VPISNA_STEVILKA`)VALUES

  (1,11,1, 2,1,1,1,1,63150000),
  (2,11,1, 2,1,1,1,1,63150001),
  (3,11,1, 2,1,1,1,1,63150002),
  (4,11,1, 2,1,1,1,1,63150003),
  #(5,11,1,2,1,1,1,1,63150004),

  (6,11,1, 2,1,1,2,1,63150005),
  (7,11,1, 2,1,1,2,1,63150006),
  (8,11,2, 2,1,1,1,1,63150007),


  (9,11,1, 2,1,1,3,1,63150008),
  (10,11,1,2,1,1,2,1,63150009),
  (11,11,1,2,1,1,3,1,63150010),
  (12,11,1,2,1,1,1,1,63150011),
  (13,11,1,2,1,1,2,1,63150012),
  (14,11,1,2,1,1,2,1,63150013),

  (15,11,1,2,1,1,2,1,63150014),
  (16,11,1,2,1,1,2,1,63150015),
  (17,11,1,2,1,1,2,1,63150016),
  (18,11,1,2,1,1,2,1,63150017),
  (19,11,1,2,1,1,2,1,63150018),
  (20,11,1,2,1,1,2,1,63150019),
  (21,11,1,2,1,1,2,1,63150020),
  (22,11,1,2,1,1,2,1,63150022),

  (51,11,1,1,1,1,1,1,63150101),

  (52,11,1,1,1,1,1,1,63150102),
  (53,11,1,2,1,1,2,1,63150102),

  (54,11,1,1,1,1,1,1,63150103),

  (55,11,1,2,1,1,2,1,63150103);


INSERT INTO `tpo`.`student`
(`VPISNA_STEVILKA`,`ID_OSEBA`,`ID_KANDIDAT`,`ID_VPIS`,`EMSO`,`ID_PROGRAM`,
 `VSOTA_OPRAVLJENIH_KREDITNIH_TOCK`,`POVPRECNA_OCENA_OPRAVLJENIH_IZPITOV`)VALUES

  (63150000,1,1,1,2505996500510,11,60,10),
  (63150001,4,2,2,1234567891211,11,60,6),
  (63150002,7,2,2,1234567891212,11,36,6),
  (63150003,8,2,2,1234567891213,11,60,10),
  (63150004,9,2,2,1234567891214,11,12,7),
  (63150005,10,2,2,1234567891215,11,120,9.33),
  (63150006,11,2,2,1234567891216,11,100,8.20),
  (63150007,12,2,2,1234567891217,11,66,7.3),
  (63150008,15,2,2,1234567891218,11,180,6),
  (63150009,16,2,2,1234567891219,11,54,7.7),
  (63150010,17,2,2,1234567891220,11,114,8),
  (63150011,18,2,2,1234567891221,11,42,7),
  (63150012,19,2,2,1234567891222,11,24,6),
  (63150013,20,2,2,1234567891223,12,120,6),
  (63150014,21,2,2,1234567891224,11,120,6),
  (63150015,22,2,2,1234567891225,11,120,6),
  (63150021,23,2,2,1234567891226,11,120,6),
  (63150016,24,2,2,1234567891227,11,120,6),
  (63150017,25,2,2,1234567891228,11,120,6),
  (63150018,26,2,2,1234567891229,11,120,6),
  (63150019,27,2,2,12345678912330,11,120,6),
  (63150020,28,2,2,12345678912331,11,120,6),
  (63150022,39,2,22,12345678912332,11,54,6),
  (63150101, 41, 4, 51, 1706996500334, 11, 60, 8),
  (63150102, 42, 5, 53, 1706996500334, 11, 120, 8),
  (63150103, 43, 6, 55, 1706996500334, 11, 120, 9);

INSERT INTO `tpo`.`naslov`(`ID_NASLOV`,`ID_POSTA`,`ID_OBCINA`,`ID_DRZAVA`,
                           `ID_OSEBA`,`JE_ZAVROCANJE`,`JE_STALNI`,`ULICA`) VALUES
  (1,1,1,705,1,1,0,'naslovzavrocanje 13'),
  (2,1,1,705,1,0,1,'stalninaslov 12'),
  (3,2,1,705,4,1,0,'zaVrocanje Ulica 12'),
  (4,2,1,705,4,0,1,'stalna Ulica 12'),

  (11, NULL, NULL, 40,  41, 0, 1, 'Test 50, 1000 Viena'),
  (12,  187,   61, 705, 41, 1, 0, 'Dunajska 10'),

  (13, NULL, NULL,   40, 42, 0, 1, 'Test 50, 1000 Viena'),
  (14,  187,   61,  705, 42, 1, 0, 'Dunajska 10'),

  (15, NULL, NULL, 40, 43, 0, 1, 'Test 50, 1000 Viena'),
  (16,  187,  61, 705, 43, 1, 0, 'Dunajska 10');

INSERT INTO  `tpo`.`zeton`
(`ID_OSEBA`, `ID_LETNIK`, `ID_STUD_LETO`, `ID_OBLIKA`, `ID_NACIN`, `ID_VRSTAVPISA`, `ID_PROGRAM`,`IZKORISCEN`, `AKTIVNOST`)
VALUES
  (1,1,1,1,1,1, 11,1,1),
  (4,1,1,1,1,1, 11,1,1),
  (7,1,1,1,1,2, 11,1,0),
  (8,1,1,1,1,1, 11,1,0),
  (10,2,1,1,1,1,11,1,0),
  (11,2,1,1,1,1,11,1,0),


  (15,3,1,1,1,1,11,1, 1),
  (16,2,1,1,1,2,11,1, 1),
  (17,3,1,1,1,2,11,1, 1),
  (18,1,1,1,1,1,11,1, 1),
  (19,2,1,1,1,1,11,1, 1),
  (20,2,1,1,1,1,11,1, 1),
  (21,2,1,1,1,1,11,1, 1),
  (22,2,1,1,1,1,11,1, 1),
  (23,2,1,1,1,1,11,1, 1),
  (24,2,1,1,1,1,11,1, 1),
  (25,2,1,1,1,1,11,1, 1),
  (26,2,1,1,1,1,11,1, 1),
  (27,2,1,1,1,1,11,1, 1),
  (28,2,1,1,1,1,11,1, 1),

  (41,1,1,1,1,1,11,1,1),
  (41,2,2,1,1,1,11,0,1),

  (42,1,1,1,1,1,11,1,1),
  (42,2,2,1,1,1,11,1,1),
  (42,3,2,1,1,1,11,0,1),

  (43,1,1,1,1,1,11,1,1),
  (43,2,2,1,1,1,11,1,1);

INSERT INTO  `tpo`.`zeton` (`ID_OSEBA`, `ID_LETNIK`, `ID_STUD_LETO`, `ID_OBLIKA`, `ID_NACIN`, `ID_VRSTAVPISA`, `ID_PROGRAM`,`IZKORISCEN`, `AKTIVNOST`, `PROSTA_IZBIRNOST`) VALUES
  (43,3,2,1,1,1,11,0,1,1);

INSERT INTO tpo.rok
(ID_ROK, ID_IZVEDBA, DATUM_ROKA, CAS_ROKA, AKTIVNOST, ID_OSEBA_IZPRASEVALEC1, ID_OSEBA_IZPRASEVALEC2, ID_OSEBA_IZPRASEVALEC3)
VALUES
  /* TPO (Mah, Fur, Poz), Studijsko leto 2017/18 */
  (1,5,"2018-01-13", "10:00:00", 1, 2, 13, NULL),
  (2,5,"2018-01-25", "11:00:00", 1, 2, 14, NULL),
  (3,5,"2018-09-25", "12:00:00", 1, 2, 13, 14),

  /* P1 (Mah), Studijsko leto 2017/18 */
  (4,6,"2018-01-12", "12:00:00", 1, NULL, NULL, NULL),
  (5,6,"2018-01-19", "13:00:00", 1, NULL, NULL, NULL),
  (6,6,"2018-09-21", "14:00:00", 1, NULL, NULL, NULL),

  /* TPO (Mah, Fur, Poz), Studijsko leto 2016/17 */
  (7,1,"2017-06-20", "14:00:00", 1, NULL, NULL, NULL),
  (8,1,"2017-06-25", "15:00:00", 1, NULL, NULL, NULL),
  (9,1,"2017-09-05", "16:00:00", 1, NULL, NULL, NULL),

  /* P1 (Fur, Poz), Studijsko leto 2016/17 */
  (10,2,"2017-01-20", "16:00:00", 1, NULL, NULL, NULL),
  (11,2,"2017-01-25", "17:00:00", 1, NULL, NULL, NULL),
  (12,2,"2017-09-05", "18:00:00", 1, NULL, NULL, NULL),

  /*id_predmet=9, stud_leto=2017/18*/
  (13,21,"2019-01-20", "16:00:00", 1, NULL, NULL, NULL),
  (14,21,"2019-01-25", "17:00:00", 1, NULL, NULL, NULL),
  (15,21,"2018-09-05", "18:00:00", 1, NULL, NULL, NULL),

  /*id_predmet=12, stud_leto=2017/18*/
  (16,22,"2019-01-21", "16:00:00", 1, NULL, NULL, NULL),
  (17,22,"2019-01-26", "17:00:00", 1, NULL, NULL, NULL),
  (18,22,"2018-09-06", "18:00:00", 1, NULL, NULL, NULL),

  /*id_predmet=18, stud_leto=2017/18*/
  (19,23,"2019-01-21", "16:00:00", 1, NULL, NULL, NULL),
  (20,23,"2019-01-26", "17:00:00", 1, NULL, NULL, NULL),
  (21,23,"2018-09-06", "18:00:00", 1, NULL, NULL, NULL),

  /*id_predmet=19, stud_leto=2017/18*/
  (22,24,"2019-01-21", "16:00:00", 1, NULL, NULL, NULL),
  (23,24,"2019-01-26", "17:00:00", 1, NULL, NULL, NULL),
  (24,24,"2018-09-06", "18:00:00", 1, NULL, NULL, NULL),

  /*
    (25,25,"2018-06-20", "14:00:00", 1, NULL, NULL, NULL),
    (26,25,"2018-06-25", "15:00:00", 1, NULL, NULL, NULL),
    (27,25,"2018-09-05", "16:00:00", 1, NULL, NULL, NULL),

    (28,26,"2019-06-20", "14:00:00", 1, NULL, NULL, NULL),
    (29,26,"2019-06-25", "15:00:00", 1, NULL, NULL, NULL),
    (30,26,"2019-09-05", "16:00:00", 1, NULL, NULL, NULL),
    (31,26,"2019-09-07", "16:00:00", 1, NULL, NULL, NULL),
  */
  (32,27,"2017-06-20", "14:00:00", 1, NULL, NULL, NULL),
  (33,27,"2017-06-25", "15:00:00", 1, NULL, NULL, NULL),
  (34,27,"2017-09-05", "16:00:00", 1, NULL, NULL, NULL),

  (35,22,"2018-09-20","10:00:00",1, NULL, NULL, NULL);



INSERT INTO `predmeti_studenta`
( `VPISNA_STEVILKA`, `ID_PREDMET`, `ID_STUD_LETO`)
VALUES
  (63150000,  6,    2),
  (63150000,  9,    2),
  (63150000,  10,   2),
  (63150000,  11,   2),
  (63150000,  12,   2),
  (63150000,  13,   2),
  (63150000,  14,   2),
  (63150000,  15,   2),
  (63150000,  16,   2),
  (63150000,  17,   2),
  (63150001,  6,    2),
  (63150001,  9,    2),
  (63150001,  10,   2),
  (63150001,  11,   2),
  (63150001,  12,   2),
  (63150001,  13,   2),
  (63150001,  14,   2),
  (63150001,  15,   2),
  (63150001,  16,   2),
  (63150001,  17,   2),
  (63150002,  6,    2),
  (63150002,  9,    2),
  (63150002,  10,   2),
  (63150002,  11,   2),
  (63150002,  12,   2),
  (63150002,  13,   2),
  (63150002,  14,   2),
  (63150002,  15,   2),
  (63150002,  16,   2),
  (63150002,  17,   2),
  (63150003,  6,    2),
  (63150003,  9,    2),
  (63150003,  10,   2),
  (63150003,  11,   2),
  (63150003,  12,   2),
  (63150003,  13,   2),
  (63150003,  14,   2),
  (63150003,  15,   2),
  (63150003,  16,   2),
  (63150003,  17,   2),
  (63150004,  6,    2),
  (63150004,  9,    2),
  (63150004,  10,   2),
  (63150004,  11,   2),
  (63150004,  12,   2),
  (63150004,  13,   2),
  (63150004,  14,   2),
  (63150004,  15,   2),
  (63150004,  16,   2),
  (63150004,  17,   2),
  (63150011,  6,    2),
  (63150011,  9,    2),
  (63150011,  10,   2),
  (63150011,  11,   2),
  (63150011,  12,   2),
  (63150011,  13,   2),
  (63150011,  14,   2),
  (63150011,  15,   2),
  (63150011,  16,   2),
  (63150011,  17,   2),
  (63150005,  18,   2),
  (63150006,  18,   2),
  (63150007,  18,   2),
  (63150012,  18,   2),
  (63150013,  18,   2),
  (63150014,  18,   2),
  (63150015,  18,   2),
  (63150016,  18,   2),
  (63150017,  18,   2),
  (63150018,  18,   2),
  (63150019,  18,   2),
  (63150020,  18,   2),
  (63150005,  19,   2),
  (63150006,  19,   2),
  (63150007,  19,   2),
  (63150012,  19,   2),
  (63150013,  19,   2),
  (63150014,  19,   2),
  (63150015,  19,   2),
  (63150016,  19,   2),
  (63150017,  19,   2),
  (63150018,  19,   2),
  (63150019,  19,   2),
  (63150020,  19,   2),
  (63150005,  20,   2),
  (63150006,  20,   2),
  (63150007,  20,   2),
  (63150012,  20,   2),
  (63150013,  20,   2),
  (63150014,  20,   2),
  (63150015,  20,   2),
  (63150016,  20,   2),
  (63150017,  20,   2),
  (63150018,  20,   2),
  (63150019,  20,   2),
  (63150020,  20,   2),
  (63150005,  21,   2),
  (63150006,  21,   2),
  (63150007,  21,   2),
  (63150012,  21,   2),
  (63150013,  21,   2),
  (63150014,  21,   2),
  (63150015,  21,   2),
  (63150016,  21,   2),
  (63150017,  21,   2),
  (63150018,  21,   2),
  (63150019,  21,   2),
  (63150020,  21,   2),
  (63150005,  22,   2),
  (63150006,  22,   2),
  (63150007,  22,   2),
  (63150012,  22,   2),
  (63150013,  22,   2),
  (63150014,  22,   2),
  (63150015,  22,   2),
  (63150016,  22,   2),
  (63150017,  22,   2),
  (63150018,  22,   2),
  (63150019,  22,   2),
  (63150020,  22,   2),
  (63150005,  23,   2),
  (63150006,  23,   2),
  (63150007,  23,   2),
  (63150012,  23,   2),
  (63150013,  23,   2),
  (63150014,  23,   2),
  (63150015,  23,   2),
  (63150016,  23,   2),
  (63150017,  23,   2),
  (63150018,  23,   2),
  (63150019,  23,   2),
  (63150020,  23,   2),
  (63150005,  24,   2),
  (63150006,  24,   2),
  (63150007,  24,   2),
  (63150012,  24,   2),
  (63150013,  24,   2),
  (63150014,  24,   2),
  (63150015,  24,   2),
  (63150016,  24,   2),
  (63150017,  24,   2),
  (63150018,  24,   2),
  (63150019,  24,   2),
  (63150020,  24,   2),
  (63150005,  25,   2),
  (63150006,  25,   2),
  (63150007,  25,   2),
  (63150012,  25,   2),
  (63150013,  25,   2),
  (63150014,  25,   2),
  (63150015,  25,   2),
  (63150016,  25,   2),
  (63150017,  25,   2),
  (63150018,  25,   2),
  (63150019,  25,   2),
  (63150020,  25,   2),
  (63150005,  26,   2),
  (63150006,  26,   2),
  (63150007,  26,   2),
  (63150012,  26,   2),
  (63150013,  26,   2),
  (63150014,  26,   2),
  (63150015,  26,   2),
  (63150016,  26,   2),
  (63150017,  26,   2),
  (63150018,  26,   2),
  (63150019,  26,   2),
  (63150020,  26,   2),
  (63150000,  1,    2),
  (63150001,  1,    2),
  (63150002,  1,    2),
  (63150022, 18,2),
  (63150022, 19,2),
  (63150022, 20,2),
  (63150022, 21,2),
  (63150022, 22,2);
/*
(63150022, 57,2);
*/

INSERT INTO prijava(ID_PRIJAVA, ID_ROK, VPISNA_STEVILKA, ZAP_ST_POLAGANJ, ZAP_ST_POLAGANJ_LETOS, PODATKI_O_PLACILU, TOCKE_IZPITA, DATUM_PRIJAVE, DATUM_ODJAVE) VALUES
  /* Prijave na izpite TPO. 1,2 in 3 rok, stud. leto 2017/18 */
  (1, 1,  63150000, 1,  1, 1,   NULL, '2018-01-02 12:22:00',  NULL),
  (2, 1,  63150001, 1,  1, 1,   NULL, '2018-01-04 12:23:00',  NULL),
  (3, 1,  63150002, 1,  1, 2,   NULL, '2018-01-05 23:32:22',  NULL),
  (4, 2,  63150000, 2,  2, 1,   NULL, '2018-01-03 12:23:34',  NULL),
  (5, 2,  63150001, 1,  1, 1,   NULL, '2018-06-01 11:12:13',  NULL),
  (6, 2,  63150002, 2,  2, 1,   NULL, '2018-06-01 17:12:13',  NULL),
  (7, 3,  63150003, 2,  2, 1,   NULL, '2018-06-03 15:16:17',  NULL),

  /* Prijave na izpite P1. 1,2 in 3 rok, stud. leto 2017/18 */
  (8, 4,  63150000, 1,  1,  1,  NULL, '2018-01-02 11:11:11',  NULL),
  (9, 5,  63150000, 2,  2,  1,  NULL, '2018-01-03 12:12:12',  NULL),
  (10,4,  63150001, 1,  1,  1,  NULL, '2018-01-04 13:14:11',  NULL),
  (11,4,  63150002, 1,  1,  1,  NULL, '2018-01-05 16:16:16',  NULL),
  (12,4,  63150003, 1,  1,  1,  NULL, '2018-01-05 17:16:15',  NULL),
  (13,4,  63150004, 1,  1,  1,  NULL, '2018-01-05 14:13:12',  NULL),
  (14,5,  63150004, 2,  1,  1,  NULL, '2018-01-05 14:11:12',  NULL),
  (15,4,  63150011, 1,  1,  1,  NULL, '2018-01-05 11:10:09',  NULL);


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