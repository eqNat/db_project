drop table myclientsession cascade constraints;
drop table myclient cascade constraints;

create table myclient (
  clientid varchar2(20) primary key,
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
 
insert into myclient values ('s', 'a',1,0);
insert into myclient values ('a', 'a',0,1);
insert into myclient values ('sa', 'a',1,1);
commit;