INSERT INTO `tpo`.`oseba`(`ID_OSEBA`,`UPOR_IME`,`GESLO`,`STAT`,`IME`,`PRIIMEK`)VALUES
  (1,'testStudent' ,12345678,3,'Janez', 'Novak'),
  (2,'testUcitelj' ,123456789,2,'An', 'Ban'),
  (3,'testReferent' ,1234567890,1,'Ančka', 'Novak');

# preverjanje login:
# uporabnisko ime= testStudent  geslo=12345678
# referent ima STAT = 1 , učitelj ima STAT = 2 , študent ima STAT = 3