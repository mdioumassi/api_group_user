<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @ApiDoc(
     *     description="Recupère l'ensemble des utilisateurs"
     * )
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"users"})
     * @Rest\Get("/users")
     */
   public function getUsersAction(){
        $users = $this->get('doctrine.orm.entity_manager')
                 ->getRepository(User::class)
                 ->findAll();
        if(empty($users)){
            return new JsonResponse(['message' => 'Not user found'], Response::HTTP_NOT_FOUND);
        }
       return $users;
   }

    /**
     * @ApiDoc(
     *     description="Créer un utilisateur",
     *     input={"class"=UserType::class, "name"=""}
     * )
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"users"})
     * @Rest\Post("/users")
     * @
     */
   public function postUsersAction(Request $request){

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $data = $request->request->all();
        //$user->setGroupe($data['groupe']);
        $form->submit($data);

        if($form->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        }else{
            return $form;
        }
   }

    /**
     * @ApiDoc(
     *     description="Afficher les informations d'un utilisateurs"
     * )
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"users"})
     * @Rest\Get("/users/{user_id}")
     */
    public function getUserAction(Request $request){
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->find($request->get('user_id'));

        if(empty($user)){
            return new JsonResponse(['message'=>'Not found user'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"users"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    public function updateUser(Request $request, $clearMissing){
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->find($request->get('id'));

        if(empty($user)){
            return new JsonResponse(['message' => 'Not found user'], Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all(), $clearMissing);

        if($form->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        }else{
            return $form;
        }
    }
}
