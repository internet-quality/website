<?php

namespace Website\Controllers;

class ContactController extends AbstractController {

    public function index(): void
    {
        $this->setContent($this->twig->render('pages/contact.twig', []));
    }

}
