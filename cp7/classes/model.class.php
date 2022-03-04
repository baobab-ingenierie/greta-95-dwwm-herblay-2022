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
}
