<?php
use Jenssegers\Blade\Blade;
class Controller
{
    function render($path, array $parameters = [])
    {
        $blade = new Blade(ROOT_FOLDER . 'Views', ROOT_FOLDER . 'cache');
        ob_start();

        echo $blade->render($path, $parameters);
    }

    private function secure_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    protected function secure_form($form)
    {
        foreach ($form as $key => $value)
        {
            $form[$key] = $this->secure_input($value);
        }
    }
}