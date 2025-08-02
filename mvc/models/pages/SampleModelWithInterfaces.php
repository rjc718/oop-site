<?php 
    namespace Sites\Models\Pages;

    use Sites\Models\Pages\ListDetailPage;
    use Sites\Models\Pages\Interfaces\Deletable;
    use Sites\Models\Pages\Traits\HasDelete;
    use Sites\Models\Pages\Interfaces\Updatable;
    use Sites\Models\Pages\Traits\HasUpdate;
    use Sites\Views\Data;

    /**
     * You must implement any function defined in any interfaces that are implemented
     * Must also include use appropiate trait
     */
    
    class LaborReport extends ListDetailPage implements Deletable, Updatable
    {
        use HasDelete, HasUpdate;

        private const TMPL_BASE = 'test/actions/';

        public function __construct() {}
    
        public function list(): Data {
            //Build and Display List Page
            return new Data(self::TMPL_BASE . 'list.php');
        }

        public function edit(): Data {
            //Display single record
            return new Data(self::TMPL_BASE . 'edit.php');
        }

        public function updateProcess(): void {
            // Add logic to update existing record
        }

        public function updateMessage(): Data {
            return new Data(self::TMPL_BASE . 'update.php');
        }
        
        public function deleteProcess(): void {
            // Add logic to delete record
        };
        
        public function deleteMessage(): Data {
            return new Data(self::TMPL_BASE . 'delete-message.php');
        };

        public function deleteConfirm(): Data
        {
            return new Data(self::TMPL_BASE . 'delete-confirm.php');
        }

    }
?>