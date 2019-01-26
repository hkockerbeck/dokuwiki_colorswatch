<?php
/**
 * DokuWiki Plugin colorswatch (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Henning Kockerbeck <henning.kockerbeck@isatis-online.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) {
    die();
}

class syntax_plugin_colorswatch_colorswatch extends DokuWiki_Syntax_Plugin
{
    /**
     * @return string Syntax mode type
     */
    public function getType()
    {
        return 'substition';
    }

    /**
     * @return string Paragraph type
     */
    public function getPType()
    {
        return 'normal';
    }

    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort()
    {
    	// we don't really use this
	// just use constant from code plugin
        return 195;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode)
    {
    	# color codes #rrggbb
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{6}>', $mode, 'plugin_colorswatch_colorswatch');
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{6}:[\p{Xwd}_ -]+>', $mode, 'plugin_colorswatch_colorswatch');
	
    	# color codes #rrggbbaa
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{8}>', $mode, 'plugin_colorswatch_colorswatch');
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{8}:[\p{Xwd}_ -]+>', $mode, 'plugin_colorswatch_colorswatch');
	
    	# color codes #rgb
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{3}>', $mode, 'plugin_colorswatch_colorswatch');
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{3}:[\p{Xwd}_ -]+>', $mode, 'plugin_colorswatch_colorswatch');
	
    	# color codes #rgba
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{4}>', $mode, 'plugin_colorswatch_colorswatch');
        $this->Lexer->addSpecialPattern('<colorswatch #[0-9a-fA-F]{4}:[\p{Xwd}_ -]+>', $mode, 'plugin_colorswatch_colorswatch');
    }

    /**
     * Handle matches of the colorswatch syntax
     *
     * @param string       $match   The match of the syntax
     * @param int          $state   The state of the handler
     * @param int          $pos     The position in the document
     * @param Doku_Handler $handler The handler
     *
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        $data = array();

	if ($state == DOKU_LEXER_SPECIAL)
	{
		preg_match('/<colorswatch (#[0-9a-fA-F]{3,8})(:([\p{Xwd}_ -]+))?>/', $match, $match_data);
		$data['code'] = $match_data[1];
		$data['name'] = $match_data[3];
	}

        return $data;
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string        $mode     Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer $renderer The renderer
     * @param array         $data     The data from the handler() function
     *
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer $renderer, $data)
    {
        if ($mode !== 'xhtml') {
            return false;
        }

	$code = $data['code'];

	if ($data['name'] != '') 
	{
	    $name = $data['name'] . '<br>(' . $code . ')';
	}
	else
	{
	    $name = $code . '<br>&nbsp;';
	}


	$renderer->doc .= <<<EOT
<div class="colorswatch"><div class="colorswatch_swatch" style="background-color: $code;">&nbsp;</div><div class="colorswatch_info">$name</div></div>
EOT;

        return true;
    }
}

