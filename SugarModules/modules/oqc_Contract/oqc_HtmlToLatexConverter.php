<?php

/************************************************************
HtmlToLatexConverter Version 0.1
This class is for converting of html code produced by on-demand html editors (TinyMCE etc.) to Latex code using DOMDocument parser. Not all of html tags are currently supported, please see $html_elements array for supported tags.

Inspired by html2text (http://www.howtocreate.co.uk/php/html2texthowto.html) and html2latex (http://html2latex.sourceforge.net/)

$html_elemets parameters:
[renderNode, renderChildNodes, renderAsText, renderType, command]

renderNode
    Boolean: says if the element should be rendered. If True, element is rendered
renderChildNodes
	 Boolean: says if the children nodes of the element should be rendered.
renderAsText
	 Boolean: says if the element should be checked if it is Text node and then rendered.
renderType
	 String: specifies the handler that should be used for node rendering.
command
	 String: specifies the latex command that should be used by the handler specified with renderType
	 
Input and output should be UTF-8 strings

****************************************************************/ 


class oqc_HtmlToLatexConverter {

 var $search_characters = array();
 
 var $replace_characters = array();
 
 var $html_actions = array();
 
 var $class_name = 'oqc_HtmlToLatexConverter';


public function __construct() {
		
 $text_latex = array(
		array('\$'    ,  '\\\\$'           ), 
	   array('\\\\(?!\$)', "\$\\backslash\$"), 
		array('<'     , '$<$'           ),
 		array('>'     , '$>$'           ),
		array('&'     , '\\&'            ),
		array('%'     , '\\%'            ),
		array('#'     , '\\#'            ),
		array('{'     , '\\{'            ),
		array('}'     , '\\}'            ),
		array('_'     , '\\_'            ),
		array('\^'    , '\\^{}'          ),
		array('~'    , '\\~{}'          ),
		array ('(&nbsp;|\xA0)' , '~'		), 
		array(chr(161), '!`'            ), 
		array(chr(163), '{\\pounds}'    ), 
	       #array(chr(164), ''              ), #¤*
 		array(chr(165), '{Y\hspace*{-1.4ex}--}'), 
		array(chr(166), '$|$'           ), 
 		array(chr(167), '{\\S}'         ), 
		array(chr(168), '\\"{}'         ), 
		array(chr(169), '{\\copyright}' ), 
		array(chr(170), '$^{\underline{a}}$'), 
		array(chr(171), '<<'            ), 
		array(chr(172), '$\\neg$'       ), 
		array(chr(173), '$-$'           ), 
		array(chr(175), '$^-$'          ), 
		array(chr(176), '$^{\\circ}$'   ), 
		array(chr(177), '$\\pm$'        ), 
	   array(chr(178), '$^2$'          ), 
		array(chr(179), '$^3$'          ), 
		array(chr(180), '$^\\prime$'    ), 
		array(chr(181), '$\\mu$'        ), 
		array(chr(182), '{\P}'          ), 
		array(chr(183), '$\cdot$'       ), 
		array(chr(184), ','             ), 
      array(chr(185), '$^1$'          ), 
      array(chr(186), '$^{\\underline{\\circ}}$'),	
      array(chr(187), '>>'            ), 
      array(chr(188), '$\frac{1}{4}$' ), 
		array(chr(189), '$\frac{1}{2}$' ), 
		array(chr(190), '$\frac{3}{4}$' ), 
		array(chr(191), '?`'            ), 
		array(chr(192), '\\`A'          ), 
		array(chr(193), '\\\'A'         ), 
		array(chr(194), '\\^A'          ), 
		array(chr(195), '\\~A'          ), 
		array(chr(196), '\\"A'          ), 
		array(chr(197), '{\\AA}'        ), 
		array(chr(198), '{\\AE}'        ), 
		array(chr(199), '\\c{C}'        ), 
		array(chr(200), '\\`E'          ), 
		array(chr(201), '\\\'E'         ), 
		array(chr(202), '\\^E'          ), 
		array(chr(203), '\\"E'          ), 
		array(chr(204), '\\`I'          ), 
		array(chr(205), '\\\'I'         ), 
		array(chr(206), '\\^I'          ), 
		array(chr(207), '\\"I'          ), 
		array(chr(208), '{D\\hspace*{-1.7ex}-\\hspace{.9ex}}'), 
		array(chr(209), '\\~N'          ), 
		array(chr(210), '\\`O'          ), 
		array(chr(211), '\\\'O'         ), 
		array(chr(212), '\\^O'          ), 
		array(chr(213), '\\~O'          ), 
		array(chr(214), '\\"O'          ), 
		array(chr(215), '$\chi$'        ), 
		array(chr(216), '{\\O}'         ), 
		array(chr(217), '\\`U'          ), 
		array(chr(218), '\\\'U'         ), 
		array(chr(219), '\\^U'          ), 
		array(chr(220), '\\"U'          ), 
		array(chr(221), '\\\'Y'         ), 
		array(chr(222), 'P'             ), 
		array(chr(223), '"s'            ), 
		array(chr(224), '\\`a'          ), 
		array(chr(225), '\\\'a'         ), 
		array(chr(226), '\\^a'          ), 
		array(chr(227), '\\~a'          ), 
		array(chr(228), '\\"a'          ), 
		array(chr(229), '\\r{a}'        ), 
		array(chr(230), '{\ae}'         ), 
		array(chr(231), '\\c{c}'        ), 
		array(chr(232), '\\`e'          ), 
		array(chr(233), '\\\'e'         ), 
		array(chr(234), '\\^e'          ), 
		array(chr(235), '\\"e'          ), 
		array(chr(236), '\\`{\i}'       ), 
		array(chr(237), '\\\'{\\i}'     ), 
		array(chr(238), '\\^{\\i}'      ), 
		array(chr(239), '\\"{\\i}'      ), 
		array(chr(240), '\\v{o}'        ), 
		array(chr(241), '\\~n'          ), 
		array(chr(242), '\\`o'          ), 
		array(chr(243), '\\\'o'         ), 
		array(chr(244), '\\^o'          ), 
		array(chr(245), '\\~o'          ), 
		array(chr(246), '\\"o'          ), 
		array(chr(247), '$\\div$'       ), 
		array(chr(248), '{\\o}'         ), 
		array(chr(249), '\\`u'          ), 
		array(chr(250), '\\\'u'         ), 
		array(chr(251), '\\^u'          ), 
		array(chr(252), '\\"u'          ), 
		array(chr(253), '\\\'y'         ), #y with acute
		array(chr(254), 'p'             ), #small leter thorn
		array(chr(255), '\\"y'          ),
		array('\x{20AC}', '\\euro{}'		  ), //Euro 
		// LTU letters translation to latex codes
		array('\x{017E}', '\\v{z}'			  ), //ž lithuanian
		array('\x{017D}', '\\v{Z}'			  ), //Ž lithuanian 
		array('\x{012f}', '\\k{i}'			  ), // į lithuanian 
		array('\x{012e}', '\\k{I}'			  ), // Į lithuanian 
		array('\x{0104}', '\\k{A}'			  ), // Ą lithuanian 
		array('\x{0105}', '\\k{a}'			  ), // ą lithuanian
		array('\x{016A}', '\\={U}'			), // Ū long lithuanian
		array('\x{016B}', '\\={u}'			), // ū long lithuanian
		array('\x{0172}', '\\k{U}'			), // Ų lithuanian
		array('\x{0173}', '\\k{u}'			), // U lithuanian
		array('\x{016A}', '\\k{a}'			), // U lithuanian
		array('\x{0116}', '\\.{E}'			), // Ė  lithuanian
		array('\x{0117}', '\\.{e}'			), // ė  lithuanian  
 );
	       
 foreach ($text_latex as $pair) {
 	$this->search_characters[]= "/". utf8_encode($pair[0]) ."/u" ;
 	$this->replace_characters[] = $pair[1] ;
 }

$html_elements['unknown element'] = array(false,true,false); //used for all unknown or default elements
$html_elements['html'] = array(false,true,false);
$html_elements['title'] = array(true,true,true,'command_handler','title');
$html_elements['script'] = array(false,true,false);
$html_elements['style'] =
$html_elements['datalist'] = 
$html_elements['h1'] = array(true,true,true,'command_handler', 'section*');
$html_elements['h2'] = array(true,true,true,'command_handler', 'subsection*');
$html_elements['h3'] = array(true,true,true,'command_handler', 'subsubsection*');
$html_elements['h4'] = array(true,true,true,'command_handler', 'textbf');
$html_elements['h5'] = array(true,true,true,'command_handler', 'textbf');
$html_elements['h6'] = array(true,true,true,'command_handler', 'textbf');
$html_elements['p'] = array(true,true,true,'single_handler', "\n");
$html_elements['ul'] = array(true,true,true,'environment_handler', 'itemize');
$html_elements['dl'] =
$html_elements['table'] =
$html_elements['blockquote'] =
$html_elements['legend'] =
$html_elements['dir'] =
$html_elements['menu'] =
$html_elements['article'] =
$html_elements['aside'] =
$html_elements['datagrid'] =
$html_elements['details'] =
$html_elements['dialog'] =
$html_elements['figure'] =
$html_elements['footer'] =
$html_elements['nav'] =
$html_elements['section'] = 
$html_elements['blockquote'] = 
$html_elements['form'] = 
$html_elements['pre'] = array(true,true,true,'environment_handler', 'verbatim');
$html_elements['listing'] =
$html_elements['plaintext'] =
$html_elements['xmp'] = array(true,true,true,'environment_handler', 'verbatim');
$html_elements['head'] = array(false,true,false);// can be used for custom latex code insertion, I think
$html_elements['meta'] = array(false,true,false);
$html_elements['body'] = array(false,true,true,'environment_handler', 'document');
$html_elements['noframes'] =
$html_elements['div'] =
$html_elements['fieldset'] =
$html_elements['dt'] =
$html_elements['caption'] =
$html_elements['thead'] =
$html_elements['tfoot'] =
$html_elements['tr'] =
$html_elements['address'] =
$html_elements['center'] =
$html_elements['marquee'] =
$html_elements['header'] = array(false,false,false);
$html_elements['dt'] = 
$html_elements['th'] =
$html_elements['td'] = 
$html_elements['dd'] = 
$html_elements['ol'] = array(true,true,true,'environment_handler', 'enumerate');
$html_elements['li'] = array(true,true,true,'single_handler', '\\item');
$html_elements['br'] = array(false,false,false,'single_handler', '\\\\'); //do not process linebreaks
$html_elements['hr'] = array(true,true,true,'single_handler', '\\hline');
$html_elements['sup'] = array(true,true,true,'command_handler', 'textsuperscript');
$html_elements['sub'] = array(true,true,true,'command_handler', 'textsubscript');
$html_elements['s'] = array(true,true,true,'command_handler', 'sout');
$html_elements['strike'] = array(true,true,true,'command_handler', 'sout');
$html_elements['del'] = array(true,true,true,'command_handler', 'sout');
$html_elements['ins'] = array(true,true,true,'command_handler', 'uline');
$html_elements['strong'] = array(true,true,true,'command_handler', 'textbf');
$html_elements['b'] = array(true,true,true,'command_handler', 'textbf');
$html_elements['mark'] = 
$html_elements['em'] = array(true,true,true,'command_handler', 'emph');
$html_elements['i'] = array(true,true,true,'command_handler', 'textit');
$html_elements['u'] = array(true,true,true,'command_handler', 'uline');
$html_elements['q'] = array(true,true,true,'environment_handler', 'quote');
$html_elements['blockquote'] = array(true,true,true,'environment_handler', 'quote');
$html_elements['center'] = array(true,true,true,'environment_handler', 'center');
$html_elements['a'] = 
$html_elements['area'] = 
$html_elements['base'] = 
$html_elements['input'] = 
$html_elements['bb'] = 
$html_elements['isindex'] = 
$html_elements['textarea'] = array(true,true,true,'environment_handler', 'verbatim');
$html_elements['button'] =
$html_elements['select'] = 
$html_elements['img'] = 

$this->html_actions = $html_elements;

}

//Handlers

# HTML input form: <FOO> Bar </FOO> this is for command functions
# Latex output form: \tex{Bar}

function command_handler($element,$command) {
    return "\n"."\\$command{" . $this->html2latex_render_childnodes($element) . "}";
}

# HTML input form: <FOO> Bar </FOO> this is for custom functions
# Latex output form: tex1 bar tex2

function other_handler($element,$tex) {
    return $tex[0] . $this->html2latex_render_childnodes($element) . $tex[1];
}

# HTML input form: <FOO> Bar </FOO>
# Latex output form: \begin{tex} Bar \end{tex}

function environment_handler($element,$environment) {
    return "\n".'\begin{' . $environment . '}' . "\n" . 
	$this->html2latex_render_childnodes($element) .
	'\end{' .  $environment . '}';
}

# HTML input form: <FOO> Bar (implicit end)
# Latex output form: \tex Bar

function single_handler($element,$single) {
    return $single . " " . $this->html2latex_render_childnodes($element);
}

function html2latex_formattext($node_value) {
	//return $node_value; //for testing
	//$GLOBALS['log']->error('OQC html2latex: Formating node value '.$node_value);
	$output = '';
	$output = preg_replace($this->search_characters,$this->replace_characters,$node_value);
	return $output;
}

function html2latex_render_childnodes($element) {
	$content = '';
	$num_child = $element->childNodes->length;
	for( $i = 0;  $i < $num_child; $i++ ) {
		$node = $element->childNodes->item($i);
		if( $node->nodeType == XML_TEXT_NODE || $node->nodeType == XML_CDATA_SECTION_NODE ) {
				//$GLOBALS['log']->error('OQC html2latex: Rendering child node '.$node->nodeName);
				$content .= $this->html2latex_formattext($node->nodeValue);
					
				}
		 elseif ( $node->nodeType == XML_ELEMENT_NODE ) {
			
		 $content .= $this->html2latex_render($node);
		}
	}
	return $content;
	}
	
	

 
function html2latex_render($element) {
	
	$tag_name = strtolower($element->tagName);
	$elem_det = $this->html_actions[$tag_name];
	if( !$elem_det ) { $elem_det = $this->html_actions['unknown element']; }
	//$GLOBALS['log']->error('OQC html2latex: Rendering node '.$tag_name);
	$latex_output = '';

	
	//if renderNode is false, then skip this step
	
	if( $elem_det[0] ) {
				
		if( ($element->nodeType == XML_ELEMENT_NODE) && $elem_det[3]) {
		$call_handler = array($this->class_name, $elem_det[3]);	
		$latex_output .= call_user_func($call_handler,$element,$elem_det[4]);
	}
	else if (!$elem_det[3] && $element->nodeType == XML_ELEMENT_NODE) {
		$latex_output .= $this->html2latex_render_childnodes($element);
		}
	}

	//go to child nodes if flag is set to true
	
	elseif( !$elem_det[0] && $elem_det[1]) {
	$num_child = $element->childNodes->length;
	for( $i = 0; $i < $num_child; $i++ ) {
		$node = $element->childNodes->item($i);
		if( $node->nodeType == XML_TEXT_NODE || $node->nodeType == XML_CDATA_SECTION_NODE ) {
			
				$latex_output .= $this->html2latex_formattext($node->nodeValue);
				
				
				}
		 elseif ( $node->nodeType == XML_ELEMENT_NODE ) {
				
		 $latex_output .= $this->html2latex_render($node);
		}
	}
	}
	//check if it is not text node
	
	if( !$elem_det[0] && !$elem_det[1] && $elem_det[2] ) {
		if( $element->nodeType == XML_TEXT_NODE || $element->nodeType == XML_CDATA_SECTION_NODE ) {
			$latex_output .= $this->html2latex_formattext($element->nodeValue);

		}
	}
	
	
	return $latex_output;
}


function correct_encoding($content,$encod='') {
		mb_detect_order("UTF-8,ASCII,ISO-8859-1,windows-1252,iso-8859-15");
            if (!empty($content)) {
                if (empty($encod))
                        $encod  = mb_detect_encoding($content);
                $headpos        = mb_strpos($content,'<head>');
                if (FALSE=== $headpos)
                        $headpos= mb_strpos($content,'<HEAD>');
                if (FALSE!== $headpos) {
                        $headpos+=6;
                        $content = mb_substr($content,0,$headpos) . '<meta http-equiv="Content-Type" content="text/html; charset='.$encod.'">' .mb_substr($content,$headpos);
                } else {
                	return false;
                	}
                //$GLOBALS['log']->error('OQC html2latex:  detected encoding is '.$encod);	
                $content = mb_convert_encoding($content, 'HTML-ENTITIES', $encod);
                // we have to replace \< \> symbols with html entities for DOMDocument to work correctly 
                $content = str_replace( '\\<', '&lt;', $content );
                $content = str_replace( '\\>', '&gt;', $content );
                //$GLOBALS['log']->error('textBlocksToLatex: correcting <>: '. var_export($content,true));
                 return $content ;
        }
        return null;
          
}

// We always inport html as a string, but maybe someday...
// we need handle everything as UTF-8 since editors output uft-8 strings
function html2latex( $sourceStr, $isfile = false ) {
	
	if( is_object($sourceStr) ) {
		$DOM = $sourceStr;
	} else {
		$DOM = new DOMDocument();
			if( $isfile ) {
			$content = file_get_contents($sourceStr);
			$content = $this->correct_encoding($content);
			if ($content) {
			$DOM->loadHTML($content);
			} else { $GLOBALS['log']->error('OQC html2latex:  no <head> tag in the file!');
						$DOM->loadHTMLFile($sourceStr);	} //if file format is not good load original file anyway
		} else {
			//remove any PHP (and XML prologs) if it exists
			$strippedStr = $this->correct_encoding(preg_replace( "/<\?[\w\W]*\?>/u", '', $sourceStr )); 
			if( $strippedStr === null ) {
				//ouch - encoding problem detected
				trigger_error('String passed to html2text has encoding issues (contains characters not permitted in the encoding PHP is using) - attempting recovery by not stripping PHP from the source string',E_USER_WARNING);
				$DOM->loadHTML( $sourceStr );
			} else { 
				//$GLOBALS['log']->error('textBlocksToLatex: loading to DOMDocument: '. var_export($strippedStr,true));
				$DOM->loadHTML( $strippedStr );
				//$GLOBALS['log']->error('textBlocksToLatex: saving from DOMDocument: '. $DOM->saveHTML());
			}
			unset($strippedStr);
		}
	}
	//$GLOBALS['log']->error('OQC html2latex: DOM encoding is:'. $DOM->encoding);
	unset($sourceStr); //free up memory before layout happens
		if( $DOM->documentElement ) {
			
		//$GLOBALS['log']->error('OQC html2latex: Starting conversion of ');	
		$sourceStr = $this->html2latex_render($DOM->documentElement);
		
		return $sourceStr;
	} else {
		return '';
	}
}
}
?>