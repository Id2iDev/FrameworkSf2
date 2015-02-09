<?php
namespace Id2i\Tools\HtmlTemplating\PaginationBundle\Service;



use Symfony\Component\Templating\EngineInterface;

class Pagination {
    private $currentPage = 1;
    private $displayPageMax = 20;
    private $distancePage = 5;
    private $startPage = 1;
    private $endPage = 1;
    private $maxPage = 1;

    private $startItem = 0;

    private $countTotal = 0;
    private $countInUse = 0;

    private $linkPage = '';

    private $pageNameParameter = 'page';

    private $template;

    public function __construct(EngineInterface $template){
        $this->template = $template;
    }

    public function setLinkPage($linkPage){
        $this->linkPage = $linkPage;
        return $this;
    }

    public function setCountTotal($count = 0){
        $this->countTotal = $count;

        if($this->countInUse == 0){
            $this->countInUse = $count;
        }

        return $this;
    }
    public function setCountInUse($count = 0){
        $this->countInUse = $count;
        return $this;
    }

    public function setCurrentPage($currentPage){
        $this->currentPage = $currentPage;
        return $this;
    }

    public function setDisplayPageMax($displayPageMax){
        $this->displayPageMax = $displayPageMax;
        return $this;
    }

    public function setDistancePage($distance){
        $this->distancePage = $distance;
    }


    public function setPageParameterName($pageName){
        $this->pageNameParameter = $pageName;
    }

    /**
     * @param string $linkPage
     * @param int $currentPage
     * @param int $displayPageMax
     * @param int $distanceDisplayPage
     * @param string $pageNameParameter
     */
    public function setPagination($linkPage, $currentPage, $displayPageMax = 20, $distanceDisplayPage = 5, $pageNameParameter = 'page'){
        $this->setLinkPage($linkPage);
        $this->setCurrentPage($currentPage);
        $this->setDisplayPageMax($displayPageMax);
        $this->setDistancePage($distanceDisplayPage);
        $this->setPageParameterName($pageNameParameter);
    }

    public function getStartItem(){
        $this->calculateAll();
       return  $this->startItem;
    }

    public function getLimitItem(){
        $this->calculateAll();
        return $this->displayPageMax;
    }

    public function renderListePage(){
        return $this->template->render("PaginationBundle::paginateList.html.twig", array(
            'currentPage' => $this->currentPage,
            'startPage'=> $this->startPage,
            'endPage'=> $this->endPage,
            'linkPage'=> $this->linkPage,
            'pageNameParameter'=> $this->pageNameParameter,
        ));
    }

    private function calculateAll(){
        $this->calculateMaxPageDisplay();
        $this->calculateStartItem();
        $this->calculatStartPage();
        $this->calculatEndPage();

        if($this->maxPage < $this->currentPage){
            $this->setCurrentPage($this->maxPage);
            $this->calculateAll();
        }
    }

    private function calculateMaxPageDisplay(){
        $maxPage = ceil($this->countInUse/$this->displayPageMax);
        $this->maxPage = $maxPage<= 0 ?1:$maxPage;
    }

    private function calculateStartItem(){
        $this->startItem = ($this->currentPage - 1 ) * $this->displayPageMax;
    }

    private function calculatStartPage(){
        $this->startPage = $this->currentPage > $this->distancePage ? ($this->currentPage - $this->distancePage):1;
    }

    private function calculatEndPage(){
        $this->endPage = $this->currentPage<($this->maxPage-$this->distancePage)?($this->currentPage+$this->distancePage):$this->maxPage;
    }
}