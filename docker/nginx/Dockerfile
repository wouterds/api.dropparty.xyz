FROM nginx:alpine
LABEL maintainer="Wouter De Schuyter <wouter.de.schuyter@gmail.com>"

# Copy required files
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./public /code/public

# Change working directory
WORKDIR /code
