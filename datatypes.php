<?php
namespace VDM\Lib\DataTypes;

//Datatypes
define('VDM_DT_TRAITS',VDM_LIB_DATATYPES . 'trait.');

define('DATATYPEDEF_TRAIT', VDM_DT_TRAITS . 'datatype-def.php');
define('DATATYPECHKVARS_TRAIT', VDM_DT_TRAITS . 'datatype-chkvars.php');
define('DATATYPECHKVALS_TRAIT', VDM_DT_TRAITS . 'datatype-chkvals.php');
define('DATACHECKS_TRAIT', VDM_DT_TRAITS . 'datachecks.php');
define('DATAPATHS_TRAIT', VDM_DT_TRAITS . 'datatype-path.php');
define('DATATYPEURL_TRAIT', VDM_DT_TRAITS . 'datatype-url.php');
define('DATATYPEARRPATH_TRAIT', VDM_DT_TRAITS . 'array-path.php');

//the phptypes that the datatypes will be derived from
define("VDM_PHPTYPES", "string,int");

define('ALLOWED_DATATYPES',"string,varchar,text,int,medint,smint,tinint,bool,dir,file,path,url,json");
define('MAXLEN_VAR',60);						//max length a var name/array key can be

/**
 * Allowed string chars
 */
define('VDM_ASTRALL','-|_');
define('VDM_ASTR','( |,|\.|\n)');
define('VDM_APATH','\/');
define('VDM_ADIR','\/');
define('VDM_AFILE','\.');
define('VDM_AURL','\/|\?|&|=|:');
define('VDM_AJSON','\{|\}|\[|\]|:|\"|\'|\@|#|\t');
/**
 * Disallowed string chars
 */
define('VDM_DIR_DISALLOWED_PATTERNS','\.\.');
define('VDM_DISALLOWED_PATTERNS','\.\.\/');

//size limits for paths
define("PATH_SIZE",200);

//string data types
define('STRING_SIZE',255);
define('VARCHAR_SIZE',75);
define('TEXT_SIZE',2000);

//int data types
define('INT_SIZE',2147483647);
define('MEDINT_SIZE',8388607);
define('SMINT_SIZE',32767);
define('TININT_SIZE',127);

//bool datatypes
DEFINE('BOOL_TRUE','True,TRUE,true,1');
DEFINE('BOOL_FALSE','False,FALSE,false,0');

//url data types
define('URL_SIZE',300);


require_once(DATACHECKS_TRAIT);
require_once(DATATYPEDEF_TRAIT);
require_once(DATATYPECHKVARS_TRAIT);
require_once(DATATYPECHKVALS_TRAIT);
require_once(DATAPATHS_TRAIT);
require_once(DATATYPEURL_TRAIT);
require_once(DATATYPEARRPATH_TRAIT);
require_once(VDM_LIB_DATATYPES . 'class.abstarray-access.php');
require_once(VDM_LIB_DATATYPES . 'class.datatypes.php');
?>