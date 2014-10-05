INSERT INTO kayttaja (kayttajatunnus, salasana, admin) VALUES ('admin', 'kermanekka', TRUE);
INSERT INTO kayttaja (kayttajatunnus, salasana, admin) VALUES ('Esko', 'eskoboy69', FALSE);
INSERT INTO kayttaja (kayttajatunnus, salasana, admin) VALUES ('Hitler', 'lebensraum', FALSE);

INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Kauf Sauerkraut', 1);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Kauf Panzerkampfwägen', 2);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Besuche Luftwaffe', 2);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Rotwein für Eva', 3);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (2, 'Ruoki Karvinen', 3);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (1, 'Poista Hitlerin tili', 1);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Juutalaiskysymys', 5);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (2, 'Osta nötköttiä', 1);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (2, 'Osta Cointreauta', 2);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (2, 'Valita mädästä turskasta', 2);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (2, 'Selvitä mitä rommeja valikoimassa on', 4);
INSERT INTO askare (kayttaja_id, kuvaus, tarkeys) VALUES (2, 'Palauta pullot', 4);

INSERT INTO luokka (nimi) VALUES ('Kauppa');
INSERT INTO luokka (nimi, yliluokka_id) VALUES ('Asekauppa', 1);
INSERT INTO luokka (nimi) VALUES ('Koti');

INSERT INTO askareenluokka (askare_id, luokka_id) VALUES (1, 1);
INSERT INTO askareenluokka (askare_id, luokka_id) VALUES (2, 2);
INSERT INTO askareenluokka (askare_id, luokka_id) VALUES (4, 1);
