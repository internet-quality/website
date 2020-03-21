<?php

namespace Website\Controllers;

class WebsitesController extends AbstractController {

    public function index(): void
    {
        $websites = json_decode(file_get_contents(__DIR__ . '/../../../data-store/data/websites.json'))->websites;
        $this->setContent($this->twig->render('pages/websites.twig', [
            'websites' => $websites,
        ]));
    }

}
