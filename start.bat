cd integrador-fontes
START /B "" npm start &

cd ..
cd frontend
START /B "" npm start &

cd ..
cd produtor-series
START /B "" php -S localhost:8083 -t public/ &

cd ..
cd adaptador-h
START /B "" php -S localhost:8088 -t public/ &
START /B "" php artisan db:seed --class=GravarEventosHidrologicoSeeder &

cd ..
cd adaptador-p
START /B "" php -S localhost:8089 -t public/ &
START /B "" php artisan db:seed --class=GravarEventosPluviometricoSeeder &



pause
