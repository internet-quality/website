<?php

namespace Website\Controllers;

class MiscController extends AbstractController {

    public function contact(): void
    {
        $this->setContent($this->twig->render('pages/contact.twig', []));
    }

    public function legal(): void
    {
        $this->setContent($this->twig->render('pages/legal.twig', []));
    }

}
