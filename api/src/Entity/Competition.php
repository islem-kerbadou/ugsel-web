<?php

/**
 * @file Competition.php
 *
 * @brief Entité représentant une compétition dans le système applicatif.
 *
 * Ce fichier définit l'entité Doctrine `Competition`, exposée en tant que
 * ressource API via API Platform. Elle modélise une compétition identifiable
 * par un identifiant unique et caractérisée par un nom.
 *
 * Cette classe est persistée en base de données grâce à Doctrine ORM
 * et automatiquement exposée sous forme d’API REST par API Platform.
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
use App\Repository\CompetitionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Competition
 *
 * Représente une compétition dans le domaine métier de l’application.
 *
 * Responsabilités fonctionnelles :
 * - Modéliser une entité métier correspondant à une compétition.
 * - Assurer la persistance des données via Doctrine ORM.
 * - Permettre l’exposition automatique des opérations CRUD via API Platform.
 *
 * Intégration technique :
 * - L’attribut `#[ORM\Entity]` déclare cette classe comme entité Doctrine.
 * - Le paramètre `repositoryClass` référence `CompetitionRepository`
 *   pour les opérations de requêtage personnalisées.
 * - L’attribut `#[ApiResource]` active l’exposition automatique
 *   en tant que ressource REST.
 *
 * Architecture :
 * Cette entité appartient à la couche Domaine/Infrastructure (Entity)
 * et constitue une représentation persistante du concept métier
 * de compétition.
 *
 * @category  Entity
 * @package   App\Entity
 * @author    Auteur
 * @license   MIT License
 * @version   Release: 1.0.0
 * @since     2025-02-13
 */
#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
#[ApiResource]
class Competition
{
    /**
     * Identifiant unique de la compétition.
     *
     * Clé primaire auto-générée par la base de données.
     *
     * - Marquée comme identifiant via `#[ORM\Id]`.
     * - Générée automatiquement grâce à `#[ORM\GeneratedValue]`.
     * - Nullable uniquement tant que l’entité n’est pas persistée.
     *
     * @var int|null Identifiant unique (null avant persistance en base)
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom de la compétition.
     *
     * Représente l’intitulé officiel de la compétition dans le système.
     *
     * Contraintes :
     * - Type : chaîne de caractères.
     * - Longueur maximale : 255 caractères.
     * - Nullable tant qu’aucune valeur n’est explicitement assignée.
     *
     * @var string|null Nom de la compétition (null si non initialisé)
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * Retourne l’identifiant unique de la compétition.
     *
     * Cette méthode fournit l’accès en lecture à la clé primaire
     * générée par Doctrine.
     *
     * @return int|null Identifiant de la compétition ou null si
     *                  l’entité n’est pas encore persistée.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom de la compétition.
     *
     * Permet d’accéder à la valeur métier représentant le nom
     * de la compétition.
     *
     * @return string|null Nom de la compétition ou null si non défini.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom de la compétition.
     *
     * Cette méthode affecte une nouvelle valeur au champ métier `name`.
     *
     * Conformité PHPStan :
     * - Le paramètre `$name` est strictement typé `string` (non nullable).
     * - La propriété reste déclarée nullable pour permettre
     *   l’instanciation progressive par Doctrine.
     *
     * @param string $name Nom de la compétition (non nul).
     *
     * @return static Retourne l’instance courante afin de permettre
     *                le chaînage de méthodes (fluent interface).
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
