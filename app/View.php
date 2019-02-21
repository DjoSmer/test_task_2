<?php

namespace App;

use Exception;

class View {

    /**
     * Папка где лежат шаблоны
     * folder where templates are located
     * @var string
     */
    private $views_dir = CONTENT_ROOT . DIRECTORY_SEPARATOR . 'views/';

    /**
     * название шаблона
     * current template name
     * @var string
     */
    private $template_name;

    /**
     * переменые шаблона.
     * current template arguments
     * @var array
     */
    private $template_args = [];

    /**
     * View constructor.
     * @param $template_name
     * @param array $template_args
     * @throws Exception
     */
    public function __construct($template_name, $template_args = []) {
        $this->template_name = $template_name;
        $this->template_args = $template_args;

        $this->template_path = $this->views_dir.$this->template_name.'.php';

        if (!file_exists($this->template_path)) {
            throw new Exception('Шаблон не найден.');
        }

    }

    /**
     * @return string
     */
    public function render() {
        foreach ($this->template_args as $key => $value) {
            ${$key} = $value;
        }
        ob_start();
        require($this->template_path);
        $template = ob_get_contents();
        ob_end_clean();

        return $template;
    }

}