<?php

namespace Controller\website_messages;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class WebsiteMessagesController (PHP version 8.5)
 *
 * @author Rudy Mas <rudy.mas@rudymas.be>
 * @copyright 2026 Rudy Mas (https://www.rudymas.be)
 * @license Apache License 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
 * @version 2026.09.16.0
 * @package Controller\WebsiteMessagesController
 */
class WebsiteMessagesController
{
    /**
     * @throws LoaderError
     */
    public function __construct()
    {
        if (RIGHTS->checkRights() === false) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            TWIG->redirect('/login');
        }

        TWIG->addPath('vendor/tigress/website-messages/src/views');
        TRANSLATIONS->load(SYSTEM_ROOT . '/vendor/tigress/website-messages/translations/translations.json');
    }

    /**
     * Home page
     *
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(): void
    {
        if (RIGHTS->checkRights() === false) {
            $_SESSION['error'] = 'U hebt niet de nodige rechten om deze pagina te bekijken.';
            TWIG->redirect('/login');
        }

        TWIG->render('website_messages/index.twig');
    }

    /**
     * Edit or create a website message.
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function edit(array $args): void
    {
        if (RIGHTS->checkRights() === false) {
            $_SESSION['error'] = 'U hebt niet de nodige rechten om deze pagina te bekijken.';
            TWIG->redirect('/login');
        }

        $websiteMessagesRepo = new \Repository\WebsiteMessagesRepo();
        $websiteMessagesRepo->loadById($args['id']);
        if ($websiteMessagesRepo->isEmpty()) {
            $websiteMessagesRepo->new();
        }
        $websiteMessage = $websiteMessagesRepo->current();

        TWIG->render('website_messages/edit.twig', [
            'actionButton' => $websiteMessagesRepo->isEmpty() ? __('Add') : __('Edit'),
            'websiteMessage' => $websiteMessage,
        ]);
    }
}