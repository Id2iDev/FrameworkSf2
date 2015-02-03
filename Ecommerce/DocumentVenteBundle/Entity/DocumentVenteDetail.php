<?php

namespace Id2i\Ecommerce\DocumentVenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentVenteDetail
 *
 * @ORM\Table("ecommerce_document_vente_detail")
 * @ORM\Entity(repositoryClass="Id2i\Ecommerce\DocumentVenteBundle\Entity\DocumentVenteDetailRepository")
 */
class DocumentVenteDetail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Id2i\Ecommerce\DocumentVenteBundle\Entity\DocumentVente
     * @ORM\ManyToOne(targetEntity="\Id2i\Ecommerce\DocumentVenteBundle\Entity\DocumentVente")
     * @ORM\JoinColumn(name="id_document_vente", referencedColumnName="id", nullable = false)
     */
    private $documentVente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_saisie", type="datetime")
     */
    private $dateSaisie;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_unitaire", type="float")
     */
    private $prixUnitaire;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set documentVente
     *
     * @param integer $documentVente
     * @return DocumentVenteDetail
     */
    public function setDocumentVente($documentVente)
    {
        $this->documentVente = $documentVente;

        return $this;
    }

    /**
     * Get documentVente
     *
     * @return integer 
     */
    public function getDocumentVente()
    {
        return $this->documentVente;
    }

    /**
     * Set dateSaisie
     *
     * @param \DateTime $dateSaisie
     * @return DocumentVenteDetail
     */
    public function setDateSaisie($dateSaisie)
    {
        $this->dateSaisie = $dateSaisie;

        return $this;
    }

    /**
     * Get dateSaisie
     *
     * @return \DateTime 
     */
    public function getDateSaisie()
    {
        return $this->dateSaisie;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return DocumentVenteDetail
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixUnitaire
     *
     * @param float $prixUnitaire
     * @return DocumentVenteDetail
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return float 
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return DocumentVenteDetail
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}
