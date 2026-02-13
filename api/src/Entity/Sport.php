<?php

/**
 * @file Sport.php
 *
 * @brief Entité représentant un sport dans le système applicatif.
 *
 * Ce fichier définit l'entité Doctrine `Sport`, exposée en tant que
 * ressource API via API Platform. Elle modélise un sport identifiable
 * par un identifiant unique, caractérisé par un nom et associé à un type
 * de sport (`SportType`).
 *
 * Cette classe est persistée en base de données grâce à Doctrine ORM
 * et automatiquement exposée sous forme d’API REST via API Platform.
 *
 * La relation avec `SportType` permet de structurer les sports
 * selon une classification métier.
 *
 * PHP version 8.3
 *
 * @category  Entity
 * @package   App\Entity
 * @author    Auteur
 * @license   MIT License
 * @version   Release: 1.0.0
 * @link      https://api-platform.com/docs/
 * @since     2025-02-13
 */

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Sport
 *
 * Représente un sport dans le domaine métier de l’application.
 *
 * Responsabilités fonctionnelles :
 * - Modéliser un sport identifiable.
 * - Associer un sport à une catégorie (`SportType`).
 * - Permettre la persistance et la récupération des données via Doctrine.
 * - Exposer automatiquement l’entité via API Platform.
 *
 * Intégration technique :
 * - `#[ORM\Entity]` déclare la classe comme entité Doctrine.
 * - `repositoryClass` référence `SportRepository`.
 * - `#[ApiResource]` active l’exposition REST automatique.
 * - La relation `#[ORM\ManyToOne]` établit une association
 *   vers l’entité `SportType`.
 *
 * Architecture :
 * Cette entité appartient à la couche Domaine/Infrastructure.
 * Elle participe à la structuration des données métier
 * relatives aux disciplines sportives.
 *
 * @category  Entity
 * @package   App\Entity
 * @author    Auteur
 * @license   MIT License
 * @version   Release: 1.0.0
 * @since     2025-02-13
 */
#[ORM\Entity(repositoryClass: SportRepository::class)]
#[ApiResource]
class Sport
{
    /**
     * Identifiant unique du sport.
     *
     * Clé primaire auto-générée par la base de données.
     *
     * - Déclarée avec `#[ORM\Id]`.
     * - Générée automatiquement via `#[ORM\GeneratedValue]`.
     * - Nullable uniquement avant persistance.
     *
     * @var int|null Identifiant unique (null avant insertion en base)
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom du sport.
     *
     * Représente l’intitulé officiel de la discipline sportive.
     *
     * Contraintes :
     * - Type : chaîne de caractères.
     * - Longueur maximale : 255 caractères.
     * - Nullable tant qu’aucune valeur n’est définie.
     *
     * @var string|null Nom du sport (null si non initialisé)
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * Type de sport associé.
     *
     * Relation ManyToOne vers l’entité `SportType`.
     *
     * Contraintes Doctrine :
     * - Association obligatoire en base (`nullable: false`).
     * - Nullable au niveau PHP pour permettre l’instanciation
     *   progressive par Doctrine avant persistance.
     *
     * Rôle métier :
     * Permet de classifier les sports selon une typologie
     * (exemple : sport collectif, individuel, mécanique, etc.).
     *
     * @var SportType|null Type de sport associé (null avant initialisation)
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?SportType $sportType = null;

    /**
     * Retourne l’identifiant unique du sport.
     *
     * @return int|null Identifiant du sport ou null si non persisté.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom du sport.
     *
     * @return string|null Nom du sport ou null si non défini.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom du sport.
     *
     * Conformité PHPStan :
     * - Le paramètre `$name` est strictement non nullable.
     *
     * @param string $name Nom du sport (non nul).
     *
     * @return static Instance courante pour chaînage de méthodes.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Retourne le type de sport associé.
     *
     * @return SportType|null Type associé ou null si non encore défini.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getSportType(): ?SportType
    {
        return $this->sportType;
    }

    /**
     * Définit le type de sport associé.
     *
     * Bien que la contrainte Doctrine impose une valeur non nulle
     * en base (`nullable: false`), le paramètre accepte `null`
     * afin de rester compatible avec le cycle de vie Doctrine
     * (instanciation partielle).
     *
     * @param SportType|null $sport_type Type de sport à associer.
     *
     * @return static Instance courante pour chaînage de méthodes.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function setSportType(?SportType $sport_type): static
    {
        $this->sportType = $sport_type;

        return $this;
    }
}
