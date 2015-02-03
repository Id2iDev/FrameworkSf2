<?php

namespace Id2i\Ecommerce\DocumentVenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentVente
 *
 * @ORM\Table("ecommerce_document_vente")
 * @ORM\Entity(repositoryClass="Id2i\Ecommerce\DocumentVenteBundle\Entity\DocumentVenteRepository")
 */
class DocumentVente
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
     * @var integer
     *
     * @ORM\Column(name="client", type="integer")
     */
    private $client;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSaisie", type="datetime")
     */
    private $dateSaisie;

    /**
     * @var \Id2i\Ecommerce\DocumentVenteBundle\Entity\DocumentVenteEtat
     * @ORM\ManyToOne(targetEntity="\Id2i\Ecommerce\DocumentVenteBundle\Entity\DocumentVenteEtat")
     * @ORM\JoinColumn(name="id_etat", referencedColumnName="id", nullable = false)
     */
    private $etat;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", nullable = true)
     */
    private $total;

    /**
     * @var float
     *
     * @ORM\Column(name="remise", type="float", nullable = true)
     */
    private $remise;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable = true)
     */
    private $commentaire;


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
     * Set client
     *
     * @param integer $client
     * @return DocumentVente
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return integer 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set dateSaisie
     *
     * @param \DateTime $dateSaisie
     * @return DocumentVente
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
     * Set etat
     *
     * @param integer $etat
     * @return DocumentVente
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return DocumentVente
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set remise
     *
     * @param float $remise
     * @return DocumentVente
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return float 
     */
    public function getRemise()
    {
        return $this->remise;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return DocumentVente
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}
