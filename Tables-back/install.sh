docker exec -it tables_django pip install requests
docker exec -it tables_django pip install pillow
docker exec -it tables_django pip install django-cors-headers
docker restart tables_django