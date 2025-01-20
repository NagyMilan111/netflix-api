# Netflix

## Overview
This Netflix Project. It is containerized with Docker for easy deployment and development.

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

NOTE: RESTART NETFLIX-API DUE TO TOKEN ERROR

# MariaDB Backup and Restore Guide

## **Introduction**
This part of the document provides instructions on how to install and use the MariaDB command-line tool for database backup and recovery.

---

## **Installation**
### **Windows**
#### **1. Install MariaDB**
- Download the **MariaDB installer** from the official site:  
  [➡ Download MariaDB](https://mariadb.org/download/)
- Run the installer and select **"MariaDB Server"** (this includes all command-line tools).
- Ensure MariaDB is added to the `PATH` environment variable during installation.

#### **2. Verify The Installation**
Open Command Prompt (`cmd`) and run:
```sh
mysql --version
```

#### **3. Default Command-Line Tools Location (Windows)**
- `C:\Program Files\MariaDB 10.x\bin`
- `C:\Program Files (x86)\MariaDB 10.x\bin`

#### **4. Add to PATH (Optional)**
To use the tools globally:
- Open **System Properties** → **Environment Variables**.
- Edit **Path** under "System Variables" and add:
  ```
  C:\Program Files\MariaDB 10.x\bin
  ```
- Restart the terminal.

---

### **Linux (Debian/Ubuntu)**
#### **1. Install MariaDB**
```sh
sudo apt update
sudo apt install mariadb-server mariadb-client
```

#### **2. Verify Installation**
```sh
mariadb --version
```

#### **3. Default Command-Line Tools Location (Linux)**
- `/usr/bin/mariadb`
- `/usr/bin/mysql`
- `/usr/bin/mysqldump`
- `/usr/bin/mariadb-dump`
- `/usr/bin/mariadb-backup`

#### **4. Start MariaDB**
```sh
sudo systemctl start mariadb
```

---

### **macOS**
#### **1. Install Using Homebrew**
```sh
brew install mariadb
```

#### **2. Verify Installation**
```sh
mariadb --version
```

#### **3. Start MariaDB Service**
```sh
brew services start mariadb
```

#### **4. Default Command-Line Tools Location (macOS)**
- `/usr/local/bin/mariadb`
- `/usr/local/bin/mysql`
- `/usr/local/bin/mysqldump`
- `/usr/local/bin/mariadb-dump`
- `/usr/local/bin/mariadb-backup`

---

### **Docker (Cross-Platform Alternative)**
#### **1. Install and Run MariaDB in Docker**
```sh
docker pull mariadb
docker run --name mariadb-container -e MYSQL_ROOT_PASSWORD=1234 -d mariadb
```

#### **2. Connect to MariaDB in Docker**
```sh
docker exec -it mariadb-container mariadb -u root -p
```

---

## **Backup and Restore Guide**
### **Creating a Backup**
To back up a database (e.g., `Netflix`) and save it as a `.sql` file:
```sh
mysqldump -h localhost -P 3306 -u root -p --single-transaction --routines --events Netflix > backups/2024-01-01.sql
```

#### **Backup Options Explained:**
- `-h localhost` → Specifies the database host.
- `-P 3306` → Specifies the port (default: 3306).
- `-u root -p` → Logs in as root and prompts for a password.
- `--single-transaction` → Ensures a consistent snapshot (for InnoDB).
- `--routines` → Includes stored procedures and functions.
- `--events` → Includes database events.
- `> backups/2024-01-01.sql` → Saves the backup in the `backups` directory.

---

### **Restoring from Backup**
#### **1. Drop and Recreate Database (Optional)**
If restoring over an existing database, drop and recreate it first:
```sh
mysql -h localhost -P 3306 -u root -p -e "DROP DATABASE IF EXISTS Netflix; CREATE DATABASE Netflix;"
```

#### **2. Restore Backup**
To restore the database from a `.sql` file:
```sh
mysql -h localhost -P 3306 -u root -p Netflix < backups/2024-01-01.sql
```

---

## **Backup Policy**
The group recommends:
- **Biweekly backups** to prevent data loss.
- Keeping **two months** of historical backups.
- Automating backups using a **cron job (Linux/macOS)** or **Task Scheduler (Windows)**.

