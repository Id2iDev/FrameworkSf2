<?php

namespace Id2i\Core\MultiSiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle',null,array("label"=>"crud.site.field.libelle.libelle"))
            ->add('domaine',null,array("label"=>"crud.site.field.domaine.libelle"))
            ->add('theme',null,array("required"=>false,"label"=>"crud.site.field.theme.libelle"))
            ->add('active',null,array("required"=>false,"label"=>"crud.site.field.active.libelle"))
            ->add('maintenance',null,array("required"=>false,"label"=>"crud.site.field.maintenance.libelle"))        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Id2i\Core\MultiSiteBundle\Entity\Site'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id2i_core_multisitebundle_site';
    }
}
