FROM node:22

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install
RUN npm install axios

# Copy the rest of the application code
COPY . .

# Expose port 8080 for Vue.js development server
EXPOSE 8080

# Start Vue.js development server
CMD ["npm", "run", "serve"]