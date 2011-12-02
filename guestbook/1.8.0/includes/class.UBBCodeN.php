<?php
////////////////////////////////////////////////////////////////
/*
Replaces the UBB tags listed below with HTML tags, and vice versa.
Also keeps the line feeds in the text and removes all HTML tags.

    UBB Tags:
    		[b]...[/b]			bold
    		[i]...[/i]			italic
    		[code]...[/code]		source code
    		[img], [/img]			images
    		[quote]...[/quote]		blockquote
    		[url]http//www.link[/url]	links
    		[url=http//www.link]name[/url]	links
    		[email]me@home.de[/email]	email link
    		[email=me@home.de]name[/email]	email link

    Additional Tags:
    		[u]...[/u]			underline
    		[center]..[/center]		center
    		[color=name]...[/color]		colors

    For a description of ubbcodes see: http://community.infopop.net/infopop/ubbcode.html

FUNCTIONS:
    function encode($text)
    function decode($text)
    function evaluate($text)
    function listCodes()

////////////////////////////////////////////////////////////////

    This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Lesser General Public
    License as published by the Free Software Foundation; either
    version 2.1 of the License, or (at your option) any later version.

    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this library; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
////////////////////////////////////////////////////////////////
/**
* Replaces the ubb tags with HTML tags, and vice versa.
* Also keeps the line feeds in the text and removes slashes (good for sql queries).
*
* @author	    Dhaval Shah <dhaval1947@gmail.com>
* @version 	    2 - 05/03/2009
*
* @access   public
*/
class UBBCodeN
{   
	//////////////////////////////////////////////////////////
	/**
	* Maps the values in the ubb_tab array
	* It is called from the encode and decode function.
	*
	* @access   public
	* @param    String      $text
	* @return   String
	*/
	function evaluate($text , $arg1 = '' , $arg2 = '' , $arg3 = '' , $arg4 = '')
	{
		$ubb_conversion=array(	"code"  	=>	"pre",
                                "u"  	   	=>	"u",
                                "b"     	=>	"b",
                                "center"	=>	"span",
                                "url"   	=>	"a href='",
                                "email"   	=>	"a href='",
                                "img"       =>	"img src=",
                                "color"     =>	"span class=",
                                "/color"    =>	"/span",
                                "i"     	=>	"i",
                                "["     	=>	"<",
                                "[/"    	=>	"</",
                                "]"     	=>	">",
                                "[/url"    	=>	"</a",
                                "[/email"       =>	"</a",
                                "quote"    	=>	"<blockquote>Quote:<hr/>",
                                "/quote"   	=>	"<hr/></blockquote>" ,
                                "<" 		=>	"[",
                                "</"		=>	"[/",
                                ">" 		=>	"]",
                                "pre"		=>	"code",
                                "span"          =>	"color",
                                "a href"	=>	"url=",
                                "</a" 		=>	"[/url",
                                "a email" 	=>	"email",
                                "</a email"	=>	"[/email",
                                "blockquote"=>	"quote"
                            );

		if(strtolower($text)=='color')
        {
		  return $ubb_conversion[strtolower($text)]."'".$arg1."'";
		}
		else if(strtolower($text)=='url')
        {
		   if($arg1!='')
            {
                if($arg2!='')
                {
				  return $ubb_conversion[strtolower($text)].$arg1."' target='_blank'";
				}
				else
                {
					  $arg1="http://".$arg1;
					  return $ubb_conversion[strtolower($text)].$arg1."' target='_blank'";
                }
            }
			else
            {
                if($arg3!='')
                {
				  return $ubb_conversion[strtolower($text)].$arg3.$arg4."' target='_blank'";
                }
				else
                {
					  $arg4="http://".$arg4;
					  return $ubb_conversion[strtolower($text)].$arg4."' target='_blank'";
				}
			}
		}
		else if(strtolower($text)=='email')
        {            
                   if($arg1!='')
                   {
		     		return $ubb_conversion[strtolower($text)]."mailto:".$arg1."'";
                   }
                   else
                   {
		     		return $ubb_conversion[strtolower($text)]."mailto:".$arg2."'";
                   }
		}
		else if(strtolower($text)=='img')
        {
		  return $ubb_conversion[strtolower($text)]."'".$arg1."' border='0'";
		}
		else if(strtolower($text)=='a href')
        {
		  return $ubb_conversion[strtolower($text)].$arg1;
		}
		else if(strtolower($text)=='a email')
        {
		  return $ubb_conversion[strtolower($text)]."=".$arg1;
		}
		else if(strtolower($text)=='blockquote')
        {
			if($arg1!='' && $arg2 !='')
            {
			   return '/'.$ubb_conversion[strtolower($text)];
			}
			else if($arg3 != '')
            {
			  return $ubb_conversion[strtolower($text)];
			}
		}
		else if(strtolower($text) == 'center' && $arg1 == '')
         {     
		 return $ubb_conversion[strtolower($text)]." class='center'";
                  
               }
		else if(strtolower($text) == 'center' && $arg1 == 'center')
         {     
		 return "span";
               }
		else if(strtolower($text) == 'span' && $arg1 == 'center')
         {
		 return "center";
               }
		else
        {
		  return $ubb_conversion[strtolower($text)];
		}
	}

	//////////////////////////////////////////////////////////
	/**
	* Encodes the string
	* Removes all html tags and exchanges only the ubb tags and with html tags.
	*
	*
	* @access   public
	* @param    String      $text
	* @return   String
	*/
	function encode($text)
	{ $text=preg_replace('/ALT="(.*?)"/i','ALT=\'\\1\'',$text);

		while(1){
			if(preg_match('/\[(u|b|i|center|code)\]([^\[]*)\[\/\1\]/i',$text))
            {
				 $text=preg_replace('/\[(u|b|i|center|code)\]([^\[]*)\[\/\1\]/ime',"\$this->evaluate('[').\$this->evaluate('\\1').\$this->evaluate(']').'\\2'.\$this->evaluate('[/').\$this->evaluate('\\1','\\1').\$this->evaluate(']')",$text);
		//		 $text=preg_replace('/\[(u|b|i|center|code)\]([^\[]*)\[\/\1\]/ie',"\$this->evaluate('[').\$this->evaluate('\\1').\$this->evaluate(']').'\\2'.\$this->evaluate('[/').\$this->evaluate('\\1').\$this->evaluate(']')",$text);
			}
			else if(preg_match('/\[img( .*?)?\]([^\[]*)\[\/img\]/ie',$text))
            {
				 $text=preg_replace('/\[img( .*?)?\]([^\[]*)\[\/img\]/ime',"\$this->evaluate('[').\$this->evaluate('img','\\2').'\\1'.'/'.\$this->evaluate(']')",$text);
			}
			else if( preg_match('/\[(color)=([^\[]*)\]([^\[]*)\[\/\1\]/i',$text))
            {
				 $text=preg_replace('/\[(color)=([^\[]*)\]([^\[]*)\[\/\1\]/ime',"\$this->evaluate('[').\$this->evaluate('\\1','\\2').\$this->evaluate(']').'\\3'.\$this->evaluate('[').\$this->evaluate('/color').\$this->evaluate(']')",$text);
			}
			 else if( preg_match('/\[url(=((https?:\/\/)?[^\[]*))?\](https?:\/\/)?([^\[]*)\[\/url\]/i',$text))
            {

			   $text=preg_replace('/\[url(=((https?:\/\/)?[^\[]*))?\](https?:\/\/)?([^\[]*)\[\/url\]/ime',"\$this->evaluate('[').\$this->evaluate('url','\\2','\\3','\\4','\\5').\$this->evaluate(']').'\\5'.\$this->evaluate('[/url').\$this->evaluate(']')",$text);
			}
			else if(preg_match('/\[email(=([^\[]*))?\]([^\[]*)\[\/email\]/i',$text))
            {
			   $text=preg_replace('/\[email(=([^\[]*))?\]([^\[]*)\[\/email\]/ime',"\$this->evaluate('[').\$this->evaluate('email','\\2','\\3').\$this->evaluate(']').'\\3'.\$this->evaluate('[/email').\$this->evaluate(']')",$text);
			}
			else if(preg_match('/\[((\/)?quote)\](\r\n)?/i',$text))
            {
                $text=preg_replace('/\[((\/)?quote)\](\r\n)?/ime',"\$this->evaluate('\\1')",$text);
			}
			else if(preg_match('/\n/i',$text))
            {
                $text=preg_replace('/\n/i','<br />',$text);
			}
			else
            {
				break;
			}

			}
		return $text;
	}

	//////////////////////////////////////////////////////////
	/**
	* Strips all UBB tags
	* Removes all ubb tags and leaves only plain text
	*
	*
	* @access   public
	* @param    String      $text
	* @return   String
	*/
	function strip($text)
    {
    	$text=preg_replace('/\[(\/)?(b|u|i|center|code|color(=(\S*?))?|url(=(\S*?))?|email(=(\S*?))?|img|quote)\]/iem','',$text);
    	return $text;
	}
	//////////////////////////////////////////////////////////
	/**
	* Decodes the string
	* Removes the html tags and replaces them with ubb code tags
	*
	* @access   public
	* @param    String      $text
	* @return   String
	*/
	function decode($text)
	{
		$text=preg_replace('/ALT="(.*?)"/i','ALT=\'\\1\'',$text);
		while(1)
		{
			if(preg_match('/<(u|b|i|pre)>([^\<]*)<\/\1>/i',$text))
            {
				 $text=preg_replace('/<(u|b|i|pre)>([^<]*)<\/\1>/ime',"\$this->evaluate('<').\$this->evaluate('\\1').\$this->evaluate('>').'\\2'.\$this->evaluate('</').\$this->evaluate('\\1').\$this->evaluate('>')",$text);
			}
			else if(preg_match('/<img src=("|\')([^<]*?)("|\')( border=("|\')([^<]*?)("|\'))?( .*?)(\/)?>/i',$text))
            {			
				 $text=preg_replace('/<(img) src=("|\')([^<]*?)("|\')( border=("|\')([^<]*?)("|\'))?( .*?)?(\/)?>/ime',"\$this->evaluate('<').'\\1'.'\\9'.\$this->evaluate('>').'\\3'.\$this->evaluate('</').'\\1'.\$this->evaluate('>')",$text);

			}
			else if( preg_match('/<span class=("|\')(center)("|\')>([^<]*)<\/span>/i',$text))
            {           
				 $text=preg_replace('/<span class=("|\')(center)("|\')>([^<]*)<\/span>/ime',"\$this->evaluate('<').\$this->evaluate('span','center').\$this->evaluate('>').'\\4'.\$this->evaluate('</').\$this->evaluate('span','center').\$this->evaluate('>')",$text);
			}
			else if( preg_match('/<span class=("|\')([^<]*?)("|\')>([^<]*)<\/span>/i',$text))
            {           
				 $text=preg_replace('/<span class=("|\')([^<]*?)("|\')>([^<]*)<\/span>/ime',"\$this->evaluate('<').\$this->evaluate('span').'=\\2'.\$this->evaluate('>').'\\4'.\$this->evaluate('</').\$this->evaluate('span').\$this->evaluate('>')",$text);
			}
			else if( preg_match('/<a href=("|\')([^<]*?)("|\') target=("|\')_blank("|\')>([^<]*)<\/a>/i',$text))
            {
			   $text=preg_replace('/<a href=("|\')([^<]*?)("|\') target=("|\')_blank("|\')>([^<]*)<\/a>/ime',"\$this->evaluate('<').\$this->evaluate('a href','\\2').\$this->evaluate('>').'\\6'.\$this->evaluate('</a').\$this->evaluate('>')",$text);
			}
			else if(preg_match('/<a href=("|\')mailto:([^<]*?)("|\')>([^<]*)<\/a>/i',$text))
            {
			   $text=preg_replace('/<a href=("|\')mailto:([^<]*?)("|\')>([^<]*)<\/a>/ime',"\$this->evaluate('<').\$this->evaluate('a email','\\2').\$this->evaluate('>').'\\4'.\$this->evaluate('</a email').\$this->evaluate('>')",$text);
			}
			else if(preg_match('/(<hr(\/)?>)?<(\/)?blockquote>((<smallfont>)?Quote:(<\/smallfont>)?<hr(\/)?>)?/i',$text))
            {
			$text=preg_replace('/(<hr(\/)?>)?<(\/)?blockquote>((<smallfont>)?Quote:(<\/smallfont>)?<hr(\/)?>)?/ime',"\$this->evaluate('<').\$this->evaluate('blockquote','\\1','\\3','\\4').\$this->evaluate('>')",$text);
			}
			else if(preg_match('/<br (\/)?>(\n)?/i',$text))
            {
                $text=preg_replace('/<br (\/)?>(\n)?/im','',$text);
			}
			 else
            {
                break;
			}
		}
		return $text;
	}

	//////////////////////////////////////////////////////////
	/**
	* Dumps the code tags
	* Displays a <pre> block with the "ubb_def" css style class
	*
	* @access   public
	*/
	function listCodes()
	{
		?>
		<pre class="ubb_def">
		[b]...[/b]                          bold
		[i]...[/i]                          italic
		[u]...[/u]                          underline
		[center]...[/center]                center
		[color=name]...[/color]             colors
		[img]...[/img]                      images
		[code]...[/code]                    source code
		[quote]...[/quote]                  blockquote
		[url]http://www.link.me[/url]       links
		[url=http://www.link.me]name[/url]  links
		[email]me@home.de[/email]           email link
		[email=me@home.de]name[/email]      email link
		</pre>
		<?php
	}
	//////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////
?>
