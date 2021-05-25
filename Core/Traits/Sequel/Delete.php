<?php

namespace Core\Traits\Sequel;

use PDO;
use Exception;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.1
 */
trait Delete
{
    /**
     * Deleting a Model's Record From Database.
     * 
     * @since 1.2.1
     * 
     * @return bool
     */
    public function delete()
    {
        return $this->checkForModelExistance()
            ->makeDeleteQuery()
            ->prepareDatabase()
            ->bindParams()
            ->destroyRecord();
    }

    /**
     * Making Query For Finding Model's Record In Database.
     * 
     * @since 1.2.1
     * 
     * @return object
     */
    private function makeDeleteQuery(): object
    {
        $this->query = "DELETE FROM \n\t{$this->table} \nWHERE \n\tid=:id";

        return $this;
    }

    /**
     * Executing Statement And Returning The Result.
     * 
     * @since 1.2.1
     * 
     * @return bool
     */
    private function destroyRecord(): bool
    {
        return $this->statement->execute()
        ? true
        : false;
    }
}