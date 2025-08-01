<?php
namespace Haskris\Hub\Models\Pages\Traits;

use Haskris\Hub\Views\Data;

trait HasUpdate {
    public function update(): Data {
        $this->updateProcess();
        return $this->updateMessage();
    }
}
