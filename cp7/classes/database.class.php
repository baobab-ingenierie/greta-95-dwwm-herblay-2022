<?php

/**
 * Mini-framework permettant la connexion à une BDD MySQL/MariaDB pour y
 * lire, écrire, modifier et supprimer des données.
 */

class Database
{
    // Attributs privés
    private $host = '';
    private $port;
    private $dbname;
    private $user;
    private $pass;
    private $cnx;
    private $isAuth = false;

    // Constantes de classe
    const PATTERN_HOST = '/^([A-Za-z]{1,30})$|^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/';
    const PATTERN_OBJECT = '/^([A-Za-z_]{1,30})$/';
    const PATTERN_PASSWORD = '/^([A-Za-z\d@$!%*?&]{,30})$/';

    // Encapsulation : Accesseurs (ou getters)
    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getDbname(): string
    {
        return $this->dbname;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    // Encapsulation : mutateurs (ou setters)

    /**
     * Change la valeur de l'hôte (ou nom du serveur) de sorte qu'il
     * corresponde aux modèles suivants :
     * 127.0.0.1 ou localhost
     */

    public function setHost(string $newHost)
    {
        // Teste si le nom de l'hôte correspond au motif
        if (preg_match(self::PATTERN_HOST, $newHost) === 1) {
            $this->host = $newHost;
        } else {
            throw new Exception(__CLASS__ . ' : Le nom de l\'hôte ne correspond pas au modèle demandé - ' . self::PATTERN_HOST);
        }
    }
}
