<template>
  <div class="dashboard-container">
    <img src="/netflix_logo.png" alt="Netflix Logo" class="netflix-logo">
    <div class="image-container">
      <router-link to="/data">
        <img src="/data.png" alt="Data" class="dashboard-image">
      </router-link>
      <router-link to="/users">
        <img src="/users.png" alt="Users" class="dashboard-image">
      </router-link>
    </div>
  </div>
</template>

<script>
import "@/assets/dashboardPage.css";

export default {
  name: "DashboardPage"
};
</script>
