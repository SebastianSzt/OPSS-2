CREATE TABLE users(
    id          INTEGER		PRIMARY KEY	AUTOINCREMENT,
    imie    	VARCHAR(100)	NOT NULL,
    nazwisko    VARCHAR(100)	NOT NULL,
    email    	VARCHAR(100)	NOT NULL,
    login    	VARCHAR(20)     NOT NULL,
    haslo    	VARCHAR(20)     NOT NULL,
    dysk         VARCHAR(20)     NOT NULL,
    UNIQUE (login)
);

INSERT INTO users (imie, nazwisko, email, login, haslo, dysk) VALUES ('krzysztof', 'kowalski', 'krzychu@gmail.com', 'krzysztof', 'supertajne', 'Prywatny');
INSERT INTO users (imie, nazwisko, email, login, haslo, dysk) VALUES ('eustachy', 'malina', 'eustachy123@gmail.com', 'eustachy', 'malina', 'Publiczny');
