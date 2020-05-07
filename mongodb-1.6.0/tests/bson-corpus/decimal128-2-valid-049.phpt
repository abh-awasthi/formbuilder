--TEST--
Decimal128: [decq604] fold-down full sequence
--DESCRIPTION--
Generated by scripts/convert-bson-corpus-tests.php

DO NOT EDIT THIS FILE
--FILE--
<?php

require_once __DIR__ . '/../utils/tools.php';

$canonicalBson = hex2bin('180000001364000000000081EFAC855B416D2DEE04FE5F00');
$canonicalExtJson = '{"d" : {"$numberDecimal" : "1.00000000000000000000000000000000E+6143"}}';

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
180000001364000000000081efac855b416d2dee04fe5f00
{"d":{"$numberDecimal":"1.00000000000000000000000000000000E+6143"}}
180000001364000000000081efac855b416d2dee04fe5f00
===DONE===