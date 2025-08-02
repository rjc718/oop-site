<?php
namespace Site\Models\Pages\Traits;

use Site\Views\Data;

trait HasEdit {
    public function edit(): Data {
        return $this->displayEditPage(
            $this->getRecordData()
        );
    }
}
