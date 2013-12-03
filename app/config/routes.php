<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * The routes file is where you define your URL structure, which is an important part of the
 * [information architecture](http://en.wikipedia.org/wiki/Information_architecture) of your
 * application. Here, you can use _routes_ to match up URL pattern strings to a set of parameters,
 * usually including a controller and action to dispatch matching requests to. For more information,
 * see the `Router` and `Route` classes.
 *
 * @see lithium\net\http\Router
 * @see lithium\net\http\Route
 */
use lithium\net\http\Router;
use lithium\core\Environment;

/**
 * With globalization enabled a localized route is configured by connecting a
 * continuation route. Once the route has been connected, all the other
 * application routes become localized and may now carry a locale.
 *
 * Requests to routes like `/en/posts/edit/1138` or `/fr/posts/edit/1138` will
 * carry a locale, while `/posts/edit/1138` keeps on working as it did before.
 */
if ($locales = Environment::get('locales')) {
	$template = '/{:locale:' . join('|', array_keys($locales)) . '}/{:args}';
	Router::connect($template, array(), array('continue' => true));
}

// Environment::set('production');

/**
 * Here, we are connecting `'/'` (the base path) to controller called `'Pages'`,
 * its action called `view()`, and we pass a param to select the view file
 * to use (in this case, `/views/pages/home.html.php`; see `app\controllers\PagesController`
 * for details).
 *
 * @see app\controllers\PagesController
 */
Router::connect('/', 'index::index');

/**
 * Connect the rest of `PagesController`'s URLs. This will route URLs like `/pages/about` to
 * `PagesController`, rendering `/views/pages/about.html.php` as a static page.
 */
// Router::connect('/pages/{:args}', 'Pages::view');

/**
 * Add the testing routes. These routes are only connected in non-production environments, and allow
 * browser-based access to the test suite for running unit and integration tests for the Lithium
 * core, as well as your own application and any other loaded plugins or frameworks. Browse to
 * [http://path/to/app/test](/test) to run tests.
 */
if (!Environment::is('production')) {
	Router::connect('/test/{:args}', array('controller' => 'lithium\test\Controller'));
	Router::connect('/test', array('controller' => 'lithium\test\Controller'));
}
/**
 * ### Database object routes
 *
 * The routes below are used primarily for accessing database objects, where `{:id}` corresponds to
 * the primary key of the database object, and can be accessed in the controller as
 * `$this->request->id`.
 *
 * If you're using a relational database, such as MySQL, SQLite or Postgres, where the primary key
 * is an integer, uncomment the routes below to enable URLs like `/posts/edit/1138`,
 * `/posts/view/1138.json`, etc.
 */
// Router::connect('/{:controller}/{:action}/{:id:\d+}.{:type}', array('id' => null));
// Router::connect('/{:controller}/{:action}/{:id:\d+}');

/**
 * If you're using a document-oriented database, such as CouchDB or MongoDB, or another type of
 * database which uses 24-character hexidecimal values as primary keys, uncomment the routes below.
 */
// Router::connect('/{:controller}/{:action}/{:id:[0-9a-f]{24}}.{:type}', array('id' => null));
// Router::connect('/{:controller}/{:action}/{:id:[0-9a-f]{24}}');

/**
 * Finally, connect the default route. This route acts as a catch-all, intercepting requests in the
 * following forms:
 *
 * - `/foo/bar`: Routes to `FooController::bar()` with no parameters passed.
 * - `/foo/bar/param1/param2`: Routes to `FooController::bar('param1, 'param2')`.
 * - `/foo`: Routes to `FooController::index()`, since `'index'` is assumed to be the action if none
 *   is otherwise specified.
 *
 * In almost all cases, custom routes should be added above this one, since route-matching works in
 * a top-down fashion.
 */

Router::connect('/products/index/{:catId:[0-9]+}/{:brandId:[0-9]+}/{:args}', 'Products::index');
Router::connect('/products/index/{:catId:[0-9]+}/page:{:page:[0-9]+}/{:args}', 'Products::index');
Router::connect('/products/index/{:catId:[0-9]+}/{:args}', 'Products::index');
Router::connect('/products/index/{:catId:[0-9]+}/{:brandId:[0-9]+}/page:{:page:[0-9]+}/{:args}', 'Products::index');
Router::connect('/products/view/{:id}/{:periodId}', 'Products::view');
Router::connect('/products/cat/{:catId:[0-9]+}/{:args}', 'Products::cat');
Router::connect('/products/brand/{:catId:[0-9]+}/{:args}', 'Products::brand');
Router::connect('/products/listing/{:status}/{:tagId}/{:id}', 'Products::listing');
Router::connect('/products/listing/{:status}/{:id}', 'Products::listing');
Router::connect('/products/edit/{:id}', 'Products::edit');
Router::connect('/products/lottery/{:productId}/{:periodId}', 'Products::lottery');

Router::connect('/search/index/{:title}/page:{:page:[0-9]+}/{:args}', 'Search::index');
Router::connect('/search/index/{:title}/{:args}', 'Search::index');

Router::connect('/shares/share/{:typeId:[0-9]+}/{:args}', 'Shares::share');
Router::connect('/shares/share/{:typeId:[0-9]+}/page:{:page:[0-9]+}/{:args}', 'Shares::share');
Router::connect('/shares/dashboard/{:typeId:[0-9]+}/{:args}', 'Shares::dashboard');
Router::connect('/shares/dashboard/{:typeId:[0-9]+}/page:{:page:[0-9]+}/{:args}', 'Shares::dashboard');
Router::connect('/shares/view/{:productId}/{:periodId}', 'Shares::view');
Router::connect('/shares/add/{:productId}/{:periodId}', 'Shares::add');

Router::connect('/shares/product/{:productId}/page:{:page:[0-9]+}/{:args}', 'Shares::product');
Router::connect('/shares/product/{:productId}/{:args}', 'Shares::product');
Router::connect('/orders/product/{:productId}/{:periodId}/page:{:page:[0-9]+}/{:args}', 'Orders::product');
Router::connect('/orders/product/{:productId}/{:periodId}/{:args}', 'Orders::product');

Router::connect('/posts/comment/{:postId}/page:{:page:[0-9]+}/{:args}', 'Posts::comment');
Router::connect('/posts/comment/{:postId}/{:args}', 'Posts::comment');
Router::connect('/posts/notice/{:postId}/{:args}', 'Posts::notice');

Router::connect('/{:controller}/{:action}/page:{:page:[0-9]+}/{:args}');
Router::connect('/{:controller}/{:action}/{:args}');

?>
