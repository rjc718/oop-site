<?php 
namespace Site\Controllers;

use Site\Views\PhpTemplateView;
use Site\Models\Request;
use Site\Models\Pages\Interfaces\Insertable;
use Site\Models\Pages\Interfaces\Updatable;
use Site\Models\Pages\Interfaces\Deletable;
use Site\Models\Pages\Interfaces\Editable;

class ListDetailController
{
    private object $model;
    private PhpTemplateView $view;
    private Request $request;
    
    public function __construct(
        object $model
    ) {
        $this->model = $model;
        $this->view = PhpTemplateView::getInstance();
        $this->request = Request::getInstance();
    }

    public function execute(): void
    {
        $action = $this->request->getSafeWord('action', INPUT_POST); 
        $tmpl = null;

        //Each case will perform some action then return a Data object (view)
        switch (strtolower($action)) {
            case 'create':
                if ($this->model instanceof Insertable) 
                {
                    $tmpl = $this->model->create();
                }
                break;
            case 'insert':
                if ($this->model instanceof Insertable) 
                {
                    $tmpl = $this->model->insert();
                }
                break;
            case 'delete':
                if ($this->model instanceof Deletable) 
                {
                    $tmpl = $this->model->delete();
                }
                break;
            case 'deleteconfirm':
                if ($this->model instanceof Deletable) 
                {
                    $tmpl = $this->model->deleteConfirm();
                }
                break;
            case 'update':
                if ($this->model instanceof Updatable) 
                {
                    $tmpl = $this->model->update();
                }
                break;
            case 'edit':
                if ($this->model instanceof Editable) 
                {
                    $tmpl = $this->model->edit();
                }
                break;
            case 'list':
            default:
                $tmpl = $this->model->list();
                break;
        }

        if (!$tmpl) {
            throw new \RuntimeException(
                "Action '$action' is not supported by this model."
            );
        }

        echo $this->view->renderTemplate($tmpl);
        
        //Optionally wrap in a shell
        /*echo $this->view->renderTemplate(
            $this->model->displayPage($tmpl)
        );*/
    }
}

?>