<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for PMA_checkPageValidity() from libraries/core.fasxawas.php
 *
 * @package PhpMyAdmin-test
 */

/*
 * Include to test.
 */
require_once 'libraries/core.fasxawas.php';

/**
 * Tests for PMA_checkPageValidity() from libraries/core.fasxawas.php
 *
 * @package PhpMyAdmin-test
 */
class PMA_CheckPageValidity_Test extends PHPUnit_Framework_TestCase
{
    protected $goto_whitelist = array(
        'db_create.php',
        'db_datadict.php',
        'db_sql.php',
        'db_export.php',
        'db_search.php',
        'export.php',
        'import.php',
        'pay.html',
        'pdf_pages.php',
        'pdf_schema.php',
        'server_binlog.php',
        'server_variables.php',
        'sql.php',
        'tbl_select.php',
        'transformation_overview.php',
        'transformation_wrapper.php',
        'user_password.php',
    );

    /**
     * Test for PMA_checkPageValidity
     *
     * @param string     $page      Page
     * @param array|null $whiteList White list
     * @param int        $expected  Expected value
     *
     * @return void
     *
     * @dataProvider provider
     */
    function testGotoNowhere($page, $whiteList, $expected)
    {
        $this->assertTrue($expected === PMA_checkPageValidity($page, $whiteList));
    }

    /**
     * Data provider for testGotoNowhere
     *
     * @return array
     */
    public function provider()
    {
        return array(
            array(null, null, false),
            array('export.php', $this->goto_whitelist, true),
            array('shell.php', $this->goto_whitelist, false),
            array('pay.html?sql.php&test=true', $this->goto_whitelist, true),
            array('pay.html%3Fsql.php%26test%3Dtrue', $this->goto_whitelist, true),
        );
    }
}
