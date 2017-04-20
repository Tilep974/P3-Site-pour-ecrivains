<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

ErrorHandler::register();
ExceptionHandler::register();

$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array( 'twig.path' => __DIR__.'/../views',));
$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
	$twig->addExtension(new Twig_Extensions_Extension_text());
	return $twig;
});
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\AssetServiceProvider(), array( 'assets.version' => 'v1'));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array (
	'security.firewalls' => array(
		'secured' => array(
			'pattern' => '^/',
			'anonymous' => true,
			'logout' => true,
			'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
			'users' => function () use ($app) {
				return new Livre\DAO\UserDAO($app['db']);
			},
		),
	),
	'security.role_hierarchy' => array(
		'ROLE_ADMIN' => array('ROLE_USER'),
	),
	'security.acces_rules' => array(
		array('^/admin', 'ROLE_ADMIN'),
	),
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app['dao.article'] = function ($app) {
	return new Livre\DAO\ArticleDAO($app['db']);
};
$app['dao.user'] = function ($app) {
	return new Livre\DAO\UserDAO($app['db']);
};
$app['dao.comment'] = function ($app) {
	$commentDAO = new Livre\DAO\CommentDAO($app['db']);
	$commentDAO->setArticleDAO($app['dao.article']);
	$commentDAO->setUserDAO($app['dao.user']);
	return $commentDAO;
};