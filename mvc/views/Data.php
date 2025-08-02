<?php 
    namespace Site\Views;

    use InvalidArgumentException;

    class Data {
        private string $template;
        private array $data;

        public function __construct(
            string|Data $source, 
            array $data = []
        ) 
        {
            if (is_string($source)) {
                $filePath = dirname(__DIR__, 2) . '/templates/' . $source;
                if (!file_exists($filePath)) {
                    throw new InvalidArgumentException(
                        "File not found: " . $filePath
                    );
                }
                $this->setTemplate($source);
            } elseif ($source instanceof Data) {
                $this->setTemplate(
                    $source->getTemplate()
                );
            } else {
                throw new InvalidArgumentException(
                    "First argument must be a filepath or a Data object"
                );
            }
            $this->setData($data);
        }

        public function getData(): array
        {
            return $this->data;
        }

        public function getTemplate(): string
        {
            return $this->template ?? '';
        }

        private function setData(array $data): void
        {
            $this->data = $data;
        }
        
        private function setTemplate($template): void
        {
            $this->template = $template;
        }
    }
?>