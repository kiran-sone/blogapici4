<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Api\Posts;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/allposts', 'Home::getPosts');
$routes->get('/post/(:num)', 'Home::show/$1');

// API endpoints for RESTful Resource
$routes->get('api/posts/categs', [Posts::class, 'categs']);
$routes->delete('api/posts', [Posts::class, 'delete']);
$routes->resource('api/posts');
