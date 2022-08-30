CREATE TABLE comments(
    id          INTEGER		PRIMARY KEY	AUTOINCREMENT,
    dysk    	VARCHAR(20)     NOT NULL,
    nick    	VARCHAR(20)     NOT NULL,
    tresc    	TEXT(250)     NOT NULL,
    data        TEXT(20)     NOT NULL,
    UNIQUE (id)
);