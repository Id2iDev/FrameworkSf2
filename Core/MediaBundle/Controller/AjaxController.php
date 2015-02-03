<?php

namespace Id2i\Core\MediaBundle\Controller;

use Id2i\Core\MediaBundle\Entity\Media;
use Id2i\Core\MediaBundle\Form\MediaQuickType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{
    public function choiceAction($id, $options)
    {
        $options_finales = array();
        $opts = explode('|', $options);
        foreach ($opts AS $opt) {
            $o = explode(':', $opt);
            $options_finales[$o[0]] = $o[1];
        }

        $url = $this->generateUrl('media_ajax_upload');
        $user = $this->getUser();
        //-- visibilité de ses medias
        $access = $this->get('id2i_secure')->setUser($user)->can('media', 'back', 'read_his');
        //-- visibilités de tous les medias
        $access2 = $this->get('id2i_secure')->setUser($user)->can('media', 'back', 'read_all');
        $em = $this->getDoctrine()->getManager();
        if (true !== $access && true !== $access2) {
            return $access;
        }

        if (true === $access) {
            $entities = $em->getRepository('MediaBundle:Media')->findBy(array("owner"=>$user),array('id'=>'desc'));
        }
        if (true === $access2) {
            $entities = $em->getRepository('MediaBundle:Media')->findBy(array(),array('id'=>'desc'));
        }


        return $this->render('MediaBundle:Ajax:choice.html.twig', array(
            'entities' => $entities, 'id' => $id, 'options' => $options_finales, 'url_media_upload' => $url
        ));
    }

    public function uploadAction(Request $request)
    {
        $user = $this->getUser();
        if (true !== $access = $this->get('id2i_secure')->setUser($user)->can('media', 'back', 'create')) {
            return $access;
        }
        $em = $this->getDoctrine()->getManager();

        $myfile = new UploadedFile(
            $_FILES['id2i_core_mediabundle_media_file']["tmp_name"],
            $_FILES['id2i_core_mediabundle_media_file']["name"],
            $_FILES['id2i_core_mediabundle_media_file']["type"],
            $_FILES['id2i_core_mediabundle_media_file']["size"],
            $_FILES['id2i_core_mediabundle_media_file']["error"]
        );

        $media = new Media();
        $media->file = $myfile;
        $media->setOwner($user);
        $media->upload();
        $em->persist($media);
        $em->flush();
        $avalancheService = $this->get('imagine.cache.path.resolver');
        $cachedImage = $avalancheService->getBrowserPath($media->getPath(), 'media_thumb');
        $cachedImageMedium = $avalancheService->getBrowserPath($media->getPath(), 'media_medium');
        $response = array(
            "files" => array(
                array(
                    "id"           => $media->getId(),
                    "name"         => $_FILES['id2i_core_mediabundle_media_file']["name"],
                    "size"         => $_FILES['id2i_core_mediabundle_media_file']["size"],
                    "type"         => $_FILES['id2i_core_mediabundle_media_file']["type"],
                    "url"          => $media->getPath(),
                    "mediumUrl"    => $cachedImageMedium,
                    "thumbnailUrl" => $cachedImage,
                    "deleteUrl"    => $this->generateUrl("superadmin_media_delete", array("id" => $media->getId())),
                    "deleteType"   => "DELETE"
                )
            )
        );

        return new Response(json_encode($response), 200);

    }


}
