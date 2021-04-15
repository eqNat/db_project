DROP TABLE myclientsession CASCADE CONSTRAINTS;
DROP TABLE myclient CASCADE CONSTRAINTS;
DROP TABLE student CASCADE CONSTRAINTS;
DROP SEQUENCE student_id_seq;

CREATE SEQUENCE student_id_seq INCREMENT BY 1;

CREATE TABLE myclient (
  clientid VARCHAR2(10) PRIMARY KEY,
  fname VARCHAR2(30) NOT NULL,
  lname VARCHAR2(30) NOT NULL,
  password VARCHAR2(20) NOT NULL,
  isadmin NUMBER(1) NOT NULL
);

CREATE TABLE student (
    studentid number PRIMARY KEY,
    age NUMBER(3), -- we can later change this to birthdate
    country VARCHAR2(30) NOT NULL,
    -- state, province, district, etc
    admin_div VARCHAR2(30) NOT NULL,
    city VARCHAR2(30) NOT NULL,
    street VARCHAR2(30) NOT NULL,
    apt_num NUMBER(10),
    zip NUMBER(9),
    clientid VARCHAR2(10) NOT NULL,
    FOREIGN KEY (clientid) REFERENCES myclient ON DELETE CASCADE
);

CREATE TABLE myclientsession (
  sessionid VARCHAR2(32),
  clientid VARCHAR2(8),
  sessiondate DATE NOT NULL,
  FOREIGN KEY (clientid) references myclient,
  PRIMARY KEY (sessionid, clientid)
);

INSERT INTO myclient VALUES ('s','Joe','Student','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 25, 'United States', 'Oklahoma', 'Edmond', '500 Made-up Dr', NULL, 55555, 's');

INSERT INTO myclient VALUES ('a','Jane','Admin','a',1);

INSERT INTO myclient VALUES ('sa','Sheev','Palpatine','a',1);
INSERT INTO student VALUES (student_id_seq.nextval, 50, 'Canada', 'Ontario', 'Toronto', '501 Made-up Dr', 78, 55575, 'sa');

INSERT INTO myclient VALUES ('dm','Darth','Maul','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 45, 'United States', 'Kansas', 'Leawood', '502 Made-up Dr', NULL, 55575, 'dm');

INSERT INTO myclient VALUES ('dv','Darth','Vader','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 40, 'United States', 'Kansas', 'Leawood', '503 Made-up Dr', NULL, 55575, 'dv');

INSERT INTO myclient VALUES ('db','Darth','Bane','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 35, 'United States', 'Kansas', 'Leawood', '504 Made-up Dr', NULL, 55575, 'db');

INSERT INTO myclient VALUES ('dz','Darth','Zannah','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 30, 'United States', 'Kansas', 'Leawood', '505 Made-up Dr', NULL, 55575, 'dz');

INSERT INTO myclient VALUES ('at','Ahsoka','Tano','a',1);

COMMIT;
