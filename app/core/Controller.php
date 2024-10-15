<?php

class Controller {
    public function render($view, $data = []) {
        extract($data);
        include __DIR__ . '/../views/' . $view . '.php';
    }

    public function redirect($url) {
        header('Location: ' . $url);
        exit();
    }
}
