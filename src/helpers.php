<?php

/**
 * Clean string from spaces and special characters.
 *
 * @param  $input
 * @return mixed
 */
function clean($input)
{
    return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', trim($input)));
}

/**
 * Include header.
 *
 * @return mixed
 */
function includeHeader()
{
    return include('src/Views/Partials/header.php');
}

/**
 * Include footer.
 *
 * @return mixed
 */
function includeFooter()
{
    return include('src/Views/Partials/footer.php');
}

function includeView($file)
{
    return include('src/Views/' . $file .'.php');
}

function requireView($file)
{
    return require 'src/Views/' . $file .'.php';
}

function viewsPath()
{
    return 'src/Views/';
}

function viewPartialsPath()
{
    return viewsPath() . 'Partials/';
}

function controllersPath()
{
    return 'src/Controllers/';
}
