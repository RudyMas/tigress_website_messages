<?php

namespace Controller\messages;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MessagesController (PHP version 8.5)
 *
 * @author Rudy Mas <rudy.mas@rudymas.be>
 * @copyright 2026 Rudy Mas (https://rudymas.be)
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3 (GPL-3.0)
 * @version 2026.09.16.0
 * @package Controller\MessagesController
 */
class MessagesController
{
    /**
     * @throws LoaderError
     */
    public function __construct()
    {
        TWIG->addPath('vendor/tigress/messages/src/views');
        TRANSLATIONS->load(SYSTEM_ROOT . '/vendor/tigress/messages/translations/translations.json');
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
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            TWIG->redirect('/login');
        }

        TWIG->render('under_construction.twig');
    }
}