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
    studentid NUMBER PRIMARY KEY,
    age NUMBER(3), -- we can later change this to birthdate
    country VARCHAR2(30) NOT NULL,
    -- state, province, district, etc
    admin_div VARCHAR2(30) NOT NULL,
    city VARCHAR2(30) NOT NULL,
    street VARCHAR2(30) NOT NULL,
    apt_num NUMBER(10),
    zip VARCHAR2(10) NOT NULL,
    clientid VARCHAR2(10) NOT NULL,
    isgraduate NUMBER(1) NOT NULL,
    -- This is set to 0 until we implement our trigger
    status NUMBER(1),
    GPA NUMBER,
    FOREIGN KEY (clientid) REFERENCES myclient ON DELETE CASCADE
);

CREATE TABLE myclientsession (
  sessionid VARCHAR2(32) PRIMARY KEY,
  clientid VARCHAR2(8) REFERENCES myclient UNIQUE,
  sessiondate DATE NOT NULL
);

INSERT INTO myclient VALUES ('js1234','Joe','Student','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 25, 'United States', 'Oklahoma', 'Edmond', '500 Made-up Dr', NULL, '55555', 'js1234', 0, 0,NULL);

INSERT INTO myclient VALUES ('ja1235','Jane','Admin','a',1);

INSERT INTO myclient VALUES ('sp1236','Sheev','Palpatine','a',1);
INSERT INTO student VALUES (student_id_seq.nextval, 50, 'Canada', 'Ontario', 'Toronto', '501 Made-up Dr', 78, '55575', 'sp1236', 1, 0,NULL);

INSERT INTO myclient VALUES ('dm1237','Darth','Maul','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 45, 'United States', 'Kansas', 'Leawood', '502 Made-up Dr', NULL, '55575', 'dm1237', 0, 0,NULL);

INSERT INTO myclient VALUES ('dv1238','Darth','Vader','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 40, 'United States', 'Kansas', 'Leawood', '503 Made-up Dr', NULL, '55575', 'dv1238', 0, 0,NULL);

INSERT INTO myclient VALUES ('db1239','Darth','Bane','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 35, 'United States', 'Kansas', 'Leawood', '504 Made-up Dr', NULL, '55575', 'db1239', 0, 1,NULL);

INSERT INTO myclient VALUES ('dz1240','Darth','Zannah','a',0);
INSERT INTO student VALUES (student_id_seq.nextval, 30, 'United States', 'Kansas', 'Leawood', '505 Made-up Dr', NULL, '55575', 'dz1240', 0, 0,NULL);

INSERT INTO myclient VALUES ('at1241','Ahsoka','Tano','a',1);

-- Course and Section part

DROP TABLE course CASCADE CONSTRAINTS;
DROP TABLE section CASCADE CONSTRAINTS;
DROP TABLE enrolled CASCADE CONSTRAINTS;
DROP TABLE requires CASCADE CONSTRAINTS;

CREATE TABLE course (
    id NUMBER(4) PRIMARY KEY,
    title VARCHAR2(32) NOT NULL,
    description VARCHAR2(256) NOT NULL,
    credits NUMBER(1) NOT NULL,
    -- UCO uses four characters to identify a subject.
    subject CHAR(4) NOT NULL
);

CREATE TABLE section (
    crn NUMBER(8) PRIMARY KEY,
    courseid NUMBER(8) NOT NULL,
    deadline DATE NOT NULL,
    capacity NUMBER(3) NOT NULL,
    -- Accepted values: SP, SU, FA
    semester CHAR(2) NOT NULL,
    -- 'TIMESTAMP' stores time down to the second.
    -- We'll ignore year, month, and day.
    begin_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    FOREIGN KEY (courseid) REFERENCES course
);

CREATE TABLE enrolled (
    studentid NUMBER REFERENCES student,
    crn NUMBER REFERENCES section,
    grade NUMBER(1), -- This can be null. Let's go with 0-4 to make this easier
    PRIMARY KEY (studentid, crn)
);

CREATE TABLE requires (
    prerequisite NUMBER(4) REFERENCES COURSE,
    postrequisite NUMBER(4) REFERENCES COURSE,
    PRIMARY KEY (prerequisite, postrequisite)
);

INSERT INTO course VALUES (1453, 'Algebra', 'Learn about Algebra', 3, 'MATH');
INSERT INTO section VALUES (10000, '1453', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10001, '1453', DATE '2021-08-24', 3, 'FA',
    TO_DATE('2000/01/01 14:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:50:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10002, '1453', DATE '2020-05-24', 5, 'SU',
    TO_DATE('2000/01/01 10:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 10:50:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10003, '1453', DATE '2020-08-24', 4, 'FA',
    TO_DATE('2000/01/01 10:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 10:50:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (20001, '1453', DATE '2021-05-24', 3, 'SU',
    TO_DATE('2000/01/01 14:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:50:00', 'yyyy/mm/dd hh24:mi:ss'));

INSERT INTO course VALUES (1454, 'Trigonometry', 'Learn about Trigonometry', 3, 'MATH');
INSERT INTO section VALUES (10004, '1454', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10005, '1454', DATE '2021-08-24', 3, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10006, '1454', DATE '2020-08-25', 4, 'FA',
    TO_DATE('2000/01/01 8:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 8:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10007, '1454', DATE '2019-01-25', 4, 'SP',
    TO_DATE('2000/01/01 8:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 8:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10008, '1454', DATE '2021-08-24', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (20004, '1454', DATE '2021-05-25', 4, 'SU',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));

INSERT INTO course VALUES (1455, 'Calculus I', 'Learn about Calculus I', 3, 'MATH');
INSERT INTO section VALUES (10104, '1455', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10105, '1455', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10106, '1455', DATE '2021-01-25', 4, 'SP',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10107, '1455', DATE '2020-01-25', 4, 'SP',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (20107, '1455', DATE '2020-01-25', 4, 'SP',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));

INSERT INTO course VALUES (1456, 'Physics', 'Learn about Physics', 3, 'PHYS');
INSERT INTO section VALUES (11109, '1456', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10109, '1456', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10110, '1456', DATE '2021-01-25', 4, 'SP',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (10118, '1456', DATE '2021-01-25', 4, 'SP',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));

INSERT INTO course VALUES (1457, 'Physics Lab', 'Learn about Physics Lab', 1, 'PHYS');
INSERT INTO section VALUES (12109, '1457', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 9:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 9:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (13109, '1457', DATE '2021-08-25', 4, 'FA',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (12110, '1457', DATE '2021-01-25', 4, 'SP',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO section VALUES (12118, '1457', DATE '2021-01-25', 4, 'SP',
    TO_DATE('2000/01/01 15:00:00', 'yyyy/mm/dd hh24:mi:ss'),
    TO_DATE('2000/01/01 15:55:00', 'yyyy/mm/dd hh24:mi:ss'));

-- calculus I requires algebra
INSERT INTO requires VALUES (1453, 1455);

-- calculus I requires trigonometry
INSERT INTO requires VALUES (1454, 1455);

-- physics requires algebra
INSERT INTO requires VALUES (1453, 1456);

-- physics requires trigonometry
INSERT INTO requires VALUES (1454, 1456);

-- physics lab requires algebra
INSERT INTO requires VALUES (1453, 1457);

-- physics lab requires trigonometry
INSERT INTO requires VALUES (1454, 1457);


CREATE OR REPLACE VIEW v_student_info AS
(SELECT c.clientid, 
    fname || ' ' ||  lname AS name,
    age,
    street || ' ' || city || ', ' || admin_div || ' ' || zip AS address, 
    isgraduate,
    status
FROM myclient c
JOIN student s on c.clientid = s.clientid);

CREATE OR REPLACE VIEW v_student_section AS
(
SELECT e.studentid, e.crn, courseid, title, semester, credits, grade
FROM course c 
JOIN section s on s.courseid = c.id
JOIN enrolled e on e.crn = s.crn);

CREATE OR REPLACE VIEW v_student_enrollment AS
(
SELECT s.crn,courseid,title,credits,semester,begin_time,capacity,count(e.crn) enrolled
FROM course c
JOIN section s on c.id = s.courseid
LEFT JOIN enrolled e on s.crn = e.crn
GROUP BY s.crn,courseid,title,credits,semester,begin_time,capacity);

CREATE OR REPLACE TRIGGER SetGPA
AFTER UPDATE ON enrolled 
DECLARE 
    theGPA NUMBER;
    sid NUMBER(5);
    CURSOR c1 IS SELECT studentid FROM enrolled;
BEGIN
    open c1;
    loop    
    fetch c1 into sid;
    EXIT WHEN c1%NOTFOUND;

    SELECT (SUM(e.grade*c.credits)/SUM(c.credits)) INTO theGPA 
    FROM enrolled e
    JOIN section s on e.crn = s.crn
    JOIN course c on c.id = s.courseid
    WHERE studentid = sid;

    UPDATE student
    SET gpa = theGPA
    WHERE studentid = sid;

        IF theGPA < 2.0 then
            UPDATE student
            SET status = 1
            WHERE studentid = sid;
        ELSE 
            UPDATE student
            SET status = 0
            WHERE studentid = sid;
        END IF;
    end loop;
    close c1;
END;
/

CREATE OR REPLACE VIEW v_student_section AS
(
SELECT e.studentid, e.crn, courseid, title, semester, credits, grade
FROM course c 
JOIN section s on s.courseid = c.id
JOIN enrolled e on e.crn = s.crn);

CREATE OR REPLACE VIEW v_section AS
(
    SELECT c.id, c.title, c.description, c.credits, c.subject, s.crn, (s.capacity - COUNT(e.studentid)) remaining,
    s.deadline, s.capacity, s.semester, s.begin_time, s.end_time
    FROM section s
    JOIN course c ON s.courseid = c.id
    LEFT JOIN enrolled e ON s.crn = e.crn
    GROUP BY c.id, c.title, c.description, c.credits, c.subject, s.crn, s.capacity, s.deadline, s.semester,
    s.begin_time, s.end_time
);

CREATE OR REPLACE VIEW v_completed_courses AS
(
    SELECT e.studentid, s.courseid
    FROM enrolled e
    JOIN section s ON e.crn = s.crn
    WHERE e.grade = 2 OR e.grade = 3 OR e.grade = 4
);

-- Returns 0 on success
-- Returns error code otherwise
CREATE OR REPLACE FUNCTION enroll(s_id IN INTEGER, s_crn IN INTEGER)
RETURN INTEGER
AS
    s_rec v_section%rowtype;
    l_count INTEGER;
    l_studentid student.studentid%TYPE;
    l_post requires.postrequisite%TYPE;
BEGIN
    SELECT COUNT(*) INTO l_count FROM v_section WHERE crn = s_crn;

    IF l_count = 0 THEN
        -- Section does not exist
        RETURN 1;
    END IF;

    SELECT * INTO s_rec FROM v_section WHERE crn = s_crn;

    IF s_rec.remaining = 0 THEN
        -- Section at max capacity
        RETURN 2;
    END IF;

-- https://stackoverflow.com/questions/42076161/how-to-check-if-a-set-is-a-subset-of-another-set

    -- In the case that nothing is found, I wish this statment would just assign 0 to 'l_count'
    -- instead of throwing a 'no data found' exception. I don't know why it does this. For now we'll
    -- tell PHP that if the 'enroll' function throws a 'no data found' exception, then it means it
    -- meant to return 3.
    SELECT count (*) INTO l_count
    FROM v_completed_courses c
    JOIN requires r ON c.courseid = r.prerequisite
    WHERE r.postrequisite = s_rec.id AND c.studentid = s_id
    GROUP BY c.studentid, r.postrequisite
    HAVING COUNT(*) = (SELECT COUNT(*) FROM requires r2 WHERE r2.postrequisite = r.postrequisite);

    IF l_count = 0 THEN
        -- Prerequisites are not met
        RETURN 3;
    END IF;

    IF s_rec.deadline < SYSDATE THEN
        -- Past deadline
        RETURN 4;
    END IF;

    SELECT COUNT(*) INTO l_count
    FROM enrolled e
    JOIN section s ON e.crn = s.crn
    WHERE e.studentid = s_id
        AND EXTRACT(YEAR FROM s_rec.deadline) = EXTRACT(YEAR FROM s.deadline)
        AND s_rec.semester = s.semester
        AND to_char(s.begin_time, 'hh24mi')
            BETWEEN to_char(s_rec.begin_time, 'hh24mi') AND to_char(s_rec.end_time, 'hh24mi')
        OR  to_char(s_rec.begin_time, 'hh24mi')
            BETWEEN to_char(s.begin_time, 'hh24mi') AND to_char(s.end_time, 'hh24mi');

    IF l_count > 0 THEN
        -- Section times overlap
        RETURN 5;
    END IF;

    SELECT COUNT(*) INTO l_count
    FROM enrolled e
    JOIN section s ON e.crn = s.crn
    WHERE s_id = e.studentid
        AND s.courseid = s_rec.id
        AND (e.grade = 'NULL' OR e.grade > 1);

    IF l_count > 0 THEN
        -- Class is passed or already enrolled for
        RETURN 5;
    END IF;

    INSERT INTO enrolled VALUES(s_id, s_crn, NULL);

    RETURN 0;
END;
/

SET serveroutput on

-- INSERT INTO enrolled VALUES(2, 20001, 4);
INSERT INTO enrolled VALUES(2, 10002, 3);
INSERT INTO enrolled VALUES(2, 10007, 3);

BEGIN
    dbms_output.put_line(enroll(2, 10104));
    dbms_output.put_line(enroll(2, 10104));
END;
/
COMMIT;
