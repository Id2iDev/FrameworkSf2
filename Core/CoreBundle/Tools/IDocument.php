<?php
/**
 * User: p.pobelle
 * Date: 20/01/2015
 * Time: 11:05
 */

namespace Id2i\Core\CoreBundle\Tools;


interface IDocument {
    function getAbsolutePath();

    function getWebPath();


    function getUploadRootDir();


    function getUploadDir();

    public function upload();
}