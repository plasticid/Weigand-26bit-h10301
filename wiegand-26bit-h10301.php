<?php
/*
Copyright (c) 2017, Plastic-ID.com
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this
  list of conditions and the following disclaimer.

* Redistributions in binary form must reproduce the above copyright notice,
  this list of conditions and the following disclaimer in the documentation
  and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/


//26-Bit Wiegand Format
//H10301 Open Format
//255 possible site codes
//65536 possible card number
//PSSSSSSSSCCCCCCCCCCCCCCCCP
//P = parity
//S = site code
//C = card number

$sitecode = 1;
$cardnumber = 1000;
$gen = 200;


echo "cardnumber,encoding,encodingwithpadding,csn\n";

for($i = $cardnumber; $i < $cardnumber + $gen; $i++){
    $bits = sprintf("%08b",$sitecode).sprintf("%016b",$i);
    $bitsstart = substr((string)$bits, 0, 12);
    $bitsend = substr((string)$bits, 12, 12);

    //even parity check
    if((substr_count($bitsstart, '1', 0, 12) % 2) == 1){
        //odd
        $startparity = 1;
    }
    else {
        //even
        $startparity = 0;
    }

    //odd parity check
    if((substr_count($bitsend, '1', 0, 12) % 2) == 1){
        //odd
        $endparity = 0;
    }
    else {
        //even
        $endparity = 1;
    }

    $bits = $startparity.sprintf("%08b",$sitecode).sprintf("%016b",$i).$endparity;
    echo $i.",".dechex(bindec($bits)).",".dechex(bindec($bits))."0".",\n";
}
die();
echo "Card number: ".$cardnumber."\n";
echo "Card number bits: ".sprintf("%016b",$cardnumber)."\n";
echo "Card number len: ".strlen(sprintf("%016b",$cardnumber))."\n";
echo "Sitecode: ".$sitecode."\n";
echo "Sitecode Bits: ".sprintf("%08b", $sitecode)."\n";
echo "Sitecode len: ".strlen(sprintf("%08b", $sitecode))."\n";
echo "Bits start: ".$bitsstart."\n";
echo "Bits end: ".$bitsend."\n";
echo "Bits start len:".strlen($bitsstart)."\n";
echo "Bits end len:".strlen($bitsend)."\n";
echo "Start parity: ".$startparity."\n";
echo "End parity: ".$endparity."\n";
echo "Bits: ".$bits."\n";
echo "Bitlen = ".strlen($bits)."\n";
echo "sitecode + cardnumber decimal: ".bindec(sprintf("%08b",$sitecode).sprintf("%016b",$cardnumber))."\n";
echo "26 bit number hex: ".dechex(bindec($bits))."\n";
//$bits32 = $bits."000000";
//echo "32 bit number hex: ".dechex(bindec($bits32))."\n";
echo "\n";
?>
