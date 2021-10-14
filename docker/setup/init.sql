DROP TABLE IF EXISTS users;
CREATE TABLE users(
    id       INTEGER PRIMARY KEY,
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    role     TEXT DEFAULT 'employee',
    active   BOOLEAN DEFAULT 1
);

DROP TABLE IF EXISTS emails;
CREATE TABLE emails(
    id              INTEGER PRIMARY KEY,
    sender          INTEGER NOT NULL,
    receiver        INTEGER NOT NULL,
    subject         TEXT NOT NULL,
    message         TEXT NOT NULL,
    received_date   TEXT NOT NULL,
    parent_email    INTEGER NULL,

    FOREIGN KEY (sender)
        REFERENCES users (id)
            ON DELETE CASCADE 
            ON UPDATE NO ACTION,
    FOREIGN KEY (receiver)
        REFERENCES users (id)
            ON DELETE CASCADE 
            ON UPDATE NO ACTION,
    FOREIGN KEY (parent_email)
        REFERENCES emails (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);
