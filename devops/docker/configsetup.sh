DOCKER_DIR=/tmp

# config ssh keys
mkdir -p /home/work/.ssh
cp $DOCKER_DIR/github_ssh_keys/id_rsa /home/work/.ssh/id_rsa
cp $DOCKER_DIR/github_ssh_keys/id_rsa.pub /home/work/.ssh/id_rsa.pub

chmod 0600 /home/work/.ssh/id_rsa
echo "
Host *
  StrictHostKeyChecking no
" > /home/work/.ssh/config

# prepare script for executing
mkdir -p /home/work/scripts
cd /home/work/scripts
git clone git@github.com:lyt123/everyday_demo.git

mkdir -p /home/work/logs/locks

cp $DOCKER_DIR/entrance.sh /home/work/entrance.sh
cp $DOCKER_DIR/crontabfile /home/work/crontabfile

rm -rf /tmp/*