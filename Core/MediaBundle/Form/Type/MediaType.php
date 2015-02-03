<?php
/**
 * User: p.pobelle
 * Date: 17/12/2014
 * Time: 09:25
 */

namespace Id2i\Core\MediaBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'options'=>array(
                'only_one'=>false,
            ),
            'multiple'=>true,
            'property'=>'originalName',
            'class'=>'Id2i\Core\MediaBundle\Entity\Media',
            'attr'=>array(
                'class'=>'btn btn-info fa fa-file-image-o',
                'data-mediabundle-ajax'=>'true',
                'data-mediabundle-type'=>'one'
            )
        ));
    }
    public function getParent()
    {
        return 'entity';
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'media';
    }
}