DROP TABLE myclientsession CASCADE CONSTRAINTS;
DROP TABLE myclient CASCADE CONSTRAINTS;
DROP TABLE student CASCADE CONSTRAINTS;

-- We need a transaction when we insert a 'student' table along with a 'myclient' table
CREATE TABLE student (
    studentid VARCHAR2(20) PRIMARY KEY,
    age NUMBER(3), -- we can later change this to birthdate
    country VARCHAR2(56) NOT NULL,
    -- state, province, district, etc
    administrative_division VARCHAR2(50) NOT NULL,
    city VARCHAR2(58) NOT NULL,
    street_address VARCHAR2(100) NOT NULL,
    apt_number NUMBER,
    zip_code NUMBER(9)
);

CREATE TABLE myclient (
  clientid VARCHAR2(20) PRIMARY KEY,
  fname VARCHAR2(20) NOT NULL,
  lname VARCHAR2(20) NOT NULL,
  password VARCHAR2(20) NOT NULL,
  isadmin NUMBER(1) NOT NULL,
  studentid VARCHAR2(20),
  FOREIGN KEY (studentid) REFERENCES student
);

CREATE TABLE myclientsession (
  sessionid VARCHAR2(32),
  clientid VARCHAR2(8),
  sessiondate DATE NOT NULL,
  FOREIGN KEY (clientid) references myclient,
  PRIMARY KEY (sessionid, clientid)
);

INSERT INTO student VALUES ('s', 25, 'United States', 'Oklahoma', 'Edmond', '500 Made-up Dr', NULL, 55555);
INSERT INTO myclient VALUES ('s','Joe','Student','a',0,'s');

INSERT INTO myclient VALUES ('a','Jane','Admin','a',1,NULL);

INSERT INTO student VALUES ('sa', 50, 'Canada', 'Ontario', 'Toronto', '501 Made-up Dr', 78, 55575);
INSERT INTO myclient VALUES ('sa','Sheev','Palpatine','a',1,'sa');

INSERT INTO student VALUES ('dm', 45,'United States', 'Kansas', 'Leawood', '502 Made-up Dr', NULL, 55575);
INSERT INTO myclient VALUES ('dm','Darth','Maul','a',0,'dm');

INSERT INTO student VALUES ('dv', 40, 'United States', 'Kansas', 'Leawood', '503 Made-up Dr', NULL, 55575);
INSERT INTO myclient VALUES ('dv','Darth','Vader','a',0,'dv');

INSERT INTO student VALUES ('db', 35, 'United States', 'Kansas', 'Leawood', '504 Made-up Dr', NULL, 55575);
INSERT INTO myclient VALUES ('db','Darth','Bane','a',0,'db');

INSERT INTO student VALUES ('dz', 30, 'United States', 'Kansas', 'Leawood', '505 Made-up Dr', NULL, 55575);
INSERT INTO myclient VALUES ('dz','Darth','Zannah','a',0,'dz');

INSERT INTO myclient VALUES ('at','Ahsoka','Tano','a',1,NULL);

COMMIT;
