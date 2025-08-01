<?php
require_once __DIR__ . '/../../includes/application_top.php';

use Haskris\Base\Models\Request;
use Haskris\Base\Models\Database;
use Haskris\Hub\Models\Pages\LaborHoursReport;
use Haskris\Hub\Controllers\ListDetailController;

$request = Request::getInstance();

// Get the slug from POST data using your Request model method
$slug = $request->getSafeString('slug', INPUT_POST);

if ($slug === 'labor-hours-report') {
    $model = new LaborHoursReport();
    $controller = new ListDetailController($model);
    $controller->execute();
}
?>



