<?php

require_once 'SwatDB/SwatDB.php';
require_once 'Pinhole/PinholeTagIntersection.php';
require_once 'Site/pages/SitePage.php';

/**
 * @package   Pinhole
 * @copyright 2007 silverorange
 */
abstract class PinholeBrowserPage extends SitePage
{
	// {{{ protected properties

	protected $tag_intersection;

	// }}}
	// {{{ public function __construct()

	public function __construct(SiteApplication $app, SiteLayout $layout, $tags = null)
	{
		parent::__construct($app, $layout);

		$this->tag_intersection = new PinholeTagIntersection($app->db);

		foreach (explode('/', $tags) as $tag)
			$this->tag_intersection->addTagByShortname($tag);
	}

	// }}}

	// init phase
	// {{{ public function init()

	public function init()
	{
		parent::init();

	}

	// }}}

	// build phase
	// {{{ public function build()

	public function build()
	{
		parent::build();

		$this->layout->startCapture('content');
		$this->displayIntersectingTags();
		$this->layout->endCapture();
	}

	// }}}
	// {{{ protected function displayIntersectingTags()

	protected function displayIntersectingTags()
	{
		$tags = $this->tag_intersection->getIntersectingTags();

		if (count($tags) == 0)
			return;

		echo '<ul class="intersecting-tag-list">';

		foreach ($tags as $tag) {
			echo '<li>';
			//$link = $this->source.'/'.$category->shortname;
			echo $tag->title;
			echo '</li>';
		}

		echo '</ul>';
	}

	// }}}
}

?>
