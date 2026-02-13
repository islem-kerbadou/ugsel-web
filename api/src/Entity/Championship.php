<?php

/**
 * @file Championship.php
 *
 * @brief Entité représentant un championnat dans le système applicatif.
 *
 * Ce fichier définit l'entité Doctrine `Championship`, exposée en tant que
 * ressource API via API Platform. Elle modélise un championnat identifié
 * de manière unique et caractérisé par un nom.
 *
 * Cette classe est persistée en base de données grâce à Doctrine ORM
 * et automatiquement exposée sous forme d’API REST grâce à l’attribut
 * `ApiResource`.
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
use App\Repository\ChampionshipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Championship
 *
 * Représente un championnat dans le domaine métier de l’application.
 *
 * Cette entité est :
 * - Persistée en base de données via Doctrine ORM.
 * - Exposée automatiquement comme ressource API grâce à API Platform.
 *
 * Responsabilités principales :
 * - Modéliser un championnat identifiable.
 * - Garantir l’intégrité des données persistées (identifiant primaire auto-généré).
 * - Fournir une interface d’accès (getters/setters) conforme aux standards
 *   Doctrine et aux bonnes pratiques orientées objet.
 *
 * Intégration technique :
 * - L’attribut `#[ORM\Entity]` indique que la classe est une entité Doctrine.
 * - Le paramètre `repositoryClass` associe l’entité à `ChampionshipRepository`.
 * - L’attribut `#[ApiResource]` permet l’exposition automatique via API Platform.
 *
 * @category  Entity
 * @package   App\Entity
 * @author    Auteur
 * @license   MIT License
 * @version   Release: 1.0.0
 * @since     2025-02-13
 */
#[ORM\Entity(repositoryClass: ChampionshipRepository::class)]
#[ApiResource]
class Championship
{
    /**
     * Identifiant unique du championnat.
     *
     * Clé primaire auto-générée par la base de données.
     *
     * - Générée automatiquement grâce à `#[ORM\GeneratedValue]`.
     * - Non modifiable manuellement.
     * - Nullable uniquement avant la persistance en base.
     *
     * @var int|null Identifiant unique (null avant insertion en base)
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom du championnat.
     *
     * Champ métier représentant l’intitulé officiel du championnat.
     *
     * Contraintes :
     * - Longueur maximale : 255 caractères.
     * - Nullable tant qu’aucune valeur n’est définie.
     *
     * @var string|null Nom du championnat (null si non initialisé)
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * Retourne l’identifiant unique du championnat.
     *
     * Cette méthode permet d’accéder à la clé primaire générée par Doctrine.
     *
     * @return int|null Identifiant du championnat ou null si l'entité
     *                  n’est pas encore persistée.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom du championnat.
     *
     * Permet d’accéder à la valeur métier représentant le nom
     * du championnat.
     *
     * @return string|null Nom du championnat ou null si non défini.
     *
     * @since   2025-02-13
     * @version 1.0.0
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom du championnat.
     *
     * Cette méthode permet d’affecter un nouveau nom à l’entité.
     *
     * Conformité PHPStan :
     * - Le paramètre `$name` est strictement typé `string` (non nullable).
     * - La propriété reste nullable au niveau structurel pour permettre
     *   l’instanciation Doctrine avant initialisation complète.
     *
     * @param string $name Nom du championnat (non nul).
     *
     * @return static Retourne l’instance courante pour permettre
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
