<?php
namespace Site\Models\Pages\Traits;

use Site\Views\Data;

trait HasDelete {
    public function delete(): Data {
        $this->deleteProcess();
        return $this->deleteMessage();
    }
}
