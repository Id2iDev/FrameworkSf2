<?php
/**
 * User: p.pobelle
 * Date: 18/12/2014
 * Time: 11:05
 */

namespace Id2i\Core\CoreBundle\Services;
use Symfony\Component\HttpFoundation\Response;

class Id2iSecure {
    private $user = null;
    public function setUser(\Id2i\Core\UserBundle\Entity\User $user){
        $this->user = $user;
        return $this;
    }

    public function can($bundle,$tag2,$tag3){
        if(null === $this->user){
            return new \Exception("Utilisateur non défini");
        }
        $groupes = $this->user->getGroups();
        //-- por chaque chaque groupe
        foreach($groupes AS $groupe){

            //on verifie les droits
            foreach($groupe->getDroits() AS $droit){

                if($droit->getBundle() == "droits.".$bundle){
                    $valid = $droit->getDroits();
                    if(isset($valid[$tag2][$tag3])){
                        if($valid[$tag2][$tag3] === true){
                            return true;
                        }else{
                            return new Response("Accès non autorisé",401);
                        }
                    }else{
                        return new Response("Droit 'droits.".$bundle.":".$tag2.":".$tag3." non configuré",404);
                    }
                }
            }
        }
        return new Response("Accès non autorisé",401);
    }
}