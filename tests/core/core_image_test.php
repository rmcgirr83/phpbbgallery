<?php

/**
*
* PhpBB Gallery extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Lucifer <https://www.anavaro.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbbgallery\tests\core;
/**
* @group core
*/
require_once dirname(__FILE__) . '/../../../../includes/functions.php';

class core_image_test extends core_base
{
	public function setUp()
	{
		parent::setUp();

		$this->album = new \phpbbgallery\core\album\album(
			$this->db,
			$this->user,
			'phpbb_gallery_albums',
			'phpbb_gallery_watch',
			'phpbb_gallery_contests'
		);

		$this->gallery_cache = new \phpbbgallery\core\cache(
			$this->cache,
			$this->db,
			'phpbb_gallery_albums',
			'phpbb_gallery_images'
		);

		$this->gallery_user = new \phpbbgallery\core\user(
			$this->db,
			$this->dispatcher,
			'phpbb_gallery_users'
		);

		$this->gallery_auth = new \phpbbgallery\core\auth\auth(
			$this->gallery_cache,
			$this->db,
			$this->gallery_user,
			$this->user,
			$this->auth,
			'phpbb_gallery_permissions',
			'phpbb_gallery_roles',
			'phpbb_gallery_users',
			'phpbb_gallery_albums'
		);
		$this->gallery_config = new \phpbbgallery\core\config(
			$this->config
		);

		$this->url = new \phpbbgallery\core\url(
			$this->template,
			$this->request,
			$this->config,
			'phpBB/',
			'php'
		);

		$this->log = new \phpbbgallery\core\log(
			$this->db,
			$this->user,
			$this->user_loader,
			$this->template,
			$this->controller_helper,
			$this->pagination,
			$this->gallery_auth,
			$this->gallery_config,
			'phpbb_gallery_log'
		);
		$this->notification_helper = $this->getMockBuilder('\phpbbgallery\core\notification\helper')
			->disableOriginalConstructor()
			->getMock();

		$this->report = new \phpbbgallery\core\report(
			$this->log,
			$this->gallery_auth,
			$this->user,
			$this->db,
			$this->user_loader,
			$this->album,
			$this->template,
			$this->controller_helper,
			$this->gallery_config,
			$this->pagination,
			$this->notification_helper,
			'phpbb_gallery_images',
			'phpbb_gallery_reports'
		);
		$this->file = new \phpbbgallery\core\file\file(
			$this->request,
			$this->url,
			2
		);
		$this->contest = new \phpbbgallery\core\contest(
			$this->db,
			$this->gallery_config,
			'phpbb_gallery_images',
			'phpbb_gallery_contests'
		);
		$this->image = new \phpbbgallery\core\image\image(
			$this->db,
			$this->user,
			$this->template,
			$this->dispatcher,
			$this->gallery_auth,
			$this->album,
			$this->gallery_config,
			$this->controller_helper,
			$this->url,
			$this->log,
			$this->notification_helper,
			$this->report,
			$this->gallery_cache,
			$this->gallery_user,
			$this->contest,
			$this->file,
			'phpbb_gallery_images'
		);
	}

	public function test_get_status_orphan()
	{
		$this->assertEquals($this->image->get_status_orphan(), 3);
	}
	public function test_get_status_unaproved()
	{
		$this->assertEquals($this->image->get_status_unapproved(), 0);
	}
	public function test_get_status_aproved()
	{
		$this->assertEquals($this->image->get_status_approved(), 1);
	}
	public function test_get_status_locked()
	{
		$this->assertEquals($this->image->get_status_locked(), 2);
	}
	public function test_get_no_contest()
	{
		$this->assertEquals($this->image->get_no_contest(), 0);
	}
	public function test_get_in_contest()
	{
		$this->assertEquals($this->image->get_in_contest(), 1);
	}

	/*
	 * Provide data for get user_info
	 */
	public function data_get_new_author_info()
	{
		return array(
			'admin' => array(
				'admin', //request
				array(
					'username'	=> 'admin',
					'user_colour'	=> '',
					'user_id'		=> 2
				)
			),
			'none' => array(
				'blabla', //request
				false
			),
		);
	}

	/**
	 * Test get_new_author_info
	 * @dataProvider data_get_new_author_info
	 **/
	public function test_get_new_author_info($request, $expected)
	{
		$this->assertEquals($expected, $this->image->get_new_author_info($request));
	}


	/**
	 * TODO: Add tests for delete_images()
	 **/
	/**
	 * This is data for test_get_filenames
	 */
	public function data_get_filenames()
	{
		return array(
			'all_array' => array(
				array(1, 2, 3, 4, 5, 6), //Request
				array( // Response
					1	=> 'md5hashednamefor1.jpg',
					2	=> 'md5hashednamefor2.jpg',
					3	=> 'md5hashednamefor3.jpg',
					4	=> 'md5hashednamefor4.jpg',
					5	=> 'md5hashednamefor5.jpg',
					6	=> 'md5hashednamefor6.jpg'
				)
			),
			'single_array'	=> array(
				array(1), //Request
				array( // Response
					1	=> 'md5hashednamefor1.jpg'
				)
			),
			'single_int'	=> array(
				1, //Request
				array( // Response
					1	=> 'md5hashednamefor1.jpg'
				)
			),
			'invalid'	=> array(
				array(11), //Request
				array() // Respons
			)
		);
	}

	/**
	 * This tests the get_filenames
	 * @dataProvider data_get_filenames
	 */
	public function test_get_filenames($request, $expected)
	{
		$this->assertEquals($expected, $this->image->get_filenames($request));
	}

	/**
	 * TODO: Add test for generate_link
	 */

	/**
	 * TODO: Add test for handle_counter
	 */

	/**
	 * TODO: Add test for get_image_data
	 */

	/**
	 * TODO: Add test for approve_images
	 */

	/**
	 * TODO: Add test for unapprove_images
	 */

	/**
	 * TODO: Add test for move_image
	 */

	/**
	 * TODO: Add test for lock_image
	 */

	/**
	 * TODO: Add test for get_last_image
	 */

	/**
	 * Test for assign_block is done in tests\core\core_search_test
	 */
}