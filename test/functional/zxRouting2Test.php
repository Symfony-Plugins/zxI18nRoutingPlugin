<?php

/*
 * This file is part of the zxI18nRoutingPlugin package.
 * (c) ZAANAX www.zaanax.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this plugin.
 */

$app = 'routing2';
include(dirname(__FILE__).'/../bootstrap/functional.php');

$b = new sfTestBrowser();
$b->test()->diag("");
$b->test()->diag("Testing routes generating");
$b->test()->diag("----------------------------------------------------------------------------");
$b->test()->diag("sf_i18n: true, culture_into_url: false, use_cultures: [en, de, pl, fr]");
$b->test()->diag("XLIFF files exists for \"de\" and \"pl\"");
$b->test()->diag("----------------------------------------------------------------------------");
$routing = sfContext::getInstance()->getRouting();
foreach ($routing->getRoutes() as $name => $route)
{
  $defaults = $route->getDefaults();
  $culture = isset($defaults['sf_culture']) ? "(sf_culture = ".$defaults['sf_culture'].")" : null;
  $b->test()->diag($name." => ".$route->getPattern()." ".$culture);
}
$b->test()->diag("----------------------------------------------------------------------------");
// default culture (en)
$b->
  get('/')->
  isStatusCode(200)->
  isUserCulture('en')
;

// choosen culture (pl)
$b->
  get('/pl/')->
  isStatusCode(404)->
  isUserCulture('en')
;

// choosen culture (en)
$b->
  get('/test/group/view')->
  isStatusCode(200)->
  isUserCulture('en')
;

// choosen culture (pl)
$b->
  get('/testowanie/grupa/edycja')->
  isStatusCode(200)->
  isUserCulture('pl')
;

// choosen culture (de)
$b->
  get('/test/gruppe/sicht')->
  isStatusCode(200)->
  isUserCulture('de')
;

// 
$b->
  get('/test/group/view')->
  isStatusCode(200)->
  isUserCulture('de')
;
$b->test()->diag("Notice the difference between results of test 6 and 12 ");
$b->test()->diag("Culture is not changed. (de) is current user culture after previous test");


$b->test()->diag("URL generating on the base routing (current culture is \"de\" after previous test)");
// dedicated routing for "de" exists
$b->test()->is(url_for('xz_test_route_1'),'/index.php/test/gruppe/sicht',"url_for('xz_test_route_1') gives /index.php/test/gruppe/sicht");
// default routing is used because "en" dedicated routing is not available
$b->test()->is(url_for('xz_test_route_1',array('sf_culture' => sfConfig::get('sf_default_culture'))),'/index.php/test/group/view',"url_for('xz_test_route_1',array('sf_culture' => sfConfig::get('sf_default_culture'))) gives /index.php/test/group/view");
// dedicated routings for "pl" and "de" exist
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'pl')),'/index.php/testowanie/grupa/widok',"url_for('xz_test_route_1',array('sf_culture'=>'pl')) gives /index.php/testowanie/grupa/widok");
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'de')),'/index.php/test/gruppe/sicht',"url_for('xz_test_route_1',array('sf_culture'=>'de')) gives /index.php/test/gruppe/sicht");

// default routing is used because "fr" and "se" dedicated routings are not available
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'fr')),'/index.php/test/group/view',"url_for('xz_test_route_1',array('sf_culture'=>'fr')) gives /index.php/test/group/view");
$b->test()->is(url_for('xz_test_route_1',array('sf_culture'=>'se')),'/index.php/test/group/view',"url_for('xz_test_route_1',array('sf_culture'=>'se')) gives /index.php/test/group/view");

$b->test()->diag("URL generating after culture change to \"pl\"");
sfContext::getInstance()->getUser()->setCulture('pl');
$b->test()->is(url_for('xz_test_route_1'),'/index.php/testowanie/grupa/widok',"url_for('xz_test_route_1') gives /index.php/testowanie/grupa/widok");

