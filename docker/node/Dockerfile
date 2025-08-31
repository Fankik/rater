FROM node:22.18.0

ARG USER_ID=1000
ARG USER_NAME=www-user
ARG GROUP_ID=1000
ARG GROUP_NAME=www-user

RUN groupmod -g ${GROUP_ID} node &&  \
    usermod -u ${USER_ID} -g ${GROUP_ID} node && \
    usermod -l ${USER_NAME} node && \
    groupmod -n ${GROUP_NAME} node

USER ${USER_NAME}

VOLUME ["/var/www/project"]

WORKDIR /var/www/project

CMD npm install && npm run dev

EXPOSE 3000
