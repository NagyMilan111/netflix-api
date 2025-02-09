<template>
  <div class="login-container">
    <img src="/netflix_logo.png" alt="Netflix Logo" class="netflix-logo">

    <div class="login-box">
      <h2>Sign In</h2>
      
      <form @submit.prevent="handleLogin">
        <div>
          <input v-model="email" type="text" placeholder="Email or phone number" class="input-field">
        </div>

        <div>
          <input v-model="password" type="password" placeholder="Password" class="input-field">
        </div>

        <button type="submit" class="login-button">Sign In</button>

        <div class="remember-help">
          <p>Don't have an account? <a href="/register">Register</a></p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginPage",
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await fetch('https://your-api-domain.com/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            // Add additional headers if needed (like authorization token)
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password
          }),
          mode: 'no-cors', // Ensure no CORS policy block
        });

        if (!response.ok) {
          // Handle response error (Non-200 responses)
          const errorData = await response.json();
          console.log('Login failed:', errorData.error);
          alert('Login failed: ' + errorData.error);
          return;
        }

        // Handle successful login
        const data = await response.json();
        console.log('Login successful:', data);

        // Store the token if necessary and navigate
        localStorage.setItem('userToken', data.token);
        this.$router.push('/dashboard'); // Redirect to dashboard after login
      } catch (error) {
        console.error('Error during login:', error);
        alert('An error occurred during login. Please try again.');
      }
    }
  }
};
</script>

<style scoped>
@import "@/assets/loginPage.css"; /* Link to the existing CSS file */
</style>
