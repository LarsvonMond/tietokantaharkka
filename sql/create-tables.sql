CREATE TABLE kayttajat (
    id SERIAL PRIMARY KEY,
    kayttajatunnus text NOT NULL,
    salasana text NOT NULL,
    admin boolean DEFAULT FALSE,
