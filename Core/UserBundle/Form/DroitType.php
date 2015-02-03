<?php

namespace Id2i\Core\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DroitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('droits',null,array("label"=>"crud.droit.field.droits.libelle"))
            ->add('groupe',null,array("property"=>"name","label"=>"crud.droit.field.groupe.libelle"))       ;
}

/**
* @param OptionsResolverInterface $resolver
*/
public function setDefaultOptions(OptionsResolverInterface $resolver)
{
$resolver->setDefaults(array(
'data_class' => 'Id2i\Core\UserBundle\Entity\Droit'
));
}

/**
* @return string
*/
public function getName()
{
return 'id2i_core_userbundle_droit';
}
}
