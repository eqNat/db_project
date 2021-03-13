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
 
insert into myclient values ('student', 'a',1,0);
insert into myclient values ('admin', 'a',0,1);
insert into myclient values ('studentadmin', 'a',1,1);
commit;