<template>
  
  <div class="data-container">
      <router-link to="/dashboard" class="logo-container">
        <img src="/netflix_logo.png" alt="Netflix Logo" class="netflix-logo">
      </router-link>
    <div v-if="isLoading">Loading...</div>
    <div v-else>
        <div class="data-grid">
          <div class="data-column" v-for="(column, index) in dataColumns" :key="index">
            <h2>{{ column.title }}</h2>
            <ul>
              <li v-for="(item, itemIndex) in column.values" :key="itemIndex" class="data-item">
                {{ item }}
              </li>
            </ul>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "DataPage",
  data() {
    return {
      dataColumns: [], // Initialize as empty array
      isLoading: true
    };
  },
  async created() {
    // Fetch data from backend when the component is created
    await this.fetchData();
  },
  methods: {
        async fetchData() {
          this.isLoading = true;
      try {
        const responseConfig = {
          headers: {
          'Access-Control-Allow-Origin': '*',  // Allow requests from any origin
          'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE',  // Allow all methods
          'Access-Control-Allow-Headers': 'Content-Type, Authorization',  // Allow specific headers
        },
          mode: 'no-cors', // This sets the request mode to no-cors
        };
      
        const [
          revenueResponse,
          discountedUsersResponse,
          topWatchedMoviesResponse,
          topWatchedSeriesResponse,
          topWatchedMediaResponse,
          topWatchedGenresResponse,
          longestSeriesResponse,
          shortestSeriesResponse,
          longestMoviesResponse,
          shortestMoviesResponse,
          leastPopularGenresResponse,
          leastWatchedSeriesResponse,
          leastWatchedMoviesResponse,
          leastWatchedMediaResponse
        ] = await Promise.all([
          axios.get('http://localhost:8000/api/analytics/revenue', responseConfig),
          axios.get('http://localhost:8000/api/analytics/discounted-users', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/watched/movies', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/watched/series', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/watched/medias', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/watched/genres', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/longest/series', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/shortest/series', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/longest/movies', responseConfig),
          axios.get('http://localhost:8000/api/analytics/top-ten/shortest/movies', responseConfig),
          axios.get('http://localhost:8000/api/analytics/bottom-ten/genres', responseConfig),
          axios.get('http://localhost:8000/api/analytics/bottom-ten/series', responseConfig),
          axios.get('http://localhost:8000/api/analytics/bottom-ten/movies', responseConfig),
          axios.get('http://localhost:8000/api/analytics/bottom-ten/medias', responseConfig)
        ]);
      
        // Map the responses to the dataColumns structure
        this.dataColumns = [
          { title: "Revenue", values: revenueResponse.data.values },
          { title: "Amount of Discounted Users", values: discountedUsersResponse.data.values },
          { title: "Most Watched Movies", values: topWatchedMoviesResponse.data.values },
          { title: "Most Watched Series", values: topWatchedSeriesResponse.data.values },
          { title: "Most Watched Media", values: topWatchedMediaResponse.data.values },
          { title: "Most Watched Genres", values: topWatchedGenresResponse.data.values },
          { title: "Longest Series", values: longestSeriesResponse.data.values },
          { title: "Shortest Series", values: shortestSeriesResponse.data.values },
          { title: "Longest Movie", values: longestMoviesResponse.data.values },
          { title: "Shortest Movie", values: shortestMoviesResponse.data.values },
          { title: "Least Popular Genres", values: leastPopularGenresResponse.data.values },
          { title: "Least Watched Series", values: leastWatchedSeriesResponse.data.values },
          { title: "Least Watched Movies", values: leastWatchedMoviesResponse.data.values },
          { title: "Least Watched Media", values: leastWatchedMediaResponse.data.values }
        ];
      } catch (error) {
        console.error("Error fetching data:", error);
      }finally{this.isLoading = false;}
    }
  }
};
</script>

<style scoped>
@import "@/assets/dataPage.css";
</style>