<?php

#
# Just counting
#
for ($i=0;$i<10;$i++) {
	echo "Counter:".$i.PHP_EOL;
}

#
# Add command to do housekeeping 
#
$cmd = "ls -al";
$result=shell_exec($cmd);

# do work on results of command ... which failed
if ($result == null) {
	echo "$cmd NOK";
}
# do work on results of command ... which are ok
if ($result != null) {
	echo "$cmd ok";
}

?>