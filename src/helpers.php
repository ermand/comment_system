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

/**
 * Include View.
 *
 * @param $file
 * @return mixed
 */
function includeView($file)
{
    return include('src/Views/' . $file .'.php');
}

/**
 * Require View.
 *
 * @param $file
 * @return mixed
 */
function requireView($file)
{
    return require 'src/Views/' . $file .'.php';
}

/**
 * Get view's path.
 *
 * @return string
 */
function viewsPath()
{
    return 'src/Views/';
}

/**
 * Get view's partials path.
 *
 * @return string
 */
function viewPartialsPath()
{
    return viewsPath() . 'Partials/';
}

/**
 * Get current value of POST based on input name.
 *
 * @param $input
 * @return string
 */
function getCurrentValue($input)
{
    return isset($_POST[$input]) ? $_POST[$input] : '';
}

/**
 * Find and convert plain url to Link.
 *
 * @param $string
 * @return string
 */
function plainUrlToLink($string) {
    return preg_replace('%(https?|ftp|www)://([-A-Z0-9./_*?&;=#]+)%i', '<a target="blank" rel="nofollow" href="$0" target="_blank">$0</a>', $string);
}

/**
 * Check if post is done by bots/spammers.
 */
function checkSpammer()
{
    if (isset($_POST['interested']))
    {
        // If it is AJAX request return true.
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }
        // Otherwise redirect back to create post form with status as spam.
        header('Location: /create?status=spam');
        exit;
    }
    else
    {
        return false;
    }
}

