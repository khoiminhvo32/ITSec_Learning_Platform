docker compose -f ./CTFd/docker-compose.yml down
docker compose -f ./CTFd/docker-compose.yml up -d

docker compose -f ./challenges/SQLi/docker-compose.yml down
docker compose -f ./challenges/SQLi/docker-compose.yml up -d

docker compose -f ./challenges/CMDi/docker-compose.yml down
docker compose -f ./challenges/CMDi/docker-compose.yml up -d

cd ./challenges/File Upload Vul/
docker-compose down
docker-compose up -d
cd ../../

cd ./challenges/Broken Authentication/
docker-compose down
docker-compose up -d 
cd ../../ 

docker compose -f ./challenges/XSS/docker-compose.yml down
docker compose -f ./challenges/XSS/docker-compose.yml up -d

docker compose -f ./challenges/IDOR/level1/docker-compose.yml down --rmi all
docker compose -f ./challenges/IDOR/level2/docker-compose.yml down --rmi all
docker compose -f ./challenges/IDOR/level3/docker-compose.yml down --rmi all
cd ./challenges/IDOR/level1/
docker-compose up -d --remove-orphans
cd ../../../
cd ./challenges/IDOR/level2/
docker-compose up -d --remove-orphans
cd ../../../
cd ./challenges/IDOR/level3/
docker-compose up -d --remove-orphans
cd ../../../

cd ./challenges/Path Traversal/
docker-compose down
docker-compose up -d
cd ../../

cd ./challenges/Information Disclosure/
docker-compose down
docker-compose up -d
cd ../../

docker compose -f ./challenges/SSRF/ssrf-chall/docker-compose.yaml down
docker compose -f ./challenges/SSRF/ssrf-chall/docker-compose.yaml up -d --remove-orphans