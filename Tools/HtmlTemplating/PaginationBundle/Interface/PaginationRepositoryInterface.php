<?php
/**
 * Created by PhpStorm.
 * User: maison
 * Date: 23/01/2015
 * Time: 23:49
 */

namespace Id2i\Tools\HtmlTemplating\PaginationBundle;


use Doctrine\ORM\QueryBuilder;

class PaginationRepositoryInterface {

    public function count(QueryBuilder $Builder){}

}