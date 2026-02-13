<?php

/**
 * @file SportType.php
 *
 * @brief Entité représentant un type de sport dans le système applicatif.
 *
 * Ce fichier définit l'entité Doctrine `SportType`, exposée en tant que
 * ressource API via API Platform. Elle permet de classifier les sports
 * selon un code unique et un libellé descriptif.
 *
 * Cette entité constitue un élément structurant du modèle métier :
 * elle est utilisée notamment comme entité de référence dans des
 * relations (ex. : association ManyToOne avec l’entité `Sport`).
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
use App\Repository\SportTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe SportType
 *
 * Représente une catégorie ou typologie de sport.
 *
 * Responsabilités fonctionnelles :
 * - Définir une classification normalisée des sports.
 * - Garantir l’unicité d’un code métier.
 * - Fournir un libellé descriptif optionnel.
 *
 * Intégration technique :
 * - `#[ORM\Entity]` indique que la classe est persistée par Doctrine.
 * - `repositoryClass` référence `SportTypeRepository`.
 * - `#[ApiResource]` permet l’exposition automatique via API Platform.
 *
 * Contraintes de modélisation :
 * - Le champ `code` est unique en base de données.
 * - Le champ `label` est optionnel (nullable).
 *
 * Architecture :
 * Cette entité agit comme table de référence (lookup table)
 * dans le modèle relationnel et favorise la normalisation
 * des données métier.
 *
 * @category  Entity
 * @package   App\Entity
 * @author    Auteur
 * @license   MIT License
 * @version   Release: 1.0.0
 * @since     2025-02-13
 */
#[ORM\Entity(repositoryClass: SportTypeRepository::class)]
#[ApiResource]
class SportType
{
    /**
     * Identifiant unique du type de sport.
     *
     * Clé primaire auto-générée par la base de données.
     *
     * - Déclarée via `#[ORM\Id]`.
     * - Générée automatiquement avec `#[ORM\GeneratedValue]`.
     * - Nullable tant que l’entité n’est pas persistée.
     *
     * @var int|null Identifiant unique (null avant insertion en base)
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Code unique du type de sport.
     *
     * Représente un identifiant métier court et normalisé
     * (exemple : "COLL", "INDIV", etc.).
     *
     * Contraintes :
     * - Longueur maximale : 50 caractères.
     * - Valeur unique en base (`unique: true`).
     * - Nullable au niveau PHP tant que non initialisé.
     *
     * @var string|null Code métier unique (null si non défini)
     */
    #[ORM\Column(length: 50, unique: true)]
    private ?string $code = null;

    /**
     * Libellé descriptif du type de sport.
     *
     * Champ optionnel permettant de fournir une description
     * lisible du code métier.
     *
     * Contraintes :
     * - Longueur maximale : 255 caractères.
     * - Nullable en base et en PHP.
     *
     * @var string|null Libellé descriptif (null si non défini)
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    /**
     * Retourne l’identifiant unique du type de sport.
     *
     * @return int|null Identifiant ou null si non persisté.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le code unique du type de sport.
     *
     * @return string|null Code métier ou null si non initialisé.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Définit le code unique du type de sport.
     *
     * Conformité PHPStan :
     * - Le paramètre `$code` est strictement non nullable.
     * - La nullabilité de la propriété permet l’instanciation
     *   progressive avant initialisation complète.
     *
     * @param string $code Code métier unique (non nul).
     *
     * @return static Instance courante pour chaînage de méthodes.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Retourne le libellé descriptif du type de sport.
     *
     * @return string|null Libellé ou null si non défini.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Définit le libellé descriptif du type de sport.
     *
     * Le paramètre accepte `null` conformément à la contrainte
     * Doctrine (`nullable: true`).
     *
     * @param string|null $label Libellé descriptif ou null.
     *
     * @return static Instance courante pour chaînage de méthodes.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
