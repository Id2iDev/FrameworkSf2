<?php
/**
 * Created by PhpStorm.
 * User: maison
 * Date: 21/01/2015
 * Time: 00:07
 */

namespace Id2i\Tools\FormsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FormController extends Controller {
    public function selectAction($options, $selectedValue, $attrs = array(), $firstOptionDisplay = true, $firstOption = array('value' => '', 'text' => 'Choisir...')){
        return $this->render("FormsBundle::select.html.twig", array(
            'attrs' => $attrs,
            'options' => $options,
            'selectedValue' => $selectedValue,
        ));
    }
}