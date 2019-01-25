<?php
/**
 * General tests for the colorswatch plugin
 *
 * @group plugin_colorswatch
 * @group plugins
 */
class general_plugin_colorswatch_test extends DokuWikiTest
{

    protected $pluginsEnabled = array('colorswatch');

    /**
     * Simple test to make sure the plugin.info.txt is in correct format
     */
    public function test_plugininfo()
    {
        $file = __DIR__ . '/../plugin.info.txt';
        $this->assertFileExists($file);

        $info = confToHash($file);

        $this->assertArrayHasKey('base', $info);
        $this->assertArrayHasKey('author', $info);
        $this->assertArrayHasKey('email', $info);
        $this->assertArrayHasKey('date', $info);
        $this->assertArrayHasKey('name', $info);
        $this->assertArrayHasKey('desc', $info);
        $this->assertArrayHasKey('url', $info);

        $this->assertEquals('colorswatch', $info['base']);
        $this->assertRegExp('/^https?:\/\//', $info['url']);
        $this->assertTrue(mail_isvalid($info['email']));
        $this->assertRegExp('/^\d\d\d\d-\d\d-\d\d$/', $info['date']);
        $this->assertTrue(false !== strtotime($info['date']));
    } // end of test_plugininfo()

    /**
     * Test to ensure that every conf['...'] entry in conf/default.php has a corresponding meta['...'] entry in
     * conf/metadata.php.
     */
    public function test_plugin_conf()
    {
        $conf_file = __DIR__ . '/../conf/default.php';
        if (file_exists($conf_file)) {
            include($conf_file);
        }
        $meta_file = __DIR__ . '/../conf/metadata.php';
        if (file_exists($meta_file)) {
            include($meta_file);
        }

        $this->assertEquals(
            gettype($conf),
            gettype($meta),
            'Both ' . DOKU_PLUGIN . 'colorswatch/conf/default.php and ' . DOKU_PLUGIN . 'colorswatch/conf/metadata.php have to exist and contain the same keys.'
        );

        if (gettype($conf) != 'NULL' && gettype($meta) != 'NULL') {
            foreach ($conf as $key => $value) {
                $this->assertArrayHasKey(
                    $key,
                    $meta,
                    'Key $meta[\'' . $key . '\'] missing in ' . DOKU_PLUGIN . 'colorswatch/conf/metadata.php'
                );
            }

            foreach ($meta as $key => $value) {
                $this->assertArrayHasKey(
                    $key,
                    $conf,
                    'Key $conf[\'' . $key . '\'] missing in ' . DOKU_PLUGIN . 'colorswatch/conf/default.php'
                );
            }
        }

    } // end of test_plugin_conf()

    /**
     * Test that the <colorswatch> tag gets properly substituted
     * if no color name is provided
     */
    public function test_substitution_without_a_name()
    {
    	$info = array();

	$code = '#FF00FF';


	$expected = <<<EOT

<p>
<div class="colorswatch"><div class="colorswatch_swatch" style="background-color: $code;">&nbsp;</div><div class="colorswatch_info">$code<br>&nbsp;</div></div>
</p>

EOT;

	$instructions = p_get_instructions('<colorswatch ' . $code . '>');
	$xhtml = p_render('xhtml', $instructions, $info);

	$this->assertEquals($expected, $xhtml, 'A <colorswatch> tag without a color name gets rendered properly');
    }

    /**
     * Test that the <colorswatch> tag gets properly substituted
     * if a color name is provided
     */
    public function test_substitution_with_a_name()
    {
    	$info = array();

	$code = '#FF00FF';
	$name = 'a name';


	$expected = <<<EOT

<p>
<div class="colorswatch"><div class="colorswatch_swatch" style="background-color: $code;">&nbsp;</div><div class="colorswatch_info">$name<br>($code)</div></div>
</p>

EOT;

	$instructions = p_get_instructions('<colorswatch ' . $code . ':' . $name . '>');
	$xhtml = p_render('xhtml', $instructions, $info);

	$this->assertEquals($expected, $xhtml, 'A <colorswatch> tag with a color name gets rendered properly');
    }

    /**
     * Test that the <colorswatch> tag gets properly substituted
     * if a color name with a non-ascii word letter is provided
     */
    public function test_substitution_with_a_non_ascii_name()
    {
    	$info = array();

	$code = '#00FF00';
	$name = 'grün';


	$expected = <<<EOT

<p>
<div class="colorswatch"><div class="colorswatch_swatch" style="background-color: $code;">&nbsp;</div><div class="colorswatch_info">$name<br>($code)</div></div>
</p>

EOT;

	$instructions = p_get_instructions('<colorswatch ' . $code . ':' . $name . '>');
	$xhtml = p_render('xhtml', $instructions, $info);

	$this->assertEquals($expected, $xhtml, 'A <colorswatch> tag with a non-ascii color name gets rendered properly');
    }
} // end of class
