<?php
namespace Haskris\Hub\Models\Pages\Interfaces;

use Haskris\Hub\Views\Data;

/**
 * Any class that implements this interface
 * is expected to use the HasDelete trait for the `delete()` method.
 */

interface Deletable {

    /* Delete existing record and display a message */
    public function delete(): Data;

    /* Logic to delete existing record */
    public function deleteProcess(): void;

    /* Logic to return success/failure message */
    public function deleteMessage(): Data;

    /* Logic to ask user to confirm deletion */
    public function deleteConfirm(): Data;
}
