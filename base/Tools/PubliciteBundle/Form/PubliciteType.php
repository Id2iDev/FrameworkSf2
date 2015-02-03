<?php

namespace Id2i\Tools\PubliciteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PubliciteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre','text',array("required"=>true,"label"=>"crud.publicite.field.titre.libelle"))
            ->add('urlCible','text',array("required"=>false,"label"=>"crud.publicite.field.urlcible.libelle"))
            ->add('script',null,array("required"=>false,"label"=>"crud.publicite.field.script.libelle"))
            ->add('attrTarget',"choice",array("choices"=>array("_blank"=>"Ouverture dans une nouvelle fenêtre","_parent"=>"Ouverture dans la même fenêtre"),"required"=>false,"label"=>"crud.publicite.field.attrtarget.libelle"))
            ->add('attrTitle',null,array("required"=>false,"label"=>"crud.publicite.field.attrtitle.libelle"))
            ->add('media','media',array("multiple"=>false,"options"=>array("only_one"=>true),"required"=>false,"label"=>"crud.publicite.field.media.libelle"))
            ->add('node',null,array("required"=>true,"property"=>"title","label"=>"crud.publicite.field.node.libelle"))
            ->add('active',null,array("required"=>false,"label"=>"crud.publicite.field.active.libelle"))
        ;
}

/**
* @param OptionsResolverInterface $resolver
*/
public function setDefaultOptions(OptionsResolverInterface $resolver)
{
$resolver->setDefaults(array(
'data_class' => 'Id2i\Tools\PubliciteBundle\Entity\Publicite'
));
}

/**
* @return string
*/
public function getName()
{
return 'id2i_tools_publicitebundle_publicite';
}
}
