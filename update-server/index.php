<?php
/**
 * ownCloud
 *
 * @author Lukas Reschke <lukas@owncloud.com>
 * @copyright Copyright (c) 2016, ownCloud GmbH.
 *
 * This code is covered by the ownCloud Commercial License.
 *
 * You should have received a copy of the ownCloud Commercial License
 * along with this program. If not, see <https://owncloud.com/licenses/owncloud-commercial/>.
 *
 */
require_once __DIR__ . '/vendor/autoload.php';

// Set Content-Type to XML
header('Content-Type: application/xml');
// Enforce browser based XSS filters
header('X-XSS-Protection: 1; mode=block');
// Disable sniffing the content type for IE
header('X-Content-Type-Options: nosniff');
// Disallow iFraming from other domains
header('X-Frame-Options: Sameorigin');
// https://developers.google.com/webmasters/control-crawl-index/docs/robots_meta_tag
header('X-Robots-Tag: none');

// Return empty response if no version is supplied
if(!isset($_GET['version']) || !is_string($_GET['version'])) {
	exit();
}

// Parse the request
try {
	$request = new \UpdateServer\Request($_GET['version'], $_SERVER);
} catch (\UpdateServer\Exceptions\UnsupportedReleaseException $e) {
	exit();
}

$config = new \UpdateServer\Config(__DIR__ . '/config/config.php');

// Return a response
$response = new \UpdateServer\Response($request, $config);
echo $response->buildResponse();
