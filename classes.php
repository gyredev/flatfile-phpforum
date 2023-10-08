<?php
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');
//hide warning

error_reporting(E_ALL ^ E_WARNING); 
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');


date_default_timezone_set('GMT');
session_start();
session_regenerate_id();

/**************************************************
classic bb type board. 
Simplified as much as possible.

uses only flatfile data to store  posts and folders w/ css and jquery to make it nice! this is a small cms for those who want to use flat files and no mysql datbase. i wrote it for that reason alone, simplity of apache/filesystem small user base. IT IS pure flatfile staffuser config is in classes.php.

RECOMMENDED TO CHANGE THE SALT and SALT2 before you release on your server.

included main files; classes.php, index.php

by alex kalas
alexk310@yandex.com

**************************************************/




class Constants{
	//security salt change all salts to unique ones before releasing on pub server!
	public $version='v245 rss jquery FINALLLLL';
protected $salt='amk8agzzio21';
protected $salt2='gtrsak3230';
protected $ipsalt='ake9afd0zkg28';


protected $masterips=array('127.0.0.1');//list of privilaged admins, part is needed to bypass captchas and use adminsu power etc
protected $masterpassword='seeyouspacecowboy';//(admins password) also allows skipping of captcha and requirement for adminpanel (for admin user)
protected $adminpanelpassword='pinkpony52';//(admins password for panel)allows full use of admin panel with used with masterpassword

//this is basically 'high admin level cmds'
protected $adminsu_command='dingdingdo21';//certain high commands require password to execute

public $adminpanelenabled=true;//still allows password login for captcha skip, shuts off admin panel to login for administrative actions;remotely/create topics etc

public $saltkeyset;

public $runfile='index.php';

public $hostbase='http://gyrereality.byethost18.com/';

public $language_directory='languages/';
public $resource_directory='res/';
public $section_directory='data/topicsection/';

public $library_directory='lib/';
public $data_directory='data/';
public $upload_directory='data/uploads/';
public $_recentactivity_file='data/rss_recentactivity.xml';//rss based
public $onlineactivity_file='data/online.htm';

public $userlog_file='data/userlog.htm';//log of bad user and abusive spammers
public $stafflog_file='data/stafflog.htm';//log staff actions
public $admincontact_file='data/admincontact.htm';

public $language;

public $time;
public $time_start;


public $language_data=array();
public $settings=array();
public $board_settings=array();
    public function __construct() {
    
    
$this->time_start = microtime(true);



    //$this->section_directory=$_SERVER['DOCUMENT_ROOT'].'/'.$this->section_directory;
    
    
    
//random algorithm for ip encode
$this->saltkeyset=array(
//http://textmechanic.com/Word-Scrambler$this->settings['fileextension']l

//62bit 0-9a-zA-Z
//array('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),



);


        if (!isset($_SESSION['time_in'])){
    $_SESSION['time_in']=time();
    }
    if (!isset($_SESSION['page_views'])){
    $_SESSION['page_views']=0;

    }

//sortpriority is lowest first, userpower limits users the # and above to post
$this->board_settings = array(



'staff updates'=>array(//name corisponds with actual folder in /data/
'icondisp'=>'',
'icon'=>$this->resource_directory.'gyre.gif',
'title'=>'Gyre Reality Updates',
'description'=>'<P style="color:#a73;">The latest updates for the site.</P>',

'allowfileupload'=>1,//allow anon user uploading in this 
'allowcomment'=>1,//allow anon user comments
'password'=>'dragonlair',//, password required for posting topic, can make it difficult for example include dynamic part day of week #
'password2'=>'',//password required for posting reply
'ftpmode'=>0,//new topic only made with ftp or server end
'maxfilesizetopic'=>15145728,//15mb max file size
'posttimelock'=>0,//0 is never, how many days until posting locked from topic creation

'maxtopics_until_archive'=>0,//0 ignores archiving keeps topic constantly alive, when total topics reaches this number it flushes topics for archiving whole section.
'maxfileage_until_archive'=>0,//0 ignores archiving keeps topic constantly alive, INDIVIDUAL TOPIC AGE: in days, based on file age (new posts included) basically age of topic if new will be ignored
//similar to comments small posts
		'minpost_length'=>4,
		'maxpost_length'=>1900,
		//first post is the topic it can be a  type posting detailed information etc
		'mintopic_length'=>15,
		'maxtopic_length'=>70000,
		'timebetween_topic'=>525+rand(0,25),
			'timebetween_comment'=>162+rand(0,10),
				
),
'uti'=>array(//name corisponds with actual folder in /data/
'icondisp'=>'',

'icon'=>$this->resource_directory.'gyre.gif',
'title'=>'Web Utilities',
'description'=>'<P style="">Web scripts that I\'ve made. Useful web links and information. Some random fragmented notes.</P>',

'allowfileupload'=>1,//allow anon user uploading in this 
'allowcomment'=>1,//allow anon user comments
'password'=>'dragonlair',//password required for posting topic
'password2'=>'qaz',//password required for posting reply
'ftpmode'=>0,//new topic only made with ftp or server end
'maxfilesizetopic'=>6145728,//3mb max file size
'posttimelock'=>0,//0 is never, how many days until posting locked from topic creation

'maxtopics_until_archive'=>0,//0 ignores archiving keeps topic constantly alive, when total topics reaches this number it flushes topics for archiving whole section.
'maxfileage_until_archive'=>0,//0 ignores archiving keeps topic constantly alive, INDIVIDUAL TOPIC AGE: in days, based on file age (new posts included) basically age of topic if new will be ignored
//similar to comments small posts
		'minpost_length'=>4,
		'maxpost_length'=>3300,
//first post is the topic it can be a  type posting detailed information etc
		'mintopic_length'=>15,
		'maxtopic_length'=>50000,
		
		'timebetween_topic'=>525+rand(0,25),
			'timebetween_comment'=>162+rand(0,10),
				
		
),

'random'=>array(//name corisponds with actual folder in /data/
'icondisp'=>'
<script>
function random_imglink(){
  var myimages=new Array()
  myimages[1]="http://badkidsgoodgrammar.files.wordpress.com/2010/08/random.jpg"
  myimages[2]="https://images.duckduckgo.com/iu/?u=http%3A%2F%2Fimages5.fanpop.com%2Fimage%2Fphotos%2F25300000%2FRandom-random-25303891-1400-1394.jpg&f=1"
  myimages[3]="https://images.duckduckgo.com/iu/?u=http%3A%2F%2Fselfcentereddotme.files.wordpress.com%2F2013%2F06%2Fsudoku-random-criss-crossed-lines-ron-brown.jpg&f=1"
  myimages[4]="http://i.walmartimages.com/i/mp/00/76/45/03/00/0076450300060_P663534_500X500.jpg"
  myimages[5]="http://fc06.deviantart.net/fs44/f/2009/059/9/9/DMT_by_leddzeppelin89.jpg"
 myimages[6]="http://fc04.deviantart.net/fs38/i/2009/002/d/c/DMT_Eye_by_rogdog.jpg"
 myimages[7]="http://25.media.tumblr.com/tumblr_lp6knsWk8q1r09l4bo1_500.jpg"
 myimages[8]="http://s1.hubimg.com/u/8157578_f520.jpg"
 myimages[9]="http://www.thelonecritic.com/wp-content/uploads/dmt-alien-abduction.jpg"
 myimages[10]="https://s.yimg.com/fz/api/res/1.2/emPNmwQGU8i0MW8P_7G9ow--/YXBwaWQ9c3JjaGRkO2g9NzY4O3E9OTU7dz0xMDI0/http://images4.fanpop.com/image/photos/21700000/Do-you-believe-ufo-and-aliens-21751692-1024-768.jpg"
 myimages[11]="http://images5.fanpop.com/image/photos/28300000/JEET-KUNE-DO-bruce-lee-28329818-500-373.jpg"
 myimages[12]="http://cdn4.miragestudio7.com/wp-content/uploads/2014/03/ancient-aliens.jpg"
 myimages[13]="http://www.intermartialarts.com/sites/default/files/jeet-kune-do.jpg"
 myimages[14]="https://img0.etsystatic.com/000/0/5349832/il_570xN.282013620.jpg"
 myimages[15]="https://pmpaspeakingofprecision.files.wordpress.com/2012/11/8-snake.jpg?w=640"
  myimages[16]="https://inannafilm.files.wordpress.com/2012/02/2-snake-with-huluppu.jpg"
 myimages[17]="https://inannafilm.files.wordpress.com/2012/02/24-yggdrasil-norse-snake-tree-of-life.jpg"
 myimages[18]="http://orig07.deviantart.net/9aef/f/2007/288/0/5/05bc840c0b53cbb6.jpg"




 //myimages[13]=""
  
  var ry=Math.floor(Math.random()*(myimages.length -1)+1 );

     document.write(\'<img src="\'+myimages[ry]+\'" alt="\'+ry+\'" border=0 style="padding:5px;max-height:200px; max-width:270px;text-align:center; vertical-align:middle;float:left;" title="yeah">\');
}

  random_imglink();
  
  </script>
  
',

'icon'=>'http://icons.iconarchive.com/icons/calle/black-knight/32/Swords-icon.png',
'title'=>'Random',
'description'=>'<P style="">Discuss about anything you want...</P>',


'allowfileupload'=>1,//allow anon user uploading in this 
'allowcomment'=>1,//allow anon user comments
'password'=>'',//password required for posting topic
'password2'=>'',//password required for posting reply
'ftpmode'=>0,//new topic only made with ftp or server end
'maxfilesizetopic'=>2145728,//2mb max file size, instead x amount of posts go with filesize
'posttimelock'=>600,//how many days until posting reply expiration

'maxtopics_until_archive'=>150,//0 ignores archiving keeps topics constantly alive, when total topics reaches this number it flushes topics for archiving whole section and the uploads folder.
'maxfileage_until_archive'=>0,//0 in sec, ignores archiving keeps topic constantly alive, INDIVIDUAL TOPIC AGE: in days to seconds, based on file age (new posts included) basically age of topic if new will be ignored
//similar to comments small posts
		'minpost_length'=>4,
		'maxpost_length'=>1900,
		//first post is the topic it can be a  type posting detailed information etc
		'mintopic_length'=>15,
		'maxtopic_length'=>30000,

'timebetween_topic'=>525+rand(0,25),
			'timebetween_comment'=>172+rand(0,10),
				
),




'temple apropos'=>array(//name corisponds with actual folder in /data/
'icondisp'=>'',
'icon'=>'http://1.bp.blogspot.com/_Eqmt-7c6i7k/SSDk1iqoJuI/AAAAAAAABO0/xpkSfw7lcMk/s200/Eye+of+Horus.jpg',
'title'=>'Temple of Apropos',
'description'=>'<P style="color:#0f4;">The personal struggle. Philosophy, psychology, occult knowledge and the noble way to live. Knowledge of the ancient ones brought into the light of the present.</P>',

'allowfileupload'=>1,//allow anon user uploading in this 
'allowcomment'=>1,//allow anon user comments
'password'=>'',//, password required for posting topic, can make it difficult for example include dynamic part day of week #
'password2'=>'',//password required for posting reply
'ftpmode'=>0,//new topic only made with ftp or server end
'maxfilesizetopic'=>15145728,//15mb max file size
'posttimelock'=>0,//0 is never, how many days until posting locked from topic creation

'maxtopics_until_archive'=>0,//0 ignores archiving keeps topic constantly alive, when total topics reaches this number it flushes topics for archiving whole section.
'maxfileage_until_archive'=>655,//0 ignores archiving keeps topic constantly alive, INDIVIDUAL TOPIC AGE: in days, based on file age (new posts included) basically age of topic if new will be ignored
//similar to comments small posts
		'minpost_length'=>4,
		'maxpost_length'=>4900,
		//first post is the topic it can be a  type posting detailed information etc
		'mintopic_length'=>15,
		'maxtopic_length'=>75000,
		'timebetween_topic'=>525+rand(0,25),
			'timebetween_comment'=>172+rand(0,10),
				
),



);




		$this->settings = array(
		'mainfile'=>'index.php',
		'main_'=>'staff updates',// to revert to on errors and to show on frontpage
		
		
		
		//recent activity rss, logall=0 and staffonly=1 will only rss log staff updates, logall=0 will shut rss logging off
		'recentactivity_log'=>array('logall'=>1,'logstaffonly'=>0,'resetfile'=>31000,'previewstandard'=>70,'previewstaff'=>360,'showyoutubesnapshot'=>1),//log recent new topics and new replies 0=false, max size of file.
			
		'rss_start'=>'<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" media="screen" href="/~d/styles/rss2full.xsl"?><?xml-stylesheet type="text/css" media="screen" href="http://feeds.feedburner.com/~d/styles/itemcontent.css"?><rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:feedburner="http://rssnamespace.org/feedburner/ext/1.0" version="2.0">

<channel>
	<title>The Gyre Reality</title>
	
	<link>http://www.gyrereality.byethost18.com</link>
	<description />
	<lastBuildDate>Thu, 07 Jul 2016 06:38:01 +0000</lastBuildDate>
	<language>en-US</language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>http://wordpress.org/?v=4.3.5</generator>
	<atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml" href="http://feeds.feedburner.com/dailysheeple" /><feedburner:info uri="dailysheeple" /><atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="hub" href="http://pubsubhubbub.appspot.com/" /><feedburner:browserFriendly></feedburner:browserFriendly>
',

			
			'iframeshowtopicpreview'=>1,//null=do not show preview, 1-500 show only certain amount of topics with a preview
			
			//logging only non anon user and bots reduce cpu load quitebit
			'usersonline'=>array(1,6000,'nonanon_and_botonly'=>1),//1 show and record user activity,nax file size
		'staffcommandoperator'=>'|',
		'template_post'=>'<div>%1$s</div>',
				'fileextension'=>'.htm',
	
		'minuser_length'=>0,
		'maxuser_length'=>150,
		'minsubject_length'=>8,
		'maxsubject_length'=>218,//constant max filename is usually 255

		
		'request_per_fivemin'=>122,
		'post_per_fivemin'=>3,
	
				'bannedsend'=>'https://www.google.bg/#q=',


		'maximages_posttopic'=>20,
		'maximages_postreply'=>9,

		'runningmysql'=>0,
'archivestamp'=>'Y-M',
		'datestamp'=>'Y-M-d (D) H:i:s',
		'defaultuser'=>'anonymancer',
		
		'maxfilesize'=>4200000,//uploading max size in bytes, default 4 meg
		'maxuploadpersession'=>11,//limit upload per session ignores further uploading
        'uploaddecay'=>7776000,//time until file uploads are removed in sec, default is 90 days
		
		'autoban_maxfailiures'=>7,//this is through local session cuts spammers and logs them as autobanned same with staff login spammer
		);


        $this->language_data = array(
	'english'=>array(

	'panelcommand'=>'<div class="staff_help" style="background-color:#111111; padding:5px;"><div style="color:#0c0; font-weight:bold; font-size:20pt;">The terminal </div>For staff commands type help in the command form; the operator is ['.$this->settings["staffcommandoperator"].']. The operator is used to separate command entries. <p></p> login form: [master password]'.$this->settings["staffcommandoperator"].'[admin panel secret phrase] <p></p> command form: [command name #1]'.$this->settings["staffcommandoperator"].'[command action #2]'.$this->settings["staffcommandoperator"].'[command action #3] ...</div><form accept-charset="utf-8" action="index.php?p=staff#bottom" method="post"><input type="password" name="password" placeholder="Password" title="password" class="staff_terminal" maxlength="60"></br><textarea placeholder="Command" title="command" class="staff_terminal" name="command" style="width:750px;height:200px;">%1$s</textarea><br /><input type="submit" value="Run Query"><a href="#bottom" name="bottom"></a>',
	
	
'post_helpdescription'=>'<div id="help" style="text-align:center;"><a title="Embed youtube vids,images,url links etc">[Click for Help/Embed]</a></div><div 
id="posthelp" style=""><a onclick="$(\'#comment\').val(readCookie(\'savecomm\'))"><div 
style="color:#bb0000;background-color:#000000;">Click to restore last saved text and replace current text (if cookies were enabled and not deleted from last message)</div></a><P><b>List of bbcode tags that are allowed: 
<hr>
<h3>Click the tag examples below to add to your post.</h3></b>
<hr />
<a onclick="bbcode(\'0\',\'[#]\',\'[/#]\');">[#]number[/#] Response to user, just click the # or double click post date area.</a><br /><a  onclick="var s=prompt(\'Provide URL to embed link\',\'\'); bbcode(\'\'+s+\'\',\'[url]\',\'[/url] \');">[url](url)[/url]</a><br /> <a onclick="var s=prompt(\'Provide URL to embed link\',\'\');var s2=prompt(\'Provide name of link\',\'\');bbcode(\'\'+s2+\'\',\'[url=\'+s+\']\',\'[/url] \');">[url=(url)](Link name)[/url]</a><br /> <a onclick="bbcode(\'\',\'[h2]\',\'[/h2]\');">[h(2-4)]<h2 style="display:inline">h2</h2> <h3 style="display:inline">h3</h3> <h4 style="display:inline">h4</h4>[/h(2-4)]</a><br /> <a onclick="bbcode(\'\',\'[hidden]\',\'[/hidden]\');">[hidden]<span id="hidden">hide the text, show when hovered</span>[/hidden]</a><br /> <a onclick="bbcode(\'\',\'[quote]\',\'[/quote]\');">[quote]<blockquote>quoted text</blockquote>[/quote]</a><br /><a onclick="bbcode(\'\',\'[b]\',\'[/b]\');">[b]<b>bold text</b>[/b]</a><br /> <a onclick="bbcode(\'\',\'[i]\',\'[/i]\');">[i]<i>italic text</i>[/i]</a><br /> <a onclick="bbcode(\'\',\'[color=red]\',\'[/color]\');">[color=(red)]<font style="color:red">red text</font>[/color]</a><br /> <a onclick="var s=prompt(\'URL of image to embed\',\'\'); bbcode(\'\'+s+\'\',\'[img]\',\'[/img]\');">[img](image url)[/img]</a><br /> <a onclick="var s=prompt(\'Youtube url to embed a video\',\'\'); var s=s.replace(\'https://www.youtube.com/watch?v=\',\'\');  bbcode(\'\'+s+\'\',\'[youtube]\',\'[/youtube]\');">[youtube](video code id ex: 6gSPhR2oBkc)[/youtube]</a><br /><a onclick="bbcode(\' \',\'[code]\',\'[/code]\');">[code][/code]</a><br /><a onclick="bbcode(\'\',\'[p]\',\'[/p]\');">[p]paragraph indent[/p]</a><br /></P><P><b>How to lock topic:</b> Make sure the name of the topic contains "[locked]" (case insensitive)</P><P><b>Allowed upload Filetypes:</b> bz2,.tar, .zip, .txt, .odt, .rtf, .doc, .pdf, .jpg, .png, .gif, .webm <P></P><P><b>Maximum file size:</b> %1$d bytes.</P></div>
<script type="text/javascript">

window.onload=document.getElementById("posthelp").style.display="none";
$("#help").click(function () {
if ($("#posthelp").css("display")=="none") {
$("#posthelp").show("slow");
}else{
$("#posthelp").hide("slow");

}
});

</script><noscript><b>JS disabled.</b></noscript>

',

	

'bannedtext'=>'YOU WERE BANNED FROM GYREREALITY contact brannon.kim1985@hushmail.com for appeal; ',

	),
        
	);
    
    
switch (isset($_GET['l'])) {
    case 'english':
        	$this->language='english';
        break;
    case 'espanol':
        	$this->language='español';
        break;
    default:
    $this->language='english';
}

    
    }

public function get_langset(){

return $this->languageid;
}

}


class Security_and_SpamHandler extends NodeFunctions{
public $isbot=false;
public $bans_location;
    public function __construct() {
        parent::__construct();

    $this->run_init_banlist();

//probe for spammers
 $this->run_request_spammer();

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}







$qaz=isset($_GET['qaz'])?$_GET['qaz']:'';
$qaz2=isset($_GET['qq'])?$_GET['qq']:'';
switch ($qaz)
{
	
case 'iframepreview':
echo '<html><head><script type="application/javascript" src="'.$this->resource_directory.'jquery.min.js"></script><script type="application/javascript" src="'.$this->resource_directory.'main.js"></script><link rel="stylesheet" href="'.$this->resource_directory.'classic.css" id="stylesheet" type="text/css" media="screen, projection" /></head><body><div class="wrap"><div class="content">';

echo $this->view_page('index.php','');
echo '<script type="text/javascript">postinit();</script></div><div class="clear"></div></div></body></html>';


die();
break;
	
	
case 'testutf':

echo ' truncate= '.$this->truncate($qaz2,400).' andparsed= '.$this->parse_generaltext($this->truncate($qaz2,400));


break;
case 'parse':
echo 'ok: '. $this->parse_generaltext($qaz2);
break;
	case 'qaz':
			 $this->handle_banned_user('banned');
			die;
	break;
	
case 'harvestmoon':
			   // array of possible top-level domains
  $tlds = array("com", "net", "gov", "org", "edu", "biz", "info");

  // string of possible characters
  $char = "0123456789abcdefghijklmnopqrstuvwxyz";

  // start output
  echo "<p>\n";

  // main loop - this gives 1000 addresses
  for ($j = 0; $j < 1000; $j++) {

    // choose random lengths for the username ($ulen) and the domain ($dlen)
    $ulen = mt_rand(5, 10);
    $dlen = mt_rand(7, 17);

    // reset the address
    $a = "";

    // get $ulen random entries from the list of possible characters
    // these make up the username (to the left of the @)
    for ($i = 1; $i <= $ulen; $i++) {
      $a .= substr($char, mt_rand(0, strlen($char)), 1);
    }

    // wouldn't work so well without this
    $a .= "@";

    // now get $dlen entries from the list of possible characters
    // this is the domain name (to the right of the @, excluding the tld)
    for ($i = 1; $i <= $dlen; $i++) {
      $a .= substr($char, mt_rand(0, strlen($char)), 1);
    }

    // need a dot to separate the domain from the tld
    $a .= ".";

    // finally, pick a random top-level domain and stick it on the end
    $a .= $tlds[mt_rand(0, (sizeof($tlds)-1))];

    // done - echo the address inside a link
    echo "<a href=\"mailto:". $a. "\">". $a. "</a><br>\n";

  } 

  // tidy up - finish the paragraph
  echo "</p>\n";

			
			die;
	break;

return;
break;

}	 

    }
        
    
	public function user_powerlevel() {
		//priviliged users with correct pass and ip may avoid bot and captcha check.
		//$_SERVER['REMOTE_ADDR']
			
  $_SESSION['password']=!isset(  $_SESSION['password'])?'':$_SESSION['password'];
  
  if (md5($this->get_ip().$this->salt.$this->masterpassword.'|'.$this->adminpanelpassword.$this->salt2)==$_SESSION['password']) {

  return true;
  }
  
       return false;
    }

    
    
    public function handle_banned_user($a) {
    
header('Location: '.$this->settings['bannedsend'].$this->language_data[$this->language]['bannedtext'].$a);
die('<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$this->settings['bannedsend'].'"><script><iframe>');

    }
    
    public function run_request_spammer(){
    
   // $this->settings['request_per_fivemin'];
  //  $this->settings['post_per_fivemin']; $this->settings['post_per_fivemin'] (time()-$_SESSION['time_in'])/


if (isset ($_SESSION['badauth']) && $_SESSION['badauth']>$this->settings['autoban_maxfailiures'] ) {

		$this->readwritefile($this->userlog_file,'a','   tban badauth spam ==><input value="'.$dyntype['security']->get_ip().'">');
	
   $this->handle_banned_user('spammer/malicious use');
 
}


  if( ( $_SESSION['page_views'] > 10 && time()-$_SESSION['time_in']>600 ) &&  $_SESSION['page_views']/((time()-$_SESSION['time_in'])/300)>$this->settings['request_per_fivemin']  ) {    
					$this->readwritefile($this->userlog_file,'a','   tban request spam ==><input value="'.$dyntype['security']->get_ip().'">');
	
    $this->handle_banned_user('req spammer');
    }
    
    }
   	public function ReverseIPOctets($inputip){
$ipoc = explode(".",$inputip);
return $ipoc[3].".".$ipoc[2].".".$ipoc[1].".".$ipoc[0];
}
	public function IsTorExitPoint(){
if (gethostbyname($this->ReverseIPOctets($_SERVER['REMOTE_ADDR']).".".$_SERVER['SERVER_PORT'].".".$this->ReverseIPOctets($_SERVER['SERVER_ADDR']).".ip-port.exitlist.torproject.org")=="127.0.0.2") {
	
	return true;
} else {
return false;
} 
}



	public function run_block_hostnames(){

/*
 * # block proxy servers from site access
# https://perishablepress.com/press/2008/04/20/how-to-block-proxy-servers-via-htaccess/

RewriteEngine on
RewriteCond %{HTTP:VIA}                 !^$ [OR]
RewriteCond %{HTTP:FORWARDED}           !^$ [OR]
RewriteCond %{HTTP:USERAGENT_VIA}       !^$ [OR]
RewriteCond %{HTTP:X_FORWARDED_FOR}     !^$ [OR]
RewriteCond %{HTTP:PROXY_CONNECTION}    !^$ [OR]
RewriteCond %{HTTP:XPROXY_CONNECTION}   !^$ [OR]
RewriteCond %{HTTP:HTTP_PC_REMOTE_ADDR} !^$ [OR]
RewriteCond %{HTTP:HTTP_CLIENT_IP}      !^$
RewriteRule ^(.*)$ - [F]
*/		
	//hostname/useragent bad list
	$badhost=array(
	'priv',
	'pro',
	'ghost',
	'hide',
	'ass',
	'l33t',
	'1337',
	'elite',
	'cloak',
	//'bot',
	//russ bots
	'ilove',
	'tube',
	'samalt',
	'buttons',
	'daroda',
	'econom',
	'kamba',
	
	);
	
	if (in_array(strtolower(gethostbyaddr($this->get_ip())), $badhost) || in_array(strtolower($_SERVER['HTTP_USER_AGENT']),$badhost)) {
	$this->handle_banned_user('hostname blocked');
	return true;
	}
	return false;
	}

	
	
public function run_init_banlist() {
$isbanned=0;

			if (!isset($_SESSION['runblist'])){


require('banlist.php');	

			$_SESSION['badauth']=1;

	if ($this->settings['usersonline'][0]==1) {
		$_COOKIE['name']=!isset($_COOKIE['name'])?$this->settings['defaultuser']:$this->parse_generaltext($this->truncate($_COOKIE['name'],$this->settings['maxuser_length']));

$d=strtolower(gethostbyaddr($_SERVER['REMOTE_ADDR']));
$dd=explode('.',$d);
$ds=sizeof($dd);
unset($dd[0]);
$dd=implode('.',$dd);

$info=$ds>1?$dd:$d;
$info=$_COOKIE['name']!=$this->settings['defaultuser']?'':$info;


if (filesize($this->onlineactivity_file) > $this->settings['usersonline'][1]) {
$this->readwritefile($this->onlineactivity_file,'w',' <span class="usr" style="color:'.$this->generate_randcolor(3,7).';">'.$_COOKIE['name'].' '.$info.' <script type="text/javascript">document.write(ago('.time().'));</script></span>');

}else{


//can do strpos either bot or .com
if(
( $this->settings['usersonline']['nonanon_and_botonly']==1 
&& $info!=null && ($_COOKIE['name']!=$this->settings['defaultuser'] || strpos('bot',$d)) || strpos('spider',$d)))  {	
	$r=' <span class="usr" style="color:'.$this->generate_randcolor(3,7).';">'.$_COOKIE['name'].' '.$info.' <script type="text/javascript">document.write(ago('.time().'));</script></span>'. $this->readwritefile($this->onlineactivity_file,'r','');

$this->readwritefile($this->onlineactivity_file,'w',$r);

}




}


}

		/*
list of bans;
*/



$banlist = 
array(


//ip, cidr range #,message or note user detail

array('220.248.0.0','11','china - hacks and spams'),

//list of pub proxies


);

$banlist=array_merge($banlist,$exbanlist);

		
		for($i=0;$i<sizeof($banlist);$i++){
		if (
		
		//ipcidrcheck seems over rich
		//$this->ipcidrcheck($banlist[$i][0],$banlist[$i][1]) 
		$this->ip_in_network($this->get_ip(), $banlist[$i][0],$banlist[$i][1]) )  {
		$isbanned=1; $_SESSION['bannedreason']=$banlist[$i][2];
		$this->handle_banned_user($banlist[$i][2]);
				   
		}
		
		}

		    $_SESSION['runblist']=$isbanned;
		     //block list of bad hostnames
			$this->run_block_hostnames();
			if ($this->IsTorExitPoint()) {
				
				
    $this->handle_banned_user('tor');

				}
			
			}//end
					 


}



public function generate_randcolor($min,$max)
{
$max=$max>16||$max==null?$max=15:$max;
$min=$min==null?$min=0:$min;


$hex16=array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');


$color='#';
for ($i=0;$i<6;$i++){
$bit=rand($min,$max);

$color.=$hex16[$bit];

}
return $color;
}




		public function generate_captcha($min,$max,$type) {
unset(		$_SESSION['captcha_val']);


//rely on unique form ids,hidden fields and token measures to prevent spam
//comment and uncomment below captchas to use
		$_SESSION['captcha_val']=rand(0,100000);

	//////////////////////////////////////////
	/// LOGIC TEST real QUALITY OF ITEM
	///
	//////////
/*
//banana is yellow fish
//grass is plant animal 


*/
	//////////////////////////////////////////
	///RANDOM MATH TEST
	///
	//////////
/*
	$arg1 = rand (0,12);
	$arg2 = rand (0,12);
	$arg3 = rand (0,100);
	
	$op_mult=array('times','multiplied','x','*');
	$op_add=array('+','plus','and','add');
	
	
$questions=array("{$arg1} ".$op_mult[rand(0,sizeof($op_mult)-1)]." {$arg2} = ?","{$arg1} ".$op_add[rand(0,sizeof($op_add)-1)]." {$arg2} = ?","{$arg1} ".$op_add[rand(0,sizeof($op_add)-1)]." {$arg2} ".$op_add[rand(0,sizeof($op_add)-1)]." {$arg3} = ?");
$answers=array(($arg1*$arg2),($arg1+$arg2),($arg1+$arg2+$arg3));
//pow($arg1,$arg1)
$ranstring = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 2, rand(2,12));


$randquestion=rand(0,sizeof($questions)-1);
	
	$asking =array('whats '.$questions[$randquestion]);

	$_SESSION['captcha']=md5($answers[$randquestion].$this->salt);

	
	
	
return "<div id='captchaq' style='text-align:center;'>".str_pad( $asking[rand(0,sizeof($asking)-1)], rand(0,74), "  ", STR_PAD_BOTH)."</div><script type='text/javascript'>var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
			
$('#captchaq').css('color',hue);</script>";

*/
	//////////////////////////////////////////
	///STANDARD CAPTCHA IMAGE SIMILAR TO GOOGLE
	///
	//////////
//return '<img src="captcha/captcha.php" alt="captcha">';


	//////////////////////////////////////////
	///DARK COLOR DECODE TEST
	///
	//////////
/*
if ($min==null&&$max==null) { $min=3;$max=6; }




$ran=array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n');

$captcha='';
$showcaptcha='';
//substr(md5(rand()), 0, 7)

for ($i=0;$i<rand($min,$max);$i++){
$realbitcolor=$this->generate_randcolor(2,7);

$rand=$ran[rand(0,23)];

$captcha.=$rand;
$showcaptcha.='<span style="color:'.$this->generate_randcolor(9,'').';">'.$ran[rand(0,23)].'</span><span style="color:'.$realbitcolor.';">'.$rand.'</span><span style="color:'.$this->generate_randcolor(9,'').';">'.$ran[rand(0,23)].'</span>';


}


$_SESSION['captcha']=md5($captcha);
	//htmlspecialchars("<a href='test'>Test</a>", UTF-8);







return '<span class="captcha">type the darker color<br />'.$showcaptcha.'</span>';

*/

	}



		public function validate_captcha($skip) {
if (!isset($_POST['captcha'])) {return false;}



if (isset($_POST['captcha']) && ($_POST['captcha'])==$_SESSION['captcha_val'] || $skip){
return true;
}

echo 'wrong captcha code';
return false;
								}
	
	
public function get_ip()
{

if (!empty($_SERVER["HTTP_CLIENT_IP"]))
{
//check for ip from share internet
$ip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
// Check for the Proxy User
$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
$ip = $_SERVER["REMOTE_ADDR"];
}
// This will echo user's real IP Address
// does't matter if user using proxy or not.
return $ip;

}


public function generate_token($tok,$t) {
	//session_id() 
	
	$_SESSION['time']=time();
	$_SESSION['pot']=$tok;
	$token=md5( $this->get_ip(). $tok.$t . $this->salt );
$_SESSION['token']=$token;

return $token;
}

public function validate_token($tok,$t) {
if (

 isset($_SESSION['time']) && 
 isset($_SESSION['token']) && 
$_SESSION['time'] == $t &&

md5( $this->get_ip(). $tok.$t . $this->salt ) == $_SESSION['token'] ) {
	return true;
}
return false;

}
     public function ipcidrcheck ($IP, $CIDR) {
    list ($net, $mask) = split ("/", $CIDR);
   
    $ip_net = ip2long ($net);
    $ip_mask = ~((1 << (32 - $mask)) - 1);

    $ip_ip = ip2long ($IP);

    $ip_ip_net = $ip_ip & $ip_mask;

    return ($ip_ip_net == $ip_net);
  }
    
	   public function ip_in_network($ip, $net_addr, $net_mask){
	    if($net_mask <= 0){ return false; }
		$ip_binary_string = sprintf("%032b",ip2long($ip));
		$net_binary_string = sprintf("%032b",ip2long($net_addr));
		return (substr_compare($ip_binary_string,$net_binary_string,0,$net_mask) === 0);
	}
	
	
	
	
	
}




class AdministrativeTools extends NodeFunctions{

public function panelprocessquery($security) {

/*
postpone admin panel for now
 
 */



$a=isset($_POST['command'])?$_POST['command']:null;
$p=explode($this->settings["staffcommandoperator"], $a);
$password=isset($_POST['password']) && $_POST['password']!=''?$_POST['password']:null;
$passwordform=explode($this->settings["staffcommandoperator"], $password);
echo sprintf($this->language_data[$this->language]['panelcommand'],$a);

if ( sizeof($p)>30 || sizeof($p)<1 || !isset($_POST['command']) ){ return; }

if ( !$this->adminpanelenabled ) { echo '<div>admin panel is disabled - logging in to bypass captcha is retained.</div>'; return; };
if ($password!="") {
$_SESSION['password']=md5($security->get_ip().$this->salt.$password.$this->salt2);
}
		if (isset($_SESSION['password']) && $_SESSION['password']!=null && $_SESSION['password']!=md5($security->get_ip().$this->salt.$this->masterpassword.'|'.$this->adminpanelpassword.$this->salt2) ){


$staffspamban=3;


			$_SESSION['badauth']+=1; if ($_SESSION['badauth']>=$staffspamban) {
				
				//htaccess autoban here
	$this->readwritefile($this->userlog_file,'a','   staff badauth==><input value="'.$security->get_ip().'">');
	 $security->handle_banned_user('staff spam'); } echo'<div class="error">you are not authorized '.$_SESSION['badauth'].'/3 attempts</div>'; return; 
	 
	 }

			switch($p[0]) {
			
			case 'maketopic':
echo "posting the following to '".$p[1]."', named '".$p[2]."'. <p></p><textarea style='width:400px;height:300px;'>".$p[3]."</textarea>";

		if (is_dir($this->section_directory.''.$p[1])) {

$r=$this->readwritefile($this->section_directory.''.$p[1].'/'.$p[2].$this->settings['fileextension'],'w',stripslashes($p[3]));
	}else{ 
		echo '<P></P>"'.$this->section_directory.''.$p[1].'" directory doesnt exist.';
	}

			break;
			
			case 'banip':
			if (isset($_POST['ip']) ) {
				
				
				//dont allow everything
				//if (strpos($a,'are') !== false) {
			//htaccess autoban here
			echo 'start. ';
			
				$r=$this->readwritefile("banlist.php",'r','');
			$r=str_replace(');?>','',$r);
			$_POST['ip']=substr($_POST['ip'],0,3)>=0 && substr_count($_POST['ip'], '.')==3 ?$_POST['ip']:$this->quickconvert($_POST['ip'],$this->ipsalt);

			$p=explode(',',$_POST['ip']);
			if ($p>0 && $p<6){
				
				for($i=0;$i<sizeof($p);$i++)
				{
				
			$r=explode(',',$_POST['reason']);	
			$c=explode(',',$_POST['cidr']);
						$dat.=stripslashes('array("'.$p[$i].'","'.$c[$i].'","'.$r[$i].'"), ');
					
				}
				
			}else{
							$dat=stripslashes('array("'.$_POST['ip'].'","'.$_POST['cidr'].'","'.$_POST['reason'].'"),');
			
			}
			echo 'ok.';
				$this->readwritefile("banlist.php",'w',$r.PHP_EOL.$dat.'//'.$security->get_ip().' '.date("Ymd hms").PHP_EOL.' );?>');
			}

			echo '<div>Use complete ip SYNTAX addresses in the field ex 127.0.0.1 4 numbers. you can use raw userid for ip it\'ll auto convert it for you to make it easy :). if you want to do more then 1 ip at a time you can do 5 separate each ip,cidr and reason with a "," colon. BE careful with cidr (range ip ban) average ban 26-15 worst spammy user/hosts. this is all  based on severity, be sure to understand it https://oav.net/mirrors/cidr.html. <P>*ranges: 8 (Class A), 16 (Class B) or 24 (Class C).
* 
a.b.c.d/26 	+0.0.0.63 	255.255.255.192 	64 	¼ C 	d = 0, 64, 128, 192
a.b.c.d/25 	+0.0.0.127 	255.255.255.128 	128 	½ C 	d = 0, 128
a.b.c.0/24 	+0.0.0.255 	255.255.255.000 	256 	1 C 	
a.b.c.0/23 	+0.0.1.255 	255.255.254.000 	512 	2 C 	c = 0 ... (2n) ... 254
a.b.c.0/22 	+0.0.3.255 	255.255.252.000 	1,024 	4 C 	c = 0 ... (4n) ... 252
a.b.c.0/21 	+0.0.7.255 	255.255.248.000 	2,048 	8 C 	c = 0 ... (8n) ... 248
a.b.c.0/20 	+0.0.15.255 	255.255.240.000 	4,096 	16 C 	c = 0 ... (16n) ... 240
a.b.c.0/19 	+0.0.31.255 	255.255.224.000 	8,192 	32 C 	c = 0 ... (32n) ... 224
a.b.c.0/18 	+0.0.63.255 	255.255.192.000 	16,384 	64 C 	c = 0, 64, 128, 192
a.b.c.0/17 	+0.0.127.255 	255.255.128.000 	32,768 	128 C 	c = 0, 128
a.b.0.0/16 	+0.0.255.255 	255.255.000.000 	65,536 	256 C = 1 B 	
a.b.0.0/15 	+0.1.255.255 	255.254.000.000 	131,072 	2 B 	b = 0 ... (2n) ... 254
a.b.0.0/14 	+0.3.255.255 	255.252.000.000 	262,144 	4 B 	b = 0 ... (4n) ... 252
a.b.0.0/13 	+0.7.255.255 	255.248.000.000 	524,288 	8 B 	b = 0 ... (8n) ... 248
a.b.0.0/12 	+0.15.255.255 	255.240.000.000 	1,048,576 	16 B 	b = 0 ... (16n) ... 240
a.b.0.0/11 	+0.31.255.255 	255.224.000.000 	2,097,152 	32 B 	b = 0 ... (32n) ... 224
a.b.0.0/10 	+0.63.255.255 	255.192.000.000 	4,194,304 	64 B 	b = 0, 64, 128, 192
a.b.0.0/9 	+0.127.255.255 	255.128.000.000 	8,388,608 	128 B 	b = 0, 128

</P></div>
			
			
			<textarea placeholder="ip addr" class="staff_terminal" name="ip"></textarea><textarea placeholder="cidr range" class="staff_terminal" name="cidr"></textarea><textarea placeholder="reason" class="staff_terminal" name="reason"></textarea>';
			
		
		
			break;
			
			case 'ipde':
			$p[1]=!isset($p[1])?null:$p[1];
					echo '<div>your ip is: '.$security->get_ip().', decoded/encoded ip <input type="text" value="'.$this->quickconvert($p[1],$this->ipsalt).'"></div>';
			break;
			
			case 'logout':
			case 'out':
			unset($_SESSION['password']);
			echo '<meta http-equiv="refresh" content="2">';
			break;
			
			case 'nano':

			if (isset($p[1]) && isset($p[2]) && $p[2]==$this->adminsu_command) {
			if (isset($_POST['nano']) && $_POST['nano']!=null) {
				$this->readwritefile($p[1],'w',stripslashes($_POST['nano']));
			}
			
echo '';
			touch($p[1]);
			chmod($p[1],0755);
$r=$this->readwritefile($p[1],'r','');
			echo '<div style="font-size:300%;">file:'.$p[1].'</div><textarea class="staff_terminal" style="width:800px;height:400px;" name="nano">'.$r.'</textarea>';
			
			
		}else{$_SESSION['badauth']+=.5; echo " incorrect adminsu password. bad tries ".$_SESSION['badauth']." of ".$staffspamban; }
			break;
						case 'rm':
						
										if (isset($p[1])&& isset($p[2]) && $p[2]==$this->adminsu_command) {
										
											if (file_exists($p[1])) {
				unlink($p[1]);
				echo "<div>removed file</div>";
			}else{ echo "<div>file doesnt exist</div>";}
			

				}else{$_SESSION['badauth']+=.5; echo " incorrect adminsu password. bad tries ".$_SESSION['badauth']." of ".$staffspamban;}
			break;

			case 'makeforum':
	
if (mkdir($this->section_directory.''.$p[1], 0755)){
echo "<div>".$p[1]." was made</div>";
	$this->readwritefile($this->userlog_file,'a','   staff made sect '.$p[1].' ==><input value="'.$security->get_ip().'">');

}

			break;
						
			case 'removeforum':
if ($p[1]!=null && isset($p[2]) && $p[2]==$this->adminsu_command) {

	if ($this->deltree($this->section_directory.$p[1])){
	echo "<div>".$p[1]." dir/dirs were removed</div>";

	}

}else{$_SESSION['badauth']+=.5; echo " incorrect adminsu password. bad tries ".$_SESSION['badauth']." of ".$staffspamban; }


			break;
			// create new board forum


		
			case 'help':
echo "<div style='font-size:200%;'>All available commands (su requires additional password syn): makeforum [name], removeforum [name] [su pass], maketopic [name of  forum] [(YYMMDD) + desired name of topic] [topic content including html and excluding the operator], nano [new/existing file path edit, to rename nano copy paste and remove file paste content in new file (nano makes new file if doesnt exist)] [su password]. (nano can be used to create/edit banlists on '.htaccess' and deny all offending ip. urlencode and serialize is a redundent way to add bans through init blist, that is admin only), rm [file path] [su password] (removes file) , logout or out (logs you out), ipde [ip userid decoded or to encode], banip [adds ip to banlist] 
<P>staff log ".$this->stafflog_file.", user log ".$this->userlog_file."</P>
<P>quick locations: banlist.php,  ".$this->section_directory."#yoursection/#file or archive</P></div>";
			break;

			}
			
			
			echo '</form>';
			
			
			

}




}

class NodeFunctions extends Constants {
    public $name;
    public $subject;
    public $comment;
    public $file;
    public function __construct() {
    parent::__construct();

}


public function dirtoarray($dir,$showdir=true,$dironly=false) {
  if (!is_dir($dir)) { return false;}
   $result = array();

   $cdir = scandir($dir);
   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,array(".","..")))
      {
		  $isdir=is_dir($dir . DIRECTORY_SEPARATOR . $value);
		  
         if ( ( $showdir )&& $isdir)
         {
         $result[$value] = $this->dirtoarray($dir . DIRECTORY_SEPARATOR . $value);
         }
         else if (!$isdir) 
         {
         if (!$dironly)   $result[] = $value;
         }
      }
   }
  
   return $result;
} 


public function recursive_directory_delete($dir)
{
     // if the path has a slash at the end we remove it here
     if(substr($directory,-1) == '/')
     {
          $directory = substr($directory,0,-1);
     }

     // if the path is not valid or is not a directory ...
     if(!file_exists($directory) || !is_dir($directory))
     {
          // ... we return false and exit the function
          return FALSE;

     // ... if the path is not readable
     }elseif(!is_readable($directory))
     {
          // ... we return false and exit the function
          return FALSE;

     // ... else if the path is readable
     }else{

          // we open the directory
          $handle = opendir($directory);

          // and scan through the items inside
          while (FALSE !== ($item = readdir($handle)))
          {
               // if the filepointer is not the current directory
               // or the parent directory
               if($item != '.' && $item != '..')
               {
                    // we build the new path to delete
                    $path = $directory.'/'.$item;

                    // if the new path is a directory
                    if(is_dir($path))
                    {
                         // we call this function with the new path
                         recursive_directory_delete($path);

                    // if the new path is a file
                    }else{
                         // we remove the file
                         unlink($path);
                    }
               }
          }
          // close the directory
          closedir($handle);

          // return success
          return TRUE;
     }
} 


   public function is_rss($feedxml) {
    @$feed = new SimpleXMLElement($feedxml);

    if ($feed->channel->item) {
        return true;
    } else {
        return false;
    }
}

public function is_atom($feedxml) {
    @$feed = new SimpleXMLElement($feedxml);

    if ($feed->entry) {
        return true;
    } else {
        return false;
    }
}     

    public function get_page_id(){

return isset($_GET['p'])?htmlentities(substr(basename($_GET['p']),0,100)):'';
    return;
    }
public function get_topic_id(){
return isset($_GET['t'])?urldecode(substr($_GET['t'],0,400)):'';
    return;
    }
    
public function get_section_id(){
//
if (isset($_GET['s']) && !isset($this->board_settings[$_GET['s']] )) {
	
	return $this->settings['main_'];
}


return isset($_GET['s'])?htmlentities(substr(basename($_GET['s']),0,400)):'';
    return;
    
    
    }



public function readwritefile($x,$y,$z)
{
$get=null;
		if ( ($y=='r'||$y=='r+') && !file_exists($x) ){
			
		}else{

$fp = fopen($x,$y);
if (!$fp) { fclose($fp);echo 'file stream open issues, access denied';return false; }

if (flock($fp, LOCK_EX)) {  // acquire an exclusive lock
   // ftruncate($fp, 0);      // truncate file
   if ($y=='a'||$y=='w'){ if (!fwrite($fp, $z) ){ fclose($fp);flock($fp, LOCK_UN); return false;} 
	   }else if($y=='r'&&filesize($x)>0){ $get=fread($fp, filesize($x)); }
    fflush($fp);            // flush output before releasing the lock
    flock($fp, LOCK_UN);    // release the lock
}
fclose($fp);
		}

return $get;
}







public function time_elapsed($hist,$rawtime=''){

$time=time()-$hist;
$time=$time<0?0:$time;



$tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    if ($rawtime=='days') {

		return floor($time/86400);
	}    



    $responses = array();
    $i=0;
 
 
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }
            $i++;
            $numberOfUnits = round($time / $unit,2);

            $responses[] = $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
            $time -= ($unit * $numberOfUnits);
            break;
        }
    

    if (!empty($responses)) {
        return implode(', ', $responses) . ' ago';
    }

    return 'Just now';      
    
    
    
    }


public function truncate($subject, $length = 100, $options = array()) {
//substr for viewing snippets of topics and recent activity, WITHOUT
//fragmented html ruining markup of page.

 

if (sizeof($options)>=1) {
	
	
	//this is critical for accurate count text in recent activity widget instead of fragments
	if (isset($options['imgonly']) || $options[0]='<img>') 
	
	{
	
		$subject=strip_tags($subject,'<img>');
	}

	
}
if ($subject==null) return;

//utf 8 encoding

htmlspecialchars($subject, ENT_NOQUOTES, "UTF-8");

$subject=substr($subject,0, $length);

$dom= new DOMDocument();


//span instead of default <p encapsulation

$dom->encoding = 'utf-8';

//load html is messing with utf pass
//,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
$dom->loadHTML(mb_convert_encoding(''.$subject.'', 'HTML-ENTITIES', 'UTF-8') );

//return $subject;


# remove <!DOCTYPE 
$dom->removeChild($dom->doctype);           

# remove <html><body></body></html> 
if ($dom->firstChild->firstChild->firstChild->firstChild==null) {

}else{	
$dom->replaceChild($dom->firstChild->firstChild->firstChild->firstChild, $dom->firstChild);
}

$xpath = new DOMXPath($dom);
$body = $xpath->query('/html/body');
$subject=trim($dom->saveHTML(($body->item(0))));

return $subject;


}





//parse files for 
public function seofriendly($x) {

$x=trim(strip_tags($x));

$seoname = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $x);//makes it file friendly, also very crucial for the function of newtopics name and reading topics to work properly
// Remove any runs of periods (thanks falstro!),
$seoname = preg_replace("([\.]{2,})", '', $seoname);
$seoname = preg_replace('/\]/','',$seoname);
$seoname = preg_replace('/\%/',' percent',$seoname);
$seoname = preg_replace('/\@/',' at ',$seoname);
$seoname = preg_replace('/\&/',' and ',$seoname);
$seoname = preg_replace('/\s[\s]+/','',$seoname);    // Strip off multiple spaces
//$seoname = preg_replace('/[\s\W]+/','-',$seoname);    // Strip off spaces and non-alpha-numeric
$seoname = preg_replace('/^[\-]+/','',$seoname); // Strip off the starting hyphens
$seoname = preg_replace('/[\-]+$/','',$seoname); // // Strip off the ending hyphens

//$seoname = strtolower($seoname); 
return ($seoname);
}

public function copyemz($file1,$file2){
          if (!file_exists($file1) ) {
              echo '<div>copy file '.$file1.' doesnt exist</div>';
              return false;
              }
 
          $contentx =@file_get_contents($file1);
        if (!is_dir(dirname($file2)) ){  mkdir(dirname($file2), 0755, true); }
         
         $openedfile = fopen($file2, "w");
                   fwrite($openedfile, $contentx);
                   fclose($openedfile);
                  unlink($file1);
                  if (!file_exists($file2) || file_exists($file1) ) { 
                                                            echo '<div>copy unsuccessful '.$file2.' or file '.$file1.' was not removed due to permission</div>';
                                                            return false;
                  }
                              
                  
    if (!chmod($file2,755) ) {
        echo '<div>unable to chmod copied file '.$file2.'</div>';
        }
    if ($contentx === FALSE) {
                   return false;
                    }
                    return true;
    }

public function parse_passwordtext($a){
if ($a==null){return true;}
return addslashes(htmltentities($a));

}

public function html2rss($content){
//xml syntax 
 // if($content==null){ return false; }

return trim(nl2br((($content))));

/*
    // xml well formed content can be loaded as xml node tree
    $fragment = $dom->createDocumentFragment();
    // wonderfull appendXML to add an XML string directly into the node tree!

    // aappendxml will fail on a xml declaration so manually skip this when occurred
    if( substr( $content,0, 5) == '<?xml' ) {
      $content = substr($content,strpos($content,'>')+1);
      if( strpos($content,'<') ) {
        $content = substr($content,strpos($content,'<'));
      }
    }

    // if appendXML is not working then use below htmlToXml() for nasty html correction
    if(!@$fragment->appendXML( $content )) {
      return $this->html2rss($dom,$content);
    }

    return $fragment;
	*/
}

public function parse_rss($feed_url,$data='',$type='notyoutube',$maxlength=8) {

$r='';

//jquery way less intensive cpu	    
//return '<li class=\'index_board_recentactivity_widget\'><script type="text/javascript">parseRSS("'.$feed_url.'");</script></li>';


$content = $feed_url!=null?file_get_contents($feed_url):$data;
$length=0;    


$sxe = simplexml_load_string($content);
if ($sxe === false) {
	touch($feed_url);
   return "Failed loading XML ".$feed_url."\n";
    foreach(libxml_get_errors() as $error) {
        echo "\t", $error->message;
    }
   // return;
}
    $x = new SimpleXmlElement($content);
if($x===false || !$x)
{
return "bad ".$feed_url."\n ";	
}


if ($type=='notyoutube'){
//standard rss type

    foreach($x->channel->item as $entry) {
	
    if($length<$maxlength) {
        $entry->pubDate=substr($entry->pubDate,0,strlen($entry->pubDate)-6);

     $r.="<li style='list-style: none;'><a href='$entry->link' target='_blank' title='$entry->title'>" . $entry->title . "  -".$entry->pubDate."</a></li>";
    }else continue;
    
    ++$length;
    }
    }else if ($type=='activityrss'){

foreach($x->channel->item as $entry) {
	
	$dc=$entry->children('http://purl.org/dc/elements/1.1/');
	

    if ($length<$maxlength) $r.= "<li style='list-style: none;'><span><a href='".$entry->link."#".$entry->pubDate."' title='$entry->title'>" . $entry->description . " &rarr;".$dc->creator." <script>document.write(ago(".$entry->pubDate."));</script></a></span></li>";
     else continue;
     
    ++$length;
    }
    
}else{
//YOUTUBE 
    foreach($x->entry as $entry) {
	
	$id=explode("=",$entry->link['href']);$id=$id[1];

$snapshot=$this->settings['recentactivity_log']['showyoutubesnapshot']==1?'<img src="https://i2.ytimg.com/vi/'.$id.'/hqdefault.jpg" style="vertical-align:text-top; height:58px;">':'';


		
    if ($length<$maxlength){
    $entry->published=substr($entry->published,0,strlen($entry->published)-6);

     $r.= '<li><a href="'.$entry->link['href'].'" target="_blank" title="'.$entry->title.'">'.$snapshot.' ' . $entry->title . '  &bull;'.$entry->published.'</a></li>';
    } else continue;
     
    ++$length;
    }
    
	
}


return $r;

	
}

//make text safe, convert symbols when placing in database, omit array to not use the bbcode #
public function parse_generaltext($subject,$omit=null){
if ($subject==null){return null;}

$bbcode=array (

//rem script ,xss
array("/<script\b[^>]*>(.*?)<\/script>/i","script"),
array("/on(.*?)\{4,10}(=)/i","$1-"),
//commenting
array("/\[#\](.*?)\[\/#\]/i","<a class='$1reply' href=\"#$1\">>>$1 </a>"),

array("/\[url\](.*?)\[\/url\]/i","<a href=\"$1\" target=\"_blank\">$1 </a>"),

array("/\[url\=(.*?)\](.*?)\[\/url\]/i","<a href=\"$1\" target=\"_blank\">$2 </a>"),

array("/\[youtube\](.*?)\[\/youtube\]/i","<div class=\"video-container\" data-video=\"$1\"><a href=\"https://www.youtube.com/watch?v=$1\" target=\"_blank\" class=\"file\"><img src=\"//img.youtube.com/vi/$1/0.jpg\" class=\"post-image\"/></a></div>"),

//array("/\[youtube\](.*?)\[\/youtube\]/i","<iframe width=\"428\" height=\"328\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe><"),

array("/\[img\](.*?)\[\/img]/i","<img src='$1'>"),
//text tags

array("/\[i\](.*?)\[\/i\]/i","<i>$1</i>"),

array("/\[p\](.*?)\[\/p\]/i","<p>$1</p>"),

array("/\[b\](.*?)\[\/b\]/i","<b>$1</b>"),

array("/\[code\](.*?)\[\/code\]/i","<pre class='code'>$1</pre>"),

array("/\[color\=(.*?)\](.*?)\[\/color\]/i","<font style='color:$1;'>$2</font>"),


//hidden text tag
array("/\[hidden\](.*?)\[\/hidden\]/i","<span id='hidden'>$1</span>"),

array("/\[quote\](.*?)\[\/quote\]/i","<blockquote>$1</blockquote>"),

array("/\[h2\](.*?)\[\/h2\]/i","<h2>$1</h2>"),
array("/\[h3\](.*?)\[\/h3\]/i","<h3>$1</h3>"),
array("/\[h4\](.*?)\[\/h4\]/i","<h4>$1</h4>"),
//![^\'\"]


///flawed in that the trailing / doesnt convert to link. ?!\\/
array('/(?!<\S)(\w+:\/\/[^<>\s]+\w)(\/?)(?!\S)/i', '<a href="$1" target="_blank">$1</a>'),


);

//" '&#34;',
// '&#39;',

//clean
$subject=strip_tags($subject, '');

//begin proc
	for($z=0;$z<sizeof($bbcode);$z++){
	preg_match_all($bbcode[$z][0], $subject, $matches, PREG_SET_ORDER);
	

			foreach($matches as $i =>$match) {
				
			$subject = preg_replace($bbcode[$z][0], $bbcode[$z][1], $subject);
			}
			
	}
//trim end junk, then nl to br	
$subject = str_replace(array("\r\n", "\r", "\n"), "<br />", rtrim($subject)); 

return ($subject);
}
public function template_displaytopic_form($security){
	$_SESSION['name_id']=rand(0,100000);
		$_SESSION['subject_id']=rand(0,100000);
		$_SESSION['comment_id']=rand(0,100000);
		$_SESSION['file_id']=rand(0,100000);
		
		$this->name='name'.$_SESSION['name_id'];
		$this->subject='subject'.$_SESSION['subject_id'];
		$this->comment='comment'.$_SESSION['comment_id'];
		$this->file='file'.$_SESSION['file_id'];
		$this->newtopic=!isset($this->newtopic)?'':$this->newtopic;
 



$tok=sha1(uniqid());
$security->generate_token($tok,time());
			echo "<div class='postformcontainer'><div class='postform'><form accept-charset='utf-8' enctype='multipart/form-data' method='post' action='index.php?p=".$this->get_page_id()."&s=".$this->get_section_id()."&t=".$this->get_topic_id()."'>".$this->newtopic."<input title='Username' value='' name='".$this->name."' placeholder='Username' id='name' onkeypress='savecomm(event,\"savename\")' type='text' maxlength='".$this->settings['maxuser_length']."'><br /><input  title='Subject' value='' name='".$this->subject."' placeholder='Subject' id='subject' type='text' maxlength='".$this->settings['maxsubject_length']."' /><input type='submit' value='Post' id='submit'><br /><textarea  id='comment' name='".$this->comment."' placeholder='Comment' title='Comment' maxlength='".$this->board_settings[$this->get_section_id()]['maxtopic_length']."' onpaste='savecomm(event,\"118\")' onkeypress='savecomm(event,\"save\")'></textarea><br /><input  id='file' type='file' name='".$this->file."' /><br /><input title='Password' type='password' placeholder='Pass' id='password' name='password'><br />".$security->generate_captcha('','','')." <br /><input id='captcha' title='Captcha' placeholder='Captcha' type='input' name='captcha' value='".$_SESSION['captcha_val']."'><br /><input type='text' value='".$tok."' name='pot' id='pot' style='display:none;'><input type='hidden' value='".$_SESSION['time']."' name='time'></form>".sprintf( $this->language_data[$this->language]['post_helpdescription'] ,$this->settings['maxfilesize']) ."</div></div>";
		}
		
		
		public function template_display_form($security){
	$_SESSION['name_id']=rand(0,100000);
		$_SESSION['subject_id']=rand(0,100000);
		$_SESSION['comment_id']=rand(0,100000);
		$_SESSION['file_id']=rand(0,100000);

		$this->name='name'.$_SESSION['name_id'];
		$this->subject='subject'.$_SESSION['subject_id'];
		$this->comment='comment'.$_SESSION['comment_id'];
		$this->file='file'.$_SESSION['file_id'];
		$this->newtopic=!isset($this->newtopic)?'':$this->newtopic;
 
$_COOKIE['username']=!isset($_COOKIE['username'])?'':$_COOKIE['username'];


$tok=sha1(uniqid());
$security->generate_token($tok,time());

			echo "<div class='postformcontainer'><div class='postform'><form accept-charset='utf-8' enctype='multipart/form-data' method='post' action='index.php?p=".$this->get_page_id()."&s=".$this->get_section_id()."&t=".$this->get_topic_id()."'>".$this->newtopic."<input title='Username' value='' name='".$this->name."' placeholder='Username' id='name' onpaste='savecomm(event,\"118\")' onkeypress='savecomm(event,\"savename\");' style='width:410px;' type='text' maxlength='".$this->settings['maxuser_length']."'><input type='submit' value='Post' id='submit'><br /><textarea  id='comment' name='".$this->comment."' placeholder='Comment' title='Comment' maxlength='".$this->board_settings[$this->get_section_id()]['maxpost_length']."' onpaste='savecomm(event,\"118\")' onkeypress='savecomm(event,\"save\")'></textarea><br /><input  id='file' type='file' name='".$this->file."' /><br /><input title='Password' type='password' placeholder='Pass' id='password' name='password'><br />".$security->generate_captcha('','','')." <br /><input id='captcha' value='".$_SESSION['captcha_val']."' title='Captcha' placeholder='Captcha' type='input' name='captcha'><br /><input type='text' value='".$tok."' name='pot' id='pot' style='display:none;'><input type='hidden' value='".$_SESSION['time']."' name='time'></form>".sprintf( $this->language_data[$this->language]['post_helpdescription'] ,$this->settings['maxfilesize']) ."</div></div>";
		}
		

function quickconvert($text, $key = '') {
	// Author: halojoy, July 2006
// Modified and commented by: laserlight
    if ($key == '') {
        return $text;
    }
    $key = str_replace(' ', '', $key);
    if (strlen($key) < 8) {
       return 'kerror';
    }
    $key_len = strlen($key);
    if ($key_len > 32) {
        $key_len = 32;
    }
    $key = substr($key, 0, $key_len);
    $text_len = strlen($text);
    $lomask = str_repeat("\x1f", $text_len); // Probably better than str_pad
    $himask = str_repeat("\xe0", $text_len);
    $k = str_pad("", $text_len, $key); // this one _does_ need to be str_pad
    $text = (($text ^ $k) & $lomask) | ($text & $himask);
    return $text;
}





public function upload_file($time) {
if ($this->board_settings[$this->get_section_id()]['allowfileupload'] !=1) {
	return true;
}

$allowedExts = array("bz2","tar","zip","txt","odt","doc","rtf","pdf","gif", "jpeg", "jpg", "png","webm");

 
if( !isset($_FILES['file'.$_SESSION['file_id']]) 
|| $_FILES['file'.$_SESSION['file_id']]["size"]==0 )
{
	//empty, this is why when one uploads it does not shows file

	return true;
}




if (($_FILES['file'.$_SESSION['file_id']]["size"] > $this->settings['maxfilesize']) ) { echo 'file is too large.<br>'; return false;}
if (isset($_SESSION['uploads']) && $_SESSION['uploads'] >= $this->settings['maxuploadpersession']) {echo '<div class="warning">max uploads reached</div>'; return false;}


$temp = explode(".", $_FILES['file'.$_SESSION['file_id']]["name"]);
$extension = end($temp);
if (
in_array($extension, $allowedExts))
{
 list($width, $height) = getimagesize($_FILES['file'.$_SESSION['file_id']]["tmp_name"]); 
 
 
 $_SESSION['imgdat']=$width.'|'.$height;
 if ($width > 4000 || $height > 4000 ) { echo 'image dimensions are too large.<br>'; return false; }


//'_'.  $_FILES['file'.$_SESSION['file_id']]['name']
		if (file_exists($this->upload_directory .$time . '.'.$extension ) ) {
			
			echo 'file already exists - change the name.<br>'; return false;
		}else{
			
		if(!move_uploaded_file( $_FILES['file'.$_SESSION['file_id']]['tmp_name'],$this->upload_directory .$time . '.' . $extension ) ){
				 echo ' unable to move file, trying rawfile passthrough. <br>';
				 
				 
$p=$this->readwritefile($this->upload_directory .$time . '.' . $extension,'w',file_get_contents($_FILES['file'.$_SESSION['file_id']]['tmp_name']));				 
				 
				 
				 
				 if (!$p) {
				unlink($_FILES['file'.$_SESSION['file_id']]['tmp_name']);
					 echo '   failiure upload passthrough<br>';
					 return false;
				 }
				 
				 }else{
			  $_SESSION['uploads']+=1;
			  return true;
			
				}
			}


}else{
	echo 'file type not allowed.';return false;
		}




}
public function upload_file_display($time) {

if ($this->board_settings[$this->get_section_id()]['allowfileupload'] !=1) {
	return null;
}

if ( !isset($_FILES['file'.$_SESSION['file_id']]) || $_FILES['file'.$_SESSION['file_id']]["size"]==0)  {
	return false;
}



$temp = explode(".", $_FILES['file'.$_SESSION['file_id']]["name"]);
$extension = end($temp);
if ($extension=='gif' 
|| $extension=='jpeg'
|| $extension=='jpg'
|| $extension=='png'
|| $extension=='bmp'

)
{
	$dat=explode('|', $_SESSION['imgdat']);
	$width=$dat[0];
	$height=$dat[1];
return '<br /><a href="'.$this->hostbase.$this->upload_directory  .$time.'.'.$extension.'" target="_blank"><img src="'.$this->upload_directory  .$time.'.'.$extension.'" alt="'.$_FILES['file'.$_SESSION['file_id']]["name"].'" title="'.$_FILES['file'.$_SESSION['file_id']]["name"].' '.round(($_FILES['file'.$_SESSION['file_id']]["size"]/1024)/1024,3).'mb '.$width.'*'.$height.'"></a>';

}else if($extension=='webm') {
	
	return ''.round(($_FILES['file'.$_SESSION['file_id']]["size"]/1024)/1024,3).'mb <video controls loop>
  <source src="'.$this->hostbase.$this->upload_directory  .$time.'.'.$extension.'" type="video/webm">
  Your browser does not support the html5 video tag.
</video>';

	}else {

		return '<br /><a href="'.$this->hostbase.$this->upload_directory .$time.'.'.$extension.'" target="_blank">>> '. $_FILES['file'.$_SESSION['file_id']]["name"].'</a>';

			
			
		}




}

public function view_page($file,$title) {


if (!file_exists($this->section_directory.''.$this->get_section_id().'/'.$this->get_topic_id().$this->settings['fileextension'])) {
echo '<div class="warning">Error couldnt find this topic.</div>';
return;
//touch($this->section_directory.'/'.$this->get_section_id().'/'.$this->get_topic_id().'.php');
}


			$p=$this->readwritefile($this->section_directory.''.$this->get_section_id().'/'.$this->get_topic_id().$this->settings['fileextension'],'r','');
			
		
if (!$p||$p==null){
echo '<div class="warning">Error no posts in this topic or it is corrupted!</div>';
return false;
}
echo $p;
$this->archive__topic($this->get_section_id(),$this->get_topic_id());
return true;

}

public function view_topics($section,$file) {

//show latest topics in a section

if (!file_exists($this->section_directory.'/'.$section.'')){
return "echo '<div class='warning'>{$section} directory doesnt exist, please create the section directory and add parameters to board_settings array!</div>';";
}

//include($this->section_directory.'/'.$section.'/_forum_topics.php');

$topics=$this->dirtoarray($this->section_directory.''.$section.'/',false);

if (!is_array($topics)||!$topics){

echo '<div class="warning">There are no board topics in this section!</div>';
}


$topics=array_reverse($topics);

$x=0;
	foreach ($topics as $k => $v) {

	$p='';

	//$time[$i]=);
	//put date time in file name
	//is folder
		$len=strlen($topics[$k]);
        //remove tag this is added later in post scripts
	$topic=substr($topics[$k],0,$len-4);	
//remove timestamp on file for temp display
$topicdisp=substr($topics[$k],8,$len-12);
	//strip tag carry subtracted amount
	echo '<div class="viewboards_post"><a style="font-size:140%;" href="'.$this->settings['mainfile'].'?p=viewpage&s='.$section.'&t='.$topic.'">'.($topicdisp).'</a>&nbsp;&nbsp;<span class="viewboards_lastactivity">&nbsp;&nbsp; Last activity &nbsp;&nbsp;<script type="text/javascript">document.write(ago('.filemtime($this->section_directory.'/'.$section.'/'.$topics[$k]).'));</script></span>'.$p.'</div>';
	if ($this->settings['iframeshowtopicpreview']!=NULL) { 

if($x<$this->settings['iframeshowtopicpreview']) {
		echo '<iframe src="'.$this->settings['mainfile'].'?p=viewpage&s='.$section.'&t='.$topic.'&&qaz=iframepreview"" width="100%" height="350px"></iframe>';
}
}

++$x;
	}


 $this->archive__topics($section,sizeof($topics));

}


public function archive__topic($section,$topic) {
//archives old posts into a seperate archive archive_(date archived) when topic limit is reached

//BASICALLY INDIVIDUALLY ARCHIVES A TOPIC when user goes to the page, maxfileage_until_archive=0 then
//this isnt triggered, THIS DOESNT DELETE UPLOADS only topic

$archivefolder='archive';
$archivesubfolder='archive'.date($this->settings['archivestamp']);
		if (time()-filemtime($this->section_directory.''.$section.'/'.$topic.$this->settings['fileextension']) > $this->board_settings[$section]['maxfileage_until_archive'] && $this->board_settings[$section]['maxfileage_until_archive']!=0) {

				
if (!is_dir($this->section_directory.''.$section.'/'.$archivefolder.'')) {
	mkdir($this->section_directory.''.$section.'/'.$archivefolder.'',0755);
}
		if (file_exists($this->section_directory.''.$section.'/'.$topic.$this->settings['fileextension'])) {
				mkdir($this->section_directory.''.$section.'/'.$archivefolder.'/'.$archivesubfolder,0755);	 
$this->copyemz($this->section_directory.''.$section.'/'.$topic.$this->settings['fileextension'],$this->section_directory.''.$section.'/'.$archivefolder.'/'.$archivesubfolder.'/'.$topic.$this->settings['fileextension']);
	chmod($this->section_directory.''.$section.'/'.$archivefolder.'/'.$archivesubfolder.'/'.$topic.$this->settings['fileextension'],0755);						
							
						}
		}

}

public function archive__topics($section,$totalpost) {
//archives old posts into a seperate archive archive_(date archived) when topic limit is reached


//ARCHIVE FOR TOTAL NUMBER OF S

if($totalpost<$this->board_settings[$section]['maxtopics_until_archive'] || $this->board_settings[$section]['maxtopics_until_archive']==0) {
return false;
}

if (!file_exists($this->section_directory.''.$section.'')){
echo "<div class='warning'>{$section} directory doesnt exist, please create the section directory and add parameters to board_settings array!</div>';";
return false;
}

//include($this->section_directory.'/'.$section.'/_forum_topics.php');

//toggle sweep of old uploads based on mtime and global setting
$uploads=$this->dirtoarray($this->upload_directory);
for ($i=0;$i<sizeof($uploads);$i++) {
    $ut=explode('.',$uploads[$i]);
    
if (time()-$ut[0]> $this->settings['uploaddecay'] && file_exists($this->upload_directory.$uploads[$i]) ) {
    
    unlink($this->upload_directory.$uploads[$i]);
    }


}

$topics=$this->dirtoarray($this->section_directory.''.$section.'/');

$archivefolder='archive';
$archivesubfolder='archive'.date($this->settings['archivestamp']);

if (!is_dir($this->section_directory.''.$section.'/'.$archivefolder.'')) {
	mkdir($this->section_directory.''.$section.'/'.$archivefolder.'',0755);
}


for ($i=0;$i<sizeof($topics);$i++) {

	if (file_exists($this->section_directory.''.$section.'/'.$topics[$i].$this->settings['fileextension'])) {
				mkdir($this->section_directory.''.$section.'/'.$archivefolder.'/'.$archivesubfolder,0755);
$this->copyemz($this->section_directory.''.$section.'/'.$topics[$i].$this->settings['fileextension'],$this->section_directory.'/'.$section.'/'.$archivefolder.'/'.$archivesubfolder.'/'.$topics[$i].$this->settings['fileextension']);
	chmod($this->section_directory.''.$section.'/'.$archivefolder.'/'.$archivesubfolder.'/'.$topics[$i].$this->settings['fileextension'],0755);
    }


}




}
public function get_usersonline() {
	if ($this->settings['usersonline'][0]==1) {

	echo '<div class="index_board_recentactivity_widget" id="lastuser" style="max-height:155px;">Users last seen: '.$this->readwritefile($this->onlineactivity_file,'r','').'</div>';



}
}

public function get_list_all_sections(){

$g=$this->dirtoarray($this->section_directory);
$recentactivity='';
		if ($this->settings['recentactivity_log']['logall']==1){
			// $this->settings['xmlstart']



				$recentactivity='<div class="index_board_recentactivity_widget">'.$this->parse_rss($this->hostbase.$this->_recentactivity_file,'','activityrss',22).'</div>';
			/*			$_SESSION['dynamic_tags']='';
						$rr=explode('[',$recentactivity);
					
					$_SESSION['dynamic_tags']=$this->seofriendly(implode(', ',array_slice($rr,1,4)));
		*/
		}
	foreach($g as $k=>$v){

	

	if ( isset($this->board_settings[$k]) ) {

	echo "<div class='viewboards'><a href='index.php?p=viewboards&s=$k'>".$this->board_settings[$k]['icondisp']." ".$this->board_settings[$k]['title']." ".$this->board_settings[$k]['description']." </a></div>";
	}else{

	echo "<div><a href='index.php?p=viewboards&s=$k'>".$k." (install in classes.php 'board_settings' array)</div>";
	}



	}
			echo $recentactivity;

}

public function write_posts($dyntype=array()) {



/***************************

NEW  POSTING-

conditions; 
is user allowed to post 
requires a section

otherwise only sys admin or ftp acess manual  handwritten entries added to the  section will appear to users

***************************/



//$dyntype['posttype']=$this->get_section_id()<=0||$this->get_section_id()==null?$dyntype['sectionid']:$this->get_section_id();


if ($dyntype['posttype']=='newtopic'){


if (  isset($_POST) && isset($_POST['pot']) && isset($_POST['time']) ) {



if ( !$dyntype['security']->validate_token($_POST['pot'],$_POST['time']) || (time()-$_POST['time'])<=2.2 ) {
	echo '<code><pre>(???????)? timed out</pre></code>' ;
	return false;
}

if ($this->board_settings[$this->get_section_id()]['ftpmode']==1) {
		$_SESSION['badauth']+=1;
echo '<div><pre>¯\_(?)_/¯ </pre>ftp mode, posting topics not allowed ['.$_SESSION['badauth'].'/'.$this->settings['autoban_maxfailiures'].' attempts till ban]</div>';
	return false;
}

if (isset($_POST['password']) && $this->board_settings[$this->get_section_id()]['password']!=$_POST['password'] && $this->board_settings[$this->get_section_id()]['password']!=null) {
$_SESSION['badauth']+=2;
	echo '<div><pre>(????)????? |</pre> incorrect password to post topic ['.$_SESSION['badauth'].'/'.$this->settings['autoban_maxfailiures'].' attempts till ban]</div>';
	
	return false;
}

if (!$dyntype['security']->validate_captcha($dyntype['powerlevel'])) { echo '<div>failed captcha check</div>';
	return false; }


	$_SESSION['last_post']=!isset($_SESSION['last_post'])?0:$_SESSION['last_post'];
	
			$lastpostsec=round(time()-$_SESSION['last_post']) ;
			
	if (strlen($_POST['comment'.$_SESSION['comment_id']])<$this->board_settings[$this->get_section_id()]['mintopic_length'] || 
	( $lastpostsec<=$this->board_settings[$this->get_section_id()]['timebetween_topic']) * ($_SESSION['badauth']*1) ) {
	echo '<div class="warning"<pre>?_( ?_? )_?</pre>  wait '.($lastpostsec).'s, '.$this->board_settings[$this->get_section_id()]['timebetween_topic']* ($_SESSION['badauth']*1).'sec between posting topic</div><div class="warning">Or your comment is too short.</div>';
	return false;
	}

	$_SESSION['posts']=!isset($_SESSION['posts'])?0.1:$_SESSION['posts'];
	if ( $_SESSION['posts']/((time()-$_SESSION['time_in'])/300)>$this->settings['post_per_fivemin'] ) {
	$this->readwritefile($this->userlog_file,'a','   posts too fast top==><input value="'.$dyntype['security']->get_ip().'">');
$_SESSION['badauth']+=3;
	echo '<div><iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/2pOMCmVc3wY?autoplay=1" frameborder="0" allowfullscreen></iframe><pre>`?(-_-)??(-_-? )??(-_-)??(-_-)? </pre>you are posting too fast ['.$_SESSION['badauth'].'/'.$this->settings['autoban_maxfailiures'].' attempts till ban]</div>';

	return false;
	}
	
	if ( strlen($_POST['subject'.$_SESSION['subject_id']])<=$this->settings['minsubject_length'] ) {
		echo '<div>subject must be longer.</div>';
		return false;
	}
if ( substr_count($_POST['comment'.$_SESSION['comment_id']], '[img]' )>$this->settings['maximages_posttopic'] ) {
		$_SESSION['badauth']+=1;
		echo '<div>
	<iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/6EneCIPJsog?autoplay=1" frameborder="0" allowfullscreen></iframe>you have posted too many images for this topic</div>';
		return false;
	}



	$uploadtime=time();
				if ( $this->board_settings[$this->get_section_id()]['allowfileupload'] ==1 ) {

$uf=$this->upload_file($uploadtime);			
if ( !$uf ) {echo $uf; return false; }		
			
			}else{ echo '<div>uploading disabled</div>'; return false; }
	
	
$_POST['name'.$_SESSION['name_id']]=$_POST['name'.$_SESSION['name_id']]==null?$this->settings['defaultuser']:$_POST['name'.$_SESSION['name_id']];

$_POST['comment'.$_SESSION['comment_id']]=$dyntype['node']->parse_generaltext($this->truncate($_POST['comment'.$_SESSION['comment_id']],$this->board_settings[$this->get_section_id()]['maxtopic_length'],array('<img>')));
$_POST['subject'.$_SESSION['subject_id']]=substr($dyntype['node']->seofriendly($_POST['subject'.$_SESSION['subject_id']]),0,$this->settings['maxsubject_length']); 


			$_POST['name'.$_SESSION['name_id']]=$dyntype['node']->parse_generaltext($this->truncate($_POST['name'.$_SESSION['name_id']],$this->settings['maxuser_length'],array('<img>'))); 
	
		if ($dyntype['powerlevel']) {
			$_POST['name'.$_SESSION['name_id']]="<b title='SU'>".$_POST['name'.$_SESSION['name_id']]."</b>"; }


	$run=$this->readwritefile($this->section_directory.''.$dyntype['node']->get_section_id().'/'.date('Ymd').' '.$_POST['subject'.$_SESSION['subject_id']].$this->settings['fileextension'],'w',"
<div class='post0' id='".time()."'><div class='usernamecolor' onclick='reply(".time().");'><a href='#".time()."' name='".time()."'>#</a> ".date($this->settings['datestamp'])." &rarr; ".$_POST['name'.$_SESSION['name_id']]." <span id='uiid'>".$this->quickconvert($dyntype['security']->get_ip(),$this->ipsalt)."</span></div> 
<div class='clear'>".$_POST['comment'.$_SESSION['comment_id']]."".$this->upload_file_display($uploadtime)."</div></div>

");	
				
				if ($this->settings['recentactivity_log']['logall']==1 
				|| ($this->settings['recentactivity_log']['logstaffonly']==1 && $this->get_section_id()==$this->settings['main_'])) {
		
		
$remrss=explode('</feedburner:browserFriendly>',$this->readwritefile($this->_recentactivity_file.'','r',''));
		
					$decorate_siteupdate=$this->get_section_id()==$this->settings['main_']?'[STAFF] ':'';
					
			$this->settings['recentactivity_log']['previewstandard']=$decorate_siteupdate!=null?$this->settings['recentactivity_log']['previewstaff']:$this->settings['recentactivity_log']['previewstandard'];				
					
	$this->readwritefile($this->_recentactivity_file.'','w',$this->settings['rss_start']."


		<item>
		<title>".$decorate_siteupdate."".$dyntype['node']->get_section_id()."</title>
		<link>http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?p=viewpage&amp;s=".$dyntype['node']->get_section_id()."&amp;t=".date('Ymd')." ".$_POST['subject'.$_SESSION['subject_id']]."</link>
		<comments>http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?p=viewpage&amp;s=".$dyntype['node']->get_section_id()."&amp;t=".date('Ymd')." ".$_POST['subject'.$_SESSION['subject_id']]."#bottom</comments>
		<pubDate>".time()."</pubDate>
		<dc:creator><![CDATA[".$_POST['name'.$_SESSION['name_id']]."]]></dc:creator>
				<category><![CDATA[Editor's Choice]]></category>
		<category><![CDATA[Featured]]></category>
		<category><![CDATA[International]]></category>
		<category><![CDATA[Media and Propaganda]]></category>
		<category><![CDATA[News]]></category>
		<category><![CDATA[People]]></category>

		<guid isPermaLink=\"false\"> </guid>
		<description><![CDATA[".$decorate_siteupdate."New topic >> ".$this->html2rss($_POST['subject'.$_SESSION['subject_id']])." ]]></description>
				<content:encoded><![CDATA[
				
]]></content:encoded>
			<wfw:commentRss></wfw:commentRss>
		<slash:comments></slash:comments>
		</item>

	".$remrss[1]);
	
				
			}
			
			
				$_SESSION['last_post']=time();
				

	$_SESSION['posts']+=3;
echo '<a href="http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?p=viewpage&s='.$dyntype['node']->get_section_id().'&t='.date('Ymd').' '.$dyntype['node']->seofriendly(substr($_POST['subject'.$_SESSION['subject_id']],0,$this->settings['maxsubject_length'])).'">Posting topic . . . </a>';

header('refresh: 0; http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?p=viewpage&s='.$dyntype['node']->get_section_id().'&t='.date('Ymd').' '.$dyntype['node']->seofriendly(substr($_POST['subject'.$_SESSION['subject_id']],0,$this->settings['maxsubject_length'])).'#'.time().'');
	return true;

}




}


/***************************

COMMENT TO  POSTING

tags for  file
[locked] = post locked, 

***************************/
if ($dyntype['posttype']=='newpost'){

//
if (  isset($_POST) && isset($_POST['pot']) && isset($_POST['time'])   ) {

if ( !$dyntype['security']->validate_token($_POST['pot'],$_POST['time']) || (time()-$_POST['time'])<=2.3 ) {
	echo '<div><code><pre>(???????)? timed out</pre></code></div>';
	return false;
}


if ($this->board_settings[$this->get_section_id()]['allowcomment']!=1) {
	echo '<div><code><pre>?(`???????) </pre></code>commenting not allowed</div>';
 return false;
  }

if (!$dyntype['security']->validate_captcha($dyntype['powerlevel'])) { echo '<div>failed captcha check.</div>'; return false; }


	//lock posting after x days
	$dateposted=explode(' ',$this->get_topic_id());
$te=$this->time_elapsed(strtotime($dateposted[0]),'days');
	
	
	if ($this->board_settings[$this->get_section_id()]['posttimelock']!=0 && ($dateposted[0]>0) && $te > $this->board_settings[$this->get_section_id()]['posttimelock'] )  {
		
		echo '<div><code><pre>?(`???????) </pre></code> topic is old and has expired. '.$te.'/'.$this->board_settings[$this->get_section_id()]['posttimelock'].' days past. </div>';
		return false;
	}
	
	
		if ( stristr ( $this->get_topic_id(), '[locked]' ) !== false  ) {
			
			echo '<div><code><pre>?(`???????) </pre></code> this topic is locked.</div>';
			return false;
			
		}
		
		if (isset($_POST['password']) && $this->board_settings[$this->get_section_id()]['password2']!=$_POST['password'] && $this->board_settings[$this->get_section_id()]['password2']!=null) {
	$_SESSION['badauth']+=2;
		echo '<div><pre>(????)????? |</pre> incorrect password to post reply ['.$_SESSION['badauth'].'/'.$this->settings['autoban_maxfailiures'].' attempts till ban]</div>';
		
	return false;
}
		

	$_SESSION['last_post']=!isset($_SESSION['last_post'])?0:$_SESSION['last_post'];
		$lastpostsec=round(time()-$_SESSION['last_post']) ;

	if ( strlen($_POST['comment'.$_SESSION['comment_id']])< $this->board_settings[$this->get_section_id()]['minpost_length'] || ( $lastpostsec <= $this->board_settings[$this->get_section_id()]['timebetween_comment']) * ($_SESSION['badauth']*1) ) {
	echo '<div><pre>?_( ?_? )_? </pre>  wait '.($lastpostsec).' '.$this->board_settings[$this->get_section_id()]['timebetween_comment']* ($_SESSION['badauth']*1).'s between posting</div><div class="warning">Or your comment is too short.</div>';
	return false;
	}

	$_SESSION['posts']=!isset($_SESSION['posts'])?0.1:$_SESSION['posts'];
	if ( $_SESSION['posts']/((time()-$_SESSION['time_in'])/300)>$this->settings['post_per_fivemin'] ) {
		$this->readwritefile($this->userlog_file,'a','   posts too fast comm ==><input value="'.$dyntype['security']->get_ip().'">');
	$_SESSION['badauth']+=3;

	echo '<div><iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/2pOMCmVc3wY?autoplay=1" frameborder="0" allowfullscreen></iframe><code><pre>(????)????? |   </pre></code>you are posting too fast ['.$_SESSION['badauth'].'/'.$this->settings['autoban_maxfailiures'].' attempts till ban]</div>';
	return false;
	}
	

if ( substr_count($_POST['comment'.$_SESSION['comment_id']], '[img]' )>$this->settings['maximages_postreply'] ) {
		$_SESSION['badauth']+=1;
		echo '<div>
	<iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/6EneCIPJsog?autoplay=1" frameborder="0" allowfullscreen></iframe>you have posted too many images in your reply</div>';
		return false;
	}
	

			$uploadtime=time();
			if ( $this->board_settings[$this->get_section_id()]['allowfileupload'] ==1 ) {
				
				$uf=$this->upload_file($uploadtime);
if ( !$uf ) {  echo $uf; return false; }		
			
			
			}else{ echo '<div>uploading disabled</div>'; return false; }
					
	
	$_POST['name'.$_SESSION['name_id']]=$_POST['name'.$_SESSION['name_id']]==null?$this->settings['defaultuser']:$_POST['name'.$_SESSION['name_id']];
	
	$totalpost=filesize($this->section_directory.''.$this->get_section_id().'/'.$this->get_topic_id().$this->settings['fileextension']);
	
				if ($totalpost>=$this->board_settings[$this->get_section_id()]['maxfilesizetopic']) { 
					echo '<div>maximum '.$this->board_settings[$this->get_section_id()]['maxfilesizetopic'].' filesize has been reached for this topic section.</div>';
					return false; }
			
			
			
			$_POST['comment'.$_SESSION['comment_id']]=$dyntype['node']->parse_generaltext($this->truncate($_POST['comment'.$_SESSION['comment_id']],$this->board_settings[$this->get_section_id()]['maxpost_length']));
		
		
			$_POST['name'.$_SESSION['name_id']]=$dyntype['node']->parse_generaltext($this->truncate($_POST['name'.$_SESSION['name_id']],$this->settings['maxuser_length'],array('<img>'))); 
	
			if ($dyntype['powerlevel']) { $_POST['name'.$_SESSION['name_id']]="<b title='SU'>".$_POST['name'.$_SESSION['name_id']]."</b>"; }
		
$run=$this->readwritefile($this->section_directory.''.$this->get_section_id().'/'.$this->get_topic_id().$this->settings['fileextension'],'a',"
<div class='post' id='".time()."'><div class='usernamecolor' onclick='reply(".time().");'><a href='#".time()."' name='".time()."'>#</a> ".date($this->settings['datestamp'])." &rarr; ".$_POST['name'.$_SESSION['name_id']]." <span id='uiid'>".$this->quickconvert($dyntype['security']->get_ip(),$this->ipsalt)."</span></div> 
<div class='clear'>".$_POST['comment'.$_SESSION['comment_id']]."".$this->upload_file_display($uploadtime)."</div></div>

");
				
	if ($this->settings['recentactivity_log']['logall']==1 
				|| ($this->settings['recentactivity_log']['logstaffonly']==1 && $this->get_section_id()==$this->settings['main_'])) {
					

					$decorate_siteupdate=$this->get_section_id()==$this->settings['main_']?'[STAFF] ':'';
			$this->settings['recentactivity_log']['previewstandard']=$decorate_siteupdate!=null?$this->settings['recentactivity_log']['previewstaff']:$this->settings['recentactivity_log']['previewstandard'];					
						//clear recentactivity
						
						if ( filesize($this->_recentactivity_file)>$this->settings['recentactivity_log']['resetfile']){
							$this->readwritefile($this->_recentactivity_file,'w',$this->settings['rss_start'].'\r\n	
	</channel>
</rss>');
						}
			
		
		
			//user show recent commented
					
$remrss=explode('</feedburner:browserFriendly>',$this->readwritefile($this->_recentactivity_file.'','r',''));
	
					
	$this->readwritefile($this->_recentactivity_file.'','w',$this->settings['rss_start']."

		<item>
		<title>".$dyntype['node']->get_section_id()." -> ".$dyntype['node']->get_topic_id()."</title>
		<link>http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?p=viewpage&amp;s=".$dyntype['node']->get_section_id()."&amp;t=".$dyntype['node']->get_topic_id()."</link>
		<comments>http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?p=viewpage&amp;s=".$dyntype['node']->get_section_id()."&amp;t=".$dyntype['node']->get_topic_id()."</comments>
		<pubDate>".time()."</pubDate>
		<dc:creator><![CDATA[".$_POST['name'.$_SESSION['name_id']]."]]></dc:creator>
				<category><![CDATA[Editor's Choice]]></category>
		<category><![CDATA[Featured]]></category>
		<category><![CDATA[International]]></category>
		<category><![CDATA[Media and Propaganda]]></category>
		<category><![CDATA[News]]></category>
		<category><![CDATA[People]]></category>

		<guid isPermaLink=\"false\"> </guid>
		<description>".$decorate_siteupdate."<![CDATA[ ".$this->truncate($_POST['comment'.$_SESSION['comment_id']],$this->settings['recentactivity_log']['previewstandard'],array('<img>'))." ]]></description>
				<content:encoded><![CDATA[
				
]]></content:encoded>
			<wfw:commentRss></wfw:commentRss>
		<slash:comments></slash:comments>
		</item>

	".$remrss[1]);
	
	
			}
			

$_SESSION['last_post']=time();
	$_SESSION['posts']+=1;
	
	
//	die('test post; '.exec('whoami').' posts'.$_SESSION['posts'].' lastpost'.$_SESSION['last_post']);
echo '<a href="http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?p=viewpage&s='.$dyntype['node']->get_section_id().'&t='.$dyntype['node']->get_topic_id().'#'.time().'">Posting . . . </a>';
header('refresh: 0; http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?p=viewpage&s='.$dyntype['node']->get_section_id().'&t='.$dyntype['node']->get_topic_id().'#'.time().'');
	
return true;

}



}




}



   
	   public function smartphone_compatability() {
		   


		if(strpos($_SERVER['HTTP_USER_AGENT'],"iPhone")
		|| strpos($_SERVER['HTTP_USER_AGENT'],"Android")
		|| strpos($_SERVER['HTTP_USER_AGENT'],"webOS")
		|| strpos($_SERVER['HTTP_USER_AGENT'],"iPod")) {
		    return true;
		 }
return false;
	}

	

	
		
}


//members to read/write from the database returned as array, then processed-- just like the innate flat file system
class Mysql_Hook extends Constants{
private $mysql_root_password;
private $database_names=array('');
private $table_structure_paths=array('');


}

class UserTemplate extends Constants{

	public $username;
	private $userpassword;
   public $userpower;
    
    public $pageicon;
    public $metatag_description;
public $metatag_keywords;
    public $pagetitle;
       public $metatag_pagetitle;
    public function __construct(){
    parent::__construct();

//default page title
	$this->pagetitle='THE GYRE REALITY'; 
	$this->pageicon=$this->resource_directory.'gyre.gif';

//for sake of performance commenting out the metatags, not super necessary
/*
 $this->metatag_pagetitle='THE GYRE REALITY';
$this->metatag_description='Gyrereality, a discussion board dedicated to gaming, sharing, lifestyle advice and help to fellow annointed necromancers.';
$this->metatag_keywords='gyrereality, rts and fps gaming,freegan cheap living and comfort,clan end, dk3, covert1, ajizizoc, warcraft 3';
	*/
	
	
           if ($_SESSION['page_views']>=0){
    $_SESSION['page_views']+=1;
}

    }

    public function testuserinfo() {
       echo '<div style="font-size:16pt; color:#0b0;background-color:black;">';
       
//      echo  NodeFunctions::time_elapsed(time()-60*6966).' is time,';
      echo $this->user_skipbotcheck.' power level,'; 
echo $this->language.' language,';

echo $this->get_page_id().' this pageid,';
echo  $_SESSION['page_views'].' views,';
echo  $_SESSION['time_in'].' time in,';

echo '</div>';
       
       
    }


//find directory if out of bounds of stylesheet and js
public function directcssjs($x=0) {
	
	
	$a='<script type="text/javascript">
	
	
	</script>';
$a.='<style type="text/css">

/*******************************************/
/*

*/
/*******************************************/


body{
background:url() 50% 50% #000000;
	color:#dbdbdb;
font-family: Verdana, Monaco, monospace,Times New Roman,Times,serif; 

	font-size:100%;
	margin:0px;
	padding:0px;
}
	::selection {
	background: #ff00ff;color:#ffffff; /* Safari */
	}
::-moz-selection {
	background: #ff00ff;color:#ffffff; /* Firefox */
}



blockquote{
font-family:"Times New Roman",Georgia,Serif;
font-size:110%;
margin:30px 75px 30px 75px;
padding:5px;
text-indent:3em;
color:#ff00ff;
border:1px solid #676767;
text-indent:2em;
background-color:#000000;

}
#uiid{
margin:0px;
padding:0px;
display:none;
}
#hidden{

background-color:#000;
color:#000;

}
#hidden img{
clear:both;
width:2%;
}
#hidden:hover{
color:#aa0;
}
#hidden img:hover{
clear:both;
width:auto;

}


h1{
	text-transform:uppercase;
	font-family:impact, serif;
 -webkit-text-shadow: -1px 0 1px #000, 1px 0 1px #000, 0 -1px 1px #000, 0 1px 1px #000;
-moz-text-shadow: -1px 0 1px #000, 1px 0 1px #000, 0 -1px 1px #000, 0 1px 1px #000;
text-shadow: -1px 0 1px #000, 1px 0 1px #000, 0 -1px 1px #000, 0 1px 1px #000;
color:#00ffff;

}
h2{
	font-size:145%;
		font-family:impact, serif;
	text-shadow: 4px 1px 1px #000;

	color:#00eeee;
}
h3{
	font-weight:bold;
	font-family:serif;
	text-shadow: 4px 3px 3px #000;

		font-size:120%;
		color:#00bbbb;
}
h4{
	font-weight:bold;
	font-family:impact,serif;
	font-style:;
	font-size:125%;
	text-shadow: 4px 4px 2px #000;
		line-height:0px;
		color:#007777;
}

.transparent_class {
  /* IE 8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";

  /* IE 5-7 */
  filter: alpha(opacity=80);

  /* Netscape */
  -moz-opacity: 0.8;

  /* Safari 1.x */
  -khtml-opacity: 0.8;

  /* Good browsers */
  opacity: 0.8;
}
.highlightquote {
background-color:#002222;

}


a:link {
	color:#00ffff;
	text-decoration:none;
}
a:hover {
	color:#ff00ff;
		text-decoration:none;
}
a:visited{
	color:#ff00ff;
	text-decoration:none;
}

p{
	text-indent:3em;
	line-height:130%;
	
}

.subject{
text-indent:3em;
font-size:150%;
color:#33ee33;
text-shadow: 8px 2px 2px #000, 3px 3px 5px #660;
}

.fileupload{

background-color:#500;
margin:10px;
}

ul.square {
	list-style-type:square;
	}

ol.rules{
list-style-type:decimal;
}



.post {
border:1px solid #444444;
padding:6px;
margin:4px 0px 0px -7px;
text-align:left;

color:#ffffff;

vertical-align:top;
word-wrap: break-word;
box-shadow: 2px 2px 3px #444444;
max-width:100%;
overflow:auto;
float:left;
display:inline-block;
clear:both;
}


.post0 {
color:#ffffff;
box-shadow: 2px 2px 3px #444444;
border:1px solid #444;
padding:6px;
margin:0px 0px 0px -7px;
text-align:left;
word-wrap: break-word;
vertical-align:top;
max-width:100%;
overflow:auto;
float:left;
display:inline-block;
clear:both;
}

.post0 img, .post img{
max-width:300px;
vertical-align:text-top;
word-wrap:break-word;
}
.post0 img:hover, .post img:hover{

max-width:100%;

}

.viewboards {
width:43%;
float:left;
margin:8px 8px 8px 15px;
display:block;
}
.viewboards a:link{
text-decoration:none;
}

.viewboards a:hover,.viewboards a:visited{
text-decoration:none;
}

.viewboards_post {

box-shadow: 2px 2px 3px #444444;
border:1px solid #444;
padding:6px;
margin:0px 0px 8px -7px;
text-align:left;
word-wrap: break-word;
vertical-align:top;
max-width:100%;
overflow:auto;
float:left;
display:inline-block;
clear:both;
}

.viewboards_lastactivity {
 float:right;font-size:130%;text-shadow: 6px 5px 20px #ff00ff;color:#cdcdcd;letter-spacing:0px;font-family:impact;line-height:22pt;margin:-10px 1px 1px 15px;vertical-align:bottom;
}

.usernamecolor{
word-wrap:unset;

}
.usernamecolor b{
letter-spacing:4px;
}

.index_board_recentactivity_widget #newsfeed img,.usernamecolor img {
vertical-align:text-top;
max-height:99px;
}


.post .post_infobar,.post0 .post_infobar{
	float:top;
	vertical-align:top;


}
.postform{
min-width:550px;
	display:block;
	width:550px;
	padding:5px;
	margin:10px auto 25px auto;
}
.postform #name:hover,.postform #subject:hover,.postform #comment:hover,.postform #password:hover,.postform #captcha:hover{
color:#aaaddd;
}
.postform #name{
	width:470px;
font-size:12pt;
background-color:#101010;
border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
}
.postform #file{
font-size:12pt;
background-color:#090909;
border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
}
.postform #submit{
font-size:12pt;
background-color:#101010;
border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
}
.postform #submit:hover{
font-size:12pt;
background-color:#101020;
border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
}
.postform #subject{
	width:400px;
	font-size:12pt;
	background-color:#101010;
	border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
margin-right:10px;
}
.postform #comment{
	width:470px;
	height:125px;
	font-size:12pt;
	background-color:#101010;
		border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
}
.postform #password{
	width:50px;
	font-size:12pt;
	background-color:#101010;
		border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
}
.postform #captcha{
	width:150px;
	font-size:12pt;
	background-color:#101010;
	border:1px solid #333444;
margin:5px 0px 0px 0px;
color:#dddddd;
}

.wrap {
-moz-border-radius: 25px 10px / 10px 25px;
border-radius: 25px 10px / 10px 25px;
background-color:#1a1a1a;
text-align:left;
width:96%;
display:block;
padding:5px;
margin:0px auto 100px auto;
border:1px solid #333;
min-width:480px;
}


.footer{
	min-height:200px;
	text-align:center;
	background-color:#101010;
	border-top:1px solid #333;
}
.footer a:link{
}
.footer a:hover,.footer a:visited{
}
.footer ul li {
		list-style: none; 
		list-style-type:none;
		text-align:left;
		max-width:195px;
		width:155px;

		border-right:0px solid #000;
}
#posthelp{
display:none;

}

.footer ul{
	float:left;
	margin:0px;
		padding:5px 0px 0px 0px;
}


    a.goup {
        display:block;
        width:228px;
        height:49px;
        background:url(btn_sprite.gif) 0 0 no-repeat;
        text-indent:-999em;    
    }
        
    a.goup:hover {
        background:url(btn_sprite.gif) 0 -51px no-repeat;
    }
	
	.clear{
	clear:both;
}
.left {
float:left;
vertical-align:text-top;
padding:5px;
}
.right {
float:right;
vertical-align:text-top;
padding:5px;
}



.captcha{

color:#0066cc;
}

.staff_help{
margin:5px;
color:#fe0;
border:1px solid #334443;
}
.staff_terminal{
	color:#0c0;
	font-family:#verdana;
	font-size:150%;
	background-color:#000000;
	border:1px solid #334443;
}
.staff_terminal:hover{
	color:#0a0;
	font-family:#verdana;
	font-size:150%;
	background-color:#000000;
}

/*
#banner{
-moz-border-radius: 25px 10px / 10px 25px;
border-radius: 25px 10px / 10px 25px;
text-shadow: 4px 1px 1px #000;
background:url() 50% 40% # repeat;
	height: 0px; 
padding:0px;
margin:0px 0px 0px 0px;
clear:both;
text-align:center;
vertical-align:center;
font-size:200%;
font-family:impact;
color:#77ee77;

}
#banner img{
z-index:0;
}

*/
#header { 
padding:5px;
margin:0px 0px 15px 0px;

} 



#left_nav {
width:225px;
overflow:auto;

}


#nav {  


	/*font-family:"georgia", serif; 
	float:; 
*/
padding:0px;
	margin:0px 0px 0px 0px;
	
	
}
.content {  
min-height:255px;
word-wrap: break-word;
padding:5px;
margin:44px 0px 0px 0px;
}


#nav li { 
	list-style: none; 
	float: left; 
min-width:150px;
	height: 30px; 
	line-height: 30px; 
	text-align: center;
background-color:#1a1a1a;
z-index:5;
position:relative;
font-size:150%;

} 
#nav li a { 
	color: #00ffff; 
	text-decoration: none; 
	display: block; 
z-index:6;

} 
#nav li a:hover { 
	color:#ff00ff;
	background-color: #101010; 
}

/* fixed position good for bottom messaging texts*/

.index_feedstaffupdates{
float:left;
	margin:10px;
	padding:5px;

	clear:right;
	vertical-align:top;


}
.index_board_recentactivity_widget {
width:98%;
	background-color:black;
	float:right;padding:10px; overflow:auto;max-height:320px;
-moz-border-radius: 25px 10px / 10px 25px;
border-radius: 25px 10px / 10px 25px;

}
.index_board_recentactivity_widget span{
display:block;
text-shadow: 6px 5px 20px #ff00ff;
}
.index_board_recentactivity_widget span span{
display:inline;
}


.index_board_recentactivity_widget img{
vertical-align:text-top;
max-height:155px;
}
@media only screen and (max-width: 480px), only screen and (max-device-width: 480px) {
   /* CSS overrides for mobile here */

}


.video-container { display: block; border:3px solid black; margin: 15px auto; width: 360px; height:270px; }
.video-container img { display:block; max-width:360px;  }
.video-container img:hover { display:block;max-width:360px;  }






</style>';


$a.='';







return $a;
	
}

    
    public function run_dynamic_page($arg){
$security=new Security_and_SpamHandler;
$node=new NodeFunctions;


    switch($node->get_page_id()){



case 'viewpage':

$q=explode(' ',$node->get_topic_id(),2);
$q[1]=isset($q[1])?$q[1]:'gyre reality';
$this->pagetitle=($q[1]);
$this->pageicon=$this->board_settings[$node->get_section_id()]['icon'];
/*$this->metatag_pagetitle=substr($node->seofriendly($node->get_topic_id()),9);
$this->metatag_description=''.substr($this->metatag_pagetitle,0,400);
$this->metatag_keywords=implode(', ',explode(' ',$this->metatag_description));
*/
$this->template_start();
			

$node->write_posts(array('posttype'=>'newpost','sectionid'=>$node->get_section_id(),'security'=>$security,'arg'=>$arg,'node'=>$node,'powerlevel'=>$security->user_powerlevel()));
echo '<div style="font-size:120%;"><a href="index.php?p=viewboards&s='.$node->get_section_id().'"> &larr; &larr; </a> <span style="font-size:70%;">'.$node->get_section_id().' &bull; </span><h3 style="display:inline;">'.$this->pagetitle.'</h3></div><div class="clear"></div>';
$node->view_page('index.php',$this->pagetitle);
echo '

<div class="clear"></div>
<script type="text/javascript">postinit();</script>';

$node->template_display_form($security);



$this->template_end();

break;


case '':
//default:
/*


$this->template_start();
echo "<a href=\"index.php#top\"><pre style=\"text-align:default;margin:-30px 0px 10px 0px;\">

                                      _ _ _           
                                     | (_) |          
   __ _ _   _ _ __ ___ _ __ ___  __ _| |_| |_ _   _  
  / _` | | | | '__/ _ \ '__/ _ \/ _` | | | __| | | | 
 | (_| | |_| | | |  __/ | |  __/ (_| | | | |_| |_| | 
  \__, |\__, |_|  \___|_|  \___|\__,_|_|_|\__|\__, | 
   __/ | __/ |                                 __/ |                       
  |___/ |___/                                 |___/                        
</pre></a>";

echo '<div class="index_feedstaffupdates">';
$node->view_topics($this->settings['main_'],'index.php');
echo '</div><div class="clear"></div>';

$this->template_end();
break;
 */

case 'viewboards':






$this->pagetitle=$node->get_section_id()!=null?''.$this->board_settings[$node->get_section_id()]['title']:'Gyrereality Boards';
$this->pageicon=$node->get_section_id()!=null?$this->board_settings[$node->get_section_id()]['icon']:$this->pageicon;

/*
$this->metatag_pagetitle=$node->seofriendly($this->pagetitle);
$this->metatag_description.='';

$this->metatag_keywords.=', list of boards';//.$_SESSION['dynamic_tags'];
*/

$this->template_start();

//view the topics in section
if ($node->get_section_id()!=null) {

echo '<div id="viewboards"><h3>'.$this->board_settings[$node->get_section_id()]['icondisp'].' '.$this->pagetitle.'</h3>';
echo '<a target="_blank" href="'.$this->section_directory.''.$node->get_section_id().'/archive">#archive#</a></div>';	

$node->write_posts(array('posttype'=>'newtopic','sectionid'=>$node->get_section_id(),'security'=>$security,'arg'=>$arg,'node'=>$node,'powerlevel'=>$security->user_powerlevel()));
$node->template_displaytopic_form($security);
echo '<div class="clear"></div>';
$node->view_topics($node->get_section_id(),'index.php');

}else{
//or list  sections


$node->get_list_all_sections();
$node->get_usersonline();

echo "
<div class='clear'></div><div id='newsfeed'>
<ul style='list-style-type: none;'>

<div class='clear'></div><h3>My recent youtube vids</h3>
".$node->parse_rss('https://www.youtube.com/feeds/videos.xml?channel_id=[your youtube channel id to pull rss]','','youtube')."

<div class='clear'></div><h3>Current News</h3>
".$node->parse_rss('https://www.youtube.com/feeds/videos.xml?channel_id=UCFjOi1ZpZVErr8EYxg8t1dQ','','youtube')."

".$node->parse_rss('https://www.cnn.com/services/rss/')."


</ul></div>
";


}

echo '<div class="clear"></div>';


$this->template_end();

break;


    case 'staff':
$admin=new AdministrativeTools;
$this->pagetitle='Staff Administration';

/*$this->metatag_pagetitle=$node->seofriendly($this->pagetitle);
$this->metatag_description='staff administration ';
$this->metatag_keywords.=', catagory staff admin';
*/

$this->template_start();



$admin->panelprocessquery($security);

$this->template_end();
break;

        case 'hfaq':
	
$this->pagetitle='Rules/Faq';
/*$this->metatag_pagetitle=$node->seofriendly($this->pagetitle);
$this->metatag_description='Rules and information about gyrereality ';

$this->metatag_keywords.=', helpfaq and rules';
*/

$this->template_start();

    echo '

<h2>Rules</h2>
    <ol>
<li>No Spam. This is includes low quality and off topic trash posts.</li>
<li>No personal attacks on other users. Be kind and respectful of others or you will be banned.</li>
<li>No dupe image/file posts.</li>
<li>You will be warned twice if we\'re nice. All offending users will be banned permanently.</li>
</ol>
<br />

<h2>Info/FAQ</h2>
    <ul>
    <li>I want to report a user post? Contact admin with the url, click the # on the post and copy paste the url to admin. Or click the # of the offending post, scroll to the bottom of the page and click the selected input --CMD-- and then type r and enter key. This will bring up a mailto to admin where you can include additional info about the offense with a prefilled url of the post with your email. You can also report it in an anonymous way by going to the updates section and report user thread with the url.</li>
    <li>This site is a simple discussion and file sharing community for anything, mainly gaming and hobbies.</li>
    <li>Timezone used by this forum is "GMT" standard.</li>
</ul>
<h2>Contact admin</h2>

	<ul>
	<li>Post your comments in the gyrereality homepage or updates section if you want something fixed. </li>
	</ul>
	<br />
';
    
$this->template_end();
break;

        case '403':
	
$this->pagetitle='403';
 
$this->template_start();

    echo $this->directcssjs(4).'
    
<h1>403 forbidden</h1>
  
<div style="clear:both"></div>
';
    
$this->template_end();
break;

        case '404':
	
$this->pagetitle='404';

$this->template_start();

    echo $this->directcssjs().'
<h1>404 page not found</h1>
<script>
function random_imglink(){
  var myimages=new Array()
  myimages[1]="<img src=\"http://oi44.tinypic.com/s6t2ll.jpg\" width=\"\" class=\"clear left\">"
  myimages[2]="<iframe src=\"https://www.youtube.com/embed/FWO5Ai_a80M?autoplay=1\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>"
  myimages[3]="<iframe src=\"https://www.youtube.com/embed/6EneCIPJsog?autoplay=1\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>"
  myimages[4]="<iframe src=\"https://www.youtube.com/embed/LleeMp9aJH8?autoplay=1\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>"

  myimages[5]="<iframe src=\"https://www.youtube.com/embed/aDfZ6STAfqA?autoplay=1\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>"




  var ry=Math.floor(Math.random()*(myimages.length -1)+1 );

     document.write(myimages[ry]+"<span style=\"font-size:6pt\"><"+ry+"></span>");
}

  random_imglink();
  
  </script>
  
  
<div style="clear:both"></div>

';
    
$this->template_end();
break;

        case '500':
	
$this->pagetitle='500';
 
$this->template_start();

    echo $this->directcssjs().'
<h1>500 internal error</h1>

  
<div style="clear:both"></div>
';
    
$this->template_end();
break;



    }
    
    }


    
    
	public function template_start(){
		//<meta name="title" content="'.$this->metatag_pagetitle.'"><meta name="description" content="'.$this->metatag_description.'"><meta name="keywords" content="'.$this->metatag_keywords.'">
		
echo '<html><head><meta charset="utf-8"><title>'.$this->pagetitle.'</title><meta http-equiv="expires" content="0"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"><meta name="robots" content="index, fol" /><script type="application/javascript" src="'.$this->resource_directory.'jquery.min.js"></script><script type="application/javascript" src="'.$this->resource_directory.'main.js"></script><link rel="stylesheet" href="'.$this->resource_directory.'classic.css" id="stylesheet" type="text/css" media="screen, projection" /><link rel="shortcut icon" type="image/png" href="'.$this->pageicon.'" /><link rel="apple-touch-icon-precomposed" href="'.$this->pageicon.'" /></head>
<body><div class="wrap"><a name="top"></a>
<div id="banner"></div><div id="header">
<ul id="nav"><li class="navlink" style="margin:0px 0px 0px 0px"><a href="#bottom" style="width:100px;">&darr;&nbsp;&nbsp;&darr;</a> </li>
<li class="navlink"><a href="'.$this->hostbase.$this->runfile.'?p=viewboards" style="margin:0px 0px 0px -40px">View all Boards</a></li> <li class="navlink"><a href="#" onclick="togglemenu();" onmouseover="togglemenu();">Menu</a></li> <li class="navlink"><a href="https://www.youtube.com/channel/UCK70x7-hUp4mQ7NcAsCfyAw" target="_blank" style="margin:0px 0px 0px 0px">My Youtube <img style="height:35px; vertical-align:text-top;" src="https://yt3.ggpht.com/yti/APfAmoEVut7rH4N_Di-BTokgGZWZx5tqVJ2nC9Fviw64=s88-c-k-c0x00ffffff-no-rj-mo"></a></li>
</ul>
</div>
<div class="content"><div id="togglemenu"></div>';
$this->top_ads();

	}
	
		public function template_end(){
		//	$_COOKIE['username']=$_COOKIE['username']!=null?$_COOKIE['username']:$this->settings['defaultuser'];
			
echo '</div></div>';
		$this->bottom_ads();
	echo '<div class="footer"><ul style="width:240px; padding:0px 0px 0px 
	20px;"><li style="font-size:150%;"><a href="#top">&uarr;&nbsp;&nbsp;&uarr;</a><a 
	name="bottom"></a></li><li><a href="'.$this->hostbase.'" style="">Home</a></li><li style="width:250px;">'.date($this->settings['datestamp']).' GMT</li><li><a href="'.$this->hostbase.'index.php?p=staff">Staff and Login</a></li><li><a href="'.$this->hostbase.'index.php?p=hfaq">Rules and FAQ</a></li><li><a href="'.$this->hostbase.$this->_recentactivity_file.'" target="_blank">RSS feed</a></li><li 
	style="width:250px;">'.$this->version.'</li><li>Loaded in '.round(microtime(true)-$this->time_start,3).'s</li></ul><ul style="overflow:auto;width:160px;"><li><a target="_blank" href="http://www.s15.invisionfree.com/dk3">The old dk3 forums</a></li></ul><ul style="overflow:auto;width:190px;"></ul>

	<ul style="float:right;padding:5px;margin:0px 0px 0px -10px"><li>
<select title="Change color theme" onChange="changeoption();" id="changeoption">
  <option value="" default>--</option>
  <option value="classic">Classic</option>
  <option value="earth">Earth</option>
  <option value="yage">Yage</option>
    <option value="gray">Gray</option>
  <option value="nostyle">No style</option>
  <option value="9000">--CMD--</option> 
</select> 
</li></ul><div class="clear"></div>Dicipline, Valor, Equanimity</div><a href="'.$this->hostbase.'index.php?qaz=harvestmoon"></a></body></html>';

	}
	
        public function top_ads()
    {
    		//put whatever ad generation here google api etc

    //echo "<div style='text-align:center; vertical-align:middle;'>example top ads</div>";
    
    }

    public function bottom_ads()
    {
		
		//put whatever ad generation here google api etc

// echo " <div style='text-align:center; vertical-align:middle;'>example bottom ads</div>";
   
    }
}
$template=new UserTemplate;



?>
