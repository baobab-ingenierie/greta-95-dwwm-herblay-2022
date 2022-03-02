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
    const PATTERN_PASSWORD = '/^([A-Za-z\d@$!%*?&_]{0,30})$/';

    /**
     * Constructeur de la classe
     * @param string $newHost nom du serveur de BDD
     * @param int $newPort port d'écoute du serveur de BDD
     * @param string $newDbname nom de la BDD
     * @param string $newUser nom de l'utilisateur
     * @param string $newPass mot de passe
     */

    public function __construct(
        string $newHost,
        int $newPort,
        string $newDbname,
        string $newUser,
        string $newPass
    ) {
        // Assigne la valeur des arguments aux attributs de la classe
        $this->setHost($newHost);
        $this->setPort($newPort);
        $this->setDbname($newDbname);
        $this->setUser($newUser);
        $this->setPass($newPass);

        // Tente une connexion à la BDD avec l'objet PDO
        try {
            // Se connecte à la BDD
            $dsn = 'mysql:host=%s;dbname=%s;port=%d;charset=utf8';
            $this->cnx = new PDO(
                sprintf($dsn, $this->getHost(), $this->getDbname(), $this->getPort()),
                $this->getUser(),
                $this->getPass()
            );

            // Définit les attributs de connexion (gestion erreurs et renvoi données)
            $this->cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cnx->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->isAuth = true;
        } catch (PDOException $err) {
            throw new PDOException(__CLASS__ . ' - ' . $err->getMessage());
        }
    }

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

    public function getCnx(): PDO
    {
        return $this->cnx;
    }

    // Encapsulation : mutateurs (ou setters)

    /**
     * Change la valeur de l'hôte (ou nom du serveur) de sorte qu'il
     * corresponde aux modèles suivants : 127.0.0.1 ou localhost (RegExp)
     */

    public function setHost(string $newHost)
    {
        // Teste si le nom de l'hôte correspond au motif
        if (preg_match(self::PATTERN_HOST, $newHost) === 1) {
            $this->host = $newHost;
        } else {
            throw new Exception(__CLASS__ . ' - Le nom de l\'hôte ne correspond pas au modèle demandé : ' . self::PATTERN_HOST);
        }
    }

    /**
     * Change la valeur du port du serveur de BDD en respectant les 
     * valeurs autorisées : entre 0 et 65535
     */

    public function setPort(int $newPort)
    {
        if ($newPort >= 0 && $newPort <= 65535) {
            $this->port = $newPort;
        } else {
            throw new Exception(__CLASS__ . ' - Le port doit être compris entre 0 et 65535.');
        }
    }

    public function setDbname(string $newDbname)
    {
        if (preg_match(self::PATTERN_OBJECT, $newDbname) === 1) {
            $this->dbname = $newDbname;
        } else {
            throw new Exception(__CLASS__ . ' - Le nom de la BDD ne correspond pas au modèle demandé : ' . self::PATTERN_OBJECT);
        }
    }

    public function setUser(string $newUser)
    {
        if (preg_match(self::PATTERN_OBJECT, $newUser) === 1) {
            $this->user = $newUser;
        } else {
            throw new Exception(__CLASS__ . ' - Le nom de l\'utilisateur ne correspond pas au modèle demandé : ' . self::PATTERN_OBJECT);
        }
    }

    public function setPass(string $newPass)
    {
        if (preg_match(self::PATTERN_PASSWORD, $newPass) === 1) {
            $this->pass = $newPass;
        } else {
            throw new Exception(__CLASS__ . ' - Le mot de passe ne correspond pas au modèle demandé : ' . self::PATTERN_PASSWORD);
        }
    }

    /**
     * Méthode qui renvoie le résultat d'une requête SQL de type SELECT
     * ou SHOW sous la forme d'un tableau associatif
     * 
     * @author Lesly Lodin <lesly.lodin@baobab-ingenierie.fr>
     * @version $Revision: 1.0$
     * @access public
     * @see https://www.php.net
     * @param string $sql requête SQL paramétrée de type SELECT ou SHOW 
     * @param array $params tableau de paramètres pour la requête
     * @return array résultat de la requête
     */

    public function getResult(string $sql, array $params = array()): array
    {
        try {
            // Teste si la requête est de type SELECT ou SHOW
            $words = explode(' ', strtolower($sql));
            if ($words[0] === 'select' || $words[0] === 'show') {
                // Prépare et exécute la requête SQL
                $res = $this->getCnx()->prepare($sql);
                $res->execute($params);

                // Renvoie le résultat
                return $res->fetchAll();
            } else {
                throw new Exception(__CLASS__ . ' - La requête doit commencer par SELECT ou SHOW.');
            }
        } catch (PDOException $err) {
            throw new PDOException(__CLASS__ . ' - ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui renvoie le résultat d'une requête SQL de type SELECT
     * ou SHOW sous la forme d'un objet JSON sérialisé
     * @param string $sql requête SQL paramétrée de type SELECT ou SHOW 
     * @param array $params tableau de paramètres pour la requête
     * @return string résultat de la requête
     */

    public function getJSON(string $sql, array $params = array()): string
    {
        return json_encode($this->getResult($sql, $params));
    }

    /**
     * Méthode qui renvoie le nom des colonnes d'une requête SQL de
     * type SELECT ou SHOW
     */

    public function getColumnsName(string $sql, array $params = array()): array
    {
        $res = $this->getCnx()->prepare($sql);
        $res->execute($params);
        $cols = array();
        for ($i = 0; $i < $res->columnCount(); $i++) {
            $meta = $res->getColumnMeta($i);
            array_push($cols, $meta['name']);
        }
        return $cols;
    }
}
