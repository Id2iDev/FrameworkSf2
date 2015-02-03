<?php

namespace Id2i\Tools\CommuneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommuneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,array("label"=>"crud.commune.field.nom.libelle"))
            ->add('codePostal',null,array("label"=>"crud.commune.field.codepostal.libelle"))
            ->add('zone',null,array("label"=>"crud.commune.field.zone.libelle"))       ;
}

/**
* @param OptionsResolverInterface $resolver
*/
public function setDefaultOptions(OptionsResolverInterface $resolver)
{
$resolver->setDefaults(array(
'data_class' => 'Id2i\Tools\CommuneBundle\Entity\Commune'
));
}

/**
* @return string
*/
public function getName()
{
return 'id2i_tools_communebundle_commune';
}
}
