<?php

namespace Id2i\CMS\PageBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('active', null, array("required"=>false,"label" => "crud.page.field.active.libelle"))
            ->add('publiedAt', null, array("label" => "crud.page.field.publiedat.libelle"))
            ->add('title', 'text', array("label" => "crud.page.field.title.libelle"))
            ->add('resume', null, array("required" => false, "label" => "crud.page.field.resume.libelle"))
            ->add('contenu', 'ckeditor', array(
                "config_name" =>'light',
                "attr" => array(
                    "class" => "col-md-12"
                ),
                "label" => "crud.page.field.contenu.libelle"
            ))
            ->add('seoTitle', null, array("required" => false, "label" => "crud.page.field.seotitle.libelle"))
            ->add('seoDescription', null, array("required" => false, "label" => "crud.page.field.seodescription.libelle"))
            ->add('seoKeywords', null, array("required" => false, "label" => "crud.page.field.seokeywords.libelle"))
            ->add('seoUrl', null, array("required" => false, "label" => "crud.page.field.seourl.libelle"))
            ->add('node', 'entity', array(
                "property" => "title",
                "multiple" => true,
                "class" => 'Id2i\Core\NodeBundle\Entity\Node',
                "label" => "crud.page.field.node.libelle",
                "query_builder"=>function(EntityRepository $er){
                    return $er->getPlacements();
                }


            ))
            ->add('groups', 'entity', array(
                "property" => "name",
                "class"    => 'Id2i\Core\UserBundle\Entity\Group',
                'multiple' => true,
                'expanded' => true,
                'required' => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Id2i\CMS\PageBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id2i_core_pagebundle_page';
    }
}
