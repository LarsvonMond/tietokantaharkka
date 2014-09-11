CREATE TABLE kayttajat (
    id SERIAL PRIMARY KEY,
    kayttajatunnus text NOT NULL,
    salasana text NOT NULL,
    admin boolean DEFAULT FALSE
)

CREATE TABLE askareet (
    id SERIAL PRIMARY KEY,
    kuvaus text NOT NULL,
    tarkeys integer NOT NULL,
    kayttaja_id integer REFERENCES kayttajat (id) ON DELETE cascade ON UPDATE cascade
)

CREATE TABLE luokat (
    id SERIAL PRIMARY KEY,
    nimi text NOT NULL, 
    yliluokka_id integer REFERENCES luokat (id) ON DELETE SET NULL ON UPDATE cascade
)

CREATE TABLE askereidenluokat (
    id SERIAL PRIMARY KEY,
    askare_id integer REFERENCES askareet (id) ON DELETE cascade ON UPDATE cascade,
    luokka_id integer REFERENCES luokat (id) ON DELETE cascade ON UPDATE cascade
)
