<?php
/**
 * Created by PhpStorm.
 * User: wolverine13
 * Date: 06.02.16
 * Time: 13:49
 */

namespace AppBundle\Controller;


//use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class HomeController extends Controller
{

    public function registerAction(Request $request)
    {
        $request->setLocale("bg");
        $locale = $request->getLocale();
        $this->denyAccessUnlessGranted('ROLE_USER',null,"This page is for authenticated users only!!!");
        return $this->render("usr/home.html.twig");
    }
}