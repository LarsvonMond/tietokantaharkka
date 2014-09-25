CREATE TABLE kayttaja (
    id SERIAL PRIMARY KEY,
    kayttajatunnus text NOT NULL,
    salasana text NOT NULL,
    admin boolean DEFAULT FALSE
);

CREATE TABLE askare (
    id SERIAL PRIMARY KEY,
    kuvaus text NOT NULL,
    tarkeys integer NOT NULL,
    kayttaja_id integer REFERENCES kayttaja (id) ON DELETE cascade ON UPDATE cascade
);

CREATE TABLE luokka (
    id SERIAL PRIMARY KEY,
    nimi text NOT NULL, 
    yliluokka_id integer REFERENCES luokka (id) ON DELETE SET NULL ON UPDATE cascade
);

CREATE TABLE askareenluokka (
    id SERIAL PRIMARY KEY,
    askare_id integer REFERENCES askare (id) ON DELETE cascade ON UPDATE cascade,
    luokka_id integer REFERENCES luokka (id) ON DELETE cascade ON UPDATE cascade
);
