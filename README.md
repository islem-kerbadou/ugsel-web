# Remake_UGSEL

## Présentation du projet
**Remake_UGSEL** est un projet réalisé dans le cadre du cours de maintenance **R6.A.06**.
L'objectif est de recréer le projet UGSEL entièrement à partir de zéro pour proposer une version plus claire, plus propre, et plus facile à maintenir et à faire évoluer.

Le projet est divisé en deux parties principales :
1.  **Backend (API)** : Une API REST réalisée avec Symfony et API Platform.
2.  **Frontend (Web)** : Une interface utilisateur réalisée avec React et TypeScript.

---

## Architecture de l'API (Entités)

Le projet s'articule autour des entités principales suivantes, définies dans l'API :

### 1. Gestion des Types de Sports (SportType)
Permet de définir des catégories de sports (ex: Collectif / Individuel).
* **code** : Identifiant unique du type (ex: 'CO').
* **label** : Libellé descriptif optionnel.

### 2. Gestion des Sports (Sport)
Permet de gérer la liste des disciplines sportives.
* **name** : Nom du sport.
* **sportType** : Relation vers un ou plusieurs Types de Sports.

### 3. Gestion des Compétitions (Competition)
Permet de créer des compétitions spécifiques rattachées à un sport.
* **name** : Nom de la compétition.
* **sport** : Relation Many-to-One vers le Sport concerné.

### 4. Gestion des Championnats (Championship)
Niveau le plus fin, permet d'organiser un championnat au sein d'une compétition.
* **name** : Nom du championnat.
* **competition** : Relation Many-to-One vers la Compétition parente.

---

## Technologies Utilisées

### Stack Technique

#### Back-end (Dossier `api/`)
* **Framework** : Symfony (v6+) avec API Platform
* **Base de données** : PostgreSQL
* **ORM** : Doctrine

#### Front-end (Dossier `frontend/`)
* **Framework** : React (v19+)
* **Langage** : TypeScript
* **State Management** : Zustand
* **HTTP Client** : Axios
* **UI Framework** : Bootstrap 5

### Qualité & Tests
* **Tests unitaires** : PHPUnit
* **Linter & Analyse statique** :
    * **PHPStan** : Pour vérifier la logique du code PHP.
    * **CodeSniffer** : Pour assurer la conformité aux standards de code ("beauté" du code).
* **Documentation** : Doxygen

### Pourquoi ces choix ?
* **Symfony** : Choisi pour sa scalabilité et robustesse adaptées à l'ampleur du projet.
* **PostgreSQL** : Base de données performante et fiable, parfaitement intégrée à l'écosystème Symfony.
* **React & TypeScript** : Offre une expérience utilisateur dynamique, un typage fort pour la maintenabilité et un écosystème riche.
* **Bootstrap** : Pour accélérer l'intégration des interfaces web et assurer le responsive design.
* **Doxygen** : Préféré à PHPDoc pour sa simplicité de configuration et sa génération de documentation complète.

---

## Installation et Lancement

### Prérequis global
* PHP 8.2+
* Composer
* PostgreSQL
* Node.js (v18+ recommandé) et npm
* Symfony CLI (recommandé)

### 1. Installation du Backend (API)

Le code source de l'API se trouve dans le dossier `api/`.

1.  **Se placer dans le dossier de l'API** :
    ```bash
    cd api
    ```

2.  **Installer les dépendances PHP** :
    ```bash
    composer install
    ```

3.  **Configuration de la base de données** :
    Copiez le fichier `.env` en `.env.local` et adaptez la ligne `DATABASE_URL` avec vos identifiants PostgreSQL.
    ```bash
    # Exemple dans .env.local
    DATABASE_URL="postgresql://user:password@127.0.0.1:5432/ugsel_db?serverVersion=16&charset=utf8"
    ```

4.  **Créer la base de données et les tables** :
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5.  **Lancer le serveur API** :
    ```bash
    symfony server:start
    # L'API sera accessible sur [http://127.0.0.1:8000](http://127.0.0.1:8000)
    ```

### 2. Installation du Frontend (Web)

Le code source du frontend se trouve dans le dossier `frontend/`.

1.  **Ouvrir un nouveau terminal et se placer dans le dossier frontend** :
    ```bash
    cd frontend
    ```

2.  **Installer les dépendances Node.js** :
    ```bash
    npm install
    ```

3.  **Lancer le serveur de développement React** :
    ```bash
    npm start
    ```
    L'application s'ouvrira automatiquement dans votre navigateur à l'adresse `http://localhost:3000`.

> **Note :** Le frontend est configuré pour communiquer avec l'API sur `http://localhost:8000`. Assurez-vous que le serveur Symfony est bien lancé.