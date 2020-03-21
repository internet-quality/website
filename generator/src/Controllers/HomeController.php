<?php

namespace Website\Controllers;

class HomeController extends AbstractController {

    public function index(): void
    {
        echo $this->twig->render('pages/index.twig', []);
    }

    public function notFound(string $routeName): void
    {
        echo $this->twig->render('pages/not-found.twig', [
            'routeName' => $routeName,
        ]);
    }

    /**
     * Method not allowed
     *
     * @param string   $routeName
     * @param string[] $allowedMethods
     * @return void
     */
    public function notAllowed(string $routeName, array $allowedMethods): void
    {
        echo $this->twig->render('pages/not-allowed.twig', [
            'routeName' => $routeName,
            'allowedMethods' => $allowedMethods,
        ]);
    }

}
