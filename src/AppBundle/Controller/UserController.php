<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/users")
     */
   public function getUsersAction(){
        $users = $this->get('doctrine.orm.entity_manager')
                 ->getRepository('AppBundle:User')
                 ->findAll();
        if(empty($users)){
            return new JsonResponse(['message' => 'Not user found'], Response::HTTP_NOT_FOUND);
        }
       return $users;
   }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/users")
     * @param Request $request
     */
   public function postUsersAction(Request $request){

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());

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
     * @Rest\View()
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
     * @Rest\View()
     * @Rest\Patch("/users/{id}")
     * @param Request $request
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
}http://127.0.0.1:8000/users
