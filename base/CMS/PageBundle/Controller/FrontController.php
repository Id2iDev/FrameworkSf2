<?php

namespace Id2i\CMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    public function indexAction(Request $request)
    {

        return $this->render('PageBundle:Front:index.html.twig', array());
    }

    public function displayAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository("PageBundle:Page")->find($id);

        return $this->render("PageBundle:Front:index.html.twig",array("entity"=>$entity));
    }

    public function linksInPlaceAction($place){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQueryBuilder()
            ->select(array('p'))
            ->from("PageBundle:Page","p")
            ->from("PageBundle:PageEtat","pe")
            ->join("p.node",'n')
            ->where("n.slug = :place AND pe.id = 3 AND p.active = 1")
            ->setParameter('place', $place)
            ->getQuery()
            ->getResult();

        return $this->render("PageBundle:Front:links.html.twig",array("entities"=>$entities));
    }

    public function drawPageAction($id,$slug = null){
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository("PageBundle:Page")->findOneBy(array('id'=>$id,'active'=>1,'etat'=>3));
        if(!$page){
            return new Response('Accès non autorisé',404);
        }else{
            return $this->render("PageBundle:Front:index.html.twig",array('page'=>$page));
        }
    }
}
