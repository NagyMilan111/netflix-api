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
      </form>
      
      <!-- <div class="remember-help">
        <label>
          <input type="checkbox"> Remember me
        </label>
        <a href="#">Need help?</a>
      </div> -->
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
    handleLogin() {
      console.log('Logging in with', this.email, this.password);
    }
  }
};
</script>

<style scoped>
@import "@/assets/loginPage.css";
</style>