<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/place.php";

    session_start();
    if (empty($_SESSION['places'])) {
        $_SESSION['places'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use($app) {

        return $app['twig']->render('places.php', array('places' => Place::getAll()));
    });

    $app->post("/places", function() use($app) {
        $place = new Place($_POST['city'], $_POST['country']);
        $place->save();

        return $app['twig']->render('places.php', array('places' => Place::getAll()));

    });

    $app->post("/", function() use($app) {
        Place::deleteAll();
        return $app['twig']->render('places.php');

    });

    return $app;
?>
