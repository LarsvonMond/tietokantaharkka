INSERT INTO kayttajat (kayttajatunnus, salasana, admin) VALUES ('admin', 'kermanekka', TRUE);
INSERT INTO kayttajat (kayttajatunnus, salasana) VALUES ('Esko', 'eskoboy69');
INSERT INTO kayttajat (kayttajatunnus, salasana) VALUES ('Hitler', 'lebensraum');

INSERT INTO askareet (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Kauf Sauerkraut', 1);
INSERT INTO askareet (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Kauf Panzerkampfwägen', 2);
INSERT INTO askareet (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Besuche Luftwaffe', 2);
INSERT INTO askareet (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Rotwein für Eva', 3);
INSERT INTO askareet (kayttaja_id, kuvaus, tarkeys) VALUES (2, 'Ruoki Karvinen', 3);
INSERT INTO askareet (kayttaja_id, kuvaus, tarkeys) VALUES (3, 'Juutalaiskysymys', 5);
INSERT INTO askareet (kayttaja_id, kuvaus, tarkeys) VALUES (1, 'Poista Hitlerin tili', 4);

INSERT INTO luokat (nimi) VALUES ('Kauppa');
INSERT INTO luokat (nimi, yliluokka_id) VALUES ('Asekauppa', 1);
INSERT INTO luokat (nimi) VALUES ('Koti');

INSERT INTO askareidenluokat (askare_id, luokka_id) VALUES (1, 1);
INSERT INTO askareidenluokat (askare_id, luokka_id) VALUES (2, 2);
INSERT INTO askareidenluokat (askare_id, luokka_id) VALUES (4, 1);
