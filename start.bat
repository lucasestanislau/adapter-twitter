cd integrador-fontes
START /B "" npm start &

cd ..
cd frontend
START /B "" npm start &

cd ..
cd produtor-series
START /B "" php -S localhost:8083 -t public/ &





pause
