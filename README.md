# Project Name

## Overview
This project is a [brief description of the project]. It is containerized with Docker for easy deployment and development.

## Prerequisites
Before starting, make sure you have the following installed on your system:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

To verify, run:
```bash
docker --version
docker compose version
```

## Setup Instructions

### Clone the Repository
```bash
git clone https://github.com/NagyMilan111/netflix-api.git
cd netflix-api
```
### Clone the Repository(development branch)
```bash
git clone -b development https://github.com/NagyMilan111/netflix-api.git
cd netflix-api
```

### Using Docker Compose 
If a `docker-compose.yml` file is provided:
1. **Start the services**:
   ```bash
   docker compose up -d
   ```
  This process can take a minute so please be patient until everything is booted up.

2. **View running services**:
   ```bash
   docker compose ps
   ```
  Or check docker desktop.

3. **Stop the services**:
   ```bash
   docker compose down
   ```

### Access the Application
- Open your browser and go to: `http://localhost:8000`

## Development Notes
- To view logs:
  ```bash
  docker logs <container-name>
  ```

- To access the container’s shell:
  ```bash
  docker exec -it <container-name> /bin/bash
  ```

- To rebuild the container after changes:
  ```bash
  docker compose down
  docker compose up --build -d
  ```
- To delete all volumes and build again:  
  ```bash
  docker compose down --volumes
  docker compose up --build -d
  ```

## Cleaning Up
- To stop and remove the container:
  ```bash
  docker stop <container-name>
  docker rm <container-name>
  ```

- To remove the image:
  ```bash
  docker rmi <image-name>
  ```
