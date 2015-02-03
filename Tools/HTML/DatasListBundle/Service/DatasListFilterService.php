<?php
namespace Id2i\Tools\HTML\DatasListBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

class DatasListFilterService {

    private $filterName;
    private $request;
    private $template;

    private $filters;

    public function __construct(Request $request,EngineInterface $template){
        $this->request = $request;
        $this->template = $template;
    }

    public function setFilterName($name){
        $this->filterName = $name;
        return $this;
    }

    public function setFilter($typeField, $field, $ddlProprieties, $defaultValue, $args){
        $this->filters[$this->filterName][$field] = (object) array(
            'type' => $typeField,
            'args' => $args,
            'ddlProprieties' => $ddlProprieties,
            'value' => $defaultValue
        );
    }

    public function addInputFilter($field, array $ddlProprieties, $defaultValue = '', $args = array()){
        $this->setFilter('input', $field, $ddlProprieties, $defaultValue, $args);
        $this->getRequestFilter($field);
        $this->setSessionFilter();
        return $this;
    }

    public function addSelectFilter(array $datas, $valuePropriety, $textPropriety , $field, array $ddlProprieties, $defaultValue, $defaultValue = '', $args = array()){
        $args['datas']  = $datas;
        $args['valuePropriety'] = $valuePropriety;
        $args['textPropriety']  = $textPropriety;

        $this->setFilter('select', $field, $ddlProprieties, $defaultValue, $args);
        $this->getRequestFilter($field);
        $this->setSessionFilter();
        return $this;
    }

    public function getValue($field){

    }

    public function getField($field){
        if($this->filters[$this->filterName][$field]->type == 'input'){
            return $this->getFieldInput($field);
        }

        if($this->filters[$this->filterName][$field]->type == 'selected'){
            return $this->getFieldSelect($field);
        }
    }

    protected function getFieldInput($field){
        $args = $this->filters[$this->filterName][$field]->args;
        $args['type'] = 'text';
        $args['name'] = $this->filterName.'_'.$field;
        $args['value'] = $this->filters[$this->filterName][$field]->value;
        return $this->template->render('DatasListBundle:Form:input.twig',array('args' => $args));
    }

    protected function getFieldSelect($field){
        $args = $this->filters[$this->filterName][$field]->args;
        $args['type'] = 'text';
        $args['name'] = $this->filterName.'_'.$field;
        $selectedValue = $this->filters[$this->filterName][$field]->value;

        return $this->template->render('DatasListBundle:Form/select:select.html.twig',array(
            'args' => $args,
            'datasList' => $args['datas'],
            'valuePropriety' => $args['valuePropriety'],
            'textPropriety' => $args['textPropriety'],
            'selectedValue' => $selectedValue
        ));
    }

    protected function getRequestFilter($field){
        $requestValue = $this->request->get($this->filterName.'_'.$field, $this->filters[$this->filterName][$field]->value);
        if($requestValue === $this->filters[$this->filterName][$field]->value){
            $this->filters[$this->filterName][$field]->value = $this->getSessionValue($field);
        }
    }

    protected function setSessionFilter(){
        $this->request->getSession()->set($this->filterName, $this->filters[$this->filterName]);
    }

    protected function getSessionValue($field){
        $sessionFilters = $this->request->getSession()->get($this->filterName, null);
        if(null === $sessionFilters){
            return $this->filters[$this->filterName][$field]->value;
        }

        return $sessionFilters[$this->filterName][$field]->value;
    }
}