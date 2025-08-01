<?php
namespace Haskris\Hub\Models\Pages\Traits;

use Haskris\Hub\Views\Data;

trait HasDelete {
    public function delete(): Data {
        $this->deleteProcess();
        return $this->deleteMessage();
    }
}
