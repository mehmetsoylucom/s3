<?php

namespace Wcms\PhonebookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WcmsPhonebookBundle:Default:index.html.twig');
    }
}
