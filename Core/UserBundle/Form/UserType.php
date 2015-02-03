<?php

namespace Id2i\Core\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',null,array('label'=>'crud.user.field.username.libelle'))
            ->add('password',"password",array("required"=>false,'label'=>'crud.user.field.password.libelle'))
            ->add('email',null,array('attr'=>array('style'=>'width:30%'),'label'=>'crud.user.field.email.libelle'))
            ->add('enabled',null,array('label'=>'crud.user.field.enabled.libelle','required'=>false))

            ->add('groups','entity',array(
                'class'=>'Id2i\Core\UserBundle\Entity\Group',
                'property'=>'name',
                'label'=>'crud.user.field.groups.libelle',
                'multiple'=>true,
//                'expanded'=>true,
                'required'=>false
            ))
//            ->add('sites','entity',array(
//                'class'=>'Id2i\Core\MultiSiteBundle\Entity\Site',
//                'property'=>'libelle',
//                'label'=>'crud.user.field.sites.libelle',
//                'multiple'=>true,
//                'expanded'=>true,
//                'required'=>false
//            ))
//            ->add('avatar',"media",array('required'=>false))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Id2i\Core\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id2i_core_userbundle_user';
    }
}
