docker build -t sibt_db ./sibtask_database
docker build -t sibt_site ./sibtask_serv
docker run --name sibt_db -p 5432:5432 -d --rm sibt_db
docker run --name sibt_site --link sibt_db:sibt_db -p 80:80 -d --rm sibt_site
