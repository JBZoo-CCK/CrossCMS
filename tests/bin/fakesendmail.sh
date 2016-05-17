#!/usr/bin/env bash
#Fake sendmail script:

#Create a temp folder to put messages in
numPath="${TMPDIR-/tmp/}fakemail"
umask 037
mkdir -p $numPath

if [ ! -f $numPath/num ]; then
  echo "0" > $numPath/num
fi
num=`cat $numPath/num`
num=$(($num + 1))
echo $num > $numPath/num

name="$numPath/message_$num.eml"
while read line
do
  echo $line >> $name
done
exit 0
