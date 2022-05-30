!/bin/sh

apk update
apk add bash
apk add nodejs
apk add npm
npm version
npm ci --loglevel verbose
npx ng version
npx ng serve

tail -f /etc/passwd

