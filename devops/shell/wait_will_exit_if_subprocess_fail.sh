#!/bin/bash
set -e

function is_goodfriend() {
  if [[ $1 == 'xiangzi' ]]; then
    echo "$1 is your goodfriend"
    exit 1
  else
    echo "$1 is not your goodfriend"
  fi
}

girls='mary xiangzi jerry'

count=1
pid_list=''
for girl in ${girls}; do
  is_goodfriend "${girl}" &
  pid_list="${pid_list} $!"
done

for pid in ${pid_list}; do
  wait "${pid}"
done

echo 'end' # this line won't be executed
