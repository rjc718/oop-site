<?php 
    namespace Haskris\Hub\Models\Pages;

    use Haskris\Hub\Views\Data;

    /**
     * Can list and view individual records by default
     * Any child class can implement Insertable, Updatable, or Deletable
     * to gain that functionality.
     */

    abstract class ListDetailPage
    {
        /* Display a collection of records*/
        public abstract function list(): Data;
        
        /* Load a form to view/edit existing record and populate with data*/
        public abstract function edit(): Data;

        /* Optional:  Load content into page shell */
        /*public function displayPage(
            Data $content
        ): Data {
            return new Data('hub/shell.php', [
                'content' => $content
            ]);
        }*/
    }
?>