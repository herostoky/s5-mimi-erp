<?php

function load_view_set ($controller, $view_name, $options) {
    $controller->load->view("partials/head");
    $controller->load->view("partials/menu", $options['menu']);
    $controller->load->view($view_name, $options['current']);
}

?>
