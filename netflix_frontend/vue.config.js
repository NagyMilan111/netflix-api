const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/api': {
        target: 'http://localhost:8000',  // The backend URL
        changeOrigin: true,  // Changes the origin of the host header to the target URL
        secure: false,  // Allow insecure SSL connections
        logLevel: 'debug',  // Optional: Log proxy requests (useful for debugging)
        headers: {
          'Access-Control-Allow-Origin': '*',  // Allow requests from any origin
          'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE',  // Allow all methods
          'Access-Control-Allow-Headers': 'Content-Type, Authorization',  // Allow specific headers
        },
      },
    },
  },
})
