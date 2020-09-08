set -e
if wget xxx; then # this line won't cause error
    echo 'hdhe'
fi
echo $?
wget xxxx
echo $?  # this line won't be executed

