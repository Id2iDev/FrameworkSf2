<?php
namespace Id2i\Tools\HtmlTemplating\DatasListBundle\Service;



use Symfony\Component\Templating\EngineInterface;

class DatasListService {

    private $template;

    public function __construct(EngineInterface $template){
        $this->template = $template;
    }



}