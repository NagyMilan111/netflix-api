<template>
    <div class="login-container">
      <img src="/netflix_logo.png" alt="Netflix Logo" class="netflix-logo">
  
      <div class="login-box">
        <h2>Create Account</h2>
  
        <form @submit.prevent="handleRegister">
          <div>
            <input v-model="email" type="text" placeholder="Email or phone number" class="input-field" required>
          </div>
  
          <div>
            <input v-model="password" type="password" placeholder="Password" class="input-field" required>
          </div>
  
          <div>
            <input v-model="confirmPassword" type="password" placeholder="Confirm Password" class="input-field" required>
          </div>
  
          <button type="submit" class="login-button">Register</button>
        </form>
  
        <div class="remember-help">
          <p>Already have an account? <a href="/login">Sign In</a></p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "RegistrationPage",
    data() {
      return {
        email: '',
        password: '',
        confirmPassword: '',
      };
    },
    methods: {
      async handleRegister() {
        if (this.password !== this.confirmPassword) {
          console.log('Passwords do not match');
          return;
        }
  
        // Validate the email format
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailRegex.test(this.email)) {
          console.log('Invalid email format');
          return;
        }
  
        try {
          const response = await fetch('http://your-api-url.com/register', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              email: this.email,
              password: this.password,
              subscription_id: 1 // Adjust accordingly
            }),
            mode: 'no-cors', // This mode will be set to no-cors in your fetch request.
          });
  
          if (response.status === 201) {
            console.log('Registration successful');
            this.$router.push('/login');
          } else {
            const data = await response.json();
            console.log('Registration error:', data.error);
          }
        } catch (error) {
          console.log('Error:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  @import "@/assets/loginPage.css"; /* Link to the existing CSS file */
  </style>
  