<template>
  <div class="users-container">
    <router-link to="/dashboard" class="logo-container">
      <img src="/netflix_logo.png" alt="Netflix Logo" class="netflix-logo">
    </router-link>
    <div class="users-list">
      <h2>Users</h2>
    <div v-if="isLoading">Loading...</div>
      <div v-else>
        <ul>
          <li v-for="user in users" :key="user.id" class="user-item">{{ user.email }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "UsersPage",
  data() {
    return {
      users: [] // Initialize as empty array
      isLoading: true
    };
  },
  async created() {
    // Fetch user data when the component is created
    await this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      this.isLoading = true;
      try {
        // Fetch user data from your backend API
        const response = await axios.get('http://localhost:8000/api/users');
        this.users = response.data; // Assign fetched data to the users array
      } catch (error) {
        console.error("Error fetching users:", error);
      }finally{this.isLoading = false;}
    }
  }
};
</script>

<style scoped>
@import "@/assets/usersPage.css";
</style>