<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Groupe;
use AppBundle\Form\GroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/groupes")
     */
    public function getGroupesAction(){
        $groupes = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('AppBundle:Groupe')
                    ->findAll();
        if(empty($groupes)){
            return new JsonResponse(['message'=>'Not found group'], Response::HTTP_NOT_FOUND);
        }
        return $groupes;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/groupes")
     * @param Request $request
     */
    public function postGroupesAction(Request $request){
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->submit($request->request->all());

        if($form->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($groupe);
            $em->flush();
            return $groupe;
        }else{
            $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Get("/groupes/{id}")
     */
    public function getGroupeAction(Request $request){
        $groupe = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('AppBundle:Groupe')
                    ->find($request->get('id'));
        if(empty($groupe)){
            return new JsonResponse(['message'=>'Not found groupe'], Response::HTTP_NOT_FOUND);
        }
        return $groupe;
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/groupes/{id}")
     * @param Request $request
     */
    public function patchGroupeAction(Request $request){
        $this->updateGroupe($request, false);
    }

    public function updateGroupe(Request $request, $clearMissing){
        $groupe = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Groupe')
            ->find($request->get('id'));

        if(empty($groupe)){
            return new JsonResponse(['message' => 'Not found groupe'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(GroupeType::class, $groupe);
        $form->submit($request->request->all(), $clearMissing);

        if($form->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($groupe);
            $em->flush();
            return $groupe;
        }else{
            return $form;
        }
    }

}
