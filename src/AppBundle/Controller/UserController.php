<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\AppBundle\Role;
use AppBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/{_locale}/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
/*
    public function getMyStoreId()
    {
        $em = $this->getDoctrine()->getManager();
        $logedUserId = $em->getRepository('AppBundle:User')->findOneBy(array('id'=>$this->getUser()->getId()));
        $storeId= $logedUserId->getStoreId();
        return $storeId;
    }
    public function getMyUserId()
    {
        return $this->getUser()->getId();
    }
*/

    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,"This page is for admins only!!!");
        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            throw $this->createAccessDeniedException("Pena ne dava!!!!!");
        }
        $em = $this->getDoctrine()->getManager();
        $logedUserId = $em->getRepository('AppBundle:User')->findOneBy(array('id'=>$this->getUser()->getId()));
        $storeId= $logedUserId->getStoreId();
        $logedUserId->getRole()->getId();
        If($logedUserId->getRole()->getId()==2)
        {
            $users = $em->getRepository('AppBundle:User')->findBy(array('storeId' => $storeId));
        }
        else
        {
            $users = $em->getRepository('AppBundle:User')->findAll();
        }
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));

    }

    /**
     * Creates a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $user = new User();

            $user->setStoreId($this->getUser()->getStoreId());

        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);
        $user->setCreatedBy($this->getUser()->getId());
        $user->setCreated(new \DateTime());
        $user->setPassword($password = $this->get('security.password_encoder')
                                        ->encodePassword($user, $user->getPassword()));



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($this->getUser()->getRole()->getId() == 2) {
                $user->setStoreId($this->getUser()->getStoreId());
            }

            /*
            if($user->getRole() == 1)
            {
                $user->setRole(2);
            }*/
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        if($this->getUser()->getRole()->getId() >=2)
        {
            throw $this->createAccessDeniedException("This is for global admins only");
        }
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        if($this->getUser()->getRole()->getId() >=2 and $user->getRole()->getId() == 1)
        {
            throw $this->createAccessDeniedException("This is for global admins only");
        }
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if($this->getUser()->getRole()->getId=2)
            {$user->setRole(array('id'=>3,'name'=>'ROLE_USER'));}

            $user->setPassword($password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword()));
            $user->setUModBy($this->getUser()->getId());
            $user->setModDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {


        if($this->getUser()->getRole()->getId() >=2 and $user->getRole()->getId() == 1)
        {
            throw $this->createAccessDeniedException("This is for global admins only");
        }
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
