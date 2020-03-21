<?php

namespace Website\Controllers;

use Symfony\Component\HttpFoundation\Response;

class WebsitesController extends AbstractController {

    public function index(): void
    {
        $this->setContent($this->twig->render('pages/websites.twig', []));
    }

}
