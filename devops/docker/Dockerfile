FROM ubuntu:16.04

COPY . /tmp

RUN bash -ex /tmp/envsetup.sh

USER work
RUN bash -ex /tmp/configsetup.sh

USER root
ENTRYPOINT ["/bin/bash", "/home/work/entrance.sh"]