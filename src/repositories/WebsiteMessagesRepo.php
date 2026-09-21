<?php

namespace Repository;

use Tigress\Repository;

class WebsiteMessagesRepo extends Repository
{
    public function __construct()
    {
        $this->dbName = 'default';
        $this->table = 'website_messages';
        $this->primaryKey = ['id'];
        $this->model = 'DefaultModel';
        $this->autoload = true;
        $this->softDelete = true;
        $this->createTable = [
            'table' => "
                CREATE TABLE {$this->table} (
                  `id` int NOT NULL,
                  `page` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
                  `url_location` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
                  `title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
                  `message` text COLLATE utf8mb4_general_ci NOT NULL,
                  `type` enum('info','success','warning','danger', 'light') COLLATE utf8mb4_general_ci NOT NULL,
                  `display` enum('page-top','page-bottom','popup','') COLLATE utf8mb4_general_ci NOT NULL,
                  `active_from` timestamp NOT NULL,
                  `active_until` timestamp NOT NULL,
                  `created` timestamp NOT NULL,
                  `created_user_id` int NOT NULL,
                  `modified` timestamp NOT NULL,
                  `modified_user_id` int NOT NULL,
                  `deleted` timestamp NOT NULL,
                  `deleted_user_id` int NOT NULL,
                  `active` tinyint(1) NOT NULL DEFAULT '1'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            ",
            'indexes' => [
                "ALTER TABLE {$this->table} ADD PRIMARY KEY (`id`);",
                "ALTER TABLE {$this->table} MODIFY `id` int NOT NULL AUTO_INCREMENT;",
            ]
        ];
        parent::__construct();
    }
}
