<?php

/**
 * Classe fille de la classe Database ayant pour but de pratiquer
 * le CRUD sur une table passée dans le constructeur
 */

include_once 'database.class.php';

final class Model extends Database
{
    // Attributs privés
    private $db = null;
    private $table = '';

    /**
     * Constructeur de la classe fille
     * @param string $newHost nom du serveur de BDD
     * @param int $newPort port d'écoute du serveur de BDD
     * @param string $newDbname nom de la BDD
     * @param string $newUser nom de l'utilisateur
     * @param string $newPass mot de passe
     * @param string $newTable table de travail
     */

    public function __construct(
        string $newHost,
        int $newPort,
        string $newDbname,
        string $newUser,
        string $newPass,
        string $newTable
    ) {
        $this->db = new Database($newHost, $newPort, $newDbname, $newUser, $newPass);
        $this->setTable($newTable);
    }

    // Encapsulation : accesseurs et mutateurs (getters et setters)
    public function getTable(): string
    {
        return $this->table;
    }

    public function setTable(string $newTable)
    {
        // Tester si nom table correspond au motif PATTERN_OBJECT de la classe mère
        if (preg_match(parent::PATTERN_OBJECT, $newTable)) {
            $this->table = $newTable;
        } else {
            throw new Exception(__CLASS__ . ' - Le nom de la table ne correspond pas au modèle demandé : ' . parent::PATTERN_OBJECT);
        }
    }

    // Méthodes publiques du CRUD

    /**
     * Méthode qui renvoie toutes les lignes de la table en cours (R comme Read)
     * @return array résultat de la requête SELECT sous la forme d'un tableau associatif
     */

    public function getRows(): array
    {
        try {
            $sql = 'SELECT * FROM ' . $this->getTable();
            return $this->db->getResult($sql);
        } catch (Exception $err) {
            throw new Exception(__CLASS__ . ' - ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui renvoie une seule ligne de la table en cours (R comme Read)
     * @param string $pk nom de la colonne PK
     * @param string $val valeur de la colonne PK
     * @return array résultat de la requête SELECT sous la forme d'un tableau associatif
     */

    public function getRow(string $pk, string $val): array
    {
        try {
            $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE ' . $pk . '=?';
            $params = array($val);
            return $this->db->getResult($sql, $params);
        } catch (Exception $err) {
            throw new Exception(__CLASS__ . ' - ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui ajoute une nouvelle ligne dans la table en cours (C comme Create)
     * @param array $post tableau associatif de type POST contenant les données à insérer
     * @return bool
     */

    public function insert(array $post): bool
    {
        try {
            // Remplit le tableau des paramètres de la requête avec $post
            foreach ($post as $key => $val) {
                $params[':' . $key] = htmlspecialchars($val);
            }

            // Prépare la requête
            $sql = sprintf(
                'INSERT INTO %s(%s) VALUES(%s)',
                $this->getTable(),
                implode(',', array_keys($post)),
                implode(',', array_keys($params))
            );

            // Exécute la requête
            $res = $this->db->getCnx()->prepare($sql);
            return $res->execute($params);
        } catch (Exception $err) {
            throw new Exception(__CLASS__ . ' - ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui met à jour une ligne dans la table en cours à partir d'un tableau associatif de type POST (U pour Update)
     * @param array $post tableau associatif de type POST contenant les données à mettre à jour
     * @param string $pk colonne clé primaire
     * @param string $val valeur de la clé primaire
     * @return bool
     */

    public function update(array $post, string $pk, string $id): bool
    {
        try {
            // Remplit le tableau des paramètres de la requête avec $post
            foreach ($post as $key => $val) {
                $params[':' . $key] = htmlspecialchars($val);
                $assign[] = $key . '=:' . $key;
            }
            $params[':pk'] = $id;

            // Prépare la requête SQL
            $sql = sprintf(
                'UPDATE %s SET %s WHERE %s=:pk',
                $this->getTable(),
                implode(',', $assign),
                $pk
            );

            // Exécute la requête SQL
            $res = $this->db->getCnx()->prepare($sql);
            return $res->execute($params);
        } catch (Exception $err) {
            throw new Exception(__CLASS__ . ' - ' . $err->getMessage());
        }
    }
}
