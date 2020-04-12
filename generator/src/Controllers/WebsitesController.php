<?php

namespace Website\Controllers;

class WebsitesController extends AbstractController {

    public function index(): void
    {
        $contents = file_get_contents(__DIR__ . '/../../../data-store/data/websites.json');
        if ($contents === false) {
            $contents = '{"websites": []}';
        }
        $websites = json_decode($contents)->websites;
        $this->setContent($this->twig->render('pages/websites.twig', [
            'websites' => $websites,
        ]));
    }

}
