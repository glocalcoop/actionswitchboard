<?php
$bt = '<a class="foot-source" target="_blank" href="http://beautifultrouble.org">Beautiful Trouble</a>';
$act = '<a class="foot-source" target="_blank" href="http://actipedia.org">Actipedia</a>';

$output = str_replace("Beautiful Trouble", $bt, $output);
$output = str_replace("Actipedia", $act, $output);

print $output;
