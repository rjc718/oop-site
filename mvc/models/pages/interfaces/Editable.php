<?php
namespace Site\Models\Pages\Interfaces;

use Site\Views\Data;

/**
 * Any class that implements this interface
 * is expected to use the HasEdit trait for the `edit()` method.
 */

interface Editable {
    /* Load a form to view/edit existing record and populate with data*/
    public abstract function edit(): Data;

    /*Query DB to get the info for specified record based on $_GET/$_POST data */
    public abstract function getRecordData(): array;

    /*Return the edit page*/
    public abstract function displayEditPage(array $data): Data;
}
