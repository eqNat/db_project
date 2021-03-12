/* we use the name 'web_user' because 'user' is not a valid name in
Oracle Database */
CREATE TABLE web_user (
    id VARCHAR2(20),
    /* size of 255 in case we use a password hash */
    password VARCHAR2(255), 
    /*
    Oracle Database does not support ENUM. We need to find an alternative.
    type ENUM('student', 'administrator')
    */
    PRIMARY KEY (id)
);

CREATE table web_user_session (
    id VARCHAR2(32),
    web_user_id VARCHAR2(20),
    session_date DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (web_user_id)
        REFERENCES web_user(id)
        ON DELETE CASCADE
);

INSERT INTO web_user VALUES ('root', 'toor'/*, 'administrator'*/);
