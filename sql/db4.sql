-- MySQL Script generated by MySQL Workbench
-- Mon Apr  9 23:11:56 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

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
CREATE SCHEMA IF NOT EXISTS `tpo` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci ;
USE `tpo` ;

-- -----------------------------------------------------
-- Table `tpo`.`del_predmetnika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`del_predmetnika` (
  `ID_DELPREDMETNIKA` INT(11) NOT NULL AUTO_INCREMENT,
  `NAZIV_DELAPREDMETNIKA` CHAR(50) NOT NULL,
  `SKUPNOSTEVILOKT` INT(11) NOT NULL,
  `TIP` CHAR(2) NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_DELPREDMETNIKA`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tpo`.`drzava`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`drzava` (
  `ID_DRZAVE` INT(11) NOT NULL AUTO_INCREMENT,
  `DVOMESTNAKODA` CHAR(2) NOT NULL,
  `TRIMESTNAKODA` CHAR(3) NOT NULL,
  `ISONAZIV` CHAR(50) NOT NULL,
  `SLOVENSKINAZIV` CHAR(50) NULL DEFAULT NULL,
  `OPOMBA` CHAR(200) NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_DRZAVE`))
ENGINE = InnoDB
AUTO_INCREMENT = 3;


-- -----------------------------------------------------
-- Table `tpo`.`predmet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`predmet` (
  `ID_PREDMET` INT(11) NOT NULL AUTO_INCREMENT,
  `IME_PREDMET` CHAR(50) NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_PREDMET`))
ENGINE = InnoDB
AUTO_INCREMENT = 6;


-- -----------------------------------------------------
-- Table `tpo`.`studijsko_leto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`studijsko_leto` (
  `ID_STUD_LETO` INT(11) NOT NULL AUTO_INCREMENT,
  `STUD_LETO` CHAR(10) NOT NULL,
  PRIMARY KEY (`ID_STUD_LETO`))
ENGINE = InnoDB
AUTO_INCREMENT = 4;


-- -----------------------------------------------------
-- Table `tpo`.`oseba`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`oseba` (
  `ID_OSEBA` INT(11) NOT NULL AUTO_INCREMENT,
  `IME` CHAR(50) NOT NULL,
  `PRIIMEK` CHAR(50) NOT NULL,
  `EMAIL` CHAR(30) NOT NULL,
  `GESLO` CHAR(60) NOT NULL,
  `VRSTA_VLOGE` CHAR(1) NOT NULL,
  `TELEFONSKA_STEVILKA` CHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_OSEBA`))
ENGINE = InnoDB
AUTO_INCREMENT = 5;


-- -----------------------------------------------------
-- Table `tpo`.`izvedba_predmeta`
-- -----------------------------------------------------
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
    REFERENCES `tpo`.`oseba` (`ID_OSEBA`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `Je_UCITELJ2`
    FOREIGN KEY (`ID_OSEBA2`)
    REFERENCES `tpo`.`oseba` (`ID_OSEBA`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `Je_UCITELJ3`
    FOREIGN KEY (`ID_OSEBA3`)
    REFERENCES `tpo`.`oseba` (`ID_OSEBA`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 5;

CREATE INDEX `FK_RELATIONSHIP_18` ON `tpo`.`izvedba_predmeta` (`ID_PREDMET` ASC);

CREATE INDEX `FK_RELATIONSHIP_19` ON `tpo`.`izvedba_predmeta` (`ID_STUD_LETO` ASC);

CREATE INDEX `2131_idx` ON `tpo`.`izvedba_predmeta` (`ID_OSEBA1` ASC);

CREATE INDEX `Je_UCITELJ2_idx` ON `tpo`.`izvedba_predmeta` (`ID_OSEBA2` ASC);

CREATE INDEX `Je_UCITELJ3_idx` ON `tpo`.`izvedba_predmeta` (`ID_OSEBA3` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`rok`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`rok` (
  `ID_ROKA` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_IZVEDBA` INT(11) NOT NULL,
  `DATUM_ROKA` DATE NOT NULL,
  `CAS_ROKA` TIME NOT NULL,
  `AKTIVNOST` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_ROKA`),
  CONSTRAINT `FK_RELATIONSHIP_25`
    FOREIGN KEY (`ID_IZVEDBA`)
    REFERENCES `tpo`.`izvedba_predmeta` (`ID_IZVEDBA`))
ENGINE = InnoDB;

CREATE INDEX `FK_RELATIONSHIP_25` ON `tpo`.`rok` (`ID_IZVEDBA` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`oblika_studija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`oblika_studija` (
  `ID_OBLIKA` INT(11) NOT NULL AUTO_INCREMENT,
  `NAZIV_OBLIKA` CHAR(50) NOT NULL,
  `ANG_OPIS_OBLIKA` CHAR(50) NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_OBLIKA`))
ENGINE = InnoDB
AUTO_INCREMENT = 4;


-- -----------------------------------------------------
-- Table `tpo`.`letnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`letnik` (
  `ID_LETNIK` INT(11) NOT NULL AUTO_INCREMENT,
  `LETNIK` INT(11) NOT NULL,
  PRIMARY KEY (`ID_LETNIK`))
ENGINE = InnoDB
AUTO_INCREMENT = 7;


-- -----------------------------------------------------
-- Table `tpo`.`stopnja`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`stopnja` (
  `ID_STOPNJA` INT NOT NULL AUTO_INCREMENT,
  `NAZIV` CHAR(50) NOT NULL,
  `MOZEN_VPIS` INT NOT NULL,
  `SIFRA` CHAR(10) NOT NULL,
  PRIMARY KEY (`ID_STOPNJA`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tpo`.`program`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`program` (
  `ID_PROGRAM` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_STOPNJA` INT(11) NOT NULL,
  `SIFRA_PROGRAM` CHAR(15) NOT NULL,
  `NAZIV_PROGRAM` CHAR(100) NOT NULL,
  `ST_SEMESTROV` INT(11) NOT NULL,
  `SIFRA_EVS` INT(11) NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_PROGRAM`),
  CONSTRAINT `FK_STOPNJA`
    FOREIGN KEY (`ID_STOPNJA`)
    REFERENCES `tpo`.`stopnja` (`ID_STOPNJA`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 3;

CREATE INDEX `FK_STOPNJA_idx` ON `tpo`.`program` (`ID_STOPNJA` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`vrsta_vpisa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`vrsta_vpisa` (
  `ID_VRSTAVPISA` INT(11) NOT NULL AUTO_INCREMENT,
  `OPIS_VPISA` CHAR(30) NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_VRSTAVPISA`))
ENGINE = InnoDB
AUTO_INCREMENT = 3;


-- -----------------------------------------------------
-- Table `tpo`.`nacin_studija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`nacin_studija` (
  `ID_NACIN` INT(11) NOT NULL AUTO_INCREMENT,
  `OPIS_NACIN` CHAR(50) NOT NULL,
  `ANG_OPIS_NACIN` CHAR(50) NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_NACIN`))
ENGINE = InnoDB
AUTO_INCREMENT = 4;


-- -----------------------------------------------------
-- Table `tpo`.`vpis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`vpis` (
  `ID_VPISA` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_PROGRAM` INT(11) NOT NULL,
  `ID_NACIN` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `ID_VRSTAVPISA` INT(11) NOT NULL,
  `ID_OBLIKA` INT(11) NOT NULL,
  `ID_LETNIK` INT(11) NOT NULL,
  `POTRJENOST_VPISA` INT(11) NOT NULL,
  `VPISNA_STEVILKA` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_VPISA`),
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
AUTO_INCREMENT = 3;

CREATE INDEX `FK_RELATIONSHIP_10` ON `tpo`.`vpis` (`ID_OBLIKA` ASC);

CREATE INDEX `FK_RELATIONSHIP_11` ON `tpo`.`vpis` (`ID_LETNIK` ASC);

CREATE INDEX `FK_RELATIONSHIP_12` ON `tpo`.`vpis` (`ID_PROGRAM` ASC);

CREATE INDEX `FK_RELATIONSHIP_16` ON `tpo`.`vpis` (`ID_STUD_LETO` ASC);

CREATE INDEX `FK_RELATIONSHIP_8` ON `tpo`.`vpis` (`ID_VRSTAVPISA` ASC);

CREATE INDEX `FK_RELATIONSHIP_9` ON `tpo`.`vpis` (`ID_NACIN` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`predmeti_studenta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`predmeti_studenta` (
  `ID_PREDMETISTUDENT` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_VPISA` INT(11) NOT NULL,
  `ID_PREDMET` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  PRIMARY KEY (`ID_PREDMETISTUDENT`),
  CONSTRAINT `FK_RELATIONSHIP_23`
    FOREIGN KEY (`ID_VPISA`)
    REFERENCES `tpo`.`vpis` (`ID_VPISA`),
  CONSTRAINT `FK_RELATIONSHIP_24`
    FOREIGN KEY (`ID_PREDMET`)
    REFERENCES `tpo`.`predmet` (`ID_PREDMET`),
  CONSTRAINT `FK_STUD_LETO_2`
    FOREIGN KEY (`ID_STUD_LETO`)
    REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_RELATIONSHIP_23` ON `tpo`.`predmeti_studenta` (`ID_VPISA` ASC);

CREATE INDEX `FK_RELATIONSHIP_24` ON `tpo`.`predmeti_studenta` (`ID_PREDMET` ASC);

CREATE INDEX `FK_STUD_LETO_idx` ON `tpo`.`predmeti_studenta` (`ID_STUD_LETO` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`prijava`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`prijava` (
  `ID_PRIJAVA` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_IZPITA` INT(11) NULL DEFAULT NULL,
  `ID_PREDMETISTUDENT` INT(11) NOT NULL,
  `ID_ROKA` INT(11) NOT NULL,
  `ZAP_ST_POLAGANJ` INT(11) NOT NULL,
  `PODATKI_O_PLACILU` CHAR(50) NULL DEFAULT NULL,
  `VPISNA_STEVILKA` INT(11) NULL DEFAULT NULL,
  `IME_PREDMET` CHAR(50) NULL DEFAULT NULL,
  `STUD_LETO` INT(11) NULL DEFAULT NULL,
  `DATUM_ROKA` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`ID_PRIJAVA`),
  CONSTRAINT `FK_RELATIONSHIP_26`
    FOREIGN KEY (`ID_ROKA`)
    REFERENCES `tpo`.`rok` (`ID_ROKA`),
  CONSTRAINT `FK_RELATIONSHIP_27`
    FOREIGN KEY (`ID_PREDMETISTUDENT`)
    REFERENCES `tpo`.`predmeti_studenta` (`ID_PREDMETISTUDENT`),
  CONSTRAINT `FK_RELATIONSHIP_29`
    FOREIGN KEY (`ID_IZPITA`)
    REFERENCES `tpo`.`izpit` (`ID_IZPITA`))
ENGINE = InnoDB;

CREATE INDEX `FK_RELATIONSHIP_26` ON `tpo`.`prijava` (`ID_ROKA` ASC);

CREATE INDEX `FK_RELATIONSHIP_27` ON `tpo`.`prijava` (`ID_PREDMETISTUDENT` ASC);

CREATE INDEX `FK_RELATIONSHIP_29` ON `tpo`.`prijava` (`ID_IZPITA` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`izpit`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`izpit` (
  `ID_IZPITA` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_PRIJAVA` INT(11) NULL DEFAULT NULL,
  `OCENA_IZPITA` INT(11) NULL DEFAULT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_IZPITA`),
  CONSTRAINT `FK_RELATIONSHIP_28`
    FOREIGN KEY (`ID_PRIJAVA`)
    REFERENCES `tpo`.`prijava` (`ID_PRIJAVA`))
ENGINE = InnoDB;

CREATE INDEX `FK_RELATIONSHIP_28` ON `tpo`.`izpit` (`ID_PRIJAVA` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`kandidat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`kandidat` (
  `ID_KANDIDATA` INT(11) NOT NULL AUTO_INCREMENT,
  `EMSO` INT(11) NULL DEFAULT NULL,
  `IZKORISCEN` INT(11) NOT NULL,
  `IME` CHAR(50) NULL DEFAULT NULL,
  `PRIIMEK` CHAR(50) NULL DEFAULT NULL,
  `VPISNA_STEVILKA` INT(11) NULL DEFAULT NULL,
  `ID_PROGRAM` INT NULL DEFAULT NULL,
  PRIMARY KEY (`ID_KANDIDATA`),
  CONSTRAINT `FK_PROGRAM_2`
    FOREIGN KEY (`ID_PROGRAM`)
    REFERENCES `tpo`.`program` (`ID_PROGRAM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3;

CREATE INDEX `FK_PROGRAM_idx` ON `tpo`.`kandidat` (`ID_PROGRAM` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`posta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`posta` (
  `ID_POSTA` INT(11) NOT NULL AUTO_INCREMENT,
  `ST_POSTA` CHAR(4) NULL DEFAULT NULL,
  `KRAJ` CHAR(30) NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_POSTA`))
ENGINE = InnoDB
AUTO_INCREMENT = 3;


-- -----------------------------------------------------
-- Table `tpo`.`obcina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`obcina` (
  `ID_OBCINA` INT(11) NOT NULL AUTO_INCREMENT,
  `IME_OBCINA` CHAR(50) NOT NULL,
  `AKTIVNOST` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_OBCINA`))
ENGINE = InnoDB
AUTO_INCREMENT = 4;


-- -----------------------------------------------------
-- Table `tpo`.`student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`student` (
  `VPISNA_STEVILKA` INT(11) NOT NULL,
  `ID_OSEBA` INT(11) NOT NULL,
  `ID_KANDIDATA` INT(11) NOT NULL,
  `ID_VPISA` INT(11) NOT NULL,
  `EMSO` CHAR(20) NOT NULL,
  `ID_PROGRAM` INT NULL DEFAULT NULL,
  PRIMARY KEY (`VPISNA_STEVILKA`),
  CONSTRAINT `FK_INHERITANCE_3`
    FOREIGN KEY (`ID_OSEBA`)
    REFERENCES `tpo`.`oseba` (`ID_OSEBA`),
  CONSTRAINT `FK_RELATIONSHIP_5`
    FOREIGN KEY (`ID_KANDIDATA`)
    REFERENCES `tpo`.`kandidat` (`ID_KANDIDATA`),
  CONSTRAINT `FK_RELATIONSHIP_6`
    FOREIGN KEY (`ID_VPISA`)
    REFERENCES `tpo`.`vpis` (`ID_VPISA`),
  CONSTRAINT `FK_PROGRAM_1`
    FOREIGN KEY (`ID_PROGRAM`)
    REFERENCES `tpo`.`program` (`ID_PROGRAM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_RELATIONSHIP_5` ON `tpo`.`student` (`ID_KANDIDATA` ASC);

CREATE INDEX `FK_RELATIONSHIP_6` ON `tpo`.`student` (`ID_VPISA` ASC);

CREATE INDEX `FK_PROGRAM_idx` ON `tpo`.`student` (`ID_PROGRAM` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`naslov`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`naslov` (
  `ID_NASLOV` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_POSTA` INT(11) NOT NULL,
  `ID_OBCINA` INT(11) NOT NULL,
  `ID_DRZAVE` INT(11) NOT NULL,
  `ID_OSEBA` INT(11) NULL DEFAULT NULL,
  `JE_ZAVROCANJE` INT(11) NULL DEFAULT NULL,
  `JE_STALNI` INT(11) NULL DEFAULT NULL,
  `ULICA` CHAR(50) NULL DEFAULT NULL,
  `HISNA_STEVILKA` CHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`ID_NASLOV`),
  CONSTRAINT `FK_RELATIONSHIP_30`
    FOREIGN KEY (`ID_POSTA`)
    REFERENCES `tpo`.`posta` (`ID_POSTA`),
  CONSTRAINT `FK_RELATIONSHIP_31`
    FOREIGN KEY (`ID_OBCINA`)
    REFERENCES `tpo`.`obcina` (`ID_OBCINA`),
  CONSTRAINT `FK_RELATIONSHIP_32`
    FOREIGN KEY (`ID_OSEBA`)
    REFERENCES `tpo`.`student` (`ID_OSEBA`),
  CONSTRAINT `FK_RELATIONSHIP_33`
    FOREIGN KEY (`ID_DRZAVE`)
    REFERENCES `tpo`.`drzava` (`ID_DRZAVE`))
ENGINE = InnoDB
AUTO_INCREMENT = 3;

CREATE INDEX `FK_RELATIONSHIP_30` ON `tpo`.`naslov` (`ID_POSTA` ASC);

CREATE INDEX `FK_RELATIONSHIP_31` ON `tpo`.`naslov` (`ID_OBCINA` ASC);

CREATE INDEX `FK_RELATIONSHIP_32` ON `tpo`.`naslov` (`ID_OSEBA` ASC);

CREATE INDEX `FK_RELATIONSHIP_33` ON `tpo`.`naslov` (`ID_DRZAVE` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`predmetnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`predmetnik` (
  `ID_PREDMETNIK` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_PREDMET` INT(11) NOT NULL,
  `ID_DELPREDMETNIKA` INT(11) NOT NULL,
  `ID_LETNIK` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  `ID_PROGRAM` INT(11) NOT NULL,
  `AKTIVNOST` INT(11) NOT NULL,
  PRIMARY KEY (`ID_PREDMETNIK`),
  CONSTRAINT `FK_RELATIONSHIP_13`
    FOREIGN KEY (`ID_PROGRAM`)
    REFERENCES `tpo`.`program` (`ID_PROGRAM`),
  CONSTRAINT `FK_RELATIONSHIP_14`
    FOREIGN KEY (`ID_LETNIK`)
    REFERENCES `tpo`.`letnik` (`ID_LETNIK`),
  CONSTRAINT `FK_RELATIONSHIP_17`
    FOREIGN KEY (`ID_STUD_LETO`)
    REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`),
  CONSTRAINT `FK_PREDMET`
    FOREIGN KEY (`ID_PREDMET`)
    REFERENCES `tpo`.`predmet` (`ID_PREDMET`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_DELPREDMETNIKA`
    FOREIGN KEY (`ID_DELPREDMETNIKA`)
    REFERENCES `tpo`.`del_predmetnika` (`ID_DELPREDMETNIKA`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_RELATIONSHIP_13` ON `tpo`.`predmetnik` (`ID_PROGRAM` ASC);

CREATE INDEX `FK_RELATIONSHIP_14` ON `tpo`.`predmetnik` (`ID_LETNIK` ASC);

CREATE INDEX `FK_RELATIONSHIP_17` ON `tpo`.`predmetnik` (`ID_STUD_LETO` ASC);

CREATE INDEX `FK_PREDMET_idx` ON `tpo`.`predmetnik` (`ID_PREDMET` ASC);

CREATE INDEX `FK_DELPREDMETNIKA_idx` ON `tpo`.`predmetnik` (`ID_DELPREDMETNIKA` ASC);


-- -----------------------------------------------------
-- Table `tpo`.`zeton`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tpo`.`zeton` (
  `ID_ZETONA` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_OSEBA` INT(11) NOT NULL,
  `EMSO` INT(11) NOT NULL,
  `IZKORISCEN` INT(11) NULL DEFAULT NULL,
  `ID_LETNIK` INT(11) NOT NULL,
  `ID_STUD_LETO` INT(11) NOT NULL,
  PRIMARY KEY (`ID_ZETONA`),
  CONSTRAINT `FK_RELATIONSHIP_7`
    FOREIGN KEY (`ID_OSEBA`)
    REFERENCES `tpo`.`student` (`ID_OSEBA`),
  CONSTRAINT `FK_STUD_LETO_1`
    FOREIGN KEY (`ID_STUD_LETO`)
    REFERENCES `tpo`.`studijsko_leto` (`ID_STUD_LETO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_LETNIK_1`
    FOREIGN KEY (`ID_LETNIK`)
    REFERENCES `tpo`.`letnik` (`ID_LETNIK`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_RELATIONSHIP_7` ON `tpo`.`zeton` (`ID_OSEBA` ASC);

CREATE INDEX `FK_STUD_LETO_idx` ON `tpo`.`zeton` (`ID_STUD_LETO` ASC);

CREATE INDEX `FK_LETNIK_idx` ON `tpo`.`zeton` (`ID_LETNIK` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `tpo`.`letnik`
(`ID_LETNIK`, `LETNIK`)VALUES
  (1,1),
  (2,2),
  (3,3),
  (4,4),
  (5,5),
  (6,6);

INSERT INTO `tpo`.`drzava`
(`ID_DRZAVE`,`DVOMESTNAKODA`,`TRIMESTNAKODA`,`ISONAZIV`,`SLOVENSKINAZIV`,`OPOMBA`,`AKTIVNOST`)VALUES
  (1,'MK','MKD','Macedonia','Makedonija','Ni opomb',1),
  (2,'SI','SLO','Slovenia','Slovenija','Ni opomb',1);

INSERT INTO `tpo`.`obcina`(`ID_OBCINA`,`IME_OBCINA`,`AKTIVNOST`)VALUES
  (1,'beltinci',0),
  (2,'Trebnje',1),
  (3,'Ljubljana',1);

INSERT INTO `tpo`.`posta`(`ID_POSTA`, `ST_POSTA`,`KRAJ`,`AKTIVNOST`)VALUES
  (1,1000,'Ljubljana', 1),
  (2,2000,'Maribor',1);

INSERT INTO `tpo`.`nacin_studija`
(`ID_NACIN`,`OPIS_NACIN`,`ANG_OPIS_NACIN`,`AKTIVNOST`)VALUES
  (1,'redni','full-time',1),
  (3,'izredni','part-time',1);


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
  
INSERT INTO `tpo`.`stopnja`(`NAZIV`,`SIFRA`,`MOZEN_VPIS`)VALUES
  ('Stari dodiplomski program-uni','123',0),
  ('Stari dodiplomski-visokosolski', '123',0),
  ('1. stopnja', '123',1),
  ('2. stopnja', '123',1),
  ('3. stopnja', '123',1),
  ('EM', '123',1),
  ('Stari magisterski studij', '123',0),
  ('stari doktorski studij', '123',0);
  
INSERT INTO `tpo`.`studijsko_leto`(`ID_STUD_LETO`, `STUD_LETO`)VALUES
  (1,"2016/17"),
  (2,"2017/18"),
  (3,"2018/19");
  
INSERT INTO `tpo`.`program`(`ID_STOPNJA`, `SIFRA_PROGRAM`, `NAZIV_PROGRAM`,
                            `ST_SEMESTROV`,`SIFRA_EVS`,`AKTIVNOST`)VALUES
  (1,'L2','RACUNAL. IN INFORMATIKA UN C-(predbolonjski) univerzitetni',9,1000475,1),
  (2,'P7','RACUNAL. IN MATEMATIKA UN C-(predbolonjski) univerzitetni',8,1000425,1),
  (3,'XX','RACUNAL. IN INFORMATIKA BUN RI',6,1000426,1);


INSERT INTO `tpo`.`oseba`(`ID_OSEBA`,`EMAIL`,`GESLO`,`VRSTA_VLOGE`,`IME`,`PRIIMEK`,`TELEFONSKA_STEVILKA`)VALUES
  (1,'testS', '123456', 's', 'Janez', 'Novak','040040040'),
  (2,'testP', '123456', 'p', 'An', 'Ban','030030030'),
  (3,'testR', '123456', 'r', 'Ancka', 'Novak','050505050'),
  (4,'testS2', '123456', 's', 'Janezek', 'Novakovic','123581321'),
  (5,'testA', '123456', 'a', 'Admin', 'Admin','123581321');
# preverjanje login:
# uporabnisko ime=testS  geslo='123456'
# VRSTA_VLOGE: admin='a', referat='r', profesor='p' in student='s'

INSERT INTO `tpo`.`kandidat`(`ID_KANDIDATA`,`EMSO`,`IZKORISCEN`,`IME`,
                             `PRIIMEK`,`VPISNA_STEVILKA`,`ID_PROGRAM`)VALUES
  (1,2505996500532,1,'Janez', 'Novak',63150000,3),
  (2,0406996505123,1,'Janezek', 'Novakovic',63150001,3);

    
INSERT INTO `tpo`.`PREDMET`
    (`ID_PREDMET`, `IME_PREDMET`, `AKTIVNOST`)
VALUES
    (1,'TPO', 1),
    (2,'PRPO', 1),
    (3,'SP', 1),
    (4,'EP', 1),
    (5,'OM', 1),
    (6,'P1', 1),
    (7,'PPJ', 1),
    (8,'Sport', 1);

INSERT INTO `tpo`.`del_predmetnika`
    (`ID_DELPREDMETNIKA`, `NAZIV_DELAPREDMETNIKA`, `SKUPNOSTEVILOKT`, `TIP`, `AKTIVNOST`)
VALUES
(1, "Razvoj programske opreme", 18, 'm', 1),
(2, "Informacijski sistemi", 18, 'm', 1),
(3, "Obvezni predmet", 6, 'o', 1),
(4, "Strokovni izbirni predmet", 6, 'st', 1),
(5, "Splosno izbirni predmet", 6, 'sp', 1);

INSERT INTO `tpo`.`predmetnik`
    (`ID_PREDMET`, `ID_DELPREDMETNIKA`, `ID_LETNIK`, `ID_STUD_LETO`, `ID_PROGRAM`, `AKTIVNOST`)
VALUES
    (1, 1, 3, 2, 3, 1),
    (2, 1, 3, 2, 3, 1),
    (3, 1, 3, 2, 3, 1),
    (4, 3, 3, 2, 3, 1),
    (5, 2, 3, 2, 3, 1),
    (6, 3, 1, 2, 3, 1),
    (7, 4, 3, 2, 3, 1),
    (8, 5, 3, 2, 3, 1);

INSERT INTO `tpo`.`IZVEDBA_PREDMETA`
    (`ID_STUD_LETO`, `ID_OSEBA1`, `ID_OSEBA2`, `ID_OSEBA3`, `ID_PREDMET`)
VALUES
    (1, 2, NULL, NULL, 1),
    (2, 2, NULL, NULL, 1),
    (3, 2, NULL, NULL, 1),
    (2, 2, NULL, NULL, 2);

INSERT INTO `tpo`.`vpis`(`ID_VPISA`,`ID_PROGRAM`,`ID_NACIN`,`ID_STUD_LETO`,`ID_VRSTAVPISA`,
                         `ID_OBLIKA`,`ID_LETNIK`,`POTRJENOST_VPISA`,`VPISNA_STEVILKA`)VALUES
  (1,3,1,2,1,1,1,1,63150000);

INSERT INTO `tpo`.`student`
(`VPISNA_STEVILKA`,`ID_OSEBA`,`ID_KANDIDATA`,
 `ID_VPISA`,`EMSO`,`ID_PROGRAM`)VALUES
  (63150000,1,1,1,2505996500532,3);

INSERT INTO `tpo`.`naslov`(`ID_NASLOV`, `ID_POSTA`,`ID_OBCINA`,`ID_DRZAVE`,`ID_OSEBA`,
                         `JE_ZAVROCANJE`,`JE_STALNI`,`ULICA`,`HISNA_STEVILKA`)VALUES
(1,1,1,1,1,1,0,'naslovzavrocanje',13),
(2,1,1,1,1,0,1,'stalninaslov',12);



