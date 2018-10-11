#!/bin/bash

clear;
php test.php;
if [ "${?}" != "0" ];
then
	exit 1;
fi

exit 0;
