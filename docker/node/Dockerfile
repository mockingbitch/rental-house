FROM node:14-alpine
WORKDIR /var/www/html
COPY package*.json ./
RUN npm install
CMD ["npm", "run", "dev"]