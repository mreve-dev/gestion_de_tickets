CREATE DATABASE lc_tickets;
USE lc_tickets;
CREATE TABLE comptes (id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT, identifiant VARCHAR(32) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, role ENUM('usager', 'dev') NOT NULL, PRIMARY KEY(id));
CREATE TABLE tickets (id SMALLINT unsigned NOT NULL AUTO_INCREMENT, compte_id TINYINT unsigned NOT NULL, titre VARCHAR(255) NOT NULL,description TEXT NOT NULL, statut ENUM('NOUVEAU', 'NONRESOLU', 'RESOLU','CLOS') NOT NULL, date_creation DATETIME NOT NULL DEFAULT NOW(), PRIMARY KEY(id));
CREATE TABLE messages (id SMALLINT unsigned NOT NULL AUTO_INCREMENT, ticket_id SMALLINT unsigned NOT NULL, compte_id TINYINT UNSIGNED NOT NULL, contenu text NOT NULL, date_creation DATETIME NOT NULL DEFAULT NOW(), PRIMARY KEY(id));
ALTER TABLE messages ADD CONSTRAINT message_ticket FOREIGN KEY (ticket_id) REFERENCES tickets (id);
ALTER TABLE messages ADD CONSTRAINT message_compte FOREIGN KEY (compte_id) REFERENCES comptes (id);
ALTER TABLE tickets ADD CONSTRAINT ticket_compte FOREIGN KEY (compte_id)REFERENCES comptes (id);
INSERT INTO comptes (identifiant, mot_de_passe, role) VALUES ('alice','$2y$10$UGK6vSeQZVMsPjugPu1RqeGLPXUjVMh9PIfKiUCBFiQyTwhbFyWpG', 'dev'),('bob', '$2y$10$joLMl9zXlQ5WQZkmHiaPb.w5eulR.UpkPAKwHPB6LG2a2ESB3fqfy','usager'), ('charles', '$2y$10$Z6REsbSHOLCI54yKvfbQ0.zJurMIFimin2Y.sqgwSN8WtJzTfeCAO', 'usager');