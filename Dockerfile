FROM php:7.2-apache
COPY web/ /var/www/html/

LABEL maintainer "Robert Mader <mada123456@gmail.com>"
EXPOSE 80

RUN apt-get update && \
# GENERIC
    apt-get install -y --no-install-recommends \
        wget\
        git\
        libc6-i386\
        python\
        sudo\
        zip && \
    apt-get clean && \
    rm -r /var/lib/apt/lists/*

ENV PATH="/var/www/Arduino:${PATH}"

#install Arduino
WORKDIR /var/www
RUN wget https://downloads.arduino.cc/arduino-1.8.8-linux32.tar.xz &&\
    tar -xf arduino-1.8.8-linux32.tar.xz &&\
    mv arduino-1.8.8 Arduino &&\
    ./Arduino/install.sh &&\
    rm arduino-1.8.8-linux32.tar.xz  &&\
#
    chown www-data: /var/www &&\
    su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --version" &&\
    chown --recursive www-data: /var/www/.arduino15 &&\
    chown --recursive www-data: /var/www/Arduino &&\
#libraries
    su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library PubSubClient" &&\
    su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library IRremoteESP8266" &&\
    su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library IRremote" &&\
    su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library ArduinoJson"

RUN mkdir /var/www/Arduino/hardware/esp8266com
WORKDIR /var/www/Arduino/hardware/esp8266com
RUN git clone https://github.com/esp8266/Arduino.git esp8266 &&\
    rm -r esp8266/.git
WORKDIR /var/www/Arduino/hardware/esp8266com/esp8266/tools
RUN python get.py &&\
#
    chown root: /var/www && \
    chown www-data: --recursive /var/www/html &&\
    chown www-data: --recursive /tmp

WORKDIR /var/www/html