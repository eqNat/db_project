DROP TABLE IF EXISTS student;
/* or we can replace the above line by adding 'IF NOT EXISTS' to the
user creation statement */

/* we use the name 'web_user' because 'user' is not a valid name in
Oracle Database */
CREATE TABLE web_user (
    username VARCHAR(20),
    /* size of 255 in case we use a password hash */
    password VARCHAR(255), 
    type ENUM('student', 'administrator')
);

INSERT INTO web_user VALUES ('root', 'toor', 'administrator');
