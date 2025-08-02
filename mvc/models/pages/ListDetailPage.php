<?php 
    namespace Site\Models\Pages;

    use Site\Views\Data;

    /**
     * Can list individual records by default
     * Any child class can implement Insertable, Updatable, Editable or Deletable
     * to gain that functionality.
     * 
     * 
     */

    abstract class ListDetailPage
    {
        /* Display a collection of records*/
        public abstract function list(): Data;
    }
?>