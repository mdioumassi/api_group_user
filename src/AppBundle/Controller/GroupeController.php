<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Groupe;
use AppBundle\Entity\User;
use AppBundle\Form\GroupeType;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends Controller
{
    /**
     * @ApiDoc(
     *     description="La liste des groupes"
     * )
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"groups"})
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
     * @ApiDoc(
     *     description="Créer un groupe"
     * )
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
     * @ApiDoc(
     *     description="Afficher un groupe"
     * )
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"groups"})
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
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"groups"})
     * @Rest\Put("/groupes/{id}")
     * @param Request $request
     */
    public function patchGroupeAction(Request $request){

        $groupe = $this->get('doctrine.orm.entity_manager')
            ->getRepository(Groupe::class)
            ->find($request->get('id'));

        if(empty($groupe)){
            return new JsonResponse(['message' => 'Not found groupe'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(GroupeType::class, $groupe);
        $form->submit($request->request->all());

        if($form->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($groupe);
            $em->flush();
            return $groupe;
        }else{
            return $form;
        }
    }

    /**
     * @param ParamFetcher $paramFetcher
     *
     * @ApiDoc(
     *     description="La liste des utilisateurs d'un groupe"
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"users", "groups"})
     * @Rest\Get("/groupes/{id}/users")
     */
    public function getUsersGroupAction(Request $request)
    {
        $groupe = $this->get('doctrine.orm.entity_manager')
                      ->getRepository(Groupe::class)
                      ->findBygroupeId($request->get('id'));
        $users = $groupe;

        return $users;
    }
}
