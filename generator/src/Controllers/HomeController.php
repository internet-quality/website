<?php

namespace Website\Controllers;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController {

    public function index(): void
    {
        $this->setContent($this->twig->render('pages/index.twig', []));
    }

    /**
     * Page not found
     *
     * @param string $routeName The route name (path)
     * @return void
     */
    public function notFound(string $routeName): void
    {
        $this->getResponse()->setStatusCode(Response::HTTP_NOT_FOUND);
        $this->setContent($this->twig->render('pages/not-found.twig', [
            'routeName' => $routeName,
        ]));
    }

    /**
     * Method not allowed
     *
     * @param string   $routeName The route name (path)
     * @param string[] $allowedMethods Allowed methods
     * @return void
     */
    public function notAllowed(string $routeName, array $allowedMethods): void
    {
        $this->getResponse()->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
        $this->setContent($this->twig->render('pages/not-allowed.twig', [
            'routeName' => $routeName,
            'allowedMethods' => $allowedMethods,
        ]));
    }

}
