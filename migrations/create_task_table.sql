CREATE TABLE task (
    id int PRIMARY KEY NOT NULL,
    username varchar(255) NOT NULL,
    email varchar(255),
    text text NOT NULL,
    isEdited tinyint(1) DEFAULT 0 NOT NULL,
    isCompleted tinyint(1) DEFAULT 0 NOT NULL,
);
