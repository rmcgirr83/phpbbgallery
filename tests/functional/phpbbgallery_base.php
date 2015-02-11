<?php
/**
*
* Gallery Tests
*
* @copyright (c) 2014 Stanislav Atanasov
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/
namespace phpbbgallery\tests\functional;
/**
* @group functional
*/
class phpbbgallery_base extends \phpbb_functional_test_case
{
	private $path;
	static protected function setup_extensions()
	{
		return array('phpbbgallery/core', 'phpbbgallery/exif', 'phpbbgallery/acpimport', 'phpbbgallery/acpcleanup');
	}
	public function setUp()
	{
		parent::setUp();
		$this->path = __DIR__ . '/images/';
		
		// Let us create a user we will use for tests
		$this->create_user('testuser1');
		$this->add_user_group('REGISTERED', array('testuser1'));
		// Let me get admin out of registered
		$this->remove_user_group('REGISTERED', array('admin'));
		
	}	
	
	public function config_set($option, $value)
	{
		$this->get_db();
		$sql = 'UPDATE phpbb_config
			SET config_value = \'' . $value . '\'
			WHERE config_name = \'phpbb_gallery_' . $option . '\'';
		$this->db->sql_query($sql);
		$this->purge_cache();
	}
}