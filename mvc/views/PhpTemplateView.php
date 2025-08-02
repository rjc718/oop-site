<?php 
namespace Site\Views;

use InvalidArgumentException;

/**
 * PhpTemplateView
 *
 * Singleton class responsible for rendering PHP templates.
 * 
 * Provides methods to render templates with data passed as arrays,
 * supports rendering collections of Data objects, and safely includes
 * templates by verifying their existence.
 *
 * The templates are loaded from a predefined directory relative to the
 * project structure.
 */

class PhpTemplateView
{
    private string $path;
    private static ?PhpTemplateView $view = null;
 
    private function __construct()
    {
        $this->path = dirname(__DIR__, 2) . '/templates/';
    }
 
    public static function getInstance(): PhpTemplateView
    {
        if (empty(self::$view)) {
            self::$view = new self();
        }
        return self::$view;
    }

    /* This function renders the contents of a specified template file as a string */    
    public function render(string $template, array $data = [])
    {
        if (!file_exists($this->path . $template)) {
            throw new InvalidArgumentException(
                "The template file: '$template' could not be found"
            );
        }

        // Pre-process the $data array to render nested Data or Collection objects
        foreach ($data as $key => $value) {
            if ($value instanceof Data) {
                $data[$key] = $this->renderTemplate($value);
            } elseif ($value instanceof Collection) {
                $renderedItems = array_map(
                    fn(Data $item) => $this->renderTemplate($item),
                    $value->getAll()
                );
                $data[$key] = implode("\n", $renderedItems);
            }
        }

        // Make variables available to the template
        if (!empty($data)) {
            extract($data);
        }

        ob_start();
        include $this->path . $template;
        return ob_get_clean();
    }

    /**
     * This function renders a Views/Data.php object as a string
     *
     * It will also render a Collection of Views/Data.php objects
     * if the collection is stored in it's data property
     * accessible via the getData() method
     * 
     * It will not render a Collection on it's own
     * Collection must be appended to a Data object
     */
    public function renderTemplate(Data $data): string
    {
        return $this->render(
            $data->getTemplate(),
            $data->getData()
        ) ?? '';
    }
}
 