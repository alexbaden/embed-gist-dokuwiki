<?php
/**
 * DokuWiki Plugin gist (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Alex Baden <alex.baden@jhu.edu>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_gist_embedgist extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    //public function getPType() {
    //    return 'normal';
    //}
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 60;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        //$this->Lexer->addSpecialPattern('\[gist\]', $mode, 'plugin_gist_embedgist');
	$this->Lexer->addSpecialPattern('\[gist\s[^\]]+\]', $mode, 'plugin_gist_embedgist');
        //$this->Lexer->addSpecialPattern('\[gist\s\w*\/\w*\]', $mode, 'plugin_gist_embedgist');
    }

    /**
     * Handle matches of the gist syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler &$handler){
        list($gistuser, $gistid) = preg_split("/\//u", substr($match, 6, -1), 2);
	return array($gistuser, $gistid);
	//return array();    
	}

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer &$renderer, $data) {
        if($mode != 'xhtml') { return false; }
	list($gistuser, $gistid) = $data;
	$gistuser = htmlentities(htmlspecialchars($gistuser));
	$gistid = htmlentities(htmlspecialchars($gistid));
	$renderer->doc .= "<script src='https://gist.github.com/" . $gistuser . "/" . $gistid . ".js'></script>";
	//$renderer->doc .= "yo";
        return true;
    }
}

// vim:ts=4:sw=4:et:
