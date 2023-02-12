# This script is used for Linux OS
#!/bin/bash

# Build CTFd and Web Theory
docker compose -f ./CTFd/docker-compose.yml down
docker compose -f ./CTFd/docker-compose.yml up -d

# Build SQLi challenges
docker compose -f ./challenges/SQLi/docker-compose.yml down
docker compose -f ./challenges/SQLi/docker-compose.yml up -d

# Build CMDi challenges
docker compose -f ./challenges/CMDi/docker-compose.yml down
docker compose -f ./challenges/CMDi/docker-compose.yml up -d

# Build File Upload challenges
docker compose -f ./challenges/File\ Upload\ Vul/docker-compose.yml down
docker compose -f ./challenges/File\ Upload\ Vul/docker-compose.yml up -d

# Build Broken Authentication
docker compose -f ./challenges/Broken\ Authentication/docker-compose.yml down
docker compose -f ./challenges/Broken\ Authentication/docker-compose.yml up -d

# Build XSS challenges
docker compose -f ./challenges/XSS/docker-compose.yml down
docker compose -f ./challenges/XSS/docker-compose.yml up -d

# Build Broken Access Control (IDOR) challenges
docker compose -f ./challenges/IDOR/level1/docker-compose.yml down --rmi all
docker compose -f ./challenges/IDOR/level2/docker-compose.yml down --rmi all
docker compose -f ./challenges/IDOR/level3/docker-compose.yml down --rmi all
cd ./challenges/IDOR/level1/ # IDOR level 1
docker-compose up -d
cd ../../../
cd ./challenges/IDOR/level2/ # IDOR level 2
docker-compose up -d
cd ../../../
cd ./challenges/IDOR/level3/ # IDOR level 3
docker-compose up -d
cd ../../../

# Build Path Traversal challenges
docker compose -f ./challenges/Path\ Traversal/docker-compose.yml down
docker compose -f ./challenges/Path\ Traversal/docker-compose.yml up -d

# Build Information Disclosure challenges
docker compose -f ./challenges/Information\ Disclosure/docker-compose.yml down
docker compose -f ./challenges/Information\ Disclosure/docker-compose.yml up -d

# Build Server - Side Request Forgery (SSRF) Challenges
docker compose -f ./challenges/SSRF/ssrf-chall/docker-compose.yaml down
docker compose -f ./challenges/SSRF/ssrf-chall/docker-compose.yaml up -d