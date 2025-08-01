<?php
namespace Haskris\Hub\Models\Pages\Interfaces;

use Haskris\Hub\Views\Data;

/**
 * Any class that implements this interface
 * is expected to use the HasUpdate trait for the `update()` method.
 */

interface Updatable {

    /* Update existing record and display a message */
    public function update(): Data;

    /* Logic to update existing record */
    public function updateProcess(): void;

    /* Logic to return success/failure message */
    public function updateMessage(): Data;
}
