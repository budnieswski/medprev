#!/bin/bash

echo -e "#\n# Sourcemap is DISABLED\n#\n"
echo -e "Style Output:"
echo -e "(1) Nested"
echo -e "(2) Expanded"
echo -e "(3) Compacts"
echo -e "(4) Compressed\n"
echo -e -n "Choise > "
read choise

style="--style compressed"
message=""
if [ ! $choise ]
then
   message="By default, lets use COMPRESSED"
elif [ $choise -eq 1 ]
then
   message="You choose NESTED"
   style="--style nested"
elif [ $choise -eq 2 ]
then
   message="You choose EXPANDED"
   style="--style expanded"
elif [ $choise -eq 3 ]
then
   message="You choose COMPACTS"
   style="--style compact"
else
   message="By default, lets use COMPRESSED"
fi

clear
echo -e "${message}\n"
#sass --watch --sourcemap=none main.sass:main.css ${style}
sass --watch --sourcemap=none assets/css/main.sass:assets/css/main.css ${style}