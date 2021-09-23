<?php

namespace Zed\Framework;

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
error_reporting(E_ERROR | E_PARSE);

use Zed\Framework\Database\DatabaseCreator;
use Zed\Framework\Database;
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Application
{
    /**
     * Router's instance.
     * 
     * @since 1.0.0
     * 
     * @var Router
     */
    public Router $router;

    /**
     * Command's instance.
     * 
     * @since 1.0.0
     * 
     * @var Command
     */
    public Command $command;

    /**
     * Database's instance.
     * 
     * @since 1.0.1
     * 
     * @var Database
     */
    public static Database $database;

    /**
     * Path to different sections of the application.
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    public static $path = [];

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct(string $root)
    {
        $this->setDatabase();
        $this->setPath($root);

        $this->router = new Router;
        $this->command = new Command;
    }

    /**
     * Set path to different sections of the application.
     * 
     * @since 1.0.1
     * 
     * @param string $projectRoot
     * 
     * @return void
     */
    private function setPath(string $projectRoot): void
    {
        self::$path = [
            'project' => $projectRoot,

            'models' => $projectRoot . '/App/Models',
            'commands' => $projectRoot . '/App/Commands',
            'services' => $projectRoot . '/App/Services',
            'controllers' => $projectRoot . '/App/Controllers',
            'repositories' => $projectRoot . '/App/Repositories',
            'migrations' => $projectRoot . '/Database/Migrations',

            'framework' => __DIR__,
            'blueprints' => __DIR__ . '/Maker/BluePrints',
        ];
    }

    /**
     * Set database's instance.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    private function setDatabase(): void
    {
        self::$database = (new DatabaseCreator)
            ->getDatabase();
    }

    /**
     * Resolve requested route.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function resolve(): void
    {
        try {
            die(
                $this->router->resolve()
            );
        } catch (Exception $exception) {
            die(
                $exception->getMessage()
            );
        }
    }

    /**
     * Execute called command.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function execute(): void
    {
        try {
            die(
                $this->command->execute()
            );
        } catch (Exception $exception) {
            die(
                $exception->getMessage()
            );
        }
    }
}
