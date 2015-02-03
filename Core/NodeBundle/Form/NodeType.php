<?php

namespace Id2i\Core\NodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array("label"=>"crud.node.field.title.libelle"))
            ->add('icon','text',array("required"=>false,"label"=>"crud.node.field.icon.libelle"))
            ->add('image',"file",array("required"=>false,"multiple"=>false,"label"=>"crud.node.field.image.libelle"))
//            ->add('lft',null,array("label"=>"crud.node.field.lft.libelle"))
//            ->add('lvl',null,array("label"=>"crud.node.field.lvl.libelle"))
//            ->add('rgt',null,array("label"=>"crud.node.field.rgt.libelle"))
//            ->add('root',null,array("label"=>"crud.node.field.root.libelle"))
            ->add('parent','entity',array(
                'class'=>'Id2i\Core\NodeBundle\Entity\Node',
                'property'=>'title',
                'label'=>'crud.node.field.parent.libelle',
                'required'=>true
            )
      )       ;
}

/**
* @param OptionsResolverInterface $resolver
*/
public function setDefaultOptions(OptionsResolverInterface $resolver)
{
$resolver->setDefaults(array(
'data_class' => 'Id2i\Core\NodeBundle\Entity\Node'
));
}

/**
* @return string
*/
public function getName()
{
return 'id2i_core_nodebundle_node';
}
}
