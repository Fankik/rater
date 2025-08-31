FROM nginx:1.22

ARG USER_ID=1000
ARG USER_NAME=www-user
ARG GROUP_ID=1000
ARG GROUP_NAME=www-user

RUN apt-get update && \
    apt-get install -y \
    nano \
    procps

RUN mkdir -p /var/log/nginx/ && \
    touch /var/log/nginx/error.log && \
    touch /var/log/nginx/access.log

RUN touch /var/run/nginx.pid

COPY nginx.conf /etc/nginx

RUN sed -i 's/user www-user/user '${USER_NAME}'/g' /etc/nginx/nginx.conf

RUN addgroup --gid ${GROUP_ID} --system ${GROUP_NAME} && \
    adduser --uid ${USER_ID} --system ${USER_NAME} --gid ${GROUP_ID}

RUN chown -R ${USER_NAME}:${GROUP_NAME} /var/log/nginx && \
    chown -R ${USER_NAME}:${GROUP_NAME} /var/run/nginx.pid /var/cache/nginx

VOLUME ["/var/www", "/etc/nginx/conf.d", "/var/log/nginx"]

USER ${USER_NAME}

WORKDIR /var/www

CMD ["/usr/sbin/nginx"]

EXPOSE 80
