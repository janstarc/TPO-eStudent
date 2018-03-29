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

/*==============================================================*/
/* Table: DEL_PREDMETNIKA                                       */
/*==============================================================*/
create table DEL_PREDMETNIKA
(
  SIFRA                int not null,
  NAZIV_DELAPREDMETNIKA char(50) not null,
  SKUPNOSTEVILOKT      int not null,
  AKTIVNOST_DELPREDMETNIKA int not null,
  primary key (SIFRA)
);

/*==============================================================*/
/* Table: DRZAVA                                                */
/*==============================================================*/
create table DRZAVA
(
  ID_DRZAVE            int not null,
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
  ID_IZPITA            int not null,
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
  ID_IZVEDBE           int not null,
  ID_OSEBA             int,
  ID_UCITELJ           int,
  ID_STUD_LETO         int not null,
  UCI_ID_OSEBA         int,
  UCI_ID_UCITELJ       int,
  UCI_ID_OSEBA2        int not null,
  UCI_ID_UCITELJ2      int not null,
  ID_PREDMET           int not null,
  primary key (ID_IZVEDBE)
);

/*==============================================================*/
/* Table: KANDIDAT                                              */
/*==============================================================*/
create table KANDIDAT
(
  ID_KANDIDATA         int not null,
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
  ID_LETNIK            int not null,
  LETNIK               int not null,
  MOZEN_VPIS           char(10),
  primary key (ID_LETNIK)
);

/*==============================================================*/
/* Table: NACIN_STUDIJA                                         */
/*==============================================================*/
create table NACIN_STUDIJA
(
  ID_NACIN             int not null,
  OPIS_NACIN           char(50) not null,
  ANG_OPIS_NACIN       char(50),
  AKTIVNOST_NACIN      int not null,
  primary key (ID_NACIN)
);

/*==============================================================*/
/* Table: OBCINA                                                */
/*==============================================================*/
create table OBCINA
(
  ID_OBCINA            int not null,
  IME_OBCINA           char(50) not null,
  AKTIVNA_OBCINA       char(50),
  primary key (ID_OBCINA)
);

/*==============================================================*/
/* Table: OBLIKA_STUDIJA                                        */
/*==============================================================*/
create table OBLIKA_STUDIJA
(
  ID_OBLIKA            int not null,
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
  ID_OSEBA             int not null,
  EMAIL                 char(30) not null,
  GESLO                char(60) not null,
  VRSTA_VLOGE      char(1) not null,
  IME                  char(50),
  PRIIMEK              char(50),
  primary key (ID_OSEBA)
);

/*==============================================================*/
/* Table: POSTA                                                 */
/*==============================================================*/
create table POSTA
(
  ID_POSTA             int not null,
  KRAJ                 char(30) not null,
  AKTIVNOST_POSTA      int not null,
  primary key (ID_POSTA)
);

/*==============================================================*/
/* Table: PREDMET                                               */
/*==============================================================*/
create table PREDMET
(
  ID_PREDMET           int not null,
  IME_PREDMET          char(50) not null,
  AKTIVNOST_PREDMET    int not null,
  primary key (ID_PREDMET)
);

/*==============================================================*/
/* Table: PREDMETI_STUDENTA                                     */
/*==============================================================*/
create table PREDMETI_STUDENTA
(
  ID_PREDMETISTUDENT   int not null,
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
  ID_LETNIK            int not null,
  ID_PREDMET           int not null,
  SIFRA                int not null,
  ID_PROGRAM           int not null,
  AKTIVNOST_PREDMETNIK int not null,
  STUD_LETO            int,
  primary key (ID_PREDMETNIK)
);

/*==============================================================*/
/* Table: PRIJAVA                                               */
/*==============================================================*/
create table PRIJAVA
(
  ID_PRIJAVA           int not null,
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
  ID_PROGRAM           int not null,
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
  ID_OSEBA             int not null,
  IME                  char(50),
  PRIIMEK              char(50),
  primary key (ID_OSEBA)
);

/*==============================================================*/
/* Table: ROK                                                   */
/*==============================================================*/
create table ROK
(
  ID_ROKA              int not null,
  ID_IZVEDBE           int not null,
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
  EMSO                 int not null,
  ID_KANDIDATA         int,
  ID_POSTA             int not null,
  ID_DRZAVE            int not null,
  ID_VPISA             int,
  ID_OBCINA            int not null,
  SIFRA_PROGRAM        char(15),
  primary key (ID_OSEBA, EMSO)
);

/*==============================================================*/
/* Table: STUDIJSKO_LETO                                        */
/*==============================================================*/
create table STUDIJSKO_LETO
(
  ID_STUD_LETO         int not null,
  STUD_LETO            int,
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
  ID_VPISA             int not null,
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
  ID_VRSTAVPISA        int not null,
  OPIS_VPISA           char(30) not null,
  AKTIVNOST_VPIS       int not null,
  primary key (ID_VRSTAVPISA)
);

/*==============================================================*/
/* Table: ZETON                                                 */
/*==============================================================*/
create table ZETON
(
  ID_ZETONA            int not null,
  ID_OSEBA             int not null,
  EMSO                 int not null,
  IZKORISCEN           int,
  LETNIK               int,
  STUD_LETO            int,
  primary key (ID_ZETONA)
);

alter table IZPIT add constraint FK_RELATIONSHIP_28 foreign key (ID_PRIJAVA)
references PRIJAVA (ID_PRIJAVA) on delete restrict on update restrict;

alter table IZVEDBA_PREDMETA add constraint FK_RELATIONSHIP_19 foreign key (ID_PREDMET)
references PREDMET (ID_PREDMET) on delete restrict on update restrict;

alter table IZVEDBA_PREDMETA add constraint FK_RELATIONSHIP_20 foreign key (ID_STUD_LETO)
references STUDIJSKO_LETO (ID_STUD_LETO) on delete restrict on update restrict;

alter table IZVEDBA_PREDMETA add constraint FK_UCITELJ1 foreign key (ID_OSEBA, ID_UCITELJ)
references UCITELJ (ID_OSEBA, ID_UCITELJ) on delete restrict on update restrict;

alter table IZVEDBA_PREDMETA add constraint FK_UCITELJ2 foreign key (UCI_ID_OSEBA2, UCI_ID_UCITELJ2)
references UCITELJ (ID_OSEBA, ID_UCITELJ) on delete restrict on update restrict;

alter table IZVEDBA_PREDMETA add constraint FK_UCITELJ3 foreign key (UCI_ID_OSEBA, UCI_ID_UCITELJ)
references UCITELJ (ID_OSEBA, ID_UCITELJ) on delete restrict on update restrict;

#alter table KANDIDAT add constraint FK_RELATIONSHIP_4 foreign key (ID_OSEBA)
#      references STUDENT (ID_OSEBA) on delete restrict on update restrict;

alter table PREDMETI_STUDENTA add constraint FK_RELATIONSHIP_23 foreign key (ID_VPISA)
references VPIS (ID_VPISA) on delete restrict on update restrict;

alter table PREDMETI_STUDENTA add constraint FK_RELATIONSHIP_24 foreign key (ID_PREDMET)
references PREDMET (ID_PREDMET) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_13 foreign key (ID_PROGRAM)
references PROGRAM (ID_PROGRAM) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_14 foreign key (ID_LETNIK)
references LETNIK (ID_LETNIK) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_15 foreign key (SIFRA)
references DEL_PREDMETNIKA (SIFRA) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_16 foreign key (ID_PREDMET)
references PREDMET (ID_PREDMET) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_18 foreign key (ID_STUD_LETO)
references STUDIJSKO_LETO (ID_STUD_LETO) on delete restrict on update restrict;

alter table PRIJAVA add constraint FK_RELATIONSHIP_26 foreign key (ID_ROKA)
references ROK (ID_ROKA) on delete restrict on update restrict;

alter table PRIJAVA add constraint FK_RELATIONSHIP_27 foreign key (ID_PREDMETISTUDENT)
references PREDMETI_STUDENTA (ID_PREDMETISTUDENT) on delete restrict on update restrict;

alter table PRIJAVA add constraint FK_RELATIONSHIP_29 foreign key (ID_IZPITA)
references IZPIT (ID_IZPITA) on delete restrict on update restrict;

alter table REFERENT add constraint FK_INHERITANCE_2 foreign key (ID_OSEBA)
references OSEBA (ID_OSEBA) on delete restrict on update restrict;

alter table ROK add constraint FK_RELATIONSHIP_25 foreign key (ID_IZVEDBE)
references IZVEDBA_PREDMETA (ID_IZVEDBE) on delete restrict on update restrict;

alter table STUDENT add constraint FK_INHERITANCE_3 foreign key (ID_OSEBA)
references OSEBA (ID_OSEBA) on delete restrict on update restrict;

alter table STUDENT add constraint FK_RELATIONSHIP_1 foreign key (ID_DRZAVE)
references DRZAVA (ID_DRZAVE) on delete restrict on update restrict;

alter table STUDENT add constraint FK_RELATIONSHIP_2 foreign key (ID_OBCINA)
references OBCINA (ID_OBCINA) on delete restrict on update restrict;

alter table STUDENT add constraint FK_RELATIONSHIP_3 foreign key (ID_POSTA)
references POSTA (ID_POSTA) on delete restrict on update restrict;

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

alter table VPIS add constraint FK_RELATIONSHIP_17 foreign key (ID_STUD_LETO)
references STUDIJSKO_LETO (ID_STUD_LETO) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_8 foreign key (ID_VRSTAVPISA)
references VRSTA_VPISA (ID_VRSTAVPISA) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_9 foreign key (ID_NACIN)
references NACIN_STUDIJA (ID_NACIN) on delete restrict on update restrict;

alter table ZETON add constraint FK_RELATIONSHIP_7 foreign key (ID_OSEBA, EMSO)
references STUDENT (ID_OSEBA, EMSO) on delete restrict on update restrict;



INSERT INTO `tpo`.`oseba`(`ID_OSEBA`,`EMAIL`,`GESLO`,`VRSTA_VLOGE`,`IME`,`PRIIMEK`)VALUES
  (1,'testS', '123456', 's', 'Janez', 'Novak'),
  (2,'testP', '123456', 'p', 'An', 'Ban'),
  (3,'testR', '123456', 'r', 'Ančka', 'Novak'),
  (4,'testS2', '123456', 's', 'Janezek', 'Novakovič');
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

INSERT INTO `tpo`.`studijsko_leto`
(`ID_STUD_LETO`,`STUD_LETO`)
VALUES
  (1,2017),
  (2,2018);

INSERT INTO `tpo`.`program`(`ID_PROGRAM`,`SIFRA_PROGRAM`,`NAZIV_PROGRAM`,
                            `STOPNJA_PROGRAM`,`ST_SEMESTROV`,`SIFRA_EVS`,`AKTIVNOST_PROGRAM`)VALUES
  (1,'L2','RAČUNAL. IN INFORMATIKA UN','C-(predbolonjski) univerzitetni',
   9,1000475,1),
  (2,'P7','RAČUNAL. IN MATEMATIKA UN','C-(predbolonjski) univerzitetni',
   8,1000425,1);

INSERT INTO `tpo`.`posta`(`ID_POSTA`,`KRAJ`,`AKTIVNOST_POSTA`)VALUES
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
  (3,'e-študij','e-študij','e-learning');

INSERT INTO `tpo`.`vrsta_vpisa`
(`ID_VRSTAVPISA`,`OPIS_VPISA`,`AKTIVNOST_VPIS`)VALUES
  (1,'Prvi vpis v letnik/dodatno leto',1),
  (2,'Ponavlanje letnika',1);


INSERT INTO `tpo`.`letnik`(`ID_LETNIK`,`LETNIK`,`MOZEN_VPIS`)VALUES
  (1,'Stari dodiplomski program -uni','dodatno leto in za podaljšanje'),
  (2,'Stari dodiplomski-visokošolski', 'vpis ni več možen'),
  (3,'1.,2.,3., stopnja', 'vsi letniki'),
  (4,'EM', 'Vsi letniki'),
  (5,'Stari magisterski študij', 'vpis ni več možen'),
  (6,'stari doktorski študij', 'vpis ni več možen');

INSERT INTO `tpo`.`vpis`(`ID_VPISA`,`ID_PROGRAM`,`ID_NACIN`,`ID_STUD_LETO`,`ID_VRSTAVPISA`,
                         `ID_OBLIKA`,`ID_LETNIK`,`POTRJENOST_VPISA`,`VPISNA_STEVILKA`)VALUES
  (1,1,1,1,1,1,1,1,63150000),
  (2,1,3,2,2,1,2,1,63150001);

INSERT INTO `tpo`.`kandidat`(`ID_KANDIDATA`,`ID_OSEBA`,`EMSO`,`IZKORISCEN`,`IME`,
                             `PRIIMEK`,`VPISNA_STEVILKA`,`SIFRA_PROGRAM`)VALUES
  (1,1,2505996500532,1,'Janez', 'Novak',63150000,1),
  (2,1,0406996505123,1,'Janezek', 'Novakovič',63150001,2);


INSERT INTO `tpo`.`student`
(`ID_OSEBA`,`VPISNA_STEVILKA`,`PRIIMEK`,`IME`,`EMSO`,`ID_KANDIDATA`,
 `ID_POSTA`,`ID_DRZAVE`,`ID_VPISA`,`ID_OBCINA`,`SIFRA_PROGRAM`)VALUES
  (1,63150000,'Novak', 'Janez', 2505996500532,1,1000,1,2,1,1),
  (4,63150001,'Novakovič','Janezek',0406996505123,2,2000,1,2,1,2);
