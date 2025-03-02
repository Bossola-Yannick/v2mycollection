-- -- Suppression des données des tables
-- DELETE FROM famille;
DELETE FROM user;

-- -- Réinitialisation de l'auto-incrémentation
-- ALTER TABLE famille AUTO_INCREMENT = 1;
ALTER TABLE user AUTO_INCREMENT = 1;

-- -- Insertion de données dans les tables
-- INSERT INTO famille (id, nom) VALUES
-- (NULL, "bossola"),
-- (NULL, "delaire");


INSERT INTO user (id, login, password, role) VALUES 
(NULL, 'yannick', '123', 'user'),
(NULL, 'gwen', '123', 'user'),
(NULL, 'sanzo', '123', 'user'),
(NULL, 'cassandra', '123', 'user');
-- (NULL, 'marine', '123', 'user'),
-- (NULL, 'morgane', '123', 'user');

