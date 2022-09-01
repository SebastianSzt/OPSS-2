CREATE TABLE users(
    id          INT             NOT NULL,
    username    VARCHAR(20)     NOT NULL,
    password    VARCHAR(20)     NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (username)
);

INSERT INTO users VALUES (0, 'user1', 'password_for_user1');
INSERT INTO users VALUES (1, 'user2', 'password_for_user2');
INSERT INTO users VALUES (2, 'krzysztof', 'supertajne');
INSERT INTO users VALUES (3, 'eustachy', 'malina');