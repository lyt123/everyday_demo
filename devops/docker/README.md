## How to run
1. copy your local .ssh/id_rsa and .ssh/id_rsa.pub to github_ssh_keys directory, in order to download script code to the docker image.
2. bash build.sh;
3. docker run -d --name my_dev_docker1 lyt123/upload/google:1.0


## See the result
docker exec -t -i my_dev_docker1 /bin/bash; cat /home/work/logs/upload_google.log


## How this tool work
In the Dockerfile, defines to use ubuntu16, and run envsetup.sh and configsetup.sh.
"RUN envsetup.sh" will install some system related software and environment.
"RUN configsetup.sh" will prepare some configs for running our job.
In this tool, I create "work user" to do our job.
And Pay attention to the entrance.sh, this script is executed using root user, as cron start should have root privilege.

