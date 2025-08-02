<?php
namespace Site\Models\Pages\Interfaces;

use Site\Views\Data;

/**
 * Any class that implements this interface
 * is expected to use the HasInsert trait for the `create()` method.
 */

interface Insertable {
    
    /* Load a form to create new record, do not populate with data */
    public function create(): Data;

    /* Insert a new record and display a message */
    public function insert(): Data;

    /* Logic to insert new record */
    public function insertProcess(): void;

    /* Logic to return success/failure message */
    public function insertMessage(): Data;
}
