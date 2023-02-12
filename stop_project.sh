#!/bin/bash

# Stop CTFd
docker compose -f ./CTFd/docker-compose.yml down

# Stop SQLi challenges
docker compose -f ./challenges/SQLi/docker-compose.yml down

# Stop CMDi challenges
docker compose -f ./challenges/CMDi/docker-compose.yml down

# Stop File Upload challenges
docker compose -f ./challenges/File\ Upload\ Vul/docker-compose.yml down

# Stop Broken Authentication
docker compose -f ./challenges/Broken\ Authentication/docker-compose.yml down

# Stop XSS challenges
docker compose -f ./challenges/XSS/docker-compose.yml down

# Stop Broken Access Control (IDOR) challenges
docker compose -f ./challenges/IDOR/level1/docker-compose.yml down
docker compose -f ./challenges/IDOR/level2/docker-compose.yml down
docker compose -f ./challenges/IDOR/level3/docker-compose.yml down

# Stop Path Traversal challenges
docker compose -f ./challenges/Path\ Traversal/docker-compose.yml down

# Stop Information Disclosure challenges
docker compose -f ./challenges/Information\ Disclosure/docker-compose.yml down

# Stop Server - Side Request Forgery (SSRF) Challenges
docker compose -f ./challenges/SSRF/ssrf-chall/docker-compose.yaml down