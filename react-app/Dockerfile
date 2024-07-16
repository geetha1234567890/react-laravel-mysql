# Base image
FROM node:18

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package.json yarn.lock ./

# Install dependencies
#RUN npm install
RUN yarn install

# Copy all files
COPY . .

# Build React app
#RUN npm run build
RUN yarn build

# Stage 2 - the production environment
FROM nginx:alpine

# Copy the React build from stage 1
COPY --from=0 /app/build /usr/share/nginx/html

# Copy custom nginx configuration
COPY nginx/nginx.conf /etc/nginx/nginx.conf

# Expose port 80
EXPOSE 80

# Command to run nginx
CMD ["nginx", "-g", "daemon off;"]

