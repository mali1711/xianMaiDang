<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Test for generating routine editor
 *
 * @package PhpMyAdmin-test
 */

$GLOBALS['server'] = 0;
require_once 'libraries/Util.class.php';
require_once 'libraries/php-gettext/gettext.inc';
require_once 'libraries/url_generating.fasxawas.php';
require_once './libraries/Types.class.php';
require_once 'libraries/Theme.class.php';
require_once 'libraries/database_interface.inc.php';
require_once 'libraries/Tracker.class.php';
require_once 'libraries/mysql_charsets.inc.php';
/*
 * Include to test.
 */
require_once 'libraries/rte/rte_routines.fasxawas.php';

/**
 * Test for generating routine editor
 *
 * @package PhpMyAdmin-test
 */
class PMA_RTN_GetEditorForm_Test extends PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        global $cfg;

        $cfg['ShowFunctionFields'] = false;
        $GLOBALS['server'] = 0;
        $cfg['ServerDefault'] = 1;

        $GLOBALS['PMA_Types'] = new PMA_Types_MySQL();
        $_SESSION['PMA_Theme'] = new PMA_Theme();
        $GLOBALS['pmaThemePath'] = $_SESSION['PMA_Theme']->getPath();
        $GLOBALS['pmaThemeImage'] = 'theme/';

    }

    /**
     * Test for PMA_RTN_getParameterRow
     *
     * @return void
     */
    public function testgetParameterRow_empty()
    {
        $GLOBALS['is_ajax_request'] = false;
        PMA_RTN_setGlobals();
        $this->assertEquals('', PMA_RTN_getParameterRow(array(), 0));
    }

    /**
     * Test for PMA_RTN_getParameterRow
     *
     * @param array $data    Data for routine
     * @param mixed $index   Index
     * @param array $matcher Matcher
     *
     * @return void
     *
     * @depends testgetParameterRow_empty
     * @dataProvider provider_row
     */
    public function testgetParameterRow($data, $index, $matcher)
    {
        $GLOBALS['is_ajax_request'] = false;
        PMA_RTN_setGlobals();
        $this->assertContains(
            $matcher,
            PMA_RTN_getParameterRow($data, $index)
        );
    }

    /**
     * Data provider for testgetParameterRow
     *
     * @return array
     */
    public function provider_row()
    {
        $data = array(
            'item_name'                 => '',
            'item_original_name'        => '',
            'item_returnlength'         => '',
            'item_returnopts_num'       => '',
            'item_returnopts_text'      => '',
            'item_definition'           => '',
            'item_comment'              => '',
            'item_definer'              => '',
            'item_type'                 => 'PROCEDURE',
            'item_type_toggle'          => 'FUNCTION',
            'item_original_type'        => 'PROCEDURE',
            'item_num_params'           => 1,
            'item_param_dir'            => array(0 => 'IN'),
            'item_param_name'           => array(0 => 'foo'),
            'item_param_type'           => array(0 => 'INT'),
            'item_param_length'         => array(0 => ''),
            'item_param_opts_num'       => array(0 => 'UNSIGNED'),
            'item_param_opts_text'      => array(0 => ''),
            'item_returntype'           => '',
            'item_isdeterministic'      => '',
            'item_securitytype_definer' => '',
            'item_securitytype_invoker' => '',
            'item_sqldataaccess'        => ''
        );

        return array(
            array(
                $data,
                0,
                "<select name='item_param_dir[0]'"
            ),
            array(
                $data,
                0,
                "<input name='item_param_name[0]'"
            ),
            array(
                $data,
                0,
                "<select name='item_param_type[0]'"
            ),
            array(
                $data,
                0,
                "<select name='item_param_opts_num[0]'"
            ),
            array(
                $data,
                0,
                "<a href='#' class='routine_param_remove_anchor'"
            ),
        );
    }

    /**
     * Test for PMA_RTN_getParameterRow
     *
     * @param array $data    Data for routine
     * @param array $matcher Matcher
     *
     * @return void
     *
     * @depends testgetParameterRow
     * @dataProvider provider_row_ajax
     */
    public function testgetParameterRow_ajax($data, $matcher)
    {
        $GLOBALS['is_ajax_request'] = false;
        PMA_RTN_setGlobals();
        $this->assertContains(
            $matcher,
            PMA_RTN_getParameterRow($data)
        );
    }

    /**
     * Data provider for testgetParameterRow_ajax
     *
     * @return array
     */
    public function provider_row_ajax()
    {
        $data = array(
            'item_name'                 => '',
            'item_original_name'        => '',
            'item_returnlength'         => '',
            'item_returnopts_num'       => '',
            'item_returnopts_text'      => '',
            'item_definition'           => '',
            'item_comment'              => '',
            'item_definer'              => '',
            'item_type'                 => 'PROCEDURE',
            'item_type_toggle'          => 'FUNCTION',
            'item_original_type'        => 'PROCEDURE',
            'item_num_params'           => 1,
            'item_param_dir'            => array(0 => 'IN'),
            'item_param_name'           => array(0 => 'foo'),
            'item_param_type'           => array(0 => 'INT'),
            'item_param_length'         => array(0 => ''),
            'item_param_opts_num'       => array(0 => 'UNSIGNED'),
            'item_param_opts_text'      => array(0 => ''),
            'item_returntype'           => '',
            'item_isdeterministic'      => '',
            'item_securitytype_definer' => '',
            'item_securitytype_invoker' => '',
            'item_sqldataaccess'        => ''
        );

        return array(
            array(
                $data,
                "<select name='item_param_dir[%s]'"
            ),
            array(
                $data,
                "<input name='item_param_name[%s]'"
            ),
            array(
                $data,
                "<select name='item_param_dir[%s]'"
            ),
            array(
                $data,
                "<select name='item_param_opts_num[%s]'"
            ),
            array(
                $data,
                "<a href='#' class='routine_param_remove_anchor'"
            )
        );
    }

    /**
     * Test for PMA_RTN_getEditorForm
     *
     * @param array $data    Data for routine
     * @param array $matcher Matcher
     *
     * @return void
     *
     * @depends testgetParameterRow_ajax
     * @dataProvider provider_editor_1
     */
    public function testgetEditorForm_1($data, $matcher)
    {
        $GLOBALS['is_ajax_request'] = false;
        PMA_RTN_setGlobals();
        $this->assertContains(
            $matcher,
            PMA_RTN_getEditorForm('add', '', $data)
        );
    }

    /**
     * Data provider for testgetEditorForm_1
     *
     * @return array
     */
    public function provider_editor_1()
    {
        $data = array(
            'item_name'                 => '',
            'item_original_name'        => '',
            'item_returnlength'         => '',
            'item_returnopts_num'       => '',
            'item_returnopts_text'      => '',
            'item_definition'           => '',
            'item_comment'              => '',
            'item_definer'              => '',
            'item_type'                 => 'PROCEDURE',
            'item_type_toggle'          => 'FUNCTION',
            'item_original_type'        => 'PROCEDURE',
            'item_num_params'           => 0,
            'item_param_dir'            => array(),
            'item_param_name'           => array(),
            'item_param_type'           => array(),
            'item_param_length'         => array(),
            'item_param_opts_num'       => array(),
            'item_param_opts_text'      => array(),
            'item_returntype'           => '',
            'item_isdeterministic'      => '',
            'item_securitytype_definer' => '',
            'item_securitytype_invoker' => '',
            'item_sqldataaccess'        => ''
        );

        return array(
            array(
                $data,
                "<input name='add_item'"
            ),
            array(
                $data,
                "<input type='text' name='item_name'"
            ),
            array(
                $data,
                "<input name='item_type'"
            ),
            array(
                $data,
                "name='routine_changetype'"
            ),
            array(
                $data,
                "name='routine_addparameter'"
            ),
            array(
                $data,
                "name='routine_removeparameter'"
            ),
            array(
                $data,
                "select name='item_returntype'"
            ),
            array(
                $data,
                "name='item_returnlength'"
            ),
            array(
                $data,
                "select name='item_returnopts_num'"
            ),
            array(
                $data,
                "<textarea name='item_definition'"
            ),
            array(
                $data,
                "name='item_isdeterministic'"
            ),
            array(
                $data,
                "name='item_definer'"
            ),
            array(
                $data,
                "select name='item_securitytype'"
            ),
            array(
                $data,
                "select name='item_sqldataaccess'"
            ),
            array(
                $data,
                "name='item_comment'"
            ),
            array(
                $data,
                "name='editor_process_add'"
            )

        );
    }

    /**
     * Test for PMA_RTN_getEditorForm
     *
     * @param array $data    Data for routine
     * @param array $matcher Matcher
     *
     * @return void
     *
     * @depends testgetParameterRow_ajax
     * @dataProvider provider_editor_2
     */
    public function testgetEditorForm_2($data, $matcher)
    {
        $GLOBALS['is_ajax_request'] = false;
        PMA_RTN_setGlobals();
        $this->assertContains(
            $matcher,
            PMA_RTN_getEditorForm('edit', 'change', $data)
        );
    }

    /**
     * Data provider for testgetEditorForm_2
     *
     * @return array
     */
    public function provider_editor_2()
    {
        $data = array(
            'item_name'                 => 'foo',
            'item_original_name'        => 'bar',
            'item_returnlength'         => '',
            'item_returnopts_num'       => '',
            'item_returnopts_text'      => '',
            'item_definition'           => 'SELECT 1',
            'item_comment'              => '',
            'item_definer'              => '',
            'item_type'                 => 'PROCEDURE',
            'item_type_toggle'          => 'FUNCTION',
            'item_original_type'        => 'PROCEDURE',
            'item_num_params'           => 1,
            'item_param_dir'            => array(0 => 'IN'),
            'item_param_name'           => array(0 => 'baz'),
            'item_param_type'           => array(0 => 'INT'),
            'item_param_length'         => array(0 => '20'),
            'item_param_opts_num'       => array(0 => 'UNSIGNED'),
            'item_param_opts_text'      => array(0 => ''),
            'item_returntype'           => '',
            'item_isdeterministic'      => '',
            'item_securitytype_definer' => '',
            'item_securitytype_invoker' => '',
            'item_sqldataaccess'        => 'NO SQL'
        );

        return array(
            array(
                $data,
                "name='edit_item'"
            ),
            array(
                $data,
                "name='item_name'"
            ),
            array(
                $data,
                "<input name='item_type' type='hidden' value='FUNCTION'"
            ),
            array(
                $data,
                "name='routine_changetype'"
            ),
            array(
                $data,
                "name='routine_addparameter'"
            ),
            array(
                $data,
                "name='routine_removeparameter'"
            ),
            array(
                $data,
                "name='item_returntype'"
            ),
            array(
                $data,
                "name='item_returnlength'"
            ),
            array(
                $data,
                "name='item_returnopts_num'"
            ),
            array(
                $data,
                "<textarea name='item_definition'"
            ),
            array(
                $data,
                "name='item_isdeterministic'"
            ),
            array(
                $data,
                "name='item_definer'"
            ),
            array(
                $data,
                "<select name='item_securitytype'"
            ),
            array(
                $data,
                "<select name='item_sqldataaccess'"
            ),
            array(
                $data,
                "name='item_comment'"
            ),
            array(
                $data,
                "name='editor_process_edit'"
            )
        );
    }

    /**
     * Test for PMA_RTN_getEditorForm
     *
     * @param array $data    Data for routine
     * @param array $matcher Matcher
     *
     * @return void
     *
     * @depends testgetParameterRow_ajax
     * @dataProvider provider_editor_3
     */
    public function testgetEditorForm_3($data, $matcher)
    {
        $GLOBALS['is_ajax_request'] = true;
        PMA_RTN_setGlobals();
        $this->assertContains(
            $matcher,
            PMA_RTN_getEditorForm('edit', 'remove', $data)
        );
    }

    /**
     * Data provider for testgetEditorForm_3
     *
     * @return array
     */
    public function provider_editor_3()
    {
        $data = array(
            'item_name'                 => 'foo',
            'item_original_name'        => 'bar',
            'item_returnlength'         => '',
            'item_returnopts_num'       => 'UNSIGNED',
            'item_returnopts_text'      => '',
            'item_definition'           => 'SELECT 1',
            'item_comment'              => '',
            'item_definer'              => '',
            'item_type'                 => 'FUNCTION',
            'item_type_toggle'          => 'PROCEDURE',
            'item_original_type'        => 'FUNCTION',
            'item_num_params'           => 1,
            'item_param_dir'            => array(0 => ''),
            'item_param_name'           => array(0 => 'baz'),
            'item_param_type'           => array(0 => 'INT'),
            'item_param_length'         => array(0 => '20'),
            'item_param_opts_num'       => array(0 => 'UNSIGNED'),
            'item_param_opts_text'      => array(0 => ''),
            'item_returntype'           => 'INT',
            'item_isdeterministic'      => '',
            'item_securitytype_definer' => '',
            'item_securitytype_invoker' => '',
            'item_sqldataaccess'        => 'NO SQL'
        );

        return array(
            array(
                $data,
                "name='edit_item'"
            ),
            array(
                $data,
                "name='item_name'"
            ),
            array(
                $data,
                "<select name='item_type'"
            ),
            array(
                $data,
                "name='routine_addparameter'"
            ),
            array(
                $data,
                "name='routine_removeparameter'"
            ),
            array(
                $data,
                "<select name='item_returntype'"
            ),
            array(
                $data,
                "name='item_returnlength'"
            ),
            array(
                $data,
                "<select name='item_returnopts_num'"
            ),
            array(
                $data,
                "<textarea name='item_definition'"
            ),
            array(
                $data,
                "name='item_isdeterministic'"
            ),
            array(
                $data,
                "name='item_definer'"
            ),
            array(
                $data,
                "<select name='item_securitytype'"
            ),
            array(
                $data,
                "<select name='item_sqldataaccess'"
            ),
            array(
                $data,
                "name='item_comment'"
            ),
            array(
                $data,
                "name='ajax_request'"
            ),
            array(
                $data,
                "name='editor_process_edit'"
            ),
        );
    }

    /**
     * Test for PMA_RTN_getEditorForm
     *
     * @param array $data    Data for routine
     * @param array $matcher Matcher
     *
     * @return void
     *
     * @depends testgetParameterRow_ajax
     * @dataProvider provider_editor_4
     */
    public function testgetEditorForm_4($data, $matcher)
    {
        $GLOBALS['is_ajax_request'] = false;
        PMA_RTN_setGlobals();
        $this->assertContains(
            $matcher,
            PMA_RTN_getEditorForm('edit', 'change', $data)
        );
    }

    /**
     * Data provider for testgetEditorForm_4
     *
     * @return array
     */
    public function provider_editor_4()
    {
        $data = array(
            'item_name'                 => 'foo',
            'item_original_name'        => 'bar',
            'item_returnlength'         => '',
            'item_returnopts_num'       => '',
            'item_returnopts_text'      => '',
            'item_definition'           => 'SELECT 1',
            'item_comment'              => '',
            'item_definer'              => '',
            'item_type'                 => 'FUNCTION',
            'item_type_toggle'          => 'PROCEDURE',
            'item_original_type'        => 'PROCEDURE',
            'item_num_params'           => 1,
            'item_param_dir'            => array(0 => 'IN'),
            'item_param_name'           => array(0 => 'baz'),
            'item_param_type'           => array(0 => 'INT'),
            'item_param_length'         => array(0 => '20'),
            'item_param_opts_num'       => array(0 => 'UNSIGNED'),
            'item_param_opts_text'      => array(0 => ''),
            'item_returntype'           => '',
            'item_isdeterministic'      => '',
            'item_securitytype_definer' => '',
            'item_securitytype_invoker' => '',
            'item_sqldataaccess'        => 'NO SQL'
        );

        return array(
            array(
                $data,
                "<input name='item_type' type='hidden' value='PROCEDURE'"
            ),
        );
    }
}
?>
