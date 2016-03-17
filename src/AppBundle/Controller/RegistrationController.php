<?php
// src/AppBundle/Controller/RegistrationController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
         $this->denyAccessUnlessGranted('ROLE_ADMIN',null,"This page is for admins only!!!");

            // 1) build the form
            $user = new User();
            $form = $this->createForm(UserType::class, $user);

            // 2) handle the submit (will only happen on POST)
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $user->setIsActive(1);
                $user->setCreatedBy(0);
                //$user->setUModBy($this->get('security.token_storage')->getToken()->getUser());
                // 4) save the User!
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // ... do any other work - like send them an email, etc
                // maybe set a "flash" success message for the user

                // return $this->redirectToRoute('replace_with_some_route');
                return new Response('<html><body>User <b>' . $user->getUsername() . '</b> added succ! </body></html>');
            }

            return $this->render(
                'registration/register.html.twig',
                array('form' => $form->createView())
            );

    }
}