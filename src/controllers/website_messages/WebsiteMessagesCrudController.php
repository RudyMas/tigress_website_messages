<?php

namespace Controller\website_messages;

use JetBrains\PhpStorm\NoReturn;
use Repository\WebsiteMessagesRepo;
use Throwable;
use Tigress\Core;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class WebsiteMessagesCrudController (PHP version 8.5)
 *
 * @author Rudy Mas <rudy.mas@rudymas.be>
 * @copyright 2026 Rudy Mas (https://rudymas.be)
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3 (GPL-3.0)
 * @version 2026.09.17.0
 * @package Controller\WebsiteMessagesCrudController
 */
class WebsiteMessagesCrudController
{
    /**
     * Archive a website message.
     *
     * @param array $args
     * @return void
     */
    #[NoReturn]
    public function archive(array $args): void
    {
        $websiteMessagesRepo = new WebsiteMessagesRepo();
        $websiteMessagesRepo->deleteById((int)$args['id']);

        $_SESSION['success'] = 'Bericht gearchiveerd.';
        TWIG->redirect('/website-messages');
    }

    /**
     * Delete a website message.
     *
     * @param array $args
     * @return void
     */
    #[NoReturn]
    public function delete(array $args): void
    {
        $websiteMessagesRepo = new WebsiteMessagesRepo();
        $websiteMessagesRepo->forceDeleteById((int)$args['id']);

        $_SESSION['success'] = 'Bericht verwijderd.';
        TWIG->redirect('/website-messages?show=archive');
    }

    /**
     * Get data for DataTable
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getData(array $args): void
    {
        $websiteMessagesRepo = new WebsiteMessagesRepo();
        if (isset($args['show']) && $args['show'] === 'active') {
            $websiteMessagesRepo->loadAllActive();
        } else {
            $websiteMessagesRepo->loadAllInactive();
        }
        TWIG->render(null, $websiteMessagesRepo->toArray(), 'DT');
    }

    /**
     * Restore a website message.
     *
     * @param array $args
     * @return void
     */
    #[NoReturn]
    public function restore(array $args): void
    {
        $websiteMessagesRepo = new WebsiteMessagesRepo();
        $websiteMessagesRepo->undeleteById((int)$args['id']);

        $_SESSION['success'] = 'Bericht hersteld.';
        TWIG->redirect('/website-messages?show=archive');
    }

    /**
     * Save a website message.
     *
     * @return void
     * @throws Throwable
     */
    #[NoReturn]
    public function save(): void
    {
        $websiteMessagesRepo = new WebsiteMessagesRepo();
        $websiteMessagesRepo->loadById((int)$_POST['id']);
        if ($websiteMessagesRepo->isEmpty()) {
            $websiteMessagesRepo->new();
        }
        $websiteMessage = $websiteMessagesRepo->current();
        $websiteMessage->UpdateByPost($_POST);
        $websiteMessagesRepo->save($websiteMessage);

        TWIG->redirect('/website-messages');
    }
}