<?php
// Database settings  - Keep these in the flat file --------------
                                                                 //
define("C_DB_TYPE", 'mysql');                                    //
define("C_DB_HOST", 'localhost');                                //
define("C_DB_NAME", 'chat');                                     //
define("C_DB_USER", 'root');                                     //
define("C_DB_PASS", '');                                         //
define("C_MSG_TBL", 'c_messages');                               //
define("C_USR_TBL", 'c_users');                                  //
define("C_REG_TBL", 'c_reg_users');                              //
define("C_BAN_TBL", 'c_ban_users');                              //
                                                                 //
//----------------------------------------------------------------

$conn = mysql_connect(C_DB_HOST, C_DB_USER, C_DB_PASS) or die ('<center>Error: Could Not Connect To Database');
mysql_select_db(C_DB_NAME);

$query = "SELECT * FROM c_config";
$result = mysql_query($query);
$row = mysql_fetch_row($result);

$MSG_DEL          = $row[1];
$USR_DEL          = $row[2];
$REG_DEL          = $row[3];
$LANGUAGE         = $row[4];
$MULTI_LANG       = $row[5];
$REQUIRE_REGISTER = $row[6];
$EMAIL_PASWD      = $row[7];
$SHOW_ADMIN       = $row[8];
$SHOW_DEL_PROF    = $row[9];
$VERSION          = $row[10];
$BANISH           = $row[11];
$NO_SWEAR         = $row[12];
$SAVE             = $row[13];
$USE_SMILIES      = $row[14];
$HTML_TAGS_KEEP   = $row[15];
$HTML_TAGS_SHOW   = $row[16];
$TMZ_OFFSET       = $row[17];
$MSG_ORDER        = $row[18];
$MSG_NB           = $row[19];
$MSG_REFRESH      = $row[20];
$SHOW_TIMESTAMP   = $row[21];
$NOTIFY           = $row[22];
$WELCOME          = $row[23];



// Cleaning settings for messages and usernames
define("C_MSG_DEL", $MSG_DEL);
define("C_USR_DEL", $USR_DEL);
define("C_REG_DEL", $REG_DEL);

// Proposed rooms
$DefaultChatRooms = array('Default', 'MyRoom1', 'MyRoom2');
$DefaultPrivateRooms = array('Priv1', 'Priv2');

// Language settings
define("C_LANGUAGE", $LANGUAGE);
define("C_MULTI_LANG", $MULTI_LANG);

// Registration of users
define("C_REQUIRE_REGISTER", $REQUIRE_REGISTER);
define("C_EMAIL_PASWD", $EMAIL_PASWD);

// Security and restriction settings
define("C_SHOW_ADMIN", $SHOW_ADMIN);
define("C_SHOW_DEL_PROF", $SHOW_DEL_PROF);
define("C_VERSION", $VERSION);
define("C_BANISH", $BANISH);
define("C_NO_SWEAR", $NO_SWEAR);
define("C_SAVE", $SAVE);

// Messages enhancements
define("C_USE_SMILIES", $USE_SMILIES);
define("C_HTML_TAGS_KEEP", $HTML_TAGS_KEEP);
define("C_HTML_TAGS_SHOW", $HTML_TAGS_SHOW);

// Default display seetings
define("C_TMZ_OFFSET", $TMZ_OFFSET);
define("C_MSG_ORDER", $MSG_ORDER);
define("C_MSG_NB", $MSG_NB);
define("C_MSG_REFRESH", $MSG_REFRESH);
define("C_SHOW_TIMESTAMP", $SHOW_TIMESTAMP);
define("C_NOTIFY", $NOTIFY);
define("C_WELCOME", $WELCOME);
?>
