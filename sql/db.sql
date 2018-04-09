/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     27/03/2018 18:50:00                          */
/*==============================================================*/
DROP SCHEMA `tpo`;
CREATE SCHEMA `tpo` ;
USE tpo;

drop table if exists DEL_PREDMETNIKA;

drop table if exists DRZAVA;

drop table if exists IZPIT;

drop table if exists IZVEDBA_PREDMETA;

drop table if exists KANDIDAT;

drop table if exists LETNIK;

drop table if exists NACIN_STUDIJA;

drop table if exists OBCINA;

drop table if exists OBLIKA_STUDIJA;

drop table if exists OSEBA;

drop table if exists POSTA;

drop table if exists PREDMET;

drop table if exists PREDMETI_STUDENTA;

drop table if exists PREDMETPREDMETNIK;

drop table if exists PREDMETNIK;

drop table if exists PRIJAVA;

drop table if exists PROGRAM;

drop table if exists REFERENT;

drop table if exists ROK;

drop table if exists STUDENT;

drop table if exists STUDIJSKO_LETO;

drop table if exists UCITELJ;

drop table if exists VPIS;

drop table if exists VRSTA_VPISA;

drop table if exists ZETON;

drop table if exists NASLOV;

/*==============================================================*/
/* Table: DEL_PREDMETNIKA                                       */
/*==============================================================*/
create table DEL_PREDMETNIKA
(
  ID_DELPREDMETNIKA    int not null,
  NAZIV_DELAPREDMETNIKA char(50) not null,
  SKUPNOSTEVILOKT      int not null,
  AKTIVNOST_DELPREDMETNIKA int not null,
  TIP                  char(2) not null,
  primary key (ID_DELPREDMETNIKA)
);


/*==============================================================*/
/* Table: DRZAVA                                                */
/*==============================================================*/
create table DRZAVA
(
  ID_DRZAVE            int not null AUTO_INCREMENT,
  DVOMESTNAKODA        char(2) not null,
  TRIMESTNAKODA        char(3) not null,
  ISONAZIV             char(50) not null,
  SLOVENSKINAZIV       char(50),
  OPOMBA               char(200),
  AKTIVNOST_DRZAVA     int not null,
  primary key (ID_DRZAVE)
);

/*==============================================================*/
/* Table: IZPIT                                                 */
/*==============================================================*/
create table IZPIT
(
  ID_IZPITA            int not null AUTO_INCREMENT,
  ID_PRIJAVA           int,
  OCENA_IZPITA         int,
  AKTIVNOST_IZPITA     int not null,
  primary key (ID_IZPITA)
);

/*==============================================================*/
/* Table: IZVEDBA_PREDMETA                                      */
/*==============================================================*/
create table IZVEDBA_PREDMETA
(
  ID_IZVEDBA           int not null AUTO_INCREMENT,
  ID_STUD_LETO         int not null,
  ID_UCITELJ1           int not null,
  ID_UCITELJ2           int,
  ID_UCITELJ3           int,
  ID_PREDMET           int not null,
  primary key (ID_IZVEDBA)
);

/*==============================================================*/
/* Table: KANDIDAT                                              */
/*==============================================================*/
create table KANDIDAT
(
  ID_KANDIDATA         int not null AUTO_INCREMENT,
  ID_OSEBA             int,
  EMSO                 int,
  IZKORISCEN           int not null,
  IME                  char(50),
  PRIIMEK              char(50),
  VPISNA_STEVILKA      int,
  SIFRA_PROGRAM        char(15),
  primary key (ID_KANDIDATA)
);

/*==============================================================*/
/* Table: LETNIK                                                */
/*==============================================================*/
create table LETNIK
(
  ID_LETNIK            int not null AUTO_INCREMENT,
  LETNIK               int not null,
  MOZEN_VPIS           char(10),
  primary key (ID_LETNIK)
);

/*==============================================================*/
/* Table: NACIN_STUDIJA                                         */
/*==============================================================*/
create table NACIN_STUDIJA
(
  ID_NACIN             int not null AUTO_INCREMENT,
  OPIS_NACIN           char(50) not null,
  ANG_OPIS_NACIN       char(50),
  AKTIVNOST_NACIN      int not null,
  primary key (ID_NACIN)
);



/*==============================================================*/
/* Table: NASLOV                                                */
/*==============================================================*/
create table NASLOV
(
  ID_NASLOV            int not null AUTO_INCREMENT,
  ID_POSTA             int not null,
  ID_OBCINA            int not null,
  ID_DRZAVE            int not null,
  ID_OSEBA             int,
  ZAVROCANJE           int,
  STALNI               int,
  ULICA                char(50),
  HISNA_STEVILKA       char(50),
  primary key (ID_NASLOV)
);

/*==============================================================*/
/* Table: OBCINA                                                */
/*==============================================================*/
create table OBCINA
(
  ID_OBCINA            int not null AUTO_INCREMENT,
  IME_OBCINA           char(50) not null,
  AKTIVNA_OBCINA       char(50),
  primary key (ID_OBCINA)
);

/*==============================================================*/
/* Table: OBLIKA_STUDIJA                                        */
/*==============================================================*/
create table OBLIKA_STUDIJA
(
  ID_OBLIKA            int not null AUTO_INCREMENT,
  NAZIV_OBLIKA         char(50) not null,
  ANG_OPIS_OBLIKA      char(50),
  AKTIVNOST_OBLIKA     int not null,
  primary key (ID_OBLIKA)
);

/*==============================================================*/
/* Table: OSEBA                                                 */
/*==============================================================*/
create table OSEBA
(
  ID_OSEBA             int not null AUTO_INCREMENT,
  EMAIL                char(30) not null,
  GESLO                char(60) not null,
  VRSTA_VLOGE          char(1) not null,
  IME                  char(50),
  PRIIMEK              char(50),
  TELEFONSKA_STEVIKLKA char(10),
  primary key (ID_OSEBA)
);

/*==============================================================*/
/* Table: POSTA                                                 */
/*==============================================================*/

create table POSTA
(
  ID_POSTA             int not null AUTO_INCREMENT,
  ST_POSTA             char(4),
  KRAJ                 char(30) not null,
  AKTIVNOST_POSTA      int not null,
  primary key (ID_POSTA)
);


/*==============================================================*/
/* Table: PREDMET                                               */
/*==============================================================*/
create table PREDMET
(
  ID_PREDMET           int not null AUTO_INCREMENT,
  IME_PREDMET          char(50) not null,
  AKTIVNOST_PREDMET    int not null,
  primary key (ID_PREDMET)
);


create table PREDMETPREDMETNIK
(
  ID_PREDMETPREDMETNIK int not null,
  ID_DELPREDMETNIKA    int not null,
  ID_PREDMET           int not null,
  primary key (ID_PREDMETPREDMETNIK)
);
/*==============================================================*/
/* Table: PREDMETI_STUDENTA                                     */
/*==============================================================*/
create table PREDMETI_STUDENTA
(
  ID_PREDMETISTUDENT   int not null AUTO_INCREMENT,
  ID_VPISA             int not null,
  ID_PREDMET           int not null,
  STUD_LETO            int,
  primary key (ID_PREDMETISTUDENT)
);

/*==============================================================*/
/* Table: PREDMETNIK                                            */
/*==============================================================*/
create table PREDMETNIK
(
  ID_PREDMETNIK        int not null,
  ID_STUD_LETO         int not null,
  ID_PROGRAM           int not null,
  ID_LETNIK            int not null,
  ID_PREDMETPREDMETNIK int not null,
  AKTIVNOST_PREDMETNIK int not null,
  primary key (ID_PREDMETNIK)
);

/*==============================================================*/
/* Table: PRIJAVA                                               */
/*==============================================================*/
create table PRIJAVA
(
  ID_PRIJAVA           int not null AUTO_INCREMENT,
  ID_IZPITA            int,
  ID_PREDMETISTUDENT   int not null,
  ID_ROKA              int not null,
  ZAP_ST_POLAGANJ      int not null,
  PODATKI_O_PLACILU    char(50),
  VPISNA_STEVILKA      int,
  IME_PREDMET          char(50),
  STUD_LETO            int,
  DATUM_ROKA           date,
  primary key (ID_PRIJAVA)
);

/*==============================================================*/
/* Table: PROGRAM                                               */
/*==============================================================*/
create table PROGRAM
(
  ID_PROGRAM           int not null AUTO_INCREMENT,
  SIFRA_PROGRAM        char(15) not null,
  NAZIV_PROGRAM        char(50) not null,
  STOPNJA_PROGRAM      char(50) not null,
  ST_SEMESTROV         int not null,
  SIFRA_EVS            int,
  AKTIVNOST_PROGRAM    int not null,
  primary key (ID_PROGRAM)
);

/*==============================================================*/
/* Table: REFERENT                                              */
/*==============================================================*/
create table REFERENT
(
  ID_OSEBA             int not null AUTO_INCREMENT,
  IME                  char(50),
  PRIIMEK              char(50),
  primary key (ID_OSEBA)
);

/*==============================================================*/
/* Table: ROK                                                   */
/*==============================================================*/
create table ROK
(
  ID_ROKA              int not null AUTO_INCREMENT,
  ID_IZVEDBA           int not null,
  DATUM_ROKA           date not null,
  CAS_ROKA             time not null,
  AKTIVNOST_ROKA       int,
  primary key (ID_ROKA)
);

/*==============================================================*/
/* Table: STUDENT                                               */
/*==============================================================*/
create table STUDENT
(
  ID_OSEBA             int not null,
  VPISNA_STEVILKA      int not null,
  PRIIMEK              char(50),
  IME                  char(50),
  EMSO                 char(20) not null,
  ID_KANDIDATA         int,
  ID_POSTA             int not null,
  ID_DRZAVE            int not null,
  ID_VPISA             int,
  ID_OBCINA            int not null,
  SIFRA_PROGRAM        char(15),
  primary key (ID_OSEBA)
);

/*==============================================================*/
/* Table: STUDIJSKO_LETO                                        */
/*==============================================================*/
create table STUDIJSKO_LETO
(
  ID_STUD_LETO         int not null AUTO_INCREMENT,
  STUD_LETO            char(10) not null,
  AKTIVNOST_STUDIJSKOLETO int,
  primary key (ID_STUD_LETO)
);

/*==============================================================*/
/* Table: UCITELJ                                               */
/*==============================================================*/
create table UCITELJ
(
  ID_OSEBA             int not null,
  ID_UCITELJ           int not null,
  IME                  char(50),
  PRIIMEK              char(50),
  AKTIVNOST_UCITELJ    int not null,
  primary key (ID_OSEBA, ID_UCITELJ)
);

/*==============================================================*/
/* Table: VPIS                                                  */
/*==============================================================*/
create table VPIS
(
  ID_VPISA             int not null AUTO_INCREMENT,
  ID_PROGRAM           int not null,
  ID_NACIN             int not null,
  ID_STUD_LETO         int not null,
  ID_VRSTAVPISA        int not null,
  ID_OBLIKA            int not null,
  ID_LETNIK            int not null,
  POTRJENOST_VPISA     int not null,
  VPISNA_STEVILKA      int,
  primary key (ID_VPISA)
);

/*==============================================================*/
/* Table: VRSTA_VPISA                                           */
/*==============================================================*/
create table VRSTA_VPISA
(
  ID_VRSTAVPISA        int not null AUTO_INCREMENT,
  OPIS_VPISA           char(30) not null,
  AKTIVNOST_VPIS       int not null,
  primary key (ID_VRSTAVPISA)
);

/*==============================================================*/
/* Table: ZETON                                                 */
/*==============================================================*/
create table ZETON
(
  ID_ZETONA            int not null AUTO_INCREMENT,
  ID_OSEBA             int not null,
  EMSO                 int not null,
  IZKORISCEN           int,
  LETNIK               int,
  STUD_LETO            int,
  primary key (ID_ZETONA)
);

alter table IZPIT add constraint FK_RELATIONSHIP_28 foreign key (ID_PRIJAVA)
references PRIJAVA (ID_PRIJAVA) on delete restrict on update restrict;

alter table IZVEDBA_PREDMETA add constraint FK_RELATIONSHIP_18 foreign key (ID_PREDMET)
references PREDMET (ID_PREDMET) on delete restrict on update restrict;

alter table IZVEDBA_PREDMETA add constraint FK_RELATIONSHIP_19 foreign key (ID_STUD_LETO)
references STUDIJSKO_LETO (ID_STUD_LETO) on delete restrict on update restrict;

alter table NASLOV add constraint FK_RELATIONSHIP_30 foreign key (ID_POSTA)
references POSTA (ID_POSTA) on delete restrict on update restrict;

alter table NASLOV add constraint FK_RELATIONSHIP_31 foreign key (ID_OBCINA)
references OBCINA (ID_OBCINA) on delete restrict on update restrict;

alter table NASLOV add constraint FK_RELATIONSHIP_32 foreign key (ID_OSEBA)
references STUDENT (ID_OSEBA) on delete restrict on update restrict;

alter table NASLOV add constraint FK_RELATIONSHIP_33 foreign key (ID_DRZAVE)
references DRZAVA (ID_DRZAVE) on delete restrict on update restrict;

alter table PREDMETI_STUDENTA add constraint FK_RELATIONSHIP_23 foreign key (ID_VPISA)
references VPIS (ID_VPISA) on delete restrict on update restrict;

alter table PREDMETI_STUDENTA add constraint FK_RELATIONSHIP_24 foreign key (ID_PREDMET)
references PREDMET (ID_PREDMET) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_13 foreign key (ID_PROGRAM)
references PROGRAM (ID_PROGRAM) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_14 foreign key (ID_LETNIK)
references LETNIK (ID_LETNIK) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_17 foreign key (ID_STUD_LETO)
references STUDIJSKO_LETO (ID_STUD_LETO) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_36 foreign key (ID_PREDMETPREDMETNIK)
references PREDMETPREDMETNIK (ID_PREDMETPREDMETNIK) on delete restrict on update restrict;

alter table PREDMETPREDMETNIK add constraint FK_RELATIONSHIP_34 foreign key (ID_DELPREDMETNIKA)
references DEL_PREDMETNIKA (ID_DELPREDMETNIKA) on delete restrict on update restrict;

alter table PREDMETPREDMETNIK add constraint FK_RELATIONSHIP_35 foreign key (ID_PREDMET)
references PREDMET (ID_PREDMET) on delete restrict on update restrict;

alter table PRIJAVA add constraint FK_RELATIONSHIP_26 foreign key (ID_ROKA)
references ROK (ID_ROKA) on delete restrict on update restrict;

alter table PRIJAVA add constraint FK_RELATIONSHIP_27 foreign key (ID_PREDMETISTUDENT)
references PREDMETI_STUDENTA (ID_PREDMETISTUDENT) on delete restrict on update restrict;

alter table PRIJAVA add constraint FK_RELATIONSHIP_29 foreign key (ID_IZPITA)
references IZPIT (ID_IZPITA) on delete restrict on update restrict;

alter table REFERENT add constraint FK_INHERITANCE_2 foreign key (ID_OSEBA)
references OSEBA (ID_OSEBA) on delete restrict on update restrict;

alter table ROK add constraint FK_RELATIONSHIP_25 foreign key (ID_IZVEDBA)
references IZVEDBA_PREDMETA (ID_IZVEDBA) on delete restrict on update restrict;

alter table STUDENT add constraint FK_INHERITANCE_3 foreign key (ID_OSEBA)
references OSEBA (ID_OSEBA) on delete restrict on update restrict;

alter table STUDENT add constraint FK_RELATIONSHIP_5 foreign key (ID_KANDIDATA)
references KANDIDAT (ID_KANDIDATA) on delete restrict on update restrict;

alter table STUDENT add constraint FK_RELATIONSHIP_6 foreign key (ID_VPISA)
references VPIS (ID_VPISA) on delete restrict on update restrict;

alter table UCITELJ add constraint FK_INHERITANCE_1 foreign key (ID_OSEBA)
references OSEBA (ID_OSEBA) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_10 foreign key (ID_OBLIKA)
references OBLIKA_STUDIJA (ID_OBLIKA) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_11 foreign key (ID_LETNIK)
references LETNIK (ID_LETNIK) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_12 foreign key (ID_PROGRAM)
references PROGRAM (ID_PROGRAM) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_16 foreign key (ID_STUD_LETO)
references STUDIJSKO_LETO (ID_STUD_LETO) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_8 foreign key (ID_VRSTAVPISA)
references VRSTA_VPISA (ID_VRSTAVPISA) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_9 foreign key (ID_NACIN)
references NACIN_STUDIJA (ID_NACIN) on delete restrict on update restrict;

alter table ZETON add constraint FK_RELATIONSHIP_7 foreign key (ID_OSEBA)
references STUDENT (ID_OSEBA) on delete restrict on update restrict;



INSERT INTO `tpo`.`oseba`(`ID_OSEBA`,`EMAIL`,`GESLO`,`VRSTA_VLOGE`,`IME`,`PRIIMEK`,`TELEFONSKA_STEVIKLKA`)VALUES
  (1,'testS', '123456', 's', 'Janez', 'Novak','040040040'),
  (2,'testP', '123456', 'p', 'An', 'Ban','030030030'),
  (3,'testR', '123456', 'r', 'Ancka', 'Novak','050505050'),
  (4,'testS2', '123456', 's', 'Janezek', 'Novakovic','123581321'),
  (5,'testA', '123456', 'a', 'Admin', 'Admin','123581321');
# preverjanje login:
# uporabnisko ime=testS  geslo='123456'
# VRSTA_VLOGE: admin='a', referat='r', profesor='p' in student='s'

INSERT INTO `tpo`.`drzava`
(`ID_DRZAVE`,`DVOMESTNAKODA`,`TRIMESTNAKODA`,`ISONAZIV`,`SLOVENSKINAZIV`,`OPOMBA`,`AKTIVNOST_DRZAVA`)VALUES
  (1,'MK','MKD','Macedonia','Makedonija','Ni opomb',1),
  (2,'SI','SLO','Slovenia','Slovenija','Ni opomb',1);

INSERT INTO `tpo`.`obcina`(`ID_OBCINA`,`IME_OBCINA`,`AKTIVNA_OBCINA`)VALUES
  (1,'beltinci',0),
  (2,'Trebnje',1),
  (3,'Ljubljana',1);

INSERT INTO `tpo`.`program`(`ID_PROGRAM`,`SIFRA_PROGRAM`,`NAZIV_PROGRAM`,
                            `STOPNJA_PROGRAM`,`ST_SEMESTROV`,`SIFRA_EVS`,`AKTIVNOST_PROGRAM`)VALUES
  (1,'L2','RACUNAL. IN INFORMATIKA UN','C-(predbolonjski) univerzitetni',
   9,1000475,1),
  (2,'P7','RACUNAL. IN MATEMATIKA UN','C-(predbolonjski) univerzitetni',
   8,1000425,1);

INSERT INTO `tpo`.`posta`(`ST_POSTA`,`KRAJ`,`AKTIVNOST_POSTA`)VALUES
  (1000,'Ljubljana', 1),
  (2000,'Maribor',1);


INSERT INTO `tpo`.`nacin_studija`
(`ID_NACIN`,`OPIS_NACIN`,`ANG_OPIS_NACIN`,`AKTIVNOST_NACIN`)VALUES
  (1,'redni','full-time',1),
  (3,'izredni','part-time',1);


INSERT INTO `tpo`.`oblika_studija`
(`ID_OBLIKA`,`NAZIV_OBLIKA`,`ANG_OPIS_OBLIKA`,`AKTIVNOST_OBLIKA`)VALUES
  (1,'na lokaciji','on site','e-learning'),
  (2,'na daljavo','distance learning','e-learning'),
  (3,'e-studij','e-studij','e-learning');

INSERT INTO `tpo`.`vrsta_vpisa`
(`ID_VRSTAVPISA`,`OPIS_VPISA`,`AKTIVNOST_VPIS`)VALUES
  (1,'Prvi vpis v letnik/dodatno leto',1),
  (2,'Ponavlanje letnika',1);


INSERT INTO `tpo`.`letnik`(`ID_LETNIK`,`LETNIK`,`MOZEN_VPIS`)VALUES
  (1,'Stari dodiplomski program -uni','dodatno leto in za podaljsanje'),
  (2,'Stari dodiplomski-visokosolski', 'vpis ni vec mozen'),
  (3,'1.,2.,3., stopnja', 'vsi letniki'),
  (4,'EM', 'Vsi letniki'),
  (5,'Stari magisterski studij', 'vpis ni vec mozen'),
  (6,'stari doktorski studij', 'vpis ni vec mozen');

INSERT INTO `tpo`.`studijsko_leto`(`STUD_LETO`, `AKTIVNOST_STUDIJSKOLETO`)VALUES
  ("2016/2017",1),("2017/2018",1),("2018/2019",1);
  
INSERT INTO `tpo`.`vpis`(`ID_VPISA`,`ID_PROGRAM`,`ID_NACIN`,`ID_STUD_LETO`,`ID_VRSTAVPISA`,
                         `ID_OBLIKA`,`ID_LETNIK`,`POTRJENOST_VPISA`,`VPISNA_STEVILKA`)VALUES
  (1,1,1,1,1,1,1,1,63150000),
  (2,1,3,2,2,1,2,1,63150001);

INSERT INTO `tpo`.`kandidat`(`ID_KANDIDATA`,`ID_OSEBA`,`EMSO`,`IZKORISCEN`,`IME`,
                             `PRIIMEK`,`VPISNA_STEVILKA`,`SIFRA_PROGRAM`)VALUES
  (1,1,2505996500532,1,'Janez', 'Novak',63150000,1),
  (2,1,0406996505123,1,'Janezek', 'Novakovic',63150001,2);


INSERT INTO `tpo`.`student`
(`ID_OSEBA`,`VPISNA_STEVILKA`,`PRIIMEK`,`IME`,`EMSO`,`ID_KANDIDATA`,
 `ID_POSTA`,`ID_DRZAVE`,`ID_VPISA`,`ID_OBCINA`,`SIFRA_PROGRAM`)VALUES
  (1,63150000,'Novak', 'Janez', 2505996500532,1,1000,1,2,1,1),
  (4,63150001,'Novakovic','Janezek',0406996505123,2,2000,1,2,1,2);


INSERT INTO `tpo`.`naslov`(`ID_POSTA`,`ID_OBCINA`,`ID_DRZAVE`,`ID_OSEBA`,
                           `ZAVROCANJE`,`ULICA`,`HISNA_STEVILKA`,`STALNI`)VALUES
  (1,1,1,1,1,'naslovzavrocanje',13,0);

INSERT INTO `tpo`.`naslov`(`ID_POSTA`,`ID_OBCINA`,`ID_DRZAVE`,`ID_OSEBA`,
                           `ZAVROCANJE`,`ULICA`,`HISNA_STEVILKA`,`STALNI`)VALUES
  (1,1,1,1,0,'stalninaslov',12,1);

INSERT INTO `tpo`.`ucitelj`
(`ID_OSEBA`, `ID_UCITELJ`, `IME`, `PRIIMEK`, `AKTIVNOST_UCITELJ`)VALUES
  (2,1,'An','Ban',1);

INSERT INTO `tpo`.`PREDMET`
    (`IME_PREDMET`, `AKTIVNOST_PREDMET`)
VALUES
    ('TPO', 1),
    ('PRPO', 1),
    ('SP', 1),
    ('EP', 1),
    ('OM', 1);

INSERT INTO `tpo`.`IZVEDBA_PREDMETA`
    (`ID_STUD_LETO`, `ID_UCITELJ1`, `ID_PREDMET`)
VALUES
    (1, 1, 1),
    (2, 1, 1),
    (3, 1, 1),
    (2, 1, 2);
