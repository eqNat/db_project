drop table myclientsession cascade constraints;
drop table myclient cascade constraints;

create table myclient (
  clientid varchar2(20) primary key,
  fname varchar2(20),
  lname varchar2(20),
  password varchar2(20),
  isstudent number(1),
  isadmin number(1)
);

create table myclientsession (
  sessionid varchar2(32) primary key,
  clientid varchar2(8),
  sessiondate date,
  foreign key (clientid) references myclient
);
 
insert into myclient values ('s','Joe','Student','a',1,0);
insert into myclient values ('a','Jane','Admin','a',0,1);
insert into myclient values ('sa','Sheev','Palpatine','a',1,1);
insert into myclient values ('dm','Darth','Maul','a',1,0);
insert into myclient values ('dv','Darth','Vader','a',1,0);
insert into myclient values ('db','Darth','Bane','a',1,0);
insert into myclient values ('dz','Darth','Zannah','a',1,0);
insert into myclient values ('at','Ahsoka','Tano','a',1,0);
commit;