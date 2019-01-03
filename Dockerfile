FROM php:7.2-apache
COPY web/ /var/www/html/

LABEL maintainer "Robert Mader <mada123456@gmail.com>"
EXPOSE 80

RUN apt-get update
RUN apt-get upgrade -y
# GENERIC
RUN apt-get install -y build-essential
    # Generic
RUN apt-get install -y build-essential
RUN apt-get install -y curl
RUN apt-get install -y wget
RUN apt-get install -y git
RUN apt-get install -y libc6-i386
    # Python
RUN apt-get install -y python
RUN apt-get install -y python-pip
RUN apt-get install -y picocom
RUN apt-get install -y sudo
RUN apt-get install -y zip

RUN apt-get clean 

WORKDIR /var/www
RUN wget https://downloads.arduino.cc/arduino-1.8.8-linux32.tar.xz
RUN tar -xf arduino-1.8.8-linux32.tar.xz
RUN mv arduino-1.8.8 Arduino
RUN ./Arduino/install.sh
RUN rm arduino-1.8.8-linux32.tar.xz 

ENV PATH="/var/www/Arduino:${PATH}"

RUN chown www-data: /var/www
RUN su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --version"
RUN chown --recursive www-data: /var/www/.arduino15
RUN chown --recursive www-data: /var/www/Arduino
#libraries
RUN su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library PubSubClient"
RUN su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library IRremoteESP8266"
RUN su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library IRremote"
RUN su - www-data -s /bin/sh -c "/var/www/Arduino/arduino --install-library ArduinoJson"


WORKDIR /var/www
RUN mkdir Arduino/hardware/esp8266com
WORKDIR /var/www/Arduino/hardware/esp8266com
RUN git clone https://github.com/esp8266/Arduino.git esp8266
WORKDIR /var/www/Arduino/hardware/esp8266com/esp8266/tools
RUN python get.py

RUN chown root: /var/www

RUN chown www-data: --recursive /var/www/html
RUN chown www-data: /tmp

WORKDIR /var/www/html