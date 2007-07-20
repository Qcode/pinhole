<?php

require_once 'Swat/Swat.php';
require_once 'Site/pages/SitePage.php';
require_once 'Admin/exceptions/AdminNotFoundException.php';
require_once 'Pinhole/PinholePhotoFactory.php';

/**
 * Page for processing uploaded photos
 *
 * This page is responsible for and decompressing, resizing, cropping and
 * database insertion required for new photos. It is triggered via javascript
 * when PinholePhotoUploadStatus has loaded.
 *
 * @package   Pinhole
 * @copyright 2007 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class PinholePhotoUploadProcessor extends SitePage
{
	// {{{ public function __construct()

	public function __construct(SiteApplication $app, SiteLayout $layout = null)
	{
		$layout = new SiteLayout($app,
			'Pinhole/layouts/xhtml/upload-processor.php');

		parent::__construct($app, $layout);
	}

	// }}}
	// {{{ public function process()

	/**
	 * Processes uploaded photo files
	 */
	public function process()
	{
		$photo_factory = new PinholePhotoFactory();
		$photo_factory->setPath(realpath('../'));
		$photo_factory->setDatabase($this->app->db);
		$photo_factory->processUploadedFile('file');
	}

	// }}}
	// {{{ public function build()

	/**
	 * Builds the layout content of this upload processor
	 *
	 * This displays the required inline JavaScript to mark that file
	 * processing is complete.
	 *
	 * @see PinholePhotoUploadProcessor::getInlineJavaScript()
	 */
	public function build()
	{
		$this->layout->startCapture('content');

		echo 'completed processing';

		//Swat::displayInlineJavaScript($this->getInlineJavaScript());

		$this->layout->endCapture();
	}

	// }}}
	// {{{ protected function getInlineJavaScript()

	/**
	 * Gets inline JavaScript that marks this file upload as complete
	 */
	protected function getInlineJavaScript()
	{
		return sprintf("window.parent.%s_obj.complete();\n", $id);
	}

	// }}}
}

?>
