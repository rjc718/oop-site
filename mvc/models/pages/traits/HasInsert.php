<?php
namespace Haskris\Hub\Models\Pages\Traits;

use Haskris\Hub\Views\Data;

trait HasInsert {
    public function insert(): Data {
        $this->insertProcess();
        return $this->insertMessage();
    }
}
