docker-compose -f .\CTFd\docker-compose.yml down

docker-compose -f .\challenges\SQLi\docker-compose.yml down

docker compose -f .\challenges\CMDi\docker-compose.yml down

cd ./challenges/File Upload Vul/
docker-compose down
cd ../../

cd ./challenges/Broken Authentication/
docker-compose down
cd ../../ 

docker compose -f .\challenges\XSS\docker-compose.yml down

docker compose -f .\challenges\IDOR\level1\docker-compose.yml down
docker compose -f .\challenges\IDOR\level2\docker-compose.yml down
docker compose -f .\challenges\IDOR\level3\docker-compose.yml down

cd ./challenges/Path Traversal/
docker-compose down
cd ../../

cd ./challenges/Information Disclosure/
docker-compose down
cd ../../

docker compose -f .\challenges\SSRF\ssrf-chall\docker-compose.yaml down