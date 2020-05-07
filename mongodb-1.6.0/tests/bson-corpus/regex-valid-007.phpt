--TEST--
Regular Expression type: Required escapes
--DESCRIPTION--
Generated by scripts/convert-bson-corpus-tests.php

DO NOT EDIT THIS FILE
--FILE--
<?php

require_once __DIR__ . '/../utils/tools.php';

$canonicalBson = hex2bin('100000000B610061625C226162000000');
$canonicalExtJson = '{"a" : {"$regularExpression" : { "pattern": "ab\\\\\\"ab", "options" : ""}}}';

// Canonical BSON -> Native -> Canonical BSON 
echo bin2hex(fromPHP(toPHP($canonicalBson))), "\n";

// Canonical BSON -> Canonical extJSON 
echo json_canonicalize(toCanonicalExtendedJSON($canonicalBson)), "\n";

// Canonical extJSON -> Canonical BSON 
echo bin2hex(fromJSON($canonicalExtJson)), "\n";

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
100000000b610061625c226162000000
{"a":{"$regularExpression":{"pattern":"ab\\\"ab","options":""}}}
100000000b610061625c226162000000
===DONE===