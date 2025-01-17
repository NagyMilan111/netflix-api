#!/bin/sh

set -e

# Install Node.js dependencies
npm install

# Build the Vue.js app
npm run build

# Start the Vue.js development server
exec npm run serve