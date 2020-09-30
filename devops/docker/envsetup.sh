DOCKER_DIR=/tmp

# use faster package source
cp $DOCKER_DIR/sources.list.16.04 /etc/apt/sources.list
apt-get update

# convenient install by package name
apt-get install -y software-properties-common
add-apt-repository -y ppa:deadsnakes/ppa
apt-get update

apt-get install -y python3.7 git cron tzdata

cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime

# create work user
adduser --disabled-password --gecos "" work
chown work /tmp -R