<?php

namespace Database\Migrations;

use Core\Classes\Migration;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class CreateUsersTable extends Migration
{
    /**
     * Doing Some Changes To a Certain Table.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function up(): void
    {
        $this->exec('CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            surname VARCHAR(255) NOT NULL, 
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            phone_number VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB');
    }

    /**
     * Undoing Some Changes In a Certain Table.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function down(): void
    {
        $this->exec("DROP TABLE IF EXISTS users");
    }
}
