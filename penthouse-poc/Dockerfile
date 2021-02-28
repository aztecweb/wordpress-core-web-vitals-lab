FROM node:lts

RUN set -ex; \
    wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add -; \
    sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list'; \
    apt-get update && apt-get install -y \
        google-chrome-stable \
    ; \
    \
    rm -rf /var/lib/apt/lists/*

RUN yarn global add nodemon
RUN yarn add penthouse puppeteer

WORKDIR /penthouse-poc
