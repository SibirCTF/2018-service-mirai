CREATE DATABASE service;
\c service;

CREATE TABLE IF NOT EXISTS users (id SERIAL PRIMARY KEY UNIQUE, login TEXT NOT NULL UNIQUE, email TEXT NOT NULL, name TEXT NOT NULL, pass_hash TEXT NOT NULL, avatar TEXT NOT NULL);

CREATE TABLE IF NOT EXISTS sections (id SERIAL PRIMARY KEY UNIQUE, name TEXT NOT NULL, description TEXT NOT NULL);

CREATE TABLE IF NOT EXISTS threads (id SERIAL UNIQUE, title TEXT NOT NULL, id_section INTEGER NOT NULL, PRIMARY KEY(id, id_section), CONSTRAINT threads_sections_id_section_fkey FOREIGN KEY(id_section) REFERENCES sections(id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS messages (id SERIAL UNIQUE, id_user INTEGER NOT NULL, id_thread INTEGER NOT NULL, message TEXT NOT NULL, image TEXT , PRIMARY KEY(id, id_user, id_thread), CONSTRAINT messages_users_id_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE, CONSTRAINT messages_threads_id_thread_fkey FOREIGN KEY(id_thread) REFERENCES threads(id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE);

INSERT INTO sections(name, description) VALUES ('anime','Что, господа, мультипликационная японская анимация?');
INSERT INTO sections(name, description) VALUES ('bullshit','Бред');
INSERT INTO sections(name, description) VALUES ('cosplay','Обсуждение косплея в целом');
INSERT INTO sections(name, description) VALUES ('manga','Обсуждение манги');

INSERT INTO users(login, email, name, pass_hash, avatar) VALUES ('layz', 'layz@sibir.wtf', 'Даниил', 'da9c3ec58071d56ecabf0b77a89a91265408a46baaa4e7d4f6a475a400bfe026', 'avatars/fa25dce019a116e4036f41f656fb427d.png');

INSERT INTO users(login, email, name, pass_hash, avatar) VALUES ('stelse', 'stelse@sibir.wtf', 'Мария', '55a8ba0c0b642966cc1b415c961717e01e1a716fa902edd77faa94b9092c2bdd', 'avatars/db7ac08dea5a7c7ba7865aabb44ff626.png');

INSERT INTO threads(title, id_section) VALUES ('Clannad', 1);
INSERT INTO threads(title, id_section) VALUES ('Лучший косплей, который я видел', 3);

INSERT INTO messages(id_user, id_thread, message, image) VALUES (1, 1, 'Делимся впечатлениями о данном тайтле', 'images/38949cf24c25d68b7b01052f95173c41.jpg');
INSERT INTO messages(id_user, id_thread, message, image) VALUES (1, 2, 'Просто отставлю это тут', 'images/8115a3fe398285ffc70dddc4b4a1aa65.jpg');
INSERT INTO messages(id_user, id_thread, message, image) VALUES (2, 2, 'Поддерживаю. Котики -- лучшие', 'images/d753c18a963b19db99abbdf964f3d816.jpeg');
