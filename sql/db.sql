/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     26/03/2018 11:46:32                          */
/*==============================================================*/
DROP DATABASE `tpo`;
CREATE SCHEMA `tpo` ;
USE tpo;

drop table if exists DEL_PREDMETNIKA;

drop table if exists DRZAVA;

drop table if exists ID_PROGRAM;

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
/* Table: ID_PROGRAM                                            */
/*==============================================================*/
create table ID_PROGRAM
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
  ID_UCITELJ           int,
  ID_STUD_LETO         int not null,
  ID_UCITELJ2           int,
  ID_UCITELJ3          int,
  ID_PREDMET           int not null,
  primary key (ID_IZVEDBA)
);

/*==============================================================*/
/* Table: KANDIDAT                                              */
/*==============================================================*/
create table KANDIDAT
(
  ID_KANDIDATA         int not null,
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
  ID_NACIN             int not null ,
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
  UPOR_IME             char(30),
  GESLO                char(30) not null,
  STAT               int,
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
  ID_PREDMET           int not null AUTO_INCREMENT,
  IME_PREDMET          char(50) not null,
  AKTIVNOST_PREDMET    int not null,
  primary key (ID_PREDMET)
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
  ID_PREDMETNIK        int not null ,
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
/* Table: REFERENT                                              */
/*==============================================================*/
create table REFERENT
(
  ID_OSEBA             int not null,
  OSE_IME              char(50),
  PRIIMEK              char(50),
  IME                  char(50) not null,
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
  SIFRA_PROGRAM        char(15),
  LETNIK               int,
  STUD_LETO            int,
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
  ID_ZETONA            int not null AUTO_INCREMENT,
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

alter table PREDMETI_STUDENTA add constraint FK_RELATIONSHIP_23 foreign key (ID_VPISA)
references VPIS (ID_VPISA) on delete restrict on update restrict;

alter table PREDMETI_STUDENTA add constraint FK_RELATIONSHIP_24 foreign key (ID_PREDMET)
references PREDMET (ID_PREDMET) on delete restrict on update restrict;

alter table PREDMETNIK add constraint FK_RELATIONSHIP_13 foreign key (ID_PROGRAM)
references ID_PROGRAM (ID_PROGRAM) on delete restrict on update restrict;

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

alter table ROK add constraint FK_RELATIONSHIP_25 foreign key (ID_IZVEDBA)
references IZVEDBA_PREDMETA (ID_IZVEDBA) on delete restrict on update restrict;

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
references ID_PROGRAM (ID_PROGRAM) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_17 foreign key (ID_STUD_LETO)
references STUDIJSKO_LETO (ID_STUD_LETO) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_8 foreign key (ID_VRSTAVPISA)
references VRSTA_VPISA (ID_VRSTAVPISA) on delete restrict on update restrict;

alter table VPIS add constraint FK_RELATIONSHIP_9 foreign key (ID_NACIN)
references NACIN_STUDIJA (ID_NACIN) on delete restrict on update restrict;


