-- Etapes dans l'exécutio d'un requête SQL :
-- 1 Parsing (analyse) : gestion des erreurs syntaxiques et sémantiques
-- 2 Executing : aller-retour entre client et serveur
-- 3 Fetching : lecture ligne à ligne du résultat

USE information_schema
;

SHOW tables
;

-- Liste des tables de la BDD herblay
SELECT table_name, table_type, table_rows, create_time
FROM information_schema.tables
WHERE table_schema = 'herblay'
;

-- Liste des colonnes PK de la BDD herblay
SELECT *
FROM information_schema.columns
WHERE table_schema = 'herblay'
AND column_key = 'PRI'
-- AND ordinal_position <= 1
;

-- Liste des tables ayant des PK multiples dans toutes les BDD
SELECT table_name
FROM information_schema.columns
WHERE ordinal_position > 1
AND column_key = 'PRI'
-- AND table_schema = 'herblay'
;

-- Requête finale
SELECT t.table_name, t.table_type, t.table_rows, t.create_time, c.column_name
FROM information_schema.tables t
JOIN information_schema.columns c
ON t.table_schema = c.table_schema
AND t.table_name = c.table_name
WHERE t.table_schema = 'herblay'
AND c.column_key = 'PRI'
AND t.table_name NOT IN (SELECT table_name
FROM information_schema.columns
WHERE ordinal_position > 1
AND column_key = 'PRI')
;
